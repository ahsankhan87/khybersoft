<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — <?= esc(setting('site_name', 'Khybersoft')) ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/fontawesome-free-7.0.0-web/css/all.min.css') ?>">
    <script src="<?= base_url('assets/css/tailwindcss-3.4.16.css') ?>"></script>
</head>
<body class="min-h-screen bg-slate-950 flex items-center justify-center p-6">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <span class="text-3xl font-extrabold text-white"><?= esc(setting('site_name', 'Khybersoft')) ?><span class="text-blue-500">.</span></span>
            <p class="mt-2 text-sm text-slate-400">Admin Panel</p>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="mb-4 rounded-lg bg-red-500/10 border border-red-500/30 px-4 py-3 text-sm text-red-400">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>
        <?php if ($errors = session()->getFlashdata('errors')): ?>
            <div class="mb-4 rounded-lg bg-red-500/10 border border-red-500/30 px-4 py-3 text-sm text-red-400">
                <?php foreach ((array) $errors as $e): ?><p><?= esc($e) ?></p><?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= site_url('admin/login') ?>" class="rounded-2xl bg-slate-900 p-8 shadow-xl border border-slate-800">
            <?= csrf_field() ?>
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-slate-300">Email address</label>
                    <input type="email" name="email" required autofocus
                           value="<?= old('email') ?>"
                           class="mt-2 w-full rounded-lg bg-slate-800 border border-slate-700 px-4 py-2.5 text-white placeholder:text-slate-500 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                           placeholder="you@khybersoft.com">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300">Password</label>
                    <input type="password" name="password" required
                           class="mt-2 w-full rounded-lg bg-slate-800 border border-slate-700 px-4 py-2.5 text-white focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
                           placeholder="••••••••">
                </div>
                <label class="flex items-center gap-2 text-sm text-slate-400">
                    <input type="checkbox" name="remember" value="1" class="rounded border-slate-600 bg-slate-800 text-blue-600 focus:ring-blue-500">
                    Remember me for 30 days
                </label>
                <button class="w-full rounded-lg bg-blue-600 py-3 text-sm font-semibold text-white transition hover:bg-blue-500">
                    Sign in
                </button>
            </div>
        </form>
        <p class="mt-6 text-center text-xs text-slate-500"><a href="<?= base_url('/') ?>" class="hover:text-slate-300">← Back to website</a></p>
    </div>
</body>
</html>
