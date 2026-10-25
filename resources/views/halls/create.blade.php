@extends('layouts.app')

@section('title', 'Tambah Gedung')

@section('content')
    <div class="mb-4">
        <a href="{{ route('halls.index') }}" class="text-sm text-blue-600 hover:underline">
            ← Kembali
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
        <h2 class="text-xl font-bold mb-6">Tambah Gedung Baru</h2>

        <form method="POST" action="{{ route('halls.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Nama Gedung</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       placeholder="cth: Grand Ballroom Cendana"
                       class="w-full border border-gray-300 rounded px-3 py-2" required>
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Deskripsi</label>
                <textarea name="description" rows="3"
                          class="w-full border border-gray-300 rounded px-3 py-2">{{ old('description') }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Kapasitas (orang)</label>
                    <input type="number" name="capacity" value="{{ old('capacity') }}"
                           min="1" class="w-full border border-gray-300 rounded px-3 py-2" required>
                    @error('capacity') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Luas (m², opsional)</label>
                    <input type="number" name="size_m2" value="{{ old('size_m2') }}"
                           min="1" class="w-full border border-gray-300 rounded px-3 py-2">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Harga per Sesi (Rp)</label>
                    <input type="number" name="price_per_session" value="{{ old('price_per_session') }}"
                           min="0" step="100000"
                           class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Harga Full Day (Rp)</label>
                    <input type="number" name="full_day_price" value="{{ old('full_day_price') }}"
                           min="0" step="100000"
                           class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
            </div>

            <div class="mb-6 flex items-center">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                       {{ old('is_active', true) ? 'checked' : '' }} class="mr-2">
                <label for="is_active" class="text-sm">Aktif</label>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Simpan
                </button>
                <a href="{{ route('halls.index') }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection