<?php

namespace App\Controllers;

class Pricing extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Pricing Plans - Khybersoft',
            'meta_description' => 'Affordable pricing plans for Khybersoft products. Choose the plan that fits your needs with our flexible options.'
        ];

        return view('layouts/header', $data)
            . view('pricing')
            . view('layouts/footer');
    }
}
