<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password — <?= esc(setting('site_name', 'Khybersoft')) ?></title>
    <script src="<?= base_url('assets/css/tailwindcss-3.4.16.css') ?>"></script>
</head>
<body class="min-h-screen bg-slate-950 flex items-center justify-center p-6">
    <main class="w-full max-w-md">
        <header class="text-center mb-8">
            <span class="text-3xl font-extrabold text-white"><?= esc(setting('site_name', 'Khybersoft')) ?><span class="text-blue-500">.</span></span>
            <p class="mt-2 text-sm text-slate-400">Reset your admin password</p>
        </header>
        <?php if ($message = session()->getFlashdata('success')): ?>
            <div class="mb-4 rounded-lg bg-emerald-500/10 border border-emerald-500/30 px-4 py-3 text-sm text-emerald-300"><?= esc($message) ?></div>
        <?php endif; ?>
        <?php if ($error = session()->getFlashdata('error')): ?>
            <div class="mb-4 rounded-lg bg-red-500/10 border border-red-500/30 px-4 py-3 text-sm text-red-400"><?= esc($error) ?></div>
        <?php endif; ?>
        <?php if ($resetLink = session()->getFlashdata('local_reset_link')): ?>
            <div class="mb-4 rounded-lg bg-blue-500/10 border border-blue-500/30 px-4 py-4 text-sm text-blue-200">
                <p class="font-semibold">Local development reset link</p>
                <a class="mt-2 block break-all underline" href="<?= esc($resetLink) ?>"><?= esc($resetLink) ?></a>
                <p class="mt-2 text-xs text-blue-200/70">This link expires in one hour.</p>
            </div>
        <?php endif; ?>
        <form method="post" action="<?= site_url('admin/login/forgot') ?>" class="rounded-2xl bg-slate-900 p-8 shadow-xl border border-slate-800">
            <?= csrf_field() ?>
            <label for="email" class="block text-sm font-medium text-slate-300">Admin email address</label>
            <input id="email" type="email" name="email" required autocomplete="email" value="<?= esc(old('email')) ?>" class="mt-2 w-full rounded-lg bg-slate-800 border border-slate-700 px-4 py-2.5 text-white focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
            <button class="mt-5 w-full rounded-lg bg-blue-600 py-3 text-sm font-semibold text-white transition hover:bg-blue-500">Send reset link</button>
        </form>
        <p class="mt-5 text-center text-sm"><a href="<?= site_url('admin/login') ?>" class="text-blue-400 hover:text-blue-300">Back to sign in</a></p>
    </main>
</body>
</html>
