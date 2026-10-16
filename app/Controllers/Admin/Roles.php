<?php

namespace App\Controllers\Admin;

use App\Models\ActivityLogModel;
use App\Models\Admin\AdminUserModel;
use App\Models\Admin\RoleModel;

class Roles extends BaseAdmin
{
    public const ALL_PERMISSIONS = ['dashboard','products','blog','media','leads','subscribers','pages','menus','testimonials','clients','tutorials','faqs','business','integrations','quotes','demos','versions','users','roles','activity','settings','spam','whatsapp','redirects','announcements'];

    public function index()
    {
        if ($resp = $this->guard('roles')) { return $resp; }

        return $this->render('admin/roles/index', [
            'title'       => 'Roles & Permissions',
            'roles'       => (new RoleModel())->orderBy('id')->findAll(),
            'permissions' => self::ALL_PERMISSIONS,
            'defaults'    => RoleModel::defaultPermissions(),
            'userCounts'  => array_count_values(array_column((new AdminUserModel())->select('role_id')->findAll(), 'role_id')),
        ]);
    }

    public function save(?int $id = null)
    {
        if ($resp = $this->guard('roles')) { return $resp; }
        $name = trim((string) $this->request->getPost('name'));
        if ($name === '') {
            return redirect()->back()->with('error', 'Role name is required.');
        }
        $perms = (array) $this->request->getPost('permissions');
        $perms = array_values(array_intersect($perms, self::ALL_PERMISSIONS));
        $model = new RoleModel();
        $data  = ['name' => $name, 'slug' => trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($name)), '-'), 'permissions' => $perms];
        if ($id) {
            $model->update($id, $data);
            ActivityLogModel::record('update', 'roles', "Role #{$id} updated");
        } else {
            $model->insert($data);
            ActivityLogModel::record('create', 'roles', "Role '{$name}' created");
        }

        return redirect()->to('/admin/roles')->with('success', 'Role saved.');
    }

    public function delete(int $id)
    {
        if ($resp = $this->guard('roles')) { return $resp; }
        if ((new AdminUserModel())->where('role_id', $id)->countAllResults() > 0) {
            return redirect()->back()->with('error', 'Cannot delete: users still assigned to this role.');
        }
        (new RoleModel())->delete($id);
        ActivityLogModel::record('delete', 'roles', "Role #{$id} deleted");

        return redirect()->to('/admin/roles')->with('success', 'Role deleted.');
    }
}
