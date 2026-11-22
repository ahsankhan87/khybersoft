<?php /* About page — matches homepage design system */ ?>
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
            <i class="fa-solid fa-heart"></i> Made with ❤️ in Pakistan
        </span>
        <h1 class="mt-6 font-display text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl">
            <?= esc(setting('about_heading', 'Business software that just works')) ?>
        </h1>
        <p class="mx-auto mt-5 max-w-2xl text-lg leading-8 text-slate-300">
            <?= esc(setting('about_sub', 'Khybersoft builds the tools that help businesses run smarter — POS, accounting, school and plot management, and HR. One platform, one login, one price.')) ?>
        </p>
        <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
            <a href="<?= site_url_path('/products') ?>" class="inline-flex items-center gap-2 rounded-2xl bg-gradient-to-r from-primary to-violet px-7 py-4 text-base font-bold text-white shadow-glow transition hover:-translate-y-0.5">
                Explore products <i class="fa-solid fa-arrow-right"></i>
            </a>
            <a href="<?= site_url_path('/contact') ?>" class="inline-flex items-center gap-2 rounded-2xl border border-white/20 bg-white/5 px-6 py-4 text-base font-semibold text-white backdrop-blur transition hover:bg-white/10">
                Talk to us
            </a>
        </div>
    </div>
</section>

<!-- Story + mission -->
<section class="bg-white py-24">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">
        <div class="grid items-center gap-14 lg:grid-cols-2">
            <div data-aos="fade-right">
                <p class="text-sm font-bold uppercase tracking-widest text-primary">Our story</p>
                <h2 class="mt-3 font-display text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">
                    Built by engineers who ran real businesses first
                </h2>
                <p class="mt-5 text-base leading-8 text-slate-600">
                    <?= esc(setting('about_story', 'Khybersoft started in Peshawar with a simple frustration: every shop, school and developer we knew was stitching together five disconnected tools. We decided to build one platform that does it all — beautifully, reliably, and at a price local businesses can actually afford.')) ?>
                </p>
                <p class="mt-4 text-base leading-8 text-slate-600">
                    <?= esc(setting('about_story_2', 'Today, hundreds of businesses across Pakistan and beyond run their daily operations on Khybersoft — from single-counter shops to multi-branch groups.')) ?>
                </p>
            </div>

            <!-- stats card -->
            <div class="grid grid-cols-2 gap-4" data-aos="fade-left">
                <?php
                $stats = [];
                for ($i = 1; $i <= 4; $i++) {
                    $v = setting("stat_{$i}_value");
                    if ($v === '') { continue; }
                    $stats[] = [$v . setting("stat_{$i}_suffix"), setting("stat_{$i}_label")];
                }
                if (! $stats) {
                    $stats = [['500+', 'Businesses'], ['50+', 'Countries'], ['10M+', 'Transactions processed'], ['99.9%', 'Uptime SLA']];
                }
                foreach ($stats as $si => [$val, $label]): ?>
                    <div class="rounded-3xl border border-slate-100 bg-gradient-to-b from-slate-50 to-white p-7 text-center transition hover:-translate-y-1 hover:shadow-soft">
                        <p class="font-display text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">
                            <span class="bg-gradient-to-r from-primary to-violet bg-clip-text text-transparent"><?= esc($val) ?></span>
                        </p>
                        <p class="mt-2 text-xs font-semibold uppercase tracking-widest text-slate-400"><?= esc($label) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- Values -->
<section class="bg-gradient-to-b from-slate-50 to-white py-24">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">
        <div class="mx-auto max-w-2xl text-center" data-aos="fade-up">
            <p class="text-sm font-bold uppercase tracking-widest text-accent">What we believe</p>
            <h2 class="mt-3 font-display text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">Our values</h2>
        </div>

        <div class="mt-14 grid gap-8 md:grid-cols-3">
            <?php
            $values = [
                ['fa-solid fa-bolt', 'Simple over clever', 'Software should disappear into your workflow. If it needs a manual, we have not finished designing it.'],
                ['fa-solid fa-shield-halved', 'Your data, your rules', 'Your business data belongs to you. Encrypted, backed up, exportable — always.'],
                ['fa-solid fa-handshake', 'Support like a partner', 'Real humans in Peshawar, answering in English and Urdu. No ticket black holes.'],
            ];
            foreach ($values as $vi => [$icon, $title, $desc]): ?>
                <div class="relative overflow-hidden rounded-3xl border border-slate-100 bg-white p-8 transition hover:-translate-y-1 hover:shadow-soft"
                     data-aos="fade-up" data-aos-delay="<?= $vi * 120 ?>">
                    <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-gradient-to-br from-primary/10 to-violet/10 blur-2xl"></div>
                    <span class="relative grid h-14 w-14 place-items-center rounded-2xl bg-gradient-to-br from-primary to-violet text-xl text-white shadow-soft">
                        <i class="<?= $icon ?>"></i>
                    </span>
                    <h3 class="relative mt-6 font-display text-xl font-bold text-slate-900"><?= esc($title) ?></h3>
                    <p class="relative mt-3 text-sm leading-7 text-slate-500"><?= esc($desc) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="relative overflow-hidden bg-gradient-to-br from-primary via-violet to-primary-700 py-20 text-white">
    <div class="pointer-events-none absolute inset-0 opacity-[0.08]" aria-hidden="true"
         style="background-image:radial-gradient(#fff 1px,transparent 1px);background-size:26px 26px;"></div>
    <div class="relative mx-auto max-w-3xl px-5 text-center lg:px-8">
        <h2 class="font-display text-3xl font-extrabold tracking-tight sm:text-4xl">Join 500+ businesses running on Khybersoft</h2>
        <p class="mx-auto mt-4 max-w-xl text-lg text-primary-100">Start your free trial today — setup is on us.</p>
        <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
            <a href="<?= site_url_path('/pricing') ?>" class="rounded-2xl bg-white px-8 py-4 text-base font-bold text-primary shadow-xl transition hover:-translate-y-0.5 hover:shadow-2xl">Start Free Trial</a>
            <a href="<?= site_url_path('/success-stories') ?>" class="rounded-2xl border-2 border-white/40 px-8 py-4 text-base font-bold text-white backdrop-blur transition hover:bg-white/10">Read success stories</a>
        </div>
    </div>
</section>
