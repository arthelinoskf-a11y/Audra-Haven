@extends('layouts.app')

@section('title', 'Meja Restoran')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <div class="flex gap-2">
            <a href="{{ route('menu.index') }}"
               class="px-4 py-2 rounded text-sm bg-gray-200 hover:bg-gray-300 text-gray-800">Menu</a>
            <a href="{{ route('tables.index') }}"
               class="px-4 py-2 rounded text-sm bg-blue-600 text-white">Meja</a>
        </div>
        <a href="{{ route('tables.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
            + Tambah Meja
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">No. Meja</th>
                    <th class="px-4 py-3 text-left">Kapasitas</th>
                    <th class="px-4 py-3 text-left">Area</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($tables as $t)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-semibold">{{ $t->table_number }}</td>
                        <td class="px-4 py-3">{{ $t->capacity }} orang</td>
                        <td class="px-4 py-3">{{ $t->area }}</td>
                        <td class="px-4 py-3">
                            @if ($t->is_active)
                                <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-700">Aktif</span>
                            @else
                                <span class="px-2 py-1 rounded text-xs bg-gray-200 text-gray-700">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('tables.edit', $t) }}"
                               class="text-blue-600 hover:underline text-xs">Edit</a>
                            <form method="POST" action="{{ route('tables.destroy', $t) }}"
                                  class="inline"
                                  onsubmit="return confirm('Yakin hapus meja {{ $t->table_number }}?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline text-xs">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                            Belum ada meja.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $tables->links() }}</div>
@endsection