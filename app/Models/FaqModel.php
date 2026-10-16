<?php

namespace App\Models;

use CodeIgniter\Model;

class FaqModel extends Model
{
    protected $table         = 'faqs';
    protected $allowedFields = ['scope', 'question', 'answer', 'sort_order', 'is_active'];
    protected $useTimestamps = true;
    protected $returnType    = 'array';

    public function forScope(string $scope): array
    {
        return $this->where('scope', $scope)->where('is_active', 1)->orderBy('sort_order')->findAll();
    }

    public function scopes(): array
    {
        return array_column($this->select('scope')->distinct()->findAll(), 'scope');
    }
}
