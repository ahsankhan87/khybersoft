<?php

namespace Config;

use CodeIgniter\Events\Events;
use CodeIgniter\Exceptions\FrameworkException;
use CodeIgniter\HotReloader\HotReloader;

/*
 * --------------------------------------------------------------------
 * Application Events
 * --------------------------------------------------------------------
 */

Events::on('pre_system', static function (): void {
    if (ENVIRONMENT !== 'testing') {
        if (ini_get('zlib.output_compression')) {
            throw FrameworkException::forEnabledZlibOutputCompression();
        }

        while (ob_get_level() > 0) {
            ob_end_flush();
        }

        ob_start(static fn ($buffer) => $buffer);
    }

    /*
     * Debug Toolbar Listeners.
     */
    if (CI_DEBUG && ! is_cli()) {
        Events::on('DBQuery', 'CodeIgniter\Debug\Toolbar\Collectors\Database::collect');
        service('toolbar')->respond();
        if (ENVIRONMENT === 'development') {
            service('routes')->get('__hot-reload', static function (): void {
                (new HotReloader())->run();
            });
        }
    }
});

/*
 * --------------------------------------------------------------------
 * Homepage content bootstrap: ensure tables exist + seed defaults once.
 * Safe for environments where migrations are not run manually.
 * --------------------------------------------------------------------
 */
Events::on('post_controller_constructor', static function (): void {
    static $done = false;

    if ($done) {
        return;
    }
    $done = true;

    // Only bother on the public homepage.
    $uri = trim(uri_string(), '/');
    if ($uri !== '') {
        return;
    }

    try {
        $db   = \Config\Database::connect();
        $prep = new \App\Database\Migrations\Support\HomepageBootstrap();
        $prep->ensureTables($db);

        if ((int) $db->table('product_categories')->countAllResults() === 0) {
            $seeder = \Config\Services::seeder();
            $seeder->setPath(APPPATH . 'Database/Seeds');
            $seeder->call('App\Database\Seeds\HomepageSeeder');
        }
    } catch (\Throwable $e) {
        log_message('error', 'Homepage bootstrap skipped: ' . $e->getMessage());
    }
});
