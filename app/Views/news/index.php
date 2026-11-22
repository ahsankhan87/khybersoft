<?php /* News archive — navy hero + card grid, matches homepage design system. Vars: $news_list */ ?>
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
            <i class="fa-solid fa-bullhorn"></i> Newsroom
        </span>
        <h1 class="mt-6 font-display text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl">
            <?= esc(setting('news_heading', 'News & announcements')) ?>
        </h1>
        <p class="mx-auto mt-5 max-w-2xl text-lg leading-8 text-slate-300">
            <?= esc(setting('news_sub', 'Product launches, updates, and stories from the Khybersoft team.')) ?>
        </p>
    </div>
</section>

<!-- News grid -->
<section class="bg-gradient-to-b from-slate-50 to-white py-20">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">
        <?php if (! empty($news_list)): ?>
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($news_list as $i => $item): ?>
                    <article class="group flex flex-col overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-soft"
                             data-aos="fade-up" data-aos-delay="<?= ($i % 3) * 100 ?>">
                        <a href="<?= site_url_path('/news/' . urlencode((string) $item['slug'])) ?>" class="block aspect-[16/10] overflow-hidden bg-gradient-to-br from-indigo-100 to-violet-100">
                            <div class="flex h-full items-center justify-center"><i class="fa-solid fa-newspaper text-5xl text-indigo-200"></i></div>
                        </a>
                        <div class="flex flex-1 flex-col p-7">
                            <div class="flex items-center gap-3 text-xs">
                                <span class="rounded-full bg-indigo-50 px-3 py-1 font-bold uppercase tracking-wide text-primary">News</span>
                                <?php if (! empty($item['created_at'])): ?>
                                    <time class="text-slate-400"><?= esc(date('M j, Y', strtotime((string) $item['created_at']))) ?></time>
                                <?php endif; ?>
                            </div>
                            <h2 class="mt-4 font-display text-xl font-bold leading-snug text-slate-900 transition group-hover:text-primary">
                                <a href="<?= site_url_path('/news/' . urlencode((string) $item['slug'])) ?>"><?= esc($item['title']) ?></a>
                            </h2>
                            <p class="mt-3 line-clamp-3 flex-1 text-sm leading-6 text-slate-500"><?= esc(strip_tags((string) $item['body'])) ?></p>
                            <a href="<?= site_url_path('/news/' . urlencode((string) $item['slug'])) ?>"
                               class="mt-6 inline-flex items-center gap-2 text-sm font-bold text-primary">
                                Read more <i class="fa-solid fa-arrow-right text-xs transition group-hover:translate-x-1"></i>
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="rounded-3xl border border-dashed border-slate-300 bg-white px-6 py-20 text-center">
                <span class="mx-auto grid h-14 w-14 place-items-center rounded-2xl bg-gradient-to-br from-primary to-violet text-xl text-white shadow-soft"><i class="fa-solid fa-bullhorn"></i></span>
                <h2 class="mt-5 font-display text-2xl font-bold text-slate-900">No news yet</h2>
                <p class="mt-2 text-slate-500">Announcements from our team will show up here.</p>
            </div>
        <?php endif; ?>
    </div>
</section>
