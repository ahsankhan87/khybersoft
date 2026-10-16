<?php

namespace App\Controllers\Admin;

use App\Models\ActivityLogModel;
use App\Models\LeadModel;
use App\Models\ProductModel;

class Leads extends BaseAdmin
{
    public function index()
    {
        if ($resp = $this->guard('leads')) { return $resp; }
        $status = (string) ($this->request->getGet('status') ?? '');
        $q      = trim((string) $this->request->getGet('q'));
        $model  = new LeadModel();
        $builder = $model->orderBy('id', 'desc');
        if ($status !== '') { $builder->where('status', $status); }
        if ($q !== '')      { $builder->groupStart()->like('full_name', $q)->orLike('email', $q)->orLike('company', $q)->groupEnd(); }

        return $this->render('admin/leads/index', [
            'title'  => 'Product Leads',
            'items'  => $builder->paginate(25),
            'pager'  => $builder->getPager(),
            'counts' => [
                'new'       => $model->where('status', 'new')->countAllResults(),
                'contacted' => $model->where('status', 'contacted')->countAllResults(),
                'customer'  => $model->where('status', 'customer')->countAllResults(),
                'junk'      => $model->where('status', 'junk')->countAllResults(),
            ],
            'status' => $status,
            'q'      => $q,
        ]);
    }

    public function show(int $id)
    {
        if ($resp = $this->guard('leads')) { return $resp; }
        $item = (new LeadModel())->find($id);
        if (! $item) {
            return redirect()->to('/admin/leads')->with('error', 'Not found.');
        }

        return $this->render('admin/leads/show', [
            'title'    => 'Lead #' . $id,
            'item'     => $item,
            'products' => (new ProductModel())->findAll(),
        ]);
    }

    public function updateStatus(int $id)
    {
        if ($resp = $this->guard('leads')) { return $resp; }
        $status = (string) $this->request->getPost('status');
        if (! in_array($status, ['new', 'contacted', 'qualified', 'proposal', 'won', 'lost', 'junk'], true)) {
            return redirect()->back()->with('error', 'Invalid status.');
        }
        (new LeadModel())->update($id, ['status' => $status]);
        ActivityLogModel::record('status', 'leads', "Lead #{$id} → {$status}");

        return redirect()->back()->with('success', 'Status updated.');
    }

    public function assign(int $id)
    {
        if ($resp = $this->guard('leads')) { return $resp; }
        (new LeadModel())->update($id, ['assigned_to' => session()->get('admin_id')]);
        ActivityLogModel::record('assign', 'leads', "Lead #{$id} assigned to me");

        return redirect()->back()->with('success', 'Assigned to you.');
    }

    public function note(int $id)
    {
        if ($resp = $this->guard('leads')) { return $resp; }
        $text = trim((string) $this->request->getPost('note'));
        if ($text === '') {
            return redirect()->back()->with('error', 'Note cannot be empty.');
        }
        $lead  = (new LeadModel())->find($id);
        $notes = json_decode((string) ($lead['notes'] ?? '[]'), true) ?: [];
        $notes[] = ['at' => date('Y-m-d H:i'), 'by' => session()->get('admin_name'), 'text' => $text];
        (new LeadModel())->update($id, ['notes' => json_encode($notes)]);
        ActivityLogModel::record('note', 'leads', "Note on lead #{$id}");

        return redirect()->back()->with('success', 'Note added.');
    }

    public function delete(int $id)
    {
        if ($resp = $this->guard('leads')) { return $resp; }
        (new LeadModel())->delete($id);
        ActivityLogModel::record('delete', 'leads', "Lead #{$id}");

        return redirect()->to('/admin/leads')->with('success', 'Deleted.');
    }

    public function bulk()
    {
        if ($resp = $this->guard('leads')) { return $resp; }
        $ids    = (array) $this->request->getPost('ids');
        $action = (string) $this->request->getPost('bulk_action');
        $model  = new LeadModel();
        foreach ($ids as $id) {
            if (! is_numeric($id)) { continue; }
            match ($action) {
                'delete' => $model->delete((int) $id),
                'junk'   => $model->update((int) $id, ['status' => 'junk']),
                'new'    => $model->update((int) $id, ['status' => 'new']),
                default  => null,
            };
        }
        ActivityLogModel::record('bulk-' . $action, 'leads', count($ids) . ' leads');

        return redirect()->back()->with('success', 'Bulk action applied.');
    }
}
