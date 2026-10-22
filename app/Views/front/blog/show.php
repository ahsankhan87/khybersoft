<article>
    <header class="relative overflow-hidden bg-slate-950 py-16 text-white sm:py-24">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-indigo-900/50 via-slate-950 to-slate-950"></div>
        <div class="relative mx-auto max-w-4xl px-5 lg:px-8">
            <a href="<?= site_url('blog') ?>" class="text-sm font-semibold text-indigo-300 hover:text-white"><i class="fa-solid fa-arrow-left mr-2"></i>All articles</a>
            <div class="mt-10 flex items-center gap-3 text-xs font-bold uppercase tracking-widest text-indigo-300"><span><?= esc($post['category_name'] ?? 'Article') ?></span><span class="h-1 w-1 rounded-full bg-slate-500"></span><time><?= esc(date('M j, Y', strtotime((string) ($post['published_at'] ?? 'now')))) ?></time><?php if (! empty($post['read_minutes'])): ?><span class="h-1 w-1 rounded-full bg-slate-500"></span><span><?= (int) $post['read_minutes'] ?> min read</span><?php endif; ?></div>
            <h1 class="mt-5 font-display text-4xl font-extrabold leading-tight tracking-tight sm:text-6xl"><?= esc($post['title']) ?></h1>
            <?php if (! empty($post['excerpt'])): ?><p class="mt-6 max-w-3xl text-lg leading-8 text-slate-300"><?= esc($post['excerpt']) ?></p><?php endif; ?>
            <p class="mt-6 text-sm text-slate-400"><?php if (! empty($post['author_name'])): ?>By <?= esc($post['author_name']) ?><?php endif; ?></p>
        </div>
    </header>
    <?php if (! empty($post['featured_image'])): ?><div class="mx-auto -mt-1 max-w-6xl px-5 lg:px-8"><img src="<?= esc(media_url($post['featured_image'])) ?>" alt="<?= esc($post['title']) ?>" class="max-h-[34rem] w-full rounded-3xl object-cover shadow-xl"></div><?php endif; ?>
    <div class="mx-auto max-w-3xl px-5 py-14 sm:py-20 lg:px-8">
        <div class="prose prose-lg prose-slate max-w-none prose-headings:font-display prose-headings:font-bold prose-a:text-indigo-700">
            <?= $post['content'] ?>
        </div>
        <div class="mt-14 border-t border-slate-200 pt-8"><a href="<?= site_url('blog') ?>" class="font-semibold text-indigo-700 hover:underline"><i class="fa-solid fa-arrow-left mr-2"></i>Back to all articles</a></div>
    </div>
</article>
