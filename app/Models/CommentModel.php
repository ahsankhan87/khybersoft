<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model
{
    protected $table         = 'comments';
    protected $allowedFields = ['post_id', 'parent_id', 'name', 'email', 'content', 'status', 'ip_hash'];
    protected $useTimestamps = true;
    protected $returnType    = 'array';

    public function moderation(?string $status = 'pending'): array
    {
        $q = $this->select('comments.*, posts.title AS post_title')->join('posts', 'posts.id = comments.post_id', 'left')->orderBy('comments.id', 'desc');
        if ($status) { $q->where('comments.status', $status); }

        return $q->findAll();
    }

    public function approvedForPost(int $postId): array
    {
        return $this->where('post_id', $postId)->where('status', 'approved')->orderBy('id', 'asc')->findAll();
    }
}
