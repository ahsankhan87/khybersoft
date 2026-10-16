<?php

namespace App\Controllers\Admin;

use App\Models\ActivityLogModel;
use App\Models\MenuItemModel;
use App\Models\MenuModel;
use App\Models\PageModel;

class Menus extends BaseAdmin
{
    public function index()
    {
        if ($resp = $this->guard('menus')) { return $resp; }

        return $this->render('admin/menus/index', [
            'title' => 'Menus',
            'menus' => (new MenuModel())->orderBy('id')->findAll(),
        ]);
    }

    public function save()
    {
        if ($resp = $this->guard('menus')) { return $resp; }
        $model = new MenuModel();
        $id    = (int) $this->request->getPost('id');
        $data  = [
            'name'       => trim((string) $this->request->getPost('name')),
            'location'   => in_array($this->request->getPost('location'), ['header', 'footer'], true) ? $this->request->getPost('location') : 'header',
            'is_active'  => $this->request->getPost('is_active') ? 1 : 0,
        ];
        if ($data['name'] === '') {
            return redirect()->back()->with('error', 'Menu name required.');
        }
        if ($id) { $model->update($id, $data); } else { $id = $model->insert($data); }
        ActivityLogModel::record('save', 'menus', "Menu '{$data['name']}'");

        return redirect()->to('/admin/menus/items/' . $id)->with('success', 'Menu saved.');
    }

    public function delete(int $id)
    {
        if ($resp = $this->guard('menus')) { return $resp; }
        (new MenuItemModel())->where('menu_id', $id)->delete();
        (new MenuModel())->delete($id);
        ActivityLogModel::record('delete', 'menus', "Menu #{$id}");

        return redirect()->to('/admin/menus')->with('success', 'Menu deleted with its items.');
    }

    public function items(int $menuId)
    {
        if ($resp = $this->guard('menus')) { return $resp; }
        $menu = (new MenuModel())->find($menuId);
        if (! $menu) {
            return redirect()->to('/admin/menus')->with('error', 'Menu not found.');
        }

        return $this->render('admin/menus/items', [
            'title' => 'Menu: ' . $menu['name'],
            'menu'  => $menu,
            'items' => (new MenuItemModel())->treeFor($menuId),
            'pages' => (new PageModel())->where('is_active', 1)->orderBy('title')->findAll(),
        ]);
    }

    public function addItem(int $menuId)
    {
        if ($resp = $this->guard('menus')) { return $resp; }
        $label = trim((string) $this->request->getPost('label'));
        if ($label === '') {
            return redirect()->back()->with('error', 'Label is required.');
        }
        (new MenuItemModel())->insert([
            'menu_id'    => $menuId,
            'parent_id'  => (int) $this->request->getPost('parent_id') ?: null,
            'label'      => $label,
            'url'        => trim((string) $this->request->getPost('url')) ?: null,
            'page_id'    => (int) $this->request->getPost('page_id') ?: null,
            'target'     => $this->request->getPost('target') ? '_blank' : '_self',
            'css_class'  => trim((string) $this->request->getPost('css_class')) ?: null,
            'sort_order' => (int) $this->request->getPost('sort_order'),
            'is_active'  => $this->request->getPost('is_active') ? 1 : 1,
        ]);
        ActivityLogModel::record('create', 'menus', "Item '{$label}' in menu #{$menuId}");

        return redirect()->back()->with('success', 'Item added.');
    }

    public function updateItem(int $itemId)
    {
        if ($resp = $this->guard('menus')) { return $resp; }
        $item = (new MenuItemModel())->find($itemId);
        if (! $item) {
            return redirect()->back()->with('error', 'Item not found.');
        }
        (new MenuItemModel())->update($itemId, [
            'parent_id'  => (int) $this->request->getPost('parent_id') ?: null,
            'label'      => trim((string) $this->request->getPost('label')),
            'url'        => trim((string) $this->request->getPost('url')) ?: null,
            'page_id'    => (int) $this->request->getPost('page_id') ?: null,
            'target'     => $this->request->getPost('target') ? '_blank' : '_self',
            'css_class'  => trim((string) $this->request->getPost('css_class')) ?: null,
            'sort_order' => (int) $this->request->getPost('sort_order'),
            'is_active'  => $this->request->getPost('is_active') ? 1 : 0,
        ]);
        ActivityLogModel::record('update', 'menus', "Item #{$itemId}");

        return redirect()->back()->with('success', 'Item updated.');
    }

    public function deleteItem(int $itemId)
    {
        if ($resp = $this->guard('menus')) { return $resp; }
        $item = (new MenuItemModel())->find($itemId);
        if ($item) {
            (new MenuItemModel())->where('parent_id', $itemId)->update(null, ['parent_id' => $item['parent_id']]);
            (new MenuItemModel())->delete($itemId);
            ActivityLogModel::record('delete', 'menus', "Item #{$itemId}");
        }

        return redirect()->back()->with('success', 'Item deleted.');
    }

    /** Drag-and-drop order save (JSON body). */
    public function reorder()
    {
        if ($resp = $this->guard('menus')) { return $resp; }
        $json = json_decode((string) $this->request->getBody(), true);
        if (! is_array($json)) {
            return $this->response->setStatusCode(400)->setJSON(['ok' => false]);
        }
        $model = new MenuItemModel();
        foreach ($json as $i => $node) {
            $model->update((int) $node['id'], ['sort_order' => $i, 'parent_id' => ! empty($node['parent']) ? (int) $node['parent'] : null]);
        }
        ActivityLogModel::record('reorder', 'menus', 'Reordered menu items');

        return $this->response->setJSON(['ok' => true]);
    }
}
