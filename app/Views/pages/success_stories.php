<?php /* Success stories listing — navy hero + story cards. Vars: $stories */ ?>
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
            <i class="fa-solid fa-trophy"></i> Customer stories
        </span>
        <h1 class="mt-6 font-display text-4xl font-extrabold tracking-tight sm:text-5xl">
            <?= esc(setting('stories_hero_heading', 'Real businesses. Real results.')) ?>
        </h1>
        <p class="mx-auto mt-5 max-w-2xl text-lg leading-8 text-slate-300">
            <?= esc(setting('stories_hero_sub', 'See how shops, schools, developers and enterprises run their operations on Khybersoft.')) ?>
        </p>
    </div>
</section>

<!-- Stories grid -->
<section class="bg-gradient-to-b from-slate-50 to-white py-20">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">
        <?php if (! empty($stories)): ?>
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($stories as $si => $s):
                    $metrics = json_decode((string) ($s['metrics'] ?? '[]'), true) ?: []; ?>
                    <article class="group flex flex-col overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-glow"
                             data-aos="fade-up" data-aos-delay="<?= ($si % 3) * 100 ?>">
                        <div class="relative h-44 overflow-hidden bg-gradient-to-br from-indigo-600 via-primary to-violet">
                            <?php if (! empty($s['hero_image'])): ?>
                                <img src="<?= esc(media_url($s['hero_image'])) ?>" alt="" loading="lazy" class="h-full w-full object-cover opacity-90 transition duration-500 group-hover:scale-105">
                            <?php else: ?>
                                <div class="absolute inset-0 opacity-20" style="background-image:radial-gradient(circle at 20% 30%,#fff 1px,transparent 1px);background-size:22px 22px;"></div>
                                <p class="absolute bottom-5 left-6 right-6 font-display text-xl font-extrabold leading-tight text-white"><?= esc($s['headline']) ?></p>
                            <?php endif; ?>
                            <?php if (! empty($s['industry'])): ?>
                                <span class="absolute right-4 top-4 rounded-full bg-white/15 px-3 py-1 text-xs font-bold text-white backdrop-blur"><?= esc($s['industry']) ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="flex flex-1 flex-col p-7">
                            <?php if (! empty($s['hero_image'])): ?>
                                <h2 class="mb-3 font-display text-xl font-bold text-slate-900"><?= esc($s['headline']) ?></h2>
                            <?php endif; ?>

                            <p class="text-sm italic leading-7 text-slate-600">“<?= esc($s['quote']) ?>”</p>

                            <?php if ($metrics): ?>
                                <div class="mt-4 flex flex-wrap gap-2">
                                    <?php foreach (array_slice($metrics, 0, 3) as $m): ?>
                                        <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700 ring-1 ring-inset ring-emerald-100">
                                            <i class="fa-solid fa-arrow-trend-up mr-1"></i><?= esc($m['label'] ?? $m) ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <div class="mt-6 flex items-center gap-3 border-t border-slate-100 pt-5">
                                <?php if (! empty($s['photo'])): ?>
                                    <img src="<?= esc(media_url($s['photo'])) ?>" alt="<?= esc($s['customer_name']) ?>" loading="lazy" class="h-11 w-11 rounded-full object-cover ring-2 ring-indigo-100">
                                <?php else: ?>
                                    <span class="flex h-11 w-11 items-center justify-center rounded-full bg-gradient-to-br from-primary to-violet text-sm font-bold text-white">
                                        <?= esc(mb_substr(strtoupper((string) $s['customer_name']), 0, 1)) ?>
                                    </span>
                                <?php endif; ?>
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-bold text-slate-900"><?= esc($s['customer_name']) ?><?= $s['role'] ? ' · ' . esc($s['role']) : '' ?></p>
                                    <p class="truncate text-xs text-slate-500"><?= esc($s['company']) ?></p>
                                </div>
                            </div>

                            <a href="<?= site_url_path('/success-stories/' . $s['slug']) ?>"
                               class="mt-5 inline-flex items-center gap-1 text-sm font-bold text-primary transition group-hover:gap-2">Read full story →</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="rounded-3xl border border-dashed border-slate-300 bg-white px-6 py-20 text-center">
                <span class="mx-auto grid h-14 w-14 place-items-center rounded-2xl bg-gradient-to-br from-primary to-violet text-xl text-white shadow-soft"><i class="fa-solid fa-trophy"></i></span>
                <h2 class="mt-5 font-display text-2xl font-bold text-slate-900">Stories coming soon</h2>
                <p class="mt-2 text-slate-500">We're collecting stories from our customers — check back soon.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- CTA -->
<section class="relative overflow-hidden bg-gradient-to-br from-primary via-violet to-primary-700 py-20 text-white">
    <div class="pointer-events-none absolute inset-0 opacity-[0.08]" aria-hidden="true"
         style="background-image:radial-gradient(#fff 1px,transparent 1px);background-size:26px 26px;"></div>
    <div class="relative mx-auto max-w-3xl px-5 text-center lg:px-8">
        <h2 class="font-display text-3xl font-extrabold tracking-tight sm:text-4xl">Your story could be next</h2>
        <p class="mx-auto mt-4 max-w-xl text-lg text-primary-100">Start your free trial and see why hundreds of businesses choose Khybersoft.</p>
        <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
            <a href="<?= site_url_path('/pricing') ?>" class="rounded-2xl bg-white px-8 py-4 text-base font-bold text-primary shadow-xl transition hover:-translate-y-0.5 hover:shadow-2xl">Start Free Trial</a>
            <a href="<?= site_url_path('/contact') ?>" class="rounded-2xl border-2 border-white/40 px-8 py-4 text-base font-bold text-white backdrop-blur transition hover:bg-white/10">Book Demo</a>
        </div>
    </div>
</section>
