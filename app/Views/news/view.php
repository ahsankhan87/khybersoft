<?php /* News single — navy hero header + body, matches design system. Vars: $news */ ?>
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
            <a href="<?= site_url_path('/news') ?>" class="inline-flex items-center gap-2 text-sm font-semibold text-primary-300 transition hover:text-white">
                <i class="fa-solid fa-arrow-left"></i> All news
            </a>

            <div class="mt-8 flex flex-wrap items-center gap-3 text-xs font-bold uppercase tracking-widest">
                <span class="rounded-full bg-primary/20 px-3 py-1 text-primary-200 ring-1 ring-inset ring-primary/30">News</span>
                <?php if (! empty($news['created_at'])): ?>
                    <time class="text-slate-400"><?= esc(date('M j, Y', strtotime((string) $news['created_at']))) ?></time>
                <?php endif; ?>
            </div>

            <h1 class="mt-5 font-display text-4xl font-extrabold leading-tight tracking-tight sm:text-5xl"><?= esc($news['title']) ?></h1>
        </div>
    </header>

    <!-- Body -->
    <div class="mx-auto max-w-3xl px-5 py-14 sm:py-20 lg:px-8">
        <div class="prose prose-lg prose-slate max-w-none prose-headings:font-display prose-headings:font-bold prose-a:font-semibold prose-a:text-primary hover:prose-a:underline">
            <?= nl2br(esc($news['body'])) ?>
        </div>

        <div class="mt-14 border-t border-slate-200 pt-8">
            <a href="<?= site_url_path('/news') ?>" class="inline-flex items-center gap-2 text-sm font-bold text-primary transition hover:underline">
                <i class="fa-solid fa-arrow-left"></i> Back to all news
            </a>
        </div>
    </div>
</article>

<!-- CTA -->
<section class="relative overflow-hidden bg-gradient-to-br from-primary via-violet to-primary-700 py-16 text-white">
    <div class="pointer-events-none absolute inset-0 opacity-[0.08]" aria-hidden="true"
         style="background-image:radial-gradient(#fff 1px,transparent 1px);background-size:26px 26px;"></div>
    <div class="relative mx-auto max-w-3xl px-5 text-center lg:px-8">
        <h2 class="font-display text-2xl font-extrabold tracking-tight sm:text-3xl">Stay in the loop</h2>
        <p class="mx-auto mt-3 max-w-lg text-primary-100">Follow our blog for product guides, or start your free trial today.</p>
        <div class="mt-7 flex flex-wrap items-center justify-center gap-4">
            <a href="<?= site_url_path('/blogs') ?>" class="rounded-2xl bg-white px-7 py-3.5 text-sm font-bold text-primary shadow-xl transition hover:-translate-y-0.5 hover:shadow-2xl">Read the blog</a>
            <a href="<?= site_url_path('/pricing') ?>" class="rounded-2xl border-2 border-white/40 px-7 py-3.5 text-sm font-bold text-white backdrop-blur transition hover:bg-white/10">Start Free Trial</a>
        </div>
    </div>
</section>
