<?php
/** Products listing. Vars: $heading,$subheading,$categories,$activeCategory,$searchQuery,$featured,$products,$faqs */
$listMode = false; // toggled client-side via Alpine
?>
<!-- Hero -->
<section class="relative overflow-hidden bg-navy pb-20 pt-24 text-white">
    <div class="absolute inset-0 opacity-30" style="background:radial-gradient(60rem 30rem at 20% 0%, rgb(79 70 229/.5), transparent), radial-gradient(50rem 25rem at 90% 30%, rgb(124 58 237/.4), transparent);"></div>
    <div class="relative mx-auto max-w-7xl px-4 text-center sm:px-6 lg:px-8">
        <h1 class="font-display text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl"><?= esc($heading) ?></h1>
        <p class="mx-auto mt-5 max-w-2xl text-lg text-slate-300"><?= esc($subheading) ?></p>
    </div>
</section>

<!-- Filters + search + view toggle -->
<section x-data="{ view: 'grid', q: <?= json_encode($searchQuery) ?> }" class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div class="flex flex-wrap gap-2">
            <a href="<?= site_url('products') ?>" class="rounded-full px-4 py-2 text-sm font-semibold transition <?= ! $activeCategory && ! $searchQuery ? 'bg-gradient-to-r from-primary to-violet text-white shadow-soft' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' ?>">All</a>
            <?php foreach ($categories as $c): ?>
                <a href="<?= site_url('products/category-filter/' . $c['slug']) ?>"
                   onclick="window.location='<?= site_url('products') ?>?category=<?= esc($c['slug']) ?>';return false;"
                   class="rounded-full px-4 py-2 text-sm font-semibold transition <?= $activeCategory === $c['slug'] ? 'bg-gradient-to-r from-primary to-violet text-white shadow-soft' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' ?>">
                    <i class="<?= esc($c['icon'] ?: 'fa-solid fa-layer-group') ?> mr-1.5"></i><?= esc($c['name']) ?>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="flex items-center gap-3">
            <label class="relative block">
                <i class="fa-solid fa-magnifying-glass pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="search" x-model="q" name="q" placeholder="Search products…"
                       @input.debounce.300ms="document.getElementById('searchform').submit()"
                       class="w-64 rounded-xl border border-slate-300 bg-white py-2.5 pl-11 pr-4 text-sm shadow-sm outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
            </label>
            <div class="hidden rounded-xl bg-slate-100 p-1 sm:flex">
                <button @click="view='grid'" :class="view==='grid' && 'bg-white shadow text-primary'" class="rounded-lg px-3 py-1.5 text-sm font-semibold text-slate-500"><i class="fa-solid fa-table-cells-large"></i></button>
                <button @click="view='list'" :class="view==='list' && 'bg-white shadow text-primary'" class="rounded-lg px-3 py-1.5 text-sm font-semibold text-slate-500"><i class="fa-solid fa-list"></i></button>
            </div>
        </div>
    </div>

    <form id="searchform" method="get" action="<?= site_url('products') ?>" class="sr-only">
        <input type="hidden" name="q" :value="q">
        <?php if ($activeCategory): ?><input type="hidden" name="category" value="<?= esc($activeCategory) ?>"><?php endif; ?>
    </form>

    <!-- Featured row -->
    <?php if ($featured && ! $searchQuery && ! $activeCategory): ?>
        <div class="mt-10">
            <h2 class="mb-5 font-display text-sm font-bold uppercase tracking-widest text-primary"><i class="fa-solid fa-bolt mr-1"></i> Featured products</h2>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($featured as $p) { echo view('front/products/_card', ['p' => $p, 'listMode' => false]); } ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- All products -->
    <div class="mt-10 grid gap-6" :class="view==='grid' ? 'sm:grid-cols-2 lg:grid-cols-3' : 'grid-cols-1'">
        <?php if (! $featured || $searchQuery || $activeCategory): ?>
            <?php foreach ($featured as $p) { /* include filtered featured too */ echo view('front/products/_card', ['p' => $p, 'listMode' => false]); } ?>
        <?php endif; ?>
        <?php foreach ($products as $p): ?>
            <template x-if="view==='grid'"><div><?php echo view('front/products/_card', ['p' => $p, 'listMode' => false]); ?></div></template>
            <template x-if="view==='list'"><div><?php echo view('front/products/_card', ['p' => $p, 'listMode' => true]); ?></div></template>
        <?php endforeach; ?>
        <?php if (! $products && ! $featured): ?>
            <div class="col-span-full rounded-3xl border border-dashed border-slate-300 p-12 text-center text-slate-500">
                <i class="fa-solid fa-box-open mb-3 text-3xl text-slate-300"></i>
                <p>No products match your search.</p>
                <a class="mt-2 inline-block font-semibold text-primary hover:underline" href="<?= site_url('products') ?>">Clear filters →</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Comparison hint -->
    <div class="mt-12 rounded-3xl bg-gradient-to-r from-indigo-50 to-violet-50 p-8 text-center ring-1 ring-indigo-100">
        <p class="font-display text-lg font-bold text-slate-900">Not sure which product fits?</p>
        <p class="mt-1 text-sm text-slate-600">Compare all modules, features and prices side by side.</p>
        <a href="<?= site_url('pricing') ?>" class="mt-4 inline-flex items-center gap-2 rounded-xl bg-white px-5 py-2.5 text-sm font-bold text-primary shadow ring-1 ring-indigo-200 hover:ring-primary">Compare all products <i class="fa-solid fa-arrow-right text-xs"></i></a>
    </div>
</section>

<!-- FAQ accordion -->
<?php if ($faqs): ?>
<section class="bg-slate-50 py-16">
    <div class="mx-auto max-w-3xl px-4 sm:px-6">
        <h2 class="text-center font-display text-3xl font-extrabold text-slate-900">Frequently asked questions</h2>
        <div class="mt-8 space-y-3">
            <?php foreach ($faqs as $i => $f): ?>
            <div x-data="{ open: <?= $i === 0 ? 'true' : 'false' ?> }" class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
                <button @click="open = !open" class="flex w-full items-center justify-between px-5 py-4 text-left font-semibold text-slate-800">
                    <?= esc($f['q'] ?? '') ?>
                    <i class="fa-solid fa-chevron-down text-sm text-primary transition" :class="open && 'rotate-180'"></i>
                </button>
                <div x-show="open" x-collapse class="px-5 pb-5 text-sm leading-relaxed text-slate-600"><?= esc($f['a'] ?? '') ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Final CTA -->
<section class="py-16 text-center">
    <div class="mx-auto max-w-3xl px-4">
        <h2 class="font-display text-3xl font-extrabold text-slate-900">Ready to see it live?</h2>
        <p class="mt-3 text-slate-600">Get a personalized walkthrough with a product expert — 30 minutes, no pressure.</p>
        <div class="mt-6 flex justify-center gap-4">
            <a href="<?= site_url('contact') ?>" class="rounded-xl bg-gradient-to-r from-primary to-violet px-6 py-3 font-bold text-white shadow-soft hover:opacity-90">Book a free demo</a>
            <a href="<?= site_url('pricing') ?>" class="rounded-xl border border-slate-300 px-6 py-3 font-bold text-slate-700 hover:border-primary hover:text-primary">See pricing</a>
        </div>
    </div>
</section>
