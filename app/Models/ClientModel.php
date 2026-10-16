<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table            = 'clients';
    protected $allowedFields    = ['company_name', 'logo', 'website', 'industry', 'sort_order', 'is_active'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    protected $returnType       = 'array';

    public function active(int $limit = 0): array
    {
        $q = $this->where('is_active', 1)->orderBy('sort_order');
        return $limit ? $q->limit($limit)->findAll() : $q->findAll();
    }

    /** Clients whose industry matches a product category (logo strip on product pages). */
    public function forIndustry(?string $industry, int $limit = 8): array
    {
        if ($industry) {
            $rows = $this->where('is_active', 1)->like('industry', $industry)
                         ->orderBy('sort_order')->limit($limit)->findAll();
            if ($rows) {
                return $rows;
            }
        }

        return $this->active($limit);
    }
}
