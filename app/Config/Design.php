<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Khybersoft DESIGN TOKENS — single source of truth.
 *
 * Injected into the Tailwind CDN config in Views/layout/partials/head.php
 * (front) and Views/admin/layout/master.php (panel). When migrating to a
 * Vite/Tailwind CLI build, generate tailwind.config.js from this class so
 * tokens never drift between runtime and build-time.
 */
class Design extends BaseConfig
{
    /* ---------------------------------------------------------------- Colors */
    public array $colors = [
        // Primary solid + full ramp (legacy `primary-*` utilities used across views)
        'primary'    => '#4F46E5',
        'primary-50'  => '#EEF2FF',
        'primary-100' => '#E0E7FF',
        'primary-200' => '#C7D2FE',
        'primary-300' => '#A5B4FC',
        'primary-400' => '#818CF8',
        'primary-500' => '#6366F1',
        'primary-600' => '#4F46E5',
        'primary-700' => '#4338CA',
        'primary-800' => '#3730A3',
        // Token aliases (new canonical names)
        'brand'       => '#4F46E5',          // Primary solid
        'brand-50'    => '#EEF2FF',
        'brand-100'   => '#E0E7FF',
        'brand-200'   => '#C7D2FE',
        'brand-500'   => '#6366F1',
        'brand-600'   => '#4F46E5',
        'brand-700'   => '#4338CA',
        'violet'      => '#7C3AED',          // Gradient end
        'violet-100'  => '#EDE9FE',
        'accent'      => '#10B981',          // Emerald — trust/success
        'warning'     => '#F59E0B',          // Amber
        'danger'      => '#EF4444',
        'navy'        => '#0B1220',          // Dark bg
        'ink'         => '#111827',          // Text primary
        'muted'       => '#6B7280',          // Text secondary
        'line'        => '#E5E7EB',          // Border
        'surface'     => '#F9FAFB',          // Light bg
    ];

    /** Primary gradient stops (bg-gradient-to-r from-brand to-violet). */
    public string $gradientFrom = '#4F46E5';
    public string $gradientTo   = '#7C3AED';

    /* ----------------------------------------------------------- Typography */
    public array $fontFamily = [
        'sans'    => ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
        'display' => ['"Plus Jakarta Sans"', 'Inter', 'ui-sans-serif', 'sans-serif'],
    ];

    /** Type scale: display 4–5rem, h1 3rem, h2 2.25rem, h3 1.5rem, body 1rem, small .875rem */
    public array $fontSize = [
        'display' => ['4rem',   ['lineHeight' => '1.05', 'letterSpacing' => '-0.03em', 'fontWeight' => '800']],
        'display-lg' => ['5rem', ['lineHeight' => '1.02', 'letterSpacing' => '-0.03em', 'fontWeight' => '800']],
        'h1'      => ['3rem',   ['lineHeight' => '1.1',  'letterSpacing' => '-0.025em', 'fontWeight' => '800']],
        'h2'      => ['2.25rem',['lineHeight' => '1.2',  'letterSpacing' => '-0.02em',  'fontWeight' => '700']],
        'h3'      => ['1.5rem', ['lineHeight' => '1.35', 'letterSpacing' => '-0.01em',  'fontWeight' => '700']],
        'body'    => ['1rem',   ['lineHeight' => '1.65']],
        'small'   => ['0.875rem', ['lineHeight' => '1.55']],
    ];

    /* -------------------------------------------------------------- Spacing */
    public string $sectionPadding = 'py-20 md:py-28 lg:py-32';   // utility preset
    public string $container      = 'max-w-7xl mx-auto px-4 sm:px-6 lg:px-8';

