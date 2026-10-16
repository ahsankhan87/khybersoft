<?php /* Section 15 — Final CTA band */ ?>
<section class="relative overflow-hidden bg-gradient-to-br from-primary via-violet to-indigo-700 py-24 text-white" id="get-started">
    <div class="pointer-events-none absolute inset-0" aria-hidden="true">
        <div class="absolute -left-24 -top-24 h-80 w-80 rounded-full bg-white/10 blur-3xl"></div>
        <div class="absolute -bottom-24 right-0 h-80 w-80 rounded-full bg-emerald-400/15 blur-3xl"></div>
        <div class="absolute inset-0 opacity-[0.08]" style="background-image:radial-gradient(#fff 1px,transparent 1px);background-size:26px 26px;"></div>
    </div>

    <div class="relative mx-auto max-w-4xl px-5 text-center lg:px-8" data-aos="zoom-in">
        <h2 class="font-display text-4xl font-extrabold tracking-tight sm:text-5xl">
            <?= esc(setting('cta_heading', 'Ready to transform your business?')) ?>
        </h2>
        <p class="mx-auto mt-4 max-w-xl text-lg text-indigo-100"><?= esc(setting('cta_sub', 'Join 500+ growing businesses running on Khybersoft.')) ?></p>

        <div class="mt-9 flex flex-wrap items-center justify-center gap-4">
            <a href="<?= site_url_path('/pricing') ?>" class="rounded-2xl bg-white px-8 py-4 text-base font-bold text-primary shadow-xl transition hover:-translate-y-0.5 hover:shadow-2xl">
                <?= esc(setting('hero_cta_primary', 'Start Free Trial')) ?>
            </a>
            <a href="<?= site_url_path('/contact') ?>" class="rounded-2xl border-2 border-white/40 px-8 py-4 text-base font-bold text-white backdrop-blur transition hover:bg-white/10">
                Book Demo
            </a>
            <?php if ($wa = preg_replace('/\D/', '', setting('whatsapp_number', ''))): ?>
                <a href="https://wa.me/<?= esc($wa) ?>?text=<?= rawurlencode('Hi Khybersoft! I would like to talk about a plan for my business.') ?>"
                   target="_blank" rel="noopener"
                   class="inline-flex items-center gap-2 rounded-2xl bg-[#25D366] px-6 py-4 text-base font-bold text-white shadow-xl transition hover:-translate-y-0.5">
                    <i class="fa-brands fa-whatsapp text-lg"></i> Talk to sales on WhatsApp
                </a>
            <?php endif; ?>
        </div>

        <p class="mt-6 text-sm text-indigo-200">14-day free trial • No credit card • Cancel anytime</p>
    </div>
</section>
