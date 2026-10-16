<?php

namespace App\Models;

use CodeIgniter\Model;

class SuccessStoryModel extends Model
{
    protected $table            = 'success_stories';
    protected $allowedFields    = [
        'headline', 'slug', 'customer_name', 'role', 'company', 'industry',
        'photo', 'logo', 'hero_image', 'quote', 'challenge', 'solution',
        'results', 'metrics', 'product_id', 'is_featured', 'status',
    ];
    protected $useTimestamps  = true;
    protected $createdField   = 'created_at';
    protected $updatedField   = 'updated_at';
    protected $useSoftDeletes = true;
    protected $deletedField   = 'deleted_at';
    protected $returnType     = 'array';

    public function featured(int $limit = 3): array
    {
        return $this->where('status', 'published')
                    ->orderBy('is_featured', 'DESC')
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    public function countPublished(): int
    {
        return $this->where('status', 'published')->countAllResults();
    }
}
