<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Audra Haven')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- ALPINE.JS WAJIB ADA DI SINI AGAR TOMBOL & MENU BERFUNGSI --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; color: #2d2317; }
        h1, h2, h3, h4, .font-serif { font-family: 'Playfair Display', serif; }
        
        /* Navbar Putih Elegan */
        .navbar {
            background: #ffffff;
            box-shadow: 0 1px 4px rgba(0,0,0,0.05);
            position: sticky; 
            top: 0; 
            z-index: 50; 
            height: 96px;
        }
        .nav-link { 
            font-size: 14px; 
            font-weight: 600; 
            color: #2d2317; 
            text-decoration: none; 
            margin: 0 15px; 
            transition: color 0.2s; 
        }
        .nav-link:hover, .nav-link.active { color: #b8935a; }
    </style>
</head>
<body>

    <!-- Navbar Publik -->
    <header class="navbar border-b border-gray-200" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-6 h-full flex items-center justify-between">
            <a href="/" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Audra Haven" class="h-16 w-auto object-contain">
            </a>

            <!-- Menu Desktop -->
            <nav class="hidden lg:flex items-center">
                <div class="relative group" style="margin: 0 15px;">
                    <a href="/kamar" class="nav-link" style="margin: 0; display: block;">Rooms & Suite</a>
                    <div class="absolute left-0 mt-2 w-64 bg-[#222] text-white opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 shadow-2xl z-50 rounded-b-md overflow-hidden">
                        <a href="/kamar/audra" class="block px-6 py-4 text-sm hover:text-[#b8935a] transition border-b border-gray-700">The Audra Room</a>
                        <a href="/kamar/premier" class="block px-6 py-4 text-sm hover:text-[#b8935a] transition border-b border-gray-700">Premier Room</a>
                        <a href="/kamar/executive" class="block px-6 py-4 text-sm hover:text-[#b8935a] transition border-b border-gray-700">Executive Suite</a>
                        <a href="/kamar/family" class="block px-6 py-4 text-sm hover:text-[#b8935a] transition border-b border-gray-700">Family Suite</a>
                        <a href="/kamar/presidential" class="block px-6 py-4 text-sm hover:text-[#b8935a] transition border-b border-gray-700">Presidential Residence</a>
                        <a href="/kamar/garden" class="block px-6 py-4 text-sm hover:text-[#b8935a] transition border-b border-gray-700">Garden View Room</a>
                        <a href="/kamar/sky" class="block px-6 py-4 text-sm hover:text-[#b8935a] transition">Skyline Penthouse</a>
                    </div>
                </div>

                <div class="relative group" style="margin: 0 15px;">
                    <a href="/restaurant" class="nav-link" style="margin: 0; display: block;">Restaurant & Cafe</a>
                    <div class="absolute left-0 mt-2 w-64 bg-[#222] text-white opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 shadow-2xl z-50 rounded-b-md overflow-hidden">
                        <a href="#" class="block px-6 py-4 text-sm hover:text-[#b8935a] transition border-b border-gray-700">Solstice Garden Café</a>
                        <a href="/detail/restaurant/ruigo" class="block px-6 py-4 text-sm hover:text-[#b8935a] transition border-b border-gray-700">RUIGO Lounge</a>
                        <a href="/detail/restaurant/poolbar" class="block px-6 py-4 text-sm hover:text-[#b8935a] transition border-b border-gray-700">Pool Bar</a>
                        <a href="/detail/restaurant/executive" class="block px-6 py-4 text-sm hover:text-[#b8935a] transition">Executive Lounge</a>
                    </div>
                </div>

                <div class="relative group" style="margin: 0 15px;">
                    <a href="/weddings" class="nav-link" style="margin: 0; display: block;">Weddings & Events</a>
                    <div class="absolute left-0 mt-2 w-64 bg-[#222] text-white opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 shadow-2xl z-50 rounded-b-md overflow-hidden">
                        <a href="#" class="block px-6 py-4 text-sm hover:text-[#b8935a] transition border-b border-gray-700">The Emerald Ballroom</a>
                        <a href="/detail/wedding/meeting" class="block px-6 py-4 text-sm hover:text-[#b8935a] transition border-b border-gray-700">Meeting Room</a>
                        <a href="/detail/wedding/vip" class="block px-6 py-4 text-sm hover:text-[#b8935a] transition border-b border-gray-700">VIP Room</a>
                        <a href="/detail/wedding/outdoor" class="block px-6 py-4 text-sm hover:text-[#b8935a] transition">Svarga Outdoor</a>
                    </div>
                </div>

                <div class="relative group" style="margin: 0 15px;">
                    <a href="/hotel-facilities" class="nav-link" style="margin: 0; display: block;">Facilities</a>
                    <div class="absolute left-0 mt-2 w-64 bg-[#222] text-white opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 shadow-2xl z-50 rounded-b-md overflow-hidden">
                        <a href="#" class="block px-6 py-4 text-sm hover:text-[#b8935a] transition border-b border-gray-700">The Audra Aqua Park</a>
                        <a href="/detail/facility/gym" class="block px-6 py-4 text-sm hover:text-[#b8935a] transition border-b border-gray-700">Bhuana Fitness Club</a>
                        <a href="/detail/facility/spa" class="block px-6 py-4 text-sm hover:text-[#b8935a] transition border-b border-gray-700">Audra Wellness</a>
                        <a href="/detail/facility/kids" class="block px-6 py-4 text-sm hover:text-[#b8935a] transition">Klub Anak</a>
                    </div>
                </div>

                <a href="/#special-offers" class="nav-link">Special Offers</a>
                <a href="{{ route('faq') }}" class="nav-link">FAQ</a>
            </nav>

            <div class="flex items-center gap-4">
                
                                @auth
                    @if(auth()->user()->role->name === 'guest')
                        <a href="{{ route('guest.riwayat') }}" class="bg-[#b8935a] hover:bg-[#9a7a44] text-white font-bold py-3 px-6 rounded transition hidden sm:inline-block" style="font-size: 13px;">
                            RIWAYAT PESANAN
                        </a>
                        
                        {{-- LOGOUT EMAS GELAP --}}
                        <form method="POST" action="{{ route('logout') }}" class="hidden sm:inline-block">
                            @csrf
                            <button type="submit" class="bg-[#9a7a44] hover:bg-[#7a5f33] text-white font-bold py-3 px-6 rounded transition" style="font-size: 13px;">
                                LOGOUT
                            </button>
                        </form>
                        
                    @else
                        <a href="/dashboard" class="bg-[#b8935a] hover:bg-[#9a7a44] text-white font-bold py-3 px-6 rounded transition hidden sm:inline-block" style="font-size: 13px;">
                            DASHBOARD
                        </a>
                    @endif
                @else
                    <a href="/login" class="bg-[#b8935a] hover:bg-[#9a7a44] text-white font-bold py-3 px-6 rounded transition hidden sm:inline-block" style="font-size: 13px;">
                        BOOK NOW
                    </a>
                @endauth
                
                <!-- TOMBOL MENU HP -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden text-[#2d2317] focus:outline-none">
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
             class="lg:hidden absolute top-full left-0 w-full bg-white border-t border-gray-200 shadow-xl z-50">
            <div class="flex flex-col px-6 py-4 space-y-4">
                <a href="/kamar" class="text-gray-800 font-semibold hover:text-[#b8935a]">Rooms & Suite</a>
                <a href="/restaurant" class="text-gray-800 font-semibold hover:text-[#b8935a]">Restaurant & Cafe</a>
                <a href="/weddings" class="text-gray-800 font-semibold hover:text-[#b8935a]">Weddings & Events</a>
                <a href="/hotel-facilities" class="text-gray-800 font-semibold hover:text-[#b8935a]">Facilities</a>
                <a href="/#special-offers" class="text-gray-800 font-semibold hover:text-[#b8935a]">Special Offers</a>
                <a href="{{ route('faq') }}" class="text-gray-800 font-semibold hover:text-[#b8935a]">FAQ</a>
                
                <div class="pt-4 border-t border-gray-200 flex flex-col gap-2">
                    @auth
                        @if(auth()->user()->role->name === 'guest')
                            <a href="{{ route('guest.riwayat') }}" class="block text-center bg-[#b8935a] text-white font-bold py-3 rounded transition w-full">
                                RIWAYAT PESANAN
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block text-center bg-red-500 text-white font-bold py-3 rounded transition w-full">
                                    LOGOUT
                                </button>
                            </form>
                        @else
                            <a href="/dashboard" class="block text-center bg-[#b8935a] text-white font-bold py-3 rounded transition w-full">
                                DASHBOARD
                            </a>
                        @endif
                    @else
                        <a href="/login" class="block text-center bg-[#b8935a] text-white font-bold py-3 rounded transition w-full">
                            BOOK NOW
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Konten Halaman -->
    <main>
        @yield('content')
    </main>

    <!-- Footer Publik -->
    <footer class="footer py-16 mt-20">
        <div class="max-w-7xl mx-auto px-6 text-center text-sm">
            &copy; {{ date('Y') }} Audra Haven Suites & Residences. All rights reserved.
        </div>
    </footer>

</body>
</html>