<?php

namespace App\Controllers\Admin;

use App\Concerns\HasAdminCrud;
use App\Models\ClientModel;

class Clients extends BaseAdmin
{
    use HasAdminCrud;

    protected string $module     = 'clients';
    protected string $modelClass = ClientModel::class;
    protected array  $fields     = ['company_name', 'logo', 'website', 'industry', 'sort_order'];
    protected array  $booleans   = ['is_active'];
    protected array  $rules      = ['company_name' => 'required|max_length[150]'];

    public function index()
    {
        return $this->render('admin/clients/index', [
            'title' => 'Clients (Logo Wall)',
            'items' => (new ClientModel())->orderBy('sort_order')->orderBy('id', 'desc')->findAll(),
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
        return '/admin/clients';
    }
}
