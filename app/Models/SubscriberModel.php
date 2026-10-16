<?php

namespace App\Models;

use CodeIgniter\Model;

class SubscriberModel extends Model
{
    protected $table            = 'subscribers';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['email', 'name', 'status', 'confirm_token', 'unsub_token', 'confirmed_at', 'source'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $validationRules = [
        'email'  => 'required|valid_email|max_length[255]',
        'name'   => 'permit_empty|max_length[255]',
        'status' => 'permit_empty|in_list[pending,confirmed,unsubscribed]',
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'This email is already subscribed.',
        ],
    ];

    /** Confirmed-only query for sending. */
    public function confirmed()
    {
        return $this->where('status', 'confirmed');
    }

    public function findByToken(string $field, string $token): ?array
    {
        if (! in_array($field, ['confirm_token', 'unsub_token'], true)) {
            return null;
        }

        return $this->where($field, $token)->first();
    }
}
