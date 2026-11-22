<?php /* Contact page — matches homepage design system */ ?>
<!-- Hero -->
<section class="relative overflow-hidden bg-navy pb-20 pt-28 text-white">
    <div class="pointer-events-none absolute inset-0" aria-hidden="true">
        <div class="absolute -top-32 left-1/3 h-[420px] w-[420px] rounded-full bg-primary/30 blur-[120px]"></div>
        <div class="absolute bottom-0 right-0 h-[320px] w-[320px] rounded-full bg-violet/20 blur-[100px]"></div>
        <div class="absolute inset-0 opacity-[0.06]"
             style="background-image:linear-gradient(to right,#fff 1px,transparent 1px),linear-gradient(to bottom,#fff 1px,transparent 1px);background-size:44px 44px;"></div>
    </div>
    <div class="relative mx-auto max-w-4xl px-5 text-center lg:px-8">
        <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-4 py-1.5 text-xs font-semibold tracking-wide text-primary-200 backdrop-blur">
            <i class="fa-solid fa-paper-plane"></i> We reply within one business day
        </span>
        <h1 class="mt-6 font-display text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl">
            <?= esc(setting('contact_heading', "Let's talk about your business")) ?>
        </h1>
        <p class="mx-auto mt-5 max-w-2xl text-lg leading-8 text-slate-300">
            <?= esc(setting('contact_sub', 'Questions about products, pricing or a custom build — send us a message and a real human will get back to you.')) ?>
        </p>
    </div>
</section>

