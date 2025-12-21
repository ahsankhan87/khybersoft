<!-- Hero Section -->
<section class="relative isolate px-6 pt-14 lg:px-8">
    <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
        <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-secondary to-accent opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"></div>
    </div>

    <div class="mx-auto max-w-7xl py-32 sm:py-48 lg:py-56">
        <div class="text-center">
            <h1 class="text-4xl font-bold tracking-tight text-dark sm:text-6xl">
                Comprehensive Business Solutions for Every Industry
            </h1>
            <p class="mt-6 text-xl leading-8 text-gray-600 max-w-3xl mx-auto">
                Khybersoft delivers enterprise-grade software solutions that streamline operations, enhance productivity, and drive growth for businesses worldwide.
            </p>
            <div class="mt-10 flex items-center justify-center gap-x-6">
                <a href="<?= site_url('products') ?>" class="rounded-md bg-primary px-6 py-3.5 text-base font-semibold text-white shadow-sm hover:bg-[#1e3a8a] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary">Explore Our Products</a>
                <a href="<?= site_url('custom-development') ?>" class="text-base font-semibold leading-6 text-dark hover:text-primary flex items-center">Custom Solutions <span aria-hidden="true" class="ml-1">→</span></a>
            </div>
        </div>
    </div>

    <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]" aria-hidden="true">
        <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-secondary to-accent opacity-30 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]"></div>
    </div>
</section>

<!-- Trusted By Section -->
<section class="py-16 bg-light">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-lg font-semibold text-primary">Trusted by Businesses Across Industries</h2>
            <div class="mt-8 grid grid-cols-2 gap-8 md:grid-cols-6 lg:grid-cols-5">
                <div class="col-span-1 flex justify-center md:col-span-2 lg:col-span-1">
                    <div class="h-12 bg-gray-300 rounded-lg flex items-center justify-center px-4">
                        <span class="font-bold text-dark">Retail</span>
                    </div>
                </div>
                <div class="col-span-1 flex justify-center md:col-span-2 lg:col-span-1">
                    <div class="h-12 bg-gray-300 rounded-lg flex items-center justify-center px-4">
                        <span class="font-bold text-dark">Education</span>
                    </div>
                </div>
                <div class="col-span-1 flex justify-center md:col-span-2 lg:col-span-1">
                    <div class="h-12 bg-gray-300 rounded-lg flex items-center justify-center px-4">
                        <span class="font-bold text-dark">Finance</span>
                    </div>
                </div>
                <div class="col-span-1 flex justify-center md:col-span-2 lg:col-span-1">
                    <div class="h-12 bg-gray-300 rounded-lg flex items-center justify-center px-4">
                        <span class="font-bold text-dark">Real Estate</span>
                    </div>
                </div>
                <div class="col-span-2 flex justify-center md:col-span-4 lg:col-span-1">
                    <div class="h-12 bg-gray-300 rounded-lg flex items-center justify-center px-4">
                        <span class="font-bold text-dark">Automotive</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="py-24">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-bold tracking-tight text-dark sm:text-4xl">Our Featured Solutions</h2>
            <p class="mt-4 text-xl text-gray-600">Comprehensive software solutions designed for specific industry needs</p>
        </div>

        <div class="mt-16 grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
            <!-- POS System -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="mt-4 text-xl font-semibold text-dark">Point of Sale (POS)</h3>
                <p class="mt-2 text-gray-600">Complete retail management with inventory, sales, customer management, and real-time reporting.</p>
                <div class="mt-4">
                    <a href="https://pos.khybersoft.com/demo/" target="_blank" class="text-primary hover:text-secondary font-semibold text-sm">Live Demo →</a>
                </div>
            </div>

            <!-- Accounting System -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h3 class="mt-4 text-xl font-semibold text-dark">Financial Accounting</h3>
                <p class="mt-2 text-gray-600">Enterprise-grade accounting software with GL, AP/AR, payroll, and comprehensive financial reporting.</p>
                <div class="mt-4">
                    <a href="https://accounts.khybersoft.com/" target="_blank" class="text-primary hover:text-secondary font-semibold text-sm">Live Demo →</a>
                </div>
            </div>

            <!-- School Management -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v6l9-5m-9 5l-9-5m9 5v-6"></path>
                    </svg>
                </div>
                <h3 class="mt-4 text-xl font-semibold text-dark">School Management</h3>
                <p class="mt-2 text-gray-600">Complete educational institution management with student, teacher, fee, and academic tracking.</p>
                <a href="<?= site_url('products#school'); ?>" class="mt-4 inline-block text-primary hover:text-secondary font-semibold text-sm">Learn More →</a>
            </div>
        </div>

        <div class="mt-12 text-center">
            <a href="<?php echo site_url('products'); ?>" class="rounded-md bg-primary px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-[#1e3a8a] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary">
                View All 7 Products
            </a>
        </div>
    </div>
