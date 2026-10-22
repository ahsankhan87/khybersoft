<section class="relative overflow-hidden bg-slate-950 py-20 text-white sm:py-28">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-indigo-900/50 via-slate-950 to-slate-950"></div>
    <div class="relative mx-auto max-w-7xl px-5 lg:px-8">
        <p class="text-sm font-bold uppercase tracking-[0.22em] text-indigo-300">Khybersoft Journal</p>
        <h1 class="mt-4 max-w-3xl font-display text-4xl font-extrabold tracking-tight sm:text-6xl">Ideas for building better business software.</h1>
        <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-300">Product guides, practical advice, and fresh thinking from our team.</p>
    </div>
</section>

<section class="bg-slate-50 py-16 sm:py-20">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">
        <?php if (! empty($posts)): ?>
            <div class="grid gap-7 sm:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($posts as $post): ?>
                    <article class="group flex flex-col overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                        <a href="<?= site_url('blog/' . rawurlencode((string) $post['slug'])) ?>" class="block aspect-[16/10] overflow-hidden bg-gradient-to-br from-indigo-100 to-violet-100">
                            <?php if (! empty($post['featured_image'])): ?><img src="<?= esc(media_url($post['featured_image'])) ?>" alt="<?= esc($post['title']) ?>" class="h-full w-full object-cover transition duration-500 group-hover:scale-105"><?php else: ?><div class="flex h-full items-center justify-center text-indigo-300"><i class="fa-solid fa-newspaper text-5xl"></i></div><?php endif; ?>
                        </a>
                        <div class="flex flex-1 flex-col p-7">
                            <div class="flex items-center gap-3 text-xs font-semibold uppercase tracking-wide text-indigo-700"><span><?= esc($post['category_name'] ?? 'Article') ?></span><span class="h-1 w-1 rounded-full bg-slate-300"></span><time><?= esc(date('M j, Y', strtotime((string) ($post['published_at'] ?? 'now')))) ?></time></div>
                            <h2 class="mt-4 font-display text-xl font-bold leading-snug text-slate-900 group-hover:text-indigo-700"><a href="<?= site_url('blog/' . rawurlencode((string) $post['slug'])) ?>"><?= esc($post['title']) ?></a></h2>
                            <p class="mt-3 line-clamp-3 flex-1 text-sm leading-6 text-slate-600"><?= esc(strip_tags((string) (($post['excerpt'] ?? '') ?: ($post['content'] ?? '')))) ?></p>
                            <a href="<?= site_url('blog/' . rawurlencode((string) $post['slug'])) ?>" class="mt-6 inline-flex items-center gap-2 text-sm font-bold text-indigo-700">Read article <i class="fa-solid fa-arrow-right text-xs transition group-hover:translate-x-1"></i></a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
            <?php if (isset($pager)): ?><div class="mt-12 flex justify-center"><?= $pager->links() ?></div><?php endif; ?>
        <?php else: ?>
            <div class="rounded-3xl border border-dashed border-slate-300 bg-white px-6 py-20 text-center">
                <span class="mx-auto grid h-14 w-14 place-items-center rounded-2xl bg-indigo-50 text-indigo-600"><i class="fa-solid fa-pen-nib text-xl"></i></span>
                <h2 class="mt-5 font-display text-2xl font-bold text-slate-900">New articles are on the way</h2>
                <p class="mt-2 text-slate-500">Check back soon for product guides and ideas from our team.</p>
            </div>
        <?php endif; ?>
    </div>
</section>