<!-- Contact grid -->
<section class="bg-white py-20">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">
        <div class="grid gap-12 lg:grid-cols-5">

            <!-- Info column -->
            <div class="lg:col-span-2">
                <h2 class="font-display text-2xl font-extrabold text-slate-900">Contact information</h2>
                <p class="mt-3 text-sm leading-7 text-slate-500">Reach us directly, or use the form — whichever is easier for you.</p>

                <div class="mt-8 space-y-4">
                    <?php if ($email = setting('company_email')): ?>
                        <a href="mailto:<?= esc($email) ?>" class="group flex items-center gap-4 rounded-2xl border border-slate-100 bg-slate-50/60 p-4 transition hover:-translate-y-0.5 hover:border-primary-200 hover:shadow-soft">
                            <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-gradient-to-br from-primary to-violet text-white shadow-soft"><i class="fa-solid fa-envelope"></i></span>
                            <span>
                                <span class="block text-xs font-semibold uppercase tracking-wider text-slate-400">Email</span>
                                <span class="block text-sm font-bold text-slate-900 group-hover:text-primary"><?= esc($email) ?></span>
                            </span>
                        </a>
                    <?php endif; ?>

                    <?php if ($wa = setting('whatsapp_number')): ?>
                        <a href="https://wa.me/<?= esc(preg_replace('/\D/', '', $wa)) ?>" target="_blank" rel="noopener"
                           class="group flex items-center gap-4 rounded-2xl border border-slate-100 bg-slate-50/60 p-4 transition hover:-translate-y-0.5 hover:border-emerald-200 hover:shadow-soft">
                            <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-[#25D366] text-white shadow-soft"><i class="fa-brands fa-whatsapp text-lg"></i></span>
                            <span>
                                <span class="block text-xs font-semibold uppercase tracking-wider text-slate-400">WhatsApp</span>
                                <span class="block text-sm font-bold text-slate-900 group-hover:text-emerald-600"><?= esc($wa) ?></span>
                            </span>
                        </a>
                    <?php endif; ?>

                    <div class="flex items-center gap-4 rounded-2xl border border-slate-100 bg-slate-50/60 p-4">
                        <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-gradient-to-br from-primary to-violet text-white shadow-soft"><i class="fa-solid fa-location-dot"></i></span>
                        <span>
                            <span class="block text-xs font-semibold uppercase tracking-wider text-slate-400">Office</span>
                            <span class="block text-sm font-bold text-slate-900"><?= esc(setting('company_address', setting('company_city', 'Peshawar') . ', Pakistan')) ?></span>
                        </span>
                    </div>

                    <div class="flex items-center gap-4 rounded-2xl border border-slate-100 bg-slate-50/60 p-4">
                        <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-gradient-to-br from-primary to-violet text-white shadow-soft"><i class="fa-solid fa-clock"></i></span>
                        <span>
                            <span class="block text-xs font-semibold uppercase tracking-wider text-slate-400">Hours</span>
                            <span class="block text-sm font-bold text-slate-900"><?= esc(setting('business_hours', 'Mon–Sat, 9:00 – 18:00 PKT')) ?></span>
                        </span>
                    </div>
                </div>

                <!-- socials -->
                <?php
                $socials = array_filter([
                    'facebook'  => setting('social_facebook'),
                    'twitter'   => setting('social_twitter'),
                    'linkedin'  => setting('social_linkedin'),
                    'youtube'   => setting('social_youtube'),
                    'instagram' => setting('social_instagram'),
                ]);
                if ($socials): ?>
                    <h3 class="mt-10 text-sm font-bold uppercase tracking-widest text-slate-400">Follow us</h3>
                    <div class="mt-4 flex gap-3">
                        <?php foreach ($socials as $net => $url): ?>
                            <a href="<?= esc($url) ?>" target="_blank" rel="noopener" aria-label="<?= ucfirst($net) ?>"
                               class="grid h-10 w-10 place-items-center rounded-full border border-slate-200 text-slate-500 transition hover:border-primary hover:bg-primary hover:text-white">
                                <i class="fa-brands fa-<?= $net ?>"></i>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Form column -->
            <div class="lg:col-span-3">
                <div class="rounded-3xl border border-slate-100 bg-white p-8 shadow-card">
                    <h2 class="font-display text-2xl font-extrabold text-slate-900">Send us a message</h2>

                    <?php if ($msg = session()->getFlashdata('success')): ?>
                        <div data-flash class="mt-5 flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-700">
                            <i class="fa-solid fa-circle-check mt-0.5"></i> <?= esc($msg) ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($msg = session()->getFlashdata('error')): ?>
                        <div data-flash class="mt-5 flex items-start gap-3 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-medium text-red-700">
                            <i class="fa-solid fa-circle-exclamation mt-0.5"></i> <?= esc($msg) ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($errs = session()->getFlashdata('errors')): ?>
                        <div data-flash class="mt-5 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                            <?php foreach ((array) $errs as $e): ?><p><?= esc($e) ?></p><?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="<?= site_url('contact/send') ?>" class="mt-7 space-y-5">
                        <?= csrf_field() ?>
                        <input type="hidden" name="form_started_at" value="<?= time() ?>">
                        <div style="position:absolute; left:-9999px; top:auto; width:1px; height:1px; overflow:hidden;" aria-hidden="true">
                            <label for="website">Website</label>
                            <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="name" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-500">Name</label>
                                <input type="text" name="name" id="name" required placeholder="Your name" value="<?= esc(old('name')) ?>"
                                       class="w-full rounded-xl border border-line bg-white px-4 py-3 text-sm text-ink shadow-sm transition placeholder:text-muted/60 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20">
                            </div>
                            <div>
                                <label for="email" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-500">Email</label>
                                <input type="email" name="email" id="email" required placeholder="you@company.com" value="<?= esc(old('email')) ?>"
                                       class="w-full rounded-xl border border-line bg-white px-4 py-3 text-sm text-ink shadow-sm transition placeholder:text-muted/60 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20">
                            </div>
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="phone" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-500">Phone <span class="font-normal normal-case text-slate-400">(optional)</span></label>
                                <input type="tel" name="phone" id="phone" placeholder="+92 3XX XXXXXXX" value="<?= esc(old('phone')) ?>"
                                       class="w-full rounded-xl border border-line bg-white px-4 py-3 text-sm text-ink shadow-sm transition placeholder:text-muted/60 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20">
                            </div>
                            <div>
                                <label for="subject" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-500">Subject</label>
                                <input type="text" name="subject" id="subject" placeholder="What's this about?" value="<?= esc(old('subject', $_GET['product'] ?? '')) ?>"
                                       class="w-full rounded-xl border border-line bg-white px-4 py-3 text-sm text-ink shadow-sm transition placeholder:text-muted/60 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20">
                            </div>
                        </div>

                        <div>
                            <label for="message" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-500">Message</label>
                            <textarea id="message" name="message" rows="5" required placeholder="Tell us how we can help…"
                                      class="w-full rounded-xl border border-line bg-white px-4 py-3 text-sm text-ink shadow-sm transition placeholder:text-muted/60 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"><?= esc(old('message')) ?></textarea>
                        </div>

                        <button type="submit"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-primary to-violet px-6 py-4 text-sm font-bold text-white shadow-soft transition hover:-translate-y-0.5 hover:shadow-glow sm:w-auto">
                            Send message <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map / location strip -->
<section class="bg-gradient-to-b from-slate-50 to-white py-20">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">
        <div class="relative overflow-hidden rounded-3xl bg-navy p-10 text-center text-white shadow-glow">
            <div class="pointer-events-none absolute inset-0 opacity-[0.07]" aria-hidden="true"
                 style="background-image:radial-gradient(#fff 1px,transparent 1px);background-size:24px 24px;"></div>
            <span class="relative mx-auto grid h-16 w-16 place-items-center rounded-2xl bg-gradient-to-br from-primary to-violet text-2xl shadow-soft">
                <i class="fa-solid fa-map-location-dot"></i>
            </span>
            <h2 class="relative mt-6 font-display text-2xl font-extrabold"><?= esc(setting('contact_map_heading', 'Visit our office')) ?></h2>
            <p class="relative mx-auto mt-3 max-w-md text-sm leading-7 text-slate-300">
                <?= esc(setting('company_address', setting('company_city', 'Peshawar') . ', Khyber Pakhtunkhwa, Pakistan')) ?>
            </p>
            <?php if ($mapUrl = setting('google_maps_url')): ?>
                <a href="<?= esc($mapUrl) ?>" target="_blank" rel="noopener"
                   class="relative mt-6 inline-flex items-center gap-2 rounded-2xl bg-white px-6 py-3 text-sm font-bold text-primary shadow-lg transition hover:-translate-y-0.5">
                    Open in Google Maps <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>
