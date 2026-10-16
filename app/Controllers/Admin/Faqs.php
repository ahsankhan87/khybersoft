<?php

namespace App\Controllers\Admin;

use App\Concerns\HasAdminCrud;
use App\Models\FaqModel;

class Faqs extends BaseAdmin
{
    use HasAdminCrud;

    protected string $module     = 'tutorials';
    protected string $modelClass = FaqModel::class;
    protected array  $fields     = ['scope', 'question', 'answer', 'sort_order'];
    protected array  $booleans   = ['is_active'];
    protected array  $rules      = ['question' => 'required|max_length[500]', 'answer' => 'required'];

    public function index()
    {
        $scope = (string) ($this->request->getGet('scope') ?? '');
        $model = new FaqModel();
        $items = $scope !== '' ? $model->where('scope', $scope)->orderBy('sort_order')->findAll() : $model->orderBy('scope')->orderBy('sort_order')->findAll();

        return $this->render('admin/faqs/index', [
            'title'  => 'FAQs',
            'items'  => $items,
            'scopes' => $model->scopes(),
            'scope'  => $scope,
        ]);
    }

    public function save(?int $id = null)
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

    protected function listUrl(): string
    {
        return '/admin/faqs';
    }
}
