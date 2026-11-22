<?php
/**
 * Section 2 — Sticky navbar with mega-menu.
 * Transparent over the dark hero on the homepage, solid white/blur elsewhere or after scroll.
 * Mega-menu groups come from product categories (DB) + header menu tree for other dropdowns.
 */
$isHome      = ($currentPath ?? '/') === '/';
$jsHome      = $isHome ? 'true' : 'false';
$productCats = [];
try { $productCats = model(\App\Models\ProductCategoryModel::class)->active(); } catch (\Throwable $e) { $productCats = []; }
$navMenu = $navMenu ?? [];
?>
<header x-data="{ scrolled: false }"
        x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 10)"
        class="sticky top-0 z-50 transition-all duration-300"
        :class="scrolled || !<?= $jsHome ?>
            ? 'bg-white/85 backdrop-blur-xl shadow-[0_4px_30px_rgba(31,41,128,0.08)] border-b border-slate-100 text-slate-800'
            : 'bg-transparent text-white'"
        id="site-header">

    <nav class="mx-auto flex max-w-7xl items-center justify-between gap-6 px-5 py-4 lg:px-8" aria-label="Global">

        <!-- Logo -->
        <a href="<?= base_url('/') ?>" class="flex shrink-0 items-center gap-2">
            <?php if ($logo = setting('logo_light')): ?>
                <img src="<?= esc(media_url($logo)) ?>" alt="<?= esc(setting('site_name', 'Khybersoft')) ?>" class="h-9 w-auto" fetchpriority="high">
            <?php else: ?>
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-primary to-violet font-display text-lg font-extrabold text-white shadow-soft">K</span>
                <span class="font-display text-xl font-extrabold tracking-tight text-current">
                    <?= esc(setting('site_name', 'Khybersoft')) ?>
                </span>
            <?php endif; ?>
        </a>

        <!-- Desktop nav — order follows the DB menu; Products renders as mega-menu at its own position -->
        <div class="hidden items-center gap-1 lg:flex" x-data="{ openSub: null }" @mouseleave="openSub = null">
            <?php foreach ($navMenu as $item): ?>
                <?php if (in_array(strtolower((string) $item['url']), ['/products', 'products'], true)): ?>
                    <!-- Products mega-menu -->
                    <div class="relative" @mouseenter="openSub = 'products'">
                        <button type="button" class="flex items-center gap-1.5 rounded-full px-4 py-2 text-sm font-semibold transition hover:bg-black/5"
                                :class="openSub === 'products' && 'bg-black/5'">
                            <?= esc($item['label']) ?> <i class="fa-solid fa-chevron-down text-[10px] transition" :class="openSub === 'products' && 'rotate-180'"></i>
                        </button>
                        <div x-show="openSub === 'products'" x-transition.origin.top.left.duration.200ms x-cloak
                             class="absolute left-1/2 top-full -translate-x-1/2 pt-4">
                            <div class="w-[880px] overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-glow">
                                <div class="flex">
                                    <!-- Feature rail -->
                                    <div class="relative hidden w-60 shrink-0 overflow-hidden bg-navy p-6 text-white lg:block">
                                        <div class="pointer-events-none absolute inset-0 opacity-40" aria-hidden="true"
                                             style="background:radial-gradient(18rem 12rem at 20% 0%, rgb(28 143 216/.55), transparent), radial-gradient(14rem 10rem at 100% 100%, rgb(37 99 235/.4), transparent);"></div>
                                        <div class="relative">
                                            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-primary-300">One platform</p>
                                            <p class="mt-2 font-display text-xl font-extrabold leading-snug">Every business need, one login.</p>
                                            <p class="mt-2 text-xs leading-5 text-slate-300">POS, accounting, school, real-estate and HR — sharing one database.</p>
                                            <a href="<?= site_url_path('/products') ?>"
                                               class="mt-5 inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-primary to-violet px-4 py-2.5 text-xs font-bold text-white shadow-soft transition hover:-translate-y-0.5">
                                                Explore all products <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                            </a>
                                            <div class="mt-6 space-y-2 border-t border-white/10 pt-4 text-xs text-slate-300">
                                                <p class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-emerald-400"></i> Free setup & migration</p>
                                                <p class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-emerald-400"></i> 14-day free trial</p>
                                                <p class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-emerald-400"></i> Support in EN & Urdu</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Category columns -->
                                    <div class="grid flex-1 grid-cols-2 gap-1.5 p-5 text-slate-800 sm:grid-cols-3">
                                        <?php foreach ($productCats as $c): ?>
                                            <?php
                                            $catProducts = model(\App\Models\ProductModel::class)
                                                ->where('category_id', $c['id'])->where('status', 'active')
                                                ->orderBy('sort_order')->limit(3)->findAll();
                                            ?>
                                            <div class="rounded-2xl p-2.5 transition hover:bg-slate-50">
                                                <a href="<?= site_url_path('/products/category/' . $c['slug']) ?>"
                                                   class="mb-2 flex items-center gap-2 text-[11px] font-bold uppercase tracking-wider text-slate-400 transition hover:text-primary">
                                                    <span class="grid h-6 w-6 place-items-center rounded-lg bg-gradient-to-br from-primary/15 to-violet/15 text-primary">
                                                        <i class="<?= esc($c['icon'] ?: 'fa-solid fa-layer-group') ?> text-[10px]"></i>
                                                    </span>
                                                    <?= esc($c['name']) ?>
                                                </a>
                                                <ul class="space-y-0.5">
                                                    <?php foreach ($catProducts as $p): ?>
                                                        <li>
                                                            <a href="<?= site_url_path('/products/' . $p['slug']) ?>"
                                                               class="group flex items-center justify-between gap-2 rounded-xl px-2 py-1.5 transition hover:bg-indigo-50/80">
                                                                <span class="min-w-0">
                                                                    <span class="block truncate text-sm font-semibold text-slate-800 group-hover:text-primary"><?= esc($p['name']) ?></span>
                                                                    <span class="block truncate text-xs text-slate-400"><?= esc($p['tagline']) ?></span>
                                                                </span>
                                                                <i class="fa-solid fa-arrow-right shrink-0 text-[10px] text-primary opacity-0 transition group-hover:translate-x-0.5 group-hover:opacity-100"></i>
                                                            </a>
                                                        </li>
                                                    <?php endforeach; ?>
                                                    <?php if (! $catProducts): ?>
                                                        <li class="px-2 py-1.5 text-xs text-slate-400">Coming soon</li>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <!-- Footer strip -->
                                <div class="flex items-center justify-between border-t border-slate-100 bg-slate-50/70 px-6 py-3.5">
                                    <a href="<?= site_url_path('/products') ?>" class="text-sm font-bold text-primary transition hover:underline">View all products →</a>
                                    <div class="flex items-center gap-5 text-xs font-semibold text-slate-500">
                                        <a href="<?= site_url_path('/pricing') ?>" class="transition hover:text-primary"><i class="fa-solid fa-tag mr-1"></i>Compare pricing</a>
                                        <a href="<?= site_url_path('/contact') ?>" class="transition hover:text-primary"><i class="fa-solid fa-calendar-check mr-1"></i>Book a demo</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php elseif (! empty($item['children'])): ?>
                    <div class="relative" @mouseenter="openSub = <?= esc(json_encode($item['label'])) ?>">
                        <button type="button" class="flex items-center gap-1.5 rounded-full px-4 py-2 text-sm font-semibold transition hover:bg-black/5">
                            <?= esc($item['label']) ?> <i class="fa-solid fa-chevron-down text-[10px] transition" :class="openSub === <?= esc(json_encode($item['label'])) ?> && 'rotate-180'"></i>
                        </button>
                        <div x-show="openSub === <?= esc(json_encode($item['label'])) ?>" x-transition.origin.top.left x-cloak
                             class="absolute left-0 top-full pt-4">
                            <div class="w-64 rounded-2xl border border-slate-100 bg-white p-3 text-slate-800 shadow-glow">
                                <?php foreach ($item['children'] as $child): ?>
                                    <a href="<?= esc(site_url_path($child['url'])) ?>"
                                       class="flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-indigo-50 hover:text-primary">
                                        <?php if (!empty($child['icon'])): ?><i class="<?= esc($child['icon']) ?> text-primary/70"></i><?php endif; ?>
                                        <?= esc($child['label']) ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?= esc(site_url_path($item['url'])) ?>"
                       class="rounded-full px-4 py-2 text-sm font-semibold transition hover:bg-black/5"
                       <?= ! empty($item['is_external']) ? 'target="_blank" rel="noopener"' : '' ?>>
                        <?= esc($item['label']) ?>
                    </a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <!-- CTAs -->
        <div class="hidden items-center gap-3 lg:flex">
            <a href="<?= site_url_path('/contact') ?>"
               class="rounded-full border px-5 py-2.5 text-sm font-semibold backdrop-blur transition hover:bg-black/5"
               style="border-color: currentColor;">Book Demo</a>
            <a href="<?= site_url_path('/pricing') ?>"
               class="rounded-full bg-gradient-to-r from-primary to-violet px-5 py-2.5 text-sm font-semibold text-white shadow-soft transition hover:-translate-y-0.5 hover:shadow-glow">
                Start Free Trial
            </a>
        </div>

        <!-- Mobile toggle -->
        <button type="button" class="rounded-xl p-2.5 transition hover:bg-black/5 lg:hidden" @click="mobileOpen = !mobileOpen" aria-label="Toggle menu">
            <i class="fa-solid" :class="mobileOpen ? 'fa-xmark text-xl' : 'fa-bars text-xl'"></i>
        </button>
    </nav>

    <!-- Mobile drawer with accordions -->
    <div x-show="mobileOpen" x-cloak x-collapse class="max-h-[calc(100vh-5rem)] overflow-y-auto border-t border-slate-100 bg-white px-5 pb-8 pt-3 text-slate-800 shadow-xl lg:hidden">
        <div x-data="{ acc: null }">
            <?php foreach ($navMenu as $item): ?>
                <?php if (in_array(strtolower((string) $item['url']), ['/products', 'products'], true)): ?>
                    <!-- Products accordion (rendered at its DB menu position) -->
                    <button type="button" @click="acc = acc === 'p' ? null : 'p'" class="flex w-full items-center justify-between py-3 text-base font-semibold">
                        <?= esc($item['label']) ?> <i class="fa-solid fa-chevron-down text-xs transition" :class="acc === 'p' && 'rotate-180'"></i>
                    </button>
                    <div x-show="acc === 'p'" x-collapse class="pl-3">
                        <?php foreach ($productCats as $c): ?>
                            <p class="pt-2 text-xs font-bold uppercase tracking-wider text-slate-400"><?= esc($c['name']) ?></p>
                            <?php
                            $mProds = model(\App\Models\ProductModel::class)
                                ->where('category_id', $c['id'])->where('status', 'active')->limit(3)->findAll();
                            foreach ($mProds as $p): ?>
                                <a href="<?= site_url_path('/products/' . $p['slug']) ?>" class="block py-1.5 text-sm text-slate-600"><?= esc($p['name']) ?></a>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                        <a href="<?= site_url_path('/products') ?>" class="block py-2 text-sm font-semibold text-primary">View all products →</a>
                    </div>
                <?php elseif (! empty($item['children'])): ?>
                    <button type="button" @click="acc = acc === <?= esc(json_encode($item['label'])) ?> ? null : <?= esc(json_encode($item['label'])) ?>"
                            class="flex w-full items-center justify-between py-3 text-base font-semibold">
                        <?= esc($item['label']) ?> <i class="fa-solid fa-chevron-down text-xs transition" :class="acc === <?= esc(json_encode($item['label'])) ?> && 'rotate-180'"></i>
                    </button>
                    <div x-show="acc === <?= esc(json_encode($item['label'])) ?>" x-collapse class="pl-3">
                        <?php foreach ($item['children'] as $child): ?>
                            <a href="<?= esc(site_url_path($child['url'])) ?>" class="block py-1.5 text-sm text-slate-600"><?= esc($child['label']) ?></a>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <a href="<?= esc(site_url_path($item['url'])) ?>" class="block py-3 text-base font-semibold"><?= esc($item['label']) ?></a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <div class="mt-5 flex flex-col gap-3">
            <a href="<?= site_url_path('/contact') ?>" class="rounded-2xl border border-slate-200 px-4 py-3 text-center text-sm font-semibold text-slate-700">Book Demo</a>
            <a href="<?= site_url_path('/pricing') ?>" class="rounded-2xl bg-gradient-to-r from-primary to-violet px-4 py-3 text-center text-sm font-semibold text-white shadow-soft">Start Free Trial</a>
        </div>
    </div>
</header>
