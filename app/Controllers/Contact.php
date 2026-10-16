<?php

namespace App\Controllers;

use App\Concerns\HandlesFormSubmissions;

class Contact extends BaseController
{
    use HandlesFormSubmissions;

    public function index()
    {
        return $this->renderPage('pages/contact', [
            'title'            => 'Contact Us',
            'meta_description' => 'Get in touch with Khybersoft. Questions about our products, pricing or custom development — we reply within one business day.',
        ]);
    }

    public function send()
    {
        if ($this->request->getMethod() !== 'POST') {
            return redirect()->to('/contact');
        }

        if (! $this->throttle('contact', 5, 3600)) {
            return redirect()->back()->with('error', 'Too many submissions. Please wait a minute and try again.')->withInput();
        }

        $rules = [
            'name'    => 'required|min_length[2]|max_length[200]',
            'email'   => 'required|valid_email|max_length[150]',
            'subject' => 'permit_empty|max_length[255]',
            'message' => 'required|min_length[10]|max_length[6000]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->recordLead('contact', [
            'name'    => trim((string) $this->request->getPost('name')),
            'company' => trim((string) ($this->request->getPost('company') ?? '')) ?: null,
            'email'   => strtolower(trim((string) $this->request->getPost('email'))),
            'phone'   => trim((string) ($this->request->getPost('phone') ?? '')) ?: null,
            'subject' => trim((string) ($this->request->getPost('subject') ?? '')) ?: 'General enquiry',
            'message' => trim((string) $this->request->getPost('message')),
        ]);

        if ($id === false) {
            log_message('error', 'Contact lead insert failed: ' . json_encode(session()->getFlashdata()));

            return redirect()->back()->withInput()->with('error', 'Something went wrong. Please try again.');
        }

        $this->notifyAdmins(
            'New contact: ' . $this->request->getPost('subject'),
            '<p><strong>' . esc((string) $this->request->getPost('name')) . '</strong> (' . esc((string) $this->request->getPost('email')) . ') wrote:</p><p>' . nl2br(esc((string) $this->request->getPost('message'))) . '</p>'
        );

        return redirect()->to('/contact')->with('success', 'Thanks for reaching out! We’ll get back to you within one business day.');
    }
}
