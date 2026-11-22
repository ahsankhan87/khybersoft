<?php /* Pricing page — matches homepage design system */ ?>
<!-- Hero -->
<section class="relative overflow-hidden bg-navy pb-20 pt-28 text-white">
    <div class="pointer-events-none absolute inset-0" aria-hidden="true">
        <div class="absolute -top-32 left-1/4 h-[420px] w-[420px] rounded-full bg-primary/30 blur-[120px]"></div>
        <div class="absolute right-0 top-16 h-[360px] w-[360px] rounded-full bg-violet/25 blur-[110px]"></div>
        <div class="absolute inset-0 opacity-[0.06]"
             style="background-image:linear-gradient(to right,#fff 1px,transparent 1px),linear-gradient(to bottom,#fff 1px,transparent 1px);background-size:44px 44px;"></div>
    </div>
    <div class="relative mx-auto max-w-4xl px-5 text-center lg:px-8">
        <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-4 py-1.5 text-xs font-semibold tracking-wide text-primary-200 backdrop-blur">
            <i class="fa-solid fa-tag"></i> <?= esc(setting('pricing_eyebrow', 'Simple, transparent pricing')) ?>
        </span>
        <h1 class="mt-6 font-display text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl">
            <?= esc(setting('pricing_hero_heading', 'Simple pricing. No surprises.')) ?>
        </h1>
        <p class="mx-auto mt-5 max-w-2xl text-lg leading-8 text-slate-300">
            <?= esc(setting('pricing_hero_sub', 'One platform for POS, accounting and operations. Pick a plan that fits today — upgrade any time. 14-day free trial on every plan.')) ?>
        </p>
    </div>
</section>

