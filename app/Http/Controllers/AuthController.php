<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Tampilkan form login
    public function showLogin()
    {
        if (Auth::check()) {
            if (Auth::user()->role->name === 'guest') {
                return redirect('/riwayat-pesanan');
            }
            return redirect('/dashboard');
        }
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(
            $request->only('email', 'password'),
            $request->boolean('remember')
        )) {
            $request->session()->regenerate();
            
            // PENGECEKAN ROLE
            if (Auth::user()->role->name === 'guest') {
                return redirect()->intended('/riwayat-pesanan')->with('success', 'Berhasil login.');
            }

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // Tampilkan form register
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('auth.register');
    }

    // Proses register
    public function register(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:100',
            'email'     => 'required|email|max:120|unique:users,email',
            'phone'     => 'required|string|max:20',
            'password'  => 'required|string|min:6|confirmed',
        ]);

        $guestRole = \App\Models\Role::where('name', 'guest')->first();

        $user = User::create([
            'role_id'   => $guestRole->id ?? 1, 
            'full_name' => $request->full_name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'password'  => Hash::make($request->password),
            'is_active' => true,
        ]);

        Auth::login($user);

        return redirect()->intended('/kamar')->with('success', 'Akun berhasil dibuat!');
    }
    
    // Dashboard
        // Dashboard
    public function dashboard()
    {
        // PENGAMAN: Jika Tamu mencoba akses paksa url /dashboard, tendang ke halaman kamar
        if (Auth::user()->role->name === 'guest') {
            return redirect('/riwayat-pesanan')->with('error', 'Anda tidak memiliki akses ke Dashboard Admin.');
        }

        return view('dashboard');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}