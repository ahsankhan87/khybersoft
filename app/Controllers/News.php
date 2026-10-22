<?php

namespace App\Controllers;

use App\Models\NewsModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class News extends BaseController
{
    public function index()
    {
        $model = model(NewsModel::class);

        return $this->renderPage('news/index', [
            'news_list'        => $model->getNews(),
            'title'            => 'News archive',
            'meta_description' => 'Latest news and updates from ' . setting('site_name', 'Khybersoft'),
        ]);
    }

    public function show($slug = null)
    {
        $model = model(NewsModel::class);

        $news = $model->getNews($slug);

        if ($news === null) {
            throw new PageNotFoundException('Cannot find the news item: ' . $slug);
        }

        return $this->renderPage('news/view', [
            'news'             => $news,
            'title'            => $news['title'],
            'meta_description' => mb_substr(strip_tags((string) $news['body']), 0, 160),
        ]);
    }

    public function new()
    {
        helper('form');

        return view('templates/header', ['title' => 'Create a news item'])
            . view('news/create')
            . view('templates/footer');
    }

    /**
     * Creates a new news item.
     *
     * @return string
     */
    public function create()
    {
        helper('form');

        $data = $this->request->getPost(['title', 'body']);

        // Checks whether the submitted data passed the validation rules.
        if (! $this->validateData($data, [
            'title' => 'required|max_length[255]|min_length[3]',
            'body'  => 'required|max_length[5000]|min_length[10]',
        ])) {
            // The validation fails, so returns the form.
            return $this->new();
        }

        // Gets the validated data.
        $post = $this->validator->getValidated();

        $model = model(NewsModel::class);

        $model->save([
            'title' => $post['title'],
            'slug'  => url_title($post['title'], '-', true),
            'body'  => $post['body'],
        ]);

        return view('templates/header', ['title' => 'Create a news item'])
            . view('news/success')
            . view('templates/footer');
    }
}
