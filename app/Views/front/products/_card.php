<?php
/** Shared product card. Vars: $p (product array), $listMode (bool) */
$feats = json_decode((string) ($p['top_features'] ?? '[]'), true) ?: [];
$href  = site_url_path('/products/' . $p['slug']);
?>
<div class="group relative <?= $listMode ? 'flex flex-col sm:flex-row gap-5' : '' ?> rounded-3xl border border-slate-200/70 bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-glow">
    <div class="absolute inset-0 rounded-3xl opacity-0 transition group-hover:opacity-100 pointer-events-none" style="background:linear-gradient(135deg,rgb(79 70 229/.08),rgb(124 58 237/.08));"></div>
    <?php if (! empty($p['is_featured'])): ?>
        <span class="absolute right-5 top-5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-600 ring-1 ring-emerald-200"><i class="fa-solid fa-star mr-1"></i>Popular</span>
    <?php endif; ?>

    <div class="<?= $listMode ? 'shrink-0' : '' ?>">
        <div class="grid h-14 w-14 place-items-center rounded-2xl bg-gradient-to-br <?= esc($p['color'] ?: 'from-indigo-500 to-violet-500') ?> text-2xl text-white shadow-soft">
            <i class="<?= esc($p['icon'] ?: 'fa-solid fa-cube') ?>"></i>
        </div>
    </div>

    <div class="relative mt-4 <?= $listMode ? 'mt-0 flex-1' : '' ?>">
        <h3 class="font-display text-lg font-extrabold text-slate-900"><?= esc($p['name']) ?></h3>
        <p class="mt-1 text-sm text-slate-500"><?= esc($p['tagline']) ?></p>

        <?php if ($feats): ?>
        <ul class="mt-4 flex flex-wrap gap-2">
            <?php foreach (array_slice($feats, 0, 3) as $f): ?>
                <li class="rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700"><i class="fa-solid fa-check mr-1 text-emerald-500"></i><?= esc($f) ?></li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>

        <div class="mt-5 flex items-center gap-4">
            <?php if ($p['price_from'] !== null): ?>
                <span class="text-sm font-bold text-slate-900">from <?= esc(number_format((float) $p['price_from'])) ?> <span class="font-medium text-slate-400"><?= esc($p['currency']) ?>/mo</span></span>
            <?php else: ?>
                <span class="text-sm font-bold text-slate-900">Custom quote</span>
            <?php endif; ?>
        </div>

        <div class="mt-4 flex flex-wrap gap-3">
            <a href="<?= $href ?>" class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-primary to-violet px-4 py-2 text-sm font-semibold text-white shadow-soft transition hover:opacity-90">Learn more <i class="fa-solid fa-arrow-right text-xs"></i></a>
            <a href="<?= $href ?>#lead-form" class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-primary hover:text-primary">Book demo</a>
        </div>
    </div>
</div>
