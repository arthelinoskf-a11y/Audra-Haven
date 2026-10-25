@extends('layouts.app')

@section('title', 'Pusat Laporan')

@section('content')

    {{-- ============ HEADER ============ --}}
    <div class="mb-6">
        <p class="text-gray-500 text-sm">
            Pilih jenis laporan dan rentang tanggal. Preview akan muncul di bawah, klik Cetak untuk mencetak.
        </p>
    </div>

    {{-- ============ RINGKASAN STATISTIK ============ --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-5 rounded-lg shadow">
            <div class="text-gray-500 text-sm">Total Kamar</div>
            <div class="text-2xl font-bold">{{ $summary['total_rooms'] }}</div>
        </div>
        <div class="bg-white p-5 rounded-lg shadow">
            <div class="text-gray-500 text-sm">Total Pengguna</div>
            <div class="text-2xl font-bold">{{ $summary['total_users'] }}</div>
        </div>
        <div class="bg-white p-5 rounded-lg shadow">
            <div class="text-gray-500 text-sm">Total Pemesanan</div>
            <div class="text-2xl font-bold text-blue-600">{{ $summary['total_bookings'] }}</div>
        </div>
        <div class="bg-white p-5 rounded-lg shadow">
            <div class="text-gray-500 text-sm">Pendapatan Bulan Ini</div>
            <div class="text-2xl font-bold text-green-600">
                Rp {{ number_format($summary['revenue_this_month'], 0, ',', '.') }}
            </div>
        </div>
    </div>

    {{-- ============ FORM FILTER ============ --}}
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="font-semibold mb-4">Filter Laporan</h3>

        <form method="GET" action="{{ route('reports.index') }}">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                <div>
                    <label class="block text-sm font-medium mb-1">Jenis Laporan</label>
                    <select name="type" class="w-full border border-gray-300 rounded px-3 py-2">
                        <option value="bookings" @selected($type == 'bookings')>Pemesanan</option>
                        <option value="revenue"  @selected($type == 'revenue')>Pendapatan</option>
                        <option value="rooms"    @selected($type == 'rooms')>Data Kamar</option>
                        <option value="users"    @selected($type == 'users')>Data Pengguna</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Dari Tanggal</label>
                    <input type="date" name="from" value="{{ $fromDate }}"
                           class="w-full border border-gray-300 rounded px-3 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Sampai Tanggal</label>
                    <input type="date" name="to" value="{{ $toDate }}"
                           class="w-full border border-gray-300 rounded px-3 py-2">
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit"
                            class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded text-sm">
                        Tampilkan
                    </button>

                    {{-- Tombol cetak: buka tab baru --}}
                    <a href="{{ route('reports.print', ['type' => $type, 'from' => $fromDate, 'to' => $toDate]) }}"
                       target="_blank"
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
                        🖨️ Cetak PDF
                    </a>
                </div>

            </div>
        </form>
    </div>

    {{-- ============ PREVIEW LAPORAN ============ --}}
    <div class="bg-white shadow-xl border border-gray-200 rounded-md p-4 md:p-8">
        
    {{-- Kop surat mini (preview) --}}
        <div class="border-b-2 border-gray-800 p-6">
            <div class="flex items-center gap-4">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-20 h-20 object-contain">
                <div>
                    <div class="text-xl font-bold text-blue-900 tracking-wide">
                        AUDRA HAVEN SUITES &amp; RESIDENCES
                    </div>
                    <div class="text-xs italic text-gray-600">Luxury • Comfort • Elegance</div>
                    <div class="text-xs text-gray-600 mt-1">
                        Jl. Contoh Raya No. 123, Semarang, Jawa Tengah 50123<br>
                        Telp: (024) 123-4567 | Email: info@audrahaven.com
                    </div>
                </div>
            </div>
        </div>

        {{-- Judul --}}
        <div class="text-center mt-6">
            <h2 class="text-lg font-bold underline uppercase">{{ $typeLabel }}</h2>
            <div class="text-sm text-gray-600 mt-1">
                Periode:
                {{ \Carbon\Carbon::parse($fromDate)->translatedFormat('d F Y') }}
                s/d
                {{ \Carbon\Carbon::parse($toDate)->translatedFormat('d F Y') }}
            </div>
        </div>

        {{-- Isi laporan --}}
        <div class="p-6">
            @if ($type === 'bookings')
                @include('reports.partials.bookings', [
                    'rooms'      => $previewData['rooms']      ?? collect(),
                    'facilities' => $previewData['facilities'] ?? collect(),
                    'tables'     => $previewData['tables']     ?? collect(),
                    'halls'      => $previewData['halls']      ?? collect(),
                    'grandTotal' => $previewData['grandTotal'] ?? 0,
                ])
            @elseif ($type === 'revenue')
                @include('reports.partials.revenue', [
                    'revenues'   => $previewData['revenues']   ?? [],
                    'grandTotal' => $previewData['grandTotal'] ?? 0,
                ])
            @elseif ($type === 'rooms')
                @include('reports.partials.rooms', [
                    'rooms' => $previewData['rooms'] ?? collect(),
                ])
            @elseif ($type === 'users')
                @include('reports.partials.users', [
                    'users' => $previewData['users'] ?? collect(),
                ])
            @endif
        </div>

        {{-- Tanda tangan mini --}}
        <div class="px-6 pb-6 flex justify-end">
            <div class="text-center text-sm w-64">
                Semarang, {{ now()->translatedFormat('d F Y') }}<br>
                Manajer,
                <div class="border-t border-black mt-16 pt-1">
                    ( ................................ )
                </div>
            </div>
        </div>

    </div>

@endsection