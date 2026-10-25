@extends('layouts.public')

@section('title', 'Special Offers - Audra Haven')

@section('content')
    <section class="py-20 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-6">
            
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4 font-serif">Special Offers</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">Dapatkan penawaran terbaik untuk pengalaman menginap yang tak terlupakan.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <!-- Penawaran 1 (Audra Room) -->
                <div class="bg-white shadow-lg relative group overflow-hidden">
                    <div class="absolute top-0 right-0 bg-[#222] text-white px-6 py-2 z-10" style="clip-path: polygon(15% 0, 100% 0, 100% 100%, 0% 100%);">
                        <span class="text-xs">dari</span> <b>Rp 1.250.000</b>
                    </div>
                    <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?q=80&w=2070&auto=format&fit=crop" alt="Super Saver" class="w-full h-64 object-cover transform group-hover:scale-110 transition duration-500">
                    <div class="p-8 text-center bg-white relative">
                        <h3 class="text-xl font-bold text-gray-800 mb-6">Super Saver</h3>
                        <a href="{{ route('room.detail', 'audra') }}" class="inline-block bg-[#a38859] hover:bg-[#8c744c] text-white px-6 py-2 text-sm font-bold shadow-md transition">PESAN SEKARANG</a>
                        <a href="{{ route('room.detail', 'audra') }}" class="block text-sm text-gray-500 hover:text-[#b8935a] mt-4 mx-auto">&rarr; Baca selengkapnya</a>
                    </div>
                </div>

                <!-- Penawaran 2 (Premier) -->
                <div class="bg-white shadow-lg relative group overflow-hidden">
                    <div class="absolute top-0 right-0 bg-[#222] text-white px-6 py-2 z-10" style="clip-path: polygon(15% 0, 100% 0, 100% 100%, 0% 100%);">
                        <span class="text-xs">dari</span> <b>Rp 1.750.000</b>
                    </div>
                    <img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?q=80&w=1974&auto=format&fit=crop" alt="Super Saver" class="w-full h-64 object-cover transform group-hover:scale-110 transition duration-500">
                    <div class="p-8 text-center bg-white relative">
                        <h3 class="text-xl font-bold text-gray-800 mb-6">Super Saver</h3>
                        <a href="{{ route('room.detail', 'premier') }}" class="inline-block bg-[#a38859] hover:bg-[#8c744c] text-white px-6 py-2 text-sm font-bold shadow-md transition">PESAN SEKARANG</a>
                        <a href="{{ route('room.detail', 'premier') }}" class="block text-sm text-gray-500 hover:text-[#b8935a] mt-4 mx-auto">&rarr; Baca selengkapnya</a>
                    </div>
                </div>

                <!-- Penawaran 3 (Executive) -->
                <div class="bg-white shadow-lg relative group overflow-hidden">
                    <div class="absolute top-0 right-0 bg-[#222] text-white px-6 py-2 z-10" style="clip-path: polygon(15% 0, 100% 0, 100% 100%, 0% 100%);">
                        <span class="text-xs">dari</span> <b>Rp 2.500.000</b>
                    </div>
                    <img src="https://images.unsplash.com/photo-1582719478250-c894022d443f?q=80&w=2070&auto=format&fit=crop" alt="Room Breakfast" class="w-full h-64 object-cover transform group-hover:scale-110 transition duration-500">
                    <div class="p-8 text-center bg-white relative">
                        <h3 class="text-xl font-bold text-gray-800 mb-6">Room & Breakfast</h3>
                        <a href="{{ route('room.detail', 'executive') }}" class="inline-block bg-[#a38859] hover:bg-[#8c744c] text-white px-6 py-2 text-sm font-bold shadow-md transition">PESAN SEKARANG</a>
                        <a href="{{ route('room.detail', 'executive') }}" class="block text-sm text-gray-500 hover:text-[#b8935a] mt-4 mx-auto">&rarr; Baca selengkapnya</a>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection