<?php
/** Product detail (conversion page). Vars: $product,$category,$plans,$features,$deepDiveTabs,$screenshots,$faqs,$tutorials,$testimonials,$related,$breadcrumbs */
$p = $product;
$featuresList = json_decode((string) ($p['top_features'] ?? '[]'), true) ?: [];
?>
<!-- Hero -->
<section class="relative overflow-hidden bg-navy pb-20 pt-24 text-white">
    <div class="pointer-events-none absolute inset-0" aria-hidden="true">
        <div class="absolute -top-24 left-1/4 h-96 w-96 rounded-full bg-primary/25 blur-[120px]"></div>
        <div class="absolute bottom-0 right-0 h-80 w-80 rounded-full bg-violet/20 blur-[110px]"></div>
    </div>
    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <nav class="mb-8 flex flex-wrap items-center gap-2 text-sm text-slate-400">
            <?php foreach (($breadcrumbs ?? []) as $bi => [$label, $url]): ?>
                <?php if ($bi > 0): ?><i class="fa-solid fa-chevron-right text-[10px]"></i><?php endif; ?>
                <?php if ($bi < count($breadcrumbs) - 1): ?>
                    <a href="<?= esc(site_url_path($url)) ?>" class="hover:text-white"><?= esc($label) ?></a>
                <?php else: ?>
                    <span class="text-white"><?= esc($label) ?></span>
                <?php endif; ?>
            <?php endforeach; ?>
        </nav>

        <div class="grid items-center gap-12 lg:grid-cols-2">
            <div>
                <?php if ($category): ?>
                    <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-4 py-1.5 text-xs font-semibold text-slate-300">
                        <i class="<?= esc($category['icon'] ?: 'fa-solid fa-layer-group') ?>"></i><?= esc($category['name']) ?>
                    </span>
                <?php endif; ?>
                <h1 class="mt-5 font-display text-4xl font-extrabold tracking-tight sm:text-5xl"><?= esc($p['name']) ?></h1>
                <p class="mt-4 max-w-xl text-lg leading-8 text-slate-300"><?= esc($p['tagline']) ?></p>

                <?php if ($featuresList): ?>
                    <ul class="mt-6 flex flex-wrap gap-2">
                        <?php foreach ($featuresList as $f): ?>
                            <li class="rounded-full bg-white/10 px-3.5 py-1.5 text-xs font-semibold text-slate-200 ring-1 ring-inset ring-white/15">
                                <i class="fa-solid fa-check mr-1 text-emerald-400"></i><?= esc($f) ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <div class="mt-8 flex flex-wrap items-center gap-4">
                    <a href="#lead-form" class="inline-flex items-center gap-2 rounded-2xl bg-gradient-to-r from-primary to-violet px-7 py-4 text-base font-bold text-white shadow-glow transition hover:-translate-y-0.5">
                        Start Free Trial <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    <?php if (! empty($p['demo_url'])): ?>
                        <a href="<?= esc($p['demo_url']) ?>" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-2xl border border-white/20 bg-white/5 px-6 py-4 text-base font-semibold text-white transition hover:bg-white/10">
                            <i class="fa-solid fa-play"></i> Live demo
                        </a>
                    <?php endif; ?>
                </div>

                <div class="mt-7 flex items-center gap-2 text-sm text-slate-400">
                    <span class="flex text-amber-400">
                        <?php for ($i = 0; $i < 5; $i++): ?><i class="fa-solid fa-star text-xs"></i><?php endfor; ?>
                    </span>
                    <strong class="text-white"><?= esc((string) ($p['rating_avg'] ?: '4.9')) ?></strong> · <?= (int) ($p['rating_count'] ?: 200) ?>+ reviews
                </div>
            </div>

            <div>
                <?php if (! empty($p['hero_image'])): ?>
                    <img src="<?= esc(media_url($p['hero_image'])) ?>" alt="<?= esc($p['name']) ?>" class="w-full rounded-3xl border border-white/10 shadow-2xl" loading="eager">
                <?php else: ?>
                    <div class="grid aspect-[4/3] place-items-center rounded-3xl border border-white/10 bg-white/[0.06] backdrop-blur">
                        <span class="grid h-24 w-24 place-items-center rounded-3xl bg-gradient-to-br <?= esc($p['color'] ?: 'from-indigo-500 to-violet-500') ?> text-5xl text-white shadow-glow">
                            <i class="<?= esc($p['icon'] ?: 'fa-solid fa-cube') ?>"></i>
                        </span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Feature grid -->
