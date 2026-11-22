<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\TutorialCategoryModel;
use App\Models\TutorialModel;
use App\Models\ProductVersionModel;
use CodeIgniter\Exceptions\PageNotFoundException;

/**
 * Resource pages linked from the footer: Help Center, Tutorials,
 * Documentation, API reference, System status and Changelog.
 */
class Resources extends BaseController
{
    /** /help — Help Center home with search + categories + popular tutorials. */
    public function help()
    {
        $tutorials = (new TutorialModel())->where('is_published', 1)->orderBy('sort_order')->orderBy('id', 'DESC')->findAll();
        $categories = (new TutorialCategoryModel())->orderBy('sort_order')->findAll();

        return $this->renderPage('pages/help', [
            'title'            => 'Help Center — ' . setting('site_name', 'Khybersoft'),
            'meta_description' => 'Guides, video tutorials and answers for every Khybersoft product.',
            'tutorials'        => $tutorials,
            'categories'       => $categories,
        ]);
    }

    /** /tutorials — full listing, optionally filtered by ?category= or ?product=. */
    public function tutorials()
    {
        $model      = new TutorialModel();
        $categoryId = (int) $this->request->getGet('category');
        $productId  = (int) $this->request->getGet('product');

        $query = $model->where('is_published', 1);
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        if ($productId) {
            $query->where('product_id', $productId);
        }

        return $this->renderPage('pages/tutorials', [
            'title'            => 'Video Tutorials — ' . setting('site_name', 'Khybersoft'),
            'meta_description' => 'Step-by-step video tutorials and articles for Khybersoft products.',
            'tutorials'        => $query->orderBy('sort_order')->orderBy('id', 'DESC')->findAll(),
            'categories'       => (new TutorialCategoryModel())->orderBy('sort_order')->findAll(),
            'products'         => (new ProductModel())->where('status', 'active')->orderBy('sort_order')->findAll(),
            'activeCategory'   => $categoryId,
            'activeProduct'    => $productId,
        ]);
    }

    /** /tutorials/{slug} — single tutorial (video embed or article). */
    public function tutorial(string $slug)
    {
        $item = (new TutorialModel())->where('slug', $slug)->where('is_published', 1)->first();
        if (! $item) {
            throw PageNotFoundException::forPageNotFound('Tutorial not found.');
        }

        (new TutorialModel())->where('id', $item['id'])->set('view_count', 'view_count + 1', false)->update();

        $product = null;
        if (! empty($item['product_id'])) {
            $product = (new ProductModel())->find((int) $item['product_id']);
        }

        return $this->renderPage('pages/tutorial', [
            'title'            => $item['title'] . ' — ' . setting('site_name', 'Khybersoft'),
            'meta_description' => mb_substr(trim(strip_tags((string) ($item['article_body'] ?? ''))), 0, 160) ?: $item['title'],
            'item'             => $item,
            'product'          => $product,
            'related'          => (new TutorialModel())->where('is_published', 1)->where('id !=', $item['id'])->orderBy('id', 'DESC')->limit(3)->findAll(),
        ]);
    }

    /** /docs — documentation landing page. */
    public function docs()
    {
        return $this->renderPage('pages/docs', [
            'title'            => 'Documentation — ' . setting('site_name', 'Khybersoft'),
            'meta_description' => 'Official Khybersoft documentation: setup guides, configuration, and product references.',
        ]);
    }

    /** /docs/api — REST API reference. */
    public function apiDocs()
    {
        return $this->renderPage('pages/api_docs', [
            'title'            => 'API Reference — ' . setting('site_name', 'Khybersoft'),
            'meta_description' => 'Khybersoft REST API reference: authentication, endpoints and examples.',
        ]);
    }

    /** /status — system status page. */
    public function status()
    {
        return $this->renderPage('pages/status', [
            'title'            => 'System Status — ' . setting('site_name', 'Khybersoft'),
            'meta_description' => 'Live uptime and service status for Khybersoft cloud services.',
        ]);
    }

    /** /changelog — product release notes. */
    public function changelog()
    {
        $versions = [];
        try {
            $versions = (new ProductVersionModel())->orderBy('release_date', 'DESC')->findAll();
        } catch (\Throwable $e) {
            $versions = [];
        }

        return $this->renderPage('pages/changelog', [
            'title'            => 'Changelog — ' . setting('site_name', 'Khybersoft'),
            'meta_description' => 'New features, improvements and fixes in every Khybersoft release.',
            'versions'         => $versions,
        ]);
    }
}
