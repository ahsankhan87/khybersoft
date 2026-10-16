<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeds homepage content: settings (hero/stats/etc.), product categories + products,
 * clients, testimonials, success stories, integrations. Idempotent-ish (checks first).
 */
class HomepageSeeder extends Seeder
{
    public function run()
    {
        $this->seedSettings();
        $this->seedCategoriesAndProducts();
        $this->seedClients();
        $this->seedTestimonials();
        $this->seedStories();
        $this->seedIntegrations();
    }

    private function seedSettings(): void
    {
        $defaults = [
            // announcement bar
            'announcement_enabled' => '1',
            'announcement_text'    => '🎉 New: Khybersoft POS v3.0 launched — 40% faster, offline mode, WhatsApp receipts.',
            'announcement_link'    => '/products/pos',
            // hero
            'hero_eyebrow'      => '⚡ Trusted by 500+ businesses in Pakistan & beyond',
            'hero_title'        => 'Run Your Entire Business on Khybersoft.',
            'hero_subtitle'     => 'POS, Accounting, School Management, Plot Management, HRM — one unified platform. Built for growing businesses, priced for everyone.',
            'hero_cta_primary'  => 'Start Free Trial',
            'hero_cta_secondary'=> 'Watch 2-min Demo',
            'hero_trust_micro'  => 'No credit card • 14-day trial • Free setup',
            'hero_rating_text'  => '4.9/5 from 200+ reviews',
            'hero_video_url'    => 'https://www.youtube.com/watch?v=khybersoft-demo',
            // trust bar
            'trust_bar_title'   => 'Trusted by 500+ businesses',
            // stats
            'stat_1_value' => '500',  'stat_1_suffix' => '+',       'stat_1_label' => 'Businesses',
            'stat_2_value' => '50',   'stat_2_suffix' => '+',       'stat_2_label' => 'Countries',
            'stat_3_value' => '10',   'stat_3_suffix' => 'M+',      'stat_3_label' => 'Transactions processed',
            'stat_4_value' => '99.9', 'stat_4_suffix' => '%',       'stat_4_label' => 'Uptime SLA',
            // sections
            'products_heading'      => 'One platform. Every business need.',
            'why_heading'           => 'Why growing teams choose Khybersoft',
            'deepdive_heading'      => 'Powerful where it counts',
            'stories_heading'       => 'Real businesses. Real results.',
            'testimonials_heading'  => 'Loved by owners, accountants & managers',
            'pricing_heading'       => 'Simple pricing. No surprises.',
            'integrations_heading'  => 'Works with the tools you already use',
            'help_heading'          => "Stuck? We've got you.",
            'blog_heading'          => 'Latest from the blog',
            // why blocks
            'why_1_icon' => 'fa-solid fa-clock-rotate-left', 'why_1_title' => 'Save 40+ hours a month',
            'why_1_text' => 'Automate invoicing, reminders, reports and reconciliation that used to eat your evenings.',
            'why_2_icon' => 'fa-solid fa-cubes',             'why_2_title' => 'All-in-one platform',
            'why_2_text' => 'Replace 5 disconnected tools with one login. Your data finally lives in one place.',
            'why_3_icon' => 'fa-solid fa-headset',           'why_3_title' => 'Local support, global standards',
            'why_3_text' => '24/7 help in English & Urdu from real engineers based in Peshawar — not bots.',
            // deep dive tabs
            'deepdive_tabs' => json_encode([
                ['name' => 'Invoicing',    'icon' => 'fa-solid fa-file-invoice-dollar', 'title' => 'Professional invoices in 15 seconds', 'points' => ['Auto-numbering, branding & GST/PRA fields', 'Recurring invoices + payment reminders', 'WhatsApp & email delivery with read receipts'], 'image' => 'uploads/screenshots/invoicing.png'],
                ['name' => 'Inventory',    'icon' => 'fa-solid fa-boxes-stacked',       'title' => 'Stock you can actually trust',         'points' => ['Real-time stock across all branches', 'Low-stock alerts & auto purchase orders', 'Batch, expiry & barcode support'], 'image' => 'uploads/screenshots/inventory.png'],
                ['name' => 'Reports',      'icon' => 'fa-solid fa-chart-line',          'title' => 'Board-ready reports, instantly',       'points' => ['P&L, balance sheet & cash flow', 'Sales analytics by item, branch, cashier', 'Export to Excel / PDF on schedule'], 'image' => 'uploads/screenshots/reports.png'],
                ['name' => 'Multi-branch', 'icon' => 'fa-solid fa-network-wired',       'title' => 'One dashboard for every branch',       'points' => ['Role-based access per location', 'Central pricing & inter-branch transfers', 'Consolidated group reporting'], 'image' => 'uploads/screenshots/branches.png'],
                ['name' => 'Offline mode', 'icon' => 'fa-solid fa-wifi',                'title' => 'Sales never stop when internet does',  'points' => ['POS keeps ringing offline', 'Auto-sync when connection returns', 'Zero data loss guarantee'], 'image' => 'uploads/screenshots/offline.png'],
                ['name' => 'Mobile app',   'icon' => 'fa-solid fa-mobile-screen',       'title' => 'Your business in your pocket',         'points' => ['Live sales & alerts on your phone', 'Approve purchases on the go', 'Owner analytics widget'], 'image' => 'uploads/screenshots/mobile.png'],
            ]),
            // final CTA
            'cta_heading'    => 'Ready to transform your business?',
            'cta_sub'        => 'Join 500+ growing businesses running on Khybersoft.',
            'whatsapp_number'=> '923001234567',
            // footer
            'footer_tagline' => 'Business software that just works. Made with ❤️ in Pakistan.',
        ];

        $db = \Config\Database::connect();
        foreach ($defaults as $key => $value) {
            $exists = $db->table('settings')->where('key', $key)->get()->getRowArray();
            if (! $exists) {
                $type = str_contains($key, 'tabs') ? 'json' : (in_array($key, ['announcement_enabled'], true) ? 'bool' : 'text');
                $group = preg_match('/^(hero|announcement|stat|why|cta|trust)/', $key) ? 'homepage' : 'general';
                $db->table('settings')->insert([
                    'key' => $key, 'value' => $value, 'type' => $type,
                    'group' => $group, 'label' => ucwords(str_replace('_', ' ', $key)),
                ]);
            }
        }
    }

