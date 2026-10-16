<?php

namespace App\Controllers\Admin;

use App\Models\ActivityLogModel;

class Activity extends BaseAdmin
{
    public function index()
    {
        if ($resp = $this->guard('activity')) { return $resp; }
        $module = (string) ($this->request->getGet('module') ?? '');
        $q      = $this->request->getGet('q');
        $builder = (new ActivityLogModel())->orderBy('id', 'desc');
        if ($module !== '') { $builder->where('module', $module); }
        if ($q)             { $builder->like('description', $q); }

        return $this->render('admin/activity/index', [
            'title'   => 'Activity Log',
            'logs'    => $builder->paginate(30),
            'pager'   => $builder->getPager(),
            'modules' => array_column((new ActivityLogModel())->select('module')->distinct()->findAll(), 'module'),
            'module'  => $module,
        ]);
    }

    public function purge()
    {
        if ($resp = $this->guard('activity')) { return $resp; }
        $days = max(7, (int) $this->request->getPost('days'));
        (new ActivityLogModel())->where('created_at <', date('Y-m-d H:i:s', time() - $days * 86400))->delete();
        ActivityLogModel::record('purge', 'activity', "Purged logs older than {$days} days");

        return redirect()->to('/admin/activity')->with('success', "Older logs purged (kept last {$days} days).");
    }
}
