<?php

namespace App\Controllers;

use App\Models\ContactModel;
use Config\Services;


class Contact extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url']);
    }

    public function index()
    {
        $data = [
            'title' => 'Contact Us - Khybersoft',
            'meta_description' => 'Get in touch with Khybersoft. We\'d love to hear from you about your project needs or any questions you might have.'
        ];

        return view('layouts/header', $data)
            . view('contact')
            . view('layouts/footer');
    }

    public function send()
    {
        // Handle contact form submission
        if ($this->request->getMethod() === 'POST') {
            if ($this->isSpamSubmission()) {
                // Use a generic message to avoid giving bots feedback.
                return redirect()->back()->with('error', 'Unable to submit right now. Please try again.')->withInput();
            }

            if ($this->isRateLimited()) {
                return redirect()->back()->with('error', 'Too many submissions. Please wait a minute and try again.')->withInput();
            }

            $model = new ContactModel();

            $validation = \Config\Services::validation();
            $validation->setRules([
                'name'    => 'required|min_length[3]|max_length[255]',
                'email'   => 'required|valid_email',
                'subject' => 'required|min_length[5]|max_length[255]',
                'message' => 'required|min_length[10]',
            ]);

            $data = $this->request->getPost();

            if (!$validation->run($data)) {
                return redirect()->back()->with('errors', $validation->getErrors())->withInput();
            }

            try {
                $payload = [
                    'name'    => trim((string) ($data['name'] ?? '')),
                    'email'   => strtolower(trim((string) ($data['email'] ?? ''))),
                    'subject' => trim((string) ($data['subject'] ?? '')),
                    'message' => trim((string) ($data['message'] ?? '')),
                ];

                // Save to database
                $model->save($payload);

                // Send notification email to admin
                $this->sendAdminNotification($payload);

                if ($this->shouldSendUserConfirmation()) {
                    $this->sendUserConfirmation($payload);
                }

                return redirect()->back()->with('success', 'Thank you for your message! We\'ll get back to you soon.');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Something went wrong. Please try again later.');
            }
        }

        return redirect()->to('/contact');
    }

    /**
     * Detect obvious bot submissions using honeypot and submit speed.
     */
    private function isSpamSubmission(): bool
    {
        // Honeypot: real users should never fill this hidden field.
        $honeypotValue = (string) $this->request->getPost('website');
        if ($honeypotValue !== '') {
            log_message('warning', 'Contact form blocked by honeypot from IP: {ip}', ['ip' => (string) $this->request->getIPAddress()]);
            return true;
        }

        // Time trap: bot submissions are typically near-instant.
        $startedAt = (int) $this->request->getPost('form_started_at');
        if ($startedAt <= 0) {
            return true;
        }

        $elapsed = time() - $startedAt;
        if ($elapsed < 3 || $elapsed > 7200) {
            log_message('warning', 'Contact form blocked by timing check from IP: {ip} ({elapsed}s)', [
                'ip'      => (string) $this->request->getIPAddress(),
                'elapsed' => $elapsed,
            ]);
            return true;
        }

        return false;
    }

    /**
     * Limit contact submissions per IP to reduce burst spam.
     */
    private function isRateLimited(): bool
    {
        $throttler = Services::throttler();
        $ipHash    = md5((string) $this->request->getIPAddress());
        $key       = 'contact_form_' . $ipHash;

        // Allow up to 3 submissions per minute per IP.
        return !$throttler->check($key, 3, MINUTE);
    }

    /**
     * Send notification email to admin when someone submits contact form
     */
    private function sendAdminNotification(array $contactData)
    {
        $email = \Config\Services::email();

        // Configure email settings
        $email->setFrom('noreply@khybersoft.com', 'Khybersoft');
        $email->setTo('ahsankhan50@gmail.com'); // Change this to your email
        $email->setReplyTo($contactData['email'], $contactData['name']);
        $email->setSubject('New Contact Form Submission: ' . $contactData['subject']);

        // Create email body
        $emailBody = "
            <h2>New Contact Form Submission</h2>
            <p><strong>Name:</strong> {$contactData['name']}</p>
            <p><strong>Email:</strong> {$contactData['email']}</p>
            <p><strong>Subject:</strong> {$contactData['subject']}</p>
            <hr>
            <h3>Message:</h3>
            <p>" . nl2br(htmlspecialchars($contactData['message'])) . "</p>
            <hr>
            <p><strong>Submitted on:</strong> " . date('Y-m-d H:i:s') . "</p>
            <p>You can reply to this contact at <a href='mailto:{$contactData['email']}'>{$contactData['email']}</a></p>
        ";

        $email->setMessage($emailBody);

        if (!$email->send()) {
            // Log the error but don't break the user experience
            log_message('error', 'Failed to send contact notification email: ' . $email->printDebugger());
        }

        return true;
    }

    /**
     * Autoreplies to arbitrary form submitters can generate backscatter bounces.
     */
    private function shouldSendUserConfirmation(): bool
    {
        return (bool) env('email.sendFormAutoReply', false);
    }

    /**
     * Send confirmation email to user when they submit contact form
     */
    private function sendUserConfirmation(array $contactData)
    {
        $email = \Config\Services::email();

        // Configure email settings
        $email->setFrom('noreply@khybersoft.com', 'Khybersoft');
        $email->setTo($contactData['email']);
        $email->setSubject('We received your message - Khybersoft');

        // Create email body
        $emailBody = "
            <h2>Thank you for reaching out!</h2>
            <p>Hi {$contactData['name']},</p>
            <p>We have received your message and appreciate you contacting us. Our team will review your inquiry and get back to you as soon as possible.</p>
            <hr>
            <h3>Your Message Details:</h3>
            <p><strong>Subject:</strong> {$contactData['subject']}</p>
            <p><strong>Message:</strong></p>
            <p>" . nl2br(htmlspecialchars($contactData['message'])) . "</p>
            <hr>
            <p>If you have any additional information to share, feel free to reply to this email.</p>
            <p><strong>Best regards,</strong><br>
            Khybersoft Team</p>
        ";

        $email->setMessage($emailBody);

        if (!$email->send()) {
            // Log the error but don't break the user experience
            log_message('error', 'Failed to send user confirmation email: ' . $email->printDebugger());
        }

        return true;
    }
}
