<?php /* Single tutorial — video embed or article body. Vars: $item, $product, $related */ ?>
<article>
    <!-- Hero header -->
    <header class="relative overflow-hidden bg-navy pb-14 pt-28 text-white">
        <div class="pointer-events-none absolute inset-0" aria-hidden="true">
            <div class="absolute -top-24 left-1/4 h-[360px] w-[360px] rounded-full bg-primary/25 blur-[110px]"></div>
            <div class="absolute inset-0 opacity-[0.06]"
                 style="background-image:linear-gradient(to right,#fff 1px,transparent 1px),linear-gradient(to bottom,#fff 1px,transparent 1px);background-size:44px 44px;"></div>
        </div>
        <div class="relative mx-auto max-w-4xl px-5 lg:px-8">
            <a href="<?= site_url('tutorials') ?>" class="inline-flex items-center gap-2 text-sm font-semibold text-primary-300 transition hover:text-white">
                <i class="fa-solid fa-arrow-left"></i> All tutorials
            </a>
            <div class="mt-7 flex flex-wrap items-center gap-3 text-xs font-bold uppercase tracking-widest">
                <span class="rounded-full bg-primary/20 px-3 py-1 text-primary-200 ring-1 ring-inset ring-primary/30"><?= $item['type'] === 'video' ? 'Video' : 'Guide' ?></span>
                <?php if ($product): ?><span class="text-slate-400"><?= esc($product['name']) ?></span><?php endif; ?>
                <?php if ((int) ($item['duration_sec'] ?? 0) > 0): ?>
                    <span class="text-slate-500">·</span>
                    <span class="text-slate-400 normal-case tracking-normal"><?= gmdate('i:s', (int) $item['duration_sec']) ?> watch</span>
                <?php endif; ?>
            </div>
            <h1 class="mt-4 font-display text-3xl font-extrabold leading-tight tracking-tight sm:text-4xl"><?= esc($item['title']) ?></h1>
        </div>
    </header>

    <div class="mx-auto max-w-4xl px-5 py-14 lg:px-8">
        <!-- Video embed -->
        <?php if ($item['type'] === 'video' && ! empty($item['video_url'])): ?>
            <?php
            $url = (string) $item['video_url'];
            $embed = $url;
            if (preg_match('#(?:youtube\.com/watch\?v=|youtu\.be/)([\w-]+)#', $url, $m)) {
                $embed = 'https://www.youtube.com/embed/' . $m[1];
            } elseif (preg_match('#vimeo\.com/(\d+)#', $url, $m)) {
                $embed = 'https://player.vimeo.com/video/' . $m[1];
            }
            ?>
            <div class="aspect-video overflow-hidden rounded-3xl border border-slate-100 shadow-soft">
                <iframe src="<?= esc($embed) ?>" title="<?= esc($item['title']) ?>" class="h-full w-full" allowfullscreen loading="lazy"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
            </div>
        <?php endif; ?>

        <!-- Article body -->
        <?php if (! empty($item['article_body'])): ?>
            <div class="<?= $item['type'] === 'video' && ! empty($item['video_url']) ? 'mt-10 ' : '' ?>prose prose-lg prose-slate max-w-none prose-headings:font-display prose-headings:font-bold prose-a:font-semibold prose-a:text-primary hover:prose-a:underline prose-img:rounded-2xl">
                <?= $item['article_body'] ?>
            </div>
        <?php endif; ?>

        <div class="mt-12 border-t border-slate-200 pt-8">
            <a href="<?= site_url('tutorials') ?>" class="inline-flex items-center gap-2 text-sm font-bold text-primary transition hover:underline">
                <i class="fa-solid fa-arrow-left"></i> Back to all tutorials
            </a>
        </div>
    </div>
</article>

<!-- Related -->
<?php if (! empty($related)): ?>
<section class="bg-gradient-to-b from-slate-50 to-white py-16">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">
        <h2 class="font-display text-2xl font-extrabold text-slate-900">More tutorials</h2>
        <div class="mt-8 grid gap-6 md:grid-cols-3">
            <?php foreach ($related as $t): ?>
                <a href="<?= site_url('tutorials/' . urlencode((string) $t['slug'])) ?>"
                   class="group rounded-3xl border border-slate-100 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-soft">
                    <span class="text-xs font-bold uppercase tracking-wider text-primary"><?= $t['type'] === 'video' ? 'Video' : 'Guide' ?></span>
                    <h3 class="mt-2 font-display text-base font-bold text-slate-900 group-hover:text-primary"><?= esc($t['title']) ?></h3>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
