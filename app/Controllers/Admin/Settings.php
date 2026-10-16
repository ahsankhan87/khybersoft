<?php

namespace App\Controllers\Admin;

use App\Models\Admin\SettingModel;

/**
 * Site settings editor — every key/value is editable here (Phase 1).
 */
class Settings extends BaseAdmin
{
    private const GROUPS = [
        'general'  => ['General',        'fa-solid fa-sliders'],
        'branding' => ['Branding',       'fa-solid fa-palette'],
        'contact'  => ['Contact Info',   'fa-solid fa-address-book'],
        'social'   => ['Social Links',   'fa-brands fa-share-nodes'],
        'seo'      => ['SEO & Analytics','fa-solid fa-magnifying-glass-chart'],
        'email'    => ['Email',          'fa-solid fa-envelope'],
    ];

    public function index()
    {
        return $this->redirectByFirstGroup();
    }

    public function group(string $group)
    {
        if (! isset(self::GROUPS[$group])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $model = new SettingModel();

        return $this->render('admin/settings/index', [
            'title'  => self::GROUPS[$group][0],
            'group'  => $group,
            'groups' => self::GROUPS,
            'items'  => $model->grouped($group),
        ]);
    }

    public function save(string $group)
    {
        if (! isset(self::GROUPS[$group])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $model = new SettingModel();
        $post  = $this->request->getPost('settings');

        foreach ((array) $post as $key => $value) {
            $row = $model->where('key', $key)->where('group', $group)->first();
            if (! $row) {
                continue; // only keys belonging to this group
            }
            $value = is_array($value) ? implode(',', $value) : trim((string) $value);
            if ($row['type'] === 'bool') {
                $value = ($value === '1' || $value === 'on') ? '1' : '0';
            }
            $model->update($row['id'], ['value' => $value, 'updated_by' => (int) session()->get('admin_id')]);
        }
        $model->all(true); // bust cache

        return redirect()->to('/admin/settings/' . $group)->with('success', 'Settings saved.');
    }

    private function redirectByFirstGroup()
    {
        return redirect()->to('/admin/settings/general');
    }
}
