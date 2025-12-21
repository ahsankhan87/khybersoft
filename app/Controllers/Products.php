<?php

namespace App\Controllers;

class Products extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Our Products - Khybersoft',
            'meta_description' => 'Discover Khybersoft\'s powerful software solutions designed to streamline your workflow and boost productivity.'
        ];

        return view('layouts/header', $data)
            . view('pages/products')
            . view('layouts/footer');
    }
}
