@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    @php
        $rp = fn ($n) => 'Rp ' . number_format($n, 0, ',', '.');
        $ranges = [7 => '7 hari', 30 => '30 hari', 90 => '90 hari', 365 => '1 tahun'];
        $occPct = $totalRooms > 0 ? round($occupied / $totalRooms * 100) : 0;
    @endphp

    {{-- ============ SAPAAN + FILTER PERIODE ============ --}}
    <div class="flex flex-wrap items-end justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold">Selamat datang, {{ auth()->user()->full_name }}! 👋</h2>
            <p style="color: var(--text-secondary);">
                Anda login sebagai <span class="font-semibold capitalize">{{ auth()->user()->role->label ?? '-' }}</span>.
            </p>
        </div>

        <div class="inline-flex rounded-lg overflow-hidden border" style="border-color: rgba(184,147,90,.45);" role="group" aria-label="Periode">
            @foreach ($ranges as $value => $label)
                <a href="{{ route('dashboard', ['range' => $value]) }}"
                   class="px-4 py-2 text-sm font-semibold transition"
                   style="{{ $range === $value ? 'background:#b8935a;color:#2b2015;' : 'color:var(--text-secondary);' }}"
                   @if ($range === $value) aria-current="true" @endif>{{ $label }}</a>
            @endforeach
        </div>
    </div>

    {{-- ============ KARTU STATISTIK ============ --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
        <div class="card p-5">
            <div class="text-sm" style="color: var(--text-secondary);">Pendapatan ({{ $ranges[$range] }})</div>
            <div class="text-2xl font-bold mt-1" style="color: var(--gold);">{{ $rp($revenue) }}</div>
            <div class="text-xs mt-1" style="color: var(--text-secondary);">
                @if ($revDelta === null)
                    Belum ada pembanding periode sebelumnya
                @else
                    <span style="color: {{ $revDelta >= 0 ? 'var(--success)' : '#b85450' }}; font-weight:600;">
                        {{ $revDelta >= 0 ? '▲' : '▼' }} {{ abs($revDelta) }}%
                    </span> dari periode sebelumnya
                @endif
            </div>
        </div>

        <div class="card p-5">
            <div class="text-sm" style="color: var(--text-secondary);">Total Pesanan ({{ $ranges[$range] }})</div>
            <div class="text-2xl font-bold mt-1">{{ number_format($totalOrders, 0, ',', '.') }}</div>
            <div class="text-xs mt-1" style="color: var(--text-secondary);">{{ $ordersToday }} pesanan hari ini</div>
        </div>

        <div class="card p-5">
            <div class="text-sm" style="color: var(--text-secondary);">Okupansi Kamar</div>
            <div class="text-2xl font-bold mt-1">{{ $occPct }}%</div>
            <div class="text-xs mt-1" style="color: var(--text-secondary);">
                {{ $occupied }} terisi · <span style="color: var(--success);">{{ $available }} tersedia</span> · {{ $totalRooms }} kamar
            </div>
        </div>

        <div class="card p-5">
            <div class="text-sm" style="color: var(--text-secondary);">Menunggu Verifikasi</div>
            <div class="text-2xl font-bold mt-1">{{ $pendingProof }}</div>
            <div class="text-xs mt-1" style="color: var(--text-secondary);">
                {{ $pendingNone }} belum unggah bukti · {{ $totalUsers }} pengguna terdaftar
            </div>
        </div>
    </div>

    {{-- ============ GRAFIK BARIS 1 ============ --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-6">
        <div class="card p-6 xl:col-span-2">
            <h3 class="font-semibold mb-1 text-lg">Pendapatan</h3>
            <p class="text-xs mb-4" style="color: var(--text-secondary);">Dari pembayaran berstatus berhasil, per {{ $charts['monthly'] ? 'bulan' : 'hari' }}.</p>
            <div class="relative h-72" data-empty="Belum ada pembayaran berhasil pada periode ini.">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <div class="card p-6">
            <h3 class="font-semibold mb-1 text-lg">Pesanan per Kategori</h3>
            <p class="text-xs mb-4" style="color: var(--text-secondary);">Kamar, fasilitas, meja, makanan, gedung.</p>
            <div class="relative h-72" data-empty="Belum ada pesanan pada periode ini.">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>
    </div>

    {{-- ============ GRAFIK BARIS 2 ============ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <div class="card p-6">
            <h3 class="font-semibold mb-4 text-lg">Status Pesanan</h3>
            <div class="relative h-60" data-empty="Belum ada pesanan pada periode ini.">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <div class="card p-6">
            <h3 class="font-semibold mb-4 text-lg">Metode Pembayaran</h3>
            <div class="relative h-60" data-empty="Belum ada pembayaran pada periode ini.">
                <canvas id="methodChart"></canvas>
            </div>
        </div>

        <div class="card p-6">
            <h3 class="font-semibold mb-4 text-lg">Status Kamar</h3>
            <div class="relative h-60" data-empty="Belum ada data kamar.">
                <canvas id="roomsChart"></canvas>
            </div>
        </div>
    </div>

    {{-- ============ PESANAN KAMAR TERBARU ============ --}}
    <div class="card p-6">
        <div class="flex items-center justify-between mb-3">
            <h3 class="font-semibold text-lg">Pesanan Kamar Terbaru</h3>
            <a href="{{ route('bookings.index') }}" class="text-sm font-semibold" style="color: var(--gold);">Lihat semua →</a>
        </div>

        @if ($recent->isEmpty())
            <p class="text-sm" style="color: var(--text-secondary);">Belum ada pesanan kamar.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-xs uppercase" style="color: var(--text-secondary);">
                        <tr>
                            <th class="py-2 pr-4 text-left">Kode</th>
                            <th class="py-2 pr-4 text-left">Tamu</th>
                            <th class="py-2 pr-4 text-left">Kamar</th>
                            <th class="py-2 pr-4 text-left">Check-in</th>
                            <th class="py-2 pr-4 text-left">Total</th>
                            <th class="py-2 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recent as $b)
                            <tr class="border-t" style="border-color: rgba(128,128,128,.18);">
                                <td class="py-3 pr-4 font-mono text-xs">{{ $b->booking_code }}</td>
                                <td class="py-3 pr-4">{{ $b->user->full_name ?? '-' }}</td>
                                <td class="py-3 pr-4">
                                    {{ $b->room->room_number ?? '-' }}
                                    <span class="text-xs" style="color: var(--text-secondary);">({{ $b->room->roomType->name ?? '-' }})</span>
                                </td>
                                <td class="py-3 pr-4">{{ $b->check_in?->format('d M Y') }}</td>
                                <td class="py-3 pr-4">{{ $rp($b->total_price) }}</td>
                                <td class="py-3">@include('bookings.partials.status-badge', ['status' => $b->status])</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- ============ SCRIPT GRAFIK ============ --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const D = @json($charts);
            const css = getComputedStyle(document.documentElement);
            const textColor = (css.getPropertyValue('--text-secondary') || '').trim() || '#6b5d4a';
            const grid = 'rgba(128,128,128,.16)';
            const palette = ['#b8935a', '#7a9471', '#8b9bb4', '#b85450', '#d4a05a', '#5a4630', '#b9ad9a'];
            const rupiah = n => 'Rp ' + Math.round(n).toLocaleString('id-ID');
            const short = v => v >= 1e9 ? (v / 1e9) + ' M' : v >= 1e6 ? (v / 1e6) + ' jt' : v >= 1e3 ? (v / 1e3) + ' rb' : v;

            Chart.defaults.color = textColor;
            Chart.defaults.font.family = 'inherit';

            function draw(id, values, config) {
                const canvas = document.getElementById(id);
                const box = canvas.parentElement;
                if (!values.some(v => v > 0)) {
                    box.innerHTML = '<div style="height:100%;display:grid;place-items:center;text-align:center;font-size:14px;color:' + textColor + ';">' + box.dataset.empty + '</div>';
                    return;
                }
                new Chart(canvas.getContext('2d'), config);
            }

            const donut = (labels, values) => ({
                type: 'doughnut',
                data: { labels, datasets: [{ data: values, backgroundColor: palette, borderWidth: 2, borderColor: 'transparent' }] },
                options: { responsive: true, maintainAspectRatio: false, cutout: '62%', plugins: { legend: { position: 'bottom', labels: { boxWidth: 12 } } } }
            });

            // 1. Pendapatan (garis berisi)
            draw('revenueChart', D.revenue.values, {
                type: 'line',
                data: {
                    labels: D.revenue.labels,
                    datasets: [{
                        label: 'Pendapatan', data: D.revenue.values, borderColor: '#b8935a',
                        backgroundColor: 'rgba(184,147,90,.18)', fill: true, tension: .35, pointRadius: D.revenue.values.length > 40 ? 0 : 3
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: { legend: { display: false }, tooltip: { callbacks: { label: c => ' ' + rupiah(c.parsed.y) } } },
                    scales: {
                        x: { grid: { display: false }, ticks: { maxTicksLimit: 10 } },
                        y: { beginAtZero: true, grid: { color: grid }, ticks: { callback: short } }
                    }
                }
            });

            // 2. Pesanan per kategori (batang)
            draw('categoryChart', D.category.values, {
                type: 'bar',
                data: { labels: D.category.labels, datasets: [{ data: D.category.values, backgroundColor: palette, borderRadius: 6 }] },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { x: { grid: { display: false } }, y: { beginAtZero: true, grid: { color: grid }, ticks: { precision: 0 } } }
                }
            });

            // 3. Status pesanan (batang horizontal)
            draw('statusChart', D.status.values, {
                type: 'bar',
                data: { labels: D.status.labels, datasets: [{ data: D.status.values, backgroundColor: ['#d4a05a', '#8b9bb4', '#b8935a', '#7a9471', '#5a4630', '#b85450'], borderRadius: 6 }] },
                options: {
                    indexAxis: 'y', responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { x: { beginAtZero: true, grid: { color: grid }, ticks: { precision: 0 } }, y: { grid: { display: false } } }
                }
            });

            // 4. Metode pembayaran, 5. Status kamar (donat)
            draw('methodChart', D.method.values, donut(D.method.labels, D.method.values));

            const roomCfg = donut(D.rooms.labels, D.rooms.values);
            roomCfg.data.datasets[0].backgroundColor = ['#7a9471', '#b85450', '#8b9bb4', '#b9ad9a'];
            draw('roomsChart', D.rooms.values, roomCfg);
        });
    </script>
@endsection