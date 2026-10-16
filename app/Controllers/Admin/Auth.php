<?php

namespace App\Controllers\Admin;

use App\Libraries\Totp;
use App\Models\ActivityLogModel;
use App\Models\Admin\AdminUserModel;
use App\Models\LoginAttemptModel;
use App\Models\PasswordResetModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    protected $helpers = ['form'];

    private const MAX_ATTEMPTS = 5;
    private const LOCK_MINUTES = 15;

    public function loginForm()
    {
        if (session()->get('admin_id')) {
            return redirect()->to('/admin');
        }

        return view('admin/auth/login', ['title' => 'Admin Login']);
    }

    public function attemptLogin()
    {
        $email = strtolower(trim((string) $this->request->getPost('email')));
        $ip    = service('request')->IPAddress();
        $attempts = new LoginAttemptModel();

        // Throttle: 5 failures → 15-minute lockout per IP
        if ($attempts->recentFailures($ip) >= self::MAX_ATTEMPTS) {
            return redirect()->back()->withInput()->with('error', 'Too many failed attempts. Try again in ' . self::LOCK_MINUTES . ' minutes.');
        }

        $user = (new AdminUserModel())->where('email', $email)->first();
        $ok   = $user && $user['status'] === 'active' && password_verify((string) $this->request->getPost('password'), $user['password_hash']);

        $attempts->insert(['email' => $email, 'ip' => $ip, 'success' => $ok ? 1 : 0, 'user_agent' => mb_substr((string) $this->request->getUserAgent()->getAgentString(), 0, 255)]);

        if (! $ok) {
            return redirect()->back()->withInput()->with('error', 'Invalid email or password.');
        }

        // 2FA challenge?
        if ((int) ($user['two_factor_enabled'] ?? 0) === 1) {
            session()->set('2fa_user_id', $user['id']);
            session()->remove('admin_id');

            return redirect()->to('/admin/login/2fa');
        }

        return $this->finishLogin($user);
    }

    public function twoFactorForm()
    {
        if (! session()->get('2fa_user_id')) {
            return redirect()->to('/admin/login');
        }

        return view('admin/auth/twofactor', ['title' => 'Two-Factor']);
    }

    public function verifyTwoFactor()
    {
        $userId = session()->get('2fa_user_id');
        if (! $userId) {
            return redirect()->to('/admin/login');
        }
        $model = new AdminUserModel();
        $user  = $model->find($userId);
        if (! $user) {
            return redirect()->to('/admin/login');
        }

        $code = trim((string) $this->request->getPost('code'));
        if (Totp::verify((string) $user['totp_secret'], $code)) {
            return $this->finishLogin($user);
        }

        // backup code?
        $hashed = json_decode((string) ($user['backup_codes'] ?? '[]'), true) ?: [];
        $idx    = Totp::matchBackupCode($code, $hashed);
        if ($idx !== null) {
            unset($hashed[$idx]);
            $model->update($user['id'], ['backup_codes' => json_encode(array_values($hashed))]);
            ActivityLogModel::record('2fa-backup', 'auth', 'Login with backup code', $user['email']);

            return $this->finishLogin($user);
        }

        return redirect()->back()->with('error', 'Invalid or expired code.');
    }

    private function finishLogin(array $user)
    {
        session()->remove('2fa_user_id');
        session()->set([
            'admin_id'    => (int) $user['id'],
            'admin_name'  => $user['name'],
            'admin_email' => $user['email'],
            'admin_role'  => (new \App\Models\Admin\RoleModel())->find($user['role_id'])['slug'] ?? '',
        ]);
        (new AdminUserModel())->update($user['id'], ['last_login_at' => date('Y-m-d H:i:s'), 'last_activity_at' => date('Y-m-d H:i:s')]);
        ActivityLogModel::record('login', 'auth', 'Signed in', $user['email']);

        return redirect()->to('/admin');
    }

    public function logout()
    {
        if (session()->get('admin_id')) {
            ActivityLogModel::record('logout', 'auth', 'Signed out', (string) session()->get('admin_email'));
        }
        session()->destroy();

        return redirect()->to('/admin/login');
    }

    public function forgotForm()
    {
        return view('admin/auth/forgot', ['title' => 'Reset Password']);
    }

    public function sendReset()
    {
        $email = strtolower(trim((string) $this->request->getPost('email')));
        $user  = (new AdminUserModel())->where('email', $email)->first();
        // Always show success to avoid user enumeration.
        if ($user) {
            $token = (new PasswordResetModel())->issue($email);
            $link  = base_url('/admin/reset-password/' . $token);
            try {
                service('email')->initialize()
                    ->setFrom([setting('noreply_email') ?: 'no-reply@khybersoft.com' => setting('site_name') ?: 'Khybersoft'])
                    ->setTo($email)
                    ->setSubject('Reset your Khybersoft admin password')
                    ->setMessage("Someone requested a password reset for {$email}.\n\nUse this link within 1 hour:\n{$link}\n\nIf you did not request this, ignore this email.")
                    ->send();
            } catch (\Throwable $e) {
                log_message('error', 'Password reset mail failed: ' . $e->getMessage());
            }
        }

        return redirect()->to('/admin/login/forgot')->with('success', 'If that email exists, a reset link has been sent.');
    }

    public function resetForm(string $token)
    {
        $reset = (new PasswordResetModel())->validateToken($token);
        if (! $reset) {
            return redirect()->to('/admin/login/forgot')->with('error', 'Reset link is invalid or expired.');
        }

        return view('admin/auth/reset', ['title' => 'Choose New Password', 'token' => $token, 'email' => $reset['email']]);
    }

    public function doReset()
    {
        $token = (string) $this->request->getPost('token');
        $reset = (new PasswordResetModel())->validateToken($token);
        if (! $reset) {
            return redirect()->to('/admin/login/forgot')->with('error', 'Reset link is invalid or expired.');
        }
        if (! $this->validate(['password' => 'required|strong_password[minLength][8]'])) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }
        $model = new AdminUserModel();
        $user  = $model->where('email', $reset['email'])->first();
        if ($user) {
            $model->update($user['id'], ['password' => $this->request->getPost('password')]);
            (new PasswordResetModel())->consume((int) $reset['id']);
            ActivityLogModel::record('reset', 'auth', 'Password reset completed', $reset['email']);
        }

        return redirect()->to('/admin/login')->with('success', 'Password updated — sign in below.');
    }
}
