<?= $this->extend('admin/layout/master') ?>
<?= $this->section('content') ?>
<?php $isEdit = ! empty($item); ?>
<form method="post" enctype="multipart/form-data"
      action="<?= $isEdit ? site_url('admin/clients/save/' . $item['id']) : site_url('admin/clients/save') ?>"
      class="max-w-2xl space-y-5 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
    <?= csrf_field() ?>

    <label class="block text-sm font-medium text-slate-700">Company name
        <input name="company_name" required maxlength="150" value="<?= esc(old('company_name', $item['company_name'] ?? '')) ?>"
               class="mt-1 w-full rounded-lg border-slate-300">
    </label>

    <div>
        <span class="block text-sm font-medium text-slate-700">Logo</span>
        <?php if ($isEdit && ! empty($item['logo'])): ?>
            <div class="mt-2 flex items-center gap-3 rounded-lg border border-slate-200 bg-slate-50 p-3">
                <img src="<?= esc(media_url($item['logo'])) ?>" alt="Current logo" class="h-10 w-auto max-w-[160px] object-contain">
                <span class="text-xs text-slate-500">Current logo — upload a new file to replace it</span>
            </div>
        <?php endif; ?>
        <input type="file" name="logo_file" accept="image/png,image/jpeg,image/webp,image/gif,image/svg+xml"
               class="mt-2 block w-full text-sm">
        <p class="mt-1 text-xs text-slate-400">JPG, PNG, WebP, GIF or SVG — max 2 MB.</p>
    </div>

    <label class="block text-sm font-medium text-slate-700">Website
        <input name="website" type="url" value="<?= esc(old('website', $item['website'] ?? '')) ?>"
               placeholder="https://…" class="mt-1 w-full rounded-lg border-slate-300">
    </label>

    <div class="grid gap-4 sm:grid-cols-2">
        <label class="block text-sm font-medium text-slate-700">Industry
            <input name="industry" value="<?= esc(old('industry', $item['industry'] ?? '')) ?>"
                   placeholder="General" class="mt-1 w-full rounded-lg border-slate-300">
        </label>
        <label class="block text-sm font-medium text-slate-700">Sort order
            <input name="sort_order" type="number" value="<?= (int) old('sort_order', $item['sort_order'] ?? 0) ?>"
                   class="mt-1 w-full rounded-lg border-slate-300">
        </label>
    </div>

    <label class="flex items-center gap-2 text-sm text-slate-700">
        <input type="checkbox" name="is_active" value="1" <?= old('is_active', $item['is_active'] ?? 1) ? 'checked' : '' ?>> Active
    </label>

    <div class="flex gap-3">
        <button class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
            <?= $isEdit ? 'Save changes' : 'Add client' ?>
        </button>
        <a href="<?= site_url('admin/clients') ?>" class="rounded-lg border border-slate-300 px-5 py-2.5 text-sm hover:bg-slate-50">Cancel</a>
    </div>
</form>
<?= $this->endSection() ?>
