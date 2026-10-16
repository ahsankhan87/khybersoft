<?= $this->extend('admin/layout/master') ?>
<?= $this->section('content') ?>

<div class="grid gap-8 lg:grid-cols-3">
    <!-- List -->
    <div class="lg:col-span-1 overflow-x-auto rounded-xl bg-white shadow-sm border border-slate-200">
        <div class="border-b border-slate-100 px-5 py-4 font-semibold text-slate-900">Indexed URLs</div>
        <ul class="divide-y divide-slate-100 text-sm">
            <?php if (! $rows): ?><li class="px-5 py-8 text-center text-slate-400">No entries yet.</li><?php endif; ?>
            <?php foreach ($rows as $r): ?>
                <li class="flex items-center justify-between px-5 py-3 hover:bg-slate-50">
                    <a href="<?= site_url('admin/seo/edit?path=' . urlencode($r['url_path'])) ?>" class="font-mono text-blue-600 hover:underline"><?= esc($r['url_path']) ?></a>
                    <form method="post" action="<?= site_url('admin/seo/delete/' . $r['id']) ?>" onsubmit="return confirm('Delete?')">
                        <?= csrf_field() ?><button class="text-xs text-red-600 hover:underline">del</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Editor -->
    <form method="post" action="<?= site_url('admin/seo/save') ?>" class="lg:col-span-2 space-y-4 rounded-xl bg-white p-6 shadow-sm border border-slate-200">
        <?= csrf_field() ?>
        <div>
            <label class="block text-sm font-medium text-slate-700">URL Path</label>
            <input name="url_path" required value="<?= esc($editPath ?? $row['url_path'] ?? '/') ?>" placeholder="/pricing" class="mt-1 w-full rounded-lg border-slate-300 px-3 py-2 font-mono text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700">Title</label>
            <input name="title" value="<?= esc($row['title'] ?? '') ?>" maxlength="200" class="mt-1 w-full rounded-lg border-slate-300 px-3 py-2 text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700">Meta Description</label>
            <textarea name="description" rows="2" maxlength="300" class="mt-1 w-full rounded-lg border-slate-300 px-3 py-2 text-sm"><?= esc($row['description'] ?? '') ?></textarea>
        </div>
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="block text-sm font-medium text-slate-700">Keywords</label>
                <input name="keywords" value="<?= esc($row['keywords'] ?? '') ?>" class="mt-1 w-full rounded-lg border-slate-300 px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700">Robots</label>
                <select name="robots" class="mt-1 w-full rounded-lg border-slate-300 bg-white px-3 py-2 text-sm">
                    <?php foreach (['index,follow', 'noindex,follow', 'index,nofollow', 'noindex,nofollow'] as $rb): ?>
                        <option <?= ($row['robots'] ?? 'index,follow') === $rb ? 'selected' : '' ?>><?= $rb ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700">OG Image (path or URL)</label>
                <input name="og_image" value="<?= esc($row['og_image'] ?? '') ?>" class="mt-1 w-full rounded-lg border-slate-300 px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700">Canonical URL</label>
                <input name="canonical" value="<?= esc($row['canonical'] ?? '') ?>" class="mt-1 w-full rounded-lg border-slate-300 px-3 py-2 text-sm">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700">JSON-LD Schema (optional)</label>
            <textarea name="schema_json" rows="4" class="mt-1 w-full rounded-lg border-slate-300 px-3 py-2 font-mono text-xs"><?= esc($row['schema_json'] ?? '') ?></textarea>
        </div>
        <button class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">Save SEO Meta</button>
    </form>
</div>

<?= $this->endSection() ?>