<?php if (! empty($features)): ?>
<section class="bg-white py-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h2 class="text-center font-display text-3xl font-extrabold text-slate-900">Everything included</h2>
        <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <?php foreach ($features as $f): ?>
                <div class="rounded-3xl border border-slate-100 bg-slate-50/60 p-6 transition hover:-translate-y-1 hover:shadow-soft">
                    <span class="grid h-11 w-11 place-items-center rounded-xl bg-gradient-to-br from-primary to-violet text-white"><i class="<?= esc($f['icon'] ?: 'fa-solid fa-star') ?>"></i></span>
                    <h3 class="mt-4 font-display text-base font-bold text-slate-900"><?= esc($f['name']) ?></h3>
                    <?php if (! empty($f['description'])): ?><p class="mt-1.5 text-sm leading-6 text-slate-500"><?= esc($f['description']) ?></p><?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Screenshots -->
<?php if (! empty($screenshots)): ?>
<section class="bg-slate-50 py-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h2 class="text-center font-display text-3xl font-extrabold text-slate-900">See it in action</h2>
        <div class="mt-12 grid gap-6 md:grid-cols-2">
            <?php foreach ($screenshots as $s): ?>
                <figure class="overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-sm">
                    <img src="<?= esc(media_url($s['image'])) ?>" alt="<?= esc($s['caption'] ?? $p['name']) ?>" loading="lazy" class="w-full object-cover">
                    <?php if (! empty($s['caption'])): ?><figcaption class="px-5 py-3 text-sm text-slate-500"><?= esc($s['caption']) ?></figcaption><?php endif; ?>
                </figure>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Pricing plans -->
<section class="bg-white py-20" id="pricing">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h2 class="text-center font-display text-3xl font-extrabold text-slate-900">Simple pricing</h2>
        <p class="mx-auto mt-3 max-w-xl text-center text-slate-500">Pick a plan that fits today — upgrade any time.</p>
        <div class="mt-12">
            <?= view('front/products/_plans', ['plans' => $plans, 'product' => $p]) ?>
        </div>
    </div>
</section>

<!-- FAQs -->
<?php if (! empty($faqs)): ?>
<section class="bg-slate-50 py-20">
    <div class="mx-auto max-w-3xl px-4 sm:px-6">
        <h2 class="text-center font-display text-3xl font-extrabold text-slate-900">Frequently asked questions</h2>
        <div class="mt-10 space-y-4" x-data="{ open: null }">
            <?php foreach ($faqs as $fi => $f): ?>
                <div class="rounded-2xl border border-slate-200 bg-white">
                    <button type="button" @click="open = open === <?= $fi ?> ? null : <?= $fi ?>"
                            class="flex w-full items-center justify-between gap-4 px-6 py-4 text-left text-sm font-bold text-slate-900">
                        <?= esc($f['question']) ?>
                        <i class="fa-solid fa-chevron-down text-xs text-slate-400 transition" :class="open === <?= $fi ?> && 'rotate-180'"></i>
                    </button>
                    <div x-show="open === <?= $fi ?>" x-cloak x-collapse class="px-6 pb-5 text-sm leading-7 text-slate-600">
                        <?= esc($f['answer']) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Testimonials -->
