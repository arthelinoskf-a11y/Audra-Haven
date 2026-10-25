@extends('layouts.app')

@section('title', 'Menu Restoran')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <div class="flex gap-2">
            <a href="{{ route('menu.index') }}"
               class="px-4 py-2 rounded text-sm bg-blue-600 text-white">Menu</a>
            <a href="{{ route('tables.index') }}"
               class="px-4 py-2 rounded text-sm bg-gray-200 hover:bg-gray-300 text-gray-800">Meja</a>
        </div>
        <a href="{{ route('menu.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
            + Tambah Menu
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">Nama</th>
                    <th class="px-4 py-3 text-left">Kategori</th>
                    <th class="px-4 py-3 text-left">Harga</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($items as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">
                            <div class="font-semibold">{{ $item->name }}</div>
                            @if ($item->description)
                                <div class="text-gray-400 text-xs">{{ $item->description }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-3">{{ $item->category_label }}</td>
                        <td class="px-4 py-3">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="px-4 py-3">
                            @if ($item->is_available)
                                <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-700">Tersedia</span>
                            @else
                                <span class="px-2 py-1 rounded text-xs bg-gray-200 text-gray-700">Habis</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('menu.edit', $item) }}"
                               class="text-blue-600 hover:underline text-xs">Edit</a>
                            <form method="POST" action="{{ route('menu.destroy', $item) }}"
                                  class="inline"
                                  onsubmit="return confirm('Yakin hapus {{ $item->name }}?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline text-xs">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                            Belum ada menu.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $items->links() }}</div>
@endsection