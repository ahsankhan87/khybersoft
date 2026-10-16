<?php

namespace App\Models;

use CodeIgniter\Model;

class TeamMemberModel extends Model
{
    protected $table         = 'team_members';
    protected $allowedFields = ['name', 'role', 'photo', 'bio', 'linkedin', 'twitter', 'github', 'sort_order', 'is_active'];
    protected $useTimestamps = true;
    protected $returnType    = 'array';
}
