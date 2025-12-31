<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <meta name="description" content="<?= esc($meta_description) ?>">
    <link rel="stylesheet" href="<?= base_url() ?>assets/fontawesome-free-7.0.0-web/css/all.min.css">

    <script src="<?= base_url() ?>assets/css/tailwindcss-3.4.16.css"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1e40af',
                        secondary: '#3b82f6',
                        accent: '#f59e0b',
                        dark: '#1f2937',
                        light: '#f3f4f6'
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-light">
    <header class="bg-white shadow-sm">
        <div class="mx-auto max-w-7xl px-6 py-4 lg:px-8 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="<?= site_url('panel') ?>" class="text-lg font-bold text-dark">Admin Panel</a>
                <span class="text-sm text-gray-500">Khybersoft</span>
            </div>
            <nav class="flex items-center gap-6">
                <a href="<?= site_url('panel/quotes') ?>" class="text-sm font-semibold text-dark hover:text-primary">Quotes</a>
                <a href="<?= site_url('panel/contacts') ?>" class="text-sm font-semibold text-dark hover:text-primary">Contacts</a>
                <a href="<?= site_url('panel/subscribers') ?>" class="text-sm font-semibold text-dark hover:text-primary">Subscribers</a>
                <a href="<?= site_url('panel/logout') ?>" class="text-sm font-semibold text-dark hover:text-primary">Logout</a>
                <a href="<?= site_url('/') ?>" class="text-sm font-semibold text-dark hover:text-primary">Back to Site</a>
            </nav>
        </div>
    </header>

    <main class="py-10">