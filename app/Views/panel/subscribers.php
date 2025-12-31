<section>
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="flex items-end justify-between">
            <div>
                <h1 class="text-2xl font-bold text-dark">Subscribers</h1>
                <p class="mt-1 text-sm text-gray-600">Newsletter subscribers list.</p>
            </div>
            <a href="<?= site_url('panel') ?>" class="text-sm font-semibold text-dark hover:text-primary">Back</a>
        </div>

        <div class="mt-8 overflow-x-auto rounded-2xl bg-white border border-gray-100 shadow-sm">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Created</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if (empty($subscribers)): ?>
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500">No subscribers found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($subscribers as $s): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-700"><?= esc($s['id'] ?? '') ?></td>
                                <td class="px-6 py-4 text-sm text-gray-700"><?= esc($s['email'] ?? '') ?></td>
                                <td class="px-6 py-4 text-sm text-gray-700"><?= esc($s['name'] ?? '-') ?></td>
                                <td class="px-6 py-4 text-sm text-gray-500"><?= esc($s['created_at'] ?? '') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            <?= $pager->links($pagerGroup, 'default_full') ?>
        </div>
    </div>
</section>