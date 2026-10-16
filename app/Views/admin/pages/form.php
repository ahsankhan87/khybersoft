<?= $this->extend('admin/layout/master') ?>
<?= $this->section('content') ?>
<form method="post" action="<?= $page ? site_url('admin/pages/update/' . $page['id']) : site_url('admin/pages/store') ?>" class="max-w-4xl space-y-5">
    <?= csrf_field() ?>
    <div class="grid gap-5 sm:grid-cols-2">
        <div class="sm:col-span-2">
            <label class="block text-sm font-medium text-slate-700">Title</label>
            <input name="title" required value="<?= esc(old('title', $page['title'] ?? '')) ?>" class="mt-1 w-full rounded-lg border-slate-300 px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700">Slug (without leading /)</label>
            <input name="slug" required value="<?= esc(old('slug', $page['slug'] ?? '')) ?>" placeholder="about-us" class="mt-1 w-full rounded-lg border-slate-300 px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700">Template</label>
            <select name="template" class="mt-1 w-full rounded-lg border-slate-300 bg-white px-3 py-2">
                <?php foreach (['default', 'full-width', 'landing'] as $tpl): ?>
                    <option value="<?= $tpl ?>" <?= ($page['template'] ?? '') === $tpl ? 'selected' : '' ?>><?= $tpl ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="sm:col-span-2">
            <label class="block text-sm font-medium text-slate-700">Body (HTML allowed)</label>
            <textarea name="body" rows="18" class="mt-1 w-full rounded-lg border-slate-300 px-3 py-2 font-mono text-sm"><?= esc(old('body', $page['body'] ?? '')) ?></textarea>
        </div>
        <div class="sm:col-span-2">
            <label class="block text-sm font-medium text-slate-700">Excerpt</label>
            <input name="excerpt" value="<?= esc(old('excerpt', $page['excerpt'] ?? '')) ?>" class="mt-1 w-full rounded-lg border-slate-300 px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700">Meta Title</label>
            <input name="meta_title" value="<?= esc(old('meta_title', $page['meta_title'] ?? '')) ?>" class="mt-1 w-full rounded-lg border-slate-300 px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700">Meta Description</label>
            <input name="meta_description" value="<?= esc(old('meta_description', $page['meta_description'] ?? '')) ?>" class="mt-1 w-full rounded-lg border-slate-300 px-3 py-2">
        </div>
        <label class="flex items-center gap-2 text-sm text-slate-700">
            <input type="checkbox" name="is_published" value="1" <?= ($page['is_published'] ?? 0) ? 'checked' : '' ?> class="rounded border-slate-300 text-blue-600"> Published
        </label>
    </div>
    <div class="flex gap-3">
        <button class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700"><?= $page ? 'Save changes' : 'Create page' ?></button>
        <a href="<?= site_url('admin/pages') ?>" class="rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">Cancel</a>
    </div>
</form>
<?= $this->endSection() ?>
