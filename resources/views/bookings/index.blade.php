@extends('layouts.app')

@section('title', 'Manajemen Pesanan')

@section('content')

    {{-- Kartu statistik --}}
    <div class="grid grid-cols-5 gap-3 mb-4">
        @php
            $cards = [
                'room'     => ['Kamar',     'bg-blue-100 text-blue-700'],
                'facility' => ['Fasilitas', 'bg-green-100 text-green-700'],
                'table'    => ['Meja',      'bg-yellow-100 text-yellow-700'],
                'order'    => ['Makanan',   'bg-purple-100 text-purple-700'],
                'hall'     => ['Gedung',    'bg-red-100 text-red-700'],
            ];
        @endphp
        @foreach ($cards as $key => $info)
            <a href="{{ route('bookings.index', ['tab' => $key]) }}"
               class="p-4 rounded-lg shadow transition
                      {{ $tab === $key ? 'ring-2 ring-offset-2 ring-blue-500 bg-white' : 'bg-white hover:bg-gray-50' }}">
                <div class="text-xs uppercase font-semibold {{ $info[1] }} inline-block px-2 py-0.5 rounded">
                    {{ $info[0] }}
                </div>
                <div class="text-2xl font-bold mt-2">{{ $stats[$key] }}</div>
                <div class="text-xs text-gray-500">total pesanan</div>
            </a>
        @endforeach
    </div>

    {{-- Tab aktif info --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">

        @if ($tab === 'room')
            @include('bookings.partials.room')
        @elseif ($tab === 'facility')
            @include('bookings.partials.facility')
        @elseif ($tab === 'table')
            @include('bookings.partials.table')
        @elseif ($tab === 'order')
            @include('bookings.partials.order')
        @elseif ($tab === 'hall')
            @include('bookings.partials.hall')
        @endif

    </div>

    <div class="mt-4">{{ $data->appends(['tab' => $tab])->links() }}</div>
@endsection