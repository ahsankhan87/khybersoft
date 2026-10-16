<?php

namespace App\Models;

use CodeIgniter\Model;

class TutorialCategoryModel extends Model
{
    protected $table         = 'tutorial_categories';
    protected $allowedFields = ['name', 'slug', 'icon', 'sort_order'];
    protected $useTimestamps = true;
    protected $returnType    = 'array';
}
