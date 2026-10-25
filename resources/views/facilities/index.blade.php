@extends('layouts.app')

@section('title', 'Manajemen Fasilitas')

@section('content')
    <div class="flex justify-end mb-4">
        <a href="{{ route('facilities.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
            + Tambah Fasilitas
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">Nama</th>
                    <th class="px-4 py-3 text-left">Kategori</th>
                    <th class="px-4 py-3 text-left">Harga</th>
                    <th class="px-4 py-3 text-left">Jam Operasional</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($facilities as $f)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-semibold">{{ $f->name }}</td>
                        <td class="px-4 py-3">{{ $f->category_label }}</td>
                        <td class="px-4 py-3">
                            Rp {{ number_format($f->price, 0, ',', '.') }}
                            <span class="text-gray-400 text-xs">/ {{ $f->price_unit }}</span>
                        </td>
                        <td class="px-4 py-3">
                            {{ \Carbon\Carbon::parse($f->open_time)->format('H:i') }}
                            –
                            {{ \Carbon\Carbon::parse($f->close_time)->format('H:i') }}
                        </td>
                        <td class="px-4 py-3">
                            @if ($f->is_active)
                                <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-700">Aktif</span>
                            @else
                                <span class="px-2 py-1 rounded text-xs bg-gray-200 text-gray-700">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('facilities.edit', $f) }}"
                               class="text-blue-600 hover:underline text-xs">Edit</a>
                            <form method="POST" action="{{ route('facilities.destroy', $f) }}"
                                  class="inline"
                                  onsubmit="return confirm('Yakin hapus {{ $f->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline text-xs">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                            Belum ada fasilitas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $facilities->links() }}</div>
@endsection