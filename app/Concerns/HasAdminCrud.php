<?php

namespace App\Concerns;

use App\Models\ActivityLogModel;
use App\Models\Admin\AdminUserModel;
use App\Models\Admin\RoleModel;

/**
 * Shared CRUD plumbing for admin module controllers.
 * Using class defines: $module (permission + log key), $modelClass, $fields,
 * optional $booleans, $rules, $slugSource, and may override beforeSaveData()/afterSave().
 */
trait HasAdminCrud
{
    /** Permission gate (also enforced by route filter — defence in depth). */
    protected function guard(?string $perm = null)
    {
        $perm ??= ($this->module ?? 'dashboard');
        $user   = (new AdminUserModel())->withRole((int) session()->get('admin_id'));
        if (! (new RoleModel())->can($user['role_slug'] ?? null, $perm)) {
            return redirect()->to('/admin')->with('error', 'You do not have permission to access that area.');
        }

        return null;
    }

    protected function slugify(string $value): string
    {
        return trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($value)), '-') ?: 'item-' . time();
    }

    /** Collect whitelisted fields from POST into a save array. */
    protected function collect(): array
    {
        $req  = service('request');
        $data = [];
        foreach ($this->fields as $field) {
            $val = $req->getPost($field);
            if ($val !== null) {
                $data[$field] = is_array($val) ? json_encode($val) : trim((string) $val);
            }
        }
        foreach ($this->booleans ?? [] as $boolField) {
            $data[$boolField] = $req->getPost($boolField) ? 1 : 0;
        }
        if (! empty($this->slugSource) && isset($data[$this->slugSource]) && empty($data['slug'])) {
            $data['slug'] = $this->slugify((string) $data[$this->slugSource]);
        }
        if (array_key_exists('status', $data) && $data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = date('Y-m-d H:i:s');
        }
        if (method_exists($this, 'beforeSaveData')) {
            $this->beforeSaveData($data);
        }

        return $data;
    }

    protected function validateRules(array $rules, ?int $id): bool
    {
        if ($id !== null) {
            foreach ($rules as $k => $r) {
                if (is_string($r)) {
                    $rules[$k] = str_replace('{id}', (string) $id, $r);
                }
            }
        }
        $this->validator = service('validation');
        $this->validator->setRules($rules);
        if ($this->validator->run(service('request')->getPost())) {
            return true;
        }
        service('session')->setFlashdata('errors', $this->validator->getErrors());

        return false;
    }

    /** Standard create/update handler. */
    protected function persist(?int $id = null)
    {
        if ($resp = $this->guard()) { return $resp; }

        $model = new ($this->modelClass)();
        $data  = $this->collect();

        if (! empty($this->rules) && ! $this->validateRules($this->rules, $id)) {
            return redirect()->back()->withInput();
        }

        if ($id !== null) {
            $model->update($id, $data);
            ActivityLogModel::record('update', $this->module, "Updated #{$id}", $this->logTarget($data));
        } else {
            $id = $model->insert($data);
            ActivityLogModel::record('create', $this->module, 'Created new record', $this->logTarget($data));
        }

        if (method_exists($this, 'afterSave')) {
            $this->afterSave((int) $id, $data);
        }

        return redirect()->to($this->listUrl())->with('success', $this->savedMessage ?? 'Saved successfully.');
    }

    protected function destroy(int $id)
    {
        if ($resp = $this->guard()) { return $resp; }
        (new ($this->modelClass)())->delete($id);
        ActivityLogModel::record('delete', $this->module, "Deleted #{$id}");

        return redirect()->to($this->listUrl())->with('success', 'Deleted.');
    }

    protected function toggleActive(int $id, string $flag = 'is_active')
    {
        if ($resp = $this->guard()) { return $resp; }
        $model = new ($this->modelClass)();
        $row   = $model->find($id);
        if ($row) {
            $model->update($id, [$flag => ! empty($row[$flag]) ? 0 : 1]);
            ActivityLogModel::record('toggle', $this->module, "Toggled #{$id} ({$flag})");
        }

        return redirect()->to($this->listUrl())->with('success', 'Toggled.');
    }

    /** Bulk action over ids[] with action delete|activate|deactivate. */
    protected function bulk(string $redirectBack)
    {
        if ($resp = $this->guard()) { return $resp; }
        $ids    = array_filter((array) service('request')->getPost('ids'), 'is_numeric');
        $action = (string) service('request')->getPost('bulk_action');
        $model  = new ($this->modelClass)();
        foreach ($ids as $id) {
            match ($action) {
                'delete'     => $model->delete((int) $id),
                'activate'   => $model->update((int) $id, ['is_active' => 1]),
                'deactivate' => $model->update((int) $id, ['is_active' => 0]),
                default      => null,
            };
        }
        ActivityLogModel::record('bulk-' . $action, $this->module, count($ids) . ' records');

        return redirect()->to($redirectBack)->with('success', 'Bulk action applied to ' . count($ids) . ' items.');
    }

    protected function logTarget(array $data): ?string
    {
        foreach (['name', 'title', 'question', 'company_name', 'message'] as $k) {
            if (isset($data[$k])) {
                return mb_substr((string) $data[$k], 0, 180);
            }
        }

        return null;
    }

    protected function listUrl(): string
    {
        return '/admin/' . ($this->module ?? 'dashboard');
    }
}
