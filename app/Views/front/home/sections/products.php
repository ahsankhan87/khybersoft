<?php /* Section 6 — Products showcase with Alpine category tabs */ ?>
<section class="bg-gradient-to-b from-slate-50 to-white py-24" id="products">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">
        <div class="mx-auto max-w-2xl text-center" data-aos="fade-up">
            <p class="text-sm font-bold uppercase tracking-widest text-primary">Products</p>
            <h2 class="mt-3 font-display text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">
                <?= esc(setting('products_heading', 'One platform. Every business need.')) ?>
            </h2>
        </div>

        <?php if (! empty($productGroups)): ?>
        <div x-data="{ tab: <?= esc(json_encode($productGroups[0]['category']['slug'])) ?> }" class="mt-12">
            <!-- Category tabs -->
            <div class="flex flex-wrap justify-center gap-2">
                <?php foreach ($productGroups as $g): $c = $g['category']; ?>
                    <button type="button" @click="tab = <?= esc(json_encode($c['slug'])) ?>"
                            class="inline-flex items-center gap-2 rounded-full border px-5 py-2.5 text-sm font-semibold transition-all duration-200"
                            :class="tab === <?= esc(json_encode($c['slug'])) ?>
                                ? 'border-transparent bg-gradient-to-r from-primary to-violet text-white shadow-soft scale-105'
                                : 'border-slate-200 bg-white text-slate-600 hover:border-indigo-200 hover:text-primary'">
                        <i class="<?= esc($c['icon'] ?: 'fa-solid fa-layer-group') ?>"></i>
                        <?= esc($c['name']) ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <!-- Panels -->
            <?php foreach ($productGroups as $gi => $g): $c = $g['category']; ?>
                <div x-show="tab === <?= esc(json_encode($c['slug'])) ?>" x-cloak
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="mt-12 grid gap-6 md:grid-cols-2 <?= count($g['products']) > 2 ? 'lg:grid-cols-' . min(4, count($g['products'])) : '' ?>">
                    <?php foreach ($g['products'] as $pi => $p):
                        $features = json_decode((string) $p['top_features'], true) ?: []; ?>
                        <div class="group relative rounded-3xl border border-slate-100 bg-white p-7 shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-glow"
                             data-aos="fade-up" data-aos-delay="<?= $gi * 50 + $pi * 80 ?>">
                            <!-- gradient glow border on hover -->
                            <div class="pointer-events-none absolute inset-0 rounded-3xl opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                                 style="background:linear-gradient(135deg,rgba(79,70,229,.14),rgba(124,58,237,.10),rgba(16,185,129,.10));"></div>

                            <div class="relative">
                                <span class="inline-flex h-13 w-13 items-center justify-center rounded-2xl bg-gradient-to-br <?= esc($p['color'] ?: 'from-indigo-500 to-violet-500') ?> p-3.5 text-xl text-white shadow-soft">
                                    <i class="<?= esc($p['icon'] ?: 'fa-solid fa-cube') ?>"></i>
                                </span>
                                <h3 class="mt-5 font-display text-xl font-bold text-slate-900"><?= esc($p['name']) ?></h3>
                                <p class="mt-1.5 text-sm leading-6 text-slate-500"><?= esc($p['tagline']) ?></p>

                                <?php if ($features): ?>
                                <ul class="mt-4 flex flex-wrap gap-2">
                                    <?php foreach (array_slice($features, 0, 3) as $f): ?>
                                        <li class="rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700 ring-1 ring-inset ring-indigo-100"><?= esc($f) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                <?php endif; ?>

                                <div class="mt-6 flex items-center justify-between border-t border-slate-100 pt-5">
                                    <a href="<?= site_url_path('/products/' . $p['slug']) ?>"
                                       class="text-sm font-bold text-primary transition group-hover:underline">Learn more →</a>
                                    <a href="<?= site_url_path('/contact?product=' . $p['slug']) ?>"
                                       class="rounded-full border border-slate-200 px-4 py-1.5 text-xs font-bold text-slate-600 transition hover:border-primary hover:bg-primary hover:text-white">Book demo</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
            <p class="mt-12 text-center text-slate-500">Products coming soon.</p>
        <?php endif; ?>
    </div>
</section>
