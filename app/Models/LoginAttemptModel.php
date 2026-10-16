<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginAttemptModel extends Model
{
    protected $table         = 'login_attempts';
    protected $allowedFields = ['email', 'ip', 'success', 'user_agent'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
    protected $returnType    = 'array';

    public function recentFailures(string $ip, int $minutes = 10): int
    {
        return $this->where('ip', $ip)
                    ->where('success', 0)
                    ->where('created_at >=', date('Y-m-d H:i:s', time() - $minutes * 60))
                    ->countAllResults();
    }
}
