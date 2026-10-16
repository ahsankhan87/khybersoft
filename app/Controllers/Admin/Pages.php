<?php

namespace App\Controllers\Admin;

use App\Concerns\HasAdminCrud;
use App\Models\PageModel;

class Pages extends BaseAdmin
{
    use HasAdminCrud;

    protected string $module     = 'pages';
    protected string $modelClass = PageModel::class;
    protected array  $fields     = ['title', 'slug', 'content', 'meta_title', 'meta_desc', 'show_in_menu'];
    protected array  $booleans   = ['is_active'];
    protected array  $rules      = ['title' => 'required|max_length[200]', 'slug' => 'required|alpha_dash|is_unique[pages.slug,id,{id}]'];
    protected string $slugSource = 'title';

    public function index()
    {
        return $this->render('admin/pages/index', [
            'title' => 'Pages',
            'items' => (new PageModel())->orderBy('id')->findAll(),
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
        return $this->render('admin/pages/form', [
            'title' => $id ? 'Edit Page' : 'New Page',
            'item'  => $id ? (new PageModel())->find($id) : null,
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
}
