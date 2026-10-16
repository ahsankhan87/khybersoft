<?php /* Section 9 — Success stories / case studies */ ?>
<?php if (! empty($stories)): ?>
<section class="bg-white py-24" id="success-stories">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">
        <div class="mx-auto max-w-2xl text-center" data-aos="fade-up">
            <p class="text-sm font-bold uppercase tracking-widest text-primary">Success stories</p>
            <h2 class="mt-3 font-display text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">
                <?= esc(setting('stories_heading', 'Real businesses. Real results.')) ?>
            </h2>
        </div>

        <div class="mt-14 grid gap-8 lg:grid-cols-3">
            <?php foreach ($stories as $si => $s):
                $metrics = json_decode((string) $s['metrics'], true) ?: []; ?>
                <article class="group flex flex-col overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-glow"
                         data-aos="fade-up" data-aos-delay="<?= $si * 120 ?>">
                    <div class="relative h-44 overflow-hidden bg-gradient-to-br from-indigo-600 via-primary to-violet">
                        <?php if (! empty($s['hero_image'])): ?>
                            <img src="<?= esc(media_url($s['hero_image'])) ?>" alt="" loading="lazy" class="h-full w-full object-cover opacity-90 transition duration-500 group-hover:scale-105">
                        <?php else: ?>
                            <div class="absolute inset-0 opacity-20" style="background-image:radial-gradient(circle at 20% 30%,#fff 1px,transparent 1px);background-size:22px 22px;"></div>
                            <p class="absolute bottom-5 left-6 right-6 font-display text-2xl font-extrabold leading-tight text-white"><?= esc($s['headline']) ?></p>
                        <?php endif; ?>
                        <?php if (! empty($s['industry'])): ?>
                            <span class="absolute right-4 top-4 rounded-full bg-white/15 px-3 py-1 text-xs font-bold text-white backdrop-blur"><?= esc($s['industry']) ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="flex flex-1 flex-col p-7">
                        <?php if (! empty($s['hero_image'])): ?><h3 class="mb-3 font-display text-xl font-bold text-slate-900"><?= esc($s['headline']) ?></h3><?php endif; ?>

                        <p class="text-sm italic leading-7 text-slate-600">“<?= esc($s['quote']) ?>”</p>

                        <div class="mt-4 flex flex-wrap gap-2">
                            <?php foreach ($metrics as $m): ?>
                                <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700 ring-1 ring-inset ring-emerald-100">
                                    <i class="fa-solid fa-arrow-trend-up mr-1"></i><?= esc($m['label'] ?? $m) ?>
                                </span>
                            <?php endforeach; ?>
                        </div>

                        <div class="mt-6 flex items-center gap-3 border-t border-slate-100 pt-5">
                            <?php if (! empty($s['photo'])): ?>
                                <img src="<?= esc(media_url($s['photo'])) ?>" alt="<?= esc($s['customer_name']) ?>" loading="lazy" class="h-11 w-11 rounded-full object-cover ring-2 ring-indigo-100" width="44" height="44">
                            <?php else: ?>
                                <span class="flex h-11 w-11 items-center justify-center rounded-full bg-gradient-to-br from-primary to-violet text-sm font-bold text-white">
                                    <?= esc(mb_substr(strtoupper((string) $s['customer_name']), 0, 1)) ?>
                                </span>
                            <?php endif; ?>
                            <div class="min-w-0">
                                <p class="truncate text-sm font-bold text-slate-900"><?= esc($s['customer_name']) ?> · <?= esc($s['role']) ?></p>
                                <p class="truncate text-xs text-slate-500"><?= esc($s['company']) ?></p>
                            </div>
                            <?php if (! empty($s['logo'])): ?>
                                <img src="<?= esc(media_url($s['logo'])) ?>" alt="" loading="lazy" class="ml-auto h-7 w-auto grayscale">
                            <?php endif; ?>
                        </div>

                        <a href="<?= site_url_path('/success-stories/' . $s['slug']) ?>"
                           class="mt-5 inline-flex items-center gap-1 text-sm font-bold text-primary transition group-hover:gap-2">Read full story →</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <p class="mt-12 text-center">
            <a href="<?= site_url_path('/success-stories') ?>" class="text-sm font-bold text-primary hover:underline">
                See all <?= (int) ($storyCount ?? count($stories)) ?>+ success stories →
            </a>
        </p>
    </div>
</section>
<?php endif; ?>
