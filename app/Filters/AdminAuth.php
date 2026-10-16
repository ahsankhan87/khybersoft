<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * DB-backed admin authentication + role gate.
 * Usage: 'filter' => 'adminauth'          → any logged-in admin
 *        'filter' => 'adminauth:products' → requires `products` permission
 */
class AdminAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $userId  = $session->get('admin_id');

        // Remember-me fallback via hashed cookie token.
        if (! $userId) {
            $cookie = $request->getCookie('admin_remember');
            if (is_string($cookie) && $cookie !== '') {
                $users = model(\App\Models\Admin\AdminUserModel::class);
                if ($user = $users->where('remember_token', hash('sha256', $cookie))->where('is_active', 1)->first()) {
                    $session->set('admin_id', $user['id']);
                    $userId = $user['id'];
                }
            }
        }

        if (! $userId) {
            return redirect()->to('/admin/login');
        }

        // Permission check for route groups like ['filter' => 'adminauth:settings.manage']
        if ($arguments) {
            $user = model(\App\Models\Admin\AdminUserModel::class)->withRole((int) $userId);
            if (! $user) {
                $session->remove('admin_id');

                return redirect()->to('/admin/login');
            }
            $roleModel = new \App\Models\Admin\RoleModel();
            foreach ((array) $arguments as $permission) {
                if (! $roleModel->can($user['role_slug'] ?? null, $permission)) {
                    throw \CodeIgniter\Router\Exceptions\RouterException::forMissingMethod('Forbidden', 'AdminAuth');
                }
            }
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // no-op
    }
}
