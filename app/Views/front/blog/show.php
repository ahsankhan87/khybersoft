<?php /* Blog single — navy hero header + prose body, matches design system */ ?>
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
            <a href="<?= site_url_path('/blogs') ?>" class="inline-flex items-center gap-2 text-sm font-semibold text-primary-300 transition hover:text-white">
                <i class="fa-solid fa-arrow-left"></i> All articles
            </a>

            <div class="mt-8 flex flex-wrap items-center gap-3 text-xs font-bold uppercase tracking-widest">
                <span class="rounded-full bg-primary/20 px-3 py-1 text-primary-200 ring-1 ring-inset ring-primary/30"><?= esc(($post['category_name'] ?? null) ?: 'Article') ?></span>
                <time class="text-slate-400"><?= esc(date('M j, Y', strtotime((string) ($post['published_at'] ?? 'now')))) ?></time>
                <?php if (! empty($post['read_minutes'])): ?>
                    <span class="text-slate-500">·</span>
                    <span class="text-slate-400 normal-case tracking-normal"><?= (int) $post['read_minutes'] ?> min read</span>
                <?php endif; ?>
            </div>

            <h1 class="mt-5 font-display text-4xl font-extrabold leading-tight tracking-tight sm:text-5xl"><?= esc($post['title']) ?></h1>

            <?php if (! empty($post['excerpt'])): ?>
                <p class="mt-5 max-w-2xl text-lg leading-8 text-slate-300"><?= esc($post['excerpt']) ?></p>
            <?php endif; ?>

            <div class="mt-7 flex items-center gap-3">
                <span class="grid h-10 w-10 place-items-center rounded-full bg-gradient-to-br from-primary to-violet text-sm font-bold text-white">
                    <?= esc(mb_substr(strtoupper((string) ($post['author_name'] ?? 'K')), 0, 1)) ?>
                </span>
                <div>
                    <p class="text-sm font-bold text-white"><?= esc(($post['author_name'] ?? null) ?: setting('site_name', 'Khybersoft') . ' Team') ?></p>
                    <p class="text-xs text-slate-400"><?= esc(setting('site_name', 'Khybersoft')) ?></p>
                </div>
            </div>
        </div>
    </header>

    <!-- Featured image -->
    <?php if (! empty($post['featured_image'])): ?>
        <div class="mx-auto max-w-5xl px-5 lg:px-8">
            <img src="<?= esc(media_url($post['featured_image'])) ?>" alt="<?= esc($post['title']) ?>"
                 class="-mt-8 max-h-[30rem] w-full rounded-3xl border border-slate-100 object-cover shadow-xl">
        </div>
    <?php endif; ?>

    <!-- Body -->
    <div class="mx-auto max-w-3xl px-5 py-14 sm:py-20 lg:px-8">
        <div class="prose prose-lg prose-slate max-w-none prose-headings:font-display prose-headings:font-bold prose-a:font-semibold prose-a:text-primary hover:prose-a:underline prose-img:rounded-2xl">
            <?= $post['content'] ?>
        </div>

        <!-- Share + back -->
        <div class="mt-14 flex flex-wrap items-center justify-between gap-4 border-t border-slate-200 pt-8">
            <a href="<?= site_url_path('/blogs') ?>" class="inline-flex items-center gap-2 text-sm font-bold text-primary transition hover:underline">
                <i class="fa-solid fa-arrow-left"></i> Back to all articles
            </a>
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold uppercase tracking-widest text-slate-400">Share</span>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= rawurlencode(current_url()) ?>" target="_blank" rel="noopener" aria-label="Share on Facebook"
                   class="grid h-9 w-9 place-items-center rounded-full border border-slate-200 text-slate-500 transition hover:border-primary hover:bg-primary hover:text-white"><i class="fa-brands fa-facebook-f text-xs"></i></a>
                <a href="https://twitter.com/intent/tweet?url=<?= rawurlencode(current_url()) ?>&text=<?= rawurlencode((string) $post['title']) ?>" target="_blank" rel="noopener" aria-label="Share on X"
                   class="grid h-9 w-9 place-items-center rounded-full border border-slate-200 text-slate-500 transition hover:border-primary hover:bg-primary hover:text-white"><i class="fa-brands fa-x-twitter text-xs"></i></a>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= rawurlencode(current_url()) ?>" target="_blank" rel="noopener" aria-label="Share on LinkedIn"
                   class="grid h-9 w-9 place-items-center rounded-full border border-slate-200 text-slate-500 transition hover:border-primary hover:bg-primary hover:text-white"><i class="fa-brands fa-linkedin-in text-xs"></i></a>
            </div>
        </div>
    </div>
</article>

<!-- CTA -->
<section class="relative overflow-hidden bg-gradient-to-br from-primary via-violet to-primary-700 py-16 text-white">
    <div class="pointer-events-none absolute inset-0 opacity-[0.08]" aria-hidden="true"
         style="background-image:radial-gradient(#fff 1px,transparent 1px);background-size:26px 26px;"></div>
    <div class="relative mx-auto max-w-3xl px-5 text-center lg:px-8">
        <h2 class="font-display text-2xl font-extrabold tracking-tight sm:text-3xl"><?= esc(setting('blog_cta_heading', 'Ready to run your business on Khybersoft?')) ?></h2>
        <p class="mx-auto mt-3 max-w-lg text-primary-100">Start your 14-day free trial — no credit card required.</p>
        <div class="mt-7 flex flex-wrap items-center justify-center gap-4">
            <a href="<?= site_url_path('/pricing') ?>" class="rounded-2xl bg-white px-7 py-3.5 text-sm font-bold text-primary shadow-xl transition hover:-translate-y-0.5 hover:shadow-2xl">Start Free Trial</a>
            <a href="<?= site_url_path('/contact') ?>" class="rounded-2xl border-2 border-white/40 px-7 py-3.5 text-sm font-bold text-white backdrop-blur transition hover:bg-white/10">Book Demo</a>
        </div>
    </div>
</section>
