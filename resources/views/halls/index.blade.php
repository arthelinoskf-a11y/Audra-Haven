@extends('layouts.app')

@section('title', 'Manajemen Gedung')

@section('content')
    <div class="flex justify-end mb-4">
        <a href="{{ route('halls.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
            + Tambah Gedung
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">Nama Gedung</th>
                    <th class="px-4 py-3 text-left">Kapasitas</th>
                    <th class="px-4 py-3 text-left">Luas</th>
                    <th class="px-4 py-3 text-left">Harga / Sesi</th>
                    <th class="px-4 py-3 text-left">Harga Full Day</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($halls as $hall)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-semibold">{{ $hall->name }}</td>
                        <td class="px-4 py-3">{{ number_format($hall->capacity, 0, ',', '.') }} orang</td>
                        <td class="px-4 py-3">{{ $hall->size_m2 ? $hall->size_m2 . ' m²' : '-' }}</td>
                        <td class="px-4 py-3">Rp {{ number_format($hall->price_per_session, 0, ',', '.') }}</td>
                        <td class="px-4 py-3">Rp {{ number_format($hall->full_day_price, 0, ',', '.') }}</td>
                        <td class="px-4 py-3">
                            @if ($hall->is_active)
                                <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-700">Aktif</span>
                            @else
                                <span class="px-2 py-1 rounded text-xs bg-gray-200 text-gray-700">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('halls.edit', $hall) }}"
                               class="text-blue-600 hover:underline text-xs">Edit</a>
                            <form method="POST" action="{{ route('halls.destroy', $hall) }}"
                                  class="inline"
                                  onsubmit="return confirm('Yakin hapus {{ $hall->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline text-xs">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                            Belum ada data gedung.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $halls->links() }}</div>
@endsection