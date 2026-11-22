<?php /* Tutorials listing — navy hero + filters + grid. Vars: $tutorials, $categories, $products, $activeCategory, $activeProduct */ ?>
<!-- Hero -->
<section class="relative overflow-hidden bg-navy pb-20 pt-28 text-white">
    <div class="pointer-events-none absolute inset-0" aria-hidden="true">
        <div class="absolute -top-32 left-1/4 h-[420px] w-[420px] rounded-full bg-primary/30 blur-[120px]"></div>
        <div class="absolute bottom-0 right-0 h-[320px] w-[320px] rounded-full bg-violet/20 blur-[100px]"></div>
        <div class="absolute inset-0 opacity-[0.06]"
             style="background-image:linear-gradient(to right,#fff 1px,transparent 1px),linear-gradient(to bottom,#fff 1px,transparent 1px);background-size:44px 44px;"></div>
    </div>
    <div class="relative mx-auto max-w-4xl px-5 text-center lg:px-8">
        <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-4 py-1.5 text-xs font-semibold tracking-wide text-primary-200 backdrop-blur">
            <i class="fa-solid fa-circle-play"></i> Learn by watching
        </span>
        <h1 class="mt-6 font-display text-4xl font-extrabold tracking-tight sm:text-5xl">Video tutorials & guides</h1>
        <p class="mx-auto mt-5 max-w-2xl text-lg leading-8 text-slate-300">Step-by-step walkthroughs for every Khybersoft product — from first setup to advanced reports.</p>
    </div>
</section>

<!-- Filters + grid -->
<section class="bg-gradient-to-b from-slate-50 to-white py-16">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">
        <?php if (! empty($categories) || ! empty($products)): ?>
            <form method="get" action="<?= site_url('tutorials') ?>" class="flex flex-wrap items-center gap-2">
                <a href="<?= site_url('tutorials') ?>"
                   class="rounded-full px-4 py-2 text-sm font-semibold transition <?= ! $activeCategory && ! $activeProduct ? 'bg-gradient-to-r from-primary to-violet text-white shadow-soft' : 'bg-white text-slate-600 ring-1 ring-slate-200 hover:text-primary' ?>">All</a>
                <?php foreach ($categories as $c): ?>
                    <a href="<?= site_url('tutorials') ?>?category=<?= (int) $c['id'] ?>"
                       class="rounded-full px-4 py-2 text-sm font-semibold transition <?= $activeCategory === (int) $c['id'] ? 'bg-gradient-to-r from-primary to-violet text-white shadow-soft' : 'bg-white text-slate-600 ring-1 ring-slate-200 hover:text-primary' ?>">
                        <i class="<?= esc($c['icon'] ?: 'fa-solid fa-book') ?> mr-1"></i><?= esc($c['name']) ?>
                    </a>
                <?php endforeach; ?>
                <?php foreach ($products as $p): ?>
                    <a href="<?= site_url('tutorials') ?>?product=<?= (int) $p['id'] ?>"
                       class="rounded-full px-4 py-2 text-sm font-semibold transition <?= $activeProduct === (int) $p['id'] ? 'bg-gradient-to-r from-primary to-violet text-white shadow-soft' : 'bg-white text-slate-600 ring-1 ring-slate-200 hover:text-primary' ?>">
                        <?= esc($p['name']) ?>
                    </a>
                <?php endforeach; ?>
            </form>
        <?php endif; ?>

        <?php if (! empty($tutorials)): ?>
            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($tutorials as $ti => $t): ?>
                    <a href="<?= site_url('tutorials/' . urlencode((string) $t['slug'])) ?>"
                       class="group overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-sm transition hover:-translate-y-2 hover:shadow-glow"
                       data-aos="fade-up" data-aos-delay="<?= ($ti % 3) * 100 ?>">
                        <div class="relative aspect-video overflow-hidden bg-gradient-to-br from-indigo-100 via-violet-100 to-emerald-50">
                            <?php if (! empty($t['thumbnail'])): ?>
                                <img src="<?= esc(media_url($t['thumbnail'])) ?>" alt="" loading="lazy" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                            <?php endif; ?>
                            <span class="absolute inset-0 m-auto grid h-14 w-14 place-items-center rounded-full bg-white/90 text-primary shadow-lg backdrop-blur transition group-hover:scale-110">
                                <i class="fa-solid <?= $t['type'] === 'video' ? 'fa-play ml-1' : 'fa-book-open' ?>"></i>
                            </span>
                            <?php if ((int) ($t['duration_sec'] ?? 0) > 0): ?>
                                <span class="absolute bottom-3 right-3 rounded-lg bg-navy/85 px-2 py-1 text-xs font-bold text-white"><?= gmdate('i:s', (int) $t['duration_sec']) ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center gap-2 text-xs">
                                <span class="rounded-full bg-indigo-50 px-3 py-1 font-bold uppercase tracking-wide text-primary"><?= $t['type'] === 'video' ? 'Video' : 'Guide' ?></span>
                                <?php if ((int) ($t['view_count'] ?? 0) > 0): ?>
                                    <span class="text-slate-400"><i class="fa-solid fa-eye mr-1"></i><?= number_format((int) $t['view_count']) ?></span>
                                <?php endif; ?>
                            </div>
                            <h2 class="mt-3 font-display text-lg font-bold leading-snug text-slate-900 transition group-hover:text-primary"><?= esc($t['title']) ?></h2>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="mt-10 rounded-3xl border border-dashed border-slate-300 bg-white px-6 py-20 text-center">
                <span class="mx-auto grid h-14 w-14 place-items-center rounded-2xl bg-gradient-to-br from-primary to-violet text-xl text-white shadow-soft"><i class="fa-solid fa-circle-play"></i></span>
                <h2 class="mt-5 font-display text-2xl font-bold text-slate-900">No tutorials here yet</h2>
                <p class="mx-auto mt-2 max-w-md text-sm text-slate-500">New guides are added regularly. Need help right now? Our team is one message away.</p>
                <a href="<?= site_url_path('/contact') ?>" class="mt-6 inline-flex items-center gap-2 rounded-2xl bg-gradient-to-r from-primary to-violet px-6 py-3 text-sm font-bold text-white shadow-soft transition hover:-translate-y-0.5">Contact support</a>
            </div>
        <?php endif; ?>
    </div>
</section>
