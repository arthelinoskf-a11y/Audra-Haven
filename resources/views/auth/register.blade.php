@extends('layouts.public')

@section('title', 'Daftar Akun - Audra Haven')

@section('content')
@php $fromBooking = str_contains((string) session('url.intended', ''), '/booking/'); @endphp

<div class="max-w-md mx-auto px-6 py-16">
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8">
        <h1 class="text-3xl font-bold font-serif text-gray-800 mb-1">Buat Akun</h1>
        <p class="text-gray-500 text-sm mb-6">
            @if ($fromBooking)
                Daftar dulu untuk melanjutkan pemesanan kamarmu.
            @else
                Daftar untuk memesan kamar, fasilitas, dan layanan Audra Haven.
            @endif
        </p>

        @if ($errors->any())
            <div class="mb-5 rounded-lg border border-red-200 bg-red-50 text-red-700 px-4 py-3 text-sm" role="alert">
                <ul class="list-disc pl-5 space-y-0.5">
                    @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="space-y-4" novalidate>
            @csrf

            <div>
                <label for="full_name" class="block text-sm font-semibold mb-1.5">Nama Lengkap</label>
                <input id="full_name" name="full_name" type="text" value="{{ old('full_name') }}" autocomplete="name" required
                       class="w-full border border-gray-300 rounded px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#b8935a]">
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold mb-1.5">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required
                       class="w-full border border-gray-300 rounded px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#b8935a]">
            </div>

            <div>
                <label for="phone" class="block text-sm font-semibold mb-1.5">No. Telepon / WhatsApp</label>
                <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" autocomplete="tel" inputmode="tel" required
                       class="w-full border border-gray-300 rounded px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#b8935a]">
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold mb-1.5">Password</label>
                <div class="relative">
                    <input id="password" name="password" type="password" minlength="8" autocomplete="new-password" required
                           class="w-full border border-gray-300 rounded px-4 py-2.5 pr-20 focus:outline-none focus:ring-2 focus:ring-[#b8935a]">
                    <button type="button" id="togglePw" class="absolute inset-y-0 right-3 text-xs font-semibold text-[#7a5f33]">Tampilkan</button>
                </div>
                <p class="text-xs text-gray-400 mt-1">Minimal 8 karakter.</p>
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-semibold mb-1.5">Ulangi Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                       class="w-full border border-gray-300 rounded px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#b8935a]">
            </div>

            <button type="submit" class="w-full bg-[#b8935a] hover:bg-[#9a7a44] text-white font-bold py-3 rounded transition">
                DAFTAR & LANJUTKAN
            </button>
        </form>

        <p class="text-sm text-gray-500 text-center mt-6">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-semibold text-[#b8935a] hover:underline">Masuk</a>
        </p>
    </div>
</div>

<script>
    (function () {
        var btn = document.getElementById('togglePw'), pw = document.getElementById('password'), pc = document.getElementById('password_confirmation');
        btn.addEventListener('click', function () {
            var show = pw.type === 'password';
            pw.type = pc.type = show ? 'text' : 'password';
            btn.textContent = show ? 'Sembunyikan' : 'Tampilkan';
        });
    })();
</script>
@endsection