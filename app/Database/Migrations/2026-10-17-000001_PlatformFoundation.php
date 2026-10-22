<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Phase 1 – Platform Foundation
 * admin_users, roles, settings, menus, menu_items, pages, seo_meta
 */
class PlatformFoundation extends Migration
{
    public function up()
    {
        // --------------------------------------------------------- roles
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 50],
            'slug'        => ['type' => 'VARCHAR', 'constraint' => 50],
            'permissions' => ['type' => 'TEXT', 'null' => true], // JSON list of permission keys
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('roles', true);

        // ------------------------------------------------------ admin_users
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'           => ['type' => 'VARCHAR', 'constraint' => 100],
            'email'          => ['type' => 'VARCHAR', 'constraint' => 255],
            'password_hash'  => ['type' => 'VARCHAR', 'constraint' => 255],
            'role_id'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'avatar'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'remember_token' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'is_active'      => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'last_login_at'  => ['type' => 'DATETIME', 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('email');
        $this->forge->addKey('role_id');
        $this->forge->createTable('admin_users', true);

        // --------------------------------------------------------- settings
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'key'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'value'      => ['type' => 'TEXT', 'null' => true],
            'type'       => ['type' => 'ENUM', 'constraint' => ['text', 'textarea', 'image', 'bool', 'select', 'json'], 'default' => 'text'],
            'group'      => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'general'], // general|branding|contact|social|seo|email
            'label'      => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'options'    => ['type' => 'TEXT', 'null' => true], // JSON choices for select type
            'sort_order' => ['type' => 'INT', 'constraint' => 4, 'default' => 0],
            'updated_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('key');
        $this->forge->addKey('group');
        $this->forge->createTable('settings', true);

        // ------------------------------------------------------------ menus
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'location'   => ['type' => 'ENUM', 'constraint' => ['header', 'footer', 'mobile'], 'default' => 'header'],
            'is_active'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('location');
        $this->forge->createTable('menus', true);

        // ------------------------------------------------------- menu_items
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'menu_id'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'parent_id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'label'      => ['type' => 'VARCHAR', 'constraint' => 100],
            'url'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true], // internal path or full URL
            'target'     => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],  // _blank etc
            'css_class'  => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'icon'       => ['type' => 'VARCHAR', 'constraint' => 60, 'null' => true],  // fontawesome class
            'is_external'=> ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'is_active'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'sort_order' => ['type' => 'INT', 'constraint' => 4, 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('menu_id');
        $this->forge->addKey('parent_id');
        $this->forge->createTable('menu_items', true);

        // ------------------------------------------------------------ pages
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'title'         => ['type' => 'VARCHAR', 'constraint' => 200],
            'slug'          => ['type' => 'VARCHAR', 'constraint' => 200],
            'body'          => ['type' => 'LONGTEXT', 'null' => true],
            'template'      => ['type' => 'VARCHAR', 'constraint' => 100, 'default' => 'default'],
            'excerpt'       => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'meta_title'    => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'meta_description' => ['type' => 'VARCHAR', 'constraint' => 300, 'null' => true],
            'sort_order'    => ['type' => 'INT', 'constraint' => 4, 'default' => 0],
            'is_published'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'created_by'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('slug');
        $this->forge->addKey(['is_published', 'deleted_at']);
        $this->forge->createTable('pages', true);

        // --------------------------------------------------------- seo_meta
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'url_path'    => ['type' => 'VARCHAR', 'constraint' => 255], // e.g. /pricing
            'title'       => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'description' => ['type' => 'VARCHAR', 'constraint' => 300, 'null' => true],
            'keywords'    => ['type' => 'VARCHAR', 'constraint' => 300, 'null' => true],
            'og_image'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'canonical'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'robots'      => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'index,follow'],
            'schema_json' => ['type' => 'TEXT', 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('url_path');
        $this->forge->createTable('seo_meta', true);
    }

    public function down()
    {
        foreach (['seo_meta', 'pages', 'menu_items', 'menus', 'settings', 'admin_users', 'roles'] as $t) {
            $this->forge->dropTable($t, true);
        }
    }
}
