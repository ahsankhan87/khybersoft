<?php

namespace App\Controllers;

use App\Models\CustomDevelopmentQuoteModel;
use Config\Services;

class CustomDevelopment extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url']);
    }

    public function index()
    {
        $data = [
            'title' => 'Custom Software Development - Khybersoft',
            'meta_description' => 'Custom software and web application development services tailored to your specific business requirements.'
        ];

        return view('layouts/header', $data)
            . view('custom_development')
            . view('layouts/footer');
    }

    public function quote()
    {
        // Handle custom development quote requests
        if ($this->request->getMethod() === 'POST') {
            if ($this->isSpamSubmission()) {
                return redirect()->back()->with('error', 'Unable to submit right now. Please try again.')->withInput();
            }

            if ($this->isRateLimited()) {
                return redirect()->back()->with('error', 'Too many submissions. Please wait a minute and try again.')->withInput();
            }

            $model = new CustomDevelopmentQuoteModel();

            $validation = \Config\Services::validation();
            $validation->setRules([
                'name'         => 'required|min_length[3]|max_length[255]',
                'company'      => 'permit_empty|max_length[255]',
                'email'        => 'required|valid_email',
                'phone'        => 'permit_empty|max_length[50]',
                'project_type' => 'required|max_length[50]',
                'description'  => 'required|min_length[10]',
            ]);

            $data = $this->request->getPost();

            if (!$validation->run($data)) {
                return redirect()->back()->with('errors', $validation->getErrors())->withInput();
            }

            try {
                $payload = [
                    'name'         => trim((string) ($data['name'] ?? '')),
                    'company'      => trim((string) ($data['company'] ?? '')),
                    'email'        => strtolower(trim((string) ($data['email'] ?? ''))),
                    'phone'        => trim((string) ($data['phone'] ?? '')),
                    'project_type' => trim((string) ($data['project_type'] ?? '')),
                    'description'  => trim((string) ($data['description'] ?? '')),
                ];

                // Save to database
                $model->save([
                    'name'         => $payload['name'],
                    'company'      => $payload['company'] !== '' ? $payload['company'] : null,
                    'email'        => $payload['email'],
                    'phone'        => $payload['phone'] !== '' ? $payload['phone'] : null,
                    'project_type' => $payload['project_type'],
                    'description'  => $payload['description'],
                ]);

                // Send notification email to admin
                $this->sendAdminNotification($payload);

                // Send confirmation email to user
                $this->sendUserConfirmation($payload);

                return redirect()->back()->with('success', 'Thank you for your inquiry! We\'ll contact you within 24 hours.');
            } catch (\Exception $e) {
                log_message('error', 'Custom development quote failed: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Something went wrong. Please try again later.');
            }
        }

        return redirect()->to('/custom-development');
    }

    /**
     * Detect obvious bot submissions using honeypot and submit speed.
     */
    private function isSpamSubmission(): bool
    {
        $honeypotValue = (string) $this->request->getPost('website');
        if ($honeypotValue !== '') {
            log_message('warning', 'Quote form blocked by honeypot from IP: {ip}', ['ip' => (string) $this->request->getIPAddress()]);
            return true;
        }

        $startedAt = (int) $this->request->getPost('form_started_at');
        if ($startedAt <= 0) {
            return true;
        }

        $elapsed = time() - $startedAt;
        if ($elapsed < 3 || $elapsed > 7200) {
            log_message('warning', 'Quote form blocked by timing check from IP: {ip} ({elapsed}s)', [
                'ip'      => (string) $this->request->getIPAddress(),
                'elapsed' => $elapsed,
            ]);
            return true;
        }

        return false;
    }

    /**
     * Limit quote submissions per IP to reduce burst spam.
     */
    private function isRateLimited(): bool
    {
        $throttler = Services::throttler();
        $ipHash    = md5((string) $this->request->getIPAddress());
        $key       = 'custom_quote_form_' . $ipHash;

        return !$throttler->check($key, 3, MINUTE);
    }

    /**
     * Send notification email to admin when someone submits quote form
     */
    private function sendAdminNotification(array $quoteData)
    {
        $email = \Config\Services::email();

        $email->setFrom('noreply@khybersoft.com', 'Khybersoft');
        $email->setTo('ahsankhan50@gmail.com'); // Change this to your email
        $email->setSubject('New Custom Development Quote Request');

        $company = !empty($quoteData['company']) ? $quoteData['company'] : '-';
        $phone = !empty($quoteData['phone']) ? $quoteData['phone'] : '-';

        $emailBody = "
            <h2>New Custom Development Quote Request</h2>
            <p><strong>Name:</strong> {$quoteData['name']}</p>
            <p><strong>Email:</strong> {$quoteData['email']}</p>
            <p><strong>Company:</strong> {$company}</p>
            <p><strong>Phone:</strong> {$phone}</p>
            <p><strong>Project Type:</strong> {$quoteData['project_type']}</p>
            <hr>
            <h3>Project Description:</h3>
            <p>" . nl2br(htmlspecialchars($quoteData['description'])) . "</p>
            <hr>
            <p><strong>Submitted on:</strong> " . date('Y-m-d H:i:s') . "</p>
            <p>You can reply to this contact at <a href='mailto:{$quoteData['email']}'>{$quoteData['email']}</a></p>
        ";

        $email->setMessage($emailBody);

        if (!$email->send()) {
            log_message('error', 'Failed to send custom development quote notification email: ' . $email->printDebugger());
        }

        return true;
    }

    /**
     * Send confirmation email to user when they submit quote form
     */
    private function sendUserConfirmation(array $quoteData)
    {
        $email = \Config\Services::email();

        $email->setFrom('noreply@khybersoft.com', 'Khybersoft');
        $email->setTo($quoteData['email']);
        $email->setSubject('We received your project inquiry - Khybersoft');

        $company = !empty($quoteData['company']) ? $quoteData['company'] : '';
        $companyLine = $company !== '' ? "<p><strong>Company:</strong> {$company}</p>" : '';

        $emailBody = "
            <h2>Thank you for your inquiry!</h2>
            <p>Hi {$quoteData['name']},</p>
            <p>We have received your project details. Our team will review your requirements and get back to you as soon as possible.</p>
            <hr>
            <h3>Your Request Details:</h3>
            {$companyLine}
            <p><strong>Project Type:</strong> {$quoteData['project_type']}</p>
            <p><strong>Description:</strong></p>
            <p>" . nl2br(htmlspecialchars($quoteData['description'])) . "</p>
            <hr>
            <p><strong>Best regards,</strong><br>
            Khybersoft Team</p>
        ";

        $email->setMessage($emailBody);

        if (!$email->send()) {
            log_message('error', 'Failed to send custom development quote user confirmation email: ' . $email->printDebugger());
        }

        return true;
    }
}
