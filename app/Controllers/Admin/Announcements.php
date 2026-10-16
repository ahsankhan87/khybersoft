<?php

namespace App\Controllers\Admin;

use App\Concerns\HasAdminCrud;
use App\Models\AnnouncementModel;

class Announcements extends BaseAdmin
{
    use HasAdminCrud;

    protected string $module     = 'announcements';
    protected string $modelClass = AnnouncementModel::class;
    protected array  $fields     = ['message', 'link_text', 'link_url', 'bg_class', 'starts_at', 'ends_at', 'sort_order'];
    protected array  $booleans   = ['is_active'];
    protected array  $rules      = ['message' => 'required|max_length[255]'];

    public function index()
    {
        return $this->render('admin/announcements/index', [
            'title'       => 'Announcement Bar',
            'items'       => (new AnnouncementModel())->orderBy('sort_order')->orderBy('id', 'desc')->findAll(),
            'currentBar'  => (new AnnouncementModel())->current(),
        ]);
    }

    public function save(?int $id = null)
    {
        $start = trim((string) $this->request->getPost('starts_at'));
        $end   = trim((string) $this->request->getPost('ends_at'));
        $_POST['starts_at'] = $start !== '' ? date('Y-m-d H:i:s', strtotime(str_replace('T', ' ', $start))) : null;
        $_POST['ends_at']   = $end !== '' ? date('Y-m-d H:i:s', strtotime(str_replace('T', ' ', $end))) : null;

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
        return '/admin/announcements';
    }
}
