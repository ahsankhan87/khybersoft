<?php

namespace App\Controllers\Admin;

use App\Concerns\HasAdminCrud;
use App\Models\ActivityLogModel;
use App\Models\FaqModel;
use App\Models\ProductModel;
use App\Models\ProductCategoryModel;
use App\Models\ProductVersionModel;

class Products extends BaseAdmin
{
    use HasAdminCrud;

    protected string $module     = 'products';
    protected string $modelClass = ProductModel::class;
    protected array  $fields     = ['category_id', 'name', 'slug', 'tagline', 'description', 'long_description', 'icon', 'color', 'hero_image', 'top_features', 'demo_url', 'video_url', 'brochure_url', 'docs_url', 'pricing_type', 'users_count', 'rating_avg', 'rating_count', 'seo_title', 'seo_description', 'og_image', 'canonical_url', 'category_intro', 'category_faq', 'price_from', 'currency', 'sort_order', 'status'];
    protected array  $booleans   = ['is_featured'];
    protected array  $rules      = ['name' => 'required|max_length[150]', 'slug' => 'required|alpha_dash|is_unique[products.slug,id,{id}]'];
    protected string $slugSource = 'name';

    public function index()
    {
        $q = trim((string) $this->request->getGet('q'));
        $catId = (int) $this->request->getGet('category');
        $status = trim((string) $this->request->getGet('status'));
        $builder = (new ProductModel())->orderBy('sort_order');
        if ($q !== '') {
            $builder->groupStart()->like('name', $q)->orLike('tagline', $q)->groupEnd();
        }
        if ($catId > 0) {
            $builder->where('category_id', $catId);
        }
        if ($status !== '') {
            $builder->where('status', $status);
        }

        return $this->render('admin/products/index', [
            'title'      => 'Products',
            'products'   => $builder->findAll(),
            'categories' => (new ProductCategoryModel())->orderBy('name')->findAll(),
            'q'          => $q,
            'catId'      => $catId,
            'status'     => $status,
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
            'categories' => (new ProductCategoryModel())->orderBy('name')->findAll(),
            'versions' => $id ? (new ProductVersionModel())->where('product_id', $id)->orderBy('id', 'desc')->findAll() : [],
            'faqs'     => $id ? (new FaqModel())->where('scope', 'product:' . $product['slug'])->orderBy('sort_order')->findAll() : [],
        ]);
    }

    public function store()
    {
        return $this->persist(null);
    }

    public function update(int $id)
    {
        return $this->persist($id);
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
