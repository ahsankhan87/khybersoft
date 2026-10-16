<?php

namespace App\Controllers;

use App\Models\PageModel;

/**
 * Dynamic CMS page resolver (Phase 1). Replaces the old dangerous
 * Pages::view() catch-all. Only serves published rows from `pages`.
 */
class Page extends BaseController
{
    public function show(string $slug)
    {
        $slug = trim($slug, '/');
        helper('text');

        $page = model(PageModel::class)->bySlug($slug);
        if (! $page) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return $this->renderPage('pages/cms', [
            'title'            => $page['meta_title'] ?: $page['title'],
            'meta_description' => $page['meta_description'] ?: ($page['excerpt'] ?: strip_tags(mb_substr((string) $page['body'], 0, 160))),
            'page'             => $page,
        ]);
    }
}
