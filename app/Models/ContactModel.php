<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactModel extends Model
{
    protected $table = 'contacts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'email', 'subject', 'message', 'created_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = ''; // Not using updated_at for contact messages

    protected $validationMessages = [
        'name' => [
            'required'   => 'Your name is required.',
            'min_length' => 'Your name must be at least 3 characters long.',
            'max_length' => 'Your name cannot exceed 255 characters.',
        ],
        'email' => [
            'required'    => 'Your email address is required.',
            'valid_email' => 'Please enter a valid email address.',
        ],
        'subject' => [
            'required'   => 'A subject is required.',
            'min_length' => 'The subject must be at least 5 characters long.',
            'max_length' => 'The subject cannot exceed 255 characters.',
        ],
        'message' => [
            'required'   => 'A message is required.',
            'min_length' => 'Your message must be at least 10 characters long.',
        ],
    ];
}
