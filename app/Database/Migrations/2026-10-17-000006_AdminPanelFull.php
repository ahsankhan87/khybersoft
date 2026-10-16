<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Full admin panel support tables: media library, blog (posts/categories/tags/comments),
 * tutorial categories, FAQs, services, team, careers + applications, redirects,
 * announcements, activity logs, login attempts, spam rules, WhatsApp departments/clicks,
 * password resets, and user 2FA columns.
 */
class AdminPanelFull extends Migration
{
    public function up()
    {
        // ------------------------------------------------------------- media
        $this->forge->addKey('id', true);
        $this->forge->addField([
            'name'        => ['type' => 'VARCHAR', 'constraint' => 255],
            'path'        => ['type' => 'VARCHAR', 'constraint' => 500],           // relative: uploads/2026/10/x.webp
            'thumb_path'  => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'mime'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'kind'        => ['type' => 'ENUM', 'value' => ['image', 'video', 'document'], 'default' => 'image'],
            'size_kb'     => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'width'       => ['type' => 'SMALLINT', 'constraint' => 6, 'null' => true],
            'height'      => ['type' => 'SMALLINT', 'constraint' => 6, 'null' => true],
            'alt_text'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'folder'      => ['type' => 'VARCHAR', 'constraint' => 100, 'default' => 'general'],
            'uploaded_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey(['folder', 'kind']);
        $this->forge->createTable('media', true);

        // ------------------------------------------------------------ categories (blog)
        $this->forge->addKey('id', true);
        $this->forge->addField([
            'name'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'slug'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'description' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'sort_order'  => ['type' => 'INT', 'constraint' => 4, 'default' => 0],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('categories', true);

        // ---------------------------------------------------------------- tags
        $this->forge->addKey('id', true);
        $this->forge->addField([
            'name'       => ['type' => 'VARCHAR', 'constraint' => 80],
            'slug'       => ['type' => 'VARCHAR', 'constraint' => 80],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('tags', true);

        // --------------------------------------------------------------- posts
        $this->forge->addKey('id', true);
        $this->forge->addField([
            'title'         => ['type' => 'VARCHAR', 'constraint' => 255],
            'slug'          => ['type' => 'VARCHAR', 'constraint' => 255],
            'category_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'author_id'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'excerpt'       => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'content'       => ['type' => 'LONGTEXT', 'null' => true],
            'featured_image'=> ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'read_minutes'  => ['type' => 'SMALLINT', 'constraint' => 4, 'default' => 5],
            'view_count'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'is_featured'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'status'        => ['type' => 'ENUM', 'value' => ['draft', 'published', 'scheduled', 'archived'], 'default' => 'draft'],
            'published_at'  => ['type' => 'DATETIME', 'null' => true],
            'meta_title'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'meta_desc'     => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addUniqueKey('slug');
        $this->forge->addKey(['status', 'published_at']);
        $this->forge->createTable('posts', true);

        // ----------------------------------------------------------- post_tag
        $this->forge->addField([
            'post_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'tag_id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
        ]);
        $this->forge->addKey(['post_id', 'tag_id'], false, true);
        $this->forge->createTable('post_tag', true);

        // ------------------------------------------------------------ comments
        $this->forge->addKey('id', true);
        $this->forge->addField([
            'post_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'parent_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'name'      => ['type' => 'VARCHAR', 'constraint' => 120],
            'email'     => ['type' => 'VARCHAR', 'constraint' => 190],
            'content'   => ['type' => 'TEXT'],
            'status'    => ['type' => 'ENUM', 'value' => ['pending', 'approved', 'spam'], 'default' => 'pending'],
            'ip_hash'   => ['type' => 'VARCHAR', 'constraint' => 64, 'null' => true],
            'created_at'=> ['type' => 'DATETIME', 'null' => true],
            'updated_at'=> ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey(['status', 'post_id']);
        $this->forge->createTable('comments', true);

        // -------------------------------------------------- tutorial_categories
        $this->forge->addKey('id', true);
        $this->forge->addField([
            'name'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'slug'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'icon'       => ['type' => 'VARCHAR', 'constraint' => 60, 'null' => true],
            'sort_order' => ['type' => 'INT', 'constraint' => 4, 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('tutorial_categories', true);

        // add category link to existing tutorials table
        if (! array_key_exists('category_id', $this->db->getFieldNames('tutorials') ? array_combine($this->db->getFieldNames('tutorials'), []) : [])) {
            $this->forge->addColumn('tutorials', [
                'category_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true, 'after' => 'id'],
            ]);
        }

        // ---------------------------------------------------------------- faqs
        $this->forge->addKey('id', true);
        $this->forge->addField([
            'scope'       => ['type' => 'VARCHAR', 'constraint' => 60, 'default' => 'general'], // general|home|product:{slug}
            'question'    => ['type' => 'VARCHAR', 'constraint' => 500],
            'answer'      => ['type' => 'TEXT'],
            'sort_order'  => ['type' => 'INT', 'constraint' => 4, 'default' => 0],
            'is_active'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('scope');
        $this->forge->createTable('faqs', true);

        // ------------------------------------------------------------- services
        $this->forge->addKey('id', true);
        $this->forge->addField([
            'name'        => ['type' => 'VARCHAR', 'constraint' => 150],
            'slug'        => ['type' => 'VARCHAR', 'constraint' => 150],
            'icon'        => ['type' => 'VARCHAR', 'constraint' => 60, 'null' => true],
            'summary'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'description' => ['type' => 'LONGTEXT', 'null' => true],
            'sort_order'  => ['type' => 'INT', 'constraint' => 4, 'default' => 0],
            'is_active'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('services', true);

        // ---------------------------------------------------------------- team
        $this->forge->addKey('id', true);
        $this->forge->addField([
            'name'        => ['type' => 'VARCHAR', 'constraint' => 120],
            'role'        => ['type' => 'VARCHAR', 'constraint' => 120],
            'photo'       => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'bio'         => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'linkedin'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'twitter'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'github'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'sort_order'  => ['type' => 'INT', 'constraint' => 4, 'default' => 0],
            'is_active'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->createTable('team_members', true);

        // ------------------------------------------------------------- careers
        $this->forge->addKey('id', true);
        $this->forge->addField([
            'title'        => ['type' => 'VARCHAR', 'constraint' => 150],
            'slug'         => ['type' => 'VARCHAR', 'constraint' => 150],
            'department'   => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'location'     => ['type' => 'VARCHAR', 'constraint' => 120, 'null' => true],
            'type'         => ['type' => 'ENUM', 'value' => ['full-time', 'part-time', 'contract', 'remote', 'internship'], 'default' => 'full-time'],
            'description'  => ['type' => 'LONGTEXT', 'null' => true],
            'salary_range' => ['type' => 'VARCHAR', 'constraint' => 80, 'null' => true],
            'is_open'      => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('careers', true);

        // ---------------------------------------------------------- job_applications
        $this->forge->addKey('id', true);
        $this->forge->addField([
            'career_id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'name'       => ['type' => 'VARCHAR', 'constraint' => 150],
            'email'      => ['type' => 'VARCHAR', 'constraint' => 190],
            'phone'      => ['type' => 'VARCHAR', 'constraint' => 40, 'null' => true],
            'portfolio'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'cover_note' => ['type' => 'TEXT', 'null' => true],
            'cv_path'    => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'status'     => ['type' => 'ENUM', 'value' => ['new', 'reviewing', 'interview', 'hired', 'rejected'], 'default' => 'new'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey(['status', 'career_id']);
        $this->forge->createTable('job_applications', true);

        // ----------------------------------------------------------- redirects
        $this->forge->addKey('id', true);
        $this->forge->addField([
            'source_path' => ['type' => 'VARCHAR', 'constraint' => 255],
            'target_url'  => ['type' => 'VARCHAR', 'constraint' => 500],
            'status_code' => ['type' => 'SMALLINT', 'constraint' => 4, 'default' => 301],
            'hits'        => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'is_active'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addUniqueKey('source_path');
        $this->forge->createTable('redirects', true);

        // -------------------------------------------------------- announcements
        $this->forge->addKey('id', true);
        $this->forge->addField([
            'message'    => ['type' => 'VARCHAR', 'constraint' => 255],
            'link_text'  => ['type' => 'VARCHAR', 'constraint' => 80, 'null' => true],
            'link_url'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'bg_class'   => ['type' => 'VARCHAR', 'constraint' => 120, 'default' => 'bg-gradient-to-r from-indigo-600 to-violet-600 text-white'],
            'starts_at'  => ['type' => 'DATETIME', 'null' => true],
            'ends_at'    => ['type' => 'DATETIME', 'null' => true],
            'is_active'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'sort_order' => ['type' => 'INT', 'constraint' => 4, 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->createTable('announcements', true);

        // --------------------------------------------------------- activity_logs
        $this->forge->addKey('id', true);
        $this->forge->addField([
            'user_id'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'user_name'   => ['type' => 'VARCHAR', 'constraint' => 120, 'null' => true],
            'action'      => ['type' => 'VARCHAR', 'constraint' => 40],            // create|update|delete|login|logout|upload…
            'module'      => ['type' => 'VARCHAR', 'constraint' => 60],
            'target'      => ['type' => 'VARCHAR', 'constraint' => 190, 'null' => true],
            'description' => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'ip'          => ['type' => 'VARCHAR', 'constraint' => 45, 'null' => true],
            'user_agent'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'payload'     => ['type' => 'TEXT', 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey(['module', 'created_at']);
        $this->forge->createTable('activity_logs', true);

        // ------------------------------------------------------- login_attempts
        $this->forge->addKey('id', true);
        $this->forge->addField([
            'email'      => ['type' => 'VARCHAR', 'constraint' => 190],
            'ip'         => ['type' => 'VARCHAR', 'constraint' => 45],
            'success'    => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'user_agent' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey(['ip', 'created_at']);
        $this->forge->createTable('login_attempts', true);

        // ------------------------------------------------------ spam blocklists
        $this->forge->addKey('id', true);
        $this->forge->addField([
            'rule_type' => ['type' => 'ENUM', 'value' => ['ip', 'keyword', 'email_domain'], 'default' => 'keyword'],
            'value'     => ['type' => 'VARCHAR', 'constraint' => 190],
            'notes'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'is_active' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'=> ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addUniqueKey(['rule_type', 'value']);
        $this->forge->createTable('spam_rules', true);

        // --------------------------------------------------- whatsapp_departments
        $this->forge->addKey('id', true);
        $this->forge->addField([
            'name'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'number'     => ['type' => 'VARCHAR', 'constraint' => 30],   // 923001234567
            'greeting'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'is_default' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'clicks'     => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->createTable('whatsapp_departments', true);

        // ----------------------------------------------------- whatsapp_clicks
        $this->forge->addKey('id', true);
        $this->forge->addField([
            'department_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'page'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'referrer'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('created_at');
        $this->forge->createTable('whatsapp_clicks', true);

        // ---------------------------------------------------- password_resets
        $this->forge->addKey('id', true);
        $this->forge->addField([
            'email'      => ['type' => 'VARCHAR', 'constraint' => 190],
            'token_hash' => ['type' => 'VARCHAR', 'constraint' => 64],
            'expires_at' => ['type' => 'DATETIME'],
            'used_at'    => ['type' => 'DATETIME', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('token_hash');
        $this->forge->createTable('password_resets', true);

        // ---------------------------------------------- admin_users: 2FA + extras
        $existing = $this->db->getFieldNames('admin_users');
        $add      = [];
        if (! in_array('totp_secret', $existing, true)) {
            $add['totp_secret'] = ['type' => 'VARCHAR', 'constraint' => 64, 'null' => true];
        }
        if (! in_array('two_factor_enabled', $existing, true)) {
            $add['two_factor_enabled'] = ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0];
        }
        if (! in_array('backup_codes', $existing, true)) {
            $add['backup_codes'] = ['type' => 'TEXT', 'null' => true];
        }
        if (! in_array('last_activity_at', $existing, true)) {
            $add['last_activity_at'] = ['type' => 'DATETIME', 'null' => true];
        }
        if ($add) {
            $this->forge->addColumn('admin_users', $add);
        }

        // ------------------------------------------------- product_versions
        if (! $this->db->tableExists('product_versions')) {
            $this->forge->addKey('id', true);
            $this->forge->addField([
                'product_id'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
                'version'          => ['type' => 'VARCHAR', 'constraint' => 30],
                'release_date'     => ['type' => 'DATE', 'null' => true],
                'highlights'       => ['type' => 'TEXT', 'null' => true],
                'breaking_changes' => ['type' => 'TEXT', 'null' => true],
                'download_url'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
                'is_latest'        => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
                'created_at'       => ['type' => 'DATETIME', 'null' => true],
                'updated_at'       => ['type' => 'DATETIME', 'null' => true],
            ]);
            $this->forge->addKey('product_id');
            $this->forge->createTable('product_versions', true);
        }
    }

    public function down()
    {
        foreach ([
            'product_versions', 'password_resets', 'whatsapp_clicks', 'whatsapp_departments',
            'spam_rules', 'login_attempts', 'activity_logs', 'announcements', 'redirects',
            'job_applications', 'careers', 'team_members', 'services', 'faqs',
            'tutorial_categories', 'comments', 'post_tag', 'tags', 'categories', 'posts', 'media',
        ] as $t) {
            $this->forge->dropTable($t, true);
        }
    }
}
