@extends('layouts.public')

@section('title', 'Rooms & Suites - Audra Haven')

@section('content')
    <section class="py-20 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto px-6">
            
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4 font-serif">Kamar & Suite</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">Pilih kamar yang paling sesuai dengan kebutuhan Anda.</p>
            </div>

            <!-- Featured Room (THE AUDRA ROOM) -->
            <div class="flex flex-col md:flex-row bg-white shadow-xl mb-12 overflow-hidden">
                <img src="images/h2.jpg" class="w-full md:w-1/2 h-[400px] object-cover">
                <div class="w-full md:w-1/2 p-10 flex flex-col justify-center relative">
                    <div class="absolute top-0 right-0 bg-[#222] text-white px-6 py-2 font-bold" style="clip-path: polygon(15% 0, 100% 0, 100% 100%, 0% 100%);">dari Rp 1.250.000</div>
                    <h3 class="text-3xl text-gray-800 mb-4 font-serif">The Audra Room</h3>
                    <p class="text-gray-600 mb-8">Kamar nyaman dengan pemandangan taman, cocok untuk pasangan atau perjalanan bisnis. Dilengkapi dengan tempat tidur King size, Smart TV, dan minibar.</p>
                    <div>
                        <a href="{{ route('room.detail', 'audra') }}" class="bg-[#222] text-white px-6 py-3 font-semibold hover:bg-gray-800 transition">LIHAT DETAIL</a>
                    </div>
                </div>
            </div>

            <!-- Grid Kamar -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <!-- Premier -->
                <div class="bg-white shadow-md relative group">
                    <div class="absolute top-4 right-0 bg-[#222] text-white px-4 py-1 text-sm font-bold" style="clip-path: polygon(15% 0, 100% 0, 100% 100%, 0% 100%);">dari Rp 1.750.000</div>
                    <img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?q=80&w=1974&auto=format&fit=crop" class="w-full h-56 object-cover">
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-bold mb-3 font-serif">Premier Room</h3>
                        <p class="text-sm text-gray-500 mb-6">Kamar lebih luas dengan balkon pribadi menghadap kolam renang.</p>
                        <a href="{{ route('room.detail', 'premier') }}" class="text-sm font-semibold text-[#b8935a] hover:text-[#9a7a44]">&rarr; Baca selengkapnya</a>
                    </div>
                </div>
                
                <!-- Executive -->
                <div class="bg-white shadow-md relative group">
                    <div class="absolute top-4 right-0 bg-[#222] text-white px-4 py-1 text-sm font-bold" style="clip-path: polygon(15% 0, 100% 0, 100% 100%, 0% 100%);">dari Rp 2.500.000</div>
                    <img src="images/Executive.jpg">
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-bold mb-3 font-serif">Executive Suite</h3>
                        <p class="text-sm text-gray-500 mb-6">Suite mewah dengan ruang tamu terpisah dan bathtub marmer.</p>
                        <a href="{{ route('room.detail', 'executive') }}" class="text-sm font-semibold text-[#b8935a] hover:text-[#9a7a44]">&rarr; Baca selengkapnya</a>
                    </div>
                </div>

                <!-- Family -->
                <div class="bg-white shadow-md relative group">
                    <div class="absolute top-4 right-0 bg-[#222] text-white px-4 py-1 text-sm font-bold" style="clip-path: polygon(15% 0, 100% 0, 100% 100%, 0% 100%);">dari Rp 3.200.000</div>
                    <img src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?q=80&w=2070&auto=format&fit=crop" class="w-full h-56 object-cover">
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-bold mb-3 font-serif">Family Suite</h3>
                        <p class="text-sm text-gray-500 mb-6">Dua kamar tidur yang saling terhubung, ideal untuk keluarga besar.</p>
                        <a href="{{ route('room.detail', 'family') }}" class="text-sm font-semibold text-[#b8935a] hover:text-[#9a7a44]">&rarr; Baca selengkapnya</a>
                    </div>
                </div>

                <!-- Presidential -->
                <div class="bg-white shadow-md relative group">
                    <div class="absolute top-4 right-0 bg-[#222] text-white px-4 py-1 text-sm font-bold" style="clip-path: polygon(15% 0, 100% 0, 100% 100%, 0% 100%);">dari Rp 7.500.000</div>
                    <img src="images/Presidential3.jpg" class="w-full h-56 object-cover">
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-bold mb-3 font-serif">Presidential Residence</h3>
                        <p class="text-sm text-gray-500 mb-6">Hunian dua lantai dengan kolam pribadi dan layanan butler 24 jam.</p>
                        <a href="{{ route('room.detail', 'presidential') }}" class="text-sm font-semibold text-[#b8935a] hover:text-[#9a7a44]">&rarr; Baca selengkapnya</a>
                    </div>
                </div>

                <!-- Garden View (KAMAR BARU 1) -->
                <div class="bg-white shadow-md relative group">
                    <div class="absolute top-4 right-0 bg-[#222] text-white px-4 py-1 text-sm font-bold" style="clip-path: polygon(15% 0, 100% 0, 100% 100%, 0% 100%);">dari Rp 1.500.000</div>
                    <img src="https://images.unsplash.com/photo-1560185007-c5ca9d2c014d?q=80&w=2070&auto=format&fit=crop" class="w-full h-56 object-cover">
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-bold mb-3 font-serif">Garden View Room</h3>
                        <p class="text-sm text-gray-500 mb-6">Kamar dengan akses langsung ke taman hijau yang asri.</p>
                        <a href="{{ route('room.detail', 'garden') }}" class="text-sm font-semibold text-[#b8935a] hover:text-[#9a7a44]">&rarr; Baca selengkapnya</a>
                    </div>
                </div>

                <!-- Skyline Penthouse (KAMAR BARU 2) -->
                <div class="bg-white shadow-md relative group">
                    <div class="absolute top-4 right-0 bg-[#222] text-white px-4 py-1 text-sm font-bold" style="clip-path: polygon(15% 0, 100% 0, 100% 100%, 0% 100%);">dari Rp 5.000.000</div>
                    <img src="https://images.unsplash.com/photo-1566665797739-1674de7a421a?q=80&w=2070&auto=format&fit=crop" class="w-full h-56 object-cover">
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-bold mb-3 font-serif">Skyline Penthouse</h3>
                        <p class="text-sm text-gray-500 mb-6">Kamar di lantai tertinggi dengan pemandangan kota Semarang.</p>
                        <a href="{{ route('room.detail', 'sky') }}" class="text-sm font-semibold text-[#b8935a] hover:text-[#9a7a44]">&rarr; Baca selengkapnya</a>
                    </div>
                </div>

            </div>

        </div>
    </section>
@endsection