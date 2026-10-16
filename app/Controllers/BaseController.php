<?php

namespace App\Controllers;

use App\Models\Admin\SettingModel;
use App\Models\MenuModel;
use App\Models\SeoMetaModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    /**
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    protected $helpers = ['url', 'form', 'site'];

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->session = service('session');
    }

    /**
     * Global data injected into every public view rendered through renderPage().
     */
    protected function globals(): array
    {
        static $cached = null;
        if ($cached !== null) {
            return $cached;
        }

        $path = '/' . ltrim($this->request->uri->getPath() ?? '', '/');
        $seo  = model(SeoMetaModel::class)->forPath($path);

        $cached = [
            'siteName'   => SettingModel::get('site_name', 'Khybersoft'),
            'tagline'    => SettingModel::get('site_tagline', ''),
            'settings'   => SettingModel::all(),
            'navMenu'    => model(MenuModel::class)->tree('header'),
            'footMenu'   => model(MenuModel::class)->tree('footer'),
            'seo'        => $seo,
            'currentPath'=> $path,
        ];

        return $cached;
    }

    /**
     * Render a public page with the master layout.
     */
    protected function renderPage(string $view, array $data = []): string
    {
        $data += $this->globals();
        $data['content'] = view($view, $data);

        return view('layout/master', $data);
    }
}
