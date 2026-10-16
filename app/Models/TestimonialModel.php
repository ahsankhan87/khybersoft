<?php

namespace App\Models;

use CodeIgniter\Model;

class TestimonialModel extends Model
{
    protected $table            = 'testimonials';
    protected $allowedFields    = [
        'quote', 'name', 'role', 'company', 'photo', 'company_logo', 'product_id',
        'rating', 'source', 'is_featured', 'status', 'sort_order',
    ];
    protected $useTimestamps  = true;
    protected $createdField   = 'created_at';
    protected $updatedField   = 'updated_at';
    protected $useSoftDeletes = true;
    protected $deletedField   = 'deleted_at';
    protected $returnType     = 'array';

    public function featured(int $limit = 8): array
    {
        return $this->where('status', 'approved')
                    ->orderBy('is_featured', 'DESC')
                    ->orderBy('sort_order')
                    ->limit($limit)
                    ->findAll();
    }

    /** Approved testimonials tied to a product (falls back to featured ones). */
    public function forProduct(int $productId, int $limit = 3): array
    {
        $rows = $this->where('status', 'approved')
                     ->where('product_id', $productId)
                     ->orderBy('is_featured', 'DESC')
                     ->orderBy('sort_order')
                     ->limit($limit)
                     ->findAll();

        if (count($rows) < $limit) {
            $exclude = array_column($rows, 'id');
            $fill    = $this->where('status', 'approved')
                            ->where('product_id IS NULL')
                            ->orderBy('is_featured', 'DESC')
                            ->limit($limit - count($rows))
                            ->findAll();
            $rows = array_merge($rows, $fill);
        }

        return $rows;
    }

    /** Testimonials from clients in a given industry (via linked success stories / company match). */
    public function forIndustry(?string $industry, int $limit = 2): array
    {
        if (! $industry) {
            return $this->featured($limit);
        }

        return $this->where('status', 'approved')
                    ->groupStart()->like('company', $industry)->orLike('role', $industry)->groupEnd()
                    ->limit($limit)
                    ->findAll() ?: $this->featured($limit);
    }
}
