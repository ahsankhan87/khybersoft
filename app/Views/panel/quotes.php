<section>
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="flex items-end justify-between">
            <div>
                <h1 class="text-2xl font-bold text-dark">Quote Requests</h1>
                <p class="mt-1 text-sm text-gray-600">Custom Development quote submissions.</p>
            </div>
            <a href="<?= site_url('panel') ?>" class="text-sm font-semibold text-dark hover:text-primary">Back</a>
        </div>

        <div class="mt-8 overflow-x-auto rounded-2xl bg-white border border-gray-100 shadow-sm">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Company</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Phone</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Project Type</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Created</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if (empty($quotes)): ?>
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-sm text-gray-500">No quote requests found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($quotes as $q): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-700"><?= esc($q['id'] ?? '') ?></td>
                                <td class="px-6 py-4 text-sm font-semibold text-dark"><?= esc($q['name'] ?? '') ?></td>
                                <td class="px-6 py-4 text-sm text-gray-700"><?= esc($q['email'] ?? '') ?></td>
                                <td class="px-6 py-4 text-sm text-gray-700"><?= esc($q['company'] ?? '-') ?></td>
                                <td class="px-6 py-4 text-sm text-gray-700"><?= esc($q['phone'] ?? '-') ?></td>
                                <td class="px-6 py-4 text-sm text-gray-700"><?= esc($q['project_type'] ?? '') ?></td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    <div class="max-w-lg whitespace-pre-wrap break-words"><?= esc($q['description'] ?? '') ?></div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500"><?= esc($q['created_at'] ?? '') ?></td>
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