<?= $this->extend('admin/layout/master') ?>
<?= $this->section('content') ?>

<div class="mb-5 flex flex-wrap items-center gap-3">
    <form method="get" class="flex flex-wrap items-center gap-2">
        <select name="type" class="rounded-lg border-slate-300 bg-white px-3 py-2 text-sm">
            <option value="">All types</option>
            <?php foreach (['contact','quote','demo','trial','other'] as $t): ?>
                <option value="<?= $t ?>" <?= $filterType === $t ? 'selected' : '' ?>><?= ucfirst($t) ?></option>
            <?php endforeach; ?>
        </select>
        <select name="status" class="rounded-lg border-slate-300 bg-white px-3 py-2 text-sm">
            <option value="">All statuses</option>
            <?php foreach (['new','read','replied','closed','spam'] as $s): ?>
                <option value="<?= $s ?>" <?= $filterStatus === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
            <?php endforeach; ?>
        </select>
        <button class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">Filter</button>
    </form>
    <a href="<?= site_url('admin/leads/export') ?>" class="ml-auto rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
        <i class="fa-solid fa-file-csv mr-1"></i> Export CSV
    </a>
</div>

<div class="overflow-x-auto rounded-xl bg-white shadow-sm border border-slate-200">
    <table class="w-full text-left text-sm">
        <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
            <tr><th class="px-6 py-3">Name</th><th class="px-6 py-3">Email</th><th class="px-6 py-3">Type</th><th class="px-6 py-3">Subject</th><th class="px-6 py-3">Status</th><th class="px-6 py-3">Date</th><th class="px-6 py-3"></th></tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            <?php if (! $leads): ?>
                <tr><td colspan="7" class="px-6 py-12 text-center text-slate-400">No leads found.</td></tr>
            <?php endif; ?>
            <?php foreach ($leads as $lead): ?>
                <tr class="hover:bg-slate-50 <?= $lead['status'] === 'new' ? 'font-medium' : '' ?>">
                    <td class="px-6 py-3 text-slate-900"><?= esc($lead['name'] ?: '—') ?><?php if ($lead['company']): ?><span class="block text-xs font-normal text-slate-400"><?= esc($lead['company']) ?></span><?php endif; ?></td>
                    <td class="px-6 py-3 text-slate-600"><?= esc($lead['email']) ?></td>
                    <td class="px-6 py-3"><span class="rounded-full bg-blue-50 px-2.5 py-1 text-xs capitalize text-blue-700"><?= esc($lead['type']) ?></span></td>
                    <td class="px-6 py-3 text-slate-600"><?= esc(str_limit($lead['subject'] ?? '', 45)) ?></td>
                    <td class="px-6 py-3 capitalize <?= $lead['status'] === 'new' ? 'text-amber-600 font-semibold' : 'text-slate-500' ?>"><?= esc($lead['status']) ?></td>
                    <td class="px-6 py-3 text-slate-500"><?= esc(format_date($lead['created_at'])) ?></td>
                    <td class="px-6 py-3 text-right"><a href="<?= site_url('admin/leads/' . $lead['id']) ?>" class="text-blue-600 hover:underline">Open</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="mt-4"><?= $pager->links() ?? '' ?></div>
<?= $this->endSection() ?>
