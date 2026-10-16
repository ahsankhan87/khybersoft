<?php

namespace App\Controllers\Admin;

use App\Concerns\HasAdminCrud;
use App\Models\ProductModel;
use App\Models\TestimonialModel;

class Testimonials extends BaseAdmin
{
    use HasAdminCrud;

    protected string $module     = 'testimonials';
    protected string $modelClass = TestimonialModel::class;
    protected array  $fields     = ['quote', 'name', 'role', 'company', 'photo', 'company_logo', 'product_id', 'rating', 'source', 'sort_order'];
    protected array  $booleans   = ['is_featured'];
    protected array  $rules      = ['name' => 'required|max_length[120]', 'quote' => 'required|min_length[10]'];

    public function index()
    {
        return $this->render('admin/testimonials/index', [
            'title'      => 'Testimonials',
            'items'      => (new TestimonialModel())->orderBy('sort_order')->orderBy('id', 'desc')->findAll(),
            'products'   => (new ProductModel())->where('status', 'active')->findAll(),
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
        return $this->render('admin/testimonials/form', [
            'title'    => $id ? 'Edit Testimonial' : 'New Testimonial',
            'item'     => $id ? (new TestimonialModel())->find($id) : null,
            'products' => (new ProductModel())->where('status', 'active')->findAll(),
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

    public function delete(int $id)
    {
        return $this->destroy($id);
    }

    public function toggle(int $id)
    {
        return $this->toggleActive($id);
    }

    /** CSV import: name,role,company,quote,rating */
    public function import()
    {
        if ($resp = $this->guard()) { return $resp; }
        $file = $this->request->getFile('csv');
        if (! $file || ! $file->isValid() || strtolower($file->getClientExtension()) !== 'csv') {
            return redirect()->back()->with('error', 'Upload a valid .csv file.');
        }
        $model = new TestimonialModel();
        $count = 0;
        if (($h = fopen($file->getTempName(), 'r')) !== false) {
            fgetcsv($h); // header row
            while (($row = fgetcsv($h)) !== false) {
                if (count($row) < 4 || trim($row[3]) === '') { continue; }
                $model->insert([
                    'name' => $row[0], 'role' => $row[1] ?? '', 'company' => $row[2] ?? '',
                    'quote' => $row[3], 'rating' => max(1, min(5, (int) ($row[4] ?? 5))),
                    'source' => 'import', 'status' => 'pending',
                ]);
                $count++;
            }
            fclose($h);
        }
        \App\Models\ActivityLogModel::record('import', 'testimonials', "{$count} rows imported");

        return redirect()->to('/admin/testimonials')->with('success', "Imported {$count} testimonials (pending approval).");
    }
}
