<?php /* Section 8 — Interactive feature deep-dive (Enerpize-style vertical tabs) */ ?>
<?php if (! empty($deepDiveTabs)): ?>
<section class="relative overflow-hidden bg-navy py-24 text-white" id="features">
    <div class="pointer-events-none absolute inset-0" aria-hidden="true">
        <div class="absolute -left-20 top-1/3 h-96 w-96 rounded-full bg-primary/20 blur-[130px]"></div>
        <div class="absolute -right-20 bottom-0 h-96 w-96 rounded-full bg-violet/20 blur-[130px]"></div>
    </div>

    <div class="relative mx-auto max-w-7xl px-5 lg:px-8">
        <div class="mx-auto max-w-2xl text-center" data-aos="fade-up">
            <p class="text-sm font-bold uppercase tracking-widest text-emerald-400">Feature deep-dive</p>
            <h2 class="mt-3 font-display text-3xl font-extrabold tracking-tight sm:text-4xl">
                <?= esc(setting('deepdive_heading', 'Powerful where it counts')) ?>
            </h2>
        </div>

        <div x-data="{ active: <?= esc(json_encode(array_key_first($deepDiveTabs))) ?> }" class="mt-14 grid gap-10 lg:grid-cols-12">
            <!-- Vertical tab list -->
            <div class="lg:col-span-4" data-aos="fade-right">
                <div role="tablist" aria-label="Feature deep dive" class="flex flex-row flex-wrap gap-2 lg:flex-col lg:flex-nowrap lg:gap-1.5">
                    <?php foreach ($deepDiveTabs as $k => $t): ?>
                        <button type="button" role="tab" @click="active = <?= esc(json_encode($k)) ?>"
                                class="flex items-center gap-3 rounded-2xl px-5 py-4 text-left text-sm font-semibold transition-all duration-200"
                                :class="active === <?= esc(json_encode($k)) ?>
                                    ? 'bg-gradient-to-r from-primary to-violet text-white shadow-glow translate-x-1'
                                    : 'bg-white/5 text-slate-300 hover:bg-white/10'">
                            <i class="<?= esc($t['icon'] ?? 'fa-solid fa-star') ?> w-5 text-center"></i>
                            <?= esc($t['name']) ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Animated mockup + bullets -->
            <div class="lg:col-span-8" data-aos="fade-left">
                <?php foreach ($deepDiveTabs as $k => $t): ?>
                    <div x-show="active === <?= esc(json_encode($k)) ?>" x-cloak
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-[0.98]"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="rounded-3xl border border-white/10 bg-white/[0.06] p-6 backdrop-blur-xl sm:p-8">
                        <h3 class="font-display text-2xl font-bold"><?= esc($t['title'] ?? $t['name']) ?></h3>

                        <!-- mockup visual -->
                        <div class="mt-6 overflow-hidden rounded-2xl ring-1 ring-white/10">
                            <?php if (! empty($t['image'])): ?>
                                <img src="<?= esc(media_url($t['image'])) ?>" alt="<?= esc($t['title'] ?? $t['name']) ?> screenshot"
                                     loading="lazy" class="w-full object-cover" width="720" height="405">
                            <?php else: ?>
                                <div class="flex aspect-video w-full flex-col justify-between bg-gradient-to-br from-indigo-950 via-navy to-violet-950 p-6">
                                    <div class="flex gap-2">
                                        <span class="h-2.5 w-2.5 rounded-full bg-red-400/70"></span>
                                        <span class="h-2.5 w-2.5 rounded-full bg-amber-400/70"></span>
                                        <span class="h-2.5 w-2.5 rounded-full bg-emerald-400/70"></span>
                                    </div>
                                    <div class="grid grid-cols-3 gap-4">
                                        <div class="col-span-2 space-y-3">
                                            <div class="h-3 w-3/4 rounded bg-white/15"></div>
                                            <div class="h-3 w-1/2 rounded bg-white/10"></div>
                                            <div class="mt-6 flex h-28 items-end gap-2 rounded-xl bg-white/5 p-3">
                                                <?php foreach ([40,65,50,80,60,95] as $hh): ?>
                                                    <div class="w-full rounded-t bg-gradient-to-t from-primary to-violet" style="height:<?= $hh ?>%"></div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                        <div class="space-y-3">
                                            <div class="rounded-xl bg-white/5 p-3"><div class="h-2 w-full rounded bg-white/20"></div><div class="mt-2 h-2 w-2/3 rounded bg-emerald-400/40"></div></div>
                                            <div class="rounded-xl bg-white/5 p-3"><div class="h-2 w-full rounded bg-white/20"></div><div class="mt-2 h-2 w-1/2 rounded bg-indigo-300/40"></div></div>
                                            <div class="rounded-xl bg-white/5 p-3"><div class="h-2 w-full rounded bg-white/20"></div><div class="mt-2 h-2 w-3/4 rounded bg-violet-300/40"></div></div>
                                        </div>
                                    </div>
                                    <p class="text-center text-xs text-slate-400"><?= esc($t['name']) ?> · live preview</p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <ul class="mt-6 grid gap-3 sm:grid-cols-2">
                            <?php foreach (($t['points'] ?? []) as $pt): ?>
                                <li class="flex items-start gap-2.5 text-sm text-slate-200">
                                    <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-accent/20 text-[10px] text-emerald-400"><i class="fa-solid fa-check"></i></span>
                                    <?= esc($pt) ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
