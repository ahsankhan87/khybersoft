<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table         = 'roles';
    protected $allowedFields = ['name', 'slug', 'permissions'];
    protected $useTimestamps = true;
    protected $casters       = ['permissions' => 'json'];

    /** Built-in permission matrix per role slug. Roles table can override. */
    public static function defaultPermissions(): array
    {
        return [
            'super_admin'  => ['*'],
            'admin'        => ['dashboard', 'products', 'blog', 'media', 'leads', 'subscribers', 'pages', 'menus', 'testimonials', 'clients', 'tutorials', 'settings.read'],
            'editor'       => ['dashboard', 'blog', 'media', 'pages', 'testimonials', 'tutorials'],
            'marketing'    => ['dashboard', 'leads', 'subscribers', 'blog.read', 'testimonials'],
        ];
    }

    public function can(?string $roleSlug, string $permission): bool
    {
        if ($roleSlug === null) {
            return false;
        }
        $perms = self::defaultPermissions()[$roleSlug] ?? [];
        return in_array('*', $perms, true) || in_array($permission, $perms, true);
    }
}
