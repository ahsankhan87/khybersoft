<?php
/** Pricing plans table. Vars: $plans, $product */
$wa = setting('whatsapp_number', '');
if (! $plans): ?>
    <div class="rounded-3xl border border-dashed border-slate-300 p-10 text-center">
        <p class="font-semibold text-slate-700">Pricing tailored to your business.</p>
        <a href="<?= site_url('contact') ?>" class="mt-4 inline-flex rounded-xl bg-gradient-to-r from-primary to-violet px-6 py-3 font-bold text-white shadow-soft">Request pricing</a>
    </div>
<?php else: ?>
<div x-data="{ yearly: false }" class="mx-auto max-w-6xl">
    <div class="mb-10 flex items-center justify-center gap-4">
        <span class="text-sm font-semibold text-slate-500" :class="!yearly && 'text-slate-900'">Monthly</span>
        <button @click="yearly = !yearly" class="relative h-7 w-14 rounded-full transition" :class="yearly ? 'bg-emerald-500' : 'bg-slate-300'">
            <span class="absolute top-1 h-5 w-5 rounded-full bg-white shadow transition-all" :class="yearly ? 'left-8' : 'left-1'"></span>
        </button>
        <span class="text-sm font-semibold text-slate-500" :class="yearly && 'text-slate-900'">Yearly</span>
        <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700">Save 20%</span>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <?php foreach ($plans as $plan): ?>
        <div class="relative flex flex-col rounded-3xl <?= $plan['is_popular'] ? 'bg-navy text-white shadow-glow ring-2 ring-primary lg:-translate-y-3' : 'border border-slate-200 bg-white shadow-sm' ?>">
            <?php if ($plan['is_popular']): ?><span class="absolute -top-3 left-1/2 -translate-x-1/2 rounded-full bg-gradient-to-r from-primary to-violet px-4 py-1 text-xs font-extrabold uppercase tracking-wide text-white shadow">Most popular</span><?php endif; ?>
            <div class="p-8 pb-0">
                <h3 class="font-display text-lg font-extrabold"><?= esc($plan['name']) ?></h3>
                <p class="mt-1 text-sm <?= $plan['is_popular'] ? 'text-slate-300' : 'text-slate-500' ?>"><?= esc($plan['tagline'] ?: $plan['user_limit'] ?: '') ?></p>
                <div class="mt-6 flex items-end gap-1">
                    <?php if ($plan['price_monthly'] !== null || $plan['price_yearly'] !== null): ?>
                        <span class="text-4xl font-extrabold" x-text="yearly ? '<?= esc(number_format((float) ($plan['price_yearly'] ?? 0))) ?>' : '<?= esc(number_format((float) ($plan['price_monthly'] ?? 0))) ?>'"></span>
                        <span class="mb-1 text-sm <?= $plan['is_popular'] ? 'text-slate-400' : 'text-slate-500' ?>" x-text="yearly ? '<?= esc($plan['currency']) ?>/yr' : '<?= esc($plan['currency']) ?>/mo'"></span>
                    <?php else: ?>
                        <span class="text-4xl font-extrabold">Custom</span>
                    <?php endif; ?>
                </div>
                <?php if ((float) $plan['setup_fee'] > 0): ?><p class="mt-1 text-xs <?= $plan['is_popular'] ? 'text-slate-400' : 'text-slate-400' ?>">+ one-time setup <?= esc(number_format((float) $plan['setup_fee'])) ?> <?= esc($plan['currency']) ?></p><?php endif; ?>
                <?php if ((int) $plan['trial_days'] > 0): ?><p class="mt-2 text-xs font-semibold text-emerald-<?= $plan['is_popular'] ? '400' : '600' ?>"><i class="fa-solid fa-gift mr-1"></i><?= (int) $plan['trial_days'] ?>-day free trial</p><?php endif; ?>
            </div>
            <ul class="mt-6 flex-1 space-y-2.5 px-8">
                <?php foreach ($plan['feature_list'] as $f): ?>
                <li class="flex items-start gap-2 text-sm"><i class="fa-solid fa-check mt-0.5 text-emerald-<?= $plan['is_popular'] ? '400' : '500' ?>"></i><span><?= esc($f) ?></span></li>
                <?php endforeach; ?>
            </ul>
            <div class="space-y-3 p-8">
                <a href="<?= site_url('contact') ?>?product=<?= (int) $product['id'] ?>&plan=<?= (int) $plan['id'] ?>&intent=trial" class="block rounded-xl <?= $plan['is_popular'] ? 'bg-gradient-to-r from-primary to-violet text-white' : 'bg-slate-900 text-white hover:bg-slate-700' ?> py-3 text-center text-sm font-bold transition">Start trial</a>
                <?php if ($wa): ?><a target="_blank" rel="noopener" href="https://wa.me/<?= preg_replace('/\D/', '', $wa) ?>?text=<?= rawurlencode('I am interested in ' . $product['name'] . ' — ' . $plan['name'] . ' plan. Can you share details?') ?>" class="block rounded-xl <?= $plan['is_popular'] ? 'border border-white/30 text-white hover:bg-white/10' : 'border border-slate-300 text-slate-700 hover:border-emerald-500 hover:text-emerald-600' ?> py-3 text-center text-sm font-bold"><i class="fa-brands fa-whatsapp mr-1 text-emerald-<?= $plan['is_popular'] ? '300' : '500' ?>"></i>Ask on WhatsApp</a><?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Feature comparison -->
    <?php
    $allKeys = [];
    foreach ($plans as $pl) { foreach (array_keys($pl['comparison']) as $k) { $allKeys[$k] = true; } }
    if ($allKeys): ?>
    <div class="mt-14 overflow-x-auto rounded-3xl border border-slate-200 bg-white shadow-sm">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-6 py-4">Feature</th>
                    <?php foreach ($plans as $pl): ?><th class="px-6 py-4 <?= $pl['is_popular'] ? 'text-primary' : '' ?>"><?= esc($pl['name']) ?></th><?php endforeach; ?>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php foreach (array_keys($allKeys) as $key): ?>
                <tr>
                    <td class="px-6 py-3.5 font-semibold text-slate-700"><?= esc($key) ?></td>
                    <?php foreach ($plans as $pl): $v = $pl['comparison'][$key] ?? null; ?>
                    <td class="px-6 py-3.5">
                        <?php if ($v === null || $v === '' || $v === false): ?><i class="fa-solid fa-minus text-slate-300"></i>
                        <?php elseif ($v === true || $v === '✓' || strtolower((string) $v) === 'yes'): ?><i class="fa-solid fa-check text-emerald-500"></i>
                        <?php else: ?><span class="text-slate-600"><?= esc((string) $v) ?></span><?php endif; ?>
                    </td>
                    <?php endforeach; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>
