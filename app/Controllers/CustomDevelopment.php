<?php

namespace App\Controllers;

use App\Models\CustomDevelopmentQuoteModel;

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
                // Save to database
                $model->save([
                    'name'         => $data['name'],
                    'company'      => $data['company'] ?? null,
                    'email'        => $data['email'],
                    'phone'        => $data['phone'] ?? null,
                    'project_type' => $data['project_type'],
                    'description'  => $data['description'],
                ]);

                // Send notification email to admin
                $this->sendAdminNotification($data);

                // Send confirmation email to user
                $this->sendUserConfirmation($data);

                return redirect()->back()->with('success', 'Thank you for your inquiry! We\'ll contact you within 24 hours.');
            } catch (\Exception $e) {
                log_message('error', 'Custom development quote failed: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Something went wrong. Please try again later.');
            }
        }

        return redirect()->to('/custom-development');
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
