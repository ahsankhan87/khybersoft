<?= $this->extend('admin/layout/master') ?>
<?= $this->section('content') ?>

<div class="flex flex-col gap-6 lg:flex-row">
    <!-- Group tabs -->
    <aside class="lg:w-56 shrink-0">
        <nav class="flex gap-2 overflow-x-auto rounded-xl bg-white p-2 shadow-sm border border-slate-200 lg:flex-col lg:overflow-visible">
            <?php foreach ($groups as $slug => [$label, $icon]): ?>
                <a href="<?= site_url('admin/settings/' . $slug) ?>"
                   class="flex items-center gap-2 whitespace-nowrap rounded-lg px-3 py-2 text-sm font-medium <?= $slug === $group ? 'bg-blue-600 text-white' : 'text-slate-600 hover:bg-slate-100' ?>">
                    <i class="<?= $icon ?>"></i><?= esc($label) ?>
                </a>
            <?php endforeach; ?>
        </nav>
    </aside>

    <!-- Settings form -->
    <form method="post" action="<?= site_url('admin/settings/save/' . $group) ?>" class="flex-1">
        <?= csrf_field() ?>
        <div class="space-y-5 rounded-xl bg-white p-6 shadow-sm border border-slate-200">
            <?php if (! $items): ?>
                <p class="text-sm text-slate-400">No settings in this group yet.</p>
            <?php endif; ?>
            <?php foreach ($items as $s): $name = 'settings[' . $s['key'] . ']'; ?>
                <div>
                    <label class="block text-sm font-medium text-slate-700"><?= esc($s['label'] ?: $s['key']) ?></label>
                    <?php if ($s['type'] === 'textarea'): ?>
                        <textarea name="<?= $name ?>" rows="4" class="mt-1 w-full rounded-lg border-slate-300 px-3 py-2 text-sm"><?= esc($s['value']) ?></textarea>
                    <?php elseif ($s['type'] === 'bool'): ?>
                        <select name="<?= $name ?>" class="mt-1 w-40 rounded-lg border-slate-300 bg-white px-3 py-2 text-sm">
                            <option value="1" <?= $s['value'] === '1' ? 'selected' : '' ?>>Enabled</option>
                            <option value="0" <?= $s['value'] !== '1' ? 'selected' : '' ?>>Disabled</option>
                        </select>
                    <?php elseif ($s['type'] === 'select'): ?>
                        <select name="<?= $name ?>" class="mt-1 w-60 rounded-lg border-slate-300 bg-white px-3 py-2 text-sm">
                            <?php foreach (json_decode((string) $s['options'], true) ?: [] as $opt): ?>
                                <option value="<?= esc($opt) ?>" <?= $s['value'] === $opt ? 'selected' : '' ?>><?= esc($opt) ?></option>
                            <?php endforeach; ?>
                        </select>
                    <?php elseif ($s['type'] === 'image'): ?>
                        <input name="<?= $name ?>" value="<?= esc($s['value']) ?>" placeholder="uploads/logo.png (media library arrives in Phase 2)" class="mt-1 w-full rounded-lg border-slate-300 px-3 py-2 text-sm">
                        <?php if ($s['value']): ?><img src="<?= esc(media_url($s['value'])) ?>" class="mt-2 h-10 rounded border border-slate-200" alt=""><?php endif; ?>
                    <?php else: ?>
                        <input name="<?= $name ?>" value="<?= esc($s['value']) ?>" class="mt-1 w-full rounded-lg border-slate-300 px-3 py-2 text-sm">
                    <?php endif; ?>
                    <p class="mt-1 text-xs text-slate-400"><code><?= esc($s['key']) ?></code></p>
                </div>
            <?php endforeach; ?>

            <?php if ($items): ?>
                <button class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">Save Changes</button>
            <?php endif; ?>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
