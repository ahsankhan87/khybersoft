<?= $this->extend('admin/layout/master') ?>
<?= $this->section('content') ?>
<div class="max-w-3xl">
    <a href="<?= site_url('admin/leads') ?>" class="text-sm text-blue-600 hover:underline">← Back to leads</a>

    <div class="mt-4 rounded-xl bg-white p-6 shadow-sm border border-slate-200">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="text-lg font-bold text-slate-900"><?= esc($lead['name'] ?: $lead['email']) ?></h2>
                <p class="text-sm text-slate-500"><?= esc($lead['email']) ?> <?php if ($lead['phone']): ?> · <?= esc($lead['phone']) ?><?php endif; ?></p>
                <?php if ($lead['company']): ?><p class="text-sm text-slate-500"><?= esc($lead['company']) ?></p><?php endif; ?>
            </div>
            <span class="rounded-full px-3 py-1 text-xs font-semibold uppercase capitalize <?= $lead['status'] === 'new' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-600' ?>"><?= esc($lead['status']) ?></span>
        </div>

        <hr class="my-5 border-slate-100">
        <p class="text-sm font-medium text-slate-700"><?= esc($lead['subject'] ?: '(no subject)') ?> · <span class="capitalize font-normal text-slate-400"><?= esc($lead['type']) ?></span> · <?= esc(format_datetime($lead['created_at'])) ?></p>
        <div class="mt-3 whitespace-pre-line text-sm leading-6 text-slate-700"><?= esc($lead['message'] ?: '(no message)') ?></div>

        <?php if (! empty($lead['extra'])): ?>
            <hr class="my-5 border-slate-100">
            <h3 class="text-xs font-semibold uppercase tracking-wide text-slate-500">Details</h3>
            <dl class="mt-2 grid grid-cols-2 gap-2 text-sm">
                <?php foreach ((array) $lead['extra'] as $k => $v): ?>
                    <div class="rounded bg-slate-50 px-3 py-2"><dt class="text-xs uppercase text-slate-400"><?= esc($k) ?></dt><dd class="text-slate-700"><?= esc(is_array($v) ? json_encode($v) : $v) ?></dd></div>
                <?php endforeach; ?>
            </dl>
        <?php endif; ?>

        <?php if (! empty($lead['utm'])): ?>
            <p class="mt-4 text-xs text-slate-400">UTM: <?= esc(http_build_query((array) $lead['utm'])) ?></p>
        <?php endif; ?>
        <?php if ($lead['source_page']): ?><p class="text-xs text-slate-400">Source: <?= esc($lead['source_page']) ?></p><?php endif; ?>
    </div>

    <div class="mt-5 flex flex-wrap gap-3">
        <?php foreach (['read' => 'Mark as read', 'replied' => 'Replied', 'closed' => 'Closed', 'spam' => 'Spam'] as $st => $label): ?>
            <form method="post" action="<?= site_url('admin/leads/' . $lead['id'] . '/status') ?>">
                <?= csrf_field() ?>
                <input type="hidden" name="status" value="<?= $st ?>">
                <button class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50"><?= $label ?></button>
            </form>
        <?php endforeach; ?>
        <a href="mailto:<?= esc($lead['email']) ?>?subject=Re: <?= rawurlencode($lead['subject'] ?? 'Your inquiry') ?>" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">Reply by email</a>
        <form method="post" action="<?= site_url('admin/leads/' . $lead['id'] . '/delete') ?>" onsubmit="return confirm('Delete this lead?')">
            <?= csrf_field() ?>
            <button class="rounded-lg border border-red-200 bg-white px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50">Delete</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
