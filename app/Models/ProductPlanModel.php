<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductPlanModel extends Model
{
    protected $table            = 'product_plans';
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'product_id', 'name', 'code', 'tagline', 'price_monthly', 'price_yearly',
        'currency', 'setup_fee', 'trial_days', 'user_limit', 'features', 'comparison',
        'is_popular', 'is_active', 'sort_order',
    ];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    /** Active plans for a product, decoded helpers attached. */
    public function forProduct(int $productId): array
    {
        $plans = $this->where('product_id', $productId)
                      ->where('is_active', 1)
                      ->orderBy('sort_order')
                      ->findAll();

        foreach ($plans as &$p) {
            $p['feature_list'] = json_decode((string) ($p['features'] ?? '[]'), true) ?: [];
            $p['comparison']   = json_decode((string) ($p['comparison'] ?? '[]'), true) ?: [];
        }

        return $plans;
    }

    public function replaceForProduct(int $productId, array $rows): void
    {
        $this->where('product_id', $productId)->delete();
        foreach ($rows as $i => $r) {
            if (trim((string) ($r['name'] ?? '')) === '') {
                continue;
            }
            $this->insert([
                'product_id'    => $productId,
                'name'          => $r['name'],
                'code'          => $r['code'] ?: null,
                'tagline'       => $r['tagline'] ?: null,
                'price_monthly' => ($r['price_monthly'] !== '' && $r['price_monthly'] !== null) ? $r['price_monthly'] : null,
                'price_yearly'  => ($r['price_yearly'] !== '' && $r['price_yearly'] !== null) ? $r['price_yearly'] : null,
                'currency'      => $r['currency'] ?: 'PKR',
                'setup_fee'     => $r['setup_fee'] ?: 0,
                'trial_days'    => (int) ($r['trial_days'] ?? 14),
                'user_limit'    => $r['user_limit'] ?: null,
                'features'      => $r['features'] ?: '[]',
                'comparison'    => $r['comparison'] ?: '[]',
                'is_popular'    => ! empty($r['is_popular']) ? 1 : 0,
                'is_active'     => ! empty($r['is_active']) ? 1 : 0,
                'sort_order'    => $i,
            ]);
        }
    }
}
