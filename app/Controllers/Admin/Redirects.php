<?php

namespace App\Controllers\Admin;

use App\Concerns\HasAdminCrud;
use App\Models\RedirectModel;

class Redirects extends BaseAdmin
{
    use HasAdminCrud;

    protected string $module     = 'redirects';
    protected string $modelClass = RedirectModel::class;
    protected array  $fields     = ['source_path', 'target_url', 'status_code'];
    protected array  $booleans   = ['is_active'];
    protected array  $rules      = ['source_path' => 'required|max_length[255]', 'target_url' => 'required|max_length[500]'];

    public function index()
    {
        return $this->render('admin/redirects/index', [
            'title' => 'URL Redirects',
            'items' => (new RedirectModel())->orderBy('hits', 'desc')->findAll(),
        ]);
    }

    public function save(?int $id = null)
    {
        // normalize source path
        $_POST['source_path'] = '/' . ltrim(trim((string) ($_POST['source_path'] ?? '')), '/');

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
        return '/admin/redirects';
    }
}
