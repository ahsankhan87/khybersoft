<?php

namespace App\Controllers;

use App\Models\NewsModel;
use App\Models\ProductModel;
use App\Models\SuccessStoryModel;
use CodeIgniter\Exceptions\PageNotFoundException;

/**
 * Static front pages (about, search) that are not CMS-driven.
 */
class FrontPage extends BaseController
{
    public function about()
    {
        return $this->renderPage('pages/about', [
            'title'            => 'About Us — ' . setting('site_name', 'Khybersoft'),
            'meta_description' => setting('site_description'),
        ]);
    }

    public function search()
    {
        $q = trim((string) $this->request->getGet('q'));

        $products = [];
        $posts    = [];
        if ($q !== '') {
            $products = model(ProductModel::class)
                ->where('status', 'active')
                ->groupStart()->like('name', $q)->orLike('tagline', $q)->orLike('description', $q)->groupEnd()
                ->orderBy('is_featured', 'DESC')->limit(12)->findAll();

            $posts = model(NewsModel::class)
                ->groupStart()->like('title', $q)->orLike('body', $q)->groupEnd()
                ->orderBy('id', 'DESC')->limit(12)->findAll();
        }

        return $this->renderPage('pages/search', [
            'title'            => 'Search — ' . setting('site_name', 'Khybersoft'),
            'meta_description' => 'Search products, articles and pages.',
            'q'                => $q,
            'products'         => $products,
            'posts'            => $posts,
        ]);
    }

    /** /success-stories — full listing of published case studies. */
    public function successStories()
    {
        $stories = (new SuccessStoryModel())
            ->where('status', 'published')
            ->orderBy('is_featured', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return $this->renderPage('pages/success_stories', [
            'title'            => 'Success Stories — ' . setting('site_name', 'Khybersoft'),
            'meta_description' => 'Real businesses. Real results. See how companies grow with Khybersoft.',
            'stories'          => $stories,
        ]);
    }

    /** /success-stories/{slug} — single case study. */
    public function successStory(string $slug)
    {
        $story = (new SuccessStoryModel())->where('slug', $slug)->where('status', 'published')->first();
        if (! $story) {
            throw PageNotFoundException::forPageNotFound('Story not found.');
        }

        $product = null;
        if (! empty($story['product_id'])) {
            $product = (new ProductModel())->find((int) $story['product_id']);
        }

        $related = (new SuccessStoryModel())
            ->where('status', 'published')->where('id !=', $story['id'])
            ->orderBy('is_featured', 'DESC')->limit(2)->findAll();

        return $this->renderPage('pages/success_story', [
            'title'            => ($story['headline'] ?: $story['company']) . ' — ' . setting('site_name', 'Khybersoft'),
            'meta_description' => mb_substr(trim(strip_tags((string) $story['quote'])), 0, 160) ?: 'Customer success story — ' . $story['company'],
            'story'            => $story,
            'product'          => $product,
            'related'          => $related,
        ]);
    }

    /** /partners — partner network page. */
    public function partners()
    {
        return $this->renderPage('pages/partners', [
            'title'            => 'Partners — ' . setting('site_name', 'Khybersoft'),
            'meta_description' => 'Meet the Khybersoft partner network and learn how to partner with us.',
        ]);
    }
}
