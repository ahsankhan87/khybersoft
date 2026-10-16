<?php /* Section 12 — Integrations grid with hover tooltips */ ?>
<?php if (! empty($integrations)): ?>
<section class="bg-gradient-to-b from-indigo-50/40 to-white py-24" id="integrations">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">
        <div class="mx-auto max-w-2xl text-center" data-aos="fade-up">
            <p class="text-sm font-bold uppercase tracking-widest text-primary">Integrations</p>
            <h2 class="mt-3 font-display text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">
                <?= esc(setting('integrations_heading', 'Works with the tools you already use')) ?>
            </h2>
        </div>

        <div class="mt-14 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
            <?php foreach ($integrations as $ig): ?>
                <div class="group relative flex flex-col items-center justify-center gap-3 rounded-2xl border border-slate-100 bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1.5 hover:border-indigo-200 hover:shadow-soft"
                     data-aos="zoom-in">
                    <?php if (! empty($ig['logo'])): ?>
                        <img src="<?= esc(media_url($ig['logo'])) ?>" alt="<?= esc($ig['name']) ?>" loading="lazy" width="40" height="40" class="h-10 w-10 object-contain grayscale transition group-hover:grayscale-0">
                    <?php else: ?>
                        <i class="<?= esc($ig['icon'] ?: 'fa-solid fa-plug') ?> text-3xl text-slate-400 transition group-hover:text-primary"></i>
                    <?php endif; ?>
                    <span class="text-xs font-bold text-slate-600"><?= esc($ig['name']) ?></span>

                    <?php if (! empty($ig['description'])): ?>
                        <!-- tooltip -->
                        <div role="tooltip" x-data x-show="true" class="pointer-events-none absolute -top-11 left-1/2 z-10 w-max max-w-[220px] -translate-x-1/2 scale-90 rounded-xl bg-navy px-3 py-2 text-center text-xs font-medium text-white opacity-0 shadow-lg transition-all duration-200 group-hover:scale-100 group-hover:opacity-100">
                            <?= esc($ig['description']) ?>
                            <span class="absolute left-1/2 top-full -translate-x-1/2 border-[6px] border-transparent border-t-navy"></span>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
