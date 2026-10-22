<?= $this->extend('admin/layout/master') ?>
<?= $this->section('content') ?>

<div class="mb-5 flex flex-wrap items-center justify-between gap-3">
    <p class="text-sm text-slate-500">Manage blog posts (<?= (int) $total ?> total).</p>
    <a href="<?= site_url('admin/posts/create') ?>" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white">New post</a>
</div>
<form method="get" class="mb-5 flex flex-wrap gap-2 rounded-xl border border-slate-200 bg-white p-4">
    <input name="q" value="<?= esc($q ?? '') ?>" placeholder="Search posts" class="rounded-lg border-slate-300 text-sm">
    <select name="status" class="rounded-lg border-slate-300 text-sm"><option value="">All statuses</option><?php foreach (['draft', 'published', 'archived'] as $option): ?><option value="<?= $option ?>" <?= ($status ?? '') === $option ? 'selected' : '' ?>><?= ucfirst($option) ?></option><?php endforeach; ?></select>
    <select name="category" class="rounded-lg border-slate-300 text-sm"><option value="">All categories</option><?php foreach ($categories as $category): ?><option value="<?= (int) $category['id'] ?>" <?= (int) ($categoryId ?? 0) === (int) $category['id'] ? 'selected' : '' ?>><?= esc($category['name']) ?></option><?php endforeach; ?></select>
    <button class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white">Filter</button>
    <a href="<?= site_url('admin/posts') ?>" class="px-2 py-2 text-sm text-slate-500">Reset</a>
</form>

<form method="post" action="<?= site_url('admin/posts/bulk') ?>" class="overflow-x-auto rounded-xl border border-slate-200 bg-white shadow-sm">
    <?= csrf_field() ?>
    <div class="flex items-center gap-2 border-b border-slate-100 p-3"><select name="bulk_action" class="rounded-lg border-slate-300 text-sm"><option value="">Bulk action</option><option value="delete">Delete selected</option></select><button class="rounded-lg border border-slate-300 px-3 py-2 text-sm">Apply</button></div>
    <table class="w-full text-left text-sm"><thead class="bg-slate-50 text-xs uppercase text-slate-500"><tr><th class="px-4 py-3"><input type="checkbox" onclick="document.querySelectorAll('.post-check').forEach(x=>x.checked=this.checked)"></th><th class="px-4 py-3">Title</th><th class="px-4 py-3">Category</th><th class="px-4 py-3">Author</th><th class="px-4 py-3">Status</th><th class="px-4 py-3">Published</th><th></th></tr></thead>
    <tbody class="divide-y divide-slate-100">
        <?php foreach ($posts as $post): ?><tr><td class="px-4 py-3"><input class="post-check" type="checkbox" name="ids[]" value="<?= (int) $post['id'] ?>"></td><td class="px-4 py-3"><div class="font-medium text-slate-900"><?= esc($post['title']) ?></div><div class="text-xs text-slate-500">/blog/<?= esc($post['slug']) ?></div></td><td class="px-4 py-3 text-slate-600"><?= esc($post['category_name'] ?? '—') ?></td><td class="px-4 py-3 text-slate-600"><?= esc($post['author_name'] ?? '—') ?></td><td class="px-4 py-3 capitalize"><?= esc($post['status']) ?></td><td class="px-4 py-3 text-slate-500"><?= esc($post['published_at'] ?? '—') ?></td><td class="px-4 py-3 text-right"><a href="<?= site_url('admin/posts/edit/' . $post['id']) ?>" class="text-blue-600 hover:underline">Edit</a><form method="post" action="<?= site_url('admin/posts/delete/' . $post['id']) ?>" class="ml-3 inline" onsubmit="return confirm('Delete this post?')"><?= csrf_field() ?><button class="text-red-600 hover:underline">Delete</button></form></td></tr><?php endforeach; ?>
        <?php if (! $posts): ?><tr><td colspan="7" class="px-4 py-10 text-center text-slate-400">No posts found.</td></tr><?php endif; ?>
    </tbody></table>
</form>
<div class="mt-5"><?= $pager->links() ?></div>

<?= $this->endSection() ?>
