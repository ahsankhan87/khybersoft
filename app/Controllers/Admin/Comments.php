<?php

namespace App\Controllers\Admin;

use App\Models\ActivityLogModel;
use App\Models\CommentModel;

class Comments extends BaseAdmin
{
    public function index()
    {
        $status = (string) ($this->request->getGet('status') ?? 'pending');

        return $this->render('admin/comments/index', [
            'title'    => 'Comment Moderation',
            'comments' => (new CommentModel())->moderation($status !== '' ? $status : null),
            'counts'   => [
                'pending'  => (new CommentModel())->where('status', 'pending')->countAllResults(),
                'approved' => (new CommentModel())->where('status', 'approved')->countAllResults(),
                'spam'     => (new CommentModel())->where('status', 'spam')->countAllResults(),
            ],
            'active'   => $status,
        ]);
    }

    public function setStatus(int $id)
    {
        $status = (string) $this->request->getPost('status');
        if (! in_array($status, ['pending', 'approved', 'spam'], true)) {
            return redirect()->back()->with('error', 'Invalid status.');
        }
        (new CommentModel())->update($id, ['status' => $status]);
        ActivityLogModel::record('moderate', 'blog', "Comment #{$id} → {$status}");

        return redirect()->back()->with('success', 'Comment marked as ' . $status . '.');
    }

    public function reply(int $id)
    {
        $comment = (new CommentModel())->find($id);
        $body    = trim((string) $this->request->getPost('reply'));
        if (! $comment || $body === '') {
            return redirect()->back()->with('error', 'Reply cannot be empty.');
        }

        $email = model(\App\Models\Admin\SettingModel::class)::get('support_email', setting('noreply_email', 'no-reply@khybersoft.com'));
        $sent  = service('email')->initialize()->setFrom(['support@khybersoft.com' => 'Khybersoft'])
            ->setTo($comment['email'])->setSubject('Re: your comment — ' . $comment['post_title'] ?? 'Khybersoft')
            ->setMessage($body)->send();

        if ($sent) {
            (new CommentModel())->update($id, ['status' => 'approved']);
            ActivityLogModel::record('reply', 'blog', "Replied to comment #{$id}");

            return redirect()->back()->with('success', 'Reply sent & comment approved.');
        }

        return redirect()->back()->with('error', 'Reply failed to send. Check SMTP settings.');
    }

    public function delete(int $id)
    {
        (new CommentModel())->delete($id);
        ActivityLogModel::record('delete', 'blog', "Comment #{$id}");

        return redirect()->back()->with('success', 'Deleted.');
    }
}