<?php if (! empty($testimonials)): ?>
<section class="bg-white py-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h2 class="text-center font-display text-3xl font-extrabold text-slate-900">Loved by teams like yours</h2>
        <div class="mt-12 grid gap-6 md:grid-cols-3">
            <?php foreach ($testimonials as $t): ?>
                <figure class="rounded-3xl border border-slate-100 bg-slate-50/60 p-7">
                    <div class="flex text-amber-400"><?= str_repeat('<i class="fa-solid fa-star text-sm"></i>', max(1, min(5, (int) $t['rating']))) ?></div>
                    <blockquote class="mt-4 text-sm leading-7 text-slate-600">“<?= esc($t['quote']) ?>”</blockquote>
                    <figcaption class="mt-5 border-t border-slate-200 pt-4">
                        <p class="text-sm font-bold text-slate-900"><?= esc($t['name']) ?></p>
                        <p class="text-xs text-slate-500"><?= esc(trim(($t['role'] ?? '') . ' ' . ($t['company'] ?? ''))) ?></p>
                    </figcaption>
                </figure>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Lead form -->
<section class="bg-navy py-20 text-white" id="lead-form">
    <div class="mx-auto max-w-2xl px-4 sm:px-6">
        <h2 class="text-center font-display text-3xl font-extrabold">Book a free demo</h2>
        <p class="mt-3 text-center text-slate-400">Tell us where to reach you — we'll set up a personalized walkthrough of <?= esc($p['name']) ?>.</p>

        <?php if ($msg = session()->getFlashdata('success')): ?>
            <div class="mt-6 rounded-xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-300"><?= esc($msg) ?></div>
        <?php endif; ?>
        <?php if ($msg = session()->getFlashdata('error')): ?>
            <div class="mt-6 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-300"><?= esc($msg) ?></div>
        <?php endif; ?>

        <form method="post" action="<?= site_url('products/lead') ?>" class="mt-8 space-y-4 rounded-3xl border border-white/10 bg-white/[0.06] p-7 backdrop-blur">
            <?= csrf_field() ?>
            <input type="hidden" name="product_id" value="<?= (int) $p['id'] ?>">
            <input type="hidden" name="lead_type" value="demo">
            <div class="grid gap-4 sm:grid-cols-2">
                <input name="name" required placeholder="Your name" value="<?= esc(old('name')) ?>"
                       class="rounded-xl border border-white/15 bg-white/10 px-4 py-3 text-sm text-white placeholder:text-slate-400 focus:border-primary focus:outline-none">
                <input name="company" placeholder="Company" value="<?= esc(old('company')) ?>"
                       class="rounded-xl border border-white/15 bg-white/10 px-4 py-3 text-sm text-white placeholder:text-slate-400 focus:border-primary focus:outline-none">
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                <input type="email" name="email" required placeholder="Work email" value="<?= esc(old('email')) ?>"
                       class="rounded-xl border border-white/15 bg-white/10 px-4 py-3 text-sm text-white placeholder:text-slate-400 focus:border-primary focus:outline-none">
                <input name="phone" placeholder="Phone / WhatsApp" value="<?= esc(old('phone')) ?>"
                       class="rounded-xl border border-white/15 bg-white/10 px-4 py-3 text-sm text-white placeholder:text-slate-400 focus:border-primary focus:outline-none">
            </div>
            <textarea name="message" rows="3" placeholder="What would you like to see in the demo?"
                      class="w-full rounded-xl border border-white/15 bg-white/10 px-4 py-3 text-sm text-white placeholder:text-slate-400 focus:border-primary focus:outline-none"><?= esc(old('message')) ?></textarea>
            <button class="w-full rounded-xl bg-gradient-to-r from-primary to-violet py-3.5 text-sm font-bold text-white shadow-glow transition hover:opacity-90">
                Request my demo
            </button>
        </form>
    </div>
</section>

<!-- Related products -->
<?php if (! empty($related)): ?>
<section class="bg-white py-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h2 class="font-display text-2xl font-extrabold text-slate-900">You may also like</h2>
        <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($related as $rp): echo view('front/products/_card', ['p' => $rp, 'listMode' => false]); endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
