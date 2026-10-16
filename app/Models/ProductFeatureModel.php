<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductFeatureModel extends Model
{
    protected $table            = 'product_features';
    protected $returnType       = 'array';
    protected $allowedFields    = ['product_id', 'name', 'description', 'icon', 'group_key', 'image', 'bullets', 'sort_order', 'is_active'];
    protected $useTimestamps    = true;

    /** Feature cards for the grid (no grouping). */
    public function grid(int $productId, int $limit = 8): array
    {
        return $this->where('product_id', $productId)->where('is_active', 1)
                    ->orderBy('sort_order')->limit($limit)->findAll();
    }

    /** Deep-dive tabs: first feature per group_key becomes a tab. */
    public function deepDiveTabs(int $productId): array
    {
        $rows = $this->where('product_id', $productId)->where('is_active', 1)
                     ->orderBy('group_key')->orderBy('sort_order')->findAll();
        $tabs = [];
        foreach ($rows as $r) {
            $key = $r['group_key'] ?: 'general';
            if (! isset($tabs[$key])) {
                $tabs[$key] = [
                    'key'     => $key,
                    'label'   => $r['name'],
                    'desc'    => $r['description'],
                    'image'   => $r['image'],
                    'bullets' => json_decode((string) ($r['bullets'] ?? '[]'), true) ?: [],
                ];
            }
        }

        return array_values($tabs);
    }

    public function replaceForProduct(int $productId, array $rows): void
    {
        $this->where('product_id', $productId)->delete();
        foreach ($rows as $i => $r) {
            if (trim((string) ($r['name'] ?? '')) === '') {
                continue;
            }
            $this->insert([
                'product_id'  => $productId,
                'name'        => $r['name'],
                'description' => $r['description'] ?: null,
                'icon'        => $r['icon'] ?: null,
                'group_key'   => $r['group_key'] ?: null,
                'image'       => $r['image'] ?: null,
                'bullets'     => $r['bullets'] ?: '[]',
                'sort_order'  => $i,
                'is_active'   => ! empty($r['is_active']) ? 1 : 0,
            ]);
        }
    }
}
