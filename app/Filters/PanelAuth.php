<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class PanelAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Session-based protection for /panel routes.
        // Login route is NOT inside the protected route group.
        if (session()->get('panel_logged_in') === true) {
            return null;
        }

        return redirect()->to('/panel/login');
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No-op
    }
}
