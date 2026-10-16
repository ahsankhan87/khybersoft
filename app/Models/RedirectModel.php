<?php

namespace App\Models;

use CodeIgniter\Model;

class RedirectModel extends Model
{
    protected $table         = 'redirects';
    protected $allowedFields = ['source_path', 'target_url', 'status_code', 'hits', 'is_active'];
    protected $useTimestamps = true;
    protected $returnType    = 'array';

    public function match(string $path): ?array
    {
        return $this->where('source_path', '/' . ltrim($path, '/'))->where('is_active', 1)->first();
    }

    public function recordHit(int $id): void
    {
        $this->db->table('redirects')->where('id', $id)->set('hits = hits + 1', null, false)->update();
    }
}
