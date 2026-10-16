<?php
/** Category page. Vars: $category,$intro,$products,$testimonials,$faqs,$breadcrumbs */
?>
<section class="relative overflow-hidden bg-navy pb-16 pt-24 text-white">
    <div class="absolute inset-0 opacity-30" style="background:radial-gradient(50rem 25rem at 30% 0%, rgb(79 70 229/.5), transparent);"></div>
    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-6 flex items-center gap-2 text-sm text-slate-400">
            <a href="<?= site_url() ?>" class="hover:text-white">Home</a>
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
            <a href="<?= site_url('products') ?>" class="hover:text-white">Products</a>
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
            <span class="text-white"><?= esc($category['name']) ?></span>
        </nav>
        <div class="flex items-center gap-4">
            <div class="grid h-16 w-16 place-items-center rounded-2xl bg-gradient-to-br from-primary to-violet text-3xl shadow-soft"><i class="<?= esc($category['icon'] ?: 'fa-solid fa-layer-group') ?>"></i></div>
            <div>
                <h1 class="font-display text-3xl font-extrabold sm:text-4xl"><?= esc($category['name']) ?> Software</h1>
                <?php if ($intro): ?><p class="mt-2 max-w-2xl text-slate-300"><?= esc($intro) ?></p><?php endif; ?>
            </div>
        </div>
    </div>
</section>

<section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <?php foreach ($products as $p): echo view('front/products/_card', ['p' => $p, 'listMode' => false]); endforeach; ?>
        <?php if (! $products): ?>
            <p class="col-span-full text-center text-slate-500">No products in this category yet — check back soon.</p>
        <?php endif; ?>
    </div>
</section>

<?php if ($testimonials): ?>
<section class="bg-slate-50 py-14">
    <div class="mx-auto max-w-5xl px-4 sm:px-6">
        <h2 class="text-center font-display text-2xl font-extrabold text-slate-900">What <?= esc(strtolower($category['name'])) ?> teams say</h2>
        <div class="mt-8 grid gap-6 md:grid-cols-2">
            <?php foreach ($testimonials as $t): ?>
            <figure class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <div class="text-amber-400"><?= str_repeat('<i class="fa-solid fa-star"></i>', (int) $t['rating']) ?></div>
                <blockquote class="mt-3 text-sm leading-relaxed text-slate-600">“<?= esc($t['quote']) ?>”</blockquote>
                <figcaption class="mt-4 flex items-center gap-3">
                    <?php if ($t['photo']): ?><img loading="lazy" src="<?= esc(media_url($t['photo'])) ?>" class="h-10 w-10 rounded-full object-cover" alt="<?= esc($t['name']) ?>"><?php endif; ?>
                    <div><p class="text-sm font-bold text-slate-900"><?= esc($t['name']) ?></p>
                    <p class="text-xs text-slate-500"><?= esc($t['role']) ?><?= $t['company'] ? ', ' . esc($t['company']) : '' ?></p></div>
                </figcaption>
            </figure>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if ($faqs): ?>
<section class="py-14">
    <div class="mx-auto max-w-3xl px-4 sm:px-6">
        <h2 class="text-center font-display text-2xl font-extrabold text-slate-900"><?= esc($category['name']) ?> FAQs</h2>
        <div class="mt-6 space-y-3">
            <?php foreach ($faqs as $i => $f): ?>
            <div x-data="{ open: <?= $i === 0 ? 'true' : 'false' ?> }" class="rounded-2xl border border-slate-200 bg-white">
                <button @click="open=!open" class="flex w-full items-center justify-between px-5 py-4 text-left font-semibold text-slate-800">
                    <?= esc($f['q'] ?? '') ?><i class="fa-solid fa-chevron-down text-sm text-primary transition" :class="open && 'rotate-180'"></i>
                </button>
                <div x-show="open" x-collapse class="px-5 pb-5 text-sm text-slate-600"><?= esc($f['a'] ?? '') ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="pb-16 text-center">
    <a href="<?= site_url('contact') ?>" class="inline-flex rounded-xl bg-gradient-to-r from-primary to-violet px-6 py-3 font-bold text-white shadow-soft hover:opacity-90">Talk to a <?= esc($category['name']) ?> expert</a>
</section>
