<?php /* Documentation landing — navy hero + doc section cards */ ?>
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
            <i class="fa-solid fa-book"></i> Documentation
        </span>
        <h1 class="mt-6 font-display text-4xl font-extrabold tracking-tight sm:text-5xl">Khybersoft documentation</h1>
        <p class="mx-auto mt-5 max-w-2xl text-lg leading-8 text-slate-300">Everything you need to install, configure and get the most out of your products.</p>
    </div>
</section>

<!-- Doc sections -->
<section class="bg-white py-20">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <?php
            $sections = [
                ['fa-solid fa-rocket', 'Getting started', 'System requirements, installation, and your first 15 minutes with Khybersoft.', '/help'],
                ['fa-solid fa-cash-register', 'POS guide', 'Registers, receipts, barcode scanning, offline mode and end-of-day closing.', '/products/pos'],
                ['fa-solid fa-book-open', 'Accounting guide', 'Chart of accounts, journals, ledgers, taxes and financial reports.', '/products/books'],
                ['fa-solid fa-code', 'API reference', 'REST API endpoints, authentication, rate limits and code examples.', '/docs/api'],
                ['fa-solid fa-plug', 'Integrations', 'WhatsApp, payment gateways, and third-party connectors.', '/products'],
                ['fa-solid fa-shield-halved', 'Security & backups', 'User roles, audit logs, data export and backup strategy.', '/contact'],
            ];
            foreach ($sections as $si => [$icon, $title, $desc, $url]): ?>
                <a href="<?= site_url_path($url) ?>"
                   class="group rounded-3xl border border-slate-100 bg-gradient-to-b from-slate-50 to-white p-7 transition hover:-translate-y-1 hover:shadow-soft"
                   data-aos="fade-up" data-aos-delay="<?= ($si % 3) * 100 ?>">
                    <span class="grid h-12 w-12 place-items-center rounded-2xl bg-gradient-to-br from-primary to-violet text-lg text-white shadow-soft"><i class="<?= $icon ?>"></i></span>
                    <h2 class="mt-5 font-display text-lg font-bold text-slate-900 group-hover:text-primary"><?= esc($title) ?></h2>
                    <p class="mt-2 text-sm leading-6 text-slate-500"><?= esc($desc) ?></p>
                    <span class="mt-4 inline-flex items-center gap-1.5 text-sm font-bold text-primary">Read docs <i class="fa-solid fa-arrow-right text-xs transition group-hover:translate-x-1"></i></span>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Quick start strip -->
        <div class="mt-16 overflow-hidden rounded-3xl bg-navy text-white shadow-glow">
            <div class="grid items-center gap-8 p-8 sm:p-10 lg:grid-cols-2">
                <div>
                    <p class="text-sm font-bold uppercase tracking-widest text-emerald-400">Quick start</p>
                    <h2 class="mt-2 font-display text-2xl font-extrabold">Up and running in three steps</h2>
                    <ol class="mt-5 space-y-3 text-sm text-slate-300">
                        <li class="flex gap-3"><span class="grid h-6 w-6 shrink-0 place-items-center rounded-full bg-primary text-xs font-bold">1</span> Create your account and choose a plan</li>
                        <li class="flex gap-3"><span class="grid h-6 w-6 shrink-0 place-items-center rounded-full bg-primary text-xs font-bold">2</span> Import your products, customers and opening balances</li>
                        <li class="flex gap-3"><span class="grid h-6 w-6 shrink-0 place-items-center rounded-full bg-primary text-xs font-bold">3</span> Make your first sale — receipts go out automatically</li>
                    </ol>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/[0.06] p-5 font-mono text-sm backdrop-blur">
                    <p class="text-slate-400"># Example: create an invoice via API</p>
                    <p class="mt-3"><span class="text-emerald-400">POST</span> <span class="text-primary-300">/api/v1/invoices</span></p>
                    <pre class="mt-3 overflow-x-auto rounded-xl bg-black/30 p-4 text-xs leading-6 text-slate-300">{
  "customer": "Walk-in",
  "items": [
    { "sku": "KS-POS", "qty": 1 }
  ]
}</pre>
                    <a href="<?= site_url_path('/docs/api') ?>" class="mt-4 inline-flex items-center gap-2 font-sans text-sm font-bold text-primary-300 transition hover:text-white">Open API reference <i class="fa-solid fa-arrow-right text-xs"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>
