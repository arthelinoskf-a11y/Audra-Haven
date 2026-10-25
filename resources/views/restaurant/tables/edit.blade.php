@extends('layouts.app')

@section('title', 'Edit Meja')

@section('content')
    <div class="mb-4">
        <a href="{{ route('tables.index') }}" class="text-sm text-blue-600 hover:underline">← Kembali</a>
    </div>

    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
        <h2 class="text-xl font-bold mb-6">Edit Meja {{ $table->table_number }}</h2>

        <form method="POST" action="{{ route('tables.update', $table) }}">
            @csrf @method('PUT')

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Nomor Meja</label>
                    <input type="text" name="table_number" value="{{ old('table_number', $table->table_number) }}"
                           class="w-full border border-gray-300 rounded px-3 py-2" required>
                    @error('table_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Kapasitas (orang)</label>
                    <input type="number" name="capacity" value="{{ old('capacity', $table->capacity) }}"
                           min="1" max="50" class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Area</label>
                <input type="text" name="area" value="{{ old('area', $table->area) }}"
                       class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>

            <div class="mb-6 flex items-center">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                       {{ old('is_active', $table->is_active) ? 'checked' : '' }} class="mr-2">
                <label for="is_active" class="text-sm">Aktif</label>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Update</button>
                <a href="{{ route('tables.index') }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded">Batal</a>
            </div>
        </form>
    </div>
@endsection