</section>

<!-- Custom Development Section -->
<section class="bg-gradient-to-r from-primary to-secondary py-20">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">Custom Software Development</h2>
            <p class="mt-4 text-xl text-blue-100 max-w-3xl mx-auto">
                Need a tailored solution? Our expert team delivers custom software and web applications designed specifically for your business requirements.
            </p>
            <div class="mt-8">
                <a href="<?php echo site_url('custom-development'); ?>" class="rounded-md bg-white px-6 py-3 text-sm font-semibold text-primary shadow-sm hover:bg-gray-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                    Get Custom Quote
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-24 bg-light">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-bold tracking-tight text-dark sm:text-4xl">Why Choose Khybersoft?</h2>
        </div>

        <div class="mt-16 grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-4">
            <div class="text-center">
                <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-semibold text-dark">Proven Expertise</h3>
                <p class="mt-2 text-gray-600">7+ specialized products with hundreds of satisfied clients worldwide</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-semibold text-dark">Comprehensive Support</h3>
                <p class="mt-2 text-gray-600">24/7 technical support, training, and regular updates</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-semibold text-dark">Secure & Reliable</h3>
                <p class="mt-2 text-gray-600">Enterprise-grade security with regular backups and data protection</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-semibold text-dark">Scalable Solutions</h3>
                <p class="mt-2 text-gray-600">Grow with software that scales with your business needs</p>
            </div>
        </div>
    </div>
</section>
<!-- Display success/error messages -->
<div class="mx-auto mt-6 max-w-md text-center">
    <?php if (session()->has('success')): ?>
        <div class="rounded-md bg-green-50 p-4">
            <p class="text-sm font-medium text-green-800"><?= session('success') ?></p>
        </div>
    <?php endif; ?>

    <?php if (session()->has('error')): ?>
        <div class="rounded-md bg-red-50 p-4">
            <p class="text-sm font-medium text-red-800"><?= session('error') ?></p>
        </div>
    <?php endif; ?>

    <?php if (session()->has('errors')): ?>
        <div class="rounded-md bg-red-50 p-4">
            <?php foreach (session('errors') as $error): ?>
                <p class="text-sm font-medium text-red-800"><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<!-- Newsletter Subscription Section -->
<section class="py-16 bg-white">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="bg-gradient-to-r from-primary to-secondary rounded-3xl p-12 text-center">
            <h2 class="text-3xl font-bold text-white">Stay Ahead with Khybersoft</h2>
            <p class="mt-4 text-xl text-blue-100">Get industry insights, product updates, and exclusive offers</p>

            <form method="post" action="<?= site_url('subscribe') ?>" class="mt-8 max-w-md mx-auto sm:flex">
                <?= csrf_field() ?>
                <label for="email" class="sr-only">Email address</label>
                <input id="email" name="email" type="email" autocomplete="email" required class="w-full min-w-0 appearance-none rounded-md border-0 bg-white px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6" placeholder="Enter your email">
                <div class="mt-4 sm:ml-4 sm:mt-0 sm:flex-shrink-0">
                    <button type="submit" class="flex w-full items-center justify-center rounded-md bg-white px-4 py-3 text-sm font-semibold text-primary shadow-sm hover:bg-gray-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">Subscribe</button>
                </div>
            </form>
        </div>
    </div>
</section>