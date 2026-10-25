@extends('layouts.app')

@section('title', 'Tambah Kamar')

@section('content')
    <div class="mb-4">
        <a href="{{ route('rooms.index') }}" class="text-sm text-blue-600 hover:underline">
            ← Kembali ke Daftar Kamar
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
        <h2 class="text-xl font-bold mb-6">Tambah Kamar Baru</h2>

        <form method="POST" action="{{ route('rooms.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Tipe Kamar</label>
                <select name="room_type_id" class="w-full border border-gray-300 rounded px-3 py-2" required>
                    <option value="">-- Pilih Tipe --</option>
                    @foreach ($roomTypes as $type)
                        <option value="{{ $type->id }}" @selected(old('room_type_id') == $type->id)>
                            {{ $type->name }} (Rp {{ number_format($type->base_price, 0, ',', '.') }})
                        </option>
                    @endforeach
                </select>
                @error('room_type_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Nomor Kamar</label>
                <input type="text" name="room_number" value="{{ old('room_number') }}"
                       placeholder="cth: 701" class="w-full border border-gray-300 rounded px-3 py-2" required>
                @error('room_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Lantai</label>
                <input type="number" name="floor" value="{{ old('floor') }}"
                       min="1" max="50" class="w-full border border-gray-300 rounded px-3 py-2" required>
                @error('floor') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium mb-1">Status</label>
                <select name="status" class="w-full border border-gray-300 rounded px-3 py-2" required>
                    <option value="available"   @selected(old('status') == 'available')>Available</option>
                    <option value="occupied"    @selected(old('status') == 'occupied')>Occupied</option>
                    <option value="cleaning"    @selected(old('status') == 'cleaning')>Cleaning</option>
                    <option value="maintenance" @selected(old('status') == 'maintenance')>Maintenance</option>
                </select>
                @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-2">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Simpan
                </button>
                <a href="{{ route('rooms.index') }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection