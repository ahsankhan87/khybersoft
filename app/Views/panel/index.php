<section>
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="flex items-end justify-between">
            <div>
                <h1 class="text-2xl font-bold text-dark">Dashboard</h1>
                <p class="mt-1 text-sm text-gray-600">View quote requests, contact messages, and subscribers.</p>
            </div>
        </div>

        <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <a href="<?= site_url('panel/quotes') ?>" class="block rounded-2xl bg-white border border-gray-100 shadow-sm p-6 hover:border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-600">Quote Requests</p>
                        <p class="mt-2 text-3xl font-bold text-dark"><?= esc($counts['quotes'] ?? 0) ?></p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fa-solid fa-file-signature text-primary"></i>
                    </div>
                </div>
            </a>

            <a href="<?= site_url('panel/contacts') ?>" class="block rounded-2xl bg-white border border-gray-100 shadow-sm p-6 hover:border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-600">Contact Messages</p>
                        <p class="mt-2 text-3xl font-bold text-dark"><?= esc($counts['contacts'] ?? 0) ?></p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                        <i class="fa-solid fa-envelope text-primary"></i>
                    </div>
                </div>
            </a>

            <a href="<?= site_url('panel/subscribers') ?>" class="block rounded-2xl bg-white border border-gray-100 shadow-sm p-6 hover:border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-600">Subscribers</p>
                        <p class="mt-2 text-3xl font-bold text-dark"><?= esc($counts['subscribers'] ?? 0) ?></p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center">
                        <i class="fa-solid fa-users text-primary"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>