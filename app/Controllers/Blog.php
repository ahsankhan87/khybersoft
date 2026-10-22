<?php

namespace App\Controllers;

use App\Models\PostModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Blog extends BaseController
{
    public function index()
    {
        $posts = new PostModel();

        return $this->renderPage('front/blog/index', [
            'title'            => 'Blog | ' . setting('site_name', 'Khybersoft'),
            'meta_description' => 'Ideas, product guides, and practical advice from ' . setting('site_name', 'Khybersoft') . '.',
            'posts'            => $posts->publishedPage(9),
            'pager'            => $posts->pager,
        ]);
    }

    public function show(string $slug)
    {
        $post = (new PostModel())->publishedBySlug($slug);
        if (! $post) {
            throw PageNotFoundException::forPageNotFound('Blog article not found.');
        }

        return $this->renderPage('front/blog/show', [
            'title'            => $post['meta_title'] ?: ($post['title'] . ' | ' . setting('site_name', 'Khybersoft')),
            'meta_description' => $post['meta_desc'] ?: mb_substr(trim(strip_tags((string) ($post['excerpt'] ?: $post['content']))), 0, 160),
            'post'             => $post,
        ]);
    }
}
