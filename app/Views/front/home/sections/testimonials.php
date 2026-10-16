<?php /* Section 10 — Testimonials carousel: 1 large + 2 small peek, auto-rotate, pause on hover */ ?>
<?php if (! empty($testimonials)): $n = count($testimonials); ?>
<section class="bg-gradient-to-b from-white to-indigo-50/40 py-24" id="testimonials">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">
        <div class="mx-auto max-w-2xl text-center" data-aos="fade-up">
            <p class="text-sm font-bold uppercase tracking-widest text-primary">Testimonials</p>
            <h2 class="mt-3 font-display text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">
                <?= esc(setting('testimonials_heading', 'Loved by owners, accountants & managers')) ?>
            </h2>
        </div>

        <div class="relative mt-14" data-aos="fade-up" data-aos-delay="100"
             x-data="ksCarousel(<?= $n ?>, 6000)"
             @mouseenter="pause()" @mouseleave="resume()">

            <!-- sliding track -->
            <div class="overflow-hidden">
                <div class="flex transition-transform duration-700 ease-out" :style="`transform: translateX(-${index * (100 / perView)}%)`">
                    <?php foreach ($testimonials as $i => $t): ?>
                        <div class="w-full shrink-0 px-3 md:w-1/3">
                            <figure class="flex h-full flex-col rounded-3xl border border-slate-100 bg-white p-8 shadow-sm transition-all duration-500"
                                    :class="index === <?= $i ?> ? 'scale-[1.03] shadow-glow ring-1 ring-indigo-100' : 'md:opacity-60 md:scale-[0.96]'">
                                <div class="flex text-amber-400">
                                    <?php for ($s = 0; $s < max(1, min(5, (int) $t['rating'])); $s++): ?><i class="fa-solid fa-star text-sm"></i><?php endfor; ?>
                                </div>
                                <blockquote class="mt-4 flex-1 text-[15px] leading-7 text-slate-700">“<?= esc($t['quote']) ?>”</blockquote>
                                <figcaption class="mt-6 flex items-center gap-3 border-t border-slate-100 pt-5">
                                    <?php if (! empty($t['photo'])): ?>
                                        <img src="<?= esc(media_url($t['photo'])) ?>" alt="<?= esc($t['name']) ?>" loading="lazy" width="44" height="44" class="h-11 w-11 rounded-full object-cover">
                                    <?php else: ?>
                                        <span class="flex h-11 w-11 items-center justify-center rounded-full bg-gradient-to-br from-primary to-violet text-sm font-bold text-white"><?= esc(mb_substr(strtoupper((string) $t['name']), 0, 1)) ?></span>
                                    <?php endif; ?>
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-bold text-slate-900"><?= esc($t['name']) ?></p>
                                        <p class="truncate text-xs text-slate-500"><?= esc(trim((string) $t['role']) !== '' ? $t['role'] . ' · ' . $t['company'] : $t['company']) ?></p>
                                    </div>
                                    <?php if ($t['source'] === 'google'): ?><i class="fa-brands fa-google ml-auto text-slate-300"></i><?php endif; ?>
                                </figcaption>
                            </figure>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- arrows -->
            <button type="button" @click="prev()" aria-label="Previous testimonials"
                    class="absolute -left-3 top-1/2 hidden h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 shadow-md transition hover:border-primary hover:text-primary md:flex lg:-left-5">
                <i class="fa-solid fa-chevron-left text-sm"></i>
            </button>
            <button type="button" @click="next()" aria-label="Next testimonials"
                    class="absolute -right-3 top-1/2 hidden h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 shadow-md transition hover:border-primary hover:text-primary md:flex lg:-right-5">
                <i class="fa-solid fa-chevron-right text-sm"></i>
            </button>

            <!-- dots -->
            <div class="mt-8 flex justify-center gap-2">
                <?php for ($i = 0; $i < $n; $i++): ?>
                    <button type="button" @click="goTo(<?= $i ?>)" :aria-label="'Go to slide " + <?= $i + 1 ?>
                            class="h-2 rounded-full transition-all duration-300"
                            :class="index === <?= $i ?> ? 'w-8 bg-gradient-to-r from-primary to-violet' : 'w-2 bg-slate-300 hover:bg-slate-400'"></button>
                <?php endfor; ?>
            </div>
        </div>
    </div>

    <script>
        function ksCarousel(count, interval) {
            return {
                index: 0, perView: window.innerWidth >= 768 ? 3 : 1, timer: null,
                init() { this.timer = setInterval(() => this.next(), interval); },
                next() { this.index = (this.index + 1) % count; },
                prev() { this.index = (this.index - 1 + count) % count; },
                goTo(i) { this.index = i; },
                pause() { clearInterval(this.timer); },
                resume() { this.pause(); this.init(); },
            };
        }
    </script>
<?php endif; ?>
