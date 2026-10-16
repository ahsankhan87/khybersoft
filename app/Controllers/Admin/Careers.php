<?php

namespace App\Controllers\Admin;

use App\Concerns\HasAdminCrud;
use App\Models\CareerModel;
use App\Models\JobApplicationModel;

class Careers extends BaseAdmin
{
    use HasAdminCrud;

    protected string $module     = 'business';
    protected string $modelClass = CareerModel::class;
    protected array  $fields     = ['title', 'slug', 'department', 'location', 'type', 'description', 'salary_range'];
    protected array  $booleans   = ['is_open'];
    protected array  $rules      = ['title' => 'required|max_length[150]', 'slug' => 'required|alpha_dash|is_unique[careers.slug,id,{id}]'];
    protected string $slugSource = 'title';

    public function index()
    {
        return $this->render('admin/careers/index', [
            'title'    => 'Careers',
            'items'    => (new CareerModel())->orderBy('id', 'desc')->findAll(),
            'appCount' => array_count_values(array_column((new JobApplicationModel())->select('career_id')->findAll(), 'career_id')),
        ]);
    }

    public function save(?int $id = null)
    {
        return $this->save($id);
    }

    public function delete(int $id)
    {
        return $this->destroy($id);
    }

    public function applications()
    {
        $status = (string) ($this->request->getGet('status') ?? '');

        return $this->render('admin/careers/applications', [
            'title'        => 'Job Applications',
            'applications' => (new JobApplicationModel())->withCareer($status !== '' ? $status : null),
            'active'       => $status,
        ]);
    }

    public function setAppStatus(int $id)
    {
        $status = (string) $this->request->getPost('status');
        if (! in_array($status, ['new', 'reviewing', 'interview', 'hired', 'rejected'], true)) {
            return redirect()->back()->with('error', 'Invalid status.');
        }
        (new JobApplicationModel())->update($id, ['status' => $status]);
        \App\Models\ActivityLogModel::record('status', 'business', "Application #{$id} → {$status}");

        return redirect()->back()->with('success', 'Application status updated.');
    }

    protected function listUrl(): string
    {
        return '/admin/careers';
    }
}
