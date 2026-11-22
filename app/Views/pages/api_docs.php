<?php /* API reference — navy hero + two-column docs layout */ ?>
<!-- Hero -->
<section class="relative overflow-hidden bg-navy pb-20 pt-28 text-white">
    <div class="pointer-events-none absolute inset-0" aria-hidden="true">
        <div class="absolute -top-32 left-1/4 h-[420px] w-[420px] rounded-full bg-primary/30 blur-[120px]"></div>
        <div class="absolute inset-0 opacity-[0.06]"
             style="background-image:linear-gradient(to right,#fff 1px,transparent 1px),linear-gradient(to bottom,#fff 1px,transparent 1px);background-size:44px 44px;"></div>
    </div>
    <div class="relative mx-auto max-w-4xl px-5 text-center lg:px-8">
        <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-4 py-1.5 text-xs font-semibold tracking-wide text-primary-200 backdrop-blur">
            <i class="fa-solid fa-code"></i> REST API v1
        </span>
        <h1 class="mt-6 font-display text-4xl font-extrabold tracking-tight sm:text-5xl">API reference</h1>
        <p class="mx-auto mt-5 max-w-2xl text-lg leading-8 text-slate-300">Connect Khybersoft with your own tools using our simple REST API.</p>
    </div>
</section>

