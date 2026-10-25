<header class="app-navbar">
    <div class="flex items-center gap-4">
        {{-- Tombol Toggle Sidebar (Tetap Ada) --}}
        <button class="btn-toggle-sidebar" onclick="toggleSidebar()" title="Buka/Tutup Sidebar">
            ☰
        </button>
        
        {{-- Judul Halaman --}}
        <h1 class="navbar-title m-0">@yield('title', 'Dashboard')</h1>
    </div>

    <div class="navbar-right">
        <span class="navbar-date">
            {{ now()->translatedFormat('l, d F Y') }}
        </span>

        <button id="themeToggle" class="theme-toggle" title="Ganti Tema">🌙</button>

        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button type="submit" class="btn-logout">Logout</button>
        </form>
    </div>
</header>

<script>
    function toggleSidebar() {
        document.getElementById('mainSidebar').classList.toggle('collapsed');
        // Simpan status di localStorage agar tidak reset saat pindah halaman
        const isCollapsed = document.getElementById('mainSidebar').classList.contains('collapsed');
        localStorage.setItem('sidebar-collapsed', isCollapsed);
    }

    // Cek status saat halaman dimuat
    document.addEventListener('DOMContentLoaded', () => {
        if (localStorage.getItem('sidebar-collapsed') === 'true') {
            document.getElementById('mainSidebar').classList.add('collapsed');
        }
    });
</script>