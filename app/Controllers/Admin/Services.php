<?php

namespace App\Controllers\Admin;

use App\Concerns\HasAdminCrud;
use App\Models\ServiceModel;

class Services extends BaseAdmin
{
    use HasAdminCrud;

    protected string $module     = 'business';
    protected string $modelClass = ServiceModel::class;
    protected array  $fields     = ['name', 'slug', 'icon', 'summary', 'description', 'sort_order'];
    protected array  $booleans   = ['is_active'];
    protected array  $rules      = ['name' => 'required|max_length[150]', 'slug' => 'required|alpha_dash|is_unique[services.slug,id,{id}]'];
    protected string $slugSource = 'name';

    public function index()
    {
        return $this->render('admin/services/index', [
            'title' => 'Services',
            'items' => (new ServiceModel())->orderBy('sort_order')->findAll(),
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

    public function toggle(int $id)
    {
        return $this->toggleActive($id);
    }

    protected function listUrl(): string
    {
        return '/admin/services';
    }
}
