<?php

namespace App\Models;

use CodeIgniter\Model;

class MediaModel extends Model
{
    protected $table          = 'media';
    protected $allowedFields  = ['name', 'path', 'thumb_path', 'mime', 'kind', 'size_kb', 'width', 'height', 'alt_text', 'folder', 'uploaded_by'];
    protected $useTimestamps  = true;
    protected $returnType     = 'array';

    public function listFiltered(array $f = []): array
    {
        $builder = $this->orderBy('id', 'desc');
        if (! empty($f['kind']))   { $builder->where('kind', $f['kind']); }
        if (! empty($f['folder'])) { $builder->where('folder', $f['folder']); }
        if (! empty($f['q']))      { $builder->like('name', $f['q']); }

        return $builder->findAll();
    }

    public function folders(): array
    {
        return array_column($this->select('folder')->distinct()->findAll(), 'folder');
    }

    public function url(array $item): string
    {
        return base_url($item['path']);
    }
}