    private function seedCategoriesAndProducts(): void
    {
        $db = \Config\Database::connect();
        if ($db->table('product_categories')->countAllResults() > 0) {
            return;
        }

        $cats = [
            ['Retail & POS',   'retail-pos',   'fa-solid fa-store',              [
                ['Khybersoft POS', 'pos', 'Sell faster — online, offline, anywhere.', 'fa-solid fa-cash-register', 'from-indigo-500 to-violet-500', ['Offline mode', 'WhatsApp receipts', 'Barcode scanning'], 1],
                ['Retail Pro Suite','retail-pro','Multi-store retail command center.','fa-solid fa-shop',['Multi-branch sync','Loyalty programs','Expiry management'],0],
            ]],
            ['Accounting',     'accounting',   'fa-solid fa-calculator',         [
                ['Khybersoft Books', 'books', 'Accounting that balances itself.', 'fa-solid fa-book-open', ['Auto bank feeds', 'GST/PRA returns', '1-click P&L'], 1],
                ['Invoice Cloud', 'invoice-cloud', 'Get paid 3x faster with smart invoicing.', 'fa-solid fa-file-invoice-dollar', ['Recurring billing', 'Payment links', 'Reminders'], 0],
            ]],
            ['Education',      'education',    'fa-solid fa-graduation-cap',     [
                ['School Manager', 'school-manager', 'The complete school ERP.', 'fa-solid fa-school', ['Fees & attendance', 'Report cards', 'Parent portal'], 1],
                ['College ERP', 'college-erp', 'Higher-ed administration made easy.', 'fa-solid fa-user-graduate', ['Admissions', 'Result gazette', 'Timetable'], 0],
            ]],
            ['Real Estate',    'real-estate',  'fa-solid fa-building',           [
                ['Plot Manager', 'plot-manager', 'Files, plots & installments under control.', 'fa-solid fa-map', ['File tracking', 'Installment plans', 'Transfer records'], 1],
                ['Society CRM', 'society-crm', 'Community billing & facility ops.', 'fa-solid fa-people-group', ['Maintenance bills', 'Gate entries', 'Complaints'], 0],
            ]],
            ['HR & Payroll',   'hr-payroll',   'fa-solid fa-users-gear',         [
                ['HR Hub', 'hr-hub', 'From hiring to payslip, automated.', 'fa-solid fa-id-card-clip', ['Biometric attendance', 'Payroll runs', 'Leave workflow'], 1],
            ]],
            ['Custom',         'custom',       'fa-solid fa-wand-magic-sparkles',[
                ['Custom Development', 'custom-development', 'Bespoke software, built to your workflow.', 'fa-solid fa-code', ['Discovery workshop', 'Agile delivery', 'Source ownership'], 0],
            ]],
        ];

        foreach ($cats as $i => [$cname, $cslug, $cicon, $products]) {
            $db->table('product_categories')->insert([
                'name' => $cname, 'slug' => $cslug, 'icon' => $cicon,
                'sort_order' => $i, 'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'),
            ]);
            $catId = $db->table('product_categories')->getInsertID();

            foreach ($products as $j => [$pname, $pslug, $tagline, $icon, $color, $features, $featured]) {
                $db->table('products')->insert([
                    'category_id' => $catId, 'name' => $pname, 'slug' => $pslug,
                    'tagline' => $tagline, 'icon' => $icon, 'color' => $color,
                    'top_features' => json_encode($features), 'currency' => 'PKR',
                    'price_from' => 4999, 'is_featured' => $featured, 'sort_order' => $j,
                    'status' => 'active',
                    'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
    }

    private function seedClients(): void
    {
        $db = \Config\Database::connect();
        if ($db->table('clients')->countAllResults() > 0) {
            return;
        }
        $names = ['Al-Madina Group', 'City Mart Peshawar', 'Giga Mall', 'Habib Sugar', 'Khyber Textile',
                  'Nexus Retail', 'Pearl Hotels', 'Saigon Traders', 'United Motors', 'Zen Auto'];
        foreach ($names as $i => $n) {
            $db->table('clients')->insert([
                'company_name' => $n, 'logo' => null, 'website' => null,
                'industry' => 'General', 'sort_order' => $i, 'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }

    private function seedTestimonials(): void
    {
        $db = \Config\Database::connect();
        if ($db->table('testimonials')->countAllResults() > 0) {
            return;
        }
        $rows = [
            ['We replaced three separate systems with Khybersoft. Month-end closing went from 6 days to 4 hours. The offline POS alone paid for the year.', 'Imran Wali', 'Owner', 'Wali Department Store', 5, 1],
            ['Finally software my staff actually enjoys using. Training took one afternoon. Support answers in Urdu within minutes.', 'Sobia Khan', 'Finance Manager', 'Green Valley Schools', 5, 1],
            ['Plot files, installments and transfers used to live in almirahs. Now everything is one search away. Our recovery rate jumped 30%.', 'Asad Ullah', 'Director', 'Battigram Housing', 5, 1],
            ['The WhatsApp receipts feature is genius — customers love it and our returns dropped because every sale has proof.', 'Nadia Yasmin', 'Operations Head', 'Zara Boutique Chain', 5, 0],
            ['Bank reconciliation that took my accountant two full days now happens automatically while she has chai.', 'Faisal Mehmood', 'CEO', 'Metro Foods Pvt', 5, 0],
            ['We run 7 branches on one dashboard. Consolidated reports that used to take a week now take one click.', 'Haroon Rashid', 'Group Controller', 'Seven Stars Retail', 5, 0],
        ];
        foreach ($rows as $i => [$q, $n, $r, $c, $rating, $feat]) {
            $db->table('testimonials')->insert([
                'quote' => $q, 'name' => $n, 'role' => $r, 'company' => $c,
                'rating' => $rating, 'source' => 'site', 'is_featured' => $feat,
                'status' => 'approved', 'sort_order' => $i,
                'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }

    private function seedStories(): void
    {
        $db = \Config\Database::connect();
        if ($db->table('success_stories')->countAllResults() > 0) {
            return;
        }
        $rows = [
            ['Cut invoice time by 70%', 'wali-case', 'Imran Wali', 'Owner', 'Wali Department Store', 'Retail',
             'Manual billing meant long queues and revenue leakage. Khybersoft POS with barcode scanning ended that overnight.',
             json_encode([['label' => '+40% revenue'], ['label' => '-15 hrs/week'], ['label' => '0 leaks']]), 1],
            ['Month-end close in 4 hours', 'green-valley-case', 'Sobia Khan', 'Finance Manager', 'Green Valley Schools', 'Education',
             'Fee collection chaos across 2 campuses. One ERP unified fees, payroll and reporting.',
             json_encode([['label' => '98% on-time fees'], ['label' => '-6 days closing']]), 1],
            ['30% faster file recovery', 'battigram-case', 'Asad Ullah', 'Director', 'Battigram Housing', 'Real Estate',
             'Paper plot files were slow and risky. Digitized everything with installment automation.',
             json_encode([['label' => '+30% recovery'], ['label' => '10k files digitized']]), 1],
        ];
        foreach ($rows as $i => [$h, $s, $n, $r, $co, $ind, $q, $m, $f]) {
            $db->table('success_stories')->insert([
                'headline' => $h, 'slug' => $s, 'customer_name' => $n, 'role' => $r,
                'company' => $co, 'industry' => $ind, 'quote' => $q, 'metrics' => $m,
                'is_featured' => $f, 'status' => 'published',
                'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }

    private function seedIntegrations(): void
    {
        $db = \Config\Database::connect();
        if ($db->table('integrations')->countAllResults() > 0) {
            return;
        }
        $rows = [
            ['Stripe', 'stripe', 'fa-brands fa-stripe', 'Accept cards & wallets globally'],
            ['PayPal', 'paypal', 'fa-brands fa-paypal', 'International payment links'],
            ['WhatsApp', 'whatsapp', 'fa-brands fa-whatsapp', 'Receipts, reminders & alerts'],
            ['JazzCash', 'jazzcash', 'fa-solid fa-mobile-screen', 'Mobile wallets PK'],
            ['EasyPaisa', 'easypaisa', 'fa-solid fa-money-bill-transfer', 'Instant local payments'],
            ['Mailchimp', 'mailchimp', 'fa-brands fa-mailchimp', 'Email campaigns from contacts'],
            ['Google Sheets', 'google-sheets', 'fa-brands fa-google', 'Auto-export any report'],
            ['QuickBooks', 'quickbooks', 'fa-solid fa-book', 'Two-way sync if you migrate'],
            ['Bank Feeds', 'bank-feeds', 'fa-solid fa-building-columns', 'Auto-reconciliation'],
            ['Biometric Devices', 'biometric', 'fa-solid fa-fingerprint', 'ZKTeco & more'],
            ['SMS Gateways', 'sms', 'fa-solid fa-comment-sms', 'Bulk OTP & alerts'],
            ['Courier APIs', 'courier', 'fa-solid fa-truck-fast', 'Leopards, TCS, M&P tracking'],
        ];
        foreach ($rows as $i => [$n, $s, $ic, $d]) {
            $db->table('integrations')->insert([
                'name' => $n, 'slug' => $s, 'icon' => $ic, 'description' => $d,
                'url' => null, 'sort_order' => $i, 'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
