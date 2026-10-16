<?php

namespace App\Controllers\Admin;

use App\Models\ActivityLogModel;
use App\Models\ContactModel;

class Contacts extends BaseAdmin
{
    public function index()
    {
        if ($resp = $this->guard('leads')) { return $resp; }
        $status = (string) ($this->request->getGet('status') ?? '');
        $q      = trim((string) $this->request->getGet('q'));
        $model  = new ContactModel();
        $builder = $model->orderBy('id', 'desc');
        if ($status !== '') { $builder->where('status', $status); }
        if ($q !== '')      { $builder->groupStart()->like('name', $q)->orLike('email', $q)->orLike('message', $q)->groupEnd(); }

        return $this->render('admin/contacts/index', [
            'title'  => 'Contact Messages',
            'items'  => $builder->paginate(20),
            'pager'  => $builder->getPager(),
            'counts' => [
                'unread'  => $model->where('status', 'unread')->countAllResults(),
                'read'    => $model->where('status', 'read')->countAllResults(),
                'archived'=> $model->where('status', 'archived')->countAllResults(),
                'junk'    => $model->where('status', 'junk')->countAllResults(),
            ],
            'status' => $status,
            'q'      => $q,
        ]);
    }

    public function show(int $id)
    {
        if ($resp = $this->guard('leads')) { return $resp; }
        $model = new ContactModel();
        $item  = $model->find($id);
        if (! $item) {
            return redirect()->to('/admin/contacts')->with('error', 'Not found.');
        }
        if ($item['status'] === 'unread') {
            $model->update($id, ['status' => 'read']);
        }

        return $this->render('admin/contacts/show', ['title' => 'Message #' . $id, 'item' => $item]);
    }

    public function setStatus(int $id)
    {
        if ($resp = $this->guard('leads')) { return $resp; }
        $status = (string) $this->request->getPost('status');
        if (! in_array($status, ['unread', 'read', 'replied', 'archived', 'junk'], true)) {
            return redirect()->back()->with('error', 'Invalid status.');
        }
        (new ContactModel())->update($id, ['status' => $status]);
        ActivityLogModel::record('status', 'leads', "Contact #{$id} → {$status}");

        return redirect()->back()->with('success', 'Updated.');
    }

    public function reply(int $id)
    {
        if ($resp = $this->guard('leads')) { return $resp; }
        $model = new ContactModel();
        $msg   = $model->find($id);
        $body  = trim((string) $this->request->getPost('reply'));
        if (! $msg || $body === '') {
            return redirect()->back()->with('error', 'Reply cannot be empty.');
        }
        try {
            $sent = service('email')->initialize()
                ->setFrom([(setting('noreply_email') ?: 'support@khybersoft.com') => setting('site_name') ?: 'Khybersoft'])
                ->setTo($msg['email'])
                ->setSubject('Re: ' . ($msg['subject'] ?: 'Your message to Khybersoft'))
                ->setMessage($body)
                ->send();
        } catch (\Throwable $e) {
            $sent = false;
            log_message('error', 'Contact reply failed: ' . $e->getMessage());
        }
        if ($sent) {
            $model->update($id, ['status' => 'replied']);
            ActivityLogModel::record('reply', 'leads', "Replied to contact #{$id}");

            return redirect()->back()->with('success', 'Reply sent.');
        }

        return redirect()->back()->with('error', 'Reply failed — check SMTP settings under Integrations.');
    }

    public function delete(int $id)
    {
        if ($resp = $this->guard('leads')) { return $resp; }
        (new ContactModel())->delete($id);
        ActivityLogModel::record('delete', 'leads', "Contact #{$id}");

        return redirect()->to('/admin/contacts')->with('success', 'Deleted.');
    }
}
