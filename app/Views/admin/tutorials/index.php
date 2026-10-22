<?= $this->extend('admin/layout/master') ?>
<?= $this->section('content') ?>

<div class="mb-5 flex flex-wrap items-center justify-between gap-3">
    <p class="text-sm text-slate-500">Manage tutorials and help center articles.</p>
    <div class="flex gap-2"><a href="<?= site_url('admin/tutorial-categories') ?>" class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium">Categories</a><a href="<?= site_url('admin/tutorials/create') ?>" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white">Add tutorial</a></div>
</div>
<div class="overflow-x-auto rounded-xl border border-slate-200 bg-white shadow-sm">
    <table class="w-full text-left text-sm">
        <thead class="bg-slate-50 text-xs uppercase text-slate-500"><tr><th class="px-4 py-3">Title</th><th class="px-4 py-3">Type</th><th class="px-4 py-3">Product</th><th class="px-4 py-3">Visibility</th><th class="px-4 py-3"></th></tr></thead>
        <tbody class="divide-y divide-slate-100">
            <?php foreach ($items as $item): ?>
                <tr>
                    <td class="px-4 py-3"><div class="font-medium text-slate-900"><?= esc($item['title']) ?></div><div class="text-xs text-slate-500"><?= esc($item['slug']) ?></div></td>
                    <td class="px-4 py-3 capitalize text-slate-600"><?= esc($item['type']) ?></td>
                    <td class="px-4 py-3 text-slate-600"><?php foreach ($products as $product) { if ((int) $product['id'] === (int) ($item['product_id'] ?? 0)) { echo esc($product['name']); break; } } ?></td>
                    <td class="px-4 py-3"><?= ! empty($item['is_published']) ? 'Published' : 'Draft' ?></td>
                    <td class="whitespace-nowrap px-4 py-3 text-right"><a href="<?= site_url('admin/tutorials/edit/' . $item['id']) ?>" class="text-blue-600 hover:underline">Edit</a><form method="post" action="<?= site_url('admin/tutorials/toggle/' . $item['id']) ?>" class="ml-3 inline"><?= csrf_field() ?><button class="text-slate-600 hover:underline">Toggle</button></form><form method="post" action="<?= site_url('admin/tutorials/delete/' . $item['id']) ?>" class="ml-3 inline" onsubmit="return confirm('Delete this tutorial?')"><?= csrf_field() ?><button class="text-red-600 hover:underline">Delete</button></form></td>
                </tr>
            <?php endforeach; ?>
            <?php if (! $items): ?><tr><td colspan="5" class="px-4 py-10 text-center text-slate-400">No tutorials yet.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
