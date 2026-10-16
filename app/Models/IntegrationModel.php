<?php

namespace App\Models;

use CodeIgniter\Model;

class IntegrationModel extends Model
{
    protected $table            = 'integrations';
    protected $allowedFields    = ['name', 'slug', 'logo', 'icon', 'description', 'url', 'sort_order', 'is_active'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    protected $returnType       = 'array';

    public function active(int $limit = 0): array
    {
        $q = $this->where('is_active', 1)->orderBy('sort_order');
        return $limit ? $q->limit($limit)->findAll() : $q->findAll();
    }
}
