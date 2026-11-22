<?= $this->extend('admin/layout/master') ?>
<?= $this->section('content') ?>
<?php $isEdit = ! empty($post); ?>
<form method="post" enctype="multipart/form-data" action="<?= $isEdit ? site_url('admin/posts/update/' . $post['id']) : site_url('admin/posts/store') ?>" class="max-w-4xl space-y-5 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
    <?= csrf_field() ?>
    <div class="grid gap-4 sm:grid-cols-2">
        <label class="block text-sm font-medium text-slate-700 sm:col-span-2">Title<input name="title" required maxlength="255" value="<?= esc($post['title'] ?? '') ?>" class="mt-1 w-full rounded-lg border-slate-300"></label>
        <label class="block text-sm font-medium text-slate-700">Slug<input name="slug" required value="<?= esc($post['slug'] ?? '') ?>" class="mt-1 w-full rounded-lg border-slate-300"></label>
        <label class="block text-sm font-medium text-slate-700">Category<select name="category_id" class="mt-1 w-full rounded-lg border-slate-300"><option value="">Uncategorized</option><?php foreach ($categories as $category): ?><option value="<?= (int) $category['id'] ?>" <?= (int) ($post['category_id'] ?? 0) === (int) $category['id'] ? 'selected' : '' ?>><?= esc($category['name']) ?></option><?php endforeach; ?></select></label>
        <label class="block text-sm font-medium text-slate-700">Status<select name="status" class="mt-1 w-full rounded-lg border-slate-300"><?php foreach (['draft', 'published', 'archived'] as $status): ?><option value="<?= $status ?>" <?= ($post['status'] ?? 'draft') === $status ? 'selected' : '' ?>><?= ucfirst($status) ?></option><?php endforeach; ?></select></label>
        <label class="block text-sm font-medium text-slate-700">
            Featured image
            <input type="file" name="featured_image_file" accept="image/*" class="mt-1 w-full rounded-lg border-slate-300">
            <span class="mt-1 block text-xs font-normal text-slate-500">Upload JPG, PNG, WebP, GIF, or SVG (max 2 MB).</span>
            <?php if (! empty($post['featured_image'])): ?>
                <img src="<?= esc(media_url($post['featured_image'])) ?>" alt="Current featured image" class="mt-3 h-16 w-28 rounded border border-slate-200 object-cover">
            <?php endif; ?>
        </label>
        <label class="block text-sm font-medium text-slate-700">Reading time (minutes)<input type="number" min="1" name="read_minutes" value="<?= (int) ($post['read_minutes'] ?? 5) ?>" class="mt-1 w-full rounded-lg border-slate-300"></label>
        <label class="block text-sm font-medium text-slate-700 sm:col-span-2">Excerpt<textarea name="excerpt" rows="2" class="mt-1 w-full rounded-lg border-slate-300"><?= esc($post['excerpt'] ?? '') ?></textarea></label>
        <label class="block text-sm font-medium text-slate-700 sm:col-span-2">Content<textarea id="post-content-editor" name="content" rows="16" class="mt-1 w-full rounded-lg border-slate-300"><?= esc($post['content'] ?? '') ?></textarea></label>
        <label class="block text-sm font-medium text-slate-700">Meta title<input name="meta_title" value="<?= esc($post['meta_title'] ?? '') ?>" class="mt-1 w-full rounded-lg border-slate-300"></label>
        <label class="block text-sm font-medium text-slate-700">Meta description<input name="meta_desc" value="<?= esc($post['meta_desc'] ?? '') ?>" class="mt-1 w-full rounded-lg border-slate-300"></label>
        <label class="block text-sm font-medium text-slate-700">Tags (comma separated)<input name="tags_input" value="<?= esc(implode(', ', $tagNames ?? [])) ?>" class="mt-1 w-full rounded-lg border-slate-300"></label>
        <label class="flex items-center gap-2 text-sm text-slate-700"><input type="checkbox" name="is_featured" value="1" <?= ! empty($post['is_featured']) ? 'checked' : '' ?>> Featured</label>
    </div>
    <div class="flex gap-3"><button class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white">Save post</button><a href="<?= site_url('admin/posts') ?>" class="rounded-lg border border-slate-300 px-5 py-2.5 text-sm">Cancel</a></div>
</form>
<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>
<script>
    if (typeof CKEDITOR !== 'undefined') {
        CKEDITOR.replace('post-content-editor');
    }
</script>
<?= $this->endSection() ?>
