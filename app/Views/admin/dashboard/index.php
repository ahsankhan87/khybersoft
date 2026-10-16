<?= $this->extend('admin/layout/master') ?>
<?= $this->section('content') ?>

<div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
    <?php
      $cards = [
          ['New Leads', $newLeads, 'fa-solid fa-inbox', 'bg-blue-600'],
          ['Open Quote Requests', $quoteLeads, 'fa-solid fa-file-signature', 'bg-amber-500'],
          ['Subscribers', $subscribers, 'fa-solid fa-envelope-open-text', 'bg-emerald-600'],
          ['View Site', null, 'fa-solid fa-arrow-up-right-from-square', 'bg-slate-700'],
      ];
    ?>
    <?php foreach ($cards as [$label, $value, $icon, $color]): ?>
        <div class="rounded-xl bg-white p-5 shadow-sm border border-slate-200 flex items-center gap-4">
            <span class="flex h-12 w-12 items-center justify-center rounded-lg <?= $color ?> text-white"><i class="<?= $icon ?>"></i></span>
            <div>
                <p class="text-sm text-slate-500"><?= esc($label) ?></p>
                <p class="text-2xl font-bold text-slate-900"><?= $value === null ? '↗' : (int) $value ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="mt-8 rounded-xl bg-white shadow-sm border border-slate-200">
    <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
        <h2 class="font-semibold text-slate-900">Recent leads & inquiries</h2>
        <a href="<?= site_url('admin/leads') ?>" class="text-sm font-medium text-blue-600 hover:underline">View all →</a>
    </div>
    <table class="w-full text-left text-sm">
        <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
            <tr><th class="px-6 py-3">Type</th><th class="px-6 py-3">Name</th><th class="px-6 py-3">Email</th><th class="px-6 py-3">Subject</th><th class="px-6 py-3">Status</th><th class="px-6 py-3">Date</th></tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            <?php if (! $recentLeads): ?>
                <tr><td colspan="6" class="px-6 py-10 text-center text-slate-400">No leads yet. Submissions from the contact & quote forms will appear here.</td></tr>
            <?php endif; ?>
            <?php foreach ($recentLeads as $lead): ?>
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-3"><span class="rounded-full bg-blue-50 px-2.5 py-1 text-xs font-medium capitalize text-blue-700"><?= esc($lead['type']) ?></span></td>
                    <td class="px-6 py-3 font-medium text-slate-900"><?= esc($lead['name'] ?: '—') ?></td>
                    <td class="px-6 py-3 text-slate-600"><?= esc($lead['email']) ?></td>
                    <td class="px-6 py-3 text-slate-600"><?= esc(str_limit($lead['subject'] ?? '', 40)) ?></td>
                    <td class="px-6 py-3"><span class="capitalize <?= $lead['status'] === 'new' ? 'text-amber-600 font-semibold' : 'text-slate-500' ?>"><?= esc($lead['status']) ?></span></td>
                    <td class="px-6 py-3 text-slate-500"><?= esc(format_date($lead['created_at'])) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php if (($roleSlug ?? '') !== 'super_admin'): ?>
<p class="mt-6 text-xs text-slate-400">Signed in as <?= esc($adminUser['email'] ?? '') ?> · role: <?= esc(str_replace('_', ' ', $roleSlug ?? '')) ?></p>
<?php endif; ?>

<?= $this->endSection() ?>
