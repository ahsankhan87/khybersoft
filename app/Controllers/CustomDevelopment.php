<?php

namespace App\Controllers;

use App\Concerns\HandlesFormSubmissions;

/**
 * Custom development quote form → unified `leads` table (type=quote).
 * Extra fields stored as JSON in leads.extra. Old custom_development_quotes
 * rows are copied over by LeadMigrationSeeder.
 */
class CustomDevelopment extends BaseController
{
    use HandlesFormSubmissions;

    public function index()
    {
        return $this->renderPage('pages/custom_development', [
            'title'            => 'Custom Software Development',
            'meta_description' => 'Custom software and web application development services tailored to your specific business requirements.',
        ]);
    }

    public function quote()
    {
        if ($this->request->getMethod() !== 'POST') {
            return redirect()->to('/custom-development');
        }

        if (! $this->throttle('quote', 3, 60)) {
            return redirect()->back()->with('error', 'Too many submissions. Please wait a minute and try again.')->withInput();
        }

        $rules = [
            'name'         => 'required|min_length[3]|max_length[255]',
            'company'      => 'permit_empty|max_length[255]',
            'email'        => 'required|valid_email|max_length[150]',
            'phone'        => 'permit_empty|max_length[50]',
            'project_type' => 'required|max_length[50]',
            'description'  => 'required|min_length[10]|max_length[8000]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $post = $this->request->getPost();

        $extra = array_filter([
            'project_type' => trim((string) ($post['project_type'] ?? '')),
            'budget'       => trim((string) ($post['budget'] ?? '')),
            'timeline'     => trim((string) ($post['timeline'] ?? '')),
        ]);

        $id = $this->recordLead('quote', [
            'name'    => trim((string) $post['name']),
            'company' => trim((string) ($post['company'] ?? '')) ?: null,
            'email'   => strtolower(trim((string) $post['email'])),
            'phone'   => trim((string) ($post['phone'] ?? '')) ?: null,
            'subject' => 'Custom development quote request',
            'message' => trim((string) $post['description']),
            'extra'   => $extra ?: null,
        ]);

        if ($id === false) {
            log_message('error', 'Quote lead insert failed: ' . json_encode(session()->getFlashdata()));

            return redirect()->back()->withInput()->with('error', 'Something went wrong. Please try again later.');
        }

        // Also keep writing the legacy table until you drop it (dual-write for safety).
        try {
            model(\App\Models\CustomDevelopmentQuoteModel::class)->insert([
                'name'         => trim((string) $post['name']),
                'company'      => trim((string) ($post['company'] ?? '')) ?: null,
                'email'        => strtolower(trim((string) $post['email'])),
                'phone'        => trim((string) ($post['phone'] ?? '')) ?: null,
                'project_type' => trim((string) $post['project_type']),
                'description'  => trim((string) $post['description']),
            ], false);
        } catch (\Throwable $e) {
            log_message('warning', 'Legacy quote dual-write failed (ok): ' . $e->getMessage());
        }

        $this->notifyAdmins(
            'New quote request: ' . ($post['project_type'] ?? 'Custom development'),
            '<p><strong>' . esc((string) $post['name']) . '</strong> — ' . esc((string) $post['email']) . '</p>'
            . '<p>Type: ' . esc((string) $post['project_type']) . '</p>'
            . '<p>' . nl2br(esc((string) $post['description'])) . '</p>'
        );

        return redirect()->to('/custom-development')->with('success', "Thank you for your inquiry! We'll contact you within 24 hours.");
    }
}
