<?php /* Section 16 — Comprehensive footer */ ?>
<footer class="bg-navy text-slate-300" id="footer">
    <div class="mx-auto max-w-7xl px-5 py-16 lg:px-8">
        <div class="grid gap-12 lg:grid-cols-12">

            <!-- Brand + newsletter -->
            <div class="lg:col-span-4">
                <a href="<?= base_url('/') ?>" class="flex items-center gap-2">
                    <?php if ($logo = setting('logo_light')): ?>
                        <img src="<?= esc(media_url($logo)) ?>" alt="<?= esc(setting('site_name', 'Khybersoft')) ?>" class="h-9 w-auto" loading="lazy">
                    <?php else: ?>
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-primary to-violet font-display text-lg font-extrabold text-white">K</span>
                        <span class="font-display text-xl font-extrabold text-white"><?= esc(setting('site_name', 'Khybersoft')) ?></span>
                    <?php endif; ?>
                </a>
                <p class="mt-4 max-w-sm text-sm leading-6 text-slate-400"><?= esc(setting('footer_tagline', 'Business software that just works. Made with ❤️ in Pakistan.')) ?></p>

                <!-- social icons -->
                <div class="mt-6 flex gap-3">
                    <?php foreach ([
                        'facebook' => setting('social_facebook'), 'twitter' => setting('social_twitter'),
                        'linkedin' => setting('social_linkedin'), 'youtube'  => setting('social_youtube'),
                        'instagram'=> setting('social_instagram'),
                    ] as $net => $url): if (! $url) continue; ?>
                        <a href="<?= esc($url) ?>" target="_blank" rel="noopener" aria-label="<?= ucfirst($net) ?>"
                           class="flex h-10 w-10 items-center justify-center rounded-full bg-white/5 text-slate-300 transition hover:bg-gradient-to-br hover:from-primary hover:to-violet hover:text-white">
                            <i class="fa-brands fa-<?= $net ?>"></i>
                        </a>
                    <?php endforeach; ?>
                </div>

                <!-- inline newsletter -->
                <form action="<?= site_url('subscribe') ?>" method="post" class="mt-7">
                    <?= csrf_field() ?>
                    <input type="hidden" name="source" value="footer">
                    <label for="footer-email" class="text-xs font-bold uppercase tracking-wider text-slate-400">Product updates, monthly. No spam.</label>
                    <div class="mt-2 flex overflow-hidden rounded-2xl border border-white/10 bg-white/5 focus-within:border-indigo-400">
                        <input id="footer-email" type="email" name="email" required placeholder="you@company.com" autocomplete="email"
                               class="w-full bg-transparent px-4 py-3 text-sm text-white placeholder-slate-500 outline-none">
                        <button type="submit" class="shrink-0 bg-gradient-to-r from-primary to-violet px-5 text-sm font-bold text-white transition hover:opacity-90">Subscribe</button>
                    </div>
                </form>
            </div>

            <!-- Link columns -->
            <?php
            $cols = [
                'Products' => array_map(fn ($p) => ['label' => $p['name'], 'url' => '/products/' . $p['slug']],
                    model(\App\Models\ProductModel::class)->topFeatured(6)),
                'Company' => [
                    ['label' => 'About us', 'url' => '/about'], ['label' => 'Careers', 'url' => '/careers'],
                    ['label' => 'Blog', 'url' => '/blogs'], ['label' => 'Contact', 'url' => '/contact'],
                    ['label' => 'Partners', 'url' => '/partners'],
                ],
                'Resources' => [
                    ['label' => 'Help Center', 'url' => '/help'], ['label' => 'Video tutorials', 'url' => '/tutorials'],
                    ['label' => 'Documentation', 'url' => '/docs'], ['label' => 'API reference', 'url' => '/docs/api'],
                    ['label' => 'System status', 'url' => '/status'], ['label' => 'Changelog', 'url' => '/changelog'],
                ],
                'Legal' => [
                    ['label' => 'Privacy policy', 'url' => '/privacy-policy'], ['label' => 'Terms of service', 'url' => '/terms-of-use'],
                    ['label' => 'Refund policy', 'url' => '/refund-policy'], ['label' => 'GDPR', 'url' => '/privacy-policy'],
                    ['label' => 'Cookies', 'url' => '/privacy-policy'],
                ],
            ];
            foreach ($cols as $heading => $links): ?>
                <div class="lg:col-span-2">
                    <h3 class="font-display text-sm font-bold uppercase tracking-wider text-white"><?= $heading ?></h3>
                    <ul class="mt-4 space-y-2.5">
                        <?php foreach ($links as $l): ?>
                            <li><a href="<?= esc(site_url_path($l['url'])) ?>" class="text-sm text-slate-400 transition hover:text-white"><?= esc($l['label']) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- bottom bar -->
        <div class="mt-14 flex flex-col items-center justify-between gap-5 border-t border-white/10 pt-8 md:flex-row">
            <p class="text-xs text-slate-500">© <?= date('Y') ?> <?= esc(setting('site_name', 'Khybersoft')) ?> • Made in Pakistan 🇵🇰</p>
            <div class="flex items-center gap-4 text-2xl text-slate-500" aria-label="Accepted payment methods">
                <i class="fa-brands fa-cc-visa transition hover:text-white" title="Visa"></i>
                <i class="fa-brands fa-cc-mastercard transition hover:text-white" title="Mastercard"></i>
                <i class="fa-brands fa-stripe transition hover:text-white" title="Stripe"></i>
                <i class="fa-brands fa-cc-paypal transition hover:text-white" title="PayPal"></i>
            </div>
        </div>
    </div>
</footer>
