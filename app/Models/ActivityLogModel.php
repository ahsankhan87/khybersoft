<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityLogModel extends Model
{
    protected $table      = 'activity_logs';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'user_id', 'user_name', 'action', 'module', 'target',
        'description', 'ip', 'user_agent', 'payload', 'created_at',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    /** Record an admin action. Never throws — logging must not break the app. */
    public static function record(string $action, string $module, string $description = '', ?string $target = null, array $payload = []): void
    {
        try {
            $user = session()->get('admin_id') ? (new \App\Models\Admin\AdminUserModel())->find(session()->get('admin_id')) : null;
            model(self::class)->insert([
                'user_id'     => $user['id'] ?? null,
                'user_name'   => $user['name'] ?? 'system',
                'action'      => $action,
                'module'      => $module,
                'target'      => $target,
                'description' => mb_substr($description, 0, 500),
                'ip'          => service('request')->IPAddress(),
                'user_agent'  => mb_substr((string) service('request')->getUserAgent()->getAgentString(), 0, 255),
                'payload'     => $payload ? json_encode($payload, JSON_UNESCAPED_UNICODE) : null,
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'ActivityLog failed: ' . $e->getMessage());
        }
    }

    public function recent(int $limit = 20): array
    {
        return $this->orderById('desc')->limit($limit)->findAll();
    }
}
