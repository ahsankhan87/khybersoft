<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Lightweight tutorials table used by product pages & help-center preview.
 * Full Help Center module (categories, search, view counts) lands in Phase 6.
 */
class TutorialModel extends Model
{
    protected $table            = 'tutorials';
    protected $returnType       = 'array';
    protected $allowedFields    = ['product_id', 'title', 'slug', 'type', 'video_url', 'article_body', 'thumbnail', 'duration_sec', 'sort_order', 'is_published'];
    protected $useTimestamps    = true;

    public function active(int $limit = 3, ?int $productId = null): array
    {
        $q = $this->where('is_published', 1);
        if ($productId !== null) {
            $q = $this->where('is_published', 1)->where('product_id', $productId);
        }

        return $q->orderBy('sort_order')->orderBy('id', 'DESC')->limit($limit)->findAll();
    }
}
