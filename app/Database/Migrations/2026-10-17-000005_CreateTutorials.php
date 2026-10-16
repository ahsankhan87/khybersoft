<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Tutorials / Help Center base table (full module in Phase 6).
 */
class CreateTutorials extends Migration
{
    public function up()
    {
        $this->forge->addKey('id', true);
        $this->forge->addField([
            'product_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'title'        => ['type' => 'VARCHAR', 'constraint' => 200],
            'slug'         => ['type' => 'VARCHAR', 'constraint' => 200],
            'type'         => ['type' => 'ENUM', 'value' => ['video', 'article'], 'default' => 'video'],
            'video_url'    => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true], // youtube/vimeo/mp4
            'article_body' => ['type' => 'LONGTEXT', 'null' => true],
            'thumbnail'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'duration_sec' => ['type' => 'INT', 'constraint' => 6, 'default' => 0],
            'view_count'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'sort_order'   => ['type' => 'INT', 'constraint' => 4, 'default' => 0],
            'is_published' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addUniqueKey('slug');
        $this->forge->addKey(['product_id', 'is_published']);
        $this->forge->createTable('tutorials', true);
    }

    public function down()
    {
        $this->forge->dropTable('tutorials', true);
    }
}
