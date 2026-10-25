@extends('layouts.public')

@section('title', 'Restaurant & Cafe - Audra Haven')

@section('content')
    <section class="py-20 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto px-6">
            
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4 font-serif">Restaurant & Cafe</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">Nikmati pengalaman kuliner yang tak terlupakan.</p>
            </div>

            <!-- Featured Restaurant -->
            <div class="flex flex-col md:flex-row bg-white shadow-xl mb-12 overflow-hidden">
                <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=2070&auto=format&fit=crop" class="w-full md:w-1/2 h-[400px] object-cover">
                <div class="w-full md:w-1/2 p-10 flex flex-col justify-center">
                    <h3 class="text-3xl text-gray-800 mb-4 font-serif">Solstice Garden Café</h3>
                    <p class="text-gray-600 mb-8">Restoran utama kami menyajikan sarapan dengan pemandangan taman yang asri.</p>
                    <a href="{{ auth()->check() ? route('guest.menu') : '/login' }}" class="bg-[#222] text-white px-6 py-3 font-semibold hover:bg-gray-800 transition w-max">
                        LIHAT MENU
                    </a>
                </div>
            </div>

            <!-- Grid Outlet Lainnya -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <!-- Outlet 1 -->
                <a href="/detail/restaurant/ruigo" class="bg-white shadow-md relative group block hover:shadow-xl transition">
                    <img src="https://images.unsplash.com/photo-1550966871-3ed3cdb5ed0c?q=80&w=2070&auto=format&fit=crop" class="w-full h-56 object-cover group-hover:opacity-90 transition">
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-bold mb-3 font-serif">RUIGO Lounge</h3>
                        <p class="text-sm text-gray-500 mb-6">Tempat yang sempurna untuk bersantai sambil menikmati kopi premium dan camilan sore.</p>
                        <span class="text-sm font-semibold text-[#b8935a] group-hover:text-[#9a7a44]">&rarr; Baca selengkapnya</span>
                    </div>
                </a>
                
                <!-- Outlet 2 -->
                <a href="/detail/restaurant/poolbar" class="bg-white shadow-md relative group block hover:shadow-xl transition">
                    <img src="https://images.unsplash.com/photo-1574096079513-d8259312b785?q=80&w=2070&auto=format&fit=crop" class="w-full h-56 object-cover group-hover:opacity-90 transition">
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-bold mb-3 font-serif">Pool Bar</h3>
                        <p class="text-sm text-gray-500 mb-6">Nikmati minuman segar dan hidangan ringan langsung dari tepi kolam renang kami.</p>
                        <span class="text-sm font-semibold text-[#b8935a] group-hover:text-[#9a7a44]">&rarr; Baca selengkapnya</span>
                    </div>
                </a>

                <!-- Outlet 3 -->
                <a href="/detail/restaurant/executive" class="bg-white shadow-md relative group block hover:shadow-xl transition">
                    <img src="https://images.unsplash.com/photo-1514933651103-005eec06c04b?q=80&w=2070&auto=format&fit=crop" class="w-full h-56 object-cover group-hover:opacity-90 transition">
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-bold mb-3 font-serif">Executive Lounge</h3>
                        <p class="text-sm text-gray-500 mb-6">Area eksklusif khusus untuk tamu yang menginap di Suite dan Residence.</p>
                        <span class="text-sm font-semibold text-[#b8935a] group-hover:text-[#9a7a44]">&rarr; Baca selengkapnya</span>
                    </div>
                </a>

            </div>
        </div>
    </section>
@endsection