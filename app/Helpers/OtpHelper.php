<?php

namespace App\Helpers;

class OtpHelper{

    public static function generateVerificationCode(): array {
        // Generate 6-digit code
        $code = random_int(100000, 999999);
        
        // Small 8-char hash using CRC32 (compact, fast)
        $hash = sprintf('%08x', crc32($code));
        
        return [
            'code' => $code,
            'hash' => $hash  // Only 8 characters
        ];
    }
}