<?php /* Section 13 — Help center preview: 3 video tutorial cards */ ?>
<section class="bg-white py-24" id="help">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">
        <div class="flex flex-col items-start justify-between gap-6 md:flex-row md:items-end" data-aos="fade-up">
            <div>
                <p class="text-sm font-bold uppercase tracking-widest text-accent">Help center</p>
                <h2 class="mt-3 font-display text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">
                    <?= esc(setting('help_heading', "Stuck? We've got you.")) ?>
                </h2>
            </div>
            <a href="<?= site_url_path('/tutorials') ?>" class="whitespace-nowrap text-sm font-bold text-primary hover:underline">Browse 200+ tutorials →</a>
        </div>

        <div class="mt-12 grid gap-8 md:grid-cols-3">
            <?php
            $tutorials = [
                ['title' => 'Set up your first POS terminal in 5 minutes', 'len' => '4:52', 'cat' => 'Getting started', 'video' => setting('tutorial_1_video'), 'thumb' => setting('tutorial_1_thumb')],
                ['title' => 'Create & send a WhatsApp invoice',             'len' => '3:10', 'cat' => 'Invoicing',       'video' => setting('tutorial_2_video'), 'thumb' => setting('tutorial_2_thumb')],
                ['title' => 'Run month-end closing without stress',         'len' => '8:24', 'cat' => 'Accounting',      'video' => setting('tutorial_3_video'), 'thumb' => setting('tutorial_3_thumb')],
            ];
            foreach ($tutorials as $ti => $tu): ?>
                <button type="button" onclick="ksOpenDemo('<?= esc($tu['video'] ?: setting('hero_video_url')) ?>')"
                        class="group overflow-hidden rounded-3xl border border-slate-100 bg-white text-left shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-glow"
                        data-aos="fade-up" data-aos-delay="<?= $ti * 120 ?>">
                    <div class="relative aspect-video overflow-hidden bg-gradient-to-br from-indigo-100 via-violet-100 to-emerald-50">
                        <?php if (! empty($tu['thumb'])): ?>
                            <img src="<?= esc(media_url($tu['thumb'])) ?>" alt="" loading="lazy" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                        <?php endif; ?>
                        <span class="absolute inset-0 m-auto flex h-14 w-14 items-center justify-center rounded-full bg-white/90 text-primary shadow-lg backdrop-blur transition group-hover:scale-110">
                            <i class="fa-solid fa-play ml-1"></i>
                        </span>
                        <span class="absolute bottom-3 right-3 rounded-lg bg-navy/85 px-2 py-1 text-xs font-bold text-white"><?= esc($tu['len']) ?></span>
                    </div>
                    <div class="p-6">
                        <span class="text-xs font-bold uppercase tracking-wider text-primary"><?= esc($tu['cat']) ?></span>
                        <h3 class="mt-2 font-display text-base font-bold text-slate-900 group-hover:text-primary"><?= esc($tu['title']) ?></h3>
                    </div>
                </button>
            <?php endforeach; ?>
        </div>
    </div>
</section>
