<?php

namespace App\Models;

use CodeIgniter\Model;

class LeadModel extends Model
{
    protected $table          = 'leads';
    protected $allowedFields  = ['type', 'name', 'company', 'email', 'phone', 'subject', 'message', 'product_id', 'plan_id', 'extra', 'source_page', 'utm', 'ip_hash', 'status', 'assigned_to', 'replied_at', 'legacy_table', 'legacy_id'];
    protected $useSoftDeletes = true;
    protected $useTimestamps  = true;
    protected $casters        = ['extra' => 'json', 'utm' => 'json'];

    protected $validationRules = [
        'email' => 'required|valid_email|max_length[150]',
        'type'  => 'required|in_list[contact,quote,demo,trial,other]',
    ];

    public function countNew(): int
    {
        return $this->where('status', 'new')->countAllResults();
    }

    public function markStatus(int $id, string $status): bool
    {
        $data = ['status' => $status];
        if ($status === 'replied') {
            $data['replied_at'] = date('Y-m-d H:i:s');
        }
        return $this->update($id, $data);
    }
}
