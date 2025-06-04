<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Notifications\ResetPasswordCodeNotification;

class ResetPasswordController extends Controller
{
    // Kirim kode verifikasi ke email user
    public function sendResetCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $code = rand(100000, 999999); // kode 6 digit

        // Simpan kode di tabel khusus, buat tabel password_reset_codes dulu
        DB::table('password_reset_codes')->updateOrInsert(
            ['email' => $request->email],
            ['code' => $code, 'created_at' => now()]
        );

        // Kirim email dengan kode verifikasi
        $user = User::where('email', $request->email)->first();
        $user->notify(new ResetPasswordCodeNotification($code));

        return redirect()->route('password.verify-code.form')->with('email', $request->email);
    }

    // Tampilkan form input kode verifikasi
    public function showVerifyCodeForm()
    {
        return view('auth.passwords.verify-code');
    }

    // Verifikasi kode yang dimasukkan user
    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|string',
        ]);

        $record = DB::table('password_reset_codes')
            ->where('email', $request->email)
            ->where('code', $request->code)
            ->first();

        if (!$record || now()->diffInMinutes($record->created_at) > 15) {
            return back()->withErrors(['code' => 'Kode verifikasi salah atau sudah kadaluarsa']);
        }

        // Tandai email sudah verified untuk reset password
        session(['password_reset_email' => $request->email]);

        return redirect()->route('password.reset.form');
    }

    // Tampilkan form reset password
    public function showResetForm()
    {
        if (!session()->has('password_reset_email')) {
            return redirect()->route('password.request');
        }
        return view('auth.passwords.reset');
    }

    // Proses simpan password baru
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8',
        ]);

        $email = session('password_reset_email');
        $user = User::where('email', $email)->first();

        $user->password = Hash::make($request->password);
        $user->save();

        session()->forget('password_reset_email');

        return redirect()->route('login')->with('status', 'Password berhasil diubah');
    }
}
