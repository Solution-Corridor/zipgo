<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Mail\PasswordResetOtpMail; // we'll create this

class ForgotPasswordController extends Controller
{
    public function showRequestForm()
    {
        return view('auth.forgot_password');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
        ]);

        $user = User::where('username', $request->login)
                    ->orWhere('phone', $request->login)
                    ->first();

        if (!$user || !$user->email) {
            return back()->withErrors(['login' => 'No email set. or Account not found with that username/phone.']);
        }

        // Generate 6-digit OTP
        $otp = rand(100000, 999999);

        // Store OTP + expiry (e.g. 10 min) - simple way using user table or cache
        // Option A: add columns to users: otp_code, otp_expires_at
        $user->otp_code = $otp;
        $user->otp_expires_at = Carbon::now()->addMinutes(10);
        $user->save();

        // Send email
        Mail::to($user->email)->send(new PasswordResetOtpMail($otp, $user->name ?? 'User'));

        session(['password_reset_login' => $request->login]); // remember who for next step

        return view('auth.forgot-password-verify', [
            'message' => 'OTP sent to your email. Valid for 10 minutes.'
        ]);
    }

    public function resetWithOtp(Request $request)
    {
        $request->validate([
            'otp'                  => 'required|digits:6',
            'password'             => 'required|min:8|confirmed',
        ]);

        $login = session('password_reset_login');

        if (!$login) {
            return redirect('/forgot-password')->withErrors(['error' => 'Session expired. Try again.']);
        }

        $user = User::where('username', $login)
                    ->orWhere('phone', $login)
                    ->first();

        if (!$user || !$user->otp_code || $user->otp_expires_at < Carbon::now()) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP.']);
        }

        if ($user->otp_code !== $request->otp) {
            return back()->withErrors(['otp' => 'Incorrect OTP.']);
        }

        // Success - update password
        $user->password = Hash::make($request->password);
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();

        session()->forget('password_reset_login');

        return redirect('/login')->with('success', 'Password reset successfully! Please log in.');
    }
}