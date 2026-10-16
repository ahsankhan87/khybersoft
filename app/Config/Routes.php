<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('subscribe', 'Home::subscribe');
$routes->get('newsletter/confirm/(:segment)', 'Home::confirm/$1');
$routes->get('newsletter/unsubscribe/(:segment)', 'Home::unsubscribe/$1');

// Front pages (DB-driven, admin-editable)
$routes->get('about', 'FrontPage::about');
$routes->get('contact', 'FrontPage::contact');
$routes->post('contact', 'FrontPage::submitContact');
$routes->get('blogs', 'FrontPage::blogList');
$routes->get('blog/(:segment)', 'FrontPage::blogSingle/$1');
$routes->get('page/(:segment)', 'FrontPage::show/$1');
$routes->get('search', 'FrontPage::search');

// Admin panel
$routes->group('admin', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'Admin\Dashboard::index');
    $routes->get('dashboard', 'Admin\Dashboard::index');

    // Settings
    $routes->get('settings', 'Admin\Settings::index');
    $routes->post('settings/save', 'Admin\Settings::save');

    // Homepage content groups
    $routes->group('homepage', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
        $routes->get('products', 'Products::index');
        $routes->get('products/create', 'Products::create');
        $routes->post('products/store', 'Products::store');
        $routes->get('products/edit/(:num)', 'Products::edit/$1');
        $routes->post('products/update/(:num)', 'Products::update/$1');
        $routes->post('products/delete/(:num)', 'Products::delete/$1');
        $routes->get('categories', 'Categories::index');
        $routes->post('categories/save', 'Categories::save');
        $routes->get('clients', 'Clients::index');
        $routes->post('clients/save', 'Clients::save');
        $routes->post('clients/delete/(:num)', 'Clients::delete/$1');
        $routes->get('testimonials', 'Testimonials::index');
        $routes->post('testimonials/save', 'Testimonials::save');
        $routes->post('testimonials/delete/(:num)', 'Testimonials::delete/$1');
        $routes->get('stories', 'Stories::index');
        $routes->post('stories/save', 'Stories::save');
        $routes->post('stories/delete/(:num)', 'Stories::delete/$1');
        $routes->get('integrations', 'Integrations::index');
        $routes->post('integrations/save', 'Integrations::save');
        $routes->post('integrations/delete/(:num)', 'Integrations::delete/$1');
    });

    // Media library
    $routes->group('media', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
        $routes->get('/', 'Media::index');
        $routes->post('upload', 'Media::upload');
        $routes->post('folder', 'Media::makeFolder');
        $routes->post('rename/(:num)', 'Media::rename/$1');
        $routes->post('move/(:num)', 'Media::move/$1');
        $routes->post('delete/(:num)', 'Media::delete/$1');
        $routes->post('bulk-delete', 'Media::bulkDelete');
        $routes->post('bulk-move', 'Media::bulkMove');
        $routes->get('folders', 'Media::foldersJson');
        $routes->get('list', 'Media::listJson');
    });

    // News
    $routes->group('news', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
        $routes->get('/', 'News::index');
        $routes->get('create', 'News::create');
        $routes->post('store', 'News::store');
        $routes->get('edit/(:num)', 'News::edit/$1');
        $routes->post('update/(:num)', 'News::update/$1');
        $routes->post('toggle/(:num)', 'News::toggle/$1');
        $routes->post('delete/(:num)', 'News::delete/$1');
    });

    // Contact messages
    $routes->group('contact-messages', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
        $routes->get('/', 'ContactMessages::index');
        $routes->get('view/(:num)', 'ContactMessages::view/$1');
        $routes->post('reply/(:num)', 'ContactMessages::reply/$1');
        $routes->post('status/(:num)', 'ContactMessages::setStatus/$1');
        $routes->post('delete/(:num)', 'ContactMessages::delete/$1');
    });

    // Subscribers
    $routes->group('subscribers', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
        $routes->get('/', 'Subscribers::index');
        $routes->get('export', 'Subscribers::export');
        $routes->get('campaigns', 'Campaigns::index');
        $routes->get('campaigns/create', 'Campaigns::create');
        $routes->post('campaigns/store', 'Campaigns::store');
        $routes->get('campaigns/edit/(:num)', 'Campaigns::edit/$1');
        $routes->post('campaigns/update/(:num)', 'Campaigns::update/$1');
        $routes->post('campaigns/send/(:num)', 'Campaigns::send/$1');
        $routes->post('campaigns/test/(:num)', 'Campaigns::sendTest/$1');
        $routes->post('campaigns/delete/(:num)', 'Campaigns::delete/$1');
    });

    // Menus
    $routes->group('menus', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
        $routes->get('manager/(:segment)', 'Menus::manage/$1');
        $routes->post('items/save', 'Menus::saveItem');
        $routes->post('items/delete/(:num)', 'Menus::deleteItem/$1');
        $routes->post('items/reorder', 'Menus::reorder');
    });

    // Users & roles
    $routes->group('users', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
        $routes->get('/', 'Users::index');
        $routes->get('create', 'Users::create');
        $routes->post('store', 'Users::store');
        $routes->get('edit/(:num)', 'Users::edit/$1');
        $routes->post('update/(:num)', 'Users::update/$1');
        $routes->post('toggle/(:num)', 'Users::toggle/$1');
        $routes->post('reset-password/(:num)', 'Users::resetPassword/$1');
        $routes->post('delete/(:num)', 'Users::delete/$1');
    });
    $routes->group('roles', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
        $routes->get('/', 'Roles::index');
        $routes->get('permissions/(:num)', 'Roles::permissions/$1');
        $routes->post('permissions/save/(:num)', 'Roles::savePermissions/$1');
    });
});

// Auth routes
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attemptLogin');
$routes->get('forgot-password', 'Auth::forgotPassword');
$routes->post('forgot-password', 'Auth::sendResetLink');
$routes->get('reset-password', 'Auth::resetPassword');
$routes->post('reset-password', 'Auth::doResetPassword');
$routes->get('logout', 'Auth::logout');
$routes->group('two-factor', static function ($routes) {
    $routes->get('verify', 'TwoFactor::verify');
    $routes->post('verify', 'TwoFactor::attemptVerify');
    $routes->get('setup', 'TwoFactor::setup');
    $routes->post('enable', 'TwoFactor::enable');
    $routes->post('disable', 'TwoFactor::disable');
    $routes->get('backup-codes', 'TwoFactor::backupCodes');
    $routes->post('regenerate-backup-codes', 'TwoFactor::regenerateBackupCodes');
});
