<?php

namespace App\Controllers;

use App\Models\SubscriberModel;

class Home extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url']);
    }

    public function index()
    {
        // Data to pass to the view
        $data = [
            'title' => 'Khybersoft - Powerful Software Solutions',
            'meta_description' => 'Khybersoft develops cutting-edge software to automate your workflow and boost productivity.'
        ];

        // Load the view templates
        return view('layouts/header', $data)
            . view('pages/home')
            . view('layouts/footer');
    }

    public function subscribe()
    {
        // Handle the newsletter signup form submission
        if ($this->request->getMethod() === 'POST') {
            $model = new SubscriberModel();

            $data = [
                'email' => $this->request->getPost('email'),
                'name'  => $this->request->getPost('name'),
            ];

            // Basic validation
            $validation = \Config\Services::validation();
            $validation->setRules([
                'email' => 'required|valid_email|is_unique[subscribers.email]',
                'name'  => 'permit_empty|max_length[255]',
            ]);

            if (!$validation->run($data)) {
                // Return validation errors
                return redirect()->back()->with('errors', $validation->getErrors())->withInput();
            }

            try {
                $model->save($data);

                // Send notification email to admin
                $this->sendAdminNotification($data);

                // Return a success message
                return redirect()->back()->with('success', 'Thank you for subscribing! You\'ll hear from us soon.');
            } catch (\Exception $e) {
                // Handle errors (like duplicate email)
                return redirect()->back()->with('error', 'This email is already subscribed or something went wrong.');
            }
        }

        return redirect()->to('/');
    }

    /**
     * Send notification email to admin when someone subscribes
     */
    private function sendAdminNotification(array $subscriberData)
    {
        $email = \Config\Services::email();

        // Configure email settings
        $email->setFrom('noreply@khybersoft.com', 'Khybersoft');
        $email->setTo('ahsankhan50@gmail.com'); // Change this to your email
        $email->setSubject('New Subscriber: ' . ($subscriberData['name'] ?? $subscriberData['email']));

        // Create email body
        $emailBody = "
            <h2>New Newsletter Subscriber</h2>
            <p><strong>Email:</strong> {$subscriberData['email']}</p>
            <p><strong>Name:</strong> " . ($subscriberData['name'] ?? 'Not provided') . "</p>
            <p><strong>Date:</strong> " . date('Y-m-d H:i:s') . "</p>
            <hr>
            <p>You can manage all subscribers from your admin panel.</p>
        ";

        $email->setMessage($emailBody);

        if (!$email->send()) {
            // Log the error but don't break the user experience
            log_message('error', 'Failed to send subscriber notification email: ' . $email->printDebugger());
        }

        return true;
    }
}
