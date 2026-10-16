<?php

namespace App\Models;

use CodeIgniter\Model;

class WhatsappClickModel extends Model
{
    protected $table         = 'whatsapp_clicks';
    protected $allowedFields = ['department_id', 'page', 'referrer'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
    protected $returnType    = 'array';

    public function countToday(): int
    {
        return $this->where('created_at >=', date('Y-m-d 00:00:00'))->countAllResults();
    }

    public function last30DaysSeries(): array
    {
        $out = [];
        for ($i = 29; $i >= 0; $i--) {
            $day  = date('Y-m-d', strtotime("-{$i} days"));
            $out[] = ['date' => $day, 'count' => $this->where('created_at >=', $day . ' 00:00:00')->where('created_at <=', $day . ' 23:59:59')->countAllResults()];
        }

        return $out;
    }
}