<!-- Plans with monthly/yearly toggle -->
<section class="bg-white py-20" id="plans">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">
        <div x-data="{ yearly: true }">
            <!-- billing toggle -->
            <div class="flex flex-wrap items-center justify-center gap-3">
                <span class="text-sm font-semibold" :class="!yearly ? 'text-slate-900' : 'text-slate-400'">Monthly</span>
                <button type="button" @click="yearly = !yearly" role="switch" :aria-checked="yearly"
                        class="relative h-7 w-14 rounded-full transition-colors duration-300"
                        :class="yearly ? 'bg-gradient-to-r from-primary to-violet' : 'bg-slate-200'">
                    <span class="absolute top-1 h-5 w-5 rounded-full bg-white shadow transition-all duration-300"
                          :class="yearly ? 'left-8' : 'left-1'"></span>
                </button>
                <span class="text-sm font-semibold" :class="yearly ? 'text-slate-900' : 'text-slate-400'">Yearly</span>
                <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-bold text-emerald-700">Save 20%</span>
            </div>

            <div class="mt-14 grid gap-8 lg:grid-cols-3">
                <?php
                $plans = $plans ?? [
                    ['name' => 'Starter', 'monthly' => 4999, 'yearly' => 47988, 'tagline' => 'For single shops getting started',
                     'features' => ['1 branch, 3 registers', 'POS + Inventory', 'WhatsApp receipts', 'Email support', 'Free setup'], 'popular' => false],
                    ['name' => 'Business', 'monthly' => 9999, 'yearly' => 95988, 'tagline' => 'For growing multi-branch teams',
                     'features' => ['Up to 5 branches', 'All POS + Accounting modules', 'Advanced reports & analytics', 'Priority support (EN/Urdu)', 'Mobile app included', 'API access'], 'popular' => true],
                    ['name' => 'Enterprise', 'monthly' => null, 'yearly' => null, 'tagline' => 'Custom scale, SLA & on-prem options',
                     'features' => ['Unlimited branches', 'Dedicated success manager', 'Custom integrations', 'SSO & audit logs', '99.9% uptime SLA'], 'popular' => false],
                ];
                foreach ($plans as $pi => $plan): ?>
                    <div class="relative flex flex-col rounded-3xl border p-8 transition-all duration-300 hover:-translate-y-2 <?= $plan['popular'] ? 'border-transparent bg-navy text-white shadow-glow lg:scale-105' : 'border-slate-200 bg-white shadow-sm hover:shadow-soft' ?>"
                         data-aos="fade-up" data-aos-delay="<?= $pi * 120 ?>">
                        <?php if ($plan['popular']): ?>
                            <span class="absolute -top-3.5 left-1/2 -translate-x-1/2 rounded-full bg-gradient-to-r from-primary to-violet px-4 py-1.5 text-xs font-bold text-white shadow">Most popular</span>
                        <?php endif; ?>

                        <h3 class="font-display text-lg font-bold <?= $plan['popular'] ? 'text-white' : 'text-slate-900' ?>"><?= esc($plan['name']) ?></h3>
                        <p class="mt-1 text-sm <?= $plan['popular'] ? 'text-slate-300' : 'text-slate-500' ?>"><?= esc($plan['tagline']) ?></p>

                        <?php if ($plan['monthly'] !== null): ?>
                            <p class="mt-6 font-display text-4xl font-extrabold">
                                <span x-show="!yearly">PKR <?= number_format($plan['monthly']) ?></span>
                                <span x-show="yearly" x-cloak>PKR <?= number_format(round($plan['yearly'] / 12)) ?></span>
                                <span class="text-sm font-semibold <?= $plan['popular'] ? 'text-slate-400' : 'text-slate-400' ?>">/mo</span>
                            </p>
                            <p class="mt-1 text-xs text-slate-400" x-show="yearly" x-cloak>billed annually · 2 months free</p>
                        <?php else: ?>
                            <p class="mt-6 font-display text-4xl font-extrabold">Custom</p>
                            <p class="mt-1 text-xs text-slate-400">tailored quote in 24 hours</p>
                        <?php endif; ?>

                        <ul class="mt-7 flex-1 space-y-3">
                            <?php foreach ($plan['features'] as $f): ?>
                                <li class="flex items-start gap-2.5 text-sm">
                                    <i class="fa-solid fa-circle-check mt-0.5 <?= $plan['popular'] ? 'text-emerald-400' : 'text-accent' ?>"></i>
                                    <span class="<?= $plan['popular'] ? 'text-slate-200' : 'text-slate-600' ?>"><?= esc($f) ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>

                        <a href="<?= site_url_path('/contact?plan=' . strtolower($plan['name'])) ?>"
                           class="mt-8 block rounded-2xl bg-gradient-to-r from-primary to-violet py-3.5 text-center text-sm font-bold text-white shadow-soft transition hover:-translate-y-0.5 hover:shadow-glow">
                            <?= $plan['monthly'] !== null ? 'Start Free Trial' : 'Talk to Sales' ?>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- comparison strip -->
        <div class="mt-14 grid gap-4 rounded-3xl border border-slate-100 bg-slate-50/60 p-8 text-center sm:grid-cols-3">
            <?php foreach ([
                ['fa-solid fa-rocket', 'Free setup & migration', 'We move your data and configure everything'],
                ['fa-solid fa-rotate-left', 'Cancel anytime', 'No lock-in, no cancellation fees'],
                ['fa-solid fa-headset', 'Support in EN & Urdu', 'Real humans, based in Peshawar'],
            ] as [$icon, $h, $sub]): ?>
                <div class="flex flex-col items-center gap-2 p-4">
                    <span class="grid h-12 w-12 place-items-center rounded-2xl bg-gradient-to-br from-primary to-violet text-lg text-white shadow-soft"><i class="<?= $icon ?>"></i></span>
                    <p class="font-display text-sm font-bold text-slate-900"><?= esc($h) ?></p>
                    <p class="text-xs text-slate-500"><?= esc($sub) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="bg-gradient-to-b from-slate-50 to-white py-24">
    <div class="mx-auto max-w-3xl px-5 lg:px-8">
        <div class="text-center">
            <p class="text-sm font-bold uppercase tracking-widest text-primary">FAQ</p>
            <h2 class="mt-3 font-display text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">Questions, answered</h2>
        </div>
        <div class="mt-12 space-y-4" x-data="{ open: 0 }">
            <?php
            $faqs = [
                ['Can I change plans anytime?', 'Yes. Upgrade or downgrade from your dashboard — changes apply immediately and we pro-rate the difference.'],
                ['Is there a free trial?', 'Every plan includes a 14-day free trial with full features. No credit card required to start.'],
                ['What payment methods do you accept?', 'All major debit/credit cards, bank transfer, and JazzCash / EasyPaisa for customers in Pakistan.'],
                ['Do you offer discounts for startups or schools?', 'Yes — startups, schools and non-profits get special pricing. Talk to our sales team for details.'],
                ['What happens when my trial ends?', 'Your data stays safe. Pick a plan to continue, or export everything first — no pressure.'],
            ];
            foreach ($faqs as $fi => [$q, $a]): ?>
                <div class="rounded-2xl border border-slate-200 bg-white transition hover:border-primary-200">
                    <button type="button" @click="open = open === <?= $fi ?> ? null : <?= $fi ?>"
                            class="flex w-full items-center justify-between gap-4 px-6 py-4 text-left text-sm font-bold text-slate-900">
                        <?= esc($q) ?>
                        <i class="fa-solid fa-chevron-down text-xs text-slate-400 transition" :class="open === <?= $fi ?> && 'rotate-180'"></i>
                    </button>
                    <div x-show="open === <?= $fi ?>" x-cloak x-collapse class="px-6 pb-5 text-sm leading-7 text-slate-600">
                        <?= esc($a) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Final CTA -->
<section class="relative overflow-hidden bg-gradient-to-br from-primary via-violet to-primary-700 py-20 text-white">
    <div class="pointer-events-none absolute inset-0 opacity-[0.08]" aria-hidden="true"
         style="background-image:radial-gradient(#fff 1px,transparent 1px);background-size:26px 26px;"></div>
    <div class="relative mx-auto max-w-3xl px-5 text-center lg:px-8">
        <h2 class="font-display text-3xl font-extrabold tracking-tight sm:text-4xl">Still not sure which plan fits?</h2>
        <p class="mx-auto mt-4 max-w-xl text-lg text-primary-100">Book a free 15-minute consultation — we'll map your workflow to the right setup.</p>
        <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
            <a href="<?= site_url_path('/contact') ?>" class="rounded-2xl bg-white px-8 py-4 text-base font-bold text-primary shadow-xl transition hover:-translate-y-0.5 hover:shadow-2xl">Book a free consultation</a>
            <?php if ($wa = preg_replace('/\D/', '', setting('whatsapp_number', ''))): ?>
                <a href="https://wa.me/<?= esc($wa) ?>?text=<?= rawurlencode('Hi! I need help choosing a plan.') ?>" target="_blank" rel="noopener"
                   class="inline-flex items-center gap-2 rounded-2xl bg-[#25D366] px-6 py-4 text-base font-bold text-white shadow-xl transition hover:-translate-y-0.5">
                    <i class="fa-brands fa-whatsapp text-lg"></i> Ask on WhatsApp
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>
