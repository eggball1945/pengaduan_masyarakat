<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Models\Masyarakat;
use App\Services\SmsService;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    /**
     * Kirim OTP via SMS untuk reset password
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'nik' => 'required|exists:tb_masyarakat,nik',
            'telepon' => 'required',
        ]);

        $user = Masyarakat::where('nik', $request->nik)->first();

        if ($user->telepon !== $request->telepon) {
            return back()->with('error', 'Nomor telepon tidak sesuai.');
        }

        // Generate OTP 6 digit
        $token = rand(100000, 999999);

        // Simpan atau update OTP di tabel password_resets
        PasswordReset::updateOrCreate(
            ['nik' => $request->nik],
            ['token' => $token, 'created_at' => now()]
        );

        // Kirim OTP via SMS menggunakan SmsService
        $result = SmsService::send($user->telepon, "OTP untuk reset password Anda: $token");

        if ($result !== true) {
            // Jika SmsService mengembalikan string error
            return back()->with('error', $result);
        }

        // Simpan nik di session agar form OTP otomatis terisi
        session(['otp_nik' => $request->nik]);

        return back()->with('success', 'OTP telah dikirim ke nomor telepon Anda. Silahkan periksa SMS Anda.');
    }

    /**
     * Verifikasi OTP
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'nik' => 'required',
            'otp' => 'required',
        ]);

        $reset = PasswordReset::where('nik', $request->nik)->first();

        if (!$reset) {
            return back()->with('error', 'OTP tidak ditemukan.');
        }

        // Periksa masa berlaku OTP (10 menit)
        if (Carbon::parse($reset->created_at)->addMinutes(10)->isPast()) {
            return back()->with('error', 'OTP sudah kadaluarsa.');
        }

        if ($reset->token != $request->otp) {
            return back()->with('error', 'OTP salah.');
        }

        // Simpan session agar bisa reset password
        session(['reset_nik' => $request->nik]);

        return back()->with('showReset', true);
    }

    /**
     * Reset password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'nik' => 'required|exists:tb_masyarakat,nik',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = Masyarakat::where('nik', $request->nik)->first();

        if (!$user) {
            return back()->with('error', 'Pengguna tidak ditemukan.');
        }

        $user->password = bcrypt($request->password);
        $user->save();

        // Hapus OTP setelah berhasil reset
        PasswordReset::where('nik', $request->nik)->delete();

        // Hapus session reset_nik
        $request->session()->forget('reset_nik');

        return redirect()->route('login')->with('success', 'Password berhasil direset.');
    }
}
