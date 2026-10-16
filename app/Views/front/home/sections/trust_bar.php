<?php /* Section 4 — Trust bar + client logo marquee (grayscale → color on hover) */ ?>
<section id="trust-bar" class="border-b border-slate-100 bg-white py-14">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">
        <p class="text-center text-sm font-bold uppercase tracking-[0.2em] text-slate-400" data-aos="fade-up">
            <?= esc(setting('trust_bar_title', 'Trusted by 500+ businesses')) ?>
        </p>

        <?php if (! empty($clients)): ?>
        <div class="relative mt-8 overflow-hidden" data-aos="fade-up" data-aos-delay="100"
             style="-webkit-mask-image:linear-gradient(to right,transparent,#000 12%,#000 88%,transparent);mask-image:linear-gradient(to right,transparent,#000 12%,#000 88%,transparent)">
            <div class="flex w-max animate-marquee items-center gap-12 hover:[animation-play-state:paused]"
                 x-data="{}">
                <?php foreach ([...$clients, ...$clients] as $c): /* duplicated for seamless loop */ ?>
                    <div class="group flex h-12 shrink-0 items-center">
                        <?php if ($c['logo']): ?>
                            <img src="<?= esc(media_url($c['logo'])) ?>" alt="<?= esc($c['company_name']) ?>"
                                 loading="lazy" width="140" height="48"
                                 class="h-9 w-auto grayscale transition duration-300 group-hover:grayscale-0">
                        <?php else: ?>
                            <span class="whitespace-nowrap font-display text-lg font-bold text-slate-400 opacity-70 transition duration-300 group-hover:text-primary group-hover:opacity-100">
                                <?= esc($c['company_name']) ?>
                            </span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>
