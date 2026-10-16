<?php

namespace App\Models;

use CodeIgniter\Model;

class PageModel extends Model
{
    protected $table         = 'pages';
    protected $allowedFields = ['title', 'slug', 'body', 'template', 'excerpt', 'meta_title', 'meta_description', 'sort_order', 'is_published', 'created_by'];
    protected $useSoftDeletes = true;
    protected $useTimestamps  = true;

    public function bySlug(string $slug): ?array
    {
        return $this->where('slug', $slug)->where('is_published', 1)->first();
    }

    public function publishedAll(): array
    {
        return $this->where('is_published', 1)->orderBy('sort_order')->findAll();
    }
}
