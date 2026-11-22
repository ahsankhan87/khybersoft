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
        $metaSource = html_entity_decode((string) ($post['excerpt'] ?: $post['content']), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $postUrl = site_url_path('/blog/' . rawurlencode((string) $post['slug']));

        return $this->renderPage('front/blog/show', [
            'title'            => $post['meta_title'] ?: ($post['title'] . ' | ' . setting('site_name', 'Khybersoft')),
            'meta_description' => $post['meta_desc'] ?: mb_substr(trim(strip_tags($metaSource)), 0, 160),
            'canonical'        => $postUrl,
            'og_image'         => $post['featured_image'] ?? null,
            'og_type'          => 'article',
            'og_url'           => $postUrl,
            'share_url'        => $postUrl,
            'post'             => $post,
        ]);
    }
}
