<?php

namespace App\Models;

use CodeIgniter\Model;

class ServiceModel extends Model
{
    protected $table         = 'services';
    protected $allowedFields = ['name', 'slug', 'icon', 'summary', 'description', 'sort_order', 'is_active'];
    protected $useTimestamps = true;
    protected $returnType    = 'array';
}
