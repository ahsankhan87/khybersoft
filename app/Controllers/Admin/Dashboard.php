<?php

namespace App\Controllers\Admin;

use App\Models\LeadModel;
use App\Models\SubscriberModel;

class Dashboard extends BaseAdmin
{
    public function index()
    {
        $newLeads = (new LeadModel())->where('status', 'new')->countAllResults();
        $quoteLeads = (new LeadModel())->where('type', 'quote')->where('status', 'new')->countAllResults();
        $subscribers = (new SubscriberModel())->countAllResults();
        $recentLeads = (new LeadModel())->orderBy('id', 'desc')->limit(10)->findAll();

        return $this->render('admin/dashboard/index', [
            'title'       => 'Dashboard',
            'newLeads'    => $newLeads,
            'quoteLeads'  => $quoteLeads,
            'subscribers' => $subscribers,
            'recentLeads' => $recentLeads,
        ]);
    }
}
