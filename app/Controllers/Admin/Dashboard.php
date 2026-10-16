<?php

namespace App\Controllers\Admin;

use App\Models\ActivityLogModel;
use App\Models\CareerModel;
use App\Models\CommentModel;
use App\Models\ContactModel;
use App\Models\CustomDevelopmentQuoteModel;
use App\Models\DemoRequestModel;
use App\Models\IntegrationModel;
use App\Models\LeadModel;
use App\Models\LoginAttemptModel;
use App\Models\PostModel;
use App\Models\ProductModel;
use App\Models\TestimonialModel;
use App\Models\WhatsappClickModel;

class Dashboard extends BaseAdmin
{
    public function index()
    {
        $leads      = new LeadModel();
        $contacts   = new ContactModel();
        $demos      = new DemoRequestModel();
        $quotes     = new CustomDevelopmentQuoteModel();
        $integr     = new IntegrationModel();
        $testimonials = new TestimonialModel();
        $comments   = new CommentModel();

        // 14-day lead trend (new leads per day) — pure SQL, no plugins.
        $trend = [];
        for ($i = 13; $i >= 0; $i--) {
            $day   = date('Y-m-d', strtotime("-{$i} days"));
            $trend[$day] = $leads->where('created_at >=', $day . ' 00:00:00')
                                 ->where('created_at <=', $day . ' 23:59:59')
                                 ->countAllResults();
        }

        return $this->render('admin/dashboard/index', [
            'title' => 'Dashboard',
            'stats' => [
                'leads'          => $leads->countAllResults(),
                'leads_new'      => $leads->where('status', 'new')->countAllResults(),
                'contacts'       => $contacts->where('status', '!=', 'archived')->countAllResults(),
                'demos'          => $demos->where('status', 'pending')->countAllResults(),
                'quotes'         => $quotes->where('status', 'new')->countAllResults(),
                'integrations'   => $integr->where('status', 'pending')->countAllResults(),
                'products'       => (new ProductModel())->where('status', 'active')->countAllResults(),
                'posts_published'=> (new PostModel())->where('status', 'published')->countAllResults(),
                'testimonials_pending' => $testimonials->where('status', 'pending')->countAllResults(),
                'comments_pending'     => $comments->where('status', 'pending')->countAllResults(),
                'careers_open'   => (new CareerModel())->where('is_open', 1)->countAllResults(),
                'whatsapp_today' => (new WhatsappClickModel())->countToday(),
            ],
            'trend'        => $trend,
            'recentLeads'  => $leads->orderBy('id', 'desc')->limit(6)->findAll(),
            'recentDemos'  => $demos->orderBy('id', 'desc')->limit(4)->findAll(),
            'recentQuotes' => $quotes->orderBy('id', 'desc')->limit(4)->findAll(),
            'activity'     => (new ActivityLogModel())->recent(10),
            'failedLogins' => (new LoginAttemptModel())->where('success', 0)->where('created_at >=', date('Y-m-d H:i:s', time() - 86400))->countAllResults(),
        ]);
    }
}
