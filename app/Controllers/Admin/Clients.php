<?php

namespace App\Controllers\Admin;

use App\Concerns\HasAdminCrud;
use App\Models\ActivityLogModel;
use App\Models\ClientModel;

class Clients extends BaseAdmin
{
    use HasAdminCrud;

    protected string $module     = 'clients';
    protected string $modelClass = ClientModel::class;
    protected array  $fields     = ['company_name', 'logo', 'website', 'industry', 'sort_order'];
    protected array  $booleans   = ['is_active'];
    protected array  $rules      = ['company_name' => 'required|max_length[150]'];

    public function index()
    {
        return $this->render('admin/clients/index', [
            'title' => 'Clients (Logo Wall)',
            'items' => (new ClientModel())->orderBy('sort_order')->orderBy('id', 'desc')->findAll(),
        ]);
    }

    public function create()
    {
        return $this->form(null);
    }

    public function edit(int $id)
    {
        return $this->form($id);
    }

    private function form(?int $id)
    {
        if ($resp = $this->guard()) { return $resp; }

        $item = $id ? (new ClientModel())->find($id) : null;
        if ($id && ! $item) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return $this->render('admin/clients/form', [
            'title' => $id ? 'Edit Client' : 'Add Client',
            'item'  => $item,
        ]);
    }

    private ?int $savingId = null;

    public function save(?int $id = null)
    {
        if ($resp = $this->guard()) { return $resp; }

        if ($error = $this->validateLogoUpload()) {
            return redirect()->back()->withInput()->with('error', $error);
        }

        $this->savingId = $id;

        return $this->persist($id);
    }

    /** Validate an incoming logo_file upload, if any. Returns error string or null. */
    private function validateLogoUpload(): ?string
    {
        $file = $this->request->getFile('logo_file');
        if (! $file || ! $file->isValid() || $file->getSize() === 0) {
            return null; // no upload attempted
        }

        $allowedMime = ['image/jpeg', 'image/png', 'image/webp', 'image/gif', 'image/svg+xml'];
        if (! in_array($file->getMimeType(), $allowedMime, true)) {
            return 'Logo must be an image (JPG, PNG, WebP, GIF or SVG).';
        }
        if ($file->getSize() > 2 * 1024 * 1024) {
            return 'Logo must be under 2 MB.';
        }

        return null;
    }

    /** Hook into HasAdminCrud::collect() — store the uploaded logo into the save payload. */
    protected function beforeSaveData(array &$data): void
    {
        $file = $this->request->getFile('logo_file');
        if (! $file || ! $file->isValid() || $file->getSize() === 0) {
            return;
        }

        $dir = ROOTPATH . 'uploads/clients';
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $ext  = strtolower($file->getClientExtension()) ?: 'png';
        $name = bin2hex(random_bytes(8)) . '.' . $ext;
        $file->move($dir, $name);

        // Remove the old uploaded logo when replacing it.
        if ($this->savingId) {
            $old = (new ClientModel())->find($this->savingId);
            if ($old && ! empty($old['logo']) && str_starts_with((string) $old['logo'], 'uploads/clients/') && is_file(ROOTPATH . $old['logo'])) {
                unlink(ROOTPATH . $old['logo']);
            }
        }

        $data['logo'] = 'uploads/clients/' . $name;
        ActivityLogModel::record('upload', 'clients', 'Logo uploaded', $data['logo']);
    }

    public function delete(int $id)
    {
        if ($resp = $this->guard()) { return $resp; }

        // Remove the uploaded logo file before deleting the record.
        $client = (new ClientModel())->find($id);
        if ($client && ! empty($client['logo']) && str_starts_with((string) $client['logo'], 'uploads/clients/') && is_file(ROOTPATH . $client['logo'])) {
            unlink(ROOTPATH . $client['logo']);
        }

        return $this->destroy($id);
    }

    public function toggle(int $id)
    {
        return $this->toggleActive($id);
    }

    protected function listUrl(): string
    {
        return '/admin/clients';
    }
}
