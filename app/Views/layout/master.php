<?php
/**
 * Premium SaaS layout shell.
 * Data: $content, $siteName, $navMenu, plus any page data.
 */
?>
<?= view('layout/partials/head', $data ?? []) ?>
<body class="bg-white font-sans text-slate-700 antialiased"
      x-data="{ mobileOpen: false }"
      x-init="$nextTick(() => { if (window.AOS) AOS.init({ duration: 700, once: true, offset: 80 }); })">

    <?= view('front/home/sections/announcement') ?>
    <?= view('layout/partials/navbar') ?>

    <main>
        <?= $content ?? '' ?>
    </main>

    <?= view('layout/partials/footer') ?>
    <?= view('front/home/sections/floating-widgets') ?>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.9/dist/cdn.min.js"></script>
    <!-- AOS scroll animations -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">
    <script defer src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <!-- Chart.js (stats sparklines / counters helpers) -->
    <script defer src="https://cdn.jsdelivr.net/npm/chart.js@4.4.9/dist/chart.umd.min.js"></script>
    <!-- Site micro-interactions: counter animation, demo modal, announcement dismissal -->
    <script defer src="<?= base_url('js/site.js') ?>"></script>
</body>
</html>
