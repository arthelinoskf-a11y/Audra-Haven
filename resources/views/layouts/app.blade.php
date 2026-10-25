<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') - Audra Haven</title>

    {{-- Tailwind (utility untuk halaman CRUD) --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- CSS Custom Audra --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- Chart.js untuk Grafik --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Script tema --}}
    <script src="{{ asset('js/audra.js') }}"></script>

    @stack('styles')

        <script>
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = `px-6 py-4 rounded-lg shadow-xl text-white font-semibold transition-all duration-300 transform translate-x-full opacity-0 ${
                type === 'success' ? 'bg-[#7a9471]' : 'bg-[#b85450]'
            }`;
            toast.innerText = message;

            container.appendChild(toast);

            // Animasi Masuk
            setTimeout(() => {
                toast.classList.remove('translate-x-full', 'opacity-0');
            }, 100);

            // Animasi Keluar dan Hapus
            setTimeout(() => {
                toast.classList.add('translate-x-full', 'opacity-0');
                setTimeout(() => toast.remove(), 300);
            }, 3500);
        }
    </script>
    <style>
    /* Sidebar Transisi */
    .app-sidebar {
        transition: all 0.3s ease-in-out;
        width: 260px;
    }
    .app-sidebar.collapsed {
        width: 0;
        padding: 0;
        overflow: hidden;
        opacity: 0;
    }
    /* Penyesuaian konten saat sidebar tertutup */
    .app-content {
        transition: all 0.3s ease-in-out;
        width: 100%;
    }
    /* Tombol Toggle */
    .btn-toggle-sidebar {
        background: transparent;
        border: 1px solid var(--border);
        color: var(--text-primary);
        padding: 8px 12px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .btn-toggle-sidebar:hover {
        background: var(--bg-hover);
    }
</style>
</head>
<body>

    <div class="app-layout">
    {{-- Sidebar --}}
    <aside class="app-sidebar" id="mainSidebar">
        @include('partials.sidebar')
    </aside>

    <div class="app-content" id="mainContent">
        {{-- Navbar --}}
        @include('partials.navbar')
        
        <main class="app-main">
            @yield('content')
        </main>
        <!-- ... footer ... -->
    </div>
</div>

    @stack('scripts')
</body>
</html>