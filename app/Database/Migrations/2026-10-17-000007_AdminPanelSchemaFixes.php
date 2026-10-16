<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Aligns existing tables with the full admin panel feature set:
 * integrations test-tracking, quotes status/reply, leads notes.
 */
class AdminPanelSchemaFixes extends Migration
{
    public function up()
    {
        $cols = fn (string $table) => array_map(
            static fn ($f) => $f->name,
            $this->db->listColumns($table)
        );

        if ($this->db->tableExists('integrations')) {
            $have = $cols('integrations');
            $add  = [];
            if (! in_array('config', $have, true)) {
                $add['config'] = ['type' => 'TEXT', 'null' => true];
            }
            if (! in_array('last_tested_at', $have, true)) {
                $add['last_tested_at'] = ['type' => 'DATETIME', 'null' => true];
            }
            if (! in_array('last_test_status', $have, true)) {
                $add['last_test_status'] = ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true];
            }
            if ($add) { $this->forge->addColumn('integrations', $add); }
        }

        if ($this->db->tableExists('custom_development_quotes')) {
            $have = $cols('custom_development_quotes');
            $add  = [];
            if (! in_array('status', $have, true)) {
                $add['status'] = ['type' => 'ENUM', 'value' => ['new', 'reviewing', 'quoted', 'won', 'lost'], 'default' => 'new'];
            }
            if (! in_array('budget_range', $have, true)) {
                $add['budget_range'] = ['type' => 'VARCHAR', 'constraint' => 80, 'null' => true];
            }
            if (! in_array('timeline', $have, true)) {
                $add['timeline'] = ['type' => 'VARCHAR', 'constraint' => 80, 'null' => true];
            }
            if (! in_array('admin_reply', $have, true)) {
                $add['admin_reply'] = ['type' => 'TEXT', 'null' => true];
            }
            if (! in_array('updated_at', $have, true)) {
                $add['updated_at'] = ['type' => 'DATETIME', 'null' => true];
            }
            if ($add) { $this->forge->addColumn('custom_development_quotes', $add); }
        }

        if ($this->db->tableExists('leads')) {
            $have = $cols('leads');
            if (! in_array('notes', $have, true)) {
                $this->forge->addColumn('leads', ['notes' => ['type' => 'TEXT', 'null' => true]]);
            }
        }
    }

    public function down()
    {
        // Columns are additive & nullable — safe to keep on rollback of this migration.
    }
}
