<?php

namespace App\Libraries;

/**
 * RFC-6238 TOTP (2FA) — zero-dependency implementation for cPanel shared hosting.
 * Compatible with Google Authenticator / Authy / 1Password.
 */
class Totp
{
    private const ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';

    /** Generate a random base32 secret (16 chars ≈ 80 bits). */
    public static function generateSecret(int $bytes = 10): string
    {
        return self::base32Encode(random_bytes($bytes));
    }

    /** otpauth:// URI for QR codes (render QR client-side, no libs needed). */
    public static function provisioningUri(string $secret, string $email, string $issuer = 'Khybersoft Admin'): string
    {
        return 'otpauth://totp/' . rawurlencode($issuer . ':' . $email)
            . '?secret=' . $secret
            . '&issuer=' . rawurlencode($issuer)
            . '&algorithm=SHA1&digits=6&period=30';
    }

    /** Verify a 6-digit code with ±1 time-step drift; optionally consume backup codes. */
    public static function verify(string $secret, string $code, int $window = 1): bool
    {
        $code = preg_replace('/\D/', '', $code);
        if (strlen($code) !== 6) {
            return false;
        }
        $counter = intdiv(time(), 30);
        for ($i = -$window; $i <= $window; $i++) {
            if (hash_equals(self::codeAt($secret, $counter + $i), $code)) {
                return true;
            }
        }

        return false;
    }

    public static function codeAt(string $secret, int $counter): string
    {
        $bin = self::base32Decode($secret);
        if ($bin === '') {
            return '000000';
        }
        $packed = pack('N*', 0) . pack('N*', $counter);
        $hash   = hash_hmac('sha1', $packed, $bin, true);
        $offset = ord($hash[19]) & 0x0F;
        $value  = ((ord($hash[$offset]) & 0x7F) << 24)
            | ((ord($hash[$offset + 1]) & 0xFF) << 16)
            | ((ord($hash[$offset + 2]) & 0xFF) << 8)
            | (ord($hash[$offset + 3]) & 0xFF);

        return str_pad((string) ($value % 1000000), 6, '0', STR_PAD_LEFT);
    }

    /** Generate 8 single-use recovery codes (hashed for storage). */
    public static function generateBackupCodes(int $count = 8): array
    {
        $plain  = [];
        $hashed = [];
        for ($i = 0; $i < $count; $i++) {
            $code     = substr(strtoupper(bin2hex(random_bytes(5))), 0, 10);
            $plain[]  = $code;
            $hashed[] = password_hash($code, PASSWORD_DEFAULT);
        }

        return ['plain' => $plain, 'hashed' => $hashed];
    }

    public static function matchBackupCode(string $input, array $hashedCodes): ?int
    {
        foreach ($hashedCodes as $i => $hash) {
            if (password_verify($input, $hash)) {
                return $i;
            }
        }

        return null;
    }

    private static function base32Encode(string $data): string
    {
        $out      = '';
        $bits     = 0;
        $current  = 0;
        for ($len = strlen($data), $i = 0; $i < $len; $i++) {
            $current = ($current << 8) | ord($data[$i]);
            $bits   += 8;
            while ($bits >= 5) {
                $bits -= 5;
                $out  .= self::ALPHABET[($current >> $bits) & 31];
            }
        }
        if ($bits > 0) {
            $out .= self::ALPHABET[($current << (5 - $bits)) & 31];
        }

        return $out;
    }

    private static function base32Decode(string $b32): string
    {
        $b32   = strtoupper(preg_replace('/[^A-Z2-7]/', '', $b32));
        $map   = array_flip(str_split(self::ALPHABET));
        $bits  = 0;
        $value = 0;
        $out   = '';
        for ($len = strlen($b32), $i = 0; $i < $len; $i++) {
            $value = ($value << 5) | $map[$b32[$i]];
            $bits += 5;
            if ($bits >= 8) {
                $bits -= 8;
                $out  .= chr(($value >> $bits) & 255);
            }
        }

        return $out;
    }
}
