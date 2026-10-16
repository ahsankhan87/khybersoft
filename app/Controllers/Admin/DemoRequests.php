<?php

namespace App\Controllers\Admin;

use App\Models\ActivityLogModel;
use App\Models\DemoRequestModel;
use App\Models\ProductModel;

class DemoRequests extends BaseAdmin
{
    public function index()
    {
        if ($resp = $this->guard('demos')) { return $resp; }
        $status = (string) ($this->request->getGet('status') ?? '');
        $q      = trim((string) $this->request->getGet('q'));
        $model  = new DemoRequestModel();
        $builder = $model->orderBy('id', 'desc');
        if ($status !== '') { $builder->where('status', $status); }
        if ($q !== '')      { $builder->groupStart()->like('company_name', $q)->orLike('email', $q)->orLike('full_name', $q)->groupEnd(); }

        return $this->render('admin/demos/index', [
            'title'    => 'Demo Requests',
            'items'    => $builder->paginate(20),
            'pager'    => $builder->getPager(),
            'counts'   => [
                'pending'  => $model->where('status', 'pending')->countAllResults(),
                'scheduled'=> $model->where('status', 'scheduled')->countAllResults(),
                'done'     => $model->where('status', 'completed')->countAllResults(),
            ],
            'status'   => $status,
            'q'        => $q,
        ]);
    }

    public function show(int $id)
    {
        if ($resp = $this->guard('demos')) { return $resp; }
        $item = (new DemoRequestModel())->find($id);
        if (! $item) {
            return redirect()->to('/admin/demos')->with('error', 'Not found.');
        }

        return $this->render('admin/demos/show', [
            'title'    => 'Demo Request #' . $id,
            'item'     => $item,
            'products' => (new ProductModel())->where('status', 'active')->findAll(),
        ]);
    }

    public function updateStatus(int $id)
    {
        if ($resp = $this->guard('demos')) { return $resp; }
        $status = (string) $this->request->getPost('status');
        if (! in_array($status, ['pending', 'contacted', 'scheduled', 'completed', 'cancelled'], true)) {
            return redirect()->back()->with('error', 'Invalid status.');
        }
        $data = ['status' => $status];
        if ((string) $this->request->getPost('scheduled_at') !== '') {
            $data['scheduled_at'] = date('Y-m-d H:i:s', strtotime(str_replace('T', ' ', (string) $this->request->getPost('scheduled_at'))));
        }
        (new DemoRequestModel())->update($id, $data);
        ActivityLogModel::record('status', 'demos', "Demo #{$id} → {$status}");

        return redirect()->back()->with('success', 'Updated.');
    }

    public function reschedule(int $id)
    {
        if ($resp = $this->guard('demos')) { return $resp; }
        $when = trim((string) $this->request->getPost('scheduled_at'));
        if ($when === '') {
            return redirect()->back()->with('error', 'Pick a new date & time.');
        }
        (new DemoRequestModel())->update($id, ['scheduled_at' => date('Y-m-d H:i:s', strtotime(str_replace('T', ' ', $when))), 'status' => 'scheduled']);
        ActivityLogModel::record('reschedule', 'demos', "Demo #{$id}");

        return redirect()->back()->with('success', 'Rescheduled.');
    }

    public function delete(int $id)
    {
        if ($resp = $this->guard('demos')) { return $resp; }
        (new DemoRequestModel())->delete($id);
        ActivityLogModel::record('delete', 'demos', "Demo #{$id}");

        return redirect()->to('/admin/demos')->with('success', 'Deleted.');
    }
}
