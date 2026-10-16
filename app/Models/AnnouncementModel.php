<?php

namespace App\Models;

use CodeIgniter\Model;

class AnnouncementModel extends Model
{
    protected $table         = 'announcements';
    protected $allowedFields = ['message', 'link_text', 'link_url', 'bg_class', 'starts_at', 'ends_at', 'is_active', 'sort_order'];
    protected $useTimestamps = true;
    protected $returnType    = 'array';

    /** The single active announcement for the top bar (time-windowed). */
    public function current(): ?array
    {
        $now = date('Y-m-d H:i:s');

        return $this->where('is_active', 1)
                    ->groupStart()->where('starts_at', null)->orGroupStart()->where('starts_at <=', $now)->groupEnd()->groupEnd()
                    ->groupStart()->where('ends_at', null)->orGroupStart()->where('ends_at >=', $now)->groupEnd()->groupEnd()
                    ->orderBy('sort_order')->orderBy('id', 'desc')
                    ->first();
    }
}
