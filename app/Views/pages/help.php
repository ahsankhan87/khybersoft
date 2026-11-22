<?php /* Help Center — navy hero + search + category grid + tutorials. Vars: $tutorials, $categories */ ?>
<!-- Hero with search -->
<section class="relative overflow-hidden bg-navy pb-24 pt-28 text-white">
    <div class="pointer-events-none absolute inset-0" aria-hidden="true">
        <div class="absolute -top-32 left-1/4 h-[420px] w-[420px] rounded-full bg-primary/30 blur-[120px]"></div>
        <div class="absolute bottom-0 right-0 h-[320px] w-[320px] rounded-full bg-violet/20 blur-[100px]"></div>
        <div class="absolute inset-0 opacity-[0.06]"
             style="background-image:linear-gradient(to right,#fff 1px,transparent 1px),linear-gradient(to bottom,#fff 1px,transparent 1px);background-size:44px 44px;"></div>
    </div>
    <div class="relative mx-auto max-w-3xl px-5 text-center lg:px-8">
        <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-4 py-1.5 text-xs font-semibold tracking-wide text-primary-200 backdrop-blur">
            <i class="fa-solid fa-circle-question"></i> Help Center
        </span>
        <h1 class="mt-6 font-display text-4xl font-extrabold tracking-tight sm:text-5xl">
            <?= esc(setting('help_hero_heading', 'How can we help?')) ?>
        </h1>
        <p class="mx-auto mt-5 max-w-xl text-lg leading-8 text-slate-300">
            <?= esc(setting('help_hero_sub', 'Search guides, watch tutorials, or browse by topic.')) ?>
        </p>
        <form method="get" action="<?= site_url('search') ?>" class="mx-auto mt-8 flex max-w-lg overflow-hidden rounded-2xl border border-white/15 bg-white/10 backdrop-blur focus-within:border-primary">
            <i class="fa-solid fa-magnifying-glass my-auto pl-5 text-slate-400"></i>
            <input type="search" name="q" placeholder="Search for answers…" aria-label="Search help"
                   class="w-full bg-transparent px-4 py-4 text-sm text-white placeholder:text-slate-400 focus:outline-none">
            <button class="shrink-0 bg-gradient-to-r from-primary to-violet px-6 text-sm font-bold text-white">Search</button>
        </form>
    </div>
</section>

<!-- Categories -->
<section class="bg-white py-20">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">
        <div class="mx-auto max-w-2xl text-center" data-aos="fade-up">
            <p class="text-sm font-bold uppercase tracking-widest text-primary">Browse topics</p>
            <h2 class="mt-3 font-display text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">Explore by category</h2>
        </div>

        <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <?php
            $fallbackCats = [
                ['name' => 'Getting started', 'icon' => 'fa-solid fa-rocket', 'desc' => 'Setup, installation and your first sale'],
                ['name' => 'Invoicing & billing', 'icon' => 'fa-solid fa-file-invoice-dollar', 'desc' => 'Invoices, taxes, receipts and payments'],
                ['name' => 'Inventory', 'icon' => 'fa-solid fa-boxes-stacked', 'desc' => 'Stock, branches, barcodes and purchase orders'],
                ['name' => 'Reports & analytics', 'icon' => 'fa-solid fa-chart-line', 'desc' => 'P&L, sales analytics and exports'],
                ['name' => 'Users & permissions', 'icon' => 'fa-solid fa-users-gear', 'desc' => 'Roles, branches and access control'],
                ['name' => 'Troubleshooting', 'icon' => 'fa-solid fa-wrench', 'desc' => 'Common issues and quick fixes'],
            ];
            $cats = ! empty($categories) ? array_map(static fn ($c) => ['id' => $c['id'], 'name' => $c['name'], 'icon' => $c['icon'] ?: 'fa-solid fa-book', 'desc' => ''], $categories) : $fallbackCats;
            foreach ($cats as $ci => $cat): ?>
                <a href="<?= site_url('tutorials') . (isset($cat['id']) ? '?category=' . (int) $cat['id'] : '') ?>"
                   class="group rounded-3xl border border-slate-100 bg-gradient-to-b from-slate-50 to-white p-7 transition hover:-translate-y-1 hover:shadow-soft"
                   data-aos="fade-up" data-aos-delay="<?= ($ci % 3) * 100 ?>">
                    <span class="grid h-12 w-12 place-items-center rounded-2xl bg-gradient-to-br from-primary to-violet text-lg text-white shadow-soft">
                        <i class="<?= esc($cat['icon']) ?>"></i>
                    </span>
                    <h3 class="mt-5 font-display text-lg font-bold text-slate-900 group-hover:text-primary"><?= esc($cat['name']) ?></h3>
                    <?php if (! empty($cat['desc'])): ?><p class="mt-1.5 text-sm leading-6 text-slate-500"><?= esc($cat['desc']) ?></p><?php endif; ?>
                    <span class="mt-4 inline-flex items-center gap-1.5 text-sm font-bold text-primary">Browse <i class="fa-solid fa-arrow-right text-xs transition group-hover:translate-x-1"></i></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Popular tutorials -->
