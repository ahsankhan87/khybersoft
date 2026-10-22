<?php

namespace App\Controllers;

use App\Models\NewsModel;
use App\Models\ProductModel;

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
}
