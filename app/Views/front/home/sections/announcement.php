<?php /* Section 1 — Announcement bar (admin-toggleable, closeable via localStorage) */ ?>
<?php if (setting('announcement_enabled', '0') === '1' && trim(setting('announcement_text')) !== ''): ?>
<div id="announcement-bar"
     data-hash="<?= substr(md5(setting('announcement_text')), 0, 8) ?>"
     class="relative z-[60] bg-gradient-to-r from-primary via-violet to-primary text-white">
    <div class="mx-auto flex max-w-7xl items-center justify-center gap-3 px-4 py-2.5 text-center text-sm font-medium">
        <a href="<?= esc(site_url_path(setting('announcement_link') ?: '#')) ?>" class="hover:underline">
            <?= esc(setting('announcement_text')) ?>
        </a>
        <button type="button" data-close-announcement aria-label="Dismiss announcement"
                class="absolute right-3 top-1/2 -translate-y-1/2 rounded-full p-1.5 text-white/70 transition hover:bg-white/15 hover:text-white">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
</div>
<?php endif; ?>
