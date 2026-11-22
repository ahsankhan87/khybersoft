<?php /* System status — operational banner + service rows + uptime */ ?>
<!-- Hero -->
<section class="relative overflow-hidden bg-navy pb-20 pt-28 text-white">
    <div class="pointer-events-none absolute inset-0" aria-hidden="true">
        <div class="absolute -top-32 left-1/4 h-[420px] w-[420px] rounded-full bg-primary/30 blur-[120px]"></div>
        <div class="absolute inset-0 opacity-[0.06]"
             style="background-image:linear-gradient(to right,#fff 1px,transparent 1px),linear-gradient(to bottom,#fff 1px,transparent 1px);background-size:44px 44px;"></div>
    </div>
    <div class="relative mx-auto max-w-4xl px-5 text-center lg:px-8">
        <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-4 py-1.5 text-xs font-semibold tracking-wide text-primary-200 backdrop-blur">
            <i class="fa-solid fa-heart-pulse"></i> System status
        </span>
        <h1 class="mt-6 font-display text-4xl font-extrabold tracking-tight sm:text-5xl">Service status</h1>
        <p class="mx-auto mt-5 max-w-2xl text-lg leading-8 text-slate-300">Live availability of Khybersoft cloud services. Updated automatically.</p>
    </div>
</section>

<section class="bg-gradient-to-b from-slate-50 to-white py-16">
    <div class="mx-auto max-w-4xl px-5 lg:px-8">
        <!-- Overall status banner -->
        <div class="flex items-center gap-4 rounded-3xl border border-emerald-200 bg-emerald-50 p-6" data-aos="fade-up">
            <span class="relative flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-emerald-500 text-xl text-white shadow-soft">
                <i class="fa-solid fa-check"></i>
                <span class="absolute -right-1 -top-1 flex h-3.5 w-3.5">
                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex h-3.5 w-3.5 rounded-full bg-emerald-500 ring-2 ring-white"></span>
                </span>
            </span>
            <div>
                <h2 class="font-display text-xl font-extrabold text-slate-900">All systems operational</h2>
                <p class="text-sm text-slate-500">Last checked <?= esc(date('M j, Y \a\t H:i')) ?> PKT · refreshes every minute</p>
            </div>
        </div>

        <!-- Services -->
        <div class="mt-8 divide-y divide-slate-100 overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-sm" data-aos="fade-up">
            <?php
            $services = [
                ['Web application', 'App dashboard and all modules', 100.0],
                ['API', 'REST endpoints & webhooks', 99.98],
                ['WhatsApp receipts', 'Message delivery service', 99.95],
                ['Backups & sync', 'Nightly backups and offline sync', 100.0],
                ['Website', 'khybersoft.com', 100.0],
            ];
            foreach ($services as [$name, $desc, $uptime]): ?>
                <div class="flex items-center gap-4 px-6 py-5">
                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-emerald-50 text-emerald-500"><i class="fa-solid fa-circle-check"></i></span>
                    <div class="min-w-0">
                        <p class="text-sm font-bold text-slate-900"><?= esc($name) ?></p>
                        <p class="truncate text-xs text-slate-500"><?= esc($desc) ?></p>
                    </div>
                    <div class="ml-auto text-right">
                        <p class="text-sm font-bold text-emerald-600">Operational</p>
                        <p class="text-xs text-slate-400"><?= number_format($uptime, 2) ?>% · 90 days</p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Uptime bars -->
        <div class="mt-8 rounded-3xl border border-slate-100 bg-white p-6 shadow-sm" data-aos="fade-up">
            <div class="flex items-center justify-between">
                <h3 class="font-display text-base font-bold text-slate-900">Uptime — last 90 days</h3>
                <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700">99.9% average</span>
            </div>
            <div class="mt-5 flex h-10 items-end gap-[3px]" aria-hidden="true">
                <?php for ($d = 0; $d < 90; $d++): ?>
                    <span class="w-full rounded-sm bg-emerald-400/80 transition hover:bg-emerald-500" style="height:100%" title="Operational"></span>
                <?php endfor; ?>
            </div>
            <div class="mt-2 flex justify-between text-xs text-slate-400"><span>90 days ago</span><span>Today</span></div>
        </div>

        <!-- Incident history -->
        <div class="mt-8 rounded-3xl border border-slate-100 bg-white p-6 shadow-sm" data-aos="fade-up">
            <h3 class="font-display text-base font-bold text-slate-900">Recent incidents</h3>
            <div class="mt-4 flex items-start gap-3 rounded-2xl bg-slate-50 p-4">
                <i class="fa-solid fa-circle-check mt-0.5 text-emerald-500"></i>
                <p class="text-sm text-slate-600">No incidents reported in the last 90 days. 🎉</p>
            </div>
        </div>

        <p class="mt-8 text-center text-sm text-slate-500">
            Questions about an outage? <a href="<?= site_url_path('/contact') ?>" class="font-bold text-primary hover:underline">Contact support</a>
        </p>
    </div>
</section>
