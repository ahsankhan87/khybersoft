<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Product detail module (Phase 3): long-form content columns on `products`,
 * plus plans, features, screenshots, FAQs and per-product tutorials.
 */
class ProductDetail extends Migration
{
    public function up()
    {
        // ---------------------------------------------------- extend products
        $db = \Config\Database::connect();
        $addCols = [
            'long_description' => "LONGTEXT NULL AFTER description",
            'brochure_url'     => "VARCHAR(255) NULL AFTER video_url",
            'docs_url'         => "VARCHAR(255) NULL AFTER brochure_url",
            'pricing_type'     => "ENUM('subscription','one-time','custom') NOT NULL DEFAULT 'subscription' AFTER docs_url",
            'users_count'      => "INT UNSIGNED NOT NULL DEFAULT 0 AFTER pricing_type",
            'rating_avg'       => "DECIMAL(2,1) NOT NULL DEFAULT 4.9 AFTER users_count",
            'rating_count'     => "INT UNSIGNED NOT NULL DEFAULT 0 AFTER rating_avg",
            'seo_title'        => "VARCHAR(255) NULL AFTER rating_count",
            'seo_description'  => "VARCHAR(500) NULL AFTER seo_title",
            'og_image'         => "VARCHAR(255) NULL AFTER seo_description",
            'canonical_url'    => "VARCHAR(255) NULL AFTER og_image",
            'category_intro'   => "TEXT NULL AFTER canonical_url",
            'category_faq'     => "TEXT NULL AFTER category_intro", // JSON [{q,a}] used on category pages
        ];
        foreach ($addCols as $col => $def) {
            try { $db->query("ALTER TABLE `products` ADD COLUMN `$col` $def"); } catch (\Throwable $e) { /* already exists */ }
        }

        // ------------------------------------------------------ product_plans
        $this->forge->addKey('id', true);
        $this->forge->addField([
            'product_id'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'name'           => ['type' => 'VARCHAR', 'constraint' => 100],
            'code'           => ['type' => 'VARCHAR', 'constraint' => 40, 'null' => true], // starter|business|enterprise
            'tagline'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'price_monthly'  => ['type' => 'DECIMAL', 'constraint' => '10,2', 'null' => true],
            'price_yearly'   => ['type' => 'DECIMAL', 'constraint' => '10,2', 'null' => true],
            'currency'       => ['type' => 'VARCHAR', 'constraint' => 3, 'default' => 'PKR'],
            'setup_fee'      => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => '0.00'],
            'trial_days'     => ['type' => 'INT', 'constraint' => 3, 'default' => 14],
            'user_limit'     => ['type' => 'VARCHAR', 'constraint' => 60, 'null' => true],
            'features'       => ['type' => 'TEXT', 'null' => true],   // JSON ["feat a","feat b"]
            'comparison'     => ['type' => 'TEXT', 'null' => true],   // JSON {"Invoicing":"✓","API":"Limited"}
            'is_popular'     => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'is_active'      => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'sort_order'     => ['type' => 'INT', 'constraint' => 4, 'default' => 0],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('product_id');
        $this->forge->createTable('product_plans', true);

        // ---------------------------------------------------- product_features
        $this->forge->addKey('id', true);
        $this->forge->addField([
            'product_id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 150],
            'description' => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'icon'        => ['type' => 'VARCHAR', 'constraint' => 60, 'null' => true],
            'group_key'   => ['type' => 'VARCHAR', 'constraint' => 60, 'null' => true], // deep-dive tab grouping
            'image'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true], // mockup shown in deep-dive tab
            'bullets'     => ['type' => 'TEXT', 'null' => true],  // JSON for deep-dive bullet points
            'sort_order'  => ['type' => 'INT', 'constraint' => 4, 'default' => 0],
            'is_active'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey(['product_id', 'group_key']);
        $this->forge->createTable('product_features', true);

        // ------------------------------------------------- product_screenshots
        $this->forge->addKey('id', true);
        $this->forge->addField([
            'product_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'image'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'caption'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'device'     => ['type' => 'ENUM', 'value' => ['desktop', 'mobile', 'tablet'], 'default' => 'desktop'],
            'sort_order' => ['type' => 'INT', 'constraint' => 4, 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('product_id');
        $this->forge->createTable('product_screenshots', true);

        // -------------------------------------------------------- product_faqs
        $this->forge->addKey('id', true);
        $this->forge->addField([
            'product_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'question'   => ['type' => 'VARCHAR', 'constraint' => 255],
            'answer'     => ['type' => 'TEXT'],
            'sort_order' => ['type' => 'INT', 'constraint' => 4, 'default' => 0],
            'is_active'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('product_id');
        $this->forge->createTable('product_faqs', true);

        // --------------------------------------------- product ↔ tutorial link
        $this->forge->addKey('id', true);
        $this->forge->addField([
            'product_id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'tutorial_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'sort_order'  => ['type' => 'INT', 'constraint' => 4, 'default' => 0],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addUniqueKey(['product_id', 'tutorial_id']);
        $this->forge->createTable('product_tutorials', true);
    }

    public function down()
    {
        foreach (['product_tutorials', 'product_faqs', 'product_screenshots', 'product_features', 'product_plans'] as $t) {
            $this->forge->dropTable($t, true);
        }
        $db = \Config\Database::connect();
        foreach (array_keys([
            'long_description' => 1, 'brochure_url' => 1, 'docs_url' => 1, 'pricing_type' => 1,
            'users_count' => 1, 'rating_avg' => 1, 'rating_count' => 1, 'seo_title' => 1,
            'seo_description' => 1, 'og_image' => 1, 'canonical_url' => 1, 'category_intro' => 1, 'category_faq' => 1,
        ]) as $col) {
            try { $db->query("ALTER TABLE `products` DROP COLUMN `$col`"); } catch (\Throwable $e) { /* ignore */ }
        }
    }
}
