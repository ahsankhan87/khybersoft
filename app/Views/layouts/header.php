<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <meta name="description" content="<?= esc($meta_description) ?>">
    <link rel="stylesheet" href="<?= base_url() ?>assets/fontawesome-free-7.0.0-web/css/all.min.css">

    <!-- Tailwind CSS CDN -->
    <script src="<?= base_url() ?>assets/css/tailwindcss-3.4.16.css"></script>

    <!-- Your Custom Configuration -->
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

    <!-- Navigation -->
    <header class="bg-white shadow-sm relative z-50">
        <nav class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8" aria-label="Global">
            <div class="flex lg:flex-1">
                <a href="<?= base_url() ?>" class="-m-1.5 p-1.5 flex items-center">
                    <span class="text-2xl font-bold text-dark">Khybersoft</span>
                </a>
            </div>

            <!-- Mobile menu button -->
            <div class="flex lg:hidden">
                <button type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700" onclick="toggleMobileMenu()">
                    <span class="sr-only">Open main menu</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex lg:gap-x-8">
                <a href="<?php echo base_url(); ?>" class="text-sm font-semibold leading-6 text-dark hover:text-primary">Home</a>

                <!-- Products Dropdown -->
                <div class="relative group">
                    <button class="text-sm font-semibold leading-6 text-dark hover:text-primary flex items-center">
                        Products
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="absolute -left-8 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                        <div class="py-1">
                            <a href="<?php echo base_url('products#pos') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Point of Sale (POS)</a>
                            <a href="<?php echo base_url('products#accounting') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Financial Accounting</a>
                            <a href="<?php echo base_url('products#plot') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Plot/Land Management</a>
                            <a href="<?php echo base_url('products#kasbook') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Kasbook Auto Line</a>
                            <a href="<?php echo base_url('products#school') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">School Management</a>
                            <a href="<?php echo base_url('products#loan') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Loan Management</a>
                            <a href="<?php echo base_url('products#hajj') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Hajj/Umra Management</a>
                        </div>
                    </div>
                </div>

                <a href="<?php echo base_url('pricing') ?>" class="text-sm font-semibold leading-6 text-dark hover:text-primary">Pricing</a>
                <a href="<?php echo base_url('custom-development') ?>" class="text-sm font-semibold leading-6 text-dark hover:text-primary">Custom Development</a>
                <a href="<?php echo base_url('blog') ?>" class="text-sm font-semibold leading-6 text-dark hover:text-primary">Blog</a>
                <a href="<?php echo base_url('contact') ?>" class="text-sm font-semibold leading-6 text-dark hover:text-primary">Contact</a>
            </div>

            <!-- <div class="hidden lg:flex lg:flex-1 lg:justify-end">
                <a href="<?= base_url('login') ?>" class="text-sm font-semibold leading-6 text-dark hover:text-primary">Log in <span aria-hidden="true">&rarr;</span></a>
            </div> -->
        </nav>

        <!-- Mobile menu, show/hide based on menu state -->
        <div class="lg:hidden hidden" id="mobile-menu">
            <div class="space-y-1 px-2 pb-3 pt-2 bg-white shadow-lg">
                <a href="<?= base_url() ?>" class="block rounded-md px-3 py-2 text-base font-medium text-dark hover:bg-gray-50 <?= current_url() == base_url() ? 'bg-gray-50 text-primary' : '' ?>">Home</a>
                <a href="<?= base_url('products') ?>" class="block rounded-md px-3 py-2 text-base font-medium text-dark hover:bg-gray-50 <?= current_url() == base_url('products') ? 'bg-gray-50 text-primary' : '' ?>">Products</a>
                <a href="<?= base_url('pricing') ?>" class="block rounded-md px-3 py-2 text-base font-medium text-dark hover:bg-gray-50 <?= current_url() == base_url('pricing') ? 'bg-gray-50 text-primary' : '' ?>">Pricing</a>
                <a href="<?= base_url('blog') ?>" class="block rounded-md px-3 py-2 text-base font-medium text-dark hover:bg-gray-50 <?= current_url() == base_url('blog') ? 'bg-gray-50 text-primary' : '' ?>">Blog</a>
                <a href="<?= base_url('contact') ?>" class="block rounded-md px-3 py-2 text-base font-medium text-dark hover:bg-gray-50 <?= current_url() == base_url('contact') ? 'bg-gray-50 text-primary' : '' ?>">Contact</a>
                <a href="<?= base_url('login') ?>" class="block rounded-md px-3 py-2 text-base font-medium text-dark hover:bg-gray-50">Log in</a>
            </div>
        </div>
    </header>

    <main>