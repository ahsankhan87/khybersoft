<?php

namespace App\Controllers\Admin;

use App\Models\ActivityLogModel;
use App\Models\LeadModel;

class Leads extends BaseAdmin
{
    public function index()
    {
        if ($resp = $this->guard('leads')) { return $resp; }
        $filterType = (string) ($this->request->getGet('type') ?? '');
        $filterStatus = (string) ($this->request->getGet('status') ?? '');
        $model  = new LeadModel();
        $builder = $model->orderBy('id', 'desc');
        if ($filterType !== '') { $builder->where('type', $filterType); }
        if ($filterStatus !== '') { $builder->where('status', $filterStatus); }

        return $this->render('admin/leads/index', [
            'title'        => 'Leads & Inquiries',
            'leads'        => $builder->paginate(25),
            'pager'        => $builder->pager,
            'filterType'   => $filterType,
            'filterStatus' => $filterStatus,
        ]);
    }

    public function exportCsv()
    {
        if ($resp = $this->guard('leads')) { return $resp; }
        $rows = (new LeadModel())->orderBy('id', 'desc')->findAll();
        $csv = "id,type,name,email,company,status,created_at\n";
        foreach ($rows as $row) {
            $values = [$row['id'], $row['type'], $row['name'], $row['email'], $row['company'], $row['status'], $row['created_at']];
            $csv .= implode(',', array_map(static fn ($value) => '"' . str_replace('"', '""', (string) $value) . '"', $values)) . "\n";
        }

        return $this->response->setContentType('text/csv')
            ->setHeader('Content-Disposition', 'attachment; filename="leads-' . date('Ymd') . '.csv"')
            ->setBody($csv);
    }

    public function show(int $id)
    {
        if ($resp = $this->guard('leads')) { return $resp; }
        $item = (new LeadModel())->find($id);
        if (! $item) {
            return redirect()->to('/admin/leads')->with('error', 'Not found.');
        }

        return $this->render('admin/leads/show', ['title' => 'Lead #' . $id, 'lead' => $item]);
    }

    public function updateStatus(int $id)
    {
        if ($resp = $this->guard('leads')) { return $resp; }
        $status = (string) $this->request->getPost('status');
        if (! in_array($status, ['new', 'read', 'replied', 'closed', 'spam'], true)) {
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
