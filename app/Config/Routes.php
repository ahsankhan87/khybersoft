<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->post('subscribe', 'Home::subscribe');
$routes->get('newsletter/confirm/(:segment)', 'Home::confirm/$1');
$routes->get('newsletter/unsubscribe/(:segment)', 'Home::unsubscribe/$1');

$routes->get('products', 'Products::index');
$routes->get('products/category/(:segment)', 'Products::category/$1');
$routes->post('products/lead', 'Products::leadRequest');
$routes->get('products/(:segment)', 'Products::show/$1');

$routes->get('pricing', 'Pricing::index');
$routes->get('custom-development', 'CustomDevelopment::index');
$routes->post('custom-development/quote', 'CustomDevelopment::quote');
$routes->get('about', 'FrontPage::about');
$routes->get('contact', 'Contact::index');
$routes->post('contact', 'Contact::send');
$routes->post('contact/send', 'Contact::send');
$routes->get('blogs', 'Blog::index');
$routes->get('blog', 'Blog::index');
$routes->get('blogs/(:segment)', 'Blog::show/$1');
$routes->get('blog/(:segment)', 'Blog::show/$1');
$routes->get('news', 'News::index');
$routes->get('news/(:segment)', 'News::show/$1');
$routes->get('page/(:segment)', 'Page::show/$1');
$routes->get('search', 'FrontPage::search');

// Success stories & partners
$routes->get('success-stories', 'FrontPage::successStories');
$routes->get('success-stories/(:segment)', 'FrontPage::successStory/$1');
$routes->get('partners', 'FrontPage::partners');

// Resources
$routes->get('help', 'Resources::help');
$routes->get('tutorials', 'Resources::tutorials');
$routes->get('tutorials/(:segment)', 'Resources::tutorial/$1');
$routes->get('docs', 'Resources::docs');
$routes->get('docs/api', 'Resources::apiDocs');
$routes->get('status', 'Resources::status');
$routes->get('changelog', 'Resources::changelog');

// Legal (CMS pages, seeded + editable in Admin → Pages)
$routes->get('privacy-policy', 'Page::show/privacy-policy');
$routes->get('terms-of-use', 'Page::show/terms-of-use');
$routes->get('terms', static fn () => redirect()->to('/terms-of-use'));
$routes->get('refund-policy', 'Page::show/refund-policy');

// Admin routes are explicit so each panel link resolves to a real controller action.
$routes->group('admin', ['filter' => 'adminauth'], static function ($routes) {
    $routes->get('/', '\App\Controllers\Admin\Dashboard::index');
    $routes->get('dashboard', '\App\Controllers\Admin\Dashboard::index');

    $routes->group('settings', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
        $routes->get('/', 'Settings::index');
        $routes->get('(:segment)', 'Settings::group/$1');
        $routes->post('save/(:segment)', 'Settings::save/$1');
    });

    $routes->group('leads', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
        $routes->get('/', 'Leads::index');
        $routes->get('export', 'Leads::exportCsv');
        $routes->get('(:num)', 'Leads::show/$1');
        $routes->post('(:num)/status', 'Leads::updateStatus/$1');
        $routes->post('(:num)/assign', 'Leads::assign/$1');
        $routes->post('(:num)/note', 'Leads::note/$1');
        $routes->post('(:num)/delete', 'Leads::delete/$1');
        $routes->post('bulk', 'Leads::bulk');
    });
    $routes->group('pages', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
        $routes->get('/', 'Pages::index');
        $routes->get('create', 'Pages::create');
        $routes->post('store', 'Pages::store');
        $routes->get('edit/(:num)', 'Pages::edit/$1');
        $routes->post('update/(:num)', 'Pages::update/$1');
        $routes->post('delete/(:num)', 'Pages::delete/$1');
    });
    $routes->group('menus', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
        $routes->get('/', 'Menus::index');
        $routes->post('/', 'Menus::save');
        $routes->post('item', 'Menus::addItem');
        $routes->post('item/(:num)', 'Menus::updateItem/$1');
        $routes->post('item/(:num)/delete', 'Menus::deleteItem/$1');
        $routes->get('items/(:num)', 'Menus::items/$1');
        $routes->post('items/reorder', 'Menus::reorder');
    });
    $routes->group('posts', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
        $routes->get('/', 'Posts::index');
        $routes->get('create', 'Posts::create');
        $routes->post('store', 'Posts::store');
        $routes->get('edit/(:num)', 'Posts::edit/$1');
        $routes->post('update/(:num)', 'Posts::update/$1');
        $routes->post('delete/(:num)', 'Posts::delete/$1');
        $routes->post('bulk', 'Posts::bulk');
    });
    $routes->group('products', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
        $routes->get('/', 'Products::index');
        $routes->get('create', 'Products::create');
        $routes->post('store', 'Products::store');
        $routes->get('edit/(:num)', 'Products::edit/$1');
        $routes->post('update/(:num)', 'Products::update/$1');
        $routes->post('delete/(:num)', 'Products::delete/$1');
        $routes->post('toggle/(:num)', 'Products::toggleStatus/$1');
    });
    $routes->group('subscribers', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
        $routes->get('/', 'Subscribers::index');
        $routes->get('export', 'Subscribers::exportCsv');
        $routes->post('status/(:num)', 'Subscribers::setStatus/$1');
        $routes->post('delete/(:num)', 'Subscribers::delete/$1');
    });
    $routes->group('media', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
        $routes->get('/', 'Media::index');
        $routes->post('upload', 'Media::upload');
        $routes->post('update/(:num)', 'Media::update/$1');
        $routes->post('delete/(:num)', 'Media::delete/$1');
        $routes->post('bulk-delete', 'Media::bulkDelete');
        $routes->get('list', 'Media::listJson');
    });
    $routes->group('testimonials', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
        $routes->get('/', 'Testimonials::index');
        $routes->get('create', 'Testimonials::create');
        $routes->post('store', 'Testimonials::store');
        $routes->get('edit/(:num)', 'Testimonials::edit/$1');
        $routes->post('update/(:num)', 'Testimonials::update/$1');
        $routes->post('delete/(:num)', 'Testimonials::delete/$1');
        $routes->post('toggle/(:num)', 'Testimonials::toggle/$1');
        $routes->post('import', 'Testimonials::import');
    });
    $routes->group('clients', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
        $routes->get('/', 'Clients::index');
        $routes->get('create', 'Clients::create');
        $routes->get('edit/(:num)', 'Clients::edit/$1');
        $routes->post('save', 'Clients::save');
        $routes->post('save/(:num)', 'Clients::save/$1');
        $routes->post('delete/(:num)', 'Clients::delete/$1');
        $routes->post('toggle/(:num)', 'Clients::toggle/$1');
    });
    $routes->group('tutorials', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
        $routes->get('/', 'Tutorials::index');
        $routes->get('create', 'Tutorials::create');
        $routes->post('store', 'Tutorials::store');
        $routes->get('edit/(:num)', 'Tutorials::edit/$1');
        $routes->post('update/(:num)', 'Tutorials::update/$1');
        $routes->post('delete/(:num)', 'Tutorials::delete/$1');
        $routes->post('toggle/(:num)', 'Tutorials::toggle/$1');
    });
    $routes->group('tutorial-categories', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
        $routes->get('/', 'TutorialCategories::index');
        $routes->post('save', 'TutorialCategories::save');
        $routes->post('delete/(:num)', 'TutorialCategories::delete/$1');
    });
    $routes->group('contacts', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
        $routes->get('/', 'Contacts::index');
        $routes->get('(:num)', 'Contacts::show/$1');
        $routes->post('(:num)/reply', 'Contacts::reply/$1');
        $routes->post('(:num)/status', 'Contacts::setStatus/$1');
        $routes->post('(:num)/delete', 'Contacts::delete/$1');
    });
    $routes->group('contact-messages', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
        $routes->get('/', 'Contacts::index');
        $routes->get('view/(:num)', 'Contacts::show/$1');
        $routes->post('reply/(:num)', 'Contacts::reply/$1');
        $routes->post('status/(:num)', 'Contacts::setStatus/$1');
        $routes->post('delete/(:num)', 'Contacts::delete/$1');
    });
    $routes->group('users', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
        $routes->get('/', 'Users::index');
        $routes->post('store', 'Users::store');
        $routes->post('update/(:num)', 'Users::update/$1');
        $routes->post('delete/(:num)', 'Users::delete/$1');
        $routes->post('reset-2fa/(:num)', 'Users::reset2fa/$1');
        $routes->get('profile', 'Users::profile');
        $routes->post('profile', 'Users::saveProfile');
        $routes->get('security', 'Users::security');
        $routes->get('2fa/setup', 'Users::twoFactorSetup');
        $routes->post('2fa/enable', 'Users::twoFactorEnable');
        $routes->post('2fa/disable', 'Users::twoFactorDisable');
    });
    $routes->group('roles', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
        $routes->get('/', 'Roles::index');
        $routes->post('save', 'Roles::save');
        $routes->post('delete/(:num)', 'Roles::delete/$1');
    });
    $routes->group('seo', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
        $routes->get('/', 'Seo::index');
        $routes->get('edit', 'Seo::edit');
        $routes->post('save', 'Seo::save');
        $routes->post('delete/(:num)', 'Seo::delete/$1');
    });

    $routes->group('homepage', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
        $routes->get('products', 'Products::index');
        $routes->get('products/create', 'Products::create');
        $routes->post('products/store', 'Products::store');
        $routes->get('products/edit/(:num)', 'Products::edit/$1');
        $routes->post('products/update/(:num)', 'Products::update/$1');
        $routes->post('products/delete/(:num)', 'Products::delete/$1');
        $routes->get('categories', 'Categories::index');
        $routes->post('categories/save', 'Categories::save');
        $routes->post('categories/delete/(:num)', 'Categories::delete/$1');
        $routes->get('clients', 'Clients::index');
        $routes->post('clients/save', 'Clients::save');
        $routes->post('clients/delete/(:num)', 'Clients::delete/$1');
        $routes->get('testimonials', 'Testimonials::index');
        $routes->post('testimonials/save', 'Testimonials::store');
        $routes->post('testimonials/delete/(:num)', 'Testimonials::delete/$1');
        $routes->get('stories', 'Stories::index');
        $routes->post('stories/save', 'Stories::save');
        $routes->post('stories/delete/(:num)', 'Stories::delete/$1');
        $routes->get('integrations', 'Integrations::index');
        $routes->post('integrations/save/(:num)', 'Integrations::save/$1');
        $routes->post('integrations/test/(:num)', 'Integrations::test/$1');
    });
    $routes->group('activity', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
        $routes->get('/', 'Activity::index');
        $routes->post('purge', 'Activity::purge');
    });
    $routes->group('announcements', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
        $routes->get('/', 'Announcements::index');
        $routes->post('save', 'Announcements::save');
        $routes->post('delete/(:num)', 'Announcements::delete/$1');
        $routes->post('toggle/(:num)', 'Announcements::toggle/$1');
    });
    $routes->group('careers', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
        $routes->get('/', 'Careers::index');
        $routes->post('save', 'Careers::save');
        $routes->post('delete/(:num)', 'Careers::delete/$1');
        $routes->get('applications', 'Careers::applications');
        $routes->post('applications/(:num)/status', 'Careers::setAppStatus/$1');
    });
    $routes->group('comments', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
        $routes->get('/', 'Comments::index');
        $routes->post('(:num)/status', 'Comments::setStatus/$1');
        $routes->post('(:num)/reply', 'Comments::reply/$1');
        $routes->post('(:num)/delete', 'Comments::delete/$1');
    });
    $routes->group('faqs', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
        $routes->get('/', 'Faqs::index');
        $routes->post('save', 'Faqs::save');
        $routes->post('delete/(:num)', 'Faqs::delete/$1');
        $routes->post('toggle/(:num)', 'Faqs::toggle/$1');
    });
    $routes->group('integrations', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
        $routes->get('/', 'Integrations::index');
        $routes->post('save/(:num)', 'Integrations::save/$1');
        $routes->post('test/(:num)', 'Integrations::test/$1');
    });
    $routes->group('quotes', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
        $routes->get('/', 'Quotes::index');
        $routes->get('(:num)', 'Quotes::show/$1');
        $routes->post('(:num)/status', 'Quotes::updateStatus/$1');
        $routes->post('(:num)/delete', 'Quotes::delete/$1');
    });
    $routes->group('redirects', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
        $routes->get('/', 'Redirects::index');
        $routes->post('save', 'Redirects::save');
        $routes->post('delete/(:num)', 'Redirects::delete/$1');
        $routes->post('toggle/(:num)', 'Redirects::toggle/$1');
    });
    $routes->group('services', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
        $routes->get('/', 'Services::index');
        $routes->post('save', 'Services::save');
        $routes->post('delete/(:num)', 'Services::delete/$1');
        $routes->post('toggle/(:num)', 'Services::toggle/$1');
    });
    $routes->group('spam', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
        $routes->get('/', 'Spam::index');
        $routes->post('rules', 'Spam::addRule');
        $routes->post('rules/(:num)/delete', 'Spam::deleteRule/$1');
        $routes->post('leads/junk', 'Spam::markLeadsJunk');
    });
    $routes->group('tags', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
        $routes->get('/', 'Tags::index');
        $routes->post('save', 'Tags::save');
        $routes->post('delete/(:num)', 'Tags::delete/$1');
    });
    $routes->group('team', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
        $routes->get('/', 'Team::index');
        $routes->post('save', 'Team::save');
        $routes->post('delete/(:num)', 'Team::delete/$1');
        $routes->post('toggle/(:num)', 'Team::toggle/$1');
    });
    $routes->group('whatsapp', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
        $routes->get('/', 'Whatsapp::index');
        $routes->post('departments/save', 'Whatsapp::saveDept');
        $routes->post('departments/delete/(:num)', 'Whatsapp::deleteDept/$1');
        $routes->post('track', 'Whatsapp::track');
    });
    $routes->group('versions', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
        $routes->get('/', 'Versions::index');
        $routes->post('save', 'Versions::save');
        $routes->post('delete/(:num)', 'Versions::delete/$1');
    });
});

$routes->get('login', static fn () => redirect()->to('/admin/login'));
$routes->get('logout', 'Admin\Auth::logout');
$routes->get('admin/login', 'Admin\Auth::loginForm');
$routes->post('admin/login', 'Admin\Auth::attemptLogin');
$routes->get('admin/login/2fa', 'Admin\Auth::twoFactorForm');
$routes->post('admin/login/2fa', 'Admin\Auth::verifyTwoFactor');
$routes->get('admin/login/forgot', 'Admin\Auth::forgotForm');
$routes->post('admin/login/forgot', 'Admin\Auth::sendReset');
$routes->get('admin/reset-password/(:segment)', 'Admin\Auth::resetForm/$1');
$routes->post('admin/reset-password', 'Admin\Auth::doReset');
$routes->get('admin/logout', 'Admin\Auth::logout');
