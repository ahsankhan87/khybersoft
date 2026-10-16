<?= $this->extend('admin/layout/master') ?>
<?= $this->section('content') ?>

<div class="mb-5 grid gap-4 sm:grid-cols-3">
    <div class="rounded-xl bg-white p-4 shadow-sm border border-slate-200"><p class="text-sm text-slate-500">Total</p><p class="text-2xl font-bold"><?= (int) $total ?></p></div>
    <div class="rounded-xl bg-white p-4 shadow-sm border border-slate-200"><p class="text-sm text-slate-500">Confirmed</p><p class="text-2xl font-bold text-emerald-600"><?= (int) $confirmed ?></p></div>
    <div class="rounded-xl bg-white p-4 shadow-sm border border-slate-200 flex items-end justify-end"><a href="<?= site_url('admin/subscribers/export') ?>" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium hover:bg-slate-50"><i class="fa-solid fa-file-csv mr-1"></i>Export CSV</a></div>
</div>

<form method="get" class="mb-5 flex gap-2 max-w-md">
    <input name="q" value="<?= esc($q ?? '') ?>" placeholder="Search email or name…" class="flex-1 rounded-lg border-slate-300 px-3 py-2 text-sm">
    <button class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white">Search</button>
</form>

<div class="overflow-x-auto rounded-xl bg-white shadow-sm border border-slate-200">
    <table class="w-full text-left text-sm">
        <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
            <tr><th class="px-6 py-3">Email</th><th class="px-6 py-3">Name</th><th class="px-6 py-3">Status</th><th class="px-6 py-3">Joined</th><th class="px-6 py-3"></th></tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            <?php if (! $subs): ?>
                <tr><td colspan="5" class="px-6 py-10 text-center text-slate-400">No subscribers found.</td></tr>
            <?php endif; ?>
            <?php foreach ($subs as $s): ?>
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-3 font-medium text-slate-900"><?= esc($s['email']) ?></td>
                    <td class="px-6 py-3 text-slate-600"><?= esc($s['name'] ?: '—') ?></td>
                    <td class="px-6 py-3">
                        <form method="post" action="<?= site_url('admin/subscribers/status/' . $s['id']) ?>" class="flex items-center gap-2">
                            <?= csrf_field() ?>
                            <select name="status" onchange="this.form.submit()" class="rounded border-slate-300 py-1 text-xs capitalize">
                                <?php foreach (['pending', 'confirmed', 'unsubscribed'] as $st): ?>
                                    <option value="<?= $st ?>" <?= ($s['status'] ?? 'confirmed') === $st ? 'selected' : '' ?>><?= ucfirst($st) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </form>
                    </td>
                    <td class="px-6 py-3 text-slate-500"><?= esc(format_date($s['created_at'])) ?></td>
                    <td class="px-6 py-3 text-right">
                        <form method="post" action="<?= site_url('admin/subscribers/delete/' . $s['id']) ?>" onsubmit="return confirm('Delete this subscriber?')">
                            <?= csrf_field() ?><button class="text-red-600 hover:underline text-xs">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php if (isset($pager) && $pager): ?>
    <div class="mt-5 flex justify-center"><?= $pager->links() ?></div>
<?php endif; ?>

<?= $this->endSection() ?>
