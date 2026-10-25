<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audra Haven Suites & Residences</title>

    {{-- Font Google (Playfair Display untuk judul elegan, Inter untuk teks) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    
    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Alpine.js (Untuk Modal) --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        /* ============ VARIABEL WARNA ============ */
        :root {
            --gold: #b8935a;
            --gold-dark: #9a7a44;
            --gold-light: #d4b483;
            --bg-body: #ffffff;
            --text-main: #2d2317;
            --text-muted: #6b5a44;
            --dark-bg: #1a1a1a;
        }

        /* Memastikan tidak ada scroll horizontal */
        html, body {
            max-width: 100vw;
            overflow-x: hidden;
            margin: 0;
            padding: 0;
            scroll-behavior: smooth; /* Penting untuk animasi scroll */
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-main);
            background-color: var(--bg-body);
        }

        /* ============ FONT ELEGAN ============ */
        h1, h2, h3, h4, .font-serif {
            font-family: 'Playfair Display', serif;
        }

        /* ============ NAVBAR ============ */
        .navbar {
            background: rgba(0, 0, 0, 0.3) !important; /* Hitam transparan 30% */
            backdrop-filter: blur(10px); /* Efek kaca buram */
            -webkit-backdrop-filter: blur(10px);
            position: absolute; 
            top: 0;
            left: 0;
            width: 100%;
            z-index: 50;
            height: 96px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1); 
        }
        .nav-link {
            font-size: 14px;
            font-weight: 600;
            color: #ffffff; /* Mengubah teks menjadi putih */
            text-decoration: none;
            transition: color 0.2s;
            margin: 0 15px;
            white-space: nowrap;
        }
        .nav-link:hover { color: var(--gold-light); }
        .btn-gold {
            background: var(--gold);
            color: #fff;
            padding: 12px 24px;
            font-weight: 600;
            letter-spacing: 1px;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            border: none;
            cursor: pointer;
        }
        .btn-gold:hover { background: var(--gold-dark); }

        /* ============ HERO SECTION ============ */
        .hero {
            position: relative;
            width: 100%;
            height: 100vh; /* Mengubah jadi 100% dari tinggi layar monitor */
            min-height: 800px; /* Memastikan tingginya minimal 800px agar form muat lega */
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #fff;
            overflow: hidden;
            background-color: #1a1a1a;
        }
        .hero-slider {
            position: absolute;
            inset: 0;
            z-index: 1;
            display: flex;
            width: 300%; /* 2 asli + 1 duplikat */
        }
        .hero-slider .slide {
            width: 33.333%;
            height: 100%;
            background-size: cover;
            background-position: center 30%;
            flex-shrink: 0;
        }
        
        /* Overlay lebih terang (0.2) */
        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.1); 
            z-index: 2;
        }
        
        .hero-content {
            position: relative;
            z-index: 10;
            max-width: 1100px;
            width: 100%;
            padding: 20px;
            padding-top: 120px; /* <--- TAMBAHKAN BARIS INI */
        }
        .hero h1 { 
            font-size: 3.5rem; 
            margin-bottom: 15px;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.8); 
        }
        .hero p {
            text-shadow: 1px 1px 5px rgba(0,0,0,0.8);
        }

        /* ============ FORM PENCARIAN TRANSPARAN ============ */
        .search-bar-glass {
            background: rgba(30, 30, 30, 0.65); 
            backdrop-filter: blur(10px); 
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2); 
            padding: 20px; 
            border-radius: 8px; 
            display: flex; 
            gap: 15px; 
            flex-wrap: nowrap; /* Tetap satu baris di desktop */
            align-items: flex-end; 
            width: 100%; 
            max-width: 1000px; 
            margin: 40px auto 0 auto; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        .search-item { flex: 1; min-width: 0; text-align: left; }
        .search-item label {
            color: #fff; 
            font-size: 11px; 
            font-weight: 600; 
            text-transform: uppercase; 
            margin-bottom: 5px; 
            display: block; 
            letter-spacing: 0.5px;
        }
        .search-item input, .search-item select {
            width: 100%; 
            padding: 10px; 
            background: rgba(0,0,0,0.5); 
            border: 1px solid rgba(255,255,255,0.3); 
            border-radius: 4px; 
            color: #fff; 
            font-size: 14px; 
            outline: none;
        }
        .search-item input[type="date"] {
            color-scheme: dark; /* Kalender jadi gelap */
        }

        /* ============ SECTION KAMAR (THE WUJIL STYLE) ============ */
        .section-header {
            text-align: center;
            max-width: 900px;
            margin: 0 auto 50px auto;
        }
        .section-header h2 {
            font-size: 2.5rem;
            color: var(--text-main);
            margin-bottom: 20px;
        }
        .section-header p {
            color: var(--text-muted);
            font-size: 15px;
            line-height: 1.8;
        }

        /* Featured Room (Kamar Utama) */
        .featured-room {
            display: flex;
            background: #fff;
            box-shadow: 0 10px 40px rgba(0,0,0,0.05);
            margin-bottom: 50px;
            overflow: hidden;
        }
        .featured-img {
            width: 50%;
            height: 400px;
            object-fit: cover;
        }
        .featured-info {
            width: 50%;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }
        .featured-price {
            position: absolute;
            top: 0;
            right: 0;
            background: #222;
            color: #fff;
            padding: 10px 25px;
            font-size: 14px;
            font-weight: 600;
            clip-path: polygon(15% 0, 100% 0, 100% 100%, 0% 100%);
        }
        .featured-info h3 { font-size: 2rem; color: #333; margin-bottom: 15px; }
        .featured-info p { color: #666; font-size: 14px; line-height: 1.7; margin-bottom: 30px; }
        
        .btn-dark {
            background: #222;
            color: #fff;
            padding: 12px 24px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 1px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
            width: max-content;
        }
        .btn-dark:hover { background: #444; }
        .link-detail {
            color: #888;
            text-decoration: none;
            font-size: 14px;
            margin-left: 15px;
            transition: color 0.2s;
        }
        .link-detail:hover { color: var(--gold); }

        /* Grid Kamar Lainnya */
        .room-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 30px;
        }
        .room-card {
            background: #fff;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            overflow: hidden;
            position: relative;
            display: flex;
            flex-direction: column;
        }
        .room-img {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }
        .room-info {
            padding: 25px;
            text-align: center;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .room-info h3 { font-size: 1.3rem; color: #333; margin-bottom: 10px; }
        .room-info p { color: #666; font-size: 13px; line-height: 1.6; margin-bottom: 20px; flex: 1; }
        .room-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        /* Harga di Pojok Gambar */
        .price-tag {
            position: absolute;
            top: 15px;
            right: 0;
            background: #222;
            color: #fff;
            padding: 6px 20px;
            font-size: 12px;
            font-weight: 600;
            clip-path: polygon(15% 0, 100% 0, 100% 100%, 0% 100%);
            z-index: 10;
        }

        /* Responsif untuk Mobile */
        @media (max-width: 768px) {
            .search-bar-glass { flex-wrap: wrap; }
            .featured-room { flex-direction: column; }
            .featured-img, .featured-info { width: 100%; }
            .hero h1 { font-size: 2.5rem; }
        }
    </style>
</head>
<body>

        <!-- ============ NAVBAR PUBLIK ============ -->
    <header class="navbar" style="font-family: 'Inter', sans-serif;" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-6 h-full flex items-center justify-between">
            <a href="/" class="flex items-center gap-3">
                <img src="{{ asset('images/logoPutih.png') }}" alt="Audra Haven" class="h-16 w-auto object-contain">
            </a>

            <!-- Menu Desktop -->
            <nav class="hidden lg:flex items-center">
                <a href="/kamar" class="nav-link">Rooms & Suite</a>
                <a href="/restaurant" class="nav-link">Restaurant & Cafe</a>
                <a href="/weddings" class="nav-link">Weddings & Events</a>
                <a href="/hotel-facilities" class="nav-link">Facilities</a>
                <a href="#special-offers" class="nav-link">Special Offers</a>
                <a href="{{ route('faq') }}" class="nav-link">FAQ</a>
            </nav>

            <div class="flex items-center gap-4">
                <div class="hidden md:flex items-center text-sm text-white font-medium">
                    <span style="color: #ccc; margin-right: 15px;">|</span>
                    <span>📞 +6281234567890</span>
                </div>
                
                {{-- TOMBOL BOOK NOW PAKSA MUNCUL --}}
                <a href="/kamar" class="btn-gold whitespace-nowrap" style="font-size: 13px; padding: 10px 20px;">
    BOOK NOW
</a>
                
                {{-- TOMBOL LOGIN DENGAN IKON PROFESIONAL --}}
<a href="/login" class="flex items-center gap-2 text-white hover:text-[#b8935a] font-semibold transition mr-4" style="font-size: 14px;">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
    </svg>
    LOGIN
</a>

                <!-- TOMBOL MENU HP -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden text-white focus:outline-none">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        <path x-show="mobileMenuOpen" style="display: none;" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- DROPDOWN MENU HP -->
        <div x-show="mobileMenuOpen" style="display: none;" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="lg:hidden absolute top-full left-0 w-full bg-[#1a1a1a] bg-opacity-95 backdrop-blur-md border-t border-gray-700 shadow-xl">
            <div class="flex flex-col px-6 py-4 space-y-4">
                <a href="/kamar" class="text-white font-semibold hover:text-[#b8935a]">Rooms & Suite</a>
                <a href="/restaurant" class="text-white font-semibold hover:text-[#b8935a]">Restaurant & Cafe</a>
                <a href="/weddings" class="text-white font-semibold hover:text-[#b8935a]">Weddings & Events</a>
                <a href="/hotel-facilities" class="text-white font-semibold hover:text-[#b8935a]">Facilities</a>
                <a href="#special-offers" @click="mobileMenuOpen = false" class="text-white font-semibold hover:text-[#b8935a]">Special Offers</a>
                <a href="{{ route('faq') }}" class="text-white font-semibold hover:text-[#b8935a]">FAQ</a>
                
                <div class="pt-4 border-t border-gray-600 flex flex-col gap-3">
                    <a href="/login" class="block text-center text-white font-bold py-3 rounded border border-white hover:bg-white hover:text-black transition w-full">LOGIN</a>
                    <a href="/kamar" class="block text-center btn-gold w-full">BOOK NOW</a>
                </div>
            </div>
        </div>
    </header>

    <!-- ============ HERO SECTION ============ -->
    <section class="hero">
        
        {{-- Background Slider --}}
        <div class="hero-slider">
            <!-- Gambar 1 -->
            <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1571896349842-33c89424de2d?q=80&w=2000&auto=format&fit=crop');"></div>
            <!-- Gambar 2 -->
            <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=2000&auto=format&fit=crop');"></div>
        </div>

        <div class="hero-content">
            <h1>Pengalaman Menginap<br>Yang Tak Terlupakan</h1>
            <p class="text-lg mb-8 font-light">
                Nikmati kemewahan dan kenyamanan di jantung kota Semarang.
            </p>

            {{-- Search Bar Transparan --}}
            <form action="{{ route('search.rooms') }}" method="GET" class="search-bar-glass">
                <div class="search-item">
                    <label>Check In</label>
                    <input type="date" name="check_in" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="search-item">
                    <label>Check Out</label>
                    <input type="date" name="check_out" value="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                </div>
                <div class="search-item">
                    <label>Dewasa</label>
                    <select name="adults">
                        <option style="color: #000;" value="1">1 Dewasa</option>
                        <option style="color: #000;" value="2">2 Dewasa</option>
                    </select>
                </div>
                <div class="search-item">
                    <label>Anak-anak</label>
                    <select name="children">
                        <option style="color: #000;" value="0">0 Anak</option>
                        <option style="color: #000;" value="1">1 Anak</option>
                        <option style="color: #000;" value="1">2 Anak</option>  
                        <option style="color: #000;" value="1">3 Anak</option>                  
                    </select>
                </div>
                <button type="submit" class="btn-gold" style="height: 42px; padding: 0 25px; font-size: 13px; letter-spacing: 0.5px;">
                    CEK KETERSEDIAAN
                </button>
            </form>
    </section>

    <!-- ============ SECTION 1: WELCOME TEXT ============ -->
    <section class="py-20 bg-white">
        <div class="max-w-5xl mx-auto px-6 text-center">
            
            <h2 class="text-xl md:text-3xl lg:text-4xl font-bold text-gray-800 mb-4 font-serif whitespace-nowrap">
                Selamat Datang di Audra Haven Suites & Residences
            </h2>
            <p class="text-lg text-gray-500 italic mb-10">
                Where luxury meets comfort
            </p>

            <div class="text-gray-600 leading-loose space-y-6 text-base">
                <p>
                    Terletak di jantung kota Semarang, Audra Haven Suites & Residences menawarkan tempat peristirahatan yang mewah dengan pemandangan kota yang memukau. Dirancang untuk memenuhi kebutuhan para pelancong bisnis maupun wisatawan yang mencari kenyamanan maksimal.
                </p>
                <p>
                    Dengan 200 kamar dan suite yang elegan, pengalaman kuliner yang menggugah selera, ruang pertemuan yang luas, dan fasilitas rekreasi kelas atas, resor kami siap memanjakan Anda. Baik untuk liburan romantis, acara keluarga, maupun keperluan bisnis, kami menghadirkan pelayanan prima yang tak terlupakan.
                </p>
                <p>
                    Audra Haven adalah tempat yang sempurna untuk melarikan diri dari hiruk pikuk kota tanpa harus meninggalkan kenyamanan modern.
                </p>
            </div>
        </div>
    </section>


    <!-- ============ SECTION 2: SPECIAL OFFERS ============ -->
    <section id="special-offers" class="py-20 bg-gray-50" x-data="{ open: false, activeRoom: null }">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-12 font-serif">
                Special Offers
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <!-- Penawaran 1 (Deluxe) -->
                <div class="bg-white shadow-lg relative group overflow-hidden">
                    <div class="absolute top-0 right-0 bg-[#222] text-white px-6 py-2 z-10" style="clip-path: polygon(15% 0, 100% 0, 100% 100%, 0% 100%);">
                        <span class="text-xs">dari</span> <b>Rp 1.250.000</b>
                    </div>
                    <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?q=80&w=2070&auto=format&fit=crop" alt="Super Saver" class="w-full h-64 object-cover transform group-hover:scale-110 transition duration-500">
                    
                    <div class="p-8 text-center bg-white relative">
                        <h3 class="text-xl font-bold text-gray-800 mb-6">Super Saver</h3>
                        <button @click="activeRoom = 'deluxe'; open = true" class="bg-[#a38859] hover:bg-[#8c744c] text-white px-6 py-2 text-sm font-bold shadow-md transition">PESAN SEKARANG</button>
                        <button @click="activeRoom = 'deluxe'; open = true" class="block text-sm text-gray-500 hover:text-[#b8935a] mt-4 mx-auto">&rarr; Baca selengkapnya</button>
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
                        <button @click="activeRoom = 'premier'; open = true" class="bg-[#a38859] hover:bg-[#8c744c] text-white px-6 py-2 text-sm font-bold shadow-md transition">PESAN SEKARANG</button>
                        <button @click="activeRoom = 'premier'; open = true" class="block text-sm text-gray-500 hover:text-[#b8935a] mt-4 mx-auto">&rarr; Baca selengkapnya</button>
                    </div>
                </div>

                <!-- Penawaran 3 (Executive) -->
                <div class="bg-white shadow-lg relative group overflow-hidden">
                    <div class="absolute top-0 right-0 bg-[#222] text-white px-6 py-2 z-10" style="clip-path: polygon(15% 0, 100% 0, 100% 100%, 0% 100%);">
                        <span class="text-xs">dari</span> <b>Rp 2.500.000</b>
                    </div>
                    <img src="images/breakfast.jpg" alt="Room Breakfast" class="w-full h-64 object-cover transform group-hover:scale-110 transition duration-500">
                    
                    <div class="p-8 text-center bg-white relative">
                        <h3 class="text-xl font-bold text-gray-800 mb-6">Room & Breakfast</h3>
                        <button @click="activeRoom = 'executive'; open = true" class="bg-[#a38859] hover:bg-[#8c744c] text-white px-6 py-2 text-sm font-bold shadow-md transition">PESAN SEKARANG</button>
                        <button @click="activeRoom = 'executive'; open = true" class="block text-sm text-gray-500 hover:text-[#b8935a] mt-4 mx-auto">&rarr; Baca selengkapnya</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ==================== MODAL POPUP ==================== -->
        <div x-show="open" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center bg-black bg-opacity-70 p-4" x-transition.opacity>
            
            <div @click.away="open = false" class="bg-white rounded-lg shadow-2xl overflow-hidden max-w-4xl w-full flex flex-col md:flex-row relative" x-transition.scale.origin.center>
                
                <button @click="open = false" class="absolute top-4 right-4 bg-white rounded-full p-2 shadow hover:bg-gray-100 z-20">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

                <div class="md:w-1/2 h-64 md:h-auto">
                    <img :src="{
                        'deluxe': 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?q=80&w=2070&auto=format&fit=crop',
                        'premier': 'https://images.unsplash.com/photo-1590490360182-c33d57733427?q=80&w=1974&auto=format&fit=crop',
                        'executive': 'images/breakfast.jpg'
                    }[activeRoom]" class="w-full h-full object-cover">
                </div>

                <div class="md:w-1/2 p-8 md:p-10 flex flex-col justify-center">
                    <div class="inline-block bg-[#d4b483] text-[#222] font-bold px-4 py-1 mb-4 text-sm self-start" style="clip-path: polygon(10% 0, 100% 0, 100% 100%, 0% 100%);">
                        dari <span x-text="{
                            'deluxe': 'Rp 1.250.000',
                            'premier': 'Rp 1.750.000',
                            'executive': 'Rp 2.500.000'
                        }[activeRoom]"></span>
                    </div>

                    <h2 class="text-3xl font-bold text-gray-800 mb-2 font-serif" x-text="{
                        'deluxe': 'Super Saver',
                        'premier': 'Super Saver',
                        'executive': 'Room & Breakfast'
                    }[activeRoom]"></h2>
                    
                    <p class="text-gray-600 mb-6 text-sm" x-text="{
                        'deluxe': 'Cara Terbaik untuk Menginap dengan Ekstra Diskon 10%!',
                        'premier': 'Nikmati kamar lebih luas dengan balkon pribadi dan sarapan gratis.',
                        'executive': 'Rasakan pengalaman menginap mewah dengan fasilitas lengkap.'
                    }[activeRoom]"></p>

                    <ul class="text-sm text-gray-600 space-y-3 mb-8 list-disc pl-5">
                        <li><b>Kamar tanpa sarapan</b> (Khusus Super Saver).</li>
                        <li>Dilengkapi <b>Smart TV</b> untuk menambah kenyamanan.</li>
                        <li><b>Akses Wi-Fi gratis</b> untuk tetap terhubung.</li>
                        <li x-show="activeRoom === 'deluxe'">Kapasitas maksimal <b>2 orang</b>, ukuran 32m².</li>
                        <li x-show="activeRoom === 'premier'">Kapasitas maksimal <b>3 orang</b>, ukuran 40m².</li>
                        <li x-show="activeRoom === 'executive'">Kapasitas maksimal <b>3 orang</b>, ukuran 58m².</li>
                        <li>Penawaran ini tidak dapat dikembalikan.</li>
                    </ul>

                    <a href="/login" class="btn-gold hidden sm:inline-block" style="font-size: 13px; padding: 10px 20px;">
                        BOOK NOW
                    </a>
                </div>
            </div>
        </div>
    </section>


        <!-- ============ SECTION 3: JELAJAHI RESOR ============ -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4 font-serif">Jelajahi Resor</h2>
                <p class="text-gray-500">Jelajahi dan awali pengalaman indah Anda</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Kartu 1 (Kamar) -->
                <div class="bg-white shadow-md border border-gray-100 overflow-hidden group">
                    <div class="overflow-hidden h-56">
                        <img src="https://images.unsplash.com/photo-1591088398332-8a7791972843?q=80&w=2070&auto=format&fit=crop" alt="Kamar & Suite" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700">
                    </div>
                    <div class="p-8 text-center">
                        <h3 class="text-xl font-bold text-[#4a5568] mb-4">Kamar & Suite</h3>
                        <p class="text-sm text-gray-500 leading-relaxed mb-6">Temukan pilihan kamar hotel terbaik hanya di Audra Haven Suites & Residences Semarang. Nikmati kenyamanan menginap di kamar yang modern dan elegan...</p>
                        
                        <a href="/kamar" class="text-sm font-semibold text-[#b8935a] hover:text-[#9a7a44]">&rarr; Baca selengkapnya</a>
                    </div>
                </div>

                <!-- Kartu 2 (Wedding) -->
                <div class="bg-white shadow-md border border-gray-100 overflow-hidden group">
                    <div class="overflow-hidden h-56">
                        <img src="https://images.unsplash.com/photo-1519167758481-83f550bb49b3?q=80&w=2098&auto=format&fit=crop" alt="Pernikahan & Acara" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700">
                    </div>
                    <div class="p-8 text-center">
                        <h3 class="text-xl font-bold text-[#4a5568] mb-4">Pernikahan & Acara</h3>
                        <p class="text-sm text-gray-500 leading-relaxed mb-6">Saat merencanakan acara istimewa di Semarang, seperti pernikahan, konferensi perusahaan, atau perayaan khusus. Memilih venue yang tepat dan mendapatkan layanan...</p>
                        
                        <a href="/weddings" class="text-sm font-semibold text-[#b8935a] hover:text-[#9a7a44]">&rarr; Baca selengkapnya</a>
                    </div>
                </div>

                <!-- Kartu 3 (Fasilitas) -->
                <div class="bg-white shadow-md border border-gray-100 overflow-hidden group">
                    <div class="overflow-hidden h-56">
                        <img src="images/pool.jpg" alt="Fasilitas" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700">
                    </div>
                    <div class="p-8 text-center">
                        <h3 class="text-xl font-bold text-[#4a5568] mb-4">Fasilitas</h3>
                        <p class="text-sm text-gray-500 leading-relaxed mb-6">Di Audra Haven Suites & Residences, kami percaya dalam memberikan tamu kami pengalaman yang benar-benar mendalam dan tak terlupakan. Itu...</p>
                        
                        <a href="/hotel-facilities" class="text-sm font-semibold text-[#b8935a] hover:text-[#9a7a44]">&rarr; Baca selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

        <!-- ============ FOOTER LENGKAP ============ -->
    <footer class="bg-[#1a1a1a] text-gray-400 py-16 mt-20">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-10">
            
            <div class="col-span-2">
                <img src="{{ asset('images/logo.png') }}" alt="Audra Haven" class="h-12 w-auto mb-6 brightness-0 invert opacity-80">
                <p class="text-sm leading-relaxed max-w-md">
                    Rasakan pengalaman menginap yang tak terlupakan di Audra Haven Suites & Residences. Kami menghadirkan kemewahan, kenyamanan, dan pelayanan prima untuk Anda.
                </p>
            </div>

            <div>
                <h4 class="text-white text-lg font-serif mb-4">Hubungi Kami</h4>
                <ul class="text-sm space-y-3">
                    <li>Jl. BSB Boulevard No. 123, Semarang</li>
                    <li>Telp: (024) 123-4567</li>
                    <li>Email: info@audrahaven.com</li>
                </ul>
            </div>

            <div>
                <h4 class="text-white text-lg font-serif mb-4">Tautan Cepat</h4>
                <ul class="text-sm space-y-3">
                    <li><a href="/kamar" class="hover:text-[#b8935a]">Kamar & Suite</a></li>
                    <li><a href="/hotel-facilities" class="hover:text-[#b8935a]">Fasilitas</a></li>
                    <li><a href="#" class="hover:text-[#b8935a]">Kebijakan Privasi</a></li>
                </ul>
            </div>

        </div>
        <div class="max-w-7xl mx-auto px-6 mt-16 pt-8 border-t border-gray-800 text-center text-xs">
            &copy; {{ date('Y') }} Audra Haven Suites & Residences. All rights reserved.
        </div>
    </footer>