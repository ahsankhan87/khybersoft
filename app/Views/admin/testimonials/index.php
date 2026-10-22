<?= $this->extend('admin/layout/master') ?>
<?= $this->section('content') ?>

<div class="mb-5 flex items-center justify-between">
    <p class="text-sm text-slate-500">Manage customer testimonials shown across the site.</p>
    <a href="<?= site_url('admin/testimonials/create') ?>" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white">Add testimonial</a>
</div>
<div class="overflow-x-auto rounded-xl border border-slate-200 bg-white shadow-sm">
    <table class="w-full text-left text-sm">
        <thead class="bg-slate-50 text-xs uppercase text-slate-500"><tr><th class="px-4 py-3">Customer</th><th class="px-4 py-3">Quote</th><th class="px-4 py-3">Product</th><th class="px-4 py-3">Rating</th><th class="px-4 py-3">Status</th><th class="px-4 py-3"></th></tr></thead>
        <tbody class="divide-y divide-slate-100">
            <?php foreach ($items as $item): ?>
                <tr>
                    <td class="px-4 py-3"><div class="font-medium text-slate-900"><?= esc($item['name']) ?></div><div class="text-xs text-slate-500"><?= esc(trim(($item['role'] ?? '') . ' ' . ($item['company'] ?? ''))) ?></div></td>
                    <td class="max-w-xl px-4 py-3 text-slate-600"><?= esc(mb_strimwidth($item['quote'], 0, 130, '…')) ?></td>
                    <td class="px-4 py-3 text-slate-600"><?php foreach ($products as $product) { if ((int) $product['id'] === (int) ($item['product_id'] ?? 0)) { echo esc($product['name']); break; } } ?></td>
                    <td class="px-4 py-3"><?= (int) $item['rating'] ?>/5</td>
                    <td class="px-4 py-3 capitalize"><?= esc($item['status'] ?? 'pending') ?></td>
                    <td class="whitespace-nowrap px-4 py-3 text-right">
                        <a href="<?= site_url('admin/testimonials/edit/' . $item['id']) ?>" class="text-blue-600 hover:underline">Edit</a>
                        <form method="post" action="<?= site_url('admin/testimonials/toggle/' . $item['id']) ?>" class="ml-3 inline"><?= csrf_field() ?><button class="text-slate-600 hover:underline">Toggle</button></form>
                        <form method="post" action="<?= site_url('admin/testimonials/delete/' . $item['id']) ?>" class="ml-3 inline" onsubmit="return confirm('Delete this testimonial?')"><?= csrf_field() ?><button class="text-red-600 hover:underline">Delete</button></form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (! $items): ?><tr><td colspan="6" class="px-4 py-10 text-center text-slate-400">No testimonials yet.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>

<form method="post" action="<?= site_url('admin/testimonials/import') ?>" enctype="multipart/form-data" class="mt-6 flex flex-wrap items-center gap-3 rounded-xl border border-slate-200 bg-white p-4">
    <?= csrf_field() ?><label class="text-sm font-medium text-slate-700">Import CSV <input type="file" name="csv" accept=".csv,text/csv" required class="ml-2 text-sm"></label>
    <button class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700">Import</button>
</form>

<?= $this->endSection() ?>
