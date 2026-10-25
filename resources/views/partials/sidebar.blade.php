<aside class="flex flex-col h-full">
    @php
        $user = auth()->user();
        $role = $user->role->name ?? 'guest';
    @endphp

    {{-- Area Foto Admin/User (Atas) --}}
    <div class="p-6 flex flex-col items-center border-b" style="border-color: var(--sidebar-border);">
        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->full_name ?? 'Tamu') }}&background=b8935a&color=fff&size=80&rounded=true" 
             alt="Profile" 
             class="w-16 h-16 rounded-full shadow-lg mb-3 border-2 border-[#d4b483]">
        <h2 class="text-sm font-bold text-white capitalize">{{ $user->full_name ?? 'Tamu' }}</h2>
        <span class="text-xs text-[#8b7355] uppercase tracking-wider">{{ $user->role->label ?? 'Tamu' }}</span>
    </div>

    {{-- Menu Navigasi --}}
    <nav class="sidebar-nav flex-1 mt-4">
        {{-- SEMBUNYIKAN MENU JIKA YANG LOGIN ADALAH GUEST --}}
        @if($role !== 'guest')
            @php
                $menu = [
                    ['dashboard', 'Dashboard', ['admin','manager','receptionist']],
                    ['rooms.index', 'Kamar', ['admin','manager','receptionist']],
                    ['facilities.index', 'Fasilitas', ['admin','manager','receptionist']],
                    ['halls.index', 'Gedung', ['admin','manager']],
                    ['menu.index', 'Restoran', ['admin','manager','receptionist']],
                    ['bookings.index', 'Pesanan', ['admin','manager','receptionist']],
                    ['users.index', 'Pengguna', ['admin']],
                    ['reports.index', 'Laporan', ['admin','manager']],
                ];
            @endphp

            @foreach ($menu as $item)
                @php
                    [$routeName, $label, $allowedRoles] = $item;
                    $canAccess = in_array($role, $allowedRoles);
                    $hasRoute = Route::has($routeName);
                    $isActive = $hasRoute && request()->routeIs($routeName);
                @endphp

                @if ($canAccess && $hasRoute)
                    <a href="{{ route($routeName) }}" class="sidebar-link {{ $isActive ? 'active' : '' }}">
                        {{ $label }}
                    </a>
                @endif
            @endforeach
        @else
            {{-- Menu khusus Tamu --}}
            <a href="/" class="sidebar-link">
                <i class="bi bi-house mr-2"></i> Kembali ke Beranda
            </a>
        @endif
    </nav>

    {{-- Tombol Logout --}}
    <div class="p-4 border-t" style="border-color: var(--sidebar-border);">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left sidebar-link text-sm" style="color: #f0a8a0;">
                Logout
            </button>
        </form>
    </div>
</aside>