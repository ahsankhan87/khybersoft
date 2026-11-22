<?php /* Single success story — challenge / solution / results layout. Vars: $story, $product, $related */ ?>
<?php $metrics = json_decode((string) ($story['metrics'] ?? '[]'), true) ?: []; ?>
<article>
    <!-- Hero header -->
    <header class="relative overflow-hidden bg-navy pb-16 pt-28 text-white">
        <div class="pointer-events-none absolute inset-0" aria-hidden="true">
            <div class="absolute -top-24 left-1/4 h-[360px] w-[360px] rounded-full bg-primary/25 blur-[110px]"></div>
            <div class="absolute bottom-0 right-0 h-[280px] w-[280px] rounded-full bg-violet/20 blur-[100px]"></div>
            <div class="absolute inset-0 opacity-[0.06]"
                 style="background-image:linear-gradient(to right,#fff 1px,transparent 1px),linear-gradient(to bottom,#fff 1px,transparent 1px);background-size:44px 44px;"></div>
        </div>
        <div class="relative mx-auto max-w-4xl px-5 lg:px-8">
            <a href="<?= site_url_path('/success-stories') ?>" class="inline-flex items-center gap-2 text-sm font-semibold text-primary-300 transition hover:text-white">
                <i class="fa-solid fa-arrow-left"></i> All success stories
            </a>
            <div class="mt-7 flex flex-wrap items-center gap-3 text-xs font-bold uppercase tracking-widest">
                <?php if (! empty($story['industry'])): ?>
                    <span class="rounded-full bg-primary/20 px-3 py-1 text-primary-200 ring-1 ring-inset ring-primary/30"><?= esc($story['industry']) ?></span>
                <?php endif; ?>
                <?php if ($product): ?><span class="text-slate-400"><?= esc($product['name']) ?></span><?php endif; ?>
            </div>
            <h1 class="mt-4 font-display text-4xl font-extrabold leading-tight tracking-tight sm:text-5xl"><?= esc($story['headline']) ?></h1>

            <div class="mt-7 flex items-center gap-3">
                <?php if (! empty($story['photo'])): ?>
                    <img src="<?= esc(media_url($story['photo'])) ?>" alt="<?= esc($story['customer_name']) ?>" class="h-12 w-12 rounded-full object-cover ring-2 ring-white/20">
                <?php else: ?>
                    <span class="grid h-12 w-12 place-items-center rounded-full bg-gradient-to-br from-primary to-violet text-base font-bold text-white">
                        <?= esc(mb_substr(strtoupper((string) $story['customer_name']), 0, 1)) ?>
                    </span>
                <?php endif; ?>
                <div>
                    <p class="text-sm font-bold text-white"><?= esc($story['customer_name']) ?><?= $story['role'] ? ' · ' . esc($story['role']) : '' ?></p>
                    <p class="text-xs text-slate-400"><?= esc($story['company']) ?></p>
                </div>
                <?php if (! empty($story['logo'])): ?>
                    <img src="<?= esc(media_url($story['logo'])) ?>" alt="" class="ml-auto h-8 w-auto rounded bg-white/90 px-2 py-1">
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Metrics band -->
    <?php if ($metrics): ?>
        <div class="border-b border-slate-100 bg-white">
            <div class="mx-auto grid max-w-4xl grid-cols-2 gap-6 px-5 py-8 sm:grid-cols-<?= min(4, max(2, count($metrics))) ?> lg:px-8">
                <?php foreach ($metrics as $m):
                    $label = $m['label'] ?? (is_string($m) ? $m : '');
                    $value = $m['value'] ?? '';
                    ?>
                    <div class="text-center">
                        <p class="font-display text-2xl font-extrabold text-primary sm:text-3xl"><?= esc($value !== '' ? $value : $label) ?></p>
                        <?php if ($value !== '' && $label !== ''): ?>
                            <p class="mt-1 text-xs font-semibold uppercase tracking-widest text-slate-400"><?= esc($label) ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Body -->
    <div class="mx-auto max-w-3xl px-5 py-14 lg:px-8">
        <?php if (! empty($story['hero_image'])): ?>
            <img src="<?= esc(media_url($story['hero_image'])) ?>" alt="<?= esc($story['headline']) ?>" class="mb-10 w-full rounded-3xl border border-slate-100 object-cover shadow-soft">
        <?php endif; ?>

        <?php if (! empty($story['quote'])): ?>
            <blockquote class="mb-10 rounded-3xl border-l-4 border-primary bg-gradient-to-r from-primary-50 to-transparent p-6">
                <p class="text-lg font-medium italic leading-8 text-slate-700">“<?= esc($story['quote']) ?>”</p>
            </blockquote>
        <?php endif; ?>

        <?php
        $blocks = [
            ['The challenge', 'fa-solid fa-triangle-exclamation', 'challenge'],
            ['The solution', 'fa-solid fa-lightbulb', 'solution'],
            ['The results', 'fa-solid fa-chart-line', 'results'],
        ];
        foreach ($blocks as [$heading, $icon, $key]): if (empty($story[$key])) continue; ?>
            <section class="mb-10">
                <h2 class="flex items-center gap-3 font-display text-2xl font-extrabold text-slate-900">
                    <span class="grid h-10 w-10 place-items-center rounded-xl bg-gradient-to-br from-primary to-violet text-sm text-white shadow-soft"><i class="<?= $icon ?>"></i></span>
                    <?= $heading ?>
                </h2>
                <div class="mt-4 text-base leading-8 text-slate-600">
                    <?= nl2br(esc($story[$key])) ?>
                </div>
            </section>
        <?php endforeach; ?>

        <?php if ($product): ?>
            <div class="mt-12 flex flex-wrap items-center gap-4 rounded-3xl border border-slate-100 bg-slate-50/60 p-6">
                <span class="grid h-12 w-12 place-items-center rounded-2xl bg-gradient-to-br <?= esc($product['color'] ?: 'from-indigo-500 to-violet-500') ?> text-lg text-white shadow-soft">
                    <i class="<?= esc($product['icon'] ?: 'fa-solid fa-cube') ?>"></i>
                </span>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-bold uppercase tracking-widest text-slate-400">Powered by</p>
                    <p class="font-display text-base font-bold text-slate-900"><?= esc($product['name']) ?></p>
                </div>
                <a href="<?= site_url_path('/products/' . $product['slug']) ?>" class="rounded-xl bg-gradient-to-r from-primary to-violet px-5 py-2.5 text-sm font-bold text-white shadow-soft transition hover:-translate-y-0.5">View product</a>
            </div>
        <?php endif; ?>

        <div class="mt-12 border-t border-slate-200 pt-8">
            <a href="<?= site_url_path('/success-stories') ?>" class="inline-flex items-center gap-2 text-sm font-bold text-primary transition hover:underline">
                <i class="fa-solid fa-arrow-left"></i> Back to all stories
            </a>
        </div>
    </div>
