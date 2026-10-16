<?php

namespace App\Controllers\Admin;

use App\Concerns\HasAdminCrud;
use App\Models\TagModel;

class Tags extends BaseAdmin
{
    use HasAdminCrud;

    protected string $module     = 'blog';
    protected string $modelClass = TagModel::class;
    protected array  $fields     = ['name', 'slug'];
    protected string $slugSource = 'name';

    public function index()
    {
        return $this->render('admin/tags/index', [
            'title' => 'Blog Tags',
            'tags'  => (new TagModel())->orderBy('name')->findAll(),
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
        return '/admin/tags';
    }
}
