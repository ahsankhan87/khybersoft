<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomDevelopmentQuoteModel extends Model
{
    protected $table = 'custom_development_quotes';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'name',
        'company',
        'email',
        'phone',
        'project_type',
        'description',
        'created_at',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = '';
}
