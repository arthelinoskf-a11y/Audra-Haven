@extends('layouts.app')

@section('title', 'Edit Pengguna')

@section('content')
    <div class="mb-4">
        <a href="{{ route('users.index') }}" class="text-sm text-blue-600 hover:underline">← Kembali</a>
    </div>

    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
        <h2 class="text-xl font-bold mb-6">Edit Pengguna: {{ $user->full_name }}</h2>

        <form method="POST" action="{{ route('users.update', $user) }}">
            @csrf @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Nama Lengkap</label>
                <input type="text" name="full_name" value="{{ old('full_name', $user->full_name) }}"
                       class="w-full border border-gray-300 rounded px-3 py-2" required>
                @error('full_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                           class="w-full border border-gray-300 rounded px-3 py-2" required>
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                           class="w-full border border-gray-300 rounded px-3 py-2">
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Role</label>
                <select name="role_id" class="w-full border border-gray-300 rounded px-3 py-2" required>
                    @foreach ($roles as $r)
                        <option value="{{ $r->id }}"
                            @selected(old('role_id', $user->role_id) == $r->id)>
                            {{ $r->label }} ({{ $r->name }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6 flex items-center">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                       {{ old('is_active', $user->is_active) ? 'checked' : '' }} class="mr-2">
                <label for="is_active" class="text-sm">Aktif</label>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Update</button>
                <a href="{{ route('users.index') }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded">Batal</a>
                <a href="{{ route('users.password', $user) }}"
                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded ml-auto">
                    Ubah Password
                </a>
            </div>
        </form>
    </div>
@endsection