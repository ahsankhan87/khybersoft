<?php
/** @var array $settings */
$seoTitle = ($seo['title'] ?? null) ?: (($title ?? null) ? $title . ' — ' . setting('site_name') : setting('site_name', 'Khybersoft') . ' — ' . setting('site_tagline'));
$seoDesc  = ($seo['description'] ?? null) ?: ($meta_description ?? setting('site_description'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($seoTitle) ?></title>
    <meta name="description" content="<?= esc($seoDesc) ?>">
    <?php if (! empty($seo['keywords'])): ?><meta name="keywords" content="<?= esc($seo['keywords']) ?>"><?php endif; ?>
    <meta name="robots" content="<?= esc($seo['robots'] ?? 'index,follow') ?>">
    <?php if (! empty($seo['canonical']) || ! empty($canonical)): ?><link rel="canonical" href="<?= esc($canonical ?? $seo['canonical']) ?>"><?php endif; ?>

    <!-- Open Graph -->
    <meta property="og:title" content="<?= esc($seoTitle) ?>">
    <meta property="og:description" content="<?= esc($seoDesc) ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?= esc(setting('site_name')) ?>">
    <?php $ogImg = $og_image ?? ($seo['og_image'] ?? setting('og_default_image')); ?>
    <?php if (! empty($ogImg)): ?>
    <meta property="og:image" content="<?= esc(media_url($ogImg)) ?>">
    <?php endif; ?>

    <link rel="icon" href="<?= esc(media_url(setting('favicon')) ?: base_url('favicon.ico')) ?>">
    <link rel="stylesheet" href="<?= base_url('assets/fontawesome-free-7.0.0-web/css/all.min.css') ?>">

    <!-- Tailwind CSS via CDN (migrate to Vite build later).
         Theme is generated from Config\Design — the single source of truth
         for Khybersoft design tokens. Do not hardcode colors/fonts here. -->
    <link rel="stylesheet" href="<?= base_url('assets/css/khybersoft.css') ?>">
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script>
        tailwind.config = { theme: <?= tailwind_theme_json() ?> };
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">

    <?php if (! empty($jsonLd ?? null)): ?>
    <script type="application/ld+json"><?= json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
    <?php endif; ?>
</head>
