<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductVersionModel extends Model
{
    protected $table         = 'product_versions';
    protected $allowedFields = ['product_id', 'version', 'release_date', 'highlights', 'breaking_changes', 'download_url', 'is_latest'];
    protected $useTimestamps = true;
    protected $returnType    = 'array';
}
