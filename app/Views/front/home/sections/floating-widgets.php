<?php /* Floating WhatsApp button + back-to-top */ ?>
<?php $waNum = preg_replace('/\D/', '', setting('whatsapp_number', '')); ?>
<?php if ($waNum): ?>
<a href="https://wa.me/<?= esc($waNum) ?>?text=<?= rawurlencode('Hi Khybersoft! I have a question.') ?>"
   target="_blank" rel="noopener" aria-label="Chat with us on WhatsApp"
   class="fixed bottom-6 right-6 z-40 flex h-14 w-14 items-center justify-center rounded-full bg-[#25D366] text-2xl text-white shadow-glow transition hover:scale-110">
    <i class="fa-brands fa-whatsapp"></i>
    <span class="absolute -right-0.5 -top-0.5 flex h-3.5 w-3.5">
        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
        <span class="relative inline-flex h-3.5 w-3.5 rounded-full bg-emerald-500 ring-2 ring-white"></span>
    </span>
</a>
<?php endif; ?>

<button type="button" id="back-to-top" aria-label="Back to top"
        class="fixed bottom-6 left-6 z-40 flex h-12 w-12 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 opacity-0 shadow-lg transition-all duration-300 hover:border-primary hover:text-primary pointer-events-none">
    <i class="fa-solid fa-arrow-up"></i>
</button>
