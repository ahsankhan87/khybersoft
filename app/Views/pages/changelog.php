<?php /* Changelog — navy hero + version timeline. Vars: $versions */ ?>
<!-- Hero -->
<section class="relative overflow-hidden bg-navy pb-20 pt-28 text-white">
    <div class="pointer-events-none absolute inset-0" aria-hidden="true">
        <div class="absolute -top-32 left-1/4 h-[420px] w-[420px] rounded-full bg-primary/30 blur-[120px]"></div>
        <div class="absolute inset-0 opacity-[0.06]"
             style="background-image:linear-gradient(to right,#fff 1px,transparent 1px),linear-gradient(to bottom,#fff 1px,transparent 1px);background-size:44px 44px;"></div>
    </div>
    <div class="relative mx-auto max-w-4xl px-5 text-center lg:px-8">
        <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-4 py-1.5 text-xs font-semibold tracking-wide text-primary-200 backdrop-blur">
            <i class="fa-solid fa-code-branch"></i> Changelog
        </span>
        <h1 class="mt-6 font-display text-4xl font-extrabold tracking-tight sm:text-5xl">What's new</h1>
        <p class="mx-auto mt-5 max-w-2xl text-lg leading-8 text-slate-300">New features, improvements and fixes in every Khybersoft release.</p>
    </div>
</section>

<section class="bg-gradient-to-b from-slate-50 to-white py-16">
    <div class="mx-auto max-w-3xl px-5 lg:px-8">
        <?php if (! empty($versions)): ?>
            <div class="relative space-y-8 before:absolute before:bottom-2 before:left-[15px] before:top-2 before:w-px before:bg-slate-200">
                <?php foreach ($versions as $vi => $v): ?>
                    <div class="relative pl-12" data-aos="fade-up" data-aos-delay="<?= min($vi, 5) * 80 ?>">
                        <span class="absolute left-0 top-1 grid h-8 w-8 place-items-center rounded-full bg-gradient-to-br from-primary to-violet text-xs font-bold text-white shadow-soft ring-4 ring-white">
                            <i class="fa-solid fa-tag"></i>
                        </span>
                        <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm transition hover:shadow-soft">
                            <div class="flex flex-wrap items-center gap-3">
                                <h2 class="font-display text-lg font-extrabold text-slate-900">v<?= esc($v['version']) ?></h2>
                                <?php if (! empty($v['is_latest'])): ?>
                                    <span class="rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-bold text-emerald-700">Latest</span>
                                <?php endif; ?>
                                <time class="ml-auto text-xs text-slate-400"><?= esc(date('M j, Y', strtotime((string) $v['release_date']))) ?></time>
                            </div>
                            <?php if (! empty($v['highlights'])): ?>
                                <ul class="mt-4 space-y-2">
                                    <?php foreach (preg_split('/\r?\n/', (string) $v['highlights']) as $line): if (trim($line) === '') continue; ?>
                                        <li class="flex items-start gap-2.5 text-sm text-slate-600">
                                            <i class="fa-solid fa-circle-check mt-1 text-xs text-accent"></i><?= esc(ltrim(trim($line), '-• ')) ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                            <?php if (! empty($v['breaking_changes'])): ?>
                                <div class="mt-4 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-xs text-amber-800">
                                    <strong><i class="fa-solid fa-triangle-exclamation mr-1"></i> Breaking changes:</strong> <?= esc($v['breaking_changes']) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="relative space-y-8 before:absolute before:bottom-2 before:left-[15px] before:top-2 before:w-px before:bg-slate-200">
                <?php
                $entries = [
                    ['3.0', true, 'Nov 2026', ['40% faster POS checkout and offline mode', 'WhatsApp receipts for every sale', 'New reports dashboard with live analytics', 'Multi-branch transfers in two clicks']],
                    ['2.4', false, 'Aug 2026', ['Dark-mode friendly print layouts', 'Barcode label printing', 'Urdu language pack improvements']],
                    ['2.3', false, 'May 2026', ['API access on Business plan', 'Automatic nightly backups', 'Low-stock WhatsApp alerts']],
                    ['2.0', false, 'Jan 2026', ['New unified platform: POS + Accounting + HR in one login', 'Mobile companion app', 'Role-based access per branch']],
                ];
                foreach ($entries as $vi => [$ver, $latest, $date, $notes]): ?>
                    <div class="relative pl-12" data-aos="fade-up" data-aos-delay="<?= min($vi, 5) * 80 ?>">
                        <span class="absolute left-0 top-1 grid h-8 w-8 place-items-center rounded-full bg-gradient-to-br from-primary to-violet text-xs font-bold text-white shadow-soft ring-4 ring-white">
                            <i class="fa-solid fa-tag"></i>
                        </span>
                        <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm transition hover:shadow-soft">
                            <div class="flex flex-wrap items-center gap-3">
                                <h2 class="font-display text-lg font-extrabold text-slate-900">v<?= esc($ver) ?></h2>
                                <?php if ($latest): ?><span class="rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-bold text-emerald-700">Latest</span><?php endif; ?>
                                <time class="ml-auto text-xs text-slate-400"><?= esc($date) ?></time>
                            </div>
                            <ul class="mt-4 space-y-2">
                                <?php foreach ($notes as $note): ?>
                                    <li class="flex items-start gap-2.5 text-sm text-slate-600">
                                        <i class="fa-solid fa-circle-check mt-1 text-xs text-accent"></i><?= esc($note) ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Subscribe CTA -->
        <div class="mt-12 overflow-hidden rounded-3xl bg-navy p-8 text-center text-white shadow-glow">
            <h2 class="font-display text-xl font-extrabold">Never miss a release</h2>
            <p class="mx-auto mt-2 max-w-sm text-sm text-slate-300">Get release notes in your inbox — one email per release, nothing else.</p>
            <form method="post" action="<?= site_url('subscribe') ?>" class="mx-auto mt-6 flex max-w-sm flex-col gap-3 sm:flex-row">
                <?= csrf_field() ?>
                <input type="hidden" name="form_started_at" value="<?= time() ?>">
                <input type="hidden" name="source" value="changelog">
                <label for="changelog-email" class="sr-only">Email address</label>
                <input id="changelog-email" name="email" type="email" required placeholder="you@company.com"
                       class="w-full min-w-0 rounded-xl border border-white/15 bg-white/10 px-4 py-3 text-sm text-white placeholder:text-slate-400 focus:border-primary focus:outline-none">
                <button class="shrink-0 rounded-xl bg-gradient-to-r from-primary to-violet px-6 py-3 text-sm font-bold text-white shadow-soft transition hover:-translate-y-0.5">Subscribe</button>
            </form>
        </div>
    </div>
</section>
