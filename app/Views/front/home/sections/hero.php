<?php /* Section 3 — Hero: 60/40, dark navy gradient mesh + grid pattern */ ?>
<section class="relative -mt-[76px] overflow-hidden bg-navy pt-[76px] text-white" id="hero">
    <!-- gradient mesh -->
    <div class="pointer-events-none absolute inset-0" aria-hidden="true">
        <div class="absolute -top-32 left-1/4 h-[500px] w-[500px] rounded-full bg-primary/30 blur-[130px]"></div>
        <div class="absolute right-0 top-20 h-[420px] w-[420px] rounded-full bg-violet/30 blur-[120px]"></div>
        <div class="absolute bottom-0 left-0 h-[300px] w-[380px] rounded-full bg-emerald-500/10 blur-[110px]"></div>
        <!-- subtle grid -->
        <div class="absolute inset-0 opacity-[0.07]"
             style="background-image:linear-gradient(to right,#fff 1px,transparent 1px),linear-gradient(to bottom,#fff 1px,transparent 1px);background-size:44px 44px;"></div>
    </div>

    <div class="relative mx-auto grid max-w-7xl grid-cols-1 items-center gap-14 px-5 pb-24 pt-28 lg:grid-cols-5 lg:gap-8 lg:px-8 lg:pb-32 lg:pt-36">

        <!-- LEFT 60% -->
        <div class="lg:col-span-3" data-aos="fade-up">
            <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-4 py-1.5 text-xs font-semibold tracking-wide text-indigo-100 backdrop-blur">
                <?= esc(setting('hero_eyebrow', '⚡ Trusted by 500+ businesses in Pakistan & beyond')) ?>
            </span>

            <h1 class="mt-6 font-display text-5xl font-extrabold leading-[1.05] tracking-tight sm:text-6xl xl:text-7xl">
                <?= esc(str_replace('Khybersoft', '', setting('hero_title', 'Run Your Entire Business on'))) ?>
                <span class="bg-gradient-to-r from-indigo-300 via-violet-300 to-emerald-300 bg-clip-text text-transparent">Khybersoft.</span>
            </h1>

            <p class="mt-6 max-w-xl text-lg leading-8 text-slate-300">
                <?= esc(setting('hero_subtitle', 'POS, Accounting, School Management, Plot Management, HRM — one unified platform.')) ?>
            </p>

            <div class="mt-9 flex flex-wrap items-center gap-4">
                <a href="<?= site_url_path('/pricing') ?>"
                   class="group inline-flex items-center gap-2 rounded-2xl bg-gradient-to-r from-primary to-violet px-7 py-4 text-base font-bold text-white shadow-glow transition hover:-translate-y-0.5">
                    <?= esc(setting('hero_cta_primary', 'Start Free Trial')) ?>
                    <i class="fa-solid fa-arrow-right transition group-hover:translate-x-1"></i>
                </a>
                <button type="button" onclick="ksOpenDemo('<?= esc(setting('hero_video_url')) ?>')"
                        class="inline-flex items-center gap-3 rounded-2xl border border-white/20 bg-white/5 px-6 py-4 text-base font-semibold text-white backdrop-blur transition hover:bg-white/10">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-accent/90 text-white">
                        <i class="fa-solid fa-play ml-0.5 text-xs"></i>
                    </span>
                    <?= esc(setting('hero_cta_secondary', 'Watch 2-min Demo')) ?>
                </button>
            </div>

            <p class="mt-5 text-sm font-medium text-slate-400"><?= esc(setting('hero_trust_micro', 'No credit card • 14-day trial • Free setup')) ?></p>

            <!-- star rating row -->
            <div class="mt-8 flex items-center gap-3">
                <div class="flex text-amber-400" aria-label="4.9 out of 5 stars">
                    <?php for ($i = 0; $i < 5; $i++): ?><i class="fa-solid fa-star text-sm"></i><?php endfor; ?>
                </div>
                <p class="text-sm text-slate-300"><strong class="text-white"><?= esc(setting('hero_rating_text', '4.9/5 from 200+ reviews')) ?></strong></p>
                <div class="ml-2 flex -space-x-2">
                    <?php foreach (['IM','SK','AU'] as $ini): ?>
                        <span class="flex h-8 w-8 items-center justify-center rounded-full border-2 border-navy bg-gradient-to-br from-indigo-400 to-violet-500 text-[10px] font-bold text-white"><?= $ini ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- RIGHT 40% — floating dashboard mockup -->
        <div class="relative mx-auto w-full max-w-md lg:col-span-2 lg:max-w-none" data-aos="fade-left" data-aos-delay="150">
            <div class="rounded-3xl border border-white/10 bg-white/[0.06] p-3 shadow-2xl backdrop-blur-xl">
                <!-- fake browser chrome -->
                <div class="flex items-center gap-2 px-3 pb-3 pt-1">
                    <span class="h-2.5 w-2.5 rounded-full bg-red-400/80"></span>
                    <span class="h-2.5 w-2.5 rounded-full bg-amber-400/80"></span>
                    <span class="h-2.5 w-2.5 rounded-full bg-emerald-400/80"></span>
                    <span class="ml-3 flex-1 rounded-md bg-white/10 px-3 py-1 text-[10px] text-slate-400">app.khybersoft.com/dashboard</span>
                </div>
                <div class="rounded-2xl bg-navy/80 p-5 ring-1 ring-white/10">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[11px] uppercase tracking-widest text-slate-400">Today's sales</p>
                            <p class="font-display text-2xl font-extrabold text-white">PKR 284,910</p>
                        </div>
                        <span class="rounded-full bg-emerald-500/15 px-3 py-1 text-xs font-bold text-emerald-400">▲ 18%</span>
                    </div>
                    <canvas id="hero-sparkline" height="110" class="mt-4 w-full" aria-hidden="true"></canvas>
                    <div class="mt-4 grid grid-cols-3 gap-3 text-center">
                        <?php foreach ([['Invoices','142'],['Items sold','1,208'],['Customers','87']] as [$l,$v]): ?>
                            <div class="rounded-xl bg-white/5 py-3">
                                <p class="text-[10px] text-slate-400"><?= $l ?></p>
                                <p class="text-sm font-bold text-white"><?= $v ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- floating invoice card -->
            <div class="absolute -left-10 top-16 hidden animate-floaty rounded-2xl border border-white/10 bg-white p-4 shadow-glow sm:block">
                <div class="flex items-center gap-3">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-100 text-primary"><i class="fa-solid fa-file-invoice-dollar"></i></span>
                    <div>
                        <p class="text-xs font-bold text-slate-900">Invoice #INV-2041</p>
                        <p class="text-[11px] text-emerald-600 font-semibold">Paid · PKR 45,000</p>
                    </div>
                </div>
            </div>

            <!-- floating sale notification -->
            <div class="absolute -right-6 top-44 hidden animate-floaty-slow rounded-2xl border border-white/10 bg-white p-4 shadow-glow md:block" style="animation-delay:1.2s">
                <div class="flex items-center gap-3">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-100 text-accent"><i class="fa-brands fa-whatsapp"></i></span>
                    <div>
                        <p class="text-xs font-bold text-slate-900">Receipt sent</p>
                        <p class="text-[11px] text-slate-500">via WhatsApp ✓✓</p>
                    </div>
                </div>
            </div>

            <!-- floating chart chip -->
            <div class="absolute -bottom-6 left-8 hidden animate-floaty rounded-2xl border border-white/10 bg-white p-4 shadow-glow sm:block" style="animation-delay:2.4s">
                <p class="text-[10px] font-semibold uppercase tracking-wider text-slate-400">Stock alerts</p>
                <p class="text-xs font-bold text-slate-900">3 items low · auto PO ready</p>
            </div>
        </div>
    </div>

    <!-- scroll indicator -->
    <a href="#trust-bar" class="absolute bottom-6 left-1/2 hidden -translate-x-1/2 flex-col items-center gap-2 text-slate-400 transition hover:text-white lg:flex" aria-label="Scroll down">
        <span class="text-[10px] uppercase tracking-widest">Scroll</span>
        <span class="flex h-9 w-5 items-start justify-center rounded-full border border-current p-1">
            <span class="h-2 w-1 animate-bounce rounded-full bg-current"></span>
        </span>
    </a>

    <!-- demo modal -->
    <div id="demo-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-navy/80 p-4 backdrop-blur-sm">
        <div class="relative aspect-video w-full max-w-3xl overflow-hidden rounded-3xl bg-black shadow-2xl">
            <iframe id="demo-frame" class="h-full w-full" src="" title="Product demo video" allow="autoplay; encrypted-media" allowfullscreen loading="lazy"></iframe>
            <button onclick="ksCloseDemo()" class="absolute -right-3 -top-3 flex h-9 w-9 items-center justify-center rounded-full bg-white text-slate-900 shadow-lg hover:scale-105" aria-label="Close video">✕</button>
        </div>
    </div>
</section>
