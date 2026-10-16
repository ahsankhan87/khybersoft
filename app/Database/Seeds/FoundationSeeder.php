<?php

namespace App\Database\Seeds;

use App\Models\Admin\AdminUserModel;
use App\Models\Admin\RoleModel;
use App\Models\Admin\SettingModel;
use App\Models\MenuModel;
use App\Models\MenuItemModel;
use CodeIgniter\Database\Seeder;

/**
 * Phase 1 seed: roles, super admin (from env bootstrap), default settings,
 * header/footer menus matching the current hardcoded navigation.
 */
class FoundationSeeder extends Seeder
{
    public function run()
    {
        $this->seedRoles();
        $this->seedAdmin();
        $this->seedSettings();
        $this->seedMenus();
    }

    private function seedRoles(): void
    {
        $roles = new RoleModel();
        foreach (array_keys(RoleModel::defaultPermissions()) as $slug) {
            if (! $roles->where('slug', $slug)->first()) {
                $roles->insert(['name' => ucwords(str_replace('_', ' ', $slug)), 'slug' => $slug, 'permissions' => json_encode(RoleModel::defaultPermissions()[$slug])]);
            }
        }
    }

    private function seedAdmin(): void
    {
        $model = new AdminUserModel();
        if ($model->countAllResults() > 0) {
            return; // never overwrite existing admins
        }

        $superRoleId = $model->db->table('roles')->where('slug', 'super_admin')->get()->getRowArray()['id'] ?? null;

        // Bootstrap credentials from env (fallback defaults force change prompt in panel).
        $email    = env('panel.email')    ?? 'admin@khybersoft.com';
        $password = env('panel.pass')     ?? 'ChangeMe!2026';
        $name     = env('panel.user')     ?? 'Administrator';

        $model->createUser($name, $email, $password, $superRoleId);
        log_message('info', "FoundationSeeder: created bootstrap admin '{$email}'. Change the password immediately.");
    }

    private function seedSettings(): void
    {
        $s = new SettingModel();
        $defaults = [
            ['site_name',        'Khybersoft',                          'text',     'general',   'Site Name'],
            ['site_tagline',     'Business software that just works.',  'text',     'general',   'Site Tagline'],
            ['site_description', 'Khybersoft builds premium business software — invoicing, accounting, POS and ERP for growing companies.', 'textarea', 'seo', 'Default Meta Description'],
            ['company_email',    'hello@khybersoft.com',                'text',     'contact',   'Contact Email'],
            ['company_phone',    '',                                    'text',     'contact',   'Contact Phone'],
            ['company_address',  '',                                    'textarea', 'contact',   'Company Address'],
            ['logo_light',       '',                                    'image',    'branding',  'Logo (light bg)'],
            ['logo_dark',        '',                                    'image',    'branding',  'Logo (dark bg)'],
            ['favicon',          '',                                    'image',    'branding',  'Favicon'],
            ['og_default_image', '',                                    'image',    'branding',  'Default Social Share Image'],
            ['footer_text',      '© {year} Khybersoft. All rights reserved.', 'textarea', 'general', 'Footer Text'],
            ['facebook',         '',                                    'text',     'social',    'Facebook URL'],
            ['twitter',          '',                                    'text',     'social',    'X / Twitter URL'],
            ['linkedin',         '',                                    'text',     'social',    'LinkedIn URL'],
            ['youtube',          '',                                    'text',     'social',    'YouTube URL'],
            ['whatsapp',         '',                                    'text',     'social',    'WhatsApp Number'],
            ['analytics_id',     '',                                    'text',     'seo',       'Google Analytics ID'],
            ['stats_businesses', '40000',                               'text',     'general',   'Trust Bar: Businesses Served'],
            ['stats_countries',  '12',                                  'text',     'general',   'Trust Bar: Countries'],
            ['stats_uptime',     '99.9%',                               'text',     'general',   'Trust Bar: Uptime'],
            ['newsletter_enabled','1',                                  'bool',     'general',   'Newsletter Signup Enabled'],
        ];
        foreach ($defaults as [$key, $value, $type, $group, $label]) {
            $s->set($key, $value, ['type' => $type, 'group' => $group, 'label' => $label]);
        }
    }

    private function seedMenus(): void
    {
        $menus = new MenuModel();
        $items = new MenuItemModel();

        foreach (['header' => 'Main Navigation', 'footer' => 'Footer Menu'] as $loc => $name) {
            if ($menus->where('location', $loc)->first()) {
                continue;
            }
            $menuId = $menus->insert(['name' => $name, 'location' => $loc, 'is_active' => 1], true);

            $links = $loc === 'header'
                ? [['Home', '/'], ['Products', '/products'], ['Pricing', '/pricing'], ['Custom Development', '/custom-development'], ['Blog', '/blog'], ['About', '/about'], ['Contact', '/contact']]
                : [['About', '/about'], ['Contact', '/contact'], ['Privacy Policy', '/privacy-policy'], ['Terms of Service', '/terms'], ['Blog', '/blog']];

            foreach ($links as $i => [$label, $url]) {
                $items->insert(['menu_id' => $menuId, 'label' => $label, 'url' => $url, 'sort_order' => $i + 1]);
            }
        }
    }
}
