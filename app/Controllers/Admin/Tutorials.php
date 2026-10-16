<?php

namespace App\Controllers\Admin;

use App\Concerns\HasAdminCrud;
use App\Models\ProductModel;
use App\Models\TutorialCategoryModel;
use App\Models\TutorialModel;

class Tutorials extends BaseAdmin
{
    use HasAdminCrud;

    protected string $module     = 'tutorials';
    protected string $modelClass = TutorialModel::class;
    protected array  $fields     = ['product_id', 'category_id', 'title', 'slug', 'type', 'video_url', 'article_body', 'thumbnail', 'duration_sec', 'sort_order'];
    protected array  $booleans   = ['is_published'];
    protected array  $rules      = ['title' => 'required|max_length[200]', 'slug' => 'required|alpha_dash|is_unique[tutorials.slug,id,{id}]'];
    protected string $slugSource = 'title';

    public function index()
    {
        return $this->render('admin/tutorials/index', [
            'title'     => 'Tutorials & Help Center',
            'items'     => (new TutorialModel())->orderBy('sort_order')->findAll(),
            'products'  => (new ProductModel())->where('status', 'active')->findAll(),
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
        return $this->render('admin/tutorials/form', [
            'title'      => $id ? 'Edit Tutorial' : 'New Tutorial',
            'item'       => $id ? (new TutorialModel())->find($id) : null,
            'products'   => (new ProductModel())->where('status', 'active')->findAll(),
            'categories' => (new TutorialCategoryModel())->orderBy('sort_order')->findAll(),
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

    public function delete(int $id)
    {
        return $this->destroy($id);
    }

    public function toggle(int $id)
    {
        if ($resp = $this->guard()) { return $resp; }
        $m = new TutorialModel();
        $row = $m->find($id);
        $m->update($id, ['is_published' => $row['is_published'] ? 0 : 1]);
        \App\Models\ActivityLogModel::record('toggle', 'tutorials', "Tutorial #{$id}");

        return redirect()->to('/admin/tutorials')->with('success', 'Toggled.');
    }
}
