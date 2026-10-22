<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose New Password — <?= esc(setting('site_name', 'Khybersoft')) ?></title>
    <script src="<?= base_url('assets/css/tailwindcss-3.4.16.css') ?>"></script>
</head>
<body class="min-h-screen bg-slate-950 flex items-center justify-center p-6">
    <main class="w-full max-w-md">
        <header class="text-center mb-8">
            <span class="text-3xl font-extrabold text-white"><?= esc(setting('site_name', 'Khybersoft')) ?><span class="text-blue-500">.</span></span>
            <p class="mt-2 text-sm text-slate-400">Choose a new admin password</p>
        </header>
        <?php if ($errors = session()->getFlashdata('errors')): ?>
            <div class="mb-4 rounded-lg bg-red-500/10 border border-red-500/30 px-4 py-3 text-sm text-red-400">
                <?php foreach ((array) $errors as $error): ?><p><?= esc($error) ?></p><?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form method="post" action="<?= site_url('admin/reset-password') ?>" class="rounded-2xl bg-slate-900 p-8 shadow-xl border border-slate-800">
            <?= csrf_field() ?>
            <input type="hidden" name="token" value="<?= esc($token) ?>">
            <p class="mb-5 text-sm text-slate-400">Resetting password for <?= esc($email) ?></p>
            <label for="password" class="block text-sm font-medium text-slate-300">New password</label>
            <input id="password" type="password" name="password" required minlength="8" autocomplete="new-password" class="mt-2 w-full rounded-lg bg-slate-800 border border-slate-700 px-4 py-2.5 text-white focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
            <button class="mt-5 w-full rounded-lg bg-blue-600 py-3 text-sm font-semibold text-white transition hover:bg-blue-500">Update password</button>
        </form>
    </main>
</body>
</html>
