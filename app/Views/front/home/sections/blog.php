<?php /* Section 14 — Latest from blog (news table) */ ?>
<?php if (! empty($latestPosts)): ?>
<section class="bg-gradient-to-b from-slate-50 to-white py-24" id="blog">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">
        <div class="flex flex-col items-start justify-between gap-6 md:flex-row md:items-end" data-aos="fade-up">
            <div>
                <p class="text-sm font-bold uppercase tracking-widest text-primary">Blog</p>
                <h2 class="mt-3 font-display text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">
                    <?= esc(setting('blog_heading', 'Latest from the blog')) ?>
                </h2>
            </div>
            <a href="<?= site_url_path('/blogs') ?>" class="whitespace-nowrap text-sm font-bold text-primary hover:underline">All articles →</a>
        </div>

        <div class="mt-12 grid gap-8 md:grid-cols-3">
            <?php foreach ($latestPosts as $bi => $post): ?>
                <article class="group overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-soft"
                         data-aos="fade-up" data-aos-delay="<?= $bi * 120 ?>">
                    <a href="<?= site_url_path('/blog/' . urlencode((string) $post['slug'])) ?>">
                        <div class="aspect-[16/9] overflow-hidden bg-gradient-to-br from-indigo-100 to-violet-100">
                            <?php if (! empty($post['image'])): ?>
                                <img src="<?= esc(media_url($post['image'])) ?>" alt="" loading="lazy"
                                     class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                            <?php else: ?>
                                <div class="flex h-full items-center justify-center"><i class="fa-solid fa-newspaper text-4xl text-indigo-200"></i></div>
                            <?php endif; ?>
                        </div>
                        <div class="p-7">
                            <div class="flex items-center gap-3 text-xs">
                                <span class="rounded-full bg-indigo-50 px-3 py-1 font-bold uppercase tracking-wide text-primary"><?= esc($post['category'] ?: 'News') ?></span>
                                <time class="text-slate-400"><?= date('M j, Y', strtotime((string) $post['created_at'])) ?></time>
                            </div>
                            <h3 class="mt-3 line-clamp-2 font-display text-lg font-bold text-slate-900 transition group-hover:text-primary"><?= esc($post['title']) ?></h3>
                            <p class="mt-2 line-clamp-2 text-sm leading-6 text-slate-500"><?= esc(strip_tags((string) $post['body'])) ?></p>
                        </div>
                    </a>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
