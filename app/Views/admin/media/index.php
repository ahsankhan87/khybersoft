<?= $this->extend('admin/layout/master') ?>
<?= $this->section('content') ?>

<form method="get" class="mb-5 flex flex-wrap gap-2 rounded-xl border border-slate-200 bg-white p-4">
    <input name="q" value="<?= esc($q ?? '') ?>" placeholder="Search files" class="min-w-48 rounded-lg border-slate-300 text-sm">
    <select name="kind" class="rounded-lg border-slate-300 text-sm"><option value="">All types</option><?php foreach (['image', 'video', 'document'] as $kind): ?><option value="<?= $kind ?>" <?= ($kindFilter ?? '') === $kind ? 'selected' : '' ?>><?= ucfirst($kind) ?></option><?php endforeach; ?></select>
    <select name="folder" class="rounded-lg border-slate-300 text-sm"><option value="">All folders</option><?php foreach ($folders as $folder): ?><option value="<?= esc($folder) ?>" <?= ($folderFilter ?? '') === $folder ? 'selected' : '' ?>><?= esc($folder) ?></option><?php endforeach; ?></select>
    <button class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white">Filter</button>
</form>

<form method="post" action="<?= site_url('admin/media/upload') ?>" enctype="multipart/form-data" class="mb-6 flex flex-wrap items-end gap-3 rounded-xl border border-slate-200 bg-white p-5">
    <?= csrf_field() ?>
    <label class="text-sm font-medium text-slate-700">File (8 MB max)<input type="file" name="file" required class="mt-1 block text-sm"></label>
    <label class="text-sm font-medium text-slate-700">Folder<input name="folder" value="general" class="mt-1 block rounded-lg border-slate-300 text-sm"></label>
    <label class="text-sm font-medium text-slate-700">Alt text<input name="alt_text" class="mt-1 block rounded-lg border-slate-300 text-sm"></label>
    <button class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white">Upload</button>
</form>

<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <?php foreach ($items as $item): ?>
        <article class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <?php if (str_starts_with((string) $item['mime'], 'image/')): ?><img src="<?= base_url($item['thumb_path'] ?: $item['path']) ?>" alt="<?= esc($item['alt_text'] ?? '') ?>" class="h-40 w-full bg-slate-100 object-cover"><?php else: ?><div class="flex h-40 items-center justify-center bg-slate-100 text-slate-500"><i class="fa-solid <?= $item['kind'] === 'video' ? 'fa-video' : 'fa-file-lines' ?> text-4xl"></i></div><?php endif; ?>
            <div class="p-4"><p class="truncate text-sm font-semibold text-slate-800" title="<?= esc($item['name']) ?>"><?= esc($item['name']) ?></p><p class="mt-1 text-xs text-slate-500"><?= esc($item['folder']) ?> · <?= number_format((int) $item['size_kb']) ?> KB</p><div class="mt-3 flex items-center justify-between"><a href="<?= base_url($item['path']) ?>" target="_blank" rel="noopener" class="text-sm text-blue-600 hover:underline">Open</a><form method="post" action="<?= site_url('admin/media/delete/' . $item['id']) ?>" onsubmit="return confirm('Delete this file?')"><?= csrf_field() ?><button class="text-sm text-red-600 hover:underline">Delete</button></form></div></div>
        </article>
    <?php endforeach; ?>
    <?php if (! $items): ?><p class="col-span-full rounded-xl border border-dashed border-slate-300 bg-white p-10 text-center text-slate-400">No media files found.</p><?php endif; ?>
</div>

<?= $this->endSection() ?>
