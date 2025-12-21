<?php

namespace App\Controllers;

use App\Models\ContactModel;


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
                // Save to database
                $model->save($data);

                // Send notification email to admin
                $this->sendAdminNotification($data);

                // Send confirmation email to user
                $this->sendUserConfirmation($data);

                return redirect()->back()->with('success', 'Thank you for your message! We\'ll get back to you soon.');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Something went wrong. Please try again later.');
            }
        }

        return redirect()->to('/contact');
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
