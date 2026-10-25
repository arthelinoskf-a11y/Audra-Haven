@extends('layouts.public')

@section('title', 'Riwayat Pesanan - Audra Haven')

@section('content')
    <section class="py-20 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto px-6">
            
            <div class="mb-12">
                <h2 class="text-4xl font-bold mb-4 font-serif">Riwayat Pesanan</h2>
                <p class="text-gray-500">Selamat datang, <b>{{ auth()->user()->full_name }}</b>. Berikut adalah daftar pesanan Anda.</p>
            </div>

            <!-- Riwayat Kamar -->
            <div class="mb-12">
                <h3 class="text-2xl font-bold font-serif mb-4 border-b pb-2">Pesanan Kamar</h3>
                
                @if($roomBookings->isEmpty())
                    <p class="text-gray-500 italic">Belum ada pesanan kamar.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($roomBookings as $booking)
                        
                        {{-- KARTU DIBUNGKUS LINK <a> --}}
                        <a href="{{ route('booking.room.payment', $booking->booking_code) }}" class="block group">
                            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-[#b8935a] transition duration-300 group-hover:shadow-xl group-hover:-translate-y-1">
                                
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Kode: <span class="font-mono font-bold">{{ $booking->booking_code }}</span></p>
                                        <h4 class="text-xl font-bold text-gray-800 mt-1">Kamar {{ $booking->room->room_number ?? '-' }}</h4>
                                    </div>
                                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase 
                                        {{ $booking->status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                        {{ $booking->status }}
                                    </span>
                                </div>
                                
                                <div class="text-sm text-gray-600 space-y-1 mb-4">
                                    <p>Check-in: {{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}</p>
                                    <p>Check-out: {{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}</p>
                                </div>
                                
                                <div class="border-t pt-3 flex justify-between items-center">
                                    <span class="text-sm text-gray-500">Total</span>
                                    <span class="font-bold text-[#b8935a]">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                                </div>
                                
                                {{-- Teks Petunjuk --}}
                                <div class="mt-4 text-xs text-center text-[#b8935a] font-semibold group-hover:underline">
                                    Klik untuk melihat status verifikasi
                                </div>
                            </div>
                        </a>
                        
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Riwayat Makanan -->
            <div>
                <h3 class="text-2xl font-bold font-serif mb-4 border-b pb-2">Pesanan Makanan</h3>
                
                @if($foodOrders->isEmpty())
                    <p class="text-gray-500 italic">Belum ada pesanan makanan.</p>
                @else
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                                <tr>
                                    <th class="px-4 py-3 text-left">Kode</th>
                                    <th class="px-4 py-3 text-left">Tanggal</th>
                                    <th class="px-4 py-3 text-left">Total</th>
                                    <th class="px-4 py-3 text-left">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($foodOrders as $order)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 font-mono text-xs">{{ $order->order_code }}</td>
                                    <td class="px-4 py-3">{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, H:i') }}</td>
                                    <td class="px-4 py-3 font-bold text-[#b8935a]">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 rounded text-xs font-bold uppercase
                                            {{ $order->status === 'completed' || $order->status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </section>
@endsection