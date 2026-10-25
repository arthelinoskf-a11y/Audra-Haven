@extends('layouts.public')

@section('title', 'Pemesanan Kamar - Audra Haven')

@section('content')
    <div class="max-w-3xl mx-auto px-6 py-20">
        <div class="bg-white rounded-lg shadow-xl p-8 border border-gray-100">
            <h2 class="text-3xl font-bold text-gray-800 mb-2 font-serif">Form Pemesanan</h2>
            <p class="text-gray-500 mb-8">Lengkapi data di bawah ini untuk memesan <b>{{ $room['name'] }}</b>.</p>

            <!-- Form akan mengirim data ke rute booking.room.store -->
            <form action="{{ route('booking.room.store') }}" method="POST">
                @csrf
                <input type="hidden" name="room_slug" value="{{ $room['slug'] }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-semibold mb-2">Check-in</label>
                        <input type="date" name="check_in" class="w-full border border-gray-300 rounded px-4 py-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2">Check-out</label>
                        <input type="date" name="check_out" class="w-full border border-gray-300 rounded px-4 py-2" required>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold mb-2">Jumlah Tamu</label>
                    <input type="number" name="guests" min="1" value="1" class="w-full border border-gray-300 rounded px-4 py-2" required>
                </div>

                <div class="mb-8">
                    <label class="block text-sm font-semibold mb-2">Permintaan Khusus (Opsional)</label>
                    <textarea name="special_request" rows="3" class="w-full border border-gray-300 rounded px-4 py-2"></textarea>
                </div>

                <div class="border-t border-gray-200 pt-6 mb-8 flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-500">Total Harga</p>
                        <p class="text-2xl font-bold text-[#b8935a]">Rp {{ number_format($room['price'], 0, ',', '.') }} <span class="text-sm font-normal text-gray-500">/ malam</span></p>
                    </div>
                </div>

                <button type="submit" class="w-full bg-[#b8935a] hover:bg-[#9a7a44] text-white font-bold py-3 rounded transition">
                    LANJUTKAN PEMESANAN
                </button>
            </form>
        </div>
    </div>
@endsection