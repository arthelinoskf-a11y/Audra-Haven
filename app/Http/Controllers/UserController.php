<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Fungsi pengecekan role manual (tanpa middleware)
    private function checkAdmin()
    {
        if (Auth::user()->role->name !== 'admin') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
    }

    public function index()
    {
        $this->checkAdmin();
        $users = User::with('role')->orderBy('full_name')->paginate(15);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $this->checkAdmin();
        $roles = Role::orderBy('id')->get();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $this->checkAdmin();
        $data = $request->validate([
            'full_name' => 'required|string|max:100',
            'email'     => 'required|email|max:120|unique:users,email',
            'phone'     => 'nullable|string|max:20',
            'role_id'   => 'required|exists:roles,id',
            'password'  => 'required|string|min:6|confirmed',
            'is_active' => 'boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);
        User::create($data);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $this->checkAdmin();
        $roles = Role::orderBy('id')->get();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $this->checkAdmin();
        $data = $request->validate([
            'full_name' => 'required|string|max:100',
            'email'     => ['required','email','max:120', Rule::unique('users','email')->ignore($user->id)],
            'phone'     => 'nullable|string|max:20',
            'role_id'   => 'required|exists:roles,id',
            'is_active' => 'boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $this->checkAdmin();
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }

    public function showPasswordForm(User $user)
    {
        $this->checkAdmin();
        return view('users.password', compact('user'));
    }

    public function updatePassword(Request $request, User $user)
    {
        $this->checkAdmin();
        $data = $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user->update(['password' => $data['password']]);
        return redirect()->route('users.index')->with('success', 'Password pengguna berhasil diubah.');
    }
}