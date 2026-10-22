<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table         = 'settings';
    protected $allowedFields = ['key', 'value', 'type', 'group', 'label', 'options', 'sort_order', 'updated_by'];
    protected $useTimestamps = true;

    /** Full settings map cached per request. */
    public static function all(bool $refresh = false): array
    {
        static $cache = null;
        if ($cache === null || $refresh) {
            $cache = [];
            foreach (model(SettingModel::class)->builder()->get()->getResultArray() as $row) {
                $cache[$row['key']] = $row['value'];
            }
        }
        return $cache;
    }

    public static function get(string $key, string $default = ''): string
    {
        $all = self::all();
        $val = $all[$key] ?? null;
        return ($val === null || $val === '') ? $default : (string) $val;
    }

    public function set($key, $value = '', $escape = null, array $meta = [])
    {
        if (is_array($escape)) {
            $meta   = $escape;
            $escape = null;
        }

        $data = array_merge(
            ['key' => $key, 'value' => is_array($value) ? json_encode($value) : (string) $value],
            $meta
        );

        $existing = $this->where('key', $key)->first();

        if ($existing) {
            unset($data['key']);
            $this->builder()->where('key', $key)->set($data)->update();
        } else {
            $this->insert($data, false); // skip validation for programmatic sets
        }

        self::all(true); // bust cache

        return $this;
    }

    public function grouped(string $group): array
    {
        return $this->where('group', $group)->orderBy('sort_order')->findAll();
    }
}
