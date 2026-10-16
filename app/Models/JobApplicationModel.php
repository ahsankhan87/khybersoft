<?php

namespace App\Models;

use CodeIgniter\Model;

class JobApplicationModel extends Model
{
    protected $table         = 'job_applications';
    protected $allowedFields = ['career_id', 'name', 'email', 'phone', 'portfolio', 'cover_note', 'cv_path', 'status'];
    protected $useTimestamps = true;
    protected $returnType    = 'array';

    public function withCareer(?string $status = null): array
    {
        $q = $this->select('job_applications.*, careers.title AS career_title')->join('careers', 'careers.id = job_applications.career_id', 'left')->orderBy('job_applications.id', 'desc');
        if ($status) { $q->where('job_applications.status', $status); }

        return $q->findAll();
    }
}