<section class="bg-white py-16">
    <div class="mx-auto grid max-w-7xl gap-10 px-5 lg:grid-cols-4 lg:px-8">
        <!-- Sidebar nav -->
        <aside class="lg:col-span-1">
            <nav class="sticky top-24 space-y-1 rounded-2xl border border-slate-100 bg-slate-50/60 p-4 text-sm">
                <?php foreach (['auth' => 'Authentication', 'endpoints' => 'Endpoints', 'invoices' => 'Invoices', 'inventory' => 'Inventory', 'errors' => 'Errors & limits'] as $anchor => $label): ?>
                    <a href="#<?= $anchor ?>" class="block rounded-lg px-3 py-2 font-medium text-slate-600 transition hover:bg-white hover:text-primary hover:shadow-sm"><?= esc($label) ?></a>
                <?php endforeach; ?>
            </nav>
        </aside>

        <!-- Content -->
        <div class="space-y-12 lg:col-span-3">
            <section id="auth">
                <h2 class="font-display text-2xl font-extrabold text-slate-900">Authentication</h2>
                <p class="mt-3 text-sm leading-7 text-slate-600">All API requests use an API key sent as a bearer token. Generate keys in <strong class="text-slate-900">Settings → API</strong>.</p>
                <div class="mt-4 overflow-hidden rounded-2xl bg-navy text-sm shadow-soft">
                    <div class="flex items-center gap-2 border-b border-white/10 px-5 py-3">
                        <span class="h-2.5 w-2.5 rounded-full bg-red-400/80"></span><span class="h-2.5 w-2.5 rounded-full bg-amber-400/80"></span><span class="h-2.5 w-2.5 rounded-full bg-emerald-400/80"></span>
                        <span class="ml-3 text-xs text-slate-400">bash</span>
                    </div>
                    <pre class="overflow-x-auto p-5 font-mono text-xs leading-6 text-slate-200">curl <?= esc(rtrim((string) config('App')->baseURL, '/')) ?>/api/v1/invoices \
  -H "Authorization: Bearer ks_live_YOUR_KEY"</pre>
                </div>
            </section>

            <section id="endpoints">
                <h2 class="font-display text-2xl font-extrabold text-slate-900">Endpoints</h2>
                <div class="mt-4 divide-y divide-slate-100 overflow-hidden rounded-2xl border border-slate-100">
                    <?php
                    $endpoints = [
                        ['GET',  '/api/v1/products',  'List products', 'emerald'],
                        ['GET',  '/api/v1/customers', 'List customers', 'emerald'],
                        ['POST', '/api/v1/customers', 'Create a customer', 'blue'],
                    ];
                    foreach ($endpoints as [$method, $path, $desc, $color]): ?>
                        <div class="flex flex-wrap items-center gap-3 px-5 py-4">
                            <span class="rounded-lg bg-<?= $color ?>-100 px-2.5 py-1 font-mono text-xs font-bold text-<?= $color ?>-700"><?= $method ?></span>
                            <code class="font-mono text-sm text-slate-800"><?= esc($path) ?></code>
                            <span class="ml-auto text-sm text-slate-500"><?= esc($desc) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <section id="invoices">
                <h2 class="font-display text-2xl font-extrabold text-slate-900">Invoices</h2>
                <p class="mt-3 text-sm leading-7 text-slate-600">Create and fetch invoices programmatically.</p>
                <div class="mt-4 overflow-hidden rounded-2xl bg-navy text-sm shadow-soft">
                    <div class="flex items-center gap-2 border-b border-white/10 px-5 py-3">
                        <span class="ml-0 text-xs text-slate-400">POST /api/v1/invoices</span>
                    </div>
                    <pre class="overflow-x-auto p-5 font-mono text-xs leading-6 text-slate-200">{
  "customer_id": 1042,
  "items": [
    { "sku": "KS-POS", "qty": 1, "price": 4999 }
  ],
  "send_whatsapp": true
}</pre>
                </div>
                <div class="mt-4 overflow-hidden rounded-2xl border border-emerald-100 bg-emerald-50/60">
                    <p class="border-b border-emerald-100 px-5 py-2.5 text-xs font-bold uppercase tracking-wide text-emerald-700">Response · 201 Created</p>
                    <pre class="overflow-x-auto p-5 font-mono text-xs leading-6 text-slate-700">{
  "id": 2041,
  "number": "INV-2041",
  "total": 4999,
  "status": "paid"
}</pre>
                </div>
            </section>

            <section id="inventory">
                <h2 class="font-display text-2xl font-extrabold text-slate-900">Inventory</h2>
                <p class="mt-3 text-sm leading-7 text-slate-600">Check stock levels and receive low-stock webhooks.</p>
                <div class="mt-4 divide-y divide-slate-100 overflow-hidden rounded-2xl border border-slate-100">
                    <div class="flex flex-wrap items-center gap-3 px-5 py-4">
                        <span class="rounded-lg bg-emerald-100 px-2.5 py-1 font-mono text-xs font-bold text-emerald-700">GET</span>
                        <code class="font-mono text-sm text-slate-800">/api/v1/stock?branch=main</code>
                        <span class="ml-auto text-sm text-slate-500">Current stock by branch</span>
                    </div>
                    <div class="flex flex-wrap items-center gap-3 px-5 py-4">
                        <span class="rounded-lg bg-blue-100 px-2.5 py-1 font-mono text-xs font-bold text-blue-700">POST</span>
                        <code class="font-mono text-sm text-slate-800">/api/v1/webhooks</code>
                        <span class="ml-auto text-sm text-slate-500">Subscribe to low-stock alerts</span>
                    </div>
                </div>
            </section>

            <section id="errors">
                <h2 class="font-display text-2xl font-extrabold text-slate-900">Errors & rate limits</h2>
                <div class="mt-4 overflow-hidden rounded-2xl border border-slate-100">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                            <tr><th class="px-5 py-3">Code</th><th class="px-5 py-3">Meaning</th></tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php foreach ([['401', 'Missing or invalid API key'], ['403', 'Key lacks the required scope'], ['422', 'Validation failed — see errors object'], ['429', 'Rate limit exceeded (120 req/min)']] as [$code, $meaning]): ?>
                                <tr><td class="px-5 py-3 font-mono font-bold text-slate-800"><?= $code ?></td><td class="px-5 py-3 text-slate-600"><?= esc($meaning) ?></td></tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="mt-6 rounded-2xl border border-primary-100 bg-primary-50 p-5 text-sm leading-7 text-slate-600">
                    <i class="fa-solid fa-circle-info mr-2 text-primary"></i>Need an API key or a higher limit? <a href="<?= site_url_path('/contact') ?>" class="font-bold text-primary hover:underline">Contact us</a> — keys are issued on Business and Enterprise plans.
                </div>
            </section>
        </div>
    </div>
</section>
