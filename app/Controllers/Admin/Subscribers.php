<?php

namespace App\Controllers\Admin;

use App\Models\ActivityLogModel;
use App\Models\SubscriberModel;

class Subscribers extends BaseAdmin
{
    public function index()
    {
        if ($resp = $this->guard('subscribers')) { return $resp; }
        $model = new SubscriberModel();
        $q     = trim((string) $this->request->getGet('q'));
        $builder = $model->orderBy('id', 'desc');
        if ($q !== '') { $builder->like('email', $q); }

        return $this->render('admin/subscribers/index', [
            'title'   => 'Newsletter Subscribers',
            'subs'    => $builder->paginate(50),
            'pager'   => $builder->pager,
            'total'   => $model->countAllResults(),
            'confirmed' => (new SubscriberModel())->where('status', 'confirmed')->countAllResults(),
            'q'       => $q,
        ]);
    }

    public function setStatus(int $id)
    {
        if ($resp = $this->guard('subscribers')) { return $resp; }
        $status = (string) $this->request->getPost('status');
        if (! in_array($status, ['pending', 'confirmed', 'unsubscribed'], true)) {
            return redirect()->back()->with('error', 'Invalid subscriber status.');
        }
        (new SubscriberModel())->update($id, ['status' => $status]);
        ActivityLogModel::record('status', 'subscribers', "Subscriber #{$id} set to {$status}");

        return redirect()->back()->with('success', 'Subscriber status updated.');
    }

    public function exportCsv()
    {
        if ($resp = $this->guard('subscribers')) { return $resp; }
        $rows  = (new SubscriberModel())->where('status', 'confirmed')->orderBy('id')->findAll();
        $csv   = "email,status,source,created_at\n";
        foreach ($rows as $r) {
            $csv .= '"' . str_replace('"', '""', $r['email']) . '",' . $r['status'] . ',' . ($r['source'] ?? '') . ',' . $r['created_at'] . "\n";
        }
        ActivityLogModel::record('export', 'subscribers', count($rows) . ' emails exported');

        return $this->response->setContentType('text/csv')
            ->setHeader('Content-Disposition', 'attachment; filename="subscribers-' . date('Ymd') . '.csv"')
            ->setBody($csv);
    }

    public function delete(int $id)
    {
        if ($resp = $this->guard('subscribers')) { return $resp; }
        (new SubscriberModel())->delete($id);
        ActivityLogModel::record('delete', 'subscribers', "Subscriber #{$id}");

        return redirect()->back()->with('success', 'Removed.');
    }
}
