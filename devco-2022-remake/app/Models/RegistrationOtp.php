<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationOtp extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'otp', 'expires_at', 'used'];
    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function isExpired()
    {
        return now()->isAfter($this->expires_at);
    }

    public static function generateOtp()
    {
        return str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    public static function createForEmail($email)
    {
        $otp = self::generateOtp();
        return self::updateOrCreate(
            ['email' => $email],
            [
                'otp' => $otp,
                'expires_at' => now()->addMinutes(10),
                'used' => false,
            ]
        );
    }
}
