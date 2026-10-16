<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class AdminUserModel extends Model
{
    protected $table            = 'admin_users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['name', 'email', 'password_hash', 'role_id', 'avatar', 'remember_token', 'is_active', 'last_login_at', 'totp_secret', 'two_factor_enabled', 'backup_codes', 'last_activity_at'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    protected $deletedField     = 'deleted_at';

    protected $validationRules = [
        'email'    => 'required|valid_email|is_unique[admin_users.email,id,{id}]',
        'name'     => 'required|max_length[100]',
        'role_id'  => 'permit_empty|integer',
        'is_active'=> 'permit_empty|in_list[0,1]',
    ];

    /** Hash password automatically when provided in plain text via save(). */
    public function createUser(string $name, string $email, string $plainPassword, ?int $roleId = null): bool|int
    {
        return $this->insert([
            'name'          => $name,
            'email'         => $email,
            'password_hash' => password_hash($plainPassword, PASSWORD_DEFAULT),
            'role_id'       => $roleId,
            'is_active'     => 1,
        ]);
    }

    public function findByEmail(string $email): ?array
    {
        return $this->where('email', $email)->first();
    }

    public function verifyPassword(array $user, string $password): bool
    {
        return isset($user['password_hash']) && password_verify($password, $user['password_hash']);
    }

    public function needsRehash(array $user): bool
    {
        return password_needs_rehash($user['password_hash'] ?? '', PASSWORD_DEFAULT);
    }

    public function withRole(int $id): ?array
    {
        return $this->select('admin_users.*, roles.name AS role_name, roles.slug AS role_slug, roles.permissions')
            ->join('roles', 'roles.id = admin_users.role_id', 'left')
            ->find($id);
    }
}
