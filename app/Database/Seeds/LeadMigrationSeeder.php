<?php

namespace App\Database\Seeds;

use App\Models\LeadModel;
use CodeIgniter\Database\Seeder;

/**
 * Copies existing rows from `contacts` and `custom_development_quotes`
 * into the unified `leads` table. Idempotent: uses (legacy_table, legacy_id)
 * to skip rows already migrated. Source tables are NOT dropped here —
 * drop them manually once verified.
 */
class LeadMigrationSeeder extends Seeder
{
    public function run()
    {
        $leads = new LeadModel();

        // ---- contacts -> leads(type=contact)
        foreach ($this->db->table('contacts')->get()->getResultArray() as $row) {
            if ($leads->where('legacy_table', 'contacts')->where('legacy_id', $row['id'])->first()) {
                continue;
            }
            $leads->insert([
                'type'         => 'contact',
                'name'         => $row['name'],
                'email'        => $row['email'],
                'subject'      => $row['subject'],
                'message'      => $row['message'],
                'status'       => 'new',
                'legacy_table' => 'contacts',
                'legacy_id'    => $row['id'],
                'created_at'   => $row['created_at'] ?: date('Y-m-d H:i:s'),
            ], false);
        }

        // ---- custom_development_quotes -> leads(type=quote)
        if ($this->db->tableExists('custom_development_quotes')) {
            foreach ($this->db->table('custom_development_quotes')->get()->getResultArray() as $row) {
                if ($leads->where('legacy_table', 'custom_development_quotes')->where('legacy_id', $row['id'])->first()) {
                    continue;
                }
                $extra = [];
                foreach (['budget', 'timeline', 'project_type', 'company', 'phone', 'description', 'requirements'] as $k) {
                    if (!empty($row[$k])) {
                        $extra[$k] = $row[$k];
                    }
                }
                $leads->insert([
                    'type'         => 'quote',
                    'name'         => $row['name'] ?? null,
                    'company'      => $row['company'] ?? null,
                    'email'        => $row['email'],
                    'phone'        => $row['phone'] ?? null,
                    'subject'      => 'Custom development quote request',
                    'message'      => $row['description'] ?? ($row['requirements'] ?? null),
                    'extra'        => json_encode($extra ?: null),
                    'status'       => 'new',
                    'legacy_table' => 'custom_development_quotes',
                    'legacy_id'    => $row['id'],
                    'created_at'   => $row['created_at'] ?? date('Y-m-d H:i:s'),
                ], false);
            }
        }
    }
}
