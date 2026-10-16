<section class="mx-auto max-w-xl px-6 py-24 text-center">
    <h1 class="text-3xl font-extrabold tracking-tight text-slate-900"><?= esc($heading ?? 'Done!') ?></h1>
    <p class="mt-4 text-lg leading-8 text-slate-600"><?= esc($message ?? '') ?></p>
    <a href="<?= base_url('/') ?>" class="mt-8 inline-block rounded-lg bg-primary px-6 py-3 text-sm font-semibold text-white hover:bg-blue-700">Back to home</a>
</section>
