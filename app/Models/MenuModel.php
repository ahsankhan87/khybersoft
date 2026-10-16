<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table         = 'menus';
    protected $allowedFields = ['name', 'location', 'is_active'];
    protected $useTimestamps = true;

    /** Items for a location as a nested tree (parent_id => children). */
    public function tree(string $location): array
    {
        $menu = $this->where('location', $location)->where('is_active', 1)->first();
        if (!$menu) {
            return [];
        }

        $items = model(MenuItemModel::class)
            ->where('menu_id', $menu['id'])
            ->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->findAll();

        return $this->buildTree($items);
    }

    private function buildTree(array $items, ?int $parent = null): array
    {
        $branch = [];
        foreach ($items as $item) {
            if ((int) ($item['parent_id'] ?? 0) === (int) $parent) {
                $children = $this->buildTree($items, (int) $item['id']);
                if ($children) {
                    $item['children'] = $children;
                }
                $branch[] = $item;
            }
        }
        return $branch;
    }
}
