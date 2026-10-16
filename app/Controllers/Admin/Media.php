<?php

namespace App\Controllers\Admin;

use App\Concerns\HasAdminCrud;
use App\Models\ActivityLogModel;
use App\Models\MediaModel;

class Media extends BaseAdmin
{
    use HasAdminCrud;

    protected string $module     = 'media';
    protected string $modelClass = MediaModel::class;
    protected array  $fields     = ['name', 'alt_text', 'folder'];

    public function index()
    {
        return $this->render('admin/media/index', [
            'title'   => 'Media Library',
            'items'   => (new MediaModel())->listFiltered([
                'kind'   => (string) $this->request->getGet('kind'),
                'folder' => (string) $this->request->getGet('folder'),
                'q'      => (string) $this->request->getGet('q'),
            ]),
            'folders' => (new MediaModel())->folders(),
        ]);
    }

    public function upload()
    {
        if ($resp = $this->guard()) { return $resp; }

        $file = $this->request->getFile('file');
        if (! $file || ! $file->isValid()) {
            return redirect()->back()->with('error', 'No valid file received.');
        }

        // Strict validation: real image/pdf/mp4 only, 8 MB cap.
        $allowedMime = ['image/jpeg', 'image/png', 'image/webp', 'image/gif', 'image/svg+xml', 'application/pdf', 'video/mp4'];
        if (! in_array($file->getMimeType(), $allowedMime, true)) {
            ActivityLogModel::record('upload-rejected', 'media', 'Rejected MIME: ' . $file->getMimeType());

            return redirect()->back()->with('error', 'File type not allowed.');
        }
        if ($file->getSize() > 8 * 1024 * 1024) {
            return redirect()->back()->with('error', 'Max file size is 8 MB.');
        }

        $folder = preg_replace('/[^a-z0-9\-]/i', '', (string) $this->request->getPost('folder')) ?: 'general';
        $subDir = 'uploads/' . date('Y/m') . '/' . $folder;
        $fullDir = ROOTPATH . 'public/' . $subDir;
        if (! is_dir($fullDir)) {
            mkdir($fullDir, 0755, true);
        }

        $ext  = strtolower($file->getClientExtension()) ?: 'bin';
        $name = bin2hex(random_bytes(8)) . '.' . $ext;
        $file->move($fullDir, $name);

        $relPath = $subDir . '/' . $name;
        $width = $height = null;
        $thumb = null;
        if (str_starts_with($file->getMimeType(), 'image/') && $file->getMimeType() !== 'image/svg+xml') {
            $info = @getimagesize(ROOTPATH . 'public/' . $relPath);
            if ($info) {
                [$width, $height] = $info;
                $thumb = $this->makeThumb($relPath, $subDir, $name, $width, $height);
            }
        }

        (new MediaModel())->insert([
            'name'        => $file->getClientName(),
            'path'        => $relPath,
            'thumb_path'  => $thumb,
            'mime'        => $file->getMimeType(),
            'kind'        => str_starts_with($file->getMimeType(), 'image/') ? 'image' : (str_starts_with($file->getMimeType(), 'video/') ? 'video' : 'document'),
            'size_kb'     => (int) round($file->getSize() / 1024),
            'width'       => $width,
            'height'      => $height,
            'alt_text'    => (string) $this->request->getPost('alt_text'),
            'folder'      => $folder,
            'uploaded_by' => session()->get('admin_id'),
        ]);
        ActivityLogModel::record('upload', 'media', $file->getClientName(), $relPath);

        return redirect()->to('/admin/media')->with('success', 'Uploaded.');
    }

    private function makeThumb(string $relPath, string $subDir, string $name, int $w, int $h): ?string
    {
        try {
            $image = service('images')->withPath(ROOTPATH . 'public/' . $relPath);
            $thumbRel = $subDir . '/thumb_' . $name;
            $image->resize(480, 480, false)->save(ROOTPATH . 'public/' . $thumbRel);

            return $thumbRel;
        } catch (\Throwable $e) {
            log_message('debug', 'Thumb failed: ' . $e->getMessage());

            return null;
        }
    }

    public function update(int $id)
    {
        return $this->save($id);
    }

    public function delete(int $id)
    {
        if ($resp = $this->guard()) { return $resp; }
        $model = new MediaModel();
        if ($item = $model->find($id)) {
            foreach ([$item['path'], $item['thumb_path']] as $p) {
                if ($p && is_file(ROOTPATH . 'public/' . $p)) {
                    unlink(ROOTPATH . 'public/' . $p);
                }
            }
            $model->delete($id);
            ActivityLogModel::record('delete', 'media', $item['name']);
        }

        return redirect()->to('/admin/media')->with('success', 'Deleted.');
    }

    public function bulkDelete()
    {
        return $this->bulk('/admin/media');
    }

    /** JSON picker for modals / pickers elsewhere in the panel. */
    public function listJson()
    {
        return $this->response->setJSON((new MediaModel())->listFiltered(['q' => (string) $this->request->getGet('q')]));
    }
}
