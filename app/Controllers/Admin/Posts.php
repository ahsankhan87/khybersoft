<?php

namespace App\Controllers\Admin;

use App\Concerns\HasAdminCrud;
use App\Models\CategoryModel;
use App\Models\PostModel;
use App\Models\TagModel;

class Posts extends BaseAdmin
{
    use HasAdminCrud;

    protected string $module     = 'blog';
    protected string $modelClass = PostModel::class;
    protected array  $fields     = ['title', 'slug', 'category_id', 'excerpt', 'content', 'featured_image', 'read_minutes', 'status', 'published_at', 'meta_title', 'meta_desc'];
    protected array  $booleans   = ['is_featured'];
    protected array  $rules      = ['title' => 'required|max_length[255]', 'slug' => 'required|alpha_dash|max_length[255]|is_unique[posts.slug,id,{id}]'];
    protected string $slugSource = 'title';

    public function index()
    {
        $model = new PostModel();

        return $this->render('admin/posts/index', [
            'title'      => 'Blog Posts',
            'posts'      => $model->paginateList(
                (string) ($this->request->getGet('status') ?: '') ?: null,
                (int) $this->request->getGet('category') ?: null,
                (string) $this->request->getGet('q'),
            ),
            'pager'      => $model->paginateList() ? null : null, // pager rendered via simple links below
            'categories' => (new CategoryModel())->orderBy('sort_order')->findAll(),
            'total'      => $model->countAllResults(false),
        ]);
    }

    public function create()
    {
        return $this->form(null);
    }

    public function edit(int $id)
    {
        return $this->form($id);
    }

    private function form(?int $id)
    {
        $post = $id ? (new PostModel())->find($id) : null;

        return $this->render('admin/posts/form', [
            'title'      => $id ? 'Edit Post' : 'New Post',
            'post'       => $post,
            'tagIds'     => $id ? (new PostModel())->tagIds($id) : [],
            'tags'       => (new TagModel())->orderBy('name')->findAll(),
            'categories' => (new CategoryModel())->orderBy('sort_order')->findAll(),
        ]);
    }

    public function store()
    {
        return $this->save(null);
    }

    public function update(int $id)
    {
        return $this->save($id);
    }

    protected function afterSave(int $postId, array $data): void
    {
        // author stamp on create
        if (! (new PostModel())->find($postId)['author_id']) {
            (new PostModel())->update($postId, ['author_id' => session()->get('admin_id')]);
        }
        // tags: comma-separated names → firstOrCreate + pivot sync
        $raw = (string) $this->request->getPost('tags_input');
        $tagModel = new TagModel();
        $ids = [];
        foreach (array_filter(array_map('trim', explode(',', $raw))) as $name) {
            $ids[] = $tagModel->firstOrCreate($name);
        }
        (new PostModel())->syncTags($postId, $ids);
    }

    public function delete(int $id)
    {
        return $this->destroy($id);
    }

    public function bulk()
    {
        return $this->bulk('/admin/posts');
    }
}
