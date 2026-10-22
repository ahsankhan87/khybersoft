<?= $this->extend('admin/layout/master') ?>
<?= $this->section('content') ?>
<?php $isEdit = ! empty($item); ?>
<form method="post" action="<?= $isEdit ? site_url('admin/tutorials/update/' . $item['id']) : site_url('admin/tutorials/store') ?>" class="max-w-3xl space-y-5 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
    <?= csrf_field() ?>
    <label class="block text-sm font-medium text-slate-700">Title<input name="title" required maxlength="200" value="<?= esc($item['title'] ?? '') ?>" class="mt-1 w-full rounded-lg border-slate-300"></label>
    <label class="block text-sm font-medium text-slate-700">Slug<input name="slug" required value="<?= esc($item['slug'] ?? '') ?>" class="mt-1 w-full rounded-lg border-slate-300"><span class="text-xs text-slate-500">Use letters, numbers, and hyphens.</span></label>
    <div class="grid gap-4 sm:grid-cols-2">
        <label class="block text-sm font-medium text-slate-700">Type<select name="type" class="mt-1 w-full rounded-lg border-slate-300"><?php foreach (['article', 'video'] as $type): ?><option value="<?= $type ?>" <?= ($item['type'] ?? 'article') === $type ? 'selected' : '' ?>><?= ucfirst($type) ?></option><?php endforeach; ?></select></label>
        <label class="block text-sm font-medium text-slate-700">Product<select name="product_id" class="mt-1 w-full rounded-lg border-slate-300"><option value="">All products</option><?php foreach ($products as $product): ?><option value="<?= (int) $product['id'] ?>" <?= (int) ($item['product_id'] ?? 0) === (int) $product['id'] ? 'selected' : '' ?>><?= esc($product['name']) ?></option><?php endforeach; ?></select></label>
        <label class="block text-sm font-medium text-slate-700">Category<select name="category_id" class="mt-1 w-full rounded-lg border-slate-300"><option value="">Uncategorized</option><?php foreach ($categories as $category): ?><option value="<?= (int) $category['id'] ?>" <?= (int) ($item['category_id'] ?? 0) === (int) $category['id'] ? 'selected' : '' ?>><?= esc($category['name']) ?></option><?php endforeach; ?></select></label>
        <label class="block text-sm font-medium text-slate-700">Video URL<input name="video_url" type="url" value="<?= esc($item['video_url'] ?? '') ?>" class="mt-1 w-full rounded-lg border-slate-300"></label>
        <label class="block text-sm font-medium text-slate-700">Thumbnail URL<input name="thumbnail" value="<?= esc($item['thumbnail'] ?? '') ?>" class="mt-1 w-full rounded-lg border-slate-300"></label>
        <label class="block text-sm font-medium text-slate-700">Duration (seconds)<input name="duration_sec" type="number" min="0" value="<?= (int) ($item['duration_sec'] ?? 0) ?>" class="mt-1 w-full rounded-lg border-slate-300"></label>
    </div>
    <label class="block text-sm font-medium text-slate-700">Article body<textarea name="article_body" rows="8" class="mt-1 w-full rounded-lg border-slate-300"><?= esc($item['article_body'] ?? '') ?></textarea></label>
    <label class="block text-sm font-medium text-slate-700">Sort order<input name="sort_order" type="number" value="<?= (int) ($item['sort_order'] ?? 0) ?>" class="mt-1 w-full rounded-lg border-slate-300"></label>
    <label class="flex items-center gap-2 text-sm text-slate-700"><input type="checkbox" name="is_published" value="1" <?= ! empty($item['is_published']) ? 'checked' : '' ?>> Published</label>
    <div class="flex gap-3"><button class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white">Save tutorial</button><a href="<?= site_url('admin/tutorials') ?>" class="rounded-lg border border-slate-300 px-5 py-2.5 text-sm">Cancel</a></div>
</form>
<?= $this->endSection() ?>
