@extends('layouts.public')

@section('title', 'Facilities - Audra Haven')

@section('content')
    <section class="py-20 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto px-6">
            
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4 font-serif">Facilities</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">Di Audra Haven Suites & Residences, kami percaya dalam memberikan tamu kami pengalaman yang mendalam.</p>
            </div>

            <!-- Featured Facility -->
            <div class="flex flex-col md:flex-row bg-white shadow-xl mb-12 overflow-hidden">
                <img src="images/pool.jpg" class="w-full md:w-1/2 h-[400px] object-cover">
                <div class="w-full md:w-1/2 p-10 flex flex-col justify-center relative">
                    <h3 class="text-3xl text-gray-800 mb-4 font-serif">The Audra Aqua Park</h3>
                    <p class="text-gray-600 mb-8">Kolam renang utama kami yang luas, dikelilingi oleh taman tropis yang asri.</p>
                    
                    {{-- TOMBOL LIHAT DETAIL (Mengarah ke Form Event) --}}
                    <a href="{{ auth()->check() ? route('guest.event.form', ['type' => 'facility', 'id' => 'aquapark']) : '/login' }}" class="bg-[#222] text-white px-6 py-3 font-semibold hover:bg-gray-800 transition w-max">
                        LIHAT DETAIL
                    </a>
                </div>
            </div>

            <!-- Grid Fasilitas Lainnya -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <!-- Fasilitas 1 -->
                <div class="bg-white shadow-md relative group border border-gray-100 flex flex-col">
                    <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=2070&auto=format&fit=crop" class="w-full h-56 object-cover">
                    <div class="p-6 text-center flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold mb-3 font-serif">Bhuana Fitness Club</h3>
                            <p class="text-sm text-gray-500 mb-6">Peralatan olahraga modern dan lengkap untuk menjaga kebugaran Anda.</p>
                        </div>
                        <a href="{{ auth()->check() ? route('guest.event.form', ['type' => 'facility', 'id' => 'gym']) : '/login' }}" class="text-sm font-semibold text-[#b8935a] hover:text-[#9a7a44]">&rarr; Baca selengkapnya</a>
                    </div>
                </div>
                
                <!-- Fasilitas 2 -->
                <div class="bg-white shadow-md relative group border border-gray-100 flex flex-col">
                    <img src="https://images.unsplash.com/photo-1540555700478-4be289fbecef?q=80&w=2070&auto=format&fit=crop" class="w-full h-56 object-cover">
                    <div class="p-6 text-center flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold mb-3 font-serif">Audra Wellness & Spa</h3>
                            <p class="text-sm text-gray-500 mb-6">Layanan pijat tradisional dan perawatan tubuh untuk merelaksasi pikiran.</p>
                        </div>
                        <a href="{{ auth()->check() ? route('guest.event.form', ['type' => 'facility', 'id' => 'spa']) : '/login' }}" class="text-sm font-semibold text-[#b8935a] hover:text-[#9a7a44]">&rarr; Baca selengkapnya</a>
                    </div>
                </div>

                <!-- Fasilitas 3 -->
                <div class="bg-white shadow-md relative group border border-gray-100 flex flex-col">
                    <img src="images/kids.jpg" class="w-full h-56 object-cover">
                    <div class="p-6 text-center flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold mb-3 font-serif">Klub Anak</h3>
                            <p class="text-sm text-gray-500 mb-6">Area bermain yang aman dan menyenangkan dengan pengawasan staf.</p>
                        </div>
                        <a href="{{ auth()->check() ? route('guest.event.form', ['type' => 'facility', 'id' => 'kids']) : '/login' }}" class="text-sm font-semibold text-[#b8935a] hover:text-[#9a7a44]">&rarr; Baca selengkapnya</a>
                    </div>
                </div>

            </div>

        </div>
    </section>
@endsection