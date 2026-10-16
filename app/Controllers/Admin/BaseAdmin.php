<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin\AdminUserModel;
use App\Models\Admin\RoleModel;

/**
 * Base for every admin module controller: shared chrome + permission helper.
 */
abstract class BaseAdmin extends BaseController
{
    protected function chrome(array $data = []): array
    {
        $user = (new AdminUserModel())->withRole((int) session()->get('admin_id'));

        return array_merge([
            'adminUser' => $user,
            'roleSlug'  => $user['role_slug'] ?? null,
            'can'       => static fn (string $perm) => (new RoleModel())->can($user['role_slug'] ?? null, $perm),
        ], $data);
    }

    protected function render(string $view, array $data = []): string
    {
        return view($view, $this->chrome($data));
    }
}
