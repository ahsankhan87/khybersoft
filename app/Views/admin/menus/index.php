<?= $this->extend('admin/layout/master') ?>
<?= $this->section('content') ?>
<div class="grid gap-8 lg:grid-cols-2">
    <?php foreach ($menus as $menu): ?>
        <div class="rounded-xl bg-white shadow-sm border border-slate-200">
            <div class="border-b border-slate-100 px-6 py-4">
                <h2 class="font-semibold text-slate-900"><?= esc($menu['name']) ?></h2>
                <p class="text-xs uppercase tracking-wide text-slate-400"><?= esc($menu['location']) ?> location</p>
            </div>
            <ul class="divide-y divide-slate-100">
                <?php foreach ($menu['items'] as $item): ?>
                    <li class="px-6 py-3">
                        <form method="post" action="<?= site_url('admin/menus/item/' . $item['id']) ?>" class="flex flex-wrap items-center gap-2">
                            <?= csrf_field() ?>
                            <input name="label" value="<?= esc($item['label']) ?>" class="w-32 rounded border-slate-300 px-2 py-1 text-sm">
                            <input name="url" value="<?= esc($item['url']) ?>" class="flex-1 min-w-[8rem] rounded border-slate-300 px-2 py-1 text-sm">
                            <input name="sort_order" value="<?= (int) $item['sort_order'] ?>" type="number" class="w-16 rounded border-slate-300 px-2 py-1 text-sm">
                            <label class="text-xs text-slate-500"><input type="checkbox" name="is_active" value="1" <?= $item['is_active'] ? 'checked' : '' ?>> active</label>
                            <label class="text-xs text-slate-500"><input type="checkbox" name="is_external" value="1" <?= $item['is_external'] ? 'checked' : '' ?>> ext</label>
                            <button class="rounded bg-slate-900 px-3 py-1 text-xs font-medium text-white">Save</button>
                        </form>
                        <form method="post" action="<?= site_url('admin/menus/item/' . $item['id'] . '/delete') ?>" class="mt-1 inline" onsubmit="return confirm('Delete item?')">
                            <?= csrf_field() ?><button class="text-xs text-red-600 hover:underline">delete</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="border-t border-slate-100 px-6 py-4">
                <form method="post" action="<?= site_url('admin/menus/item') ?>" class="flex flex-wrap items-center gap-2">
                    <?= csrf_field() ?>
                    <input type="hidden" name="menu_id" value="<?= $menu['id'] ?>">
                    <input name="label" placeholder="Label" required class="w-32 rounded border-slate-300 px-2 py-1 text-sm">
                    <input name="url" placeholder="/path or https://…" required class="flex-1 min-w-[8rem] rounded border-slate-300 px-2 py-1 text-sm">
                    <button class="rounded bg-blue-600 px-3 py-1 text-xs font-medium text-white">+ Add item</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<p class="mt-4 text-xs text-slate-400">Header menu renders in the navbar; footer menu in the “Company” column. Toggling “active” hides an item from the site instantly.</p>
<?= $this->endSection() ?>
