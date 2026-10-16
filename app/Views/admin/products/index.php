<?= $this->extend('admin/layout/master') ?>
<?= $this->section('content') ?>

<div class="mb-4 flex items-center justify-between">
    <h1 class="text-xl font-bold text-slate-800">Products</h1>
    <a href="<?= site_url('admin/products/create') ?>" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700"><i class="fa-solid fa-plus mr-1"></i>New Product</a>
</div>

<!-- Filters -->
<form method="get" class="mb-4 flex flex-wrap items-center gap-3 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
    <input name="q" value="<?= esc($q) ?>" placeholder="Search name / tagline…" class="w-56 rounded-lg border-slate-300 px-3 py-2 text-sm">
    <select name="category" class="rounded-lg border-slate-300 bg-white px-3 py-2 text-sm">
        <option value="">All categories</option>
        <?php foreach ($categories as $c): ?><option value="<?= (int) $c['id'] ?>" <?= $catId === (int) $c['id'] ? 'selected' : '' ?>><?= esc($c['name']) ?></option><?php endforeach; ?>
    </select>
    <select name="status" class="rounded-lg border-slate-300 bg-white px-3 py-2 text-sm">
        <option value="">Any status</option>
        <?php foreach (['active','draft','archived'] as $s): ?><option value="<?= $s ?>" <?= $status === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option><?php endforeach; ?>
    </select>
    <button class="rounded-lg bg-slate-800 px-4 py-2 text-sm font-semibold text-white">Filter</button>
    <a href="<?= site_url('admin/products') ?>" class="text-sm text-slate-500 hover:underline">Reset</a>
</form>

<form method="post" id="bulkForm">
    <?= csrf_field() ?>
    <div class="mb-3 flex items-center gap-3">
        <select name="bulk_action" class="rounded-lg border-slate-300 bg-white px-3 py-2 text-sm">
            <option value="">Bulk actions…</option>
            <option value="publish">Publish</option>
            <option value="draft">Draft</option>
            <option value="feature">Mark featured</option>
            <option value="unfeature">Unfeature</option>
            <option value="delete">Delete</option>
        </select>
        <button type="submit" formnovalidate onclick="return confirm('Apply bulk action to selected?')" class="rounded-lg border border-slate-300 px-3 py-2 text-sm font-semibold hover:bg-slate-50">Apply</button>
    </div>

    <div class="overflow-x-auto rounded-xl border border-slate-200 bg-white shadow-sm">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-4 py-3"><input type="checkbox" onclick="document.querySelectorAll('.rowchk').forEach(c=>c.checked=this.checked)" class="rounded"></th>
                    <th class="px-4 py-3">Product</th>
                    <th class="px-4 py-3">Category</th>
                    <th class="px-4 py-3">Price from</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Featured</th>
                    <th class="px-4 py-3">Order</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php foreach ($products as $p): ?>
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3"><input type="checkbox" class="rowchk rounded" name="ids[]" value="<?= (int) $p['id'] ?>"></td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <span class="grid h-9 w-9 shrink-0 place-items-center rounded-lg bg-gradient-to-br <?= esc($p['color'] ?: 'from-indigo-500 to-violet-500') ?> text-white"><i class="<?= esc($p['icon']) ?>"></i></span>
                            <div>
                                <p class="font-semibold text-slate-800"><?= esc($p['name']) ?></p>
                                <p class="text-xs text-slate-400"><?= esc($p['slug']) ?></p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-slate-600"><?= esc($p['category_id'] ? ($categories[array_search((int)$p['category_id'], array_column($categories, 'id'))]['name'] ?? '—') : '—') ?></td>
                    <td class="px-4 py-3 text-slate-600"><?= $p['price_from'] !== null ? esc($p['currency'] . ' ' . number_format((float) $p['price_from'])) : 'Custom' ?></td>
                    <td class="px-4 py-3"><span class="rounded-full px-2.5 py-1 text-xs font-semibold <?= $p['status'] === 'active' ? 'bg-emerald-100 text-emerald-700' : ($p['status'] === 'draft' ? 'bg-amber-100 text-amber-700' : 'bg-slate-100 text-slate-500') ?>"><?= esc($p['status']) ?></span></td>
                    <td class="px-4 py-3"><?= $p['is_featured'] ? '<i class="fa-solid fa-star text-amber-400"></i>' : '<i class="fa-regular fa-star text-slate-300"></i>' ?></td>
                    <td class="px-4 py-3 text-slate-500"><?= (int) $p['sort_order'] ?></td>
                    <td class="px-4 py-3 text-right">
                        <a title="View page" target="_blank" href="<?= site_url('products/' . $p['slug']) ?>" class="mr-2 text-slate-400 hover:text-blue-600"><i class="fa-solid fa-up-right-from-square"></i></a>
                        <a title="Edit" href="<?= site_url('admin/products/edit/' . $p['id']) ?>" class="mr-2 text-slate-400 hover:text-blue-600"><i class="fa-solid fa-pen"></i></a>
                        <a title="Delete" href="<?= site_url('admin/products/delete/' . $p['id']) ?>" onclick="return confirm('Delete <?= esc(addslashes($p['name'])) ?> and all its plans/features?')" class="text-slate-400 hover:text-red-600"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (! $products): ?><tr><td colspan="8" class="px-4 py-10 text-center text-slate-400">No products found.</td></tr><?php endif; ?>
            </tbody>
        </table>
    </div>
</form>
<?= $this->endSection() ?>
