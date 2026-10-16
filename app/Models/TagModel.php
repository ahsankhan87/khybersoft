<?php

namespace App\Models;

use CodeIgniter\Model;

class TagModel extends Model
{
    protected $table         = 'tags';
    protected $allowedFields = ['name', 'slug'];
    protected $useTimestamps = false;
    protected $returnType    = 'array';

    public function firstOrCreate(string $name): int
    {
        $slug = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $name), '-'));
        if ($existing = $this->where('slug', $slug)->first()) {
            return (int) $existing['id'];
        }

        return (int) $this->insert(['name' => $name, 'slug' => $slug, 'created_at' => date('Y-m-d H:i:s')]);
    }
}
