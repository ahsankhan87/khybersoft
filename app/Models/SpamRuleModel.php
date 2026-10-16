<?php

namespace App\Models;

use CodeIgniter\Model;

class SpamRuleModel extends Model
{
    protected $table         = 'spam_rules';
    protected $allowedFields = ['rule_type', 'value', 'notes', 'is_active'];
    protected $useTimestamps = true;
    protected $returnType    = 'array';

    public static function isSpam(string $ip, string $email, string $text): bool
    {
        try {
            foreach (model(self::class)->where('is_active', 1)->findAll() as $rule) {
                if ($rule['rule_type'] === 'ip' && fnmatch($rule['value'], $ip)) { return true; }
                if ($rule['rule_type'] === 'email_domain' && str_ends_with(strtolower($email), '@' . strtolower($rule['value']))) { return true; }
                if ($rule['rule_type'] === 'keyword' && stripos($text, $rule['value']) !== false) { return true; }
            }
        } catch (\Throwable $e) {
            log_message('error', 'SpamRule check failed: ' . $e->getMessage());
        }

        return false;
    }
}
