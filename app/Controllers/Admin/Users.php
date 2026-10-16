<?php

namespace App\Controllers\Admin;

use App\Libraries\Totp;
use App\Models\ActivityLogModel;
use App\Models\Admin\AdminUserModel;
use App\Models\Admin\RoleModel;
use App\Models\LoginAttemptModel;

class Users extends BaseAdmin
{
    public function index()
    {
        if ($resp = $this->guard('users')) { return $resp; }

        return $this->render('admin/users/index', [
            'title' => 'Admin Users',
            'users' => (new AdminUserModel())->withRole()->orderBy('id')->findAll(),
            'roles' => (new RoleModel())->orderBy('name')->findAll(),
        ]);
    }

    public function store()
    {
        if ($resp = $this->guard('users')) { return $resp; }
        $rules = [
            'name'  => 'required|max_length[120]',
            'email' => 'required|valid_email|is_unique[admin_users.email]',
            'role_id' => 'required|integer',
            'password' => 'required|min_length[8]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $model = new AdminUserModel();
        $id = $model->insert([
            'name'     => $this->request->getPost('name'),
            'email'    => strtolower((string) $this->request->getPost('email')),
            'role_id'  => (int) $this->request->getPost('role_id'),
            'password' => $this->request->getPost('password'), // model hashes it
            'status'   => 'active',
        ]);
        ActivityLogModel::record('create', 'users', 'Created admin user', $this->request->getPost('email'));

        return redirect()->to('/admin/users')->with('success', 'User created.');
    }

    public function update(int $id)
    {
        if ($resp = $this->guard('users')) { return $resp; }
        $model = new AdminUserModel();
        $data  = [
            'name'    => $this->request->getPost('name'),
            'email'   => strtolower((string) $this->request->getPost('email')),
            'role_id' => (int) $this->request->getPost('role_id'),
            'status'  => (string) $this->request->getPost('status'),
        ];
        if ((string) $this->request->getPost('password') !== '') {
            $data['password'] = $this->request->getPost('password');
        }
        $model->update($id, $data);
        ActivityLogModel::record('update', 'users', "Updated user #{$id}", $data['email']);

        return redirect()->to('/admin/users')->with('success', 'User updated.');
    }

    public function delete(int $id)
    {
        if ($resp = $this->guard('users')) { return $resp; }
        if ($id === (int) session()->get('admin_id')) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }
        (new AdminUserModel())->delete($id);
        ActivityLogModel::record('delete', 'users', "Deleted user #{$id}");

        return redirect()->to('/admin/users')->with('success', 'User deleted.');
    }

    /** Super-admin only: toggle 2FA for a user (resets secret when enabling). */
    public function reset2fa(int $id)
    {
        if ($resp = $this->guard('users')) { return $resp; }
        $model = new AdminUserModel();
        $user  = $model->find($id);
        if (! $user) {
            return redirect()->back()->with('error', 'User not found.');
        }
        $enabled = (int) ($user['two_factor_enabled'] ?? 0);
        if ($enabled) {
            $model->update($id, ['two_factor_enabled' => 0, 'totp_secret' => null, 'backup_codes' => null]);
            ActivityLogModel::record('2fa-off', 'users', "Disabled 2FA for user #{$id}");

            return redirect()->to('/admin/users')->with('success', '2FA disabled for this user.');
        }
        $model->update($id, ['totp_secret' => Totp::generateSecret()]);
        ActivityLogModel::record('2fa-reset', 'users', "Reset 2FA secret for user #{$id}");

        return redirect()->to('/admin/users')->with('success', '2FA enabled — user must scan the QR on next login.');
    }

    /** Current user's own profile + password. */
    public function profile()
    {
        return $this->render('admin/users/profile', [
            'title' => 'My Profile',
            'user'  => (new AdminUserModel())->withRole((int) session()->get('admin_id')),
        ]);
    }

    public function saveProfile()
    {
        $id    = (int) session()->get('admin_id');
        $model = new AdminUserModel();
        $data  = ['name' => $this->request->getPost('name')];
        if ((string) $this->request->getPost('new_password') !== '') {
            $rules = ['new_password' => 'strong_password[minLength][8]'];
            if (! $this->validate($rules)) {
                return redirect()->back()->with('errors', $this->validator->getErrors());
            }
            $data['password'] = $this->request->getPost('new_password');
        }
        $model->update($id, $data);
        ActivityLogModel::record('profile', 'users', 'Updated own profile');

        return redirect()->to('/admin/profile')->with('success', 'Profile saved.');
    }

    /** Enable TOTP 2FA for the signed-in user: show QR setup page. */
    public function twoFactorSetup()
    {
        if ($resp = $this->guard('dashboard')) { return $resp; }
        $model = new AdminUserModel();
        $user  = $model->find(session()->get('admin_id'));
        if (empty($user['totp_secret'])) {
            $model->update($user['id'], ['totp_secret' => Totp::generateSecret()]);
            $user['totp_secret'] = Totp::generateSecret();
        }

        return $this->render('admin/users/twofactor', [
            'title' => 'Two-Factor Authentication',
            'uri'   => Totp::provisioningUri($user['totp_secret'], $user['email']),
            'secret'=> $user['totp_secret'],
            'enabled' => (int) ($user['two_factor_enabled'] ?? 0),
        ]);
    }

    public function twoFactorEnable()
    {
        $model = new AdminUserModel();
        $user  = $model->find(session()->get('admin_id'));
        $code  = (string) $this->request->getPost('code');
        if (! Totp::verify((string) $user['totp_secret'], $code)) {
            return redirect()->back()->with('error', 'Invalid code — try again within 30s window.');
        }
        $backup = Totp::generateBackupCodes();
        $model->update($user['id'], ['two_factor_enabled' => 1, 'backup_codes' => json_encode($backup['hashed'])]);
        ActivityLogModel::record('2fa-on', 'users', 'Enabled 2FA');

        return redirect()->to('/admin/users/two-factor/setup')->with('success', '2FA enabled! Backup codes: ' . implode(', ', $backup['plain']));
    }

    public function twoFactorDisable()
    {
        $model = new AdminUserModel();
        $model->update(session()->get('admin_id'), ['two_factor_enabled' => 0, 'totp_secret' => null, 'backup_codes' => null]);
        ActivityLogModel::record('2fa-off', 'users', 'Disabled 2FA');

        return redirect()->to('/admin/profile')->with('success', '2FA disabled.');
    }

    /** Security tab data: login attempts + online users (last 15 min activity). */
    public function security()
    {
        if ($resp = $this->guard('users')) { return $resp; }

        return $this->render('admin/users/security', [
            'title'    => 'Security Log',
            'attempts' => (new LoginAttemptModel())->orderBy('id', 'desc')->limit(100)->findAll(),
            'online'   => (new AdminUserModel())->where('last_activity_at >=', date('Y-m-d H:i:s', time() - 900))->findAll(),
        ]);
    }
}
