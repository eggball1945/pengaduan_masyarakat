<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;

class FirebaseService
{
    protected $auth;

    public function __construct()
    {
        $factory = (new Factory)->withServiceAccount(config('firebase.credentials'));
        $this->auth = $factory->createAuth();
    }

    // Kirim OTP (mengembalikan session info)
    public function sendOtp($phone)
    {
        // Firebase client di PHP hanya untuk verifikasi token, OTP dikirim via frontend JS
        // Frontend harus pakai Firebase JS SDK untuk kirim OTP
        return true;
    }

    // Verifikasi OTP
    public function verifyOtp($idToken)
    {
        return $this->auth->verifyIdToken($idToken);
    }
}
