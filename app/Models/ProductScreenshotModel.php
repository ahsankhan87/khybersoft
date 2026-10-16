<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductScreenshotModel extends Model
{
    protected $table            = 'product_screenshots';
    protected $returnType       = 'array';
    protected $allowedFields    = ['product_id', 'image', 'caption', 'device', 'sort_order'];
    protected $useTimestamps    = true;

    public function forProduct(int $productId): array
    {
        return $this->where('product_id', $productId)->orderBy('sort_order')->findAll();
    }

    public function replaceForProduct(int $productId, array $rows): void
    {
        $this->where('product_id', $productId)->delete();
        foreach ($rows as $i => $r) {
            if (trim((string) ($r['image'] ?? '')) === '') {
                continue;
            }
            $this->insert([
                'product_id' => $productId,
                'image'      => $r['image'],
                'caption'    => $r['caption'] ?: null,
                'device'     => in_array($r['device'] ?? '', ['desktop', 'mobile', 'tablet'], true) ? $r['device'] : 'desktop',
                'sort_order' => $i,
            ]);
        }
    }
}
