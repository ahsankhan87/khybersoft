<?php

declare(strict_types=1);

/**
 * Legacy helpers from the old functions.php (minus the custom e() which
 * collided with CI's native esc()). Kept during transition; remove once
 * all views use esc().
 */

if (! function_exists('slugify')) {
    function slugify(string $text): string
    {
        $text  = mb_strtolower($text);
        $text  = preg_replace('/[^a-z0-9\s-]/', '', $text);
        $text  = preg_replace('/[\s-]+/', '-', $text);

        return trim($text, '-');
    }
}

if (! function_exists('money')) {
    function money(float $amount, string $currency = 'USD'): string
    {
        $symbols = ['USD' => '$', 'EUR' => '€', 'GBP' => '£', 'PKR' => 'Rs.', 'INR' => '₹'];
        $symbol  = $symbols[$currency] ?? $currency . ' ';

        return $symbol . number_format($amount, 2);
    }
}

if (! function_exists('format_date')) {
    function format_date(?string $date, string $format = 'M d, Y'): string
    {
        return $date ? date($format, strtotime($date)) : '';
    }
}

if (! function_exists('format_datetime')) {
    function format_datetime(?string $datetime, string $format = 'M d, Y H:i'): string
    {
        return $datetime ? date($format, strtotime($datetime)) : '';
    }
}

if (! function_exists('str_limit')) {
    function str_limit(string $text, int $limit = 100, string $end = '...'): string
    {
        return mb_strlen($text) <= $limit ? $text : mb_substr($text, 0, $limit) . $end;
    }
}
