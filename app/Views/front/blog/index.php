<?php /* Blog index — navy hero + card grid, matches homepage design system */ ?>
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
            <i class="fa-solid fa-pen-nib"></i> <?= esc(setting('blog_eyebrow', 'Khybersoft Journal')) ?>
        </span>
        <h1 class="mt-6 font-display text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl">
            <?= esc(setting('blog_hero_heading', 'Ideas for building better business software.')) ?>
        </h1>
        <p class="mx-auto mt-5 max-w-2xl text-lg leading-8 text-slate-300">
            <?= esc(setting('blog_hero_sub', 'Product guides, practical advice, and fresh thinking from our team.')) ?>
        </p>
    </div>
</section>

<!-- Posts grid -->
<section class="bg-gradient-to-b from-slate-50 to-white py-20">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">
        <?php if (! empty($posts)): ?>
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($posts as $i => $post): ?>
                    <article class="group flex flex-col overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-soft"
                             data-aos="fade-up" data-aos-delay="<?= ($i % 3) * 100 ?>">
                        <a href="<?= site_url_path('/blog/' . urlencode((string) $post['slug'])) ?>" class="block aspect-[16/10] overflow-hidden bg-gradient-to-br from-indigo-100 to-violet-100">
                            <?php if (! empty($post['featured_image'])): ?>
                                <img src="<?= esc(media_url($post['featured_image'])) ?>" alt="<?= esc($post['title']) ?>" loading="lazy"
                                     class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                            <?php else: ?>
                                <div class="flex h-full items-center justify-center"><i class="fa-solid fa-newspaper text-5xl text-indigo-200"></i></div>
                            <?php endif; ?>
                        </a>
                        <div class="flex flex-1 flex-col p-7">
                            <div class="flex items-center gap-3 text-xs">
                                <span class="rounded-full bg-indigo-50 px-3 py-1 font-bold uppercase tracking-wide text-primary"><?= esc(($post['category_name'] ?? null) ?: 'Article') ?></span>
                                <time class="text-slate-400"><?= esc(date('M j, Y', strtotime((string) ($post['published_at'] ?? 'now')))) ?></time>
                            </div>
                            <h2 class="mt-4 font-display text-xl font-bold leading-snug text-slate-900 transition group-hover:text-primary">
                                <a href="<?= site_url_path('/blog/' . urlencode((string) $post['slug'])) ?>"><?= esc($post['title']) ?></a>
                            </h2>
                            <p class="mt-3 line-clamp-3 flex-1 text-sm leading-6 text-slate-500"><?= esc(strip_tags((string) (($post['excerpt'] ?? '') ?: ($post['content'] ?? '')))) ?></p>
                            <a href="<?= site_url_path('/blog/' . urlencode((string) $post['slug'])) ?>"
                               class="mt-6 inline-flex items-center gap-2 text-sm font-bold text-primary">
                                Read article <i class="fa-solid fa-arrow-right text-xs transition group-hover:translate-x-1"></i>
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <?php if (isset($pager)): ?>
                <div class="mt-14 flex justify-center"><?= $pager->links() ?></div>
            <?php endif; ?>
        <?php else: ?>
            <div class="rounded-3xl border border-dashed border-slate-300 bg-white px-6 py-20 text-center">
                <span class="mx-auto grid h-14 w-14 place-items-center rounded-2xl bg-gradient-to-br from-primary to-violet text-xl text-white shadow-soft"><i class="fa-solid fa-pen-nib"></i></span>
                <h2 class="mt-5 font-display text-2xl font-bold text-slate-900">New articles are on the way</h2>
                <p class="mt-2 text-slate-500">Check back soon for product guides and ideas from our team.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Newsletter CTA -->
<section class="bg-white pb-24">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">
        <div class="relative overflow-hidden rounded-3xl bg-navy p-10 text-center text-white shadow-glow sm:p-14">
            <div class="pointer-events-none absolute inset-0 opacity-[0.07]" aria-hidden="true"
                 style="background-image:radial-gradient(#fff 1px,transparent 1px);background-size:24px 24px;"></div>
            <div class="pointer-events-none absolute -right-16 -top-16 h-64 w-64 rounded-full bg-primary/25 blur-[90px]" aria-hidden="true"></div>
            <h2 class="relative font-display text-2xl font-extrabold sm:text-3xl"><?= esc(setting('blog_newsletter_heading', 'Get new articles in your inbox')) ?></h2>
            <p class="relative mx-auto mt-3 max-w-md text-sm leading-7 text-slate-300">One practical email a month. No spam, unsubscribe anytime.</p>

            <?php if ($msg = session()->getFlashdata('success')): ?>
                <p data-flash class="relative mx-auto mt-5 max-w-md rounded-xl border border-emerald-400/30 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-300"><?= esc($msg) ?></p>
            <?php endif; ?>
            <?php if ($msg = session()->getFlashdata('error')): ?>
                <p data-flash class="relative mx-auto mt-5 max-w-md rounded-xl border border-red-400/30 bg-red-500/10 px-4 py-3 text-sm text-red-300"><?= esc($msg) ?></p>
            <?php endif; ?>

            <form method="post" action="<?= site_url('subscribe') ?>" class="relative mx-auto mt-7 flex max-w-md flex-col gap-3 sm:flex-row">
                <?= csrf_field() ?>
                <input type="hidden" name="form_started_at" value="<?= time() ?>">
                <input type="hidden" name="source" value="blog">
                <div style="position:absolute; left:-9999px; top:auto; width:1px; height:1px; overflow:hidden;" aria-hidden="true">
                    <label for="blog-newsletter-website">Website</label>
                    <input type="text" name="website" id="blog-newsletter-website" tabindex="-1" autocomplete="off">
                </div>
                <label for="blog-email" class="sr-only">Email address</label>
                <input id="blog-email" name="email" type="email" autocomplete="email" required placeholder="you@company.com"
                       class="w-full min-w-0 rounded-xl border border-white/15 bg-white/10 px-4 py-3.5 text-sm text-white placeholder:text-slate-400 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/30">
                <button type="submit" class="shrink-0 rounded-xl bg-gradient-to-r from-primary to-violet px-6 py-3.5 text-sm font-bold text-white shadow-soft transition hover:-translate-y-0.5 hover:shadow-glow">
                    Subscribe
                </button>
            </form>
        </div>
    </div>
</section>
