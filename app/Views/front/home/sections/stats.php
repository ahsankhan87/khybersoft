<?php /* Section 5 — Animated counters */ ?>
<section class="relative overflow-hidden bg-navy py-20 text-white">
    <div class="pointer-events-none absolute inset-0" aria-hidden="true">
        <div class="absolute left-1/3 top-0 h-72 w-72 rounded-full bg-primary/25 blur-[110px]"></div>
        <div class="absolute bottom-0 right-1/4 h-72 w-72 rounded-full bg-violet/25 blur-[110px]"></div>
    </div>
    <div class="relative mx-auto grid max-w-7xl grid-cols-2 gap-y-12 px-5 lg:grid-cols-4 lg:px-8">
        <?php for ($i = 1; $i <= 4; $i++):
            $val = setting("stat_{$i}_value", '');
            if ($val === '') continue; ?>
            <div class="text-center <?= $i < 4 ? 'lg:border-r lg:border-white/10' : '' ?>" data-aos="zoom-in" data-aos-delay="<?= ($i - 1) * 100 ?>">
                <p class="font-display text-4xl font-extrabold tracking-tight sm:text-5xl">
                    <span data-counter="<?= esc($val) ?>">0</span><span class="bg-gradient-to-r from-indigo-300 to-emerald-300 bg-clip-text text-transparent"><?= esc(setting("stat_{$i}_suffix")) ?></span>
                </p>
                <p class="mt-2 text-sm font-medium uppercase tracking-widest text-slate-400"><?= esc(setting("stat_{$i}_label")) ?></p>
            </div>
        <?php endfor; ?>
    </div>
</section>
