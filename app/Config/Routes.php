<?php

use App\Controllers\Home;
use CodeIgniter\Router\RouteCollection;
use App\Controllers\Pages;
use App\Controllers\News; // Add this line
use App\Controllers\Products;
use App\Controllers\Pricing;
use App\Controllers\Blog;
use App\Controllers\Contact;
use App\Controllers\CustomDevelopment; // Add this line
use App\Controllers\Panel;
use App\Controllers\PanelAuthController;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [Home::class, 'index']);
$routes->get('home', [Home::class, 'index']);
// Add these routes
$routes->get('custom-development', [CustomDevelopment::class, 'index']);
$routes->post('custom-development/quote', [CustomDevelopment::class, 'quote'], ['filter' => 'honeypot']);

$routes->post('subscribe', 'Home::subscribe');
// Other pages
$routes->get('products', [Products::class, 'index']);
$routes->get('pricing', [Pricing::class, 'index']);
$routes->get('blog', [Blog::class, 'index']);
$routes->get('contact', [Contact::class, 'index']);
$routes->post('contact/send', [Contact::class, 'send'], ['filter' => 'honeypot']);

$routes->get('news', [News::class, 'index']);
$routes->get('news/new', [News::class, 'new']); // Add this line
$routes->post('news', [News::class, 'create']); // Add this line
$routes->get('news/(:segment)', [News::class, 'show']);

$routes->match(['get', 'post'], 'panel/login', [PanelAuthController::class, 'login']);
$routes->get('panel/logout', [PanelAuthController::class, 'logout']);

$routes->group('panel', ['filter' => 'panelauth'], static function ($routes) {
    $routes->get('/', [Panel::class, 'index']);
    $routes->get('quotes', [Panel::class, 'quotes']);
    $routes->get('contacts', [Panel::class, 'contacts']);
    $routes->get('subscribers', [Panel::class, 'subscribers']);
});

$routes->get('pages', [Pages::class, 'index']);
$routes->get('(:segment)', [Pages::class, 'view']);
