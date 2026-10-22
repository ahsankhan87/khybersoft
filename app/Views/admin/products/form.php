<?= $this->extend('admin/layout/master') ?>
<?= $this->section('content') ?>
<?php $isEdit = ! empty($item); ?>
<form method="post" action="<?= $isEdit ? site_url('admin/products/update/' . $item['id']) : site_url('admin/products/store') ?>" class="max-w-4xl space-y-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
    <?= csrf_field() ?>
    <div class="grid gap-4 sm:grid-cols-2">
        <label class="block text-sm font-medium text-slate-700">Name<input name="name" required maxlength="150" value="<?= esc($item['name'] ?? '') ?>" class="mt-1 w-full rounded-lg border-slate-300"></label>
        <label class="block text-sm font-medium text-slate-700">Slug<input name="slug" required value="<?= esc($item['slug'] ?? '') ?>" class="mt-1 w-full rounded-lg border-slate-300"></label>
        <label class="block text-sm font-medium text-slate-700">Category<select name="category_id" class="mt-1 w-full rounded-lg border-slate-300"><option value="">No category</option><?php foreach ($categories as $category): ?><option value="<?= (int) $category['id'] ?>" <?= (int) ($item['category_id'] ?? 0) === (int) $category['id'] ? 'selected' : '' ?>><?= esc($category['name']) ?></option><?php endforeach; ?></select></label>
        <label class="block text-sm font-medium text-slate-700">Tagline<input name="tagline" value="<?= esc($item['tagline'] ?? '') ?>" class="mt-1 w-full rounded-lg border-slate-300"></label>
        <label class="block text-sm font-medium text-slate-700">Icon class<input name="icon" value="<?= esc($item['icon'] ?? 'fa-solid fa-cube') ?>" class="mt-1 w-full rounded-lg border-slate-300"></label>
        <label class="block text-sm font-medium text-slate-700">Color theme<input name="color" value="<?= esc($item['color'] ?? '') ?>" placeholder="from-indigo-500 to-violet-500" class="mt-1 w-full rounded-lg border-slate-300"></label>
        <label class="block text-sm font-medium text-slate-700">Price from<input name="price_from" type="number" step="0.01" value="<?= esc($item['price_from'] ?? '') ?>" class="mt-1 w-full rounded-lg border-slate-300"></label>
        <label class="block text-sm font-medium text-slate-700">Currency<input name="currency" maxlength="8" value="<?= esc($item['currency'] ?? 'USD') ?>" class="mt-1 w-full rounded-lg border-slate-300"></label>
        <label class="block text-sm font-medium text-slate-700">Pricing type<input name="pricing_type" value="<?= esc($item['pricing_type'] ?? '') ?>" class="mt-1 w-full rounded-lg border-slate-300"></label>
        <label class="block text-sm font-medium text-slate-700">Status<select name="status" class="mt-1 w-full rounded-lg border-slate-300"><?php foreach (['draft', 'active', 'archived'] as $status): ?><option value="<?= $status ?>" <?= ($item['status'] ?? 'draft') === $status ? 'selected' : '' ?>><?= ucfirst($status) ?></option><?php endforeach; ?></select></label>
        <label class="block text-sm font-medium text-slate-700">Hero image URL<input name="hero_image" value="<?= esc($item['hero_image'] ?? '') ?>" class="mt-1 w-full rounded-lg border-slate-300"></label>
        <label class="block text-sm font-medium text-slate-700">Demo URL<input name="demo_url" type="url" value="<?= esc($item['demo_url'] ?? '') ?>" class="mt-1 w-full rounded-lg border-slate-300"></label>
        <label class="block text-sm font-medium text-slate-700">Documentation URL<input name="docs_url" type="url" value="<?= esc($item['docs_url'] ?? '') ?>" class="mt-1 w-full rounded-lg border-slate-300"></label>
        <label class="block text-sm font-medium text-slate-700">Brochure URL<input name="brochure_url" type="url" value="<?= esc($item['brochure_url'] ?? '') ?>" class="mt-1 w-full rounded-lg border-slate-300"></label>
        <label class="block text-sm font-medium text-slate-700">Sort order<input name="sort_order" type="number" value="<?= (int) ($item['sort_order'] ?? 0) ?>" class="mt-1 w-full rounded-lg border-slate-300"></label>
    </div>
    <label class="block text-sm font-medium text-slate-700">Short description<textarea name="description" rows="3" class="mt-1 w-full rounded-lg border-slate-300"><?= esc($item['description'] ?? '') ?></textarea></label>
    <label class="block text-sm font-medium text-slate-700">Full description<textarea name="long_description" rows="8" class="mt-1 w-full rounded-lg border-slate-300"><?= esc($item['long_description'] ?? '') ?></textarea></label>
    <label class="block text-sm font-medium text-slate-700">Top features<textarea name="top_features" rows="4" class="mt-1 w-full rounded-lg border-slate-300"><?= esc($item['top_features'] ?? '') ?></textarea><span class="text-xs text-slate-500">Enter feature details as text or JSON.</span></label>
    <div class="grid gap-4 sm:grid-cols-2">
        <label class="block text-sm font-medium text-slate-700">SEO title<input name="seo_title" value="<?= esc($item['seo_title'] ?? '') ?>" class="mt-1 w-full rounded-lg border-slate-300"></label>
        <label class="block text-sm font-medium text-slate-700">SEO description<input name="seo_description" value="<?= esc($item['seo_description'] ?? '') ?>" class="mt-1 w-full rounded-lg border-slate-300"></label>
    </div>
    <label class="flex items-center gap-2 text-sm text-slate-700"><input type="checkbox" name="is_featured" value="1" <?= ! empty($item['is_featured']) ? 'checked' : '' ?>> Featured</label>
    <div class="flex gap-3"><button class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white">Save product</button><a href="<?= site_url('admin/products') ?>" class="rounded-lg border border-slate-300 px-5 py-2.5 text-sm">Cancel</a></div>
</form>
<?= $this->endSection() ?>
