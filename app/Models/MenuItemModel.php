<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuItemModel extends Model
{
    protected $table         = 'menu_items';
    protected $allowedFields = ['menu_id', 'parent_id', 'label', 'url', 'target', 'css_class', 'icon', 'is_external', 'is_active', 'sort_order'];
    protected $useTimestamps = true;
    protected $validationRules = [
        'menu_id' => 'required|integer',
        'label'   => 'required|max_length[100]',
    ];

    public function itemsFor(int $menuId): array
    {
        return $this->where('menu_id', $menuId)->orderBy('sort_order')->findAll();
    }

    public function treeFor(int $menuId): array
    {
        return $this->itemsFor($menuId);
    }
}
