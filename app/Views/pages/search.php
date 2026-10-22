<?php /** Vars: $q, $products, $posts */ ?>
<section class="relative overflow-hidden bg-navy pb-16 pt-24 text-white">
    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h1 class="font-display text-3xl font-extrabold sm:text-4xl">Search</h1>
        <form method="get" action="<?= site_url('search') ?>" class="mt-6 flex max-w-xl gap-3">
            <input type="search" name="q" value="<?= esc($q) ?>" placeholder="Search products, articles…"
                   class="w-full rounded-xl border border-white/20 bg-white/10 px-4 py-3 text-sm text-white placeholder:text-slate-400 focus:border-primary focus:outline-none">
            <button class="rounded-xl bg-gradient-to-r from-primary to-violet px-6 py-3 text-sm font-bold text-white">Search</button>
        </form>
    </div>
</section>

<section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
    <?php if ($q === ''): ?>
        <p class="text-slate-500">Type a keyword above to search.</p>
    <?php else: ?>
        <h2 class="font-display text-xl font-bold text-slate-900">
            Results for “<?= esc($q) ?>”
            <span class="text-sm font-medium text-slate-400">(<?= count($products) + count($posts) ?> found)</span>
        </h2>

        <?php if ($products): ?>
            <h3 class="mt-8 text-sm font-bold uppercase tracking-widest text-primary">Products</h3>
            <div class="mt-4 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($products as $p): echo view('front/products/_card', ['p' => $p, 'listMode' => false]); endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($posts): ?>
            <h3 class="mt-10 text-sm font-bold uppercase tracking-widest text-primary">Articles</h3>
            <div class="mt-4 grid gap-6 md:grid-cols-3">
                <?php foreach ($posts as $post): ?>
                    <a href="<?= site_url_path('/blog/' . urlencode((string) $post['slug'])) ?>"
                       class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-soft">
                        <h4 class="font-display text-lg font-bold text-slate-900"><?= esc($post['title']) ?></h4>
                        <p class="mt-2 line-clamp-2 text-sm text-slate-500"><?= esc(strip_tags((string) $post['body'])) ?></p>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (! $products && ! $posts): ?>
            <p class="mt-6 text-slate-500">No results found. Try a different keyword.</p>
        <?php endif; ?>
    <?php endif; ?>
</section>
