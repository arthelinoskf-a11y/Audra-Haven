<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $item['name'] }} - Audra Haven</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f9f9f9; }
        h1, h2 { font-family: 'Playfair Display', serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50">

    <nav class="bg-white shadow-sm py-4">
        <div class="max-w-7xl mx-auto px-6">
            <a href="/" class="text-2xl font-bold text-gray-800 tracking-widest font-serif">AUDRA HAVEN</a>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto px-6 py-16">
        
        <div class="bg-white rounded-lg shadow-xl overflow-hidden flex flex-col md:flex-row relative">
            
            <!-- Slider Foto -->
            <div class="md:w-1/2 relative bg-black" x-data="{ 
                activeSlide: 0, 
                slides: {{ json_encode($item['photos']) }},
                next() { this.activeSlide = (this.activeSlide + 1) % this.slides.length },
                prev() { this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length }
            }">
                
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
                             alt="{{ $item['name'] }}">
                    </template>
                </div>

                <button @click="prev()" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/70 hover:bg-white text-gray-800 rounded-full p-2 shadow transition z-10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <button @click="next()" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/70 hover:bg-white text-gray-800 rounded-full p-2 shadow transition z-10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>

                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                    <template x-for="(slide, index) in slides" :key="index">
                        <button @click="activeSlide = index" 
                                class="w-2.5 h-2.5 rounded-full transition-colors"
                                :class="activeSlide === index ? 'bg-[#b8935a]' : 'bg-white/60 hover:bg-white'">
                        </button>
                    </template>
                </div>
            </div>
            
            <!-- Info Kanan -->
            <div class="md:w-1/2 p-10 flex flex-col justify-center relative">
                
                <a href="{{ url()->previous() }}" class="absolute top-4 right-4 bg-white rounded-full p-2 shadow hover:bg-gray-100 text-gray-500 transition z-20" title="Tutup">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </a>

                <span class="text-sm font-semibold text-[#b8935a] uppercase tracking-wider mb-2 mt-6">
                    {{ $type === 'restaurant' ? 'Restoran' : ($type === 'wedding' ? 'Wedding & Events' : 'Fasilitas') }}
                </span>
                <h1 class="text-4xl text-gray-900 mb-4">{{ $item['name'] }}</h1>
                <p class="text-gray-600 leading-relaxed mb-8">{{ $item['desc'] }}</p>
                
                <div class="border-t border-gray-200 pt-6 mb-8">
                    <p class="text-sm text-gray-500 mb-1">Harga</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $item['price'] }}</p>
                </div>

                {{-- LOGIKA TOMBOL PESAN SEKARANG --}}
                @auth
                    @if(auth()->user()->role->name === 'guest')
                        @if($type === 'restaurant')
                            <a href="/pesan-makanan" class="bg-[#b8935a] hover:bg-[#9a7a44] text-white text-center py-3 px-8 rounded font-semibold transition w-full block">PESAN MAKANAN</a>
                        @else
                            <a href="/kamar" class="bg-[#b8935a] hover:bg-[#9a7a44] text-white text-center py-3 px-8 rounded font-semibold transition w-full block">PESAN / BOOKING</a>
                        @endif
                    @else
                        <a href="/dashboard" class="bg-[#222] text-white text-center py-3 px-8 rounded font-semibold transition w-full block">KEMBALI KE DASHBOARD</a>
                    @endif
                @else
                    {{-- Jika Belum Login, arahkan ke halaman yang diinginkan (agar intended() bekerja) --}}
                    @if($type === 'restaurant')
                        <a href="{{ url('/pesan-makanan') }}" class="bg-[#b8935a] hover:bg-[#9a7a44] text-white text-center py-3 px-8 rounded font-semibold transition w-full block">LOGIN UNTUK MEMESAN</a>
                    @else
                        <a href="{{ url('/kamar') }}" class="bg-[#b8935a] hover:bg-[#9a7a44] text-white text-center py-3 px-8 rounded font-semibold transition w-full block">LOGIN UNTUK BOOKING</a>
                    @endif
                @endauth
            </div>
        </div>
    </div>

</body>
</html>