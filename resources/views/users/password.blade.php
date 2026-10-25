@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
    <div class="mb-4">
        <a href="{{ route('users.index') }}" class="text-sm text-blue-600 hover:underline">← Kembali</a>
    </div>

    <div class="bg-white rounded-lg shadow p-6 max-w-xl">
        <h2 class="text-xl font-bold mb-2">Reset Password</h2>
        <p class="text-gray-500 text-sm mb-6">
            Ubah password untuk <span class="font-semibold">{{ $user->full_name }}</span>
            ({{ $user->email }})
        </p>

        <form method="POST" action="{{ route('users.password.update', $user) }}">
            @csrf @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Password Baru</label>
                <input type="password" name="password"
                       class="w-full border border-gray-300 rounded px-3 py-2" required>
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium mb-1">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation"
                       class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">
                    Ubah Password
                </button>
                <a href="{{ route('users.index') }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded">Batal</a>
            </div>
        </form>
    </div>
@endsection