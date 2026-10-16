<?= $this->extend('admin/layout/master') ?>
<?= $this->section('content') ?>
<div class="mb-5 flex justify-end">
    <a href="<?= site_url('admin/pages/create') ?>" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700"><i class="fa-solid fa-plus mr-1"></i> New Page</a>
</div>
<div class="overflow-x-auto rounded-xl bg-white shadow-sm border border-slate-200">
    <table class="w-full text-left text-sm">
        <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
            <tr><th class="px-6 py-3">Title</th><th class="px-6 py-3">Slug</th><th class="px-6 py-3">Template</th><th class="px-6 py-3">Status</th><th class="px-6 py-3">Updated</th><th class="px-6 py-3"></th></tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            <?php foreach ($pages as $p): ?>
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-3 font-medium text-slate-900"><?= esc($p['title']) ?></td>
                    <td class="px-6 py-3 text-slate-500">/<?= esc($p['slug']) ?></td>
                    <td class="px-6 py-3 text-slate-500"><?= esc($p['template']) ?></td>
                    <td class="px-6 py-3"><?= $p['is_published'] ? '<span class="text-emerald-600 font-medium">Published</span>' : '<span class="text-slate-400">Draft</span>' ?></td>
                    <td class="px-6 py-3 text-slate-500"><?= esc(format_date($p['updated_at'])) ?></td>
                    <td class="px-6 py-3 text-right space-x-3 whitespace-nowrap">
                        <a href="<?= site_url('admin/pages/edit/' . $p['id']) ?>" class="text-blue-600 hover:underline">Edit</a>
                        <form method="post" action="<?= site_url('admin/pages/delete/' . $p['id']) ?>" class="inline" onsubmit="return confirm('Delete this page?')">
                            <?= csrf_field() ?><button class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
