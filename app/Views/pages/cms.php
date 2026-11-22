<?php /** @var array $page */ ?>
<!-- Hero -->
<section class="relative overflow-hidden bg-navy pb-16 pt-28 text-white">
    <div class="pointer-events-none absolute inset-0" aria-hidden="true">
        <div class="absolute -top-24 left-1/4 h-[360px] w-[360px] rounded-full bg-primary/25 blur-[110px]"></div>
        <div class="absolute bottom-0 right-0 h-[280px] w-[280px] rounded-full bg-violet/20 blur-[100px]"></div>
        <div class="absolute inset-0 opacity-[0.06]"
             style="background-image:linear-gradient(to right,#fff 1px,transparent 1px),linear-gradient(to bottom,#fff 1px,transparent 1px);background-size:44px 44px;"></div>
    </div>
    <div class="relative mx-auto max-w-3xl px-5 text-center lg:px-8">
        <h1 class="font-display text-4xl font-extrabold tracking-tight sm:text-5xl"><?= esc($page['title']) ?></h1>
        <?php if (! empty($page['excerpt'])): ?>
            <p class="mx-auto mt-5 max-w-xl text-lg leading-8 text-slate-300"><?= esc($page['excerpt']) ?></p>
        <?php endif; ?>
    </div>
</section>

<!-- Body -->
<section class="bg-white py-14">
    <article class="cms-body mx-auto max-w-3xl px-5 text-base leading-8 text-slate-700 lg:px-8">
        <?= $page['body'] /* editable admin HTML — trusted authors only */ ?>
    </article>
</section>
