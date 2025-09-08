<?php
namespace App\Services;

use Twilio\Rest\Client;

class SmsService
{
    /**
     * Kirim SMS via Twilio
     *
     * @param string $to Nomor tujuan, harus lengkap dengan kode negara, misal +628123456789
     * @param string $message Pesan yang dikirim
     * @return bool|string True jika berhasil, pesan error jika gagal
     */
    public static function send($to, $message)
    {
        $sid    = env('TWILIO_SID');
        $token  = env('TWILIO_AUTH_TOKEN');
        $from   = env('TWILIO_FROM');

        // Validasi konfigurasi
        if (!$sid || !$token || !$from) {
            return "Twilio credentials belum dikonfigurasi di .env";
        }

        // Pastikan nomor tujuan diawali '+' dan kode negara
        if (!preg_match('/^\+\d+$/', $to)) {
            return "Format nomor tujuan salah, harus diawali + dan kode negara";
        }

        try {
            $client = new Client($sid, $token);
            $client->messages->create($to, [
                'from' => $from,
                'body' => $message
            ]);

            return true; // sukses
        } catch (\Exception $e) {
            // Kembalikan pesan error supaya bisa ditangkap di controller
            return "Gagal mengirim SMS: " . $e->getMessage();
        }
    }
}
