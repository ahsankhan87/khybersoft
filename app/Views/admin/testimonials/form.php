<?= $this->extend('admin/layout/master') ?>
<?= $this->section('content') ?>
<?php $isEdit = ! empty($item); ?>
<form method="post" action="<?= $isEdit ? site_url('admin/testimonials/update/' . $item['id']) : site_url('admin/testimonials/store') ?>" class="max-w-3xl space-y-5 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
    <?= csrf_field() ?>
    <label class="block text-sm font-medium text-slate-700">Customer name<input name="name" required maxlength="120" value="<?= esc($item['name'] ?? '') ?>" class="mt-1 w-full rounded-lg border-slate-300"></label>
    <label class="block text-sm font-medium text-slate-700">Quote<textarea name="quote" required minlength="10" rows="4" class="mt-1 w-full rounded-lg border-slate-300"><?= esc($item['quote'] ?? '') ?></textarea></label>
    <div class="grid gap-4 sm:grid-cols-2">
        <label class="block text-sm font-medium text-slate-700">Role<input name="role" value="<?= esc($item['role'] ?? '') ?>" class="mt-1 w-full rounded-lg border-slate-300"></label>
        <label class="block text-sm font-medium text-slate-700">Company<input name="company" value="<?= esc($item['company'] ?? '') ?>" class="mt-1 w-full rounded-lg border-slate-300"></label>
        <label class="block text-sm font-medium text-slate-700">Photo URL<input name="photo" value="<?= esc($item['photo'] ?? '') ?>" class="mt-1 w-full rounded-lg border-slate-300"></label>
        <label class="block text-sm font-medium text-slate-700">Company logo URL<input name="company_logo" value="<?= esc($item['company_logo'] ?? '') ?>" class="mt-1 w-full rounded-lg border-slate-300"></label>
        <label class="block text-sm font-medium text-slate-700">Product<select name="product_id" class="mt-1 w-full rounded-lg border-slate-300"><option value="">General</option><?php foreach ($products as $product): ?><option value="<?= (int) $product['id'] ?>" <?= (int) ($item['product_id'] ?? 0) === (int) $product['id'] ? 'selected' : '' ?>><?= esc($product['name']) ?></option><?php endforeach; ?></select></label>
        <label class="block text-sm font-medium text-slate-700">Rating<select name="rating" class="mt-1 w-full rounded-lg border-slate-300"><?php for ($rating = 5; $rating >= 1; $rating--): ?><option value="<?= $rating ?>" <?= (int) ($item['rating'] ?? 5) === $rating ? 'selected' : '' ?>><?= $rating ?>/5</option><?php endfor; ?></select></label>
        <label class="block text-sm font-medium text-slate-700">Status<select name="status" class="mt-1 w-full rounded-lg border-slate-300"><?php foreach (['pending', 'approved', 'hidden'] as $status): ?><option value="<?= $status ?>" <?= ($item['status'] ?? 'pending') === $status ? 'selected' : '' ?>><?= ucfirst($status) ?></option><?php endforeach; ?></select></label>
        <label class="block text-sm font-medium text-slate-700">Sort order<input name="sort_order" type="number" value="<?= (int) ($item['sort_order'] ?? 0) ?>" class="mt-1 w-full rounded-lg border-slate-300"></label>
    </div>
    <label class="flex items-center gap-2 text-sm text-slate-700"><input type="checkbox" name="is_featured" value="1" <?= ! empty($item['is_featured']) ? 'checked' : '' ?>> Featured</label>
    <div class="flex gap-3"><button class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white">Save testimonial</button><a href="<?= site_url('admin/testimonials') ?>" class="rounded-lg border border-slate-300 px-5 py-2.5 text-sm">Cancel</a></div>
</form>
<?= $this->endSection() ?>
