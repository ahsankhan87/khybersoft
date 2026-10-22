<?= $this->extend('admin/layout/master') ?>
<?= $this->section('content') ?>
<div class="grid gap-6 lg:grid-cols-3">
    <form method="post" action="<?= site_url('admin/tutorial-categories/save') ?>" class="space-y-4 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <?= csrf_field() ?><h2 class="font-semibold text-slate-900">Add category</h2>
        <label class="block text-sm font-medium text-slate-700">Name<input name="name" required maxlength="100" class="mt-1 w-full rounded-lg border-slate-300"></label>
        <label class="block text-sm font-medium text-slate-700">Slug<input name="slug" required class="mt-1 w-full rounded-lg border-slate-300"></label>
        <label class="block text-sm font-medium text-slate-700">Icon class<input name="icon" placeholder="fa-solid fa-book" class="mt-1 w-full rounded-lg border-slate-300"></label>
        <label class="block text-sm font-medium text-slate-700">Sort order<input name="sort_order" type="number" value="0" class="mt-1 w-full rounded-lg border-slate-300"></label>
        <button class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white">Save category</button>
    </form>
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm lg:col-span-2">
        <table class="w-full text-left text-sm"><thead class="bg-slate-50 text-xs uppercase text-slate-500"><tr><th class="px-4 py-3">Name</th><th class="px-4 py-3">Slug</th><th class="px-4 py-3">Order</th><th></th></tr></thead><tbody class="divide-y divide-slate-100">
        <?php foreach ($categories as $category): ?><tr><td class="px-4 py-3 font-medium"><?= esc($category['name']) ?></td><td class="px-4 py-3 text-slate-500"><?= esc($category['slug']) ?></td><td class="px-4 py-3"><?= (int) $category['sort_order'] ?></td><td class="px-4 py-3 text-right"><form method="post" action="<?= site_url('admin/tutorial-categories/delete/' . $category['id']) ?>" onsubmit="return confirm('Delete this category?')"><?= csrf_field() ?><button class="text-red-600 hover:underline">Delete</button></form></td></tr><?php endforeach; ?>
        <?php if (! $categories): ?><tr><td colspan="4" class="px-4 py-8 text-center text-slate-400">No categories yet.</td></tr><?php endif; ?>
        </tbody></table>
    </div>
</div>
<?= $this->endSection() ?>