<section class="bg-gradient-to-b from-slate-50 to-white py-20">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">
        <div class="flex flex-col items-start justify-between gap-4 md:flex-row md:items-end" data-aos="fade-up">
            <div>
                <p class="text-sm font-bold uppercase tracking-widest text-accent">Tutorials</p>
                <h2 class="mt-3 font-display text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">Popular guides & videos</h2>
            </div>
            <a href="<?= site_url('tutorials') ?>" class="whitespace-nowrap text-sm font-bold text-primary hover:underline">Browse all tutorials →</a>
        </div>

        <?php if (! empty($tutorials)): ?>
            <div class="mt-10 grid gap-6 md:grid-cols-3">
                <?php foreach (array_slice($tutorials, 0, 6) as $ti => $t): ?>
                    <a href="<?= site_url('tutorials/' . urlencode((string) $t['slug'])) ?>"
                       class="group overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-sm transition hover:-translate-y-2 hover:shadow-glow"
                       data-aos="fade-up" data-aos-delay="<?= ($ti % 3) * 100 ?>">
                        <div class="relative aspect-video overflow-hidden bg-gradient-to-br from-indigo-100 via-violet-100 to-emerald-50">
                            <?php if (! empty($t['thumbnail'])): ?>
                                <img src="<?= esc(media_url($t['thumbnail'])) ?>" alt="" loading="lazy" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                            <?php endif; ?>
                            <span class="absolute inset-0 m-auto grid h-12 w-12 place-items-center rounded-full bg-white/90 text-primary shadow-lg backdrop-blur transition group-hover:scale-110">
                                <i class="fa-solid <?= $t['type'] === 'video' ? 'fa-play ml-0.5' : 'fa-book-open' ?>"></i>
                            </span>
                            <?php if ((int) ($t['duration_sec'] ?? 0) > 0): ?>
                                <span class="absolute bottom-3 right-3 rounded-lg bg-navy/85 px-2 py-1 text-xs font-bold text-white"><?= gmdate('i:s', (int) $t['duration_sec']) ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="p-6">
                            <span class="text-xs font-bold uppercase tracking-wider text-primary"><?= $t['type'] === 'video' ? 'Video' : 'Guide' ?></span>
                            <h3 class="mt-2 font-display text-base font-bold text-slate-900 group-hover:text-primary"><?= esc($t['title']) ?></h3>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="mt-10 rounded-3xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center">
                <span class="mx-auto grid h-14 w-14 place-items-center rounded-2xl bg-gradient-to-br from-primary to-violet text-xl text-white shadow-soft"><i class="fa-solid fa-circle-play"></i></span>
                <h3 class="mt-5 font-display text-xl font-bold text-slate-900">Tutorials are on the way</h3>
                <p class="mx-auto mt-2 max-w-md text-sm text-slate-500">We're recording step-by-step guides for every product. Meanwhile, our team is happy to help directly.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Contact CTA -->
<section class="relative overflow-hidden bg-gradient-to-br from-primary via-violet to-primary-700 py-20 text-white">
    <div class="pointer-events-none absolute inset-0 opacity-[0.08]" aria-hidden="true"
         style="background-image:radial-gradient(#fff 1px,transparent 1px);background-size:26px 26px;"></div>
    <div class="relative mx-auto max-w-3xl px-5 text-center lg:px-8">
        <h2 class="font-display text-3xl font-extrabold tracking-tight sm:text-4xl">Still stuck?</h2>
        <p class="mx-auto mt-4 max-w-xl text-lg text-primary-100">Our support team answers in English and Urdu — usually within a few hours.</p>
        <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
            <a href="<?= site_url_path('/contact') ?>" class="rounded-2xl bg-white px-8 py-4 text-base font-bold text-primary shadow-xl transition hover:-translate-y-0.5 hover:shadow-2xl">Contact support</a>
            <?php if ($wa = preg_replace('/\D/', '', setting('whatsapp_number', ''))): ?>
                <a href="https://wa.me/<?= esc($wa) ?>?text=<?= rawurlencode('Hi! I need help with Khybersoft.') ?>" target="_blank" rel="noopener"
                   class="inline-flex items-center gap-2 rounded-2xl bg-[#25D366] px-6 py-4 text-base font-bold text-white shadow-xl transition hover:-translate-y-0.5">
                    <i class="fa-brands fa-whatsapp text-lg"></i> WhatsApp us
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>
