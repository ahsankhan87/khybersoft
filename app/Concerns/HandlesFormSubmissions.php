<?php

namespace App\Concerns;

use App\Models\Admin\SettingModel;
use App\Models\LeadModel;

/**
 * Shared logic for every public form (contact, quote, demo…).
 * - per-IP rate limiting (session based – safe on shared hosting)
 * - honeypot handled by CI's `honeypot` filter on the route
 * - unified write into `leads` + optional email notification
 */
trait HandlesFormSubmissions
{
    protected function throttle(string $key, int $max = 5, int $seconds = 3600): bool
    {
        $session = session();
        $hits    = $session->get('_rate_' . $key) ?? [];
        $now     = time();
        $hits    = array_values(array_filter($hits, static fn ($t) => $now - $t < $seconds));

        if (count($hits) >= $max) {
            return false;
        }
        $hits[] = $now;
        $session->set('_rate_' . $key, $hits);

        return true;
    }

    protected function captureUtm(): ?array
    {
        $keys = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content'];
        $utm  = [];
        foreach ($keys as $k) {
            if ($v = $this->request->getGet($k)) {
                $utm[$k] = mb_substr((string) $v, 0, 100);
            }
        }

        return $utm ?: null;
    }

    /** Persist a lead. Returns insert id or false. */
    protected function recordLead(string $type, array $fields): bool|int
    {
        $leads = new LeadModel();

        return $leads->insert(array_merge([
            'type'        => $type,
            'source_page' => '/' . ltrim($this->request->uri->getPath() ?? '', '/'),
            'utm'         => $this->captureUtm(),
            'ip_hash'     => hash('sha256', ($this->request->ipAddress() ?? '') . '|khybersoft'),
            'status'      => 'new',
        ], $fields), false);
    }

    protected function notifyAdmins(string $subject, string $bodyHtml): void
    {
        $to = SettingModel::get('admin_notify_email') ?: SettingModel::get('company_email', 'hello@khybersoft.com');
        if (! $to) {
            return;
        }
        try {
            $email = service('email');
            $email->setTo($to);
            $email->setFrom(SettingModel::get('company_email', 'no-reply@khybersoft.com'), SettingModel::get('site_name', 'Khybersoft'));
            $email->setSubject($subject);
            $email->setHTMLMessage($bodyHtml);
            $email->send();
        } catch (\Throwable $e) {
            log_message('error', 'Admin notify failed: ' . $e->getMessage());
        }
    }
}
