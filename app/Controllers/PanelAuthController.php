<?php

namespace App\Controllers;

class PanelAuthController extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url']);
    }

    public function login()
    {
        $data = [
            'title' => 'Panel Login - Khybersoft',
            'meta_description' => 'Login to the admin panel.',
        ];

        if ($this->request->getMethod() === 'POST') {
            $validation = \Config\Services::validation();
            $validation->setRules([
                'username' => 'required|max_length[255]',
                'password' => 'required|max_length[255]',
            ]);

            $post = $this->request->getPost();

            if (!$validation->run($post)) {
                return redirect()->back()->with('errors', $validation->getErrors())->withInput();
            }

            $expectedUser = (string) (env('panel.user') ?? 'admin');
            $expectedPass = (string) (env('panel.pass') ?? 'admin123');

            $username = (string) ($post['username'] ?? '');
            $password = (string) ($post['password'] ?? '');

            if ($username === $expectedUser && $password === $expectedPass) {
                session()->set([
                    'panel_logged_in' => true,
                    'panel_user' => $username,
                ]);

                return redirect()->to('/panel');
            }

            return redirect()->back()->with('error', 'Invalid username or password.')->withInput();
        }

        return view('panel/layouts/header', $data)
            . view('panel/login', $data)
            . view('panel/layouts/footer');
    }

    public function logout()
    {
        session()->remove(['panel_logged_in', 'panel_user']);

        return redirect()->to('/panel/login');
    }
}
