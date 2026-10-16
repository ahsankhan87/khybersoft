<?php /* Section 7 — Why Khybersoft: 3 benefit blocks */ ?>
<section class="bg-white py-24" id="why">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">
        <div class="mx-auto max-w-2xl text-center" data-aos="fade-up">
            <p class="text-sm font-bold uppercase tracking-widest text-accent">Why Khybersoft</p>
            <h2 class="mt-3 font-display text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">
                <?= esc(setting('why_heading', 'Why growing teams choose Khybersoft')) ?>
            </h2>
        </div>

        <div class="mt-14 grid gap-8 md:grid-cols-3">
            <?php for ($i = 1; $i <= 3; $i++):
                if (trim(setting("why_{$i}_title")) === '') continue; ?>
                <div class="relative overflow-hidden rounded-3xl border border-slate-100 bg-gradient-to-b from-slate-50 to-white p-8 transition hover:-translate-y-1 hover:shadow-soft"
                     data-aos="fade-up" data-aos-delay="<?= ($i - 1) * 120 ?>">
                    <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-gradient-to-br from-primary/10 to-violet/10 blur-2xl"></div>
                    <span class="relative inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-primary to-violet text-xl text-white shadow-soft">
                        <i class="<?= esc(setting("why_{$i}_icon", 'fa-solid fa-star')) ?>"></i>
                    </span>
                    <h3 class="relative mt-6 font-display text-xl font-bold text-slate-900"><?= esc(setting("why_{$i}_title")) ?></h3>
                    <p class="relative mt-3 text-sm leading-7 text-slate-500"><?= esc(setting("why_{$i}_text")) ?></p>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</section>
