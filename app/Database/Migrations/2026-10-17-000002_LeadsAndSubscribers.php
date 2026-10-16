<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Phase 1 – Leads unification + Newsletter hardening.
 * Creates `leads`, alters `subscribers`. Data migration from
 * `contacts` / `custom_development_quotes` happens in LeadMigrationSeeder
 * (safe to re-run; source tables are kept until you drop them manually).
 */
class LeadsAndSubscribers extends Migration
{
    public function up()
    {
        $this->forge->addKey('id', true);
        $this->forge->addField([
            'type'         => ['type' => 'ENUM', 'value' => ['contact', 'quote', 'demo', 'trial', 'other'], 'default' => 'contact'],
            'name'         => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'company'      => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'email'        => ['type' => 'VARCHAR', 'constraint' => 150],
            'phone'        => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'subject'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'message'      => ['type' => 'TEXT', 'null' => true],
            'product_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true], // wired up in Phase 3
            'plan_id'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true], // wired up in Phase 3
            'extra'        => ['type' => 'TEXT', 'null' => true], // JSON: budget, timeline, modules… (quote form data)
            'source_page'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'utm'          => ['type' => 'TEXT', 'null' => true], // JSON utm_* capture
            'ip_hash'      => ['type' => 'VARCHAR', 'constraint' => 64, 'null' => true],
            'status'       => ['type' => 'ENUM', 'value' => ['new', 'read', 'replied', 'closed', 'spam'], 'default' => 'new'],
            'assigned_to'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'replied_at'   => ['type' => 'DATETIME', 'null' => true],
            'legacy_table' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true], // provenance: contacts | custom_development_quotes
            'legacy_id'    => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey(['status', 'type']);
        $this->forge->addKey('email');
        $this->forge->addKey(['legacy_table', 'legacy_id']);
        $this->forge->createTable('leads', true);

        // ------------------------------------------------ subscribers alter
        $this->forge->addColumn([
            'status'         => ['type' => 'ENUM', 'value' => ['pending', 'confirmed', 'unsubscribed'], 'default' => 'confirmed'],
            'confirm_token'  => ['type' => 'VARCHAR', 'constraint' => 64, 'null' => true],
            'unsub_token'    => ['type' => 'VARCHAR', 'constraint' => 64, 'null' => true],
            'confirmed_at'   => ['type' => 'DATETIME', 'null' => true],
            'source'         => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->process_alterTable('subscribers');
    }

    public function down()
    {
        $this->forge->dropTable('leads', true);

        $this->forge->dropColumn('subscribers', [
            'status', 'confirm_token', 'unsub_token', 'confirmed_at', 'source', 'updated_at',
        ]);
    }
}
