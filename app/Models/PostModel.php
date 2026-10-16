<?php

namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model
{
    protected $table         = 'posts';
    protected $allowedFields = [
        'title', 'slug', 'category_id', 'author_id', 'excerpt', 'content', 'featured_image',
        'read_minutes', 'view_count', 'is_featured', 'status', 'published_at', 'meta_title', 'meta_desc',
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $returnType     = 'array';
    protected $validationRules = ['title' => 'required|max_length[255]', 'slug' => 'required|alpha_dash|max_length[255]|is_unique[posts.slug,id,{id}]'];

    public function published(int $limit = 0): array
    {
        $q = $this->where('status', 'published')
                  ->where('published_at <=', date('Y-m-d H:i:s'))
                  ->orderBy('published_at', 'desc');
        if ($limit) { $q->limit($limit); }

        return $q->findAll();
    }

    public function withCategory(int $id): ?array
    {
        return $this->select('posts.*, categories.name AS category_name, categories.slug AS category_slug')
                    ->join('categories', 'categories.id = posts.category_id', 'left')
                    ->find($id);
    }

    public function paginateList(?string $status = null, ?int $categoryId = null, string $q = '')
    {
        $builder = $this->select('posts.*, categories.name AS category_name, admin_users.name AS author_name')
                        ->join('categories', 'categories.id = posts.category_id', 'left')
                        ->join('admin_users', 'admin_users.id = posts.author_id', 'left')
                        ->orderBy('posts.id', 'desc');
        if ($status)            { $builder->where('posts.status', $status); }
        if ($categoryId)         { $builder->where('posts.category_id', $categoryId); }
        if ($q !== '')           { $builder->groupStart()->like('posts.title', $q)->orLike('posts.excerpt', $q)->groupEnd(); }

        return pager('default', $builder->countAllResults(false), 15);
    }

    public function syncTags(int $postId, array $tagIds): void
    {
        $db = db_connect();
        $db->table('post_tag')->where('post_id', $postId)->delete();
        foreach (array_unique($tagIds) as $tid) {
            $db->table('post_tag')->insert(['post_id' => $postId, 'tag_id' => (int) $tid]);
        }
    }

    public function tagIds(int $postId): array
    {
        return array_map('intval', array_column(db_connect()->table('post_tag')->where('post_id', $postId)->get()->getResultArray(), 'tag_id'));
    }
}
