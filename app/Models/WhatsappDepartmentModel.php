<?php

namespace App\Models;

use CodeIgniter\Model;

class WhatsappDepartmentModel extends Model
{
    protected $table         = 'whatsapp_departments';
    protected $allowedFields = ['name', 'number', 'greeting', 'is_default'];
    protected $useTimestamps = true;
    protected $returnType    = 'array';

    public function defaultOne(): ?array
    {
        return $this->where('is_default', 1)->first() ?? $this->orderBy('id')->first();
    }

    public function clickUrl(array $dept, string $message = ''): string
    {
        $msg = $message !== '' ? $message : (string) ($dept['greeting'] ?? 'Hello Khybersoft!');

        return 'https://wa.me/' . preg_replace('/\D/', '', $dept['number']) . '?text=' . rawurlencode($msg);
    }
}
