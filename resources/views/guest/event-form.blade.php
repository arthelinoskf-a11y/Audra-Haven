@extends('layouts.public')

@section('title', 'Form Pemesanan Event - Audra Haven')

@section('content')
    <section class="py-20 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto px-6">
            <div class="bg-white rounded-lg shadow-xl overflow-hidden flex flex-col md:flex-row border border-gray-100">
                
                {{-- ==================== SISI KIRI: FOTO DINAMIS ==================== --}}
                @php
                    $images = [
                        'ballroom' => 'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?q=80&w=2098&auto=format&fit=crop',
                        'meeting'  => asset('images/meeting.jpg'),
                        'vip'  => asset('images/vip.jpg'),
                        'outdoor'  => asset('images/svarga.jpg'),
                        'aquapark' => asset('images/pool.jpg'),
                        'gym'      => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=2070&auto=format&fit=crop',
                        'spa'      => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?q=80&w=2070&auto=format&fit=crop',
                        'kids'     => asset('images/kids.jpg'),
                    ];
                    $imageUrl = $images[$id] ?? 'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?q=80&w=2098&auto=format&fit=crop';
                    
                    $venueName = ucwords(str_replace('-', ' ', $id));
                    if($id == 'ballroom') $venueName = 'The Emerald Ballroom';
                    if($id == 'meeting') $venueName = 'Meeting Room';
                    if($id == 'vip') $venueName = 'VIP Room';
                    if($id == 'outdoor') $venueName = 'Svarga Outdoor';
                    if($id == 'aquapark') $venueName = 'The Audra Aqua Park';
                    if($id == 'gym') $venueName = 'Bhuana Fitness Club';
                    if($id == 'spa') $venueName = 'Audra Wellness & Spa';
                    if($id == 'kids') $venueName = 'Klub Anak';
                @endphp

                <div class="md:w-1/2 min-h-[400px]">
                    <img src="{{ $imageUrl }}" alt="{{ $venueName }}" class="w-full h-full object-cover">
                </div>

                {{-- ==================== SISI KANAN: FORM ==================== --}}
                <div class="md:w-1/2 p-8 md:p-10 flex flex-col justify-center">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2 font-serif">Form Pemesanan {{ $venueName }}</h2>
                    <p class="text-gray-500 mb-8">Lengkapi data di bawah ini untuk memesan venue.</p>

                    <form action="{{ route('guest.event.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="{{ $type }}">
                        <input type="hidden" name="id" value="{{ $id }}">

                        <div class="grid grid-cols-1 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-semibold mb-2">Tanggal Acara</label>
                                <input type="date" name="date" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-[#b8935a] outline-none" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-2">Jumlah Tamu (Estimasi)</label>
                                <input type="number" name="guests" min="1" value="50" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-[#b8935a] outline-none" required>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-semibold mb-2">Catatan Tambahan (Opsional)</label>
                            <textarea name="notes" rows="3" class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-[#b8935a] outline-none"></textarea>
                        </div>

                        <div class="flex gap-4">
                            <a href="{{ url()->previous() }}" class="w-1/3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 rounded text-center transition">Batal</a>
                            <button type="submit" class="w-2/3 bg-[#b8935a] hover:bg-[#9a7a44] text-white font-bold py-3 rounded transition">
                                KIRIM PERMINTAAN
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection