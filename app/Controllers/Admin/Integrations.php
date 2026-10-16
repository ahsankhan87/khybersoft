<?php

namespace App\Controllers\Admin;

use App\Models\ActivityLogModel;
use App\Models\IntegrationModel;

class Integrations extends BaseAdmin
{
    public function index()
    {
        if ($resp = $this->guard('integrations')) { return $resp; }

        return $this->render('admin/integrations/index', [
            'title' => 'Integrations',
            'items' => (new IntegrationModel())->orderBy('id')->findAll(),
        ]);
    }

    public function save(int $id)
    {
        if ($resp = $this->guard('integrations')) { return $resp; }
        $model = new IntegrationModel();
        $item  = $model->find($id);
        if (! $item) {
            return redirect()->to('/admin/integrations')->with('error', 'Not found.');
        }
        $config = (array) ($item['config'] ? json_decode((string) $item['config'], true) : []);
        foreach ((array) $this->request->getPost('config') as $k => $v) {
            if (is_string($v) && str_contains($v, '••••')) { continue; } // keep masked secret untouched
            $config[$k] = trim($v);
        }
        $model->update($id, ['config' => json_encode($config), 'is_active' => $this->request->getPost('is_active') ? 1 : 0]);
        ActivityLogModel::record('save', 'integrations', "Configured {$item['name']}");

        return redirect()->back()->with('success', $item['name'] . ' saved.');
    }

    /** Test a single integration with real API calls. */
    public function test(int $id)
    {
        if ($resp = $this->guard('integrations')) { return $resp; }
        $model = new IntegrationModel();
        $item  = $model->find($id);
        if (! $item) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Not found']);
        }
        $config = json_decode((string) ($item['config'] ?? '{}'), true) ?: [];
        $result = match ($item['slug']) {
            'smtp'          => $this->testSmtp($config),
            'stripe'        => $this->testStripe($config),
            'payoneer'      => ['ok' => true, 'message' => 'Payoneer has no public sandbox API — verify your account ID manually.'],
            'mailchimp'     => $this->testMailchimp($config),
            'brevo'         => $this->testBrevo($config),
            'google_analytics' => ['ok' => true, 'message' => 'GA4 measures via snippet; ensure the tag is present on pages.'],
            'meta_pixel'    => ['ok' => true, 'message' => 'Meta Pixel validates at delivery time; check Events Manager after deploy.'],
            default         => ['ok' => false, 'message' => 'No test available for this integration.'],
        };
        $model->update($id, [
            'last_tested_at' => date('Y-m-d H:i:s'),
            'last_test_status' => ($result['ok'] ?? false) ? 'success' : 'failed',
        ]);
        ActivityLogModel::record('test', 'integrations', "{$item['name']}: " . ($result['message'] ?? ''));

        return $this->response->setJSON($result);
    }

    private function httpGet(string $url, array $headers = []): array
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 15, CURLOPT_HTTPHEADER => $headers]);
        $body = curl_exec($ch);
        $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err  = curl_error($ch);
        curl_close($ch);

        return ['code' => $code, 'body' => (string) $body, 'error' => $err];
    }

    private function testSmtp(array $c): array
    {
        $host = $c['host'] ?? '';
        $port = (int) ($c['port'] ?? 587);
        if ($host === '') {
            return ['ok' => false, 'message' => 'SMTP host is empty.'];
        }
        $conn = @fsockopen($host, $port, $errno, $errstr, 8);
        if (! $conn) {
            return ['ok' => false, 'message' => "Cannot reach {$host}:{$port} — {$errstr}"];
        }
        $banner = fgets($conn, 512);
        fclose($conn);

        return ['ok' => str_starts_with($banner, '220'), 'message' => 'Connection OK: ' . trim($banner)];
    }

    private function testStripe(array $c): array
    {
        $key = $c['secret_key'] ?? '';
        if ($key === '') {
            return ['ok' => false, 'message' => 'Secret key missing.'];
        }
        $r = $this->httpGet('https://api.stripe.com/v1/balance', ['Authorization: Bearer ' . $key]);
        if ($r['code'] === 200) {
            $mode = str_starts_with($key, 'sk_test') ? 'test' : 'live';

            return ['ok' => true, 'message' => "Stripe keys valid ({$mode} mode)."];
        }

        return ['ok' => false, 'message' => 'Stripe rejected the key (HTTP ' . $r['code'] . ').'];
    }

    private function testMailchimp(array $c): array
    {
        $key = $c['api_key'] ?? '';
        $dc = preg_match('/-(us\d+|eu\d+)\z/', $key, $m) ? $m[1] : 'us1';
        if ($key === '') {
            return ['ok' => false, 'message' => 'API key missing.'];
        }
        $r = $this->httpGet("https://{$dc}.api.mailchimp.com/3.0/ping", ['Authorization: Basic ' . base64_encode('anystring:' . $key)]);

        return $r['code'] === 200 ? ['ok' => true, 'message' => 'Mailchimp reachable & authorized.'] : ['ok' => false, 'message' => 'Mailchimp auth failed (HTTP ' . $r['code'] . ').'];
    }

    private function testBrevo(array $c): array
    {
        $key = $c['api_key'] ?? '';
        if ($key === '') {
            return ['ok' => false, 'message' => 'API key missing.'];
        }
        $r = $this->httpGet('https://api.brevo.com/v3/account', ['api-key: ' . $key, 'Accept: application/json']);

        return $r['code'] === 200 ? ['ok' => true, 'message' => 'Brevo authorized.'] : ['ok' => false, 'message' => 'Brevo failed (HTTP ' . $r['code'] . ').'];
    }
}
