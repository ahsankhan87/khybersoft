<?php

namespace App\Controllers\Admin;

use App\Models\ActivityLogModel;
use App\Models\WhatsappClickModel;
use App\Models\WhatsappDepartmentModel;

class Whatsapp extends BaseAdmin
{
    public function index()
    {
        if ($resp = $this->guard('whatsapp')) { return $resp; }
        $model = new WhatsappDepartmentModel();

        return $this->render('admin/whatsapp/index', [
            'title'  => 'WhatsApp Click-to-Chat',
            'depts'  => $model->orderBy('id')->findAll(),
            'today'  => (new WhatsappClickModel())->countToday(),
            'series' => (new WhatsappClickModel())->last30DaysSeries(),
            'total'  => (new WhatsappClickModel())->countAllResults(),
        ]);
    }

    public function saveDept(?int $id = null)
    {
        if ($resp = $this->guard('whatsapp')) { return $resp; }
        $name   = trim((string) $this->request->getPost('name'));
        $number = preg_replace('/\D/', '', (string) $this->request->getPost('number'));
        if ($name === '' || strlen($number) < 10) {
            return redirect()->back()->with('error', 'Name and a full international number (e.g. 923001234567) are required.');
        }
        $model = new WhatsappDepartmentModel();
        $data  = ['name' => $name, 'number' => $number, 'greeting' => $this->request->getPost('greeting'), 'is_default' => $this->request->getPost('is_default') ? 1 : 0];
        if ($data['is_default']) {
            $model->where('id !=', $id ?? 0)->update(null, ['is_default' => 0]);
        }
        if ($id) { $model->update($id, $data); } else { $model->insert($data); }
        ActivityLogModel::record('save', 'whatsapp', "Department '{$name}'");

        return redirect()->to('/admin/whatsapp')->with('success', 'Department saved.');
    }

    public function deleteDept(int $id)
    {
        if ($resp = $this->guard('whatsapp')) { return $resp; }
        (new WhatsappDepartmentModel())->delete($id);
        ActivityLogModel::record('delete', 'whatsapp', "Department #{$id}");

        return redirect()->to('/admin/whatsapp')->with('success', 'Department deleted.');
    }

    /** Public endpoint: logs the click then 302s to wa.me */
    public function track()
    {
        try {
            $deptId = (int) $this->request->getGet('d');
            $model  = new WhatsappDepartmentModel();
            $dept   = $deptId ? $model->find($deptId) : $model->defaultOne();
            if (! $dept) {
                return redirect()->to('/contact');
            }
            (new WhatsappClickModel())->insert([
                'department_id' => $dept['id'],
                'page'          => mb_substr((string) $this->request->getGet('page'), 0, 255),
                'referrer'      => mb_substr((string) (service('request')->getServer('HTTP_REFERER') ?? ''), 0, 255),
            ]);
            $model->update($dept['id'], ['clicks' => (int) $dept['clicks'] + 1]);

            return redirect()->to($model->clickUrl($dept, (string) $this->request->getGet('msg')), 302);
        } catch (\Throwable $e) {
            return redirect()->to('/contact');
        }
    }
}
