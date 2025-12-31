<?php

namespace App\Controllers;

use App\Models\ContactModel;
use App\Models\CustomDevelopmentQuoteModel;
use App\Models\SubscriberModel;

class Panel extends BaseController
{
    public function __construct()
    {
        helper(['url']);
    }

    public function index()
    {
        $quotesModel = new CustomDevelopmentQuoteModel();
        $contactsModel = new ContactModel();
        $subscribersModel = new SubscriberModel();

        $data = [
            'title' => 'Admin Panel - Khybersoft',
            'meta_description' => 'Admin panel for viewing quotes, contacts, and subscribers.',
            'counts' => [
                'quotes' => $quotesModel->countAllResults(),
                'contacts' => $contactsModel->countAllResults(),
                'subscribers' => $subscribersModel->countAllResults(),
            ],
        ];

        return view('panel/layouts/header', $data)
            . view('panel/index', $data)
            . view('panel/layouts/footer');
    }

    public function quotes()
    {
        $model = new CustomDevelopmentQuoteModel();

        $quotes = $model->orderBy('id', 'DESC')->paginate(20, 'panel_quotes');

        $data = [
            'title' => 'Quote Requests - Admin Panel',
            'meta_description' => 'View custom development quote requests.',
            'quotes' => $quotes,
            'pager' => $model->pager,
            'pagerGroup' => 'panel_quotes',
        ];

        return view('panel/layouts/header', $data)
            . view('panel/quotes', $data)
            . view('panel/layouts/footer');
    }

    public function contacts()
    {
        $model = new ContactModel();

        $contacts = $model->orderBy('id', 'DESC')->paginate(20, 'panel_contacts');

        $data = [
            'title' => 'Contact Messages - Admin Panel',
            'meta_description' => 'View contact form messages.',
            'contacts' => $contacts,
            'pager' => $model->pager,
            'pagerGroup' => 'panel_contacts',
        ];

        return view('panel/layouts/header', $data)
            . view('panel/contacts', $data)
            . view('panel/layouts/footer');
    }

    public function subscribers()
    {
        $model = new SubscriberModel();

        $subscribers = $model->orderBy('id', 'DESC')->paginate(20, 'panel_subscribers');

        $data = [
            'title' => 'Subscribers - Admin Panel',
            'meta_description' => 'View newsletter subscribers.',
            'subscribers' => $subscribers,
            'pager' => $model->pager,
            'pagerGroup' => 'panel_subscribers',
        ];

        return view('panel/layouts/header', $data)
            . view('panel/subscribers', $data)
            . view('panel/layouts/footer');
    }
}
