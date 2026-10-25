<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\HallController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\RestaurantTableController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;

// =========================================================================
// 1. HALAMAN PUBLIK
// =========================================================================
Route::get('/', function () { return view('welcome'); });
Route::get('/faq', function () { return view('faq'); })->name('faq');
Route::get('/kamar', function () { return view('rooms'); });
Route::get('/weddings', function () { return view('weddings'); });
Route::get('/hotel-facilities', function () { return view('facilities'); });

// RUTE RESTORAN
Route::get('/restaurant', function () { return view('restaurant'); })->name('restaurant');

// RUTE SPECIAL OFFERS
Route::get('/special-offers', function () { return view('special-offers'); })->name('special-offers');

// RUTE UNIVERSAL DETAIL
Route::get('/detail/{type}/{id}', function ($type, $id) {
    $data = [
        'restaurant' => [
            'ruigo' => ['name' => 'RUIGO Lounge', 'price' => 'Mulai dari Rp 50.000', 'desc' => 'Tempat yang sempurna untuk bersantai sambil menikmati kopi premium dan camilan sore.', 'photos' => ['https://images.unsplash.com/photo-1550966871-3ed3cdb5ed0c?q=80&w=2070&auto=format&fit=crop', 'https://images.unsplash.com/photo-1514933651103-005eec06c04b?q=80&w=2070&auto=format&fit=crop']],
            'poolbar' => ['name' => 'Pool Bar', 'price' => 'Mulai dari Rp 35.000', 'desc' => 'Nikmati minuman segar dan hidangan ringan langsung dari tepi kolam renang kami.', 'photos' => ['https://images.unsplash.com/photo-1574096079513-d8259312b785?q=80&w=2070&auto=format&fit=crop', 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?q=80&w=2070&auto=format&fit=crop']],
            'executive' => ['name' => 'Executive Lounge', 'price' => 'Akses Eksklusif', 'desc' => 'Area eksklusif khusus untuk tamu yang menginap di Suite dan Residence.', 'photos' => ['https://images.unsplash.com/photo-1514933651103-005eec06c04b?q=80&w=2070&auto=format&fit=crop', 'https://images.unsplash.com/photo-1550966871-3ed3cdb5ed0c?q=80&w=2070&auto=format&fit=crop']],
        ],
        'wedding' => [
            'meeting' => ['name' => 'Meeting Room', 'price' => 'Mulai dari Rp 2.500.000', 'desc' => 'Ruang rapat modern dengan peralatan audio-visual canggih.', 'photos' => ['https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=2069&auto=format&fit=crop', 'https://images.unsplash.com/photo-1517457373958-b7bdd4587205?q=80&w=2069&auto=format&fit=crop']],
            'vip' => ['name' => 'VIP Room', 'price' => 'Mulai dari Rp 5.000.000', 'desc' => 'Ruang privat yang elegan untuk pertemuan eksklusif.', 'photos' => ['https://images.unsplash.com/photo-1517457373958-b7bdd4587205?q=80&w=2069&auto=format&fit=crop', 'https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=2069&auto=format&fit=crop']],
            'outdoor' => ['name' => 'Svarga Outdoor', 'price' => 'Mulai dari Rp 7.000.000', 'desc' => 'Area taman terbuka yang indah untuk pesta kebun.', 'photos' => ['https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?q=80&w=2069&auto=format&fit=crop', 'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?q=80&w=2098&auto=format&fit=crop']],
        ],
        'facility' => [
            'gym' => ['name' => 'Bhuana Fitness Club', 'price' => 'Gratis untuk Tamu', 'desc' => 'Peralatan olahraga modern dan lengkap.', 'photos' => ['https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=2070&auto=format&fit=crop', 'https://images.unsplash.com/photo-1574621100236-d25b64cfd647?q=80&w=2070&auto=format&fit=crop']],
            'spa' => ['name' => 'Audra Wellness & Spa', 'price' => 'Mulai dari Rp 250.000', 'desc' => 'Layanan pijat tradisional dan perawatan tubuh.', 'photos' => ['https://images.unsplash.com/photo-1540555700478-4be289fbecef?q=80&w=2070&auto=format&fit=crop', 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=2070&auto=format&fit=crop']],
            'kids' => ['name' => 'Klub Anak', 'price' => 'Gratis untuk Tamu', 'desc' => 'Area bermain yang aman dan menyenangkan.', 'photos' => ['https://images.unsplash.com/photo-1574621100236-d25b64cfd647?q=80&w=2070&auto=format&fit=crop', 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=2070&auto=format&fit=crop']],
        ]
    ];

    if(!isset($data[$type][$id])) return redirect()->back();

    $item = $data[$type][$id];
    return view('detail-universal', compact('item', 'type'));
})->name('detail.universal');


// RUTE DETAIL KAMAR
Route::get('/kamar/{slug}', function ($slug) {
    $rooms = [
        'audra' => ['name' => 'The Audra Room', 'price' => 'Rp 1.250.000', 'desc' => 'Kamar nyaman dengan pemandangan taman, cocok untuk pasangan atau perjalanan bisnis.', 'photos' => [asset('images/h2.jpg'), 'https://images.unsplash.com/photo-1590490360182-c33d57733427?q=80&w=1974&auto=format&fit=crop']],
        'premier' => ['name' => 'Premier Room', 'price' => 'Rp 1.750.000', 'desc' => 'Kamar lebih luas dengan balkon pribadi menghadap kolam renang.', 'photos' => ['https://images.unsplash.com/photo-1590490360182-c33d57733427?q=80&w=1974&auto=format&fit=crop', 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?q=80&w=2070&auto=format&fit=crop']],
        'executive' => ['name' => 'Executive Suite', 'price' => 'Rp 2.500.000', 'desc' => 'Suite mewah dengan ruang tamu terpisah.', 'photos' => [asset('images/Executive.jpg'), 'https://images.unsplash.com/photo-1590490360182-c33d57733427?q=80&w=1974&auto=format&fit=crop']],
        'family' => ['name' => 'Family Suite', 'price' => 'Rp 3.200.000', 'desc' => 'Dua kamar tidur yang saling terhubung.', 'photos' => ['https://images.unsplash.com/photo-1611892440504-42a792e24d32?q=80&w=2070&auto=format&fit=crop', 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?q=80&w=2070&auto=format&fit=crop']],
        'presidential' => ['name' => 'Presidential Residence', 'price' => 'Rp 7.500.000', 'desc' => 'Hunian dua lantai dengan kolam pribadi.', 'photos' => [asset('images/Presidential3.jpg'), 'https://images.unsplash.com/photo-1512918728675-ed5a9ecdebfd?q=80&w=2070&auto=format&fit=crop']],
        'garden' => ['name' => 'Garden View Room', 'price' => 'Rp 1.500.000', 'desc' => 'Kamar dengan akses langsung ke taman hijau.', 'photos' => ['https://images.unsplash.com/photo-1560185007-c5ca9d2c014d?q=80&w=2070&auto=format&fit=crop', 'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?q=80&w=2070&auto=format&fit=crop']],
        'sky' => ['name' => 'Skyline Penthouse', 'price' => 'Rp 5.000.000', 'desc' => 'Kamar di lantai tertinggi dengan pemandangan kota.', 'photos' => ['https://images.unsplash.com/photo-1566665797739-1674de7a421a?q=80&w=2070&auto=format&fit=crop', 'https://images.unsplash.com/photo-1590490360182-c33d57733427?q=80&w=1974&auto=format&fit=crop']],
    ];

    if (!array_key_exists($slug, $rooms)) return redirect('/');
    $room = $rooms[$slug];
    return view('room-detail', compact('room'));
})->name('room.detail');

// RUTE PENCARIAN KAMAR
Route::get('/search-rooms', function (Request $request) {
    $checkIn = $request->query('check_in');
    $checkOut = $request->query('check_out');
    $adults = $request->query('adults');
    $children = $request->query('children');

    $rooms = [
        ['slug' => 'audra', 'name' => 'The Audra Room', 'price' => 'Rp 1.250.000', 'image' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?q=80&w=2070&auto=format&fit=crop'],
        ['slug' => 'premier', 'name' => 'Premier Room', 'price' => 'Rp 1.750.000', 'image' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?q=80&w=1974&auto=format&fit=crop'],
        ['slug' => 'executive', 'name' => 'Executive Suite', 'price' => 'Rp 2.500.000', 'image' => 'images/Executive.jpg'],
        ['slug' => 'family', 'name' => 'Family Suite', 'price' => 'Rp 3.200.000', 'image' => 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?q=80&w=2070&auto=format&fit=crop'],
        ['slug' => 'presidential', 'name' => 'Presidential Residence', 'price' => 'Rp 7.500.000', 'image' => 'images/Presidential3.jpg'],
        ['slug' => 'garden', 'name' => 'Garden View Room', 'price' => 'Rp 1.500.000', 'image' => 'https://images.unsplash.com/photo-1560185007-c5ca9d2c014d?q=80&w=2070&auto=format&fit=crop'],
        ['slug' => 'sky', 'name' => 'Skyline Penthouse', 'price' => 'Rp 5.000.000', 'image' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?q=80&w=2070&auto=format&fit=crop'],
    ];

    return view('search-results', compact('rooms', 'checkIn', 'checkOut', 'adults', 'children'));
})->name('search.rooms');


// =========================================================================
// 2. AUTENTIKASI (LOGIN & REGISTER)
// =========================================================================
Route::middleware('guest')->group(function () {
    Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// =========================================================================
// 3. AREA YANG WAJIB LOGIN (TAMU & STAF)
// =========================================================================
Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout',   [AuthController::class, 'logout'])->name('logout');

    // --- RUTE KHUSUS TAMU ---
    Route::get('/booking/create/{slug}', [BookingController::class, 'createRoomBooking'])->name('booking.room.create');
    Route::post('/booking/store', [BookingController::class, 'storeRoomBooking'])->name('booking.room.store');
    Route::get('/booking/{code}/payment', [BookingController::class, 'showPayment'])->name('booking.room.payment');
    Route::post('/booking/{code}/proof', [BookingController::class, 'uploadProof'])->name('booking.room.proof');
    Route::patch('/payments/{payment}/verify', [BookingController::class, 'verifyPayment'])->name('payments.verify');

    // --- RUTE PESAN MAKANAN TAMU ---
    Route::get('/pesan-makanan', function () {
        $items = \App\Models\MenuItem::where('is_available', 1)->orderBy('category')->get();
        return view('guest.menu', compact('items'));
    })->name('guest.menu');

    Route::post('/pesan-makanan/store', function (Request $request) {
        $request->validate([
            'table_id' => 'required',
            'items' => 'required|array',
            'total' => 'required|numeric'
        ]);

        $orderId = \DB::table('orders')->insertGetId([
            'order_code' => 'ORD-' . strtoupper(\Str::random(6)),
            'user_id' => auth()->id(),
            'order_type' => 'dine_in',
            'total_price' => $request->total,
            'status' => 'pending',
            'created_at' => now(),
        ]);

        foreach ($request->items as $item) {
            \DB::table('order_items')->insert([
                'order_id' => $orderId,
                'menu_item_id' => $item['id'],
                'quantity' => $item['qty'],
                'unit_price' => $item['price'],
                'subtotal' => $item['price'] * $item['qty'],
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Pesanan berhasil dibuat!']);
    })->name('guest.menu.store');

    // --- RUTE FORM PEMESANAN WEDDING / FASILITAS ---
    Route::get('/booking-event/{type}/{id}', function ($type, $id) {
        return view('guest.event-form', compact('type', 'id'));
    })->name('guest.event.form');

    Route::post('/booking-event/store', function (Request $request) {
        $request->validate([
            'type' => 'required',
            'id' => 'required',
            'date' => 'required|date',
            'guests' => 'required|integer|min:1',
        ]);

        \DB::table('orders')->insert([
            'order_code' => 'EVT-' . strtoupper(\Str::random(6)),
            'user_id' => auth()->id(),
            'order_type' => 'dine_in',
            'total_price' => 0,
            'status' => 'pending',
            'created_at' => now(),
        ]);

        return redirect()->route('guest.riwayat')->with('success', 'Permintaan pemesanan event berhasil dikirim.');
    })->name('guest.event.store');

    // --- RUTE RIWAYAT PESANAN TAMU ---
    Route::get('/riwayat-pesanan', function () {
        $roomBookings = \App\Models\RoomBooking::where('user_id', auth()->id())->latest()->get();
        $foodOrders = \DB::table('orders')
            ->where('user_id', auth()->id())
            ->where('order_type', 'dine_in')
            ->latest()
            ->get();
        
        return view('guest.riwayat', compact('roomBookings', 'foodOrders'));
    })->name('guest.riwayat');


    // --- AREA STAF ---
    Route::middleware(['role:admin,manager,receptionist'])->group(function () {
        Route::resource('rooms', RoomController::class);
        Route::resource('facilities', FacilityController::class);
        Route::resource('menu', MenuItemController::class);
        Route::resource('tables', RestaurantTableController::class);
        Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
        Route::get('/admin/payments', [BookingController::class, 'adminPayments'])->name('admin.payments.index');
    });

    // --- AREA ADMIN & MANAGER ---
    Route::middleware(['role:admin,manager'])->group(function () {
        Route::resource('halls', HallController::class);
        Route::get('/reports',       [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/print', [ReportController::class, 'print'])->name('reports.print');
    });

    // --- AREA KHUSUS ADMIN ---
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
        Route::get('/users/{user}/password', [UserController::class, 'showPasswordForm'])->name('users.password');
        Route::put('/users/{user}/password', [UserController::class, 'updatePassword'])->name('users.password.update');
    });

});