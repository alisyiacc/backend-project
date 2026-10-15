<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email tersebut sudah dipakai akun lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        // Tersimpan ke database (tabel users). Password di-hash otomatis oleh cast 'hashed'.
        $user = User::create([
            'name' => trim($data['name']),
            'email' => strtolower(trim($data['email'])),
            'password' => $data['password'],
        ]);

        // Kirim email ke pendaftar. Kalau SMTP bermasalah, registrasi tetap berhasil.
        $mailSent = true;
        try {
            Mail::to($user->email)->send(new WelcomeMail($user));
        } catch (\Throwable $e) {
            $mailSent = false;
            Log::error('Gagal kirim email registrasi: ' . $e->getMessage());
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => $mailSent
                ? 'Registrasi berhasil, cek email kamu.'
                : 'Registrasi berhasil, tetapi email gagal dikirim.',
            'mail_sent' => $mailSent,
            'token' => $token,
            'user' => $user,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $user = User::where('email', strtolower(trim($request->email)))->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akun dengan email tersebut belum terdaftar.',
            ], 401);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Password yang kamu masukkan salah.',
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil',
            'token' => $token,
            'user' => $user,
        ], 200);
    }

    public function logout(Request $request)
    {
        // Hapus token yang sedang dipakai dari tabel personal_access_tokens.
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logout berhasil',
        ], 200);
    }

    // Dipakai halaman Lupa Password untuk cek email terdaftar di database.
    public function checkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $exists = User::where('email', strtolower(trim($request->email)))->exists();

        return response()->json([
            'status' => 'success',
            'exists' => $exists,
        ], 200);
    }
}
