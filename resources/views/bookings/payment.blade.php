@extends('layouts.public')

@section('title', 'Pembayaran - Audra Haven')

@section('content')
@php
    $rp = fn ($n) => 'Rp ' . number_format($n, 0, ',', '.');
    $status = $payment->status ?? 'pending';
    $isCash = ($payment->method_type ?? '') === 'cash';
    $statusText = ['pending' => 'Menunggu pembayaran', 'success' => 'Pembayaran berhasil', 'failed' => 'Pembayaran ditolak', 'expired' => 'Kedaluwarsa', 'refunded' => 'Dikembalikan'][$status] ?? $status;
    $statusColor = ['pending' => 'bg-yellow-100 text-yellow-800', 'success' => 'bg-green-100 text-green-800', 'failed' => 'bg-red-100 text-red-800'][$status] ?? 'bg-gray-100 text-gray-700';
@endphp

<div class="max-w-5xl mx-auto px-6 py-12">

    @if (session('success'))
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 text-green-800 px-5 py-3 text-sm" role="status">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 text-red-700 px-5 py-3 text-sm" role="alert">{{ $errors->first() }}</div>
    @endif

    <div class="flex flex-wrap items-center justify-between gap-3 mb-8">
        <div>
            <h1 class="text-3xl font-bold font-serif text-gray-800">Pembayaran</h1>
            <p class="text-gray-500">Kode pesanan <span class="font-mono font-semibold text-gray-800">{{ $booking->booking_code }}</span></p>
        </div>
        <span class="px-3 py-1.5 rounded-full text-sm font-semibold {{ $statusColor }}">{{ $statusText }}</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-5 gap-8">

        {{-- ========== INSTRUKSI PEMBAYARAN ========== --}}
        <div class="md:col-span-3 space-y-6">

            @if ($payment)
            <section class="bg-white rounded-xl shadow border border-gray-100 p-6">
                <h2 class="text-lg font-bold font-serif mb-4">{{ $payment->method_name ?? 'Pembayaran' }}</h2>

                @if ($payment->method_type === 'qris')
                    <div class="flex flex-col items-center text-center">
                        <div class="w-64 h-64 border-2 border-dashed border-[#b8935a]/50 rounded-xl grid place-items-center bg-white overflow-hidden mb-4">
                            @if ($payment->qr_image)
                                {{-- UBAH BARIS DI BAWAH INI --}}
                                <img src="{{ asset($payment->qr_image) }}" alt="Kode QRIS Audra Haven" class="w-full h-full object-contain"
                                    onerror="this.replaceWith(Object.assign(document.createElement('p'),{className:'text-sm text-gray-400 px-6',textContent:'Gambar QRIS belum diunggah. Hubungi resepsionis.'}))">
                            @else
                                <p class="text-sm text-gray-400 px-6">Gambar QRIS belum diunggah. Hubungi resepsionis.</p>
                            @endif
                        </div>
                        <p class="text-sm text-gray-500">Scan dengan aplikasi bank atau e-wallet apa pun, lalu bayar tepat</p>
                        <p class="text-2xl font-bold text-[#b8935a] mt-1">{{ $rp($payment->amount) }}</p>
                    </div>

                @elseif ($isCash)
                    <p class="text-gray-600 text-sm">Bayar langsung di resepsionis saat check-in sebesar <b>{{ $rp($payment->amount) }}</b>. Tunjukkan kode pesanan di atas.</p>

                @else
                    <dl class="space-y-4 text-sm">
                        <div>
                            <dt class="text-gray-500 mb-1">{{ $payment->method_type === 'ewallet' ? 'Nomor' : 'Nomor rekening' }} {{ $payment->method_name }}</dt>
                            <dd class="flex items-center gap-3">
                                <span id="accNo" class="font-mono text-2xl font-bold tracking-wide">{{ $payment->account_number }}</span>
                                <button type="button" data-copy="#accNo" class="px-3 py-1 rounded border border-[#b8935a] text-[#7a5f33] text-xs font-semibold hover:bg-[#faf3e6]">Salin</button>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 mb-1">Atas nama</dt>
                            <dd class="font-semibold">{{ $payment->account_name }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 mb-1">Jumlah yang harus dibayar</dt>
                            <dd class="flex items-center gap-3">
                                <span id="amountText" data-raw="{{ (int) $payment->amount }}" class="text-2xl font-bold text-[#b8935a]">{{ $rp($payment->amount) }}</span>
                                <button type="button" data-copy-raw="#amountText" class="px-3 py-1 rounded border border-[#b8935a] text-[#7a5f33] text-xs font-semibold hover:bg-[#faf3e6]">Salin</button>
                            </dd>
                        </div>
                    </dl>
                @endif

                @if ($payment->instructions)
                    <p class="text-sm text-gray-500 mt-5 border-t border-gray-100 pt-4">{{ $payment->instructions }}</p>
                @endif
            </section>

            {{-- Unggah bukti --}}
            @if (!$isCash && $status !== 'success')
            <section class="bg-white rounded-xl shadow border border-gray-100 p-6">
                <h2 class="text-lg font-bold font-serif mb-1">Unggah Bukti Pembayaran</h2>
                @if ($payment->proof_file)
                    <p class="text-sm text-green-700 mb-3">
                        Bukti sudah terkirim —
                        <a class="underline" href="{{ asset('storage/' . $payment->proof_file) }}" target="_blank" rel="noopener">lihat file</a>.
                        Kamu bisa mengunggah ulang jika perlu.
                    </p>
                @else
                    <p class="text-sm text-gray-500 mb-3">Setelah membayar, unggah bukti transfer agar pesanan segera diverifikasi.</p>
                @endif

                <form action="{{ route('booking.room.proof', $booking->booking_code) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                    @csrf
                    <input type="file" name="proof" accept="image/png,image/jpeg,application/pdf" required
                           class="block w-full text-sm border border-gray-300 rounded px-3 py-2 file:mr-3 file:border-0 file:bg-[#b8935a] file:text-white file:font-semibold file:px-3 file:py-1 file:rounded">
                    <input type="text" name="reference_note" maxlength="120" placeholder="Catatan (opsional), mis. nama pengirim"
                           class="w-full border border-gray-300 rounded px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#b8935a]">
                    <button class="bg-[#b8935a] hover:bg-[#9a7a44] text-white font-bold py-2.5 px-6 rounded transition">Kirim Bukti</button>
                    <p class="text-xs text-gray-400">JPG, PNG, atau PDF, maksimal 4 MB.</p>
                </form>
            </section>
            @endif
            @endif
        </div>

        {{-- ========== RINGKASAN ========== --}}
        <aside class="md:col-span-2">
            <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden md:sticky md:top-28">
                @if ($photo)
                    <img src="{{ $photo }}" alt="{{ $type->name }}" class="w-full h-40 object-cover bg-gray-100">
                @endif
                <div class="p-5">
                    <p class="font-bold font-serif text-lg">{{ $type->name }}</p>
                    <p class="text-sm text-gray-500 mb-4">Kamar {{ $booking->room_number }}</p>

                    <dl class="space-y-2 text-sm">
                        <div class="flex justify-between"><dt class="text-gray-500">Check-in</dt><dd>{{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}</dd></div>
                        <div class="flex justify-between"><dt class="text-gray-500">Check-out</dt><dd>{{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}</dd></div>
                        <div class="flex justify-between"><dt class="text-gray-500">Malam</dt><dd>{{ $booking->nights }}</dd></div>
                        <div class="flex justify-between"><dt class="text-gray-500">Tamu</dt><dd>{{ $booking->guests }}</dd></div>
                    </dl>

                    <div class="border-t border-gray-200 mt-4 pt-4 flex justify-between items-end">
                        <span class="text-sm text-gray-500">Total</span>
                        <span class="text-xl font-bold text-[#b8935a]">{{ $rp($booking->total_price) }}</span>
                    </div>

                    @if ($booking->expires_at && $status === 'pending')
                        <p class="text-xs text-gray-500 mt-4">Bayar sebelum
                            <span class="font-semibold" id="countdown" data-until="{{ \Carbon\Carbon::parse($booking->expires_at)->toIso8601String() }}"></span>
                        </p>
                    @endif
                </div>
            </div>
        </aside>
    </div>
</div>

<script>
(function () {
    function copy(text, btn) {
        const done = () => { const t = btn.textContent; btn.textContent = 'Tersalin ✓'; setTimeout(() => btn.textContent = t, 1600); };
        if (navigator.clipboard) navigator.clipboard.writeText(text).then(done);
        else { const i = document.createElement('input'); i.value = text; document.body.append(i); i.select(); document.execCommand('copy'); i.remove(); done(); }
    }
    document.querySelectorAll('[data-copy]').forEach(b => b.addEventListener('click', () =>
        copy(document.querySelector(b.dataset.copy).textContent.trim(), b)));
    document.querySelectorAll('[data-copy-raw]').forEach(b => b.addEventListener('click', () =>
        copy(document.querySelector(b.dataset.copyRaw).dataset.raw, b)));

    const el = document.getElementById('countdown');
    if (el) {
        const until = new Date(el.dataset.until).getTime();
        const tick = () => {
            const left = until - Date.now();
            if (left <= 0) { el.textContent = 'waktu habis'; return; }
            const h = Math.floor(left / 3600000), m = Math.floor(left % 3600000 / 60000), s = Math.floor(left % 60000 / 1000);
            el.textContent = h + ' jam ' + m + ' menit ' + s + ' detik lagi';
            setTimeout(tick, 1000);
        };
        tick();
    }
})();
</script>
@endsection