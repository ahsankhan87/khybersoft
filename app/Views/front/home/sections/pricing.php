<?php /* Section 11 — Pricing preview with monthly/yearly toggle (-20%) */ ?>
<?php if (! empty($plans)): ?>
<section class="bg-white py-24" id="pricing">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">
        <div class="mx-auto max-w-2xl text-center" data-aos="fade-up">
            <p class="text-sm font-bold uppercase tracking-widest text-accent">Pricing</p>
            <h2 class="mt-3 font-display text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">
                <?= esc(setting('pricing_heading', 'Simple pricing. No surprises.')) ?>
            </h2>
        </div>

        <div x-data="{ yearly: false }" class="mt-10">
            <!-- billing toggle -->
            <div class="flex items-center justify-center gap-3">
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

            <div class="mt-12 grid gap-8 lg:grid-cols-3">
                <?php foreach ($plans as $pi => $plan): ?>
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
                            <p class="mt-1 text-xs <?= $plan['popular'] ? 'text-slate-400' : 'text-slate-400' ?>" x-show="yearly" x-cloak>billed annually · 2 months free</p>
                        <?php else: ?>
                            <p class="mt-6 font-display text-4xl font-extrabold">Custom</p>
                            <p class="mt-1 text-xs <?= $plan['popular'] ? 'text-slate-400' : 'text-slate-400' ?>">tailored quote in 24 hours</p>
                        <?php endif; ?>

                        <ul class="mt-7 flex-1 space-y-3">
                            <?php foreach ($plan['features'] as $f): ?>
                                <li class="flex items-start gap-2.5 text-sm">
                                    <i class="fa-solid fa-circle-check mt-0.5 <?= $plan['popular'] ? 'text-emerald-400' : 'text-accent' ?>"></i>
                                    <span class="<?= $plan['popular'] ? 'text-slate-200' : 'text-slate-600' ?>"><?= esc($f) ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>

                        <a href="<?= site_url_path('/pricing#' . strtolower($plan['name'])) ?>"
                           class="mt-8 block rounded-2xl py-3.5 text-center text-sm font-bold transition hover:-translate-y-0.5
                                  <?= $plan['popular'] ? 'bg-gradient-to-r from-primary to-violet text-white shadow-soft hover:shadow-glow' : 'bg-gradient-to-r from-primary to-violet text-white shadow-soft hover:shadow-glow' ?>">
                            <?= $plan['monthly'] !== null ? 'Start Free Trial' : 'Talk to Sales' ?>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <p class="mt-12 text-center">
            <a href="<?= site_url_path('/pricing') ?>" class="text-sm font-bold text-primary hover:underline">See full pricing & all products →</a>
        </p>
    </div>
</section>
<?php endif; ?>
