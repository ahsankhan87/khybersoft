<?php

namespace App\Controllers\Admin;

use App\Concerns\HasAdminCrud;
use App\Models\TeamMemberModel;

class Team extends BaseAdmin
{
    use HasAdminCrud;

    protected string $module     = 'business';
    protected string $modelClass = TeamMemberModel::class;
    protected array  $fields     = ['name', 'role', 'photo', 'bio', 'linkedin', 'twitter', 'github', 'sort_order'];
    protected array  $booleans   = ['is_active'];
    protected array  $rules      = ['name' => 'required|max_length[120]', 'role' => 'required|max_length[120]'];

    public function index()
    {
        return $this->render('admin/team/index', [
            'title' => 'Team Members',
            'items' => (new TeamMemberModel())->orderBy('sort_order')->findAll(),
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
        return '/admin/team';
    }
}
