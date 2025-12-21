<?php

namespace App\Controllers;

class CustomDevelopment extends BaseController
{
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
        if ($this->request->getMethod() === 'post') {
            // Process the quote request
            return redirect()->back()->with('success', 'Thank you for your inquiry! We\'ll contact you within 24 hours.');
        }

        return redirect()->to('/custom-development');
    }
}
