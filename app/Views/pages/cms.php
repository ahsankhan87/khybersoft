<?php /** @var array $page */ ?>
<section class="border-b border-slate-100 bg-gradient-to-b from-blue-50/60 to-white py-16 text-center">
    <div class="mx-auto max-w-3xl px-6">
        <h1 class="text-4xl font-extrabold tracking-tight text-slate-900 sm:text-5xl"><?= esc($page['title']) ?></h1>
        <?php if (! empty($page['excerpt'])): ?>
            <p class="mt-4 text-lg leading-8 text-slate-600"><?= esc($page['excerpt']) ?></p>
        <?php endif; ?>
    </div>
</section>

<section class="py-16">
    <article class="cms-body mx-auto max-w-3xl px-6 text-base leading-7 text-slate-700">
        <?= $page['body'] /* editable admin HTML – trusted authors only */ ?>
    </article>
</section>
