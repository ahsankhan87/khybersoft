<?php

namespace App\Controllers\Admin;

use App\Concerns\HasAdminCrud;
use App\Models\TutorialCategoryModel;

class TutorialCategories extends BaseAdmin
{
    use HasAdminCrud;

    protected string $module     = 'tutorials';
    protected string $modelClass = TutorialCategoryModel::class;
    protected array  $fields     = ['name', 'slug', 'icon', 'sort_order'];
    protected array  $rules      = ['name' => 'required|max_length[100]', 'slug' => 'required|alpha_dash|is_unique[tutorial_categories.slug,id,{id}]'];
    protected string $slugSource = 'name';

    public function index()
    {
        return $this->render('admin/tutorials/categories', [
            'title'      => 'Tutorial Categories',
            'categories' => (new TutorialCategoryModel())->orderBy('sort_order')->findAll(),
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
        return '/admin/tutorial-categories';
    }
}
