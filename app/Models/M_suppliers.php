<?php

namespace App\Models;

use CodeIgniter\Model;

class M_suppliers extends Model
{
    protected $table = 'pos_suppliers';
    protected $allowedFields = ['name', 'email', 'phone', 'address', 'created_at'];
}
