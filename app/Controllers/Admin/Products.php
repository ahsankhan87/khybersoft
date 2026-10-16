<?php

namespace App\Controllers\Admin;

use App\Concerns\HasAdminCrud;
use App\Models\ActivityLogModel;
use App\Models\FaqModel;
use App\Models\ProductModel;
use App\Models\ProductVersionModel;

class Products extends BaseAdmin
{
    use HasAdminCrud;

    protected string $module     = 'products';
    protected string $modelClass = ProductModel::class;
    protected array  $fields     = ['name', 'slug', 'tagline', 'description', 'icon', 'color_theme', 'pricing_model', 'price_from', 'currency', 'license_terms', 'features', 'screenshots', 'demo_url', 'docs_url', 'changelog', 'meta_title', 'meta_desc', 'sort_order'];
    protected array  $booleans   = ['is_featured'];
    protected array  $rules      = ['name' => 'required|max_length[150]', 'slug' => 'required|alpha_dash|is_unique[products.slug,id,{id}]'];
    protected string $slugSource = 'name';

    public function index()
    {
        return $this->render('admin/products/index', [
            'title'   => 'Products',
            'items'   => (new ProductModel())->orderBy('sort_order')->findAll(),
        ]);
    }

    public function create()
    {
        return $this->form(null);
    }

    public function edit(int $id)
    {
        return $this->form($id);
    }

    private function form(?int $id)
    {
        $product = $id ? (new ProductModel())->find($id) : null;

        return $this->render('admin/products/form', [
            'title'    => $id ? 'Edit Product' : 'New Product',
            'item'     => $product,
            'features' => $product && ! empty($product['features']) ? json_decode((string) $product['features'], true) : [],
            'versions' => $id ? (new ProductVersionModel())->where('product_id', $id)->orderBy('id', 'desc')->findAll() : [],
            'faqs'     => $id ? (new FaqModel())->where('scope', 'product:' . $product['slug'])->orderBy('sort_order')->findAll() : [],
        ]);
    }

    public function store()
    {
        return $this->save(null);
    }

    public function update(int $id)
    {
        return $this->save($id);
    }

    protected function beforeSaveData(array &$data): void
    {
        // features repeater: rows of icon/title/desc → JSON
        $rows  = (array) $this->request->getPost('features');
        $clean = [];
        foreach ($rows as $r) {
            if (! empty($r['title'])) {
                $clean[] = ['icon' => $r['icon'] ?? 'fa-solid fa-check', 'title' => $r['title'], 'description' => $r['description'] ?? ''];
            }
        }
        $data['features'] = json_encode($clean);
    }

    public function delete(int $id)
    {
        return $this->destroy($id);
    }

    /** Quick status toggle from the list. */
    public function toggleStatus(int $id)
    {
        if ($resp = $this->guard()) { return $resp; }
        $model = new ProductModel();
        $row   = $model->find($id);
        $model->update($id, ['status' => $row['status'] === 'active' ? 'draft' : 'active']);
        ActivityLogModel::record('toggle', 'products', "Product #{$id} status");

        return redirect()->to('/admin/products')->with('success', 'Status toggled.');
    }
}
