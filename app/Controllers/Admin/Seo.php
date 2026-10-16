<?php

namespace App\Controllers\Admin;

use App\Models\SeoMetaModel;

/**
 * Per-URL SEO meta manager (Phase 1). Full OG/schema editing per path.
 */
class Seo extends BaseAdmin
{
    public function index()
    {
        return $this->render('admin/seo/index', [
            'title' => 'SEO Meta',
            'rows'  => (new SeoMetaModel())->orderBy('url_path')->findAll(),
            'row'   => null,
        ]);
    }

    public function edit()
    {
        $path = '/' . ltrim((string) $this->request->getGet('path'), '/');
        return $this->render('admin/seo/index', [
            'title' => 'SEO Meta — ' . $path,
            'rows'  => (new SeoMetaModel())->orderBy('url_path')->findAll(),
            'row'   => (new SeoMetaModel())->forPath($path),
            'editPath' => $path,
        ]);
    }

    public function save()
    {
        $model = new SeoMetaModel();
        $path  = '/' . ltrim((string) $this->request->getPost('url_path'), '/');

        $model->put($path, [
            'title'       => trim((string) $this->request->getPost('title')),
            'description' => trim((string) $this->request->getPost('description')),
            'keywords'    => trim((string) $this->request->getPost('keywords')),
            'og_image'    => trim((string) $this->request->getPost('og_image')),
            'canonical'   => trim((string) $this->request->getPost('canonical')),
            'robots'      => $this->request->getPost('robots') ?: 'index,follow',
            'schema_json' => trim((string) $this->request->getPost('schema_json')),
        ]);

        return redirect()->to('/admin/seo/edit?path=' . urlencode($path))->with('success', 'SEO meta saved for ' . $path);
    }

    public function delete(int $id)
    {
        (new SeoMetaModel())->delete($id);

        return redirect()->to('/admin/seo')->with('success', 'Entry deleted.');
    }
}
