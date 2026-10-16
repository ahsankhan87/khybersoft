<?php

declare(strict_types=1);

use App\Models\Admin\SettingModel;

if (! function_exists('setting')) {
    function setting(string $key, string $default = ''): string
    {
        return SettingModel::get($key, $default);
    }
}

if (! function_exists('site_url_path')) {
    /** Resolve a menu url (internal path or external) to an href. */
    function site_url_path(?string $url): string
    {
        if ($url === null || $url === '') {
            return '#';
        }
        if (preg_match('#^https?://#i', $url)) {
            return $url;
        }

        return rtrim(base_url(), '/') . '/' . ltrim($url, '/');
    }
}

if (! function_exists('nav_active')) {
    /** Returns 'active' styling class when item matches current path. */
    function nav_active(?string $url, string $currentPath): string
    {
        $p = '/' . ltrim((string) $url, '/');
        if ($p === '/' && $currentPath === '/') {
            return 'text-primary font-semibold';
        }
        if ($p !== '/' && str_starts_with($currentPath, $p)) {
            return 'text-primary font-semibold';
        }

        return 'text-gray-700 hover:text-primary';
    }
}

if (! function_exists('media_url')) {
    function media_url(?string $path): ?string
    {
        if (! $path) {
            return null;
        }
        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }

        return rtrim(base_url(), '/') . '/uploads/' . ltrim($path, '/');
    }
}

if (! function_exists('brand_logo')) {
    /** Logo from settings, falling back to wordmark. */
    function brand_logo(): string
    {
        $logo = setting('logo_light');
        if ($logo) {
            $img = media_url($logo);

            return '<img src="' . esc($img) . '" alt="' . esc(setting('site_name')) . '" class="h-9 w-auto">';
        }

        return '<span class="text-2xl font-extrabold tracking-tight text-slate-900">'
            . esc(setting('site_name', 'Khybersoft'))
            . '<span class="text-blue-600">.</span></span>';
    }
}

if (! function_exists('design_class')) {
    /**
     * Return a canonical component class string from Config\Design tokens.
     * Usage: class="<?= design_class('btn-primary') ?>"
     */
    function design_class(string $name): string
    {
        static $config = null;
        $config ??= new \Config\Design();

        return $config->components[$name] ?? '';
    }
}

if (! function_exists('tailwind_theme_json')) {
    /**
     * JSON-encoded theme.extend block generated from Config\Design — keeps
     * front + admin Tailwind configs perfectly in sync.
     */
    function tailwind_theme_json(): string
    {
        static $json = null;
        if ($json === null) {
            $json = json_encode((new \Config\Design())->tailwindTheme(), JSON_UNESCAPED_SLASHES);
        }

        return $json;
    }
}
