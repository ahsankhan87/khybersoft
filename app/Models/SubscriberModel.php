<?php

namespace App\Models;

use CodeIgniter\Model;

class SubscriberModel extends Model
{
    protected $table = 'subscribers';
    protected $primaryKey = 'id';
    protected $allowedFields = ['email', 'name', 'created_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = '';

    // Validation rules (optional, since we're validating in controller)
    protected $validationRules = [
        'email' => 'required|valid_email|is_unique[subscribers.email]',
        'name' => 'max_length[255]'
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'This email is already subscribed.'
        ]
    ];
}
