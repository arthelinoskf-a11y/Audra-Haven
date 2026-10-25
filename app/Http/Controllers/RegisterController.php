<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->merge(['email' => strtolower(trim((string) $request->input('email')))]);

        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:100'],
            'email'     => ['required', 'email', 'max:120', 'unique:users,email'],
            'phone'     => ['required', 'string', 'regex:/^[0-9+\-\s]{8,20}$/'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'full_name.required' => 'Nama lengkap wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email ini sudah terdaftar. Silakan masuk.',
            'phone.required'     => 'Nomor telepon wajib diisi.',
            'phone.regex'        => 'Nomor telepon tidak valid (8-20 digit).',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sama.',
        ]);

        // Akun baru selalu berperan sebagai Tamu (role_id 1)
        $id = DB::table('users')->insertGetId([
            'role_id'   => 1,
            'full_name' => trim($data['full_name']),
            'email'     => $data['email'],
            'phone'     => trim($data['phone']),
            'password'  => Hash::make($data['password']),
            'is_active' => 1,
        ]);

        Auth::loginUsingId($id);
        $request->session()->regenerate();

        // Kembali ke halaman pemesanan kalau tadi datang dari sana
        return redirect()->intended('/kamar');
    }
}