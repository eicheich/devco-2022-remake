<?php

namespace App\Http\Controllers;

use App\Models\PasswordReset;
use App\Models\User;
use App\Mail\PasswordResetMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    // ========== CHANGE PASSWORD (dari settings, perlu login) ==========

    /**
     * Show form untuk masukkan email (confirm identity)
     */
    public function showChangeForm()
    {
        return view('auth.change-password-email');
    }

    /**
     * Send OTP untuk change password
     */
    public function sendChangeOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->email;

        // Pastikan email sama dengan user yang login
        if ($email !== Auth::user()->email) {
            return back()->withErrors(['email' => 'Email does not match your account.']);
        }

        // Rate limiting - max 3 OTP per hour
        $key = 'change-password-otp:' . $email;
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors(['email' => "Too many attempts. Please try again in " . ceil($seconds / 60) . " minutes."]);
        }

        RateLimiter::hit($key, 3600);

        // Generate dan kirim OTP
        $passwordReset = PasswordReset::createForEmail($email, 'change');
        Mail::to($email)->send(new PasswordResetMail($passwordReset->otp, $email, 'change'));

        session(['change_password_email' => $email]);

        return redirect()->route('password.change.verify')->with('success', 'OTP has been sent to your email!');
    }

    /**
     * Show form verify OTP
     */
    public function showChangeVerifyForm()
    {
        if (!session('change_password_email')) {
            return redirect()->route('password.change');
        }

        return view('auth.change-password-verify', [
            'email' => session('change_password_email')
        ]);
    }

    /**
     * Verify OTP untuk change password
     */
    public function verifyChangeOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $email = session('change_password_email');
        if (!$email) {
            return redirect()->route('password.change');
        }

        $passwordReset = PasswordReset::where('email', $email)
            ->where('type', 'change')
            ->where('otp', $request->otp)
            ->where('used', false)
            ->first();

        if (!$passwordReset) {
            return back()->withErrors(['otp' => 'Invalid OTP code.']);
        }

        if ($passwordReset->isExpired()) {
            return back()->withErrors(['otp' => 'OTP has expired. Please request a new one.']);
        }

        // Mark OTP as used
        $passwordReset->update(['used' => true]);

        session(['change_otp_verified' => true]);

        return redirect()->route('password.change.new');
    }

    /**
     * Show form untuk masukkan password baru
     */
    public function showChangeNewForm()
    {
        if (!session('change_otp_verified')) {
            return redirect()->route('password.change');
        }

        return view('auth.change-password-new');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        if (!session('change_otp_verified')) {
            return redirect()->route('password.change');
        }

        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = Auth::user();

        // Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        // Clean up session dan OTP record
        session()->forget(['change_password_email', 'change_otp_verified']);
        PasswordReset::where('email', $user->email)->where('type', 'change')->delete();

        return redirect()->route('home')->with('success', 'Password changed successfully!');
    }

    // ========== FORGOT PASSWORD (dari login, tidak perlu login) ==========

    /**
     * Show form untuk masukkan email
     */
    public function showForgotForm()
    {
        return view('auth.forgot-password-email');
    }

    /**
     * Send OTP untuk reset password
     */
    public function sendResetOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'Email not found in our records.'
        ]);

        $email = $request->email;

        // Rate limiting - max 3 OTP per hour
        $key = 'reset-password-otp:' . $email;
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors(['email' => "Too many attempts. Please try again in " . ceil($seconds / 60) . " minutes."]);
        }

        RateLimiter::hit($key, 3600);

        // Generate dan kirim OTP
        $passwordReset = PasswordReset::createForEmail($email, 'reset');
        Mail::to($email)->send(new PasswordResetMail($passwordReset->otp, $email, 'reset'));

        session(['reset_password_email' => $email]);

        return redirect()->route('password.reset.verify')->with('success', 'OTP has been sent to your email!');
    }

    /**
     * Show form verify OTP
     */
    public function showResetVerifyForm()
    {
        if (!session('reset_password_email')) {
            return redirect()->route('password.forgot');
        }

        return view('auth.forgot-password-verify', [
            'email' => session('reset_password_email')
        ]);
    }

    /**
     * Verify OTP untuk reset password
     */
    public function verifyResetOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $email = session('reset_password_email');
        if (!$email) {
            return redirect()->route('password.forgot');
        }

        $passwordReset = PasswordReset::where('email', $email)
            ->where('type', 'reset')
            ->where('otp', $request->otp)
            ->where('used', false)
            ->first();

        if (!$passwordReset) {
            return back()->withErrors(['otp' => 'Invalid OTP code.']);
        }

        if ($passwordReset->isExpired()) {
            return back()->withErrors(['otp' => 'OTP has expired. Please request a new one.']);
        }

        // Mark OTP as used
        $passwordReset->update(['used' => true]);

        session(['reset_otp_verified' => true]);

        return redirect()->route('password.reset.new');
    }

    /**
     * Show form untuk masukkan password baru
     */
    public function showResetNewForm()
    {
        if (!session('reset_otp_verified')) {
            return redirect()->route('password.forgot');
        }

        return view('auth.forgot-password-new');
    }

    /**
     * Reset password
     */
    public function resetPassword(Request $request)
    {
        if (!session('reset_otp_verified')) {
            return redirect()->route('password.forgot');
        }

        $request->validate([
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $email = session('reset_password_email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('password.forgot')->withErrors(['email' => 'User not found.']);
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        // Clean up session dan OTP record
        session()->forget(['reset_password_email', 'reset_otp_verified']);
        PasswordReset::where('email', $email)->where('type', 'reset')->delete();

        return redirect()->route('login')->with('success', 'Password reset successfully! Please login with your new password.');
    }
}
