<?php

namespace App\Controllers\Admin;

use App\Concerns\HasAdminCrud;
use App\Models\ProductModel;
use App\Models\ProductVersionModel;

class Versions extends BaseAdmin
{
    use HasAdminCrud;

    protected string $module     = 'versions';
    protected string $modelClass = ProductVersionModel::class;
    protected array  $fields     = ['product_id', 'version', 'release_date', 'highlights', 'breaking_changes', 'download_url'];
    protected array  $booleans   = ['is_latest'];
    protected array  $rules      = ['product_id' => 'required|integer', 'version' => 'required|max_length[30]'];

    public function index()
    {
        return $this->render('admin/versions/index', [
            'title'    => 'Changelogs & Versions',
            'items'    => (new ProductVersionModel())->select('product_versions.*, products.name AS product_name')->join('products', 'products.id = product_versions.product_id', 'left')->orderBy('product_versions.id', 'desc')->findAll(),
            'products' => (new ProductModel())->where('status', 'active')->findAll(),
        ]);
    }

    public function save(?int $id = null)
    {
        $resp = $this->save($id);
        if ((int) $this->request->getPost('is_latest')) {
            $pid = (int) $this->request->getPost('product_id');
            (new ProductVersionModel())->where('product_id', $pid)->where('id !=', (int) $this->request->getPost('_saved_id'))->update(null, ['is_latest' => 0]);
        }

        return $resp;
    }

    public function delete(int $id)
    {
        return $this->destroy($id);
    }

    protected function listUrl(): string
    {
        return '/admin/versions';
    }
}
