@extends('layouts.app')

@section('title', 'Tambah Fasilitas')

@section('content')
    <div class="mb-4">
        <a href="{{ route('facilities.index') }}" class="text-sm text-blue-600 hover:underline">
            ← Kembali
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
        <h2 class="text-xl font-bold mb-6">Tambah Fasilitas Baru</h2>

        <form method="POST" action="{{ route('facilities.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Nama Fasilitas</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full border border-gray-300 rounded px-3 py-2" required>
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Kategori</label>
                    <select name="category" class="w-full border border-gray-300 rounded px-3 py-2" required>
                        <option value="tennis" @selected(old('category')=='tennis')>Lapangan Tenis</option>
                        <option value="gym"    @selected(old('category')=='gym')>Fitness Center</option>
                        <option value="pool"   @selected(old('category')=='pool')>Kolam Renang</option>
                        <option value="cabana" @selected(old('category')=='cabana')>Kabana</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Tipe Booking</label>
                    <select name="booking_type" class="w-full border border-gray-300 rounded px-3 py-2" required>
                        <option value="hourly_slot"   @selected(old('booking_type')=='hourly_slot')>Per Jam (slot)</option>
                        <option value="session_quota" @selected(old('booking_type')=='session_quota')>Per Sesi (kuota)</option>
                        <option value="daily_quota"   @selected(old('booking_type')=='daily_quota')>Per Hari (kuota)</option>
                        <option value="unit_daily"    @selected(old('booking_type')=='unit_daily')>Per Unit/Hari</option>
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Deskripsi</label>
                <textarea name="description" rows="3"
                          class="w-full border border-gray-300 rounded px-3 py-2">{{ old('description') }}</textarea>
            </div>

            <div class="grid grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Harga</label>
                    <input type="number" name="price" value="{{ old('price') }}"
                           min="0" step="1000"
                           class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Satuan</label>
                    <input type="text" name="price_unit" value="{{ old('price_unit', 'per jam') }}"
                           class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Kuota (opsional)</label>
                    <input type="number" name="quota" value="{{ old('quota') }}"
                           min="1" class="w-full border border-gray-300 rounded px-3 py-2">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Jam Buka</label>
                    <input type="time" name="open_time" value="{{ old('open_time', '06:00') }}"
                           class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Jam Tutup</label>
                    <input type="time" name="close_time" value="{{ old('close_time', '22:00') }}"
                           class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
            </div>

            <div class="mb-6 flex items-center">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                       {{ old('is_active', true) ? 'checked' : '' }} class="mr-2">
                <label for="is_active" class="text-sm">Aktif</label>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Simpan</button>
                <a href="{{ route('facilities.index') }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded">Batal</a>
            </div>
        </form>
    </div>
@endsection