@extends('layouts.public')

@section('title', 'Weddings & Events - Audra Haven')

@section('content')
    <section class="py-20 bg-white min-h-screen">
        <div class="max-w-6xl mx-auto px-6">
            
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4 font-serif">Weddings & Events</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">Saat merencanakan acara istimewa di Semarang.</p>
            </div>

            <!-- Featured Venue -->
            <div class="flex flex-col md:flex-row bg-gray-50 shadow-xl mb-12 overflow-hidden">
                <img src="https://images.unsplash.com/photo-1519167758481-83f550bb49b3?q=80&w=2098&auto=format&fit=crop" class="w-full md:w-1/2 h-[400px] object-cover">
                <div class="w-full md:w-1/2 p-10 flex flex-col justify-center relative">
                    <h3 class="text-3xl text-gray-800 mb-4 font-serif">The Emerald Ballroom</h3>
                    <p class="text-gray-600 mb-8">Ballroom utama kami yang megah, dirancang untuk pernikahan impian dan resepsi akbar.</p>
                    
                    {{-- TOMBOL HUBUNGI KAMI (Mengarah ke Form Event) --}}
                    <a href="{{ auth()->check() ? route('guest.event.form', ['type' => 'wedding', 'id' => 'ballroom']) : '/login' }}" class="bg-[#222] text-white px-6 py-3 font-semibold hover:bg-gray-800 transition w-max">
                        HUBUNGI KAMI
                    </a>
                </div>
            </div>

            <!-- Grid Venue Lainnya -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <!-- Venue 1 -->
                <div class="bg-white shadow-md relative group border border-gray-100 flex flex-col">
                    <img src="images/meeting.jpg" class="w-full h-56 object-cover">
                    <div class="p-6 text-center flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold mb-3 font-serif">Meeting Room</h3>
                            <p class="text-sm text-gray-500 mb-6">Ruang rapat modern dengan peralatan audio-visual canggih.</p>
                        </div>
                        <a href="{{ auth()->check() ? route('guest.event.form', ['type' => 'wedding', 'id' => 'meeting']) : '/login' }}" class="text-sm font-semibold text-[#b8935a] hover:text-[#9a7a44]">&rarr; Baca selengkapnya</a>
                    </div>
                </div>
                
                <!-- Venue 2 -->
                <div class="bg-white shadow-md relative group border border-gray-100 flex flex-col">
                    <img src="images/vip.jpg" class="w-full h-56 object-cover">
                    <div class="p-6 text-center flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold mb-3 font-serif">VIP Room</h3>
                            <p class="text-sm text-gray-500 mb-6">Ruang privat yang elegan untuk pertemuan eksklusif.</p>
                        </div>
                        <a href="{{ auth()->check() ? route('guest.event.form', ['type' => 'wedding', 'id' => 'vip']) : '/login' }}" class="text-sm font-semibold text-[#b8935a] hover:text-[#9a7a44]">&rarr; Baca selengkapnya</a>
                    </div>
                </div>

                <!-- Venue 3 -->
                <div class="bg-white shadow-md relative group border border-gray-100 flex flex-col">
                    <img src="images/svarga.jpg" class="w-full h-56 object-cover">
                    <div class="p-6 text-center flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold mb-3 font-serif">Svarga Outdoor</h3>
                            <p class="text-sm text-gray-500 mb-6">Area taman terbuka yang indah untuk pesta kebun.</p>
                        </div>
                        <a href="{{ auth()->check() ? route('guest.event.form', ['type' => 'wedding', 'id' => 'outdoor']) : '/login' }}" class="text-sm font-semibold text-[#b8935a] hover:text-[#9a7a44]">&rarr; Baca selengkapnya</a>
                    </div>
                </div>

            </div>

        </div>
    </section>
@endsection