    /* --------------------------------------------------- Component recipes */
    /**
     * Canonical class strings. Use design_class('btn-primary') in views so a
     * token change here propagates everywhere.
     */
    public array $components = [
        'btn'           => 'inline-flex items-center justify-center gap-2 rounded-xl px-6 py-3 text-sm font-semibold transition-all duration-200 hover:scale-[1.02] focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-500 focus-visible:ring-offset-2 disabled:opacity-50 disabled:hover:scale-100',
        'btn-primary'   => 'inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-brand to-violet px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-500/25 transition-all duration-200 hover:scale-[1.02] hover:shadow-xl hover:shadow-indigo-500/30 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-500 focus-visible:ring-offset-2',
        'btn-secondary' => 'inline-flex items-center justify-center gap-2 rounded-xl border border-line bg-white px-6 py-3 text-sm font-semibold text-ink shadow-sm transition-all duration-200 hover:scale-[1.02] hover:border-brand-200 hover:text-brand focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-500',
        'btn-accent'    => 'inline-flex items-center justify-center gap-2 rounded-xl bg-accent px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-500/25 transition-all duration-200 hover:scale-[1.02] hover:brightness-110',
        'card'          => 'rounded-3xl border border-gray-200 bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl',
        'card-glass'    => 'rounded-3xl border border-white/20 bg-white/80 p-6 shadow-soft backdrop-blur-xl',
        'gradient-text' => 'bg-gradient-to-r from-brand to-violet bg-clip-text text-transparent',
        'badge'         => 'inline-flex items-center gap-1.5 rounded-full border border-line bg-surface px-3 py-1 text-xs font-semibold text-muted',
        'eyebrow'       => 'text-sm font-bold uppercase tracking-widest text-brand',
        'link'          => 'font-semibold text-brand transition hover:text-violet hover:underline underline-offset-4',
        'input'         => 'w-full rounded-xl border border-line bg-white px-4 py-3 text-sm text-ink placeholder:text-muted/60 shadow-sm transition focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand-500/30',
        'section'       => 'py-20 md:py-28 lg:py-32',
        'container'     => 'mx-auto max-w-7xl px-4 sm:px-6 lg:px-8',
    ];

    /** Motion: all transitions target 200–300ms per spec. */
    public array $transitionDuration = ['fast' => '150ms', 'base' => '200ms', 'slow' => '300ms'];

    /* ------------------------------------------------------------ Breakpoints */
    public array $breakpoints = ['sm' => '640px', 'md' => '768px', 'lg' => '1024px', 'xl' => '1280px', '2xl' => '1536px'];

    /* ------------------------------------------------------------- Animations */
    public array $keyframes = [
        'floaty'  => ['0%,100%' => ['transform' => 'translateY(0)'],      '50%' => ['transform' => 'translateY(-12px)']],
        'marquee' => ['0%'      => ['transform' => 'translateX(0)'],      '100%' => ['transform' => 'translateX(-50%)']],
        'fade-up' => ['0%'      => ['opacity' => '0', 'transform' => 'translateY(16px)'], '100%' => ['opacity' => '1', 'transform' => 'none']],
    ];
    public array $animation = [
        'floaty'      => 'floaty 6s ease-in-out infinite',
        'floaty-slow' => 'floaty 8s ease-in-out infinite',
        'marquee'     => 'marquee 30s linear infinite',
        'fade-up'     => 'fade-up 0.6s cubic-bezier(0.22,1,0.36,1) both',
    ];
    public array $boxShadow = [
        'soft' => '0 10px 40px -12px rgb(79 70 229 / 0.18)',
        'glow' => '0 0 0 1px rgb(124 58 237 / 0.25), 0 20px 50px -12px rgb(124 58 237 / 0.35)',
        'card' => '0 1px 3px rgb(17 24 39 / 0.06), 0 8px 24px -8px rgb(17 24 39 / 0.08)',
    ];

    /**
     * Full tailwind.config theme.extend payload generated from tokens.
     * Echo as JSON inside <script> after loading the CDN build.
     */
    public function tailwindTheme(): array
    {
        return [
            'colors'       => $this->colors,
            'fontFamily'   => $this->fontFamily,
            'fontSize'     => $this->fontSize,
            'boxShadow'    => $this->boxShadow,
            'keyframes'    => $this->keyframes,
            'animation'    => $this->animation,
            'screens'      => $this->breakpoints,
            'borderRadius' => ['4xl' => '2rem'],
        ];
    }
}
