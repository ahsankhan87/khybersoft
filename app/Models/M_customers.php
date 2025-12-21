<?php

namespace App\Models;

use CodeIgniter\Model;

class M_customers extends Model
{
    protected $table = 'pos_customers';
    protected $allowedFields = ['name', 'email', 'phone', 'address', 'created_at']; // adjust fields as per your table
}
