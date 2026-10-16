<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductFaqModel extends Model
{
    protected $table            = 'product_faqs';
    protected $returnType       = 'array';
    protected $allowedFields    = ['product_id', 'question', 'answer', 'sort_order', 'is_active'];
    protected $useTimestamps    = true;

    public function forProduct(int $productId): array
    {
        return $this->where('product_id', $productId)->where('is_active', 1)
                    ->orderBy('sort_order')->findAll();
    }

    public function replaceForProduct(int $productId, array $rows): void
    {
        $this->where('product_id', $productId)->delete();
        foreach ($rows as $i => $r) {
            if (trim((string) ($r['question'] ?? '')) === '') {
                continue;
            }
            $this->insert([
                'product_id' => $productId,
                'question'   => $r['question'],
                'answer'     => $r['answer'] ?? '',
                'sort_order' => $i,
                'is_active'  => ! empty($r['is_active']) ? 1 : 0,
            ]);
        }
    }
}
