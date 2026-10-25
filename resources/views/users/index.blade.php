@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
    <div class="flex justify-end mb-4">
        <a href="{{ route('users.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
            + Tambah Pengguna
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">Nama</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">Telepon</th>
                    <th class="px-4 py-3 text-left">Role</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($users as $u)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">
                            <div class="font-semibold">{{ $u->full_name }}</div>
                            @if ($u->id === auth()->id())
                                <div class="text-xs text-blue-600">(Anda)</div>
                            @endif
                        </td>
                        <td class="px-4 py-3">{{ $u->email }}</td>
                        <td class="px-4 py-3">{{ $u->phone ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded text-xs bg-indigo-100 text-indigo-700">
                                {{ $u->role->label ?? '-' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            @if ($u->is_active)
                                <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-700">Aktif</span>
                            @else
                                <span class="px-2 py-1 rounded text-xs bg-red-100 text-red-700">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('users.password', $u) }}"
                               class="text-yellow-600 hover:underline text-xs">Password</a>
                            <a href="{{ route('users.edit', $u) }}"
                               class="text-blue-600 hover:underline text-xs">Edit</a>
                            @if ($u->id !== auth()->id())
                                <form method="POST" action="{{ route('users.destroy', $u) }}"
                                      class="inline"
                                      onsubmit="return confirm('Yakin hapus pengguna {{ $u->full_name }}?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:underline text-xs">Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                            Belum ada pengguna.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $users->links() }}</div>
@endsection