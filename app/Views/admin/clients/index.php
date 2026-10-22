<?= $this->extend('admin/layout/master') ?>
<?= $this->section('content') ?>

<div class="grid gap-6 lg:grid-cols-3">
    <form method="post" action="<?= site_url('admin/clients/save') ?>" class="space-y-4 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <?= csrf_field() ?>
        <h2 class="font-semibold text-slate-900">Add client</h2>
        <label class="block text-sm font-medium text-slate-700">Company name
            <input name="company_name" required maxlength="150" class="mt-1 w-full rounded-lg border-slate-300" />
        </label>
        <label class="block text-sm font-medium text-slate-700">Logo path or URL
            <input name="logo" class="mt-1 w-full rounded-lg border-slate-300" />
        </label>
        <label class="block text-sm font-medium text-slate-700">Website
            <input name="website" type="url" class="mt-1 w-full rounded-lg border-slate-300" />
        </label>
        <label class="block text-sm font-medium text-slate-700">Industry
            <input name="industry" class="mt-1 w-full rounded-lg border-slate-300" />
        </label>
        <label class="block text-sm font-medium text-slate-700">Sort order
            <input name="sort_order" type="number" value="0" class="mt-1 w-full rounded-lg border-slate-300" />
        </label>
        <label class="flex items-center gap-2 text-sm text-slate-700"><input type="checkbox" name="is_active" value="1" checked> Active</label>
        <button class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white">Save client</button>
    </form>

    <div class="overflow-x-auto rounded-xl border border-slate-200 bg-white shadow-sm lg:col-span-2">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs uppercase text-slate-500"><tr><th class="px-4 py-3">Company</th><th class="px-4 py-3">Industry</th><th class="px-4 py-3">Status</th><th class="px-4 py-3"></th></tr></thead>
            <tbody class="divide-y divide-slate-100">
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td class="px-4 py-3 font-medium text-slate-900"><?= esc($item['company_name']) ?></td>
                        <td class="px-4 py-3 text-slate-600"><?= esc($item['industry'] ?? '') ?></td>
                        <td class="px-4 py-3"><?= ! empty($item['is_active']) ? 'Active' : 'Inactive' ?></td>
                        <td class="px-4 py-3 text-right">
                            <form method="post" action="<?= site_url('admin/clients/toggle/' . $item['id']) ?>" class="inline">
                                <?= csrf_field() ?><button class="text-blue-600 hover:underline">Toggle</button>
                            </form>
                            <form method="post" action="<?= site_url('admin/clients/delete/' . $item['id']) ?>" class="ml-3 inline" onsubmit="return confirm('Delete this client?')">
                                <?= csrf_field() ?><button class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (! $items): ?><tr><td colspan="4" class="px-4 py-8 text-center text-slate-400">No clients have been added.</td></tr><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
