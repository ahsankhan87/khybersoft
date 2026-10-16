<?php

namespace App\Controllers;

use App\Concerns\HandlesFormSubmissions;
use App\Models\ClientModel;
use App\Models\IntegrationModel;
use App\Models\NewsModel;
use App\Models\ProductModel;
use App\Models\SuccessStoryModel;
use App\Models\TestimonialModel;
use App\Models\SubscriberModel;
use Config\Services;

class Home extends BaseController
{
    use HandlesFormSubmissions;

    public function index()
    {
        $db = \Config\Database::connect();

        // Deep-dive tabs come from a JSON setting (editable in admin → Settings → homepage)
        $tabs = json_decode(setting('deepdive_tabs', '[]'), true) ?: [];

        $data = [
            'title'            => setting('hero_title', 'Business Software That Just Works'),
            'meta_description' => setting('site_description'),
            'productGroups'    => model(ProductModel::class)->groupedActive(4),
            'clients'          => model(ClientModel::class)->active(12),
            'testimonials'     => model(TestimonialModel::class)->featured(8),
            'stories'          => model(SuccessStoryModel::class)->featured(3),
            'storyCount'       => model(SuccessStoryModel::class)->countPublished(),
            'integrations'     => model(IntegrationModel::class)->active(12),
            'deepDiveTabs'     => $tabs,
            'latestPosts'      => $db->table('news')->orderBy('id', 'DESC')->limit(3)->get()->getResultArray(),
            'plans'            => $this->pricingPreview(),
            'jsonLd'           => $this->homepageSchema(),
        ];

        return $this->renderPage('front/home/index', $data);
    }

    /** JSON-LD: Organization + WebSite (+ BreadcrumbList on sub-pages). */
    private function homepageSchema(): array
    {
        $name  = setting('site_name', 'Khybersoft');
        $url   = rtrim((string) config('App')->baseURL, '/');
        $logo  = setting('logo') ? (string) media_url(setting('logo')) : null;

        return [
            [
                '@context' => 'https://schema.org',
                '@type'    => 'Organization',
                'name'     => $name,
                'url'      => $url . '/',
                'logo'     => $logo ?: ($url . '/assets/img/logo.png'),
                'slogan'   => setting('site_tagline', 'Business software that just works'),
                'foundingDate' => '2020',
                'address'  => [
                    '@type'          => 'PostalAddress',
                    'addressLocality'=> setting('company_city', 'Peshawar'),
                    'addressCountry' => 'PK',
                ],
                'contactPoint' => [[
                    '@type'           => 'ContactPoint',
                    'contactType'     => 'sales',
                    'email'           => setting('company_email', ''),
                    'availableLanguage' => ['English', 'Urdu'],
                ]],
                'sameAs' => array_values(array_filter([
                    setting('social_facebook'), setting('social_twitter'),
                    setting('social_linkedin'), setting('social_youtube'),
                ])),
                'aggregateRating' => [
                    '@type'       => 'AggregateRating',
                    'ratingValue' => '4.9',
                    'reviewCount' => '200',
                ],
            ],
            [
                '@context'    => 'https://schema.org',
                '@type'       => 'WebSite',
                'name'        => $name,
                'url'         => $url . '/',
                'description' => setting('site_description', ''),
                'publisher'   => ['@type' => 'Organization', 'name' => $name, 'url' => $url . '/'],
                'potentialAction' => [[
                    '@type'       => 'SearchAction',
                    'target'      => ['@type' => 'EntryPoint', 'urlTemplate' => $url . '/search?q={search_term_string}'],
                    'query-input' => 'required name=search_term_string',
                ]],
            ],
            [
                '@context'        => 'https://schema.org',
                '@type'           => 'BreadcrumbList',
                'itemListElement' => [[
                    '@type'    => 'ListItem',
                    'position' => 1,
                    'name'     => 'Home',
                    'item'     => $url . '/',
                ]],
            ],
        ];
    }

    /** Pricing preview: static defaults until Phase 3 plan tables ship. */
    private function pricingPreview(): array
    {
        return [
            ['name' => 'Starter',  'monthly' => 4999,  'yearly' => 47988, 'tagline' => 'For single shops getting started',
             'features' => ['1 branch, 3 registers', 'POS + Inventory', 'WhatsApp receipts', 'Email support', 'Free setup'], 'popular' => false],
            ['name' => 'Business', 'monthly' => 9999,  'yearly' => 95988, 'tagline' => 'For growing multi-branch teams',
             'features' => ['Up to 5 branches', 'All POS + Accounting modules', 'Advanced reports & analytics', 'Priority support (EN/Urdu)', 'Mobile app included', 'API access'], 'popular' => true],
            ['name' => 'Enterprise','monthly' => null, 'yearly' => null,  'tagline' => 'Custom scale, SLA & on-prem options',
             'features' => ['Unlimited branches', 'Dedicated success manager', 'Custom integrations', 'SSO & audit logs', '99.9% uptime SLA'], 'popular' => false],
        ];
    }

    /**
     * Newsletter signup → unified `subscribers` table with tokens.
     */
    public function subscribe()
    {
        if ($this->request->getMethod() !== 'POST') {
            return redirect()->to('/');
        }

        $started = (int) $this->request->getPost('form_started_at');
        if ($started > 0 && (time() - $started) < 3) {
            return redirect()->back()->with('error', 'Please wait a moment and try again.');
        }

        if (! $this->throttle('subscribe', 3, 60)) {
            return redirect()->back()->with('error', 'Too many attempts. Please wait a minute.')->withInput();
        }

        $email = strtolower(trim((string) $this->request->getPost('email')));
        $name  = trim((string) $this->request->getPost('name'));

        $model = new SubscriberModel();
        $data  = ['email' => $email, 'name' => $name];

        $validation = Services::validation();
        $validation->setRules([
            'email' => 'required|valid_email|is_unique[subscribers.email]',
            'name'  => 'permit_empty|max_length[255]',
        ]);

        if (! $validation->run($data)) {
            return redirect()->back()->with('errors', $validation->getErrors())->withInput();
        }

        $confirmToken = bin2hex(random_bytes(16));
        $unsubToken   = bin2hex(random_bytes(16));

        $id = $model->insert([
            'email'         => $email,
            'name'          => $name ?: null,
            'status'        => 'pending',
            'confirm_token' => $confirmToken,
            'unsub_token'   => $unsubToken,
            'source'        => (string) ($this->request->getPost('source') ?: 'footer-form'),
        ], false);

        if ($id === false) {
            return redirect()->back()->with('error', 'Something went wrong. Please try again.')->withInput();
        }

        $this->sendConfirmEmail($email, $confirmToken);
        $this->notifyAdmins('New newsletter subscriber: ' . $email, '<p><strong>' . esc($email) . '</strong> signed up (' . date('Y-m-d H:i') . ').</p>');

        return redirect()->back()->with('success', 'Almost done! Please click the confirmation link we just emailed you.');
    }

    /** GET /newsletter/confirm/(:token) */
    public function confirm(string $token)
    {
        $model = new SubscriberModel();
        if ($sub = $model->findByToken('confirm_token', $token)) {
            $model->update($sub['id'], [
                'status'        => 'confirmed',
                'confirmed_at'  => date('Y-m-d H:i:s'),
                'confirm_token' => null,
            ]);

            return $this->renderPage('pages/newsletter_done', [
                'title'   => 'Subscription confirmed',
                'heading' => 'You’re in! 🎉',
                'message' => 'Your email is confirmed. Watch your inbox for product updates and tips from Khybersoft.',
            ]);
        }

        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    /** GET /newsletter/unsubscribe/(:token) */
    public function unsubscribe(string $token)
    {
        $model = new SubscriberModel();
        if ($sub = $model->findByToken('unsub_token', $token)) {
            $model->update($sub['id'], ['status' => 'unsubscribed']);
        }

        return $this->renderPage('pages/newsletter_done', [
            'title'   => 'Unsubscribed',
            'heading' => 'You have been unsubscribed',
            'message' => 'You will no longer receive emails from Khybersoft. Sorry to see you go!',
        ]);
    }

    private function sendConfirmEmail(string $to, string $token): void
    {
        try {
            $link  = site_url('newsletter/confirm/' . $token);
            $email = Services::email();
            $email->setTo($to);
            $email->setFrom(setting('company_email', 'no-reply@khybersoft.com'), setting('site_name', 'Khybersoft'));
            $email->setSubject('Confirm your ' . setting('site_name', 'Khybersoft') . ' subscription');
            $email->setHTMLMessage(
                '<p>Hi!</p><p>Please confirm your newsletter subscription:</p>'
                . '<p><a href="' . esc($link) . '">Confirm my email</a></p>'
                . '<p>If you did not request this, simply ignore this message.</p>'
            );
            $email->send();
        } catch (\Throwable $e) {
            log_message('error', 'Confirm email failed: ' . $e->getMessage());
        }
    }
}
