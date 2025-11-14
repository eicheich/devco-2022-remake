<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RegistrationOtp;
use App\Mail\OtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegistrationController extends Controller
{
    public function showEmailForm()
    {
        return view('auth.register-email');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
        ], [
            'email.unique' => 'Email sudah terdaftar',
        ]);

        // Throttle: max 3 OTP per email per hour
        $recentCount = RegistrationOtp::where('email', $request->email)
            ->where('created_at', '>', now()->subHour())
            ->count();

        if ($recentCount >= 3) {
            return back()->withErrors(['email' => 'Terlalu banyak percobaan. Coba lagi dalam 1 jam.']);
        }

        $otpRecord = RegistrationOtp::createForEmail($request->email);

        // Send OTP via email
        Mail::to($request->email)->send(new OtpMail($otpRecord->otp, $request->email));

        return redirect()->route('register.verify')->with([
            'email' => $request->email,
            'success' => 'OTP telah dikirim ke email Anda',
        ]);
    }

    public function showVerifyForm()
    {
        return view('auth.register-verify');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ]);

        $otpRecord = RegistrationOtp::where('email', $request->email)->first();

        if (!$otpRecord) {
            return back()->withErrors(['otp' => 'OTP tidak ditemukan']);
        }

        if ($otpRecord->isExpired()) {
            $otpRecord->delete();
            return back()->withErrors(['otp' => 'OTP telah kadaluarsa']);
        }

        if ($otpRecord->otp !== $request->otp) {
            return back()->withErrors(['otp' => 'OTP salah']);
        }

        if ($otpRecord->used) {
            return back()->withErrors(['otp' => 'OTP sudah digunakan']);
        }

        $otpRecord->update(['used' => true]);

        session(['email' => $request->email, 'otp_verified' => true]);

        return redirect()->route('register.password');
    }

    public function showPasswordForm()
    {
        if (!session('otp_verified')) {
            return redirect()->route('register.email');
        }

        return view('auth.register-password');
    }

    public function completeRegistration(Request $request)
    {
        if (!session('otp_verified')) {
            return redirect()->route('register.email');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username|regex:/^[a-zA-Z0-9_]+$/',
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'required|date|before:today',
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'username.unique' => 'Username sudah digunakan, silakan pilih yang lain',
            'username.regex' => 'Username hanya boleh mengandung huruf, angka, dan underscore',
            'date_of_birth.before' => 'Tanggal lahir harus sebelum hari ini'
        ]);

        $email = session('email');

        if (!$email) {
            return redirect()->route('register.email')->withErrors(['email' => 'Session expired, silakan coba lagi']);
        }

        // Check if email already registered (extra safety)
        if (User::where('email', $email)->exists()) {
            return back()->withErrors(['email' => 'Email sudah terdaftar']);
        }

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $email,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'password' => Hash::make($request->password),
        ]);

        // Clean up OTP record and session
        RegistrationOtp::where('email', $email)->delete();
        session()->forget(['email', 'otp_verified']);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan login.');
    }
}
