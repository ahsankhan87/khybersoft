<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'category_id', 'name', 'slug', 'tagline', 'description', 'long_description', 'icon', 'color',
        'hero_image', 'top_features', 'demo_url', 'video_url', 'brochure_url', 'docs_url',
        'pricing_type', 'users_count', 'rating_avg', 'rating_count',
        'seo_title', 'seo_description', 'og_image', 'canonical_url',
        'category_intro', 'category_faq',
        'price_from', 'currency', 'is_featured', 'sort_order', 'status',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $useSoftDeletes = true;

    /** Products grouped by category for the homepage tabs. */
    public function groupedActive(int $limitPerCat = 4): array
    {
        $cats = model(ProductCategoryModel::class)->active();
        $out  = [];
        foreach ($cats as $c) {
            $items = $this->where('category_id', $c['id'])
                          ->where('status', 'active')
                          ->orderBy('is_featured', 'DESC')
                          ->orderBy('sort_order')
                          ->limit($limitPerCat)
                          ->findAll();
            if ($items) {
                $out[] = ['category' => $c, 'products' => $items];
            }
        }

        return $out;
    }

    public function topFeatured(int $n = 6): array
    {
        return $this->where('status', 'active')
                    ->orderBy('is_featured', 'DESC')
                    ->orderBy('sort_order')
                    ->limit($n)
                    ->findAll();
    }

    public function bySlug(string $slug): ?array
    {
        return $this->where('slug', $slug)->where('status', 'active')->first();
    }

    /** Listing with optional category + free-text search. */
    public function filter(?int $categoryId = null, string $q = ''): array
    {
        $builder = $this->where('status', 'active');
        if ($categoryId) {
            $builder->where('category_id', $categoryId);
        }
        if ($q !== '') {
            $like = $this->db->escapeLikeString($q);
            $builder->groupStart()
                    ->like('name', $q)
                    ->orLike('tagline', $q)
                    ->orLike('description', $q)
                    ->groupEnd();
        }

        return $builder->orderBy('is_featured', 'DESC')->orderBy('sort_order')->findAll();
    }

    /** Related products: same category first, then featured fill-up. */
    public function related(array $product, int $n = 3): array
    {
        $out = $this->where('status', 'active')
                    ->where('id !=', $product['id'])
                    ->where('category_id', $product['category_id'] ?? 0)
                    ->orderBy('sort_order')->limit($n)->findAll();

        if (count($out) < $n) {
            $excludeIds = array_merge([$product['id']], array_column($out, 'id'));
            $fill       = $this->where('status', 'active')
                               ->notIn('id', $excludeIds)
                               ->orderBy('is_featured', 'DESC')
                               ->orderBy('sort_order')
                               ->limit($n - count($out))
                               ->findAll();
            $out = array_merge($out, $fill);
        }

        return $out;
    }
}
