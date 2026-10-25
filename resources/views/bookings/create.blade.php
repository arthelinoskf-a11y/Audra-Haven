@extends('layouts.public')

@section('title', 'Pemesanan Kamar - Audra Haven')

@section('content')
@php
    $groupLabels = ['qris' => 'QRIS', 'bank_transfer' => 'Transfer Bank', 'ewallet' => 'E-Wallet', 'cash' => 'Bayar di Hotel'];
    $grouped = $methods->groupBy('type');
    $oldMethod = old('payment_method');
@endphp

<div class="max-w-6xl mx-auto px-6 py-12">
    <div class="mb-8">
        <a href="{{ url('/kamar') }}" class="text-sm text-gray-500 hover:text-[#b8935a]">&larr; Kembali ke daftar kamar</a>
        <h1 class="text-3xl font-bold text-gray-800 mt-2 font-serif">Pesan Kamar</h1>
        <p class="text-gray-500">Pilih tipe kamar, tanggal menginap, dan cara pembayaran.</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 text-red-700 px-5 py-4 text-sm" role="alert">
            <p class="font-semibold mb-1">Periksa kembali isian kamu:</p>
            <ul class="list-disc pl-5 space-y-0.5">
                @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form id="bookingForm" action="{{ route('booking.room.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-5 gap-8">
        @csrf
        <input type="hidden" name="room_slug" id="roomSlug" value="{{ old('room_slug', $room['slug']) }}">

        {{-- ===================== KOLOM KIRI ===================== --}}
        <div class="lg:col-span-3 space-y-8">

            {{-- 1. Kamar + foto --}}
            <section class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
                <div class="relative bg-gray-100 aspect-[16/9]">
                    <img id="mainPhoto" src="" alt="" class="absolute inset-0 w-full h-full object-cover transition-opacity duration-300">
                    <div class="absolute inset-x-0 bottom-0 p-5 bg-gradient-to-t from-black/70 to-transparent text-white">
                        <h2 id="roomName" class="text-2xl font-bold font-serif"></h2>
                        <p id="roomPrice" class="text-sm opacity-90"></p>
                    </div>
                </div>

                <div id="thumbs" class="flex gap-2 px-5 pt-4 overflow-x-auto"></div>

                <div class="p-5">
                    <div class="flex flex-wrap gap-2 text-xs mb-3" id="roomChips"></div>
                    <p id="roomDesc" class="text-gray-600 text-sm mb-3"></p>
                    <div id="roomAmenities" class="flex flex-wrap gap-2"></div>
                </div>

                <div class="border-t border-gray-100 px-5 py-4">
                    <p class="text-sm font-semibold mb-2">Ganti tipe kamar</p>
                    <div id="roomSwitch" class="flex flex-wrap gap-2" role="radiogroup" aria-label="Tipe kamar"></div>
                </div>
            </section>

            {{-- 2. Tanggal & tamu --}}
            <section class="bg-white rounded-xl shadow border border-gray-100 p-6">
                <h3 class="text-lg font-bold font-serif mb-4">Tanggal & Tamu</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                    <div>
                        <label for="checkIn" class="block text-sm font-semibold mb-2">Check-in</label>
                        <input type="date" id="checkIn" name="check_in" value="{{ old('check_in', $checkIn) }}"
                               class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#b8935a]" required>
                    </div>
                    <div>
                        <label for="checkOut" class="block text-sm font-semibold mb-2">Check-out</label>
                        <input type="date" id="checkOut" name="check_out" value="{{ old('check_out', $checkOut) }}"
                               class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#b8935a]" required>
                    </div>
                </div>
                <div class="mb-5">
                    <label for="guests" class="block text-sm font-semibold mb-2">Jumlah Tamu <span id="capNote" class="font-normal text-gray-400"></span></label>
                    <input type="number" id="guests" name="guests" min="1" value="{{ old('guests', $guests) }}"
                           class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#b8935a]" required>
                </div>
                <div>
                    <label for="special" class="block text-sm font-semibold mb-2">Permintaan Khusus (Opsional)</label>
                    <textarea id="special" name="special_request" rows="3" maxlength="255"
                              class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#b8935a]">{{ old('special_request') }}</textarea>
                </div>
            </section>

            {{-- 3. Metode pembayaran --}}
            <section class="bg-white rounded-xl shadow border border-gray-100 p-6">
                <h3 class="text-lg font-bold font-serif mb-1">Metode Pembayaran</h3>
                <p class="text-sm text-gray-500 mb-5">Detail rekening atau kode QR tampil setelah pesanan dibuat.</p>

                @if ($methods->isEmpty())
                    <div class="rounded border border-yellow-200 bg-yellow-50 text-yellow-800 text-sm px-4 py-3">
                        Metode pembayaran belum diatur. Jalankan <code>audra_haven_update_pembayaran.sql</code> terlebih dahulu.
                    </div>
                @endif

                @foreach ($groupLabels as $type => $label)
                    @if ($grouped->has($type))
                        <p class="text-xs uppercase tracking-wide text-gray-500 font-semibold mb-2 mt-4 first:mt-0">{{ $label }}</p>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @foreach ($grouped[$type] as $m)
                                <label class="cursor-pointer">
                                    <input type="radio" name="payment_method" value="{{ $m->code }}" class="peer sr-only"
                                           data-name="{{ $m->name }}" data-hint="{{ $m->instructions }}"
                                           {{ $oldMethod === $m->code ? 'checked' : '' }} required>
                                    <div class="h-full border-2 border-gray-200 rounded-lg px-4 py-3 text-sm font-semibold text-gray-700 transition
                                                hover:border-[#b8935a]/60 peer-checked:border-[#b8935a] peer-checked:bg-[#faf3e6]
                                                peer-focus-visible:ring-2 peer-focus-visible:ring-[#b8935a] peer-focus-visible:ring-offset-2">
                                        {{ $m->name }}
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    @endif
                @endforeach

                <p id="methodHint" class="text-sm text-gray-500 mt-4 min-h-[1.25rem]" aria-live="polite"></p>
            </section>
        </div>

        {{-- ===================== RINGKASAN ===================== --}}
        <aside class="lg:col-span-2">
            <div class="lg:sticky lg:top-28 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="flex gap-4 p-5 border-b border-gray-100">
                    <img id="sumPhoto" src="" alt="" class="w-24 h-20 rounded-lg object-cover bg-gray-100 flex-none">
                    <div class="min-w-0">
                        <p class="text-xs uppercase tracking-wide text-gray-500">Ringkasan pesanan</p>
                        <p id="sumName" class="font-bold font-serif text-lg leading-tight"></p>
                        <p id="sumGuests" class="text-sm text-gray-500"></p>
                    </div>
                </div>

                <dl class="p-5 space-y-3 text-sm">
                    <div class="flex justify-between"><dt class="text-gray-500">Check-in</dt><dd id="sumIn" class="font-medium">-</dd></div>
                    <div class="flex justify-between"><dt class="text-gray-500">Check-out</dt><dd id="sumOut" class="font-medium">-</dd></div>
                    <div class="flex justify-between"><dt class="text-gray-500">Lama menginap</dt><dd id="sumNights" class="font-medium">-</dd></div>
                    <div class="flex justify-between"><dt class="text-gray-500" id="sumCalcLabel">Harga kamar</dt><dd id="sumCalc" class="font-medium">-</dd></div>
                    <div class="flex justify-between"><dt class="text-gray-500">Pembayaran</dt><dd id="sumMethod" class="font-medium">Belum dipilih</dd></div>
                </dl>

                <div class="px-5 pb-5">
                    <div class="border-t border-gray-200 pt-4 flex justify-between items-end mb-4">
                        <span class="text-sm text-gray-500">Total</span>
                        <span id="sumTotal" class="text-2xl font-bold text-[#b8935a]">Rp 0</span>
                    </div>
                    <button type="submit" id="submitBtn"
                            class="w-full bg-[#b8935a] hover:bg-[#9a7a44] disabled:opacity-60 text-white font-bold py-3 rounded transition">
                        BUAT PESANAN
                    </button>
                    <p class="text-xs text-gray-400 text-center mt-3">Pesanan berlaku 24 jam menunggu pembayaran.</p>
                </div>
            </div>
        </aside>
    </form>
</div>

<script>
(function () {
    const types = @json($roomTypes);
    const bySlug = Object.fromEntries(types.map(t => [t.slug, t]));
    const $ = id => document.getElementById(id);
    const rupiah = n => 'Rp ' + Math.round(n).toLocaleString('id-ID');
    const pad = n => String(n).padStart(2, '0');
    const ymd = d => d.getFullYear() + '-' + pad(d.getMonth() + 1) + '-' + pad(d.getDate());
    const parse = s => { const p = s.split('-').map(Number); return new Date(p[0], p[1] - 1, p[2]); };
    const fmtDate = s => s ? parse(s).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) : '-';

    let current = bySlug[$('roomSlug').value] || types[0];
    let photoIndex = 0;

    function setPhoto(i) {
        photoIndex = i;
        const img = $('mainPhoto');
        img.style.opacity = 0;
        const next = new Image();
        next.onload = next.onerror = () => { img.src = current.photos[i]; img.alt = current.name; img.style.opacity = 1; };
        next.src = current.photos[i];
        document.querySelectorAll('#thumbs button').forEach((b, idx) => {
            b.classList.toggle('ring-2', idx === i);
            b.setAttribute('aria-current', idx === i ? 'true' : 'false');
        });
    }

    function chip(text) {
        const s = document.createElement('span');
        s.className = 'px-2.5 py-1 rounded-full bg-gray-100 text-gray-600';
        s.textContent = text;
        return s;
    }

    function renderRoom() {
        $('roomSlug').value = current.slug;
        $('roomName').textContent = current.name;
        $('roomPrice').textContent = rupiah(current.price) + ' / malam';
        $('roomDesc').textContent = current.description || '';
        $('sumName').textContent = current.name;
        $('sumPhoto').src = current.photos[0];

        const chips = $('roomChips'); chips.replaceChildren();
        chips.append(chip('Maks. ' + current.capacity + ' tamu'));
        if (current.size) chips.append(chip(current.size + ' m²'));
        if (current.bed) chips.append(chip(current.bed));

        const am = $('roomAmenities'); am.replaceChildren();
        current.amenities.forEach(a => {
            const s = chip(a);
            s.className = 'px-2.5 py-1 rounded-full border border-[#b8935a]/40 text-[#7a5f33] text-xs';
            am.append(s);
        });

        const thumbs = $('thumbs'); thumbs.replaceChildren();
        thumbs.style.display = current.photos.length > 1 ? 'flex' : 'none';
        current.photos.forEach((src, i) => {
            const b = document.createElement('button');
            b.type = 'button';
            b.className = 'flex-none w-20 h-14 rounded overflow-hidden ring-[#b8935a] ring-offset-2';
            b.setAttribute('aria-label', 'Foto ' + (i + 1));
            const im = document.createElement('img');
            im.src = src; im.alt = ''; im.className = 'w-full h-full object-cover';
            b.append(im);
            b.addEventListener('click', () => setPhoto(i));
            thumbs.append(b);
        });

        document.querySelectorAll('#roomSwitch button').forEach(b => {
            const on = b.dataset.slug === current.slug;
            b.setAttribute('aria-checked', on ? 'true' : 'false');
            b.className = 'px-3 py-2 rounded-lg border-2 text-sm font-semibold transition ' +
                (on ? 'border-[#b8935a] bg-[#faf3e6] text-[#7a5f33]' : 'border-gray-200 text-gray-600 hover:border-[#b8935a]/60');
        });

        $('guests').max = current.capacity;
        $('capNote').textContent = '(maks. ' + current.capacity + ')';
        history.replaceState(null, '', '/booking/create/' + current.slug + location.search);
        setPhoto(0);
        updateSummary();
    }

    function buildSwitch() {
        const box = $('roomSwitch');
        types.forEach(t => {
            const b = document.createElement('button');
            b.type = 'button'; b.dataset.slug = t.slug; b.setAttribute('role', 'radio');
            b.textContent = t.name;
            b.addEventListener('click', () => { current = t; renderRoom(); });
            box.append(b);
        });
    }

    function nights() {
        const a = $('checkIn').value, b = $('checkOut').value;
        if (!a || !b) return 0;
        const n = Math.round((parse(b) - parse(a)) / 86400000);
        return n > 0 ? n : 0;
    }

    function updateSummary() {
        const n = nights();
        const g = parseInt($('guests').value, 10) || 0;
        $('sumIn').textContent = fmtDate($('checkIn').value);
        $('sumOut').textContent = fmtDate($('checkOut').value);
        $('sumNights').textContent = n ? n + ' malam' : '-';
        $('sumGuests').textContent = g ? g + ' tamu' : '';
        $('sumCalcLabel').textContent = n ? rupiah(current.price) + ' × ' + n + ' malam' : 'Harga kamar';
        $('sumCalc').textContent = n ? rupiah(current.price * n) : '-';
        $('sumTotal').textContent = rupiah(current.price * n);
        const over = g > current.capacity;
        $('capNote').className = over ? 'font-semibold text-red-600' : 'font-normal text-gray-400';
        $('submitBtn').disabled = !n || over;
    }

    function syncDates() {
        const today = new Date();
        $('checkIn').min = ymd(today);
        if ($('checkIn').value) {
            const min = parse($('checkIn').value); min.setDate(min.getDate() + 1);
            $('checkOut').min = ymd(min);
            if (!$('checkOut').value || parse($('checkOut').value) < min) $('checkOut').value = ymd(min);
        }
        updateSummary();
    }

    function syncMethod() {
        const sel = document.querySelector('input[name="payment_method"]:checked');
        $('sumMethod').textContent = sel ? sel.dataset.name : 'Belum dipilih';
        $('methodHint').textContent = sel ? (sel.dataset.hint || '') : '';
    }

    $('checkIn').addEventListener('change', syncDates);
    $('checkOut').addEventListener('change', updateSummary);
    $('guests').addEventListener('input', updateSummary);
    document.querySelectorAll('input[name="payment_method"]').forEach(r => r.addEventListener('change', syncMethod));
    $('bookingForm').addEventListener('submit', () => { $('submitBtn').disabled = true; $('submitBtn').textContent = 'MEMPROSES…'; });

    buildSwitch();
    renderRoom();
    syncDates();
    syncMethod();
})();
</script>
@endsection