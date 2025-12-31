<section>
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-md">
            <h1 class="text-2xl font-bold text-dark">Panel Login</h1>
            <p class="mt-1 text-sm text-gray-600">Enter your admin credentials.</p>

            <div class="mt-6 rounded-2xl bg-white border border-gray-100 shadow-sm p-6">
                <?php if (session()->has('error')): ?>
                    <div class="rounded-md bg-red-50 p-4 mb-4">
                        <p class="text-sm font-medium text-red-800"><?= session('error') ?></p>
                    </div>
                <?php endif; ?>

                <?php if (session()->has('errors')): ?>
                    <div class="rounded-md bg-red-50 p-4 mb-4">
                        <?php foreach (session('errors') as $error): ?>
                            <p class="text-sm font-medium text-red-800"><?= $error ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="<?= site_url('panel/login') ?>" class="space-y-4">
                    <?= csrf_field() ?>

                    <div>
                        <label for="username" class="block text-sm font-semibold text-dark">Username</label>
                        <input type="text" name="username" id="username" value="<?= old('username') ?>" required class="mt-1 block w-full rounded-md border-0 bg-white px-3 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6" placeholder="admin">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-dark">Password</label>
                        <input type="password" name="password" id="password" required class="mt-1 block w-full rounded-md border-0 bg-white px-3 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6" placeholder="••••••••">
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="rounded-md bg-primary px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#1e3a8a] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary">
                            Sign in
                        </button>
                        <a href="<?= site_url('/') ?>" class="text-sm font-semibold text-dark hover:text-primary">Back to site</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>