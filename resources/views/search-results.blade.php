<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pencarian - Audra Haven</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f9f9f9; }
        h1, h2, h3 { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body>

    <!-- Navbar Sederhana -->
    <nav class="bg-white shadow-sm py-4">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-gray-800 tracking-widest font-serif">AUDRA HAVEN</a>
            <a href="/" class="text-sm font-semibold text-[#b8935a] hover:underline">&larr; Kembali ke Beranda</a>
        </div>
    </nav>

    <!-- Konten -->
    <div class="max-w-6xl mx-auto px-6 py-12">
        <div class="bg-white p-6 rounded-lg shadow-sm mb-8 border-l-4 border-[#b8935a]">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Hasil Pencarian Kamar</h1>
            <p class="text-gray-600 text-sm">
                Menampilkan kamar yang tersedia untuk:
                <br>
                <span class="font-semibold">{{ \Carbon\Carbon::parse($checkIn)->format('d M Y') }}</span> s/d 
                <span class="font-semibold">{{ \Carbon\Carbon::parse($checkOut)->format('d M Y') }}</span> 
                | <span class="font-semibold">{{ $adults }} Dewasa</span>, 
                <span class="font-semibold">{{ $children }} Anak</span>
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($rooms as $room)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                <img src="{{ $room['image'] }}" alt="{{ $room['name'] }}" class="w-full h-56 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $room['name'] }}</h3>
                    <p class="text-sm text-gray-500 mb-4">Harga mulai dari</p>
                    <div class="text-xl font-bold text-[#b8935a] mb-6">{{ $room['price'] }} <span class="text-sm font-normal text-gray-500">/ malam</span></div>
                    <a href="{{ route('room.detail', $room['slug']) }}" class="block text-center bg-[#b8935a] hover:bg-[#9a7a44] text-white py-2 rounded font-semibold transition">
                        LIHAT DETAIL
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</body>
</html>