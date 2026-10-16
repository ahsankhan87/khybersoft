<?php

namespace App\Models;

use CodeIgniter\Model;

class CareerModel extends Model
{
    protected $table          = 'careers';
    protected $allowedFields  = ['title', 'slug', 'department', 'location', 'type', 'description', 'salary_range', 'is_open'];
    protected $useTimestamps  = true;
    protected $useSoftDeletes = true;
    protected $returnType     = 'array';
}
