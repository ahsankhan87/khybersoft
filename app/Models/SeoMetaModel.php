<?php

namespace App\Models;

use CodeIgniter\Model;

class SeoMetaModel extends Model
{
    protected $table         = 'seo_meta';
    protected $allowedFields = ['url_path', 'title', 'description', 'keywords', 'og_image', 'canonical', 'robots', 'schema_json'];
    protected $useTimestamps = true;

    public function forPath(string $path): ?array
    {
        return $this->where('url_path', '/' . ltrim($path, '/'))->first();
    }

    public function put(string $path, array $data): void
    {
        $path = '/' . ltrim($path, '/');
        $existing = $this->forPath($path);
        if ($existing) {
            $this->update($existing['id'], $data);
        } else {
            $this->insert(array_merge(['url_path' => $path], $data), false);
        }
    }
}
