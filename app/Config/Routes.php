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

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [Home::class, 'index']);
$routes->get('home', [Home::class, 'index']);
// Add these routes
$routes->get('custom-development', [CustomDevelopment::class, 'index']);
$routes->post('custom-development/quote', [CustomDevelopment::class, 'quote']);

$routes->post('subscribe', 'Home::subscribe');
// Other pages
$routes->get('products', [Products::class, 'index']);
$routes->get('pricing', [Pricing::class, 'index']);
$routes->get('blog', [Blog::class, 'index']);
$routes->get('contact', [Contact::class, 'index']);
$routes->post('contact/send', [Contact::class, 'send']);

$routes->get('news', [News::class, 'index']);
$routes->get('news/new', [News::class, 'new']); // Add this line
$routes->post('news', [News::class, 'create']); // Add this line
$routes->get('news/(:segment)', [News::class, 'show']);

$routes->get('pages', [Pages::class, 'index']);
$routes->get('(:segment)', [Pages::class, 'view']);
