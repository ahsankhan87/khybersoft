<?php

namespace App\Controllers\Admin;

use App\Models\ActivityLogModel;
use App\Models\CustomDevelopmentQuoteModel;

class Quotes extends BaseAdmin
{
    public function index()
    {
        if ($resp = $this->guard('quotes')) { return $resp; }
        $status = (string) ($this->request->getGet('status') ?? '');
        $model  = new CustomDevelopmentQuoteModel();
        $builder = $model->orderBy('id', 'desc');
        if ($status !== '') { $builder->where('status', $status); }

        return $this->render('admin/quotes/index', [
            'title'  => 'Custom Development Quotes',
            'items'  => $builder->paginate(20),
            'pager'  => $builder->getPager(),
            'counts' => [
                'new'      => $model->where('status', 'new')->countAllResults(),
                'reviewing'=> $model->where('status', 'reviewing')->countAllResults(),
                'quoted'   => $model->where('status', 'quoted')->countAllResults(),
            ],
            'status' => $status,
        ]);
    }

    public function show(int $id)
    {
        if ($resp = $this->guard('quotes')) { return $resp; }
        $item = (new CustomDevelopmentQuoteModel())->find($id);
        if (! $item) {
            return redirect()->to('/admin/quotes')->with('error', 'Not found.');
        }

        return $this->render('admin/quotes/show', ['title' => 'Quote #' . $id, 'item' => $item]);
    }

    public function updateStatus(int $id)
    {
        if ($resp = $this->guard('quotes')) { return $resp; }
        $status = (string) $this->request->getPost('status');
        if (! in_array($status, ['new', 'reviewing', 'quoted', 'won', 'lost'], true)) {
            return redirect()->back()->with('error', 'Invalid status.');
        }
        (new CustomDevelopmentQuoteModel())->update($id, ['status' => $status]);
        ActivityLogModel::record('status', 'quotes', "Quote #{$id} → {$status}");

        return redirect()->back()->with('success', 'Updated.');
    }

    public function delete(int $id)
    {
        if ($resp = $this->guard('quotes')) { return $resp; }
        (new CustomDevelopmentQuoteModel())->delete($id);
        ActivityLogModel::record('delete', 'quotes', "Quote #{$id}");

        return redirect()->to('/admin/quotes')->with('success', 'Deleted.');
    }
}
