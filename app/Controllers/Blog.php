<?php

namespace App\Controllers;

class Blog extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Blog - Khybersoft',
            'meta_description' => 'Read the latest articles, tutorials, and news from Khybersoft about software development and technology.'
        ];

        return view('layouts/header', $data)
            . view('blog')
            . view('layouts/footer');
    }
}
