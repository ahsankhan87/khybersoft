<?php

namespace App\Controllers\Admin;

use App\Concerns\HasAdminCrud;
use App\Models\ProductModel;
use App\Models\SuccessStoryModel;

class Stories extends BaseAdmin
{
    use HasAdminCrud;

    protected string $module     = 'testimonials';
    protected string $modelClass = SuccessStoryModel::class;
    protected array  $fields     = ['headline', 'slug', 'customer_name', 'role', 'company', 'industry', 'photo', 'logo', 'hero_image', 'quote', 'challenge', 'solution', 'product_id', 'status'];
    protected array  $booleans   = ['is_featured'];
    protected array  $rules      = ['headline' => 'required|max_length[255]', 'slug' => 'required|alpha_dash|is_unique[success_stories.slug,id,{id}]'];
    protected string $slugSource = 'headline';

    public function index()
    {
        return $this->render('admin/stories/index', [
            'title'    => 'Success Stories',
            'items'    => (new SuccessStoryModel())->orderBy('id', 'desc')->findAll(),
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
        $story = $id ? (new SuccessStoryModel())->find($id) : null;

        return $this->render('admin/stories/form', [
            'title'    => $id ? 'Edit Story' : 'New Story',
            'item'     => $story,
            'metrics'  => $story && ! empty($story['metrics']) ? json_decode((string) $story['metrics'], true) : [],
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

    protected function beforeSaveData(array &$data): void
    {
        // metrics repeater → JSON
        $rows = (array) $this->request->getPost('metrics');
        $clean = [];
        foreach ($rows as $r) {
            if (! empty($r['label'])) {
                $clean[] = ['label' => $r['label'], 'value' => $r['value'] ?? '', 'icon' => $r['icon'] ?? 'fa-solid fa-arrow-trend-up'];
            }
        }
        $data['metrics'] = json_encode($clean);
    }

    public function delete(int $id)
    {
        return $this->destroy($id);
    }
}
