<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Homepage content modules (Phase 3–6 tables, built early so the homepage is fully dynamic):
 * products, product_categories, clients, testimonials, success_stories, integrations.
 */
class HomepageContent extends Migration
{
    public function up()
    {
        // ------------------------------------------------ product_categories
        $this->forge->addKey('id', true);
        $this->forge->addField([
            'name'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'slug'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'icon'       => ['type' => 'VARCHAR', 'constraint' => 60, 'null' => true], // fontawesome class
            'sort_order' => ['type' => 'INT', 'constraint' => 4, 'default' => 0],
            'is_active'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('product_categories', true);

        // ------------------------------------------------------------ products
        $this->forge->addKey('id', true);
        $this->forge->addField([
            'category_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'name'          => ['type' => 'VARCHAR', 'constraint' => 150],
            'slug'          => ['type' => 'VARCHAR', 'constraint' => 150],
            'tagline'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true], // one-line value prop
            'description'   => ['type' => 'LONGTEXT', 'null' => true],
            'icon'          => ['type' => 'VARCHAR', 'constraint' => 60, 'null' => true],
            'color'         => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],  // gradient classes for icon tile
            'hero_image'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'top_features'  => ['type' => 'TEXT', 'null' => true],   // JSON array of 3 feature chips
            'demo_url'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'video_url'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'price_from'    => ['type' => 'DECIMAL', 'constraint' => '10,2', 'null' => true],
            'currency'      => ['type' => 'VARCHAR', 'constraint' => 3, 'default' => 'PKR'],
            'is_featured'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'sort_order'    => ['type' => 'INT', 'constraint' => 4, 'default' => 0],
            'status'        => ['type' => 'ENUM', 'value' => ['active', 'draft', 'archived'], 'default' => 'active'],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addUniqueKey('slug');
        $this->forge->addKey(['status', 'category_id']);
        $this->forge->createTable('products', true);

        // ------------------------------------------------------------- clients (logo wall)
        $this->forge->addKey('id', true);
        $this->forge->addField([
            'company_name' => ['type' => 'VARCHAR', 'constraint' => 150],
            'logo'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true], // uploads path
            'website'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'industry'     => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'sort_order'   => ['type' => 'INT', 'constraint' => 4, 'default' => 0],
            'is_active'    => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->createTable('clients', true);

        // --------------------------------------------------------- testimonials
        $this->forge->addKey('id', true);
        $this->forge->addField([
            'quote'         => ['type' => 'TEXT'],
            'name'          => ['type' => 'VARCHAR', 'constraint' => 150],
            'role'          => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'company'       => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'photo'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'company_logo'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'product_id'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'rating'        => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 5],
            'source'        => ['type' => 'ENUM', 'value' => ['site', 'google', 'facebook'], 'default' => 'site'],
            'is_featured'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'status'        => ['type' => 'ENUM', 'value' => ['approved', 'pending', 'hidden'], 'default' => 'approved'],
            'sort_order'    => ['type' => 'INT', 'constraint' => 4, 'default' => 0],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey(['status', 'is_featured']);
        $this->forge->createTable('testimonials', true);

        // ------------------------------------------------------ success_stories
        $this->forge->addKey('id', true);
        $this->forge->addField([
            'headline'      => ['type' => 'VARCHAR', 'constraint' => 200],           // "Cut invoice time by 70%"
            'slug'          => ['type' => 'VARCHAR', 'constraint' => 200],
            'customer_name' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'role'          => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'company'       => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'industry'      => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'photo'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'logo'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'hero_image'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'quote'         => ['type' => 'TEXT', 'null' => true],                    // short 2-sentence quote
            'challenge'     => ['type' => 'LONGTEXT', 'null' => true],
            'solution'      => ['type' => 'LONGTEXT', 'null' => true],
            'results'       => ['type' => 'LONGTEXT', 'null' => true],
            'metrics'       => ['type' => 'TEXT', 'null' => true],                    // JSON [{"label":"+40% revenue"}]
            'product_id'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'is_featured'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'status'        => ['type' => 'ENUM', 'value' => ['published', 'draft'], 'default' => 'published'],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addUniqueKey('slug');
        $this->forge->addKey(['status', 'is_featured']);
        $this->forge->createTable('success_stories', true);

        // -------------------------------------------------------- integrations
        $this->forge->addKey('id', true);
        $this->forge->addField([
            'name'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'slug'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'logo'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'icon'        => ['type' => 'VARCHAR', 'constraint' => 60, 'null' => true], // fallback FA class
            'description' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true], // tooltip line
            'url'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'sort_order'  => ['type' => 'INT', 'constraint' => 4, 'default' => 0],
            'is_active'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('integrations', true);
    }

    public function down()
    {
        foreach (['integrations', 'success_stories', 'testimonials', 'clients', 'products', 'product_categories'] as $t) {
            $this->forge->dropTable($t, true);
        }
    }
}
