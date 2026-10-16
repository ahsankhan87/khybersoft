<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table         = 'categories';
    protected $allowedFields = ['name', 'slug', 'description', 'sort_order'];
    protected $useTimestamps = true;
    protected $returnType    = 'array';
    protected $validationRules = ['name' => 'required|max_length[100]', 'slug' => 'required|alpha_dash|is_unique[categories.slug,id,{id}]'];
}
