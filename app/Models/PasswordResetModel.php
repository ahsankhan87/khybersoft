<?php

namespace App\Models;

use CodeIgniter\Model;

class PasswordResetModel extends Model
{
    protected $table         = 'password_resets';
    protected $allowedFields = ['email', 'token_hash', 'expires_at', 'used_at'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
    protected $returnType    = 'array';

    public function issue(string $email): string
    {
        $token = bin2hex(random_bytes(32));
        $this->insert(['email' => $email, 'token_hash' => hash('sha256', $token), 'expires_at' => date('Y-m-d H:i:s', time() + 3600)]);

        return $token;
    }

    public function validateToken(string $token): ?array
    {
        return $this->where('token_hash', hash('sha256', $token))->where('used_at', null)->where('expires_at >=', date('Y-m-d H:i:s'))->first();
    }

    public function consume(int $id): void
    {
        $this->update($id, ['used_at' => date('Y-m-d H:i:s')]);
    }
}
