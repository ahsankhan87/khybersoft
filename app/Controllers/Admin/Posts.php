<?php

namespace App\Controllers\Admin;

use App\Concerns\HasAdminCrud;
use App\Models\CategoryModel;
use App\Models\PostModel;
use App\Models\SubscriberModel;
use App\Models\TagModel;
use App\Models\ActivityLogModel;

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
            'pager'      => $model->pager,
            'categories' => (new CategoryModel())->orderBy('sort_order')->findAll(),
            'total'      => (new PostModel())->countAllResults(),
            'status'     => (string) ($this->request->getGet('status') ?? ''),
            'categoryId' => (int) ($this->request->getGet('category') ?? 0),
            'q'          => (string) ($this->request->getGet('q') ?? ''),
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
            'tagNames'   => $id ? (new PostModel())->tagNames($id) : [],
            'tags'       => (new TagModel())->orderBy('name')->findAll(),
            'categories' => (new CategoryModel())->orderBy('sort_order')->findAll(),
        ]);
    }

    public function store()
    {
        return $this->savePost(null);
    }

    public function update(int $id)
    {
        return $this->savePost($id);
    }

    private function savePost(?int $id)
    {
        if ($resp = $this->guard()) {
            return $resp;
        }

        $model = new PostModel();
        $previous = $id ? $model->find($id) : null;
        if ($id !== null && ! $previous) {
            return redirect()->to($this->listUrl())->with('error', 'The post could not be found.');
        }

        $data = $this->collect();
        if (! $this->validateRules($this->rules, $id)) {
            return redirect()->back()->withInput();
        }

        // The controller has already validated title and slug. Avoid a second,
        // conflicting model validation pass when updating a record's own slug.
        $model->skipValidation(true);
        if ($id !== null) {
            $saved = $model->update($id, $data);
        } else {
            $insertedId = $model->insert($data);
            $saved = $insertedId !== false;
            $id = $saved ? (int) $insertedId : null;
        }

        if (! $saved || $id === null) {
            $errors = $model->errors();
            if (! $errors) {
                $errors = ['post' => 'The post could not be saved. Please check the fields and try again.'];
            }
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        $this->afterSave($id, $data);
        ActivityLogModel::record($previous ? 'update' : 'create', $this->module, $previous ? "Updated #{$id}" : 'Created new record', $this->logTarget($data));

        $message = 'Saved successfully.';
        $wasPublished = ($previous['status'] ?? null) === 'published';
        if (($data['status'] ?? null) === 'published' && ! $wasPublished) {
            [$sent, $failed] = $this->emailSubscribers($id);
            $message .= " Subscriber emails sent: {$sent}.";
            if ($failed > 0) {
                $message .= " {$failed} could not be sent; check SMTP configuration and application logs.";
            }
        }

        return redirect()->to($this->listUrl())->with('success', $message);
    }

    /** @return array{int, int} sent and failed message counts */
    private function emailSubscribers(int $postId): array
    {
        $post = (new PostModel())->find($postId);
        if (! $post) {
            return [0, 0];
        }

        $subscribers = (new SubscriberModel())->where('status', 'confirmed')->findAll();
        if (! $subscribers) {
            return [0, 0];
        }

        $url = site_url('blog/' . rawurlencode($post['slug']));
        $title = esc($post['title']);
        $excerpt = esc($post['excerpt'] ?: strip_tags($post['content']));
        $message = '<!doctype html><html><body style="font-family:Arial,sans-serif;color:#1f2937;line-height:1.6">'
            . '<h1 style="font-size:24px">' . $title . '</h1>'
            . '<p>' . nl2br($excerpt) . '</p>'
            . '<p><a href="' . esc($url) . '" style="display:inline-block;padding:12px 18px;background:#2563eb;color:#fff;text-decoration:none;border-radius:6px">Read the blog</a></p>'
            . '<p style="font-size:12px;color:#64748b">You received this because you subscribed to ' . esc(setting('site_name', 'Khybersoft')) . ' updates.</p>'
            . '</body></html>';

        $sent = 0;
        $failed = 0;
        foreach ($subscribers as $subscriber) {
            try {
                $email = service('email');
                $email->clear(true);
                $email->setTo($subscriber['email']);
                $email->setSubject('New blog post: ' . $post['title']);
                $email->setMessage($message);
                if ($email->send()) {
                    $sent++;
                    continue;
                }
                $failed++;
                log_message('error', 'Blog subscriber notification failed for post #{postId} to {email}: {debug}', [
                    'postId' => $postId,
                    'email' => $subscriber['email'],
                    'debug' => $email->printDebugger(['headers']),
                ]);
            } catch (\Throwable $e) {
                $failed++;
                log_message('error', 'Blog subscriber notification failed for post #{postId} to {email}: {error}', [
                    'postId' => $postId,
                    'email' => $subscriber['email'],
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return [$sent, $failed];
    }

    protected function beforeSaveData(array &$data): void
    {
        if (array_key_exists('category_id', $data) && $data['category_id'] === '') {
            $data['category_id'] = null;
        }
        if (($data['status'] ?? null) === 'published' && empty($data['published_at'])) {
            $data['published_at'] = date('Y-m-d H:i:s');
        }
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

    protected function listUrl(): string
    {
        return '/admin/posts';
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
