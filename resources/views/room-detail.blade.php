<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $room['name'] }} - Audra Haven</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js untuk Slider -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f9f9f9; }
        h1, h2 { font-family: 'Playfair Display', serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Navbar Simple -->
    <nav class="bg-white shadow-sm py-4">
        <div class="max-w-7xl mx-auto px-6">
            <a href="/" class="text-2xl font-bold text-gray-800 tracking-widest font-serif">AUDRA HAVEN</a>
        </div>
    </nav>

    <!-- Konten Detail -->
    <div class="max-w-5xl mx-auto px-6 py-16">
        
        <div class="bg-white rounded-lg shadow-xl overflow-hidden flex flex-col md:flex-row relative">
            
            <!-- ================= SLIDER FOTO (KIRI) ================= -->
            <div class="md:w-1/2 relative bg-black" x-data="{ 
                activeSlide: 0, 
                slides: {{ json_encode($room['photos']) }},
                next() { this.activeSlide = (this.activeSlide + 1) % this.slides.length },
                prev() { this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length }
            }">
                
                <!-- Gambar Utama -->
                <div class="relative w-full h-[400px] md:h-full min-h-[400px]">
                    <template x-for="(slide, index) in slides" :key="index">
                        <img :src="slide" 
                             x-show="activeSlide === index" 
                             x-transition:enter="transition ease-out duration-500"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="transition ease-in duration-300"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             class="absolute inset-0 w-full h-full object-cover"
                             alt="{{ $room['name'] }}">
                    </template>
                </div>

                <!-- Tombol Navigasi Kiri & Kanan -->
                <button @click="prev()" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/70 hover:bg-white text-gray-800 rounded-full p-2 shadow transition z-10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <button @click="next()" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/70 hover:bg-white text-gray-800 rounded-full p-2 shadow transition z-10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>

                <!-- Indikator Titik-titik (Dots) -->
                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                    <template x-for="(slide, index) in slides" :key="index">
                        <button @click="activeSlide = index" 
                                class="w-2.5 h-2.5 rounded-full transition-colors"
                                :class="activeSlide === index ? 'bg-[#b8935a]' : 'bg-white/60 hover:bg-white'">
                        </button>
                    </template>
                </div>
            </div>
            
            <!-- ================= INFO KAMAR (KANAN) ================= -->
            <div class="md:w-1/2 p-10 flex flex-col justify-center relative">
                
                <!-- Tombol X -->
                <a href="/kamar" class="absolute top-4 right-4 bg-white rounded-full p-2 shadow hover:bg-gray-100 text-gray-500 transition z-20" title="Tutup">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </a>

                <span class="text-sm font-semibold text-[#b8935a] uppercase tracking-wider mb-2 mt-6">Tipe Kamar</span>
                <h1 class="text-4xl text-gray-900 mb-4">{{ $room['name'] }}</h1>
                <p class="text-gray-600 leading-relaxed mb-8">{{ $room['desc'] }}</p>
                
                <div class="border-t border-gray-200 pt-6 mb-8">
                    <p class="text-sm text-gray-500 mb-1">Harga mulai dari</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $room['price'] }} <span class="text-sm font-normal text-gray-500">/ malam</span></p>
                </div>

                {{-- Form Pemesanan --}}
                <form action="{{ route('booking.room.create', strtolower(str_replace(' ', '-', $room['name']))) }}" method="GET">
                    <button type="submit" class="bg-[#b8935a] hover:bg-[#9a7a44] text-white text-center py-3 px-8 rounded font-semibold transition w-full block">
                        PESAN SEKARANG
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>