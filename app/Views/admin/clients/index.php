<?= $this->extend('admin/layout/master') ?>
<?= $this->section('content') ?>

<div class="mb-5 flex flex-wrap items-center justify-between gap-3">
    <p class="text-sm text-slate-500">Manage the client logo wall (<?= count($items) ?> total).</p>
    <a href="<?= site_url('admin/clients/create') ?>" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
        <i class="fa-solid fa-plus mr-1"></i> Add client
    </a>
</div>

<div class="overflow-x-auto rounded-xl border border-slate-200 bg-white shadow-sm">
    <table class="w-full text-left text-sm">
        <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
            <tr>
                <th class="px-4 py-3">Logo</th>
                <th class="px-4 py-3">Company</th>
                <th class="px-4 py-3">Industry</th>
                <th class="px-4 py-3">Order</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            <?php foreach ($items as $item): ?>
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-3">
                        <?php if (! empty($item['logo'])): ?>
                            <span class="inline-flex h-10 w-24 items-center justify-center rounded-lg border border-slate-200 bg-white p-1.5">
                                <img src="<?= esc(media_url($item['logo'])) ?>" alt="<?= esc($item['company_name']) ?>" class="max-h-full max-w-full object-contain">
                            </span>
                        <?php else: ?>
                            <span class="inline-flex h-10 w-24 items-center justify-center rounded-lg border border-dashed border-slate-300 text-[10px] uppercase tracking-wide text-slate-400">No logo</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-3 font-medium text-slate-900">
                        <?= esc($item['company_name']) ?>
                        <?php if (! empty($item['website'])): ?>
                            <a href="<?= esc($item['website']) ?>" target="_blank" rel="noopener" class="ml-1 text-slate-400 hover:text-blue-600" title="Visit website"><i class="fa-solid fa-arrow-up-right-from-square text-xs"></i></a>
                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-3 text-slate-600"><?= esc($item['industry'] ?? '—') ?></td>
                    <td class="px-4 py-3 text-slate-500"><?= (int) $item['sort_order'] ?></td>
                    <td class="px-4 py-3">
                        <span class="rounded-full px-2.5 py-1 text-xs font-semibold <?= ! empty($item['is_active']) ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' ?>">
                            <?= ! empty($item['is_active']) ? 'Active' : 'Inactive' ?>
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right whitespace-nowrap">
                        <a href="<?= site_url('admin/clients/edit/' . $item['id']) ?>" class="text-blue-600 hover:underline">Edit</a>
                        <form method="post" action="<?= site_url('admin/clients/toggle/' . $item['id']) ?>" class="ml-3 inline">
                            <?= csrf_field() ?><button class="text-slate-600 hover:underline"><?= ! empty($item['is_active']) ? 'Deactivate' : 'Activate' ?></button>
                        </form>
                        <form method="post" action="<?= site_url('admin/clients/delete/' . $item['id']) ?>" class="ml-3 inline" onsubmit="return confirm('Delete this client?')">
                            <?= csrf_field() ?><button class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (! $items): ?>
                <tr><td colspan="6" class="px-4 py-10 text-center text-slate-400">No clients have been added yet.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
