<?php

namespace App\Controllers\Admin;

use App\Concerns\HasAdminCrud;
use App\Models\CategoryModel;

class Categories extends BaseAdmin
{
    use HasAdminCrud;

    protected string $module     = 'blog';
    protected string $modelClass = CategoryModel::class;
    protected array  $fields     = ['name', 'slug', 'description', 'sort_order'];
    protected array  $rules      = ['name' => 'required|max_length[100]', 'slug' => 'required|alpha_dash|is_unique[categories.slug,id,{id}]'];
    protected string $slugSource = 'name';
    protected string $listUrlOverride = '/admin/categories';

    public function index()
    {
        return $this->render('admin/categories/index', [
            'title'      => 'Blog Categories',
            'categories' => (new CategoryModel())->orderBy('sort_order')->findAll(),
        ]);
    }

    public function save(?int $id = null)
    {
        return $this->save($id);
    }

    public function delete(int $id)
    {
        return $this->destroy($id);
    }

    protected function listUrl(): string
    {
        return '/admin/categories';
    }
}
