@extends('layouts.app')

@section('title', 'Tambah Menu')

@section('content')
    <div class="mb-4">
        <a href="{{ route('menu.index') }}" class="text-sm text-blue-600 hover:underline">← Kembali</a>
    </div>

    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
        <h2 class="text-xl font-bold mb-6">Tambah Menu Baru</h2>

        <form method="POST" action="{{ route('menu.store') }}">
            @csrf

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Kategori</label>
                    <select name="category" class="w-full border border-gray-300 rounded px-3 py-2" required>
                        <option value="appetizer" @selected(old('category')=='appetizer')>Pembuka</option>
                        <option value="main"      @selected(old('category')=='main')>Menu Utama</option>
                        <option value="dessert"   @selected(old('category')=='dessert')>Penutup</option>
                        <option value="beverage"  @selected(old('category')=='beverage')>Minuman</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Harga (Rp)</label>
                    <input type="number" name="price" value="{{ old('price') }}" min="0" step="1000"
                           class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Nama Menu</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full border border-gray-300 rounded px-3 py-2" required>
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Deskripsi (opsional)</label>
                <textarea name="description" rows="3"
                          class="w-full border border-gray-300 rounded px-3 py-2">{{ old('description') }}</textarea>
            </div>

            <div class="mb-6 flex items-center">
                <input type="checkbox" name="is_available" id="is_available" value="1"
                       {{ old('is_available', true) ? 'checked' : '' }} class="mr-2">
                <label for="is_available" class="text-sm">Tersedia</label>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Simpan</button>
                <a href="{{ route('menu.index') }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded">Batal</a>
            </div>
        </form>
    </div>
@endsection