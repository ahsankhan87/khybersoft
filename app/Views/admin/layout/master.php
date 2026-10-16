<?php
/** @var array|null $adminUser  @var callable $can */
$nav = [
    ['dashboard',      'Dashboard',      '/admin',                    'fa-solid fa-gauge-high'],
    ['leads',          'Leads & Inquiries','/admin/leads',            'fa-solid fa-inbox'],
    ['subscribers',    'Subscribers',    '/admin/subscribers',        'fa-solid fa-envelope-open-text'],
    ['pages',          'Pages',          '/admin/pages',              'fa-solid fa-file-lines'],
    ['menus',          'Menus',          '/admin/menus',              'fa-solid fa-list-ul'],
    ['blog',           'Blog',           '/admin/posts',              'fa-solid fa-newspaper'],
    ['products',       'Products',       '/admin/products',           'fa-solid fa-cube'],
    ['testimonials',   'Testimonials',   '/admin/testimonials',       'fa-solid fa-quote-left'],
    ['clients',        'Clients',        '/admin/clients',            'fa-solid fa-building'],
    ['tutorials',      'Help Center',    '/admin/tutorials',          'fa-solid fa-circle-play'],
    ['media',          'Media Library',  '/admin/media',              'fa-solid fa-photo-film'],
    ['settings.manage','Settings',       '/admin/settings',           'fa-solid fa-gear'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Admin') ?> — <?= esc(setting('site_name')) ?> Panel</title>
    <meta name="robots" content="noindex,nofollow">
    <link rel="stylesheet" href="<?= base_url('assets/fontawesome-free-7.0.0-web/css/all.min.css') ?>">
    <!-- Design tokens: Config\Design is the single source of truth -->
    <link rel="stylesheet" href="<?= base_url('assets/css/khybersoft.css') ?>">
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script>tailwind.config = { theme: <?= tailwind_theme_json() ?> };</script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="bg-slate-100 text-slate-800 antialiased" x-data="{ sidebarOpen: false }">
<div class="min-h-screen flex">

    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 z-40 w-64 bg-slate-900 text-slate-300 transform transition lg:translate-x-0 lg:static"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
        <div class="flex items-center gap-2 px-6 py-5 border-b border-slate-800">
            <span class="text-xl font-extrabold text-white"><?= esc(setting('site_name', 'Khybersoft')) ?><span class="text-blue-500">.</span></span>
            <span class="ml-auto rounded bg-blue-600/20 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-blue-400">Panel</span>
        </div>
        <nav class="mt-4 space-y-1 px-3 pb-10 overflow-y-auto max-h-[calc(100vh-90px)]">
            <?php foreach ($nav as [$perm, $label, $url, $icon]): if (! ($can)($perm)) continue; ?>
                <a href="<?= site_url(ltrim($url, '/')) ?>"
                   class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                          <?= ($currentAdminPath ?? '/') === $url ? 'bg-blue-600 text-white' : 'hover:bg-slate-800 hover:text-white' ?>">
                    <i class="<?= $icon ?> w-5 text-center"></i><?= esc($label) ?>
                </a>
            <?php endforeach; ?>
        </nav>
    </aside>

    <!-- Main -->
    <div class="flex-1 min-w-0 flex flex-col">
        <header class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-slate-200 bg-white px-4 sm:px-6">
            <div class="flex items-center gap-3">
                <button class="lg:hidden rounded-md p-2 hover:bg-slate-100" @click="sidebarOpen = !sidebarOpen"><i class="fa-solid fa-bars"></i></button>
                <h1 class="text-lg font-semibold text-slate-900"><?= esc($heading ?? $title ?? 'Admin') ?></h1>
            </div>
            <div class="flex items-center gap-4">
                <a href="<?= base_url('/') ?>" target="_blank" class="hidden sm:inline-flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-primary">
                    <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i> View Site
                </a>
                <div class="flex items-center gap-3">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-semibold leading-tight text-slate-900"><?= esc($adminUser['name'] ?? '') ?></p>
                        <p class="text-xs text-slate-500 capitalize"><?= esc(str_replace('_', ' ', $roleSlug ?? '')) ?></p>
                    </div>
                    <span class="flex h-9 w-9 items-center justify-center rounded-full bg-blue-600 text-sm font-bold text-white">
                        <?= strtoupper(substr($adminUser['name'] ?? 'A', 0, 1)) ?>
                    </span>
                    <a href="<?= site_url('admin/logout') ?>" class="text-sm font-medium text-red-600 hover:text-red-700">Logout</a>
                </div>
            </div>
        </header>

        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="mb-5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800"><?= esc(session()->getFlashdata('success')) ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"><?= esc(session()->getFlashdata('error')) ?></div>
            <?php endif; ?>
            <?php if ($errors = session()->getFlashdata('errors')): ?>
                <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <?php foreach ((array) $errors as $e): ?><p>• <?= esc($e) ?></p><?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?= $this->renderSection('content') ?>
        </main>
    </div>
</div>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.9/dist/cdn.min.js"></script>
</body>
</html>