</article>

<!-- Related stories -->
<?php if (! empty($related)): ?>
<section class="bg-gradient-to-b from-slate-50 to-white py-16">
    <div class="mx-auto max-w-5xl px-5 lg:px-8">
        <h2 class="font-display text-2xl font-extrabold text-slate-900">More success stories</h2>
        <div class="mt-8 grid gap-6 md:grid-cols-2">
            <?php foreach ($related as $r): ?>
                <a href="<?= site_url_path('/success-stories/' . $r['slug']) ?>"
                   class="group rounded-3xl border border-slate-100 bg-white p-7 shadow-sm transition hover:-translate-y-1 hover:shadow-soft">
                    <span class="text-xs font-bold uppercase tracking-wider text-primary"><?= esc($r['industry'] ?? 'Case study') ?></span>
                    <h3 class="mt-2 font-display text-lg font-bold text-slate-900 group-hover:text-primary"><?= esc($r['headline']) ?></h3>
                    <p class="mt-2 line-clamp-2 text-sm text-slate-500">“<?= esc($r['quote']) ?>”</p>
                    <span class="mt-4 inline-flex items-center gap-1.5 text-sm font-bold text-primary">Read story <i class="fa-solid fa-arrow-right text-xs transition group-hover:translate-x-1"></i></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
