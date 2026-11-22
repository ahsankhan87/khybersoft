<?php /* Partners page — navy hero + featured partner + partner program */ ?>
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
            <i class="fa-solid fa-handshake"></i> Partner network
        </span>
        <h1 class="mt-6 font-display text-4xl font-extrabold tracking-tight sm:text-5xl">Stronger together</h1>
        <p class="mx-auto mt-5 max-w-2xl text-lg leading-8 text-slate-300">
            We work with technology partners across the region to deliver, deploy and support Khybersoft for businesses everywhere.
        </p>
    </div>
</section>

<!-- Featured partner: Nozum Technologies -->
<section class="bg-white py-20">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">
        <div class="mx-auto max-w-2xl text-center" data-aos="fade-up">
            <p class="text-sm font-bold uppercase tracking-widest text-primary">Featured partner</p>
            <h2 class="mt-3 font-display text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">Our technology partner in Saudi Arabia</h2>
        </div>

        <div class="mx-auto mt-12 max-w-4xl overflow-hidden rounded-3xl border border-slate-100 bg-gradient-to-b from-slate-50 to-white shadow-soft" data-aos="fade-up">
            <div class="grid items-center gap-8 p-8 sm:p-10 md:grid-cols-5">
                <!-- Logo / brand mark -->
                <div class="flex justify-center md:col-span-2">
                    <div class="grid h-32 w-32 place-items-center rounded-3xl bg-gradient-to-br from-primary to-violet shadow-glow">
                        <span class="font-display text-5xl font-extrabold text-white">N</span>
                    </div>
                </div>
                <div class="text-center md:col-span-3 md:text-left">
                    <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700 ring-1 ring-inset ring-emerald-100">
                        <i class="fa-solid fa-location-dot"></i> Saudi Arabia
                    </span>
                    <h3 class="mt-3 font-display text-2xl font-extrabold text-slate-900">Nozum Technologies</h3>
                    <p class="mt-3 text-sm leading-7 text-slate-600">
                        Nozum Technologies is our regional technology partner based in Saudi Arabia. Together we deliver Khybersoft
                        deployments, customizations and on-ground support for businesses across the Kingdom and the wider Gulf region —
                        combining our platform with Nozum's local expertise and enterprise service capabilities.
                    </p>
                    <div class="mt-6 flex flex-wrap items-center justify-center gap-4 md:justify-start">
                        <a href="https://nozumtech.com" target="_blank" rel="noopener"
                           class="inline-flex items-center gap-2 rounded-2xl bg-gradient-to-r from-primary to-violet px-6 py-3 text-sm font-bold text-white shadow-soft transition hover:-translate-y-0.5 hover:shadow-glow">
                            Visit nozumtech.com <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                        </a>
                        <a href="<?= site_url_path('/contact') ?>" class="text-sm font-bold text-primary hover:underline">Become a partner →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why partner with us -->
<section class="bg-gradient-to-b from-slate-50 to-white py-20">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">
        <div class="mx-auto max-w-2xl text-center" data-aos="fade-up">
            <p class="text-sm font-bold uppercase tracking-widest text-accent">Partner program</p>
            <h2 class="mt-3 font-display text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">Why partner with Khybersoft</h2>
        </div>

        <div class="mt-12 grid gap-6 md:grid-cols-3">
            <?php
            $perks = [
                ['fa-solid fa-percent', 'Recurring revenue share', 'Earn ongoing commissions on every customer you bring — not just the first sale.'],
                ['fa-solid fa-screwdriver-wrench', 'Implementation ready', 'Full onboarding toolkit, migration scripts and deployment playbooks included.'],
                ['fa-solid fa-headset', 'Priority partner support', 'Direct line to our engineering team in English, Urdu and Arabic.'],
                ['fa-solid fa-certificate', 'Co-marketing', 'Joint case studies, event presence and featured listing on this page.'],
                ['fa-solid fa-layer-group', 'White-label options', 'Resell under your own brand with custom domains and theming.'],
                ['fa-solid fa-earth-asia', 'Regional exclusivity', 'Territory protection for certified partners in their home market.'],
            ];
            foreach ($perks as $pi => [$icon, $title, $desc]): ?>
                <div class="relative overflow-hidden rounded-3xl border border-slate-100 bg-white p-7 transition hover:-translate-y-1 hover:shadow-soft"
                     data-aos="fade-up" data-aos-delay="<?= ($pi % 3) * 100 ?>">
                    <div class="absolute -right-8 -top-8 h-24 w-24 rounded-full bg-gradient-to-br from-primary/10 to-violet/10 blur-2xl"></div>
                    <span class="relative grid h-12 w-12 place-items-center rounded-2xl bg-gradient-to-br from-primary to-violet text-lg text-white shadow-soft"><i class="<?= $icon ?>"></i></span>
                    <h3 class="relative mt-5 font-display text-lg font-bold text-slate-900"><?= esc($title) ?></h3>
                    <p class="relative mt-2 text-sm leading-6 text-slate-500"><?= esc($desc) ?></p>
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
        <h2 class="font-display text-3xl font-extrabold tracking-tight sm:text-4xl">Interested in partnering with us?</h2>
        <p class="mx-auto mt-4 max-w-xl text-lg text-primary-100">Tell us about your business and region — we usually reply within one business day.</p>
        <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
            <a href="<?= site_url_path('/contact?subject=Partnership') ?>" class="rounded-2xl bg-white px-8 py-4 text-base font-bold text-primary shadow-xl transition hover:-translate-y-0.5 hover:shadow-2xl">Apply to partner program</a>
            <?php if ($wa = preg_replace('/\D/', '', setting('whatsapp_number', ''))): ?>
                <a href="https://wa.me/<?= esc($wa) ?>?text=<?= rawurlencode('Hi! I am interested in the Khybersoft partner program.') ?>" target="_blank" rel="noopener"
                   class="inline-flex items-center gap-2 rounded-2xl bg-[#25D366] px-6 py-4 text-base font-bold text-white shadow-xl transition hover:-translate-y-0.5">
                    <i class="fa-brands fa-whatsapp text-lg"></i> Chat on WhatsApp
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>
