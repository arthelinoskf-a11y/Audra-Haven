@extends('layouts.app')

@section('title', 'Manajemen Kamar')

@section('content')
    <div class="flex justify-end mb-4">
        <a href="{{ route('rooms.create') }}"
        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
            + Tambah Kamar
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">No. Kamar</th>
                    <th class="px-4 py-3 text-left">Tipe</th>
                    <th class="px-4 py-3 text-left">Lantai</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($rooms as $room)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-semibold">{{ $room->room_number }}</td>
                        <td class="px-4 py-3">{{ $room->roomType->name ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $room->floor }}</td>
                        <td class="px-4 py-3">
                            @php
                                $badge = [
                                    'available'   => 'bg-green-100 text-green-700',
                                    'occupied'    => 'bg-red-100 text-red-700',
                                    'cleaning'    => 'bg-yellow-100 text-yellow-700',
                                    'maintenance' => 'bg-gray-200 text-gray-700',
                                ][$room->status] ?? 'bg-gray-100 text-gray-600';
                            @endphp
                            <span class="px-2 py-1 rounded text-xs capitalize {{ $badge }}">
                                {{ $room->status }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('rooms.edit', $room) }}"
                               class="text-blue-600 hover:underline text-xs">Edit</a>
                            <form method="POST" action="{{ route('rooms.destroy', $room) }}"
                                  class="inline" onsubmit="return confirm('Yakin hapus kamar {{ $room->room_number }}?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline text-xs">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                            Belum ada data kamar.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $rooms->links() }}
    </div>
@endsection