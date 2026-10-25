<?php

namespace App\Http\Controllers;

use App\Models\RoomBooking;
use App\Models\FacilityBooking;
use App\Models\TableReservation;
use App\Models\Order;
use App\Models\HallBooking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    // =========================================================
    // DAFTAR PESANAN (ADMIN)
    // =========================================================
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'room');

        $data = match ($tab) {
            'facility' => FacilityBooking::with(['user', 'facility'])->latest()->paginate(15, ['*'], 'page'),
            'table'    => TableReservation::with(['user', 'table'])->latest()->paginate(15, ['*'], 'page'),
            'order'    => Order::with(['user', 'items'])->latest()->paginate(15, ['*'], 'page'),
            'hall'     => HallBooking::with(['user', 'hall'])->latest()->paginate(15, ['*'], 'page'),
            default    => RoomBooking::with(['user', 'room.roomType'])->latest()->paginate(15, ['*'], 'page'),
        };

        $stats = [
            'room'     => RoomBooking::count(),
            'facility' => FacilityBooking::count(),
            'table'    => TableReservation::count(),
            'order'    => Order::count(),
            'hall'     => HallBooking::count(),
        ];

        // Pembayaran terakhir untuk tiap pesanan kamar di halaman ini
        $payments = collect();
        if ($tab === 'room' && Schema::hasColumn('payments', 'payment_method_id')) {
            $payments = DB::table('payments as p')
                ->leftJoin('payment_methods as pm', 'pm.id', '=', 'p.payment_method_id')
                ->where('p.booking_type', 'room')
                ->whereIn('p.booking_id', $data->pluck('id'))
                ->orderBy('p.id')
                ->select('p.*', 'pm.name as method_name')
                ->get()->keyBy('booking_id');
        }

        return view('bookings.index', compact('tab', 'data', 'stats', 'payments'));
    }

    // =========================================================
    // FORM PEMESANAN KAMAR
    // =========================================================
    public function createRoomBooking(Request $request, string $slug)
    {
        // Slug pendek dari halaman publik (/kamar/audra) dipetakan ke slug database
        $alias = [
            'audra' => 'audra-room', // <-- TAMBAHAN UNTUK KAMAR AUDRA
            'deluxe' => 'deluxe-room', 
            'premier' => 'premier-room', 
            'executive' => 'executive-suite',
            'family' => 'family-suite', 
            'presidential' => 'presidential-residence',
        ];
        $slug = $alias[$slug] ?? $slug;

        $roomTypes = $this->roomTypesForForm();
        $selected  = $roomTypes->firstWhere('slug', $slug);

        if (!$selected) {
            return redirect('/')->with('error', 'Tipe kamar tidak ditemukan.');
        }

        return view('bookings.create', [
            'room'      => $selected,
            'roomTypes' => $roomTypes->values(),
            'methods'   => $this->paymentMethods(),
            'checkIn'   => $request->query('check_in'),
            'checkOut'  => $request->query('check_out'),
            'guests'    => max(1, (int) $request->query('adults', 1) + (int) $request->query('children', 0)),
        ]);
    }

    // =========================================================
    // SIMPAN PESANAN KAMAR + BUAT PEMBAYARAN
    // =========================================================
    public function storeRoomBooking(Request $request)
    {
        $types = DB::table('room_types')->where('is_active', 1)->get()->keyBy('slug');

        $data = $request->validate([
            'room_slug'       => ['required', Rule::in($types->keys()->all())],
            'check_in'        => 'required|date|after_or_equal:today',
            'check_out'       => 'required|date|after:check_in',
            'guests'          => 'required|integer|min:1|max:20',
            'special_request' => 'nullable|string|max:255',
            'payment_method'  => ['required', Rule::exists('payment_methods', 'code')->where('is_active', 1)],
        ], [
            'check_in.after_or_equal' => 'Tanggal check-in tidak boleh sebelum hari ini.',
            'check_out.after'         => 'Tanggal check-out harus setelah check-in.',
            'payment_method.required' => 'Pilih metode pembayaran.',
        ]);

        $type = $types[$data['room_slug']];

        if ((int) $data['guests'] > (int) $type->capacity) {
            return back()->withInput()->withErrors(['guests' => "Kapasitas {$type->name} maksimal {$type->capacity} tamu."]);
        }

        $method = DB::table('payment_methods')->where('code', $data['payment_method'])->first();
        $in     = Carbon::parse($data['check_in'])->startOfDay();
        $out    = Carbon::parse($data['check_out'])->startOfDay();
        $nights = max(1, (int) abs($in->diffInDays($out)));

        $code = null;

        try {
            DB::transaction(function () use ($data, $type, $method, $in, $out, $nights, &$code) {
                // Cari kamar yang kosong pada rentang tanggal tersebut
                $roomId = DB::table('rooms as r')
                    ->where('r.room_type_id', $type->id)
                    ->where('r.status', '!=', 'maintenance')
                    ->whereNotExists(function ($q) use ($in, $out) {
                        $q->select(DB::raw(1))->from('room_bookings as b')
                            ->whereColumn('b.room_id', 'r.id')
                            ->whereNotIn('b.status', ['cancelled', 'expired', 'completed'])
                            ->where('b.check_in', '<', $out->toDateString())
                            ->where('b.check_out', '>', $in->toDateString());
                    })
                    ->orderBy('r.room_number')
                    ->lockForUpdate()
                    ->value('r.id');

                if (!$roomId) {
                    throw new \RuntimeException('NO_ROOM');
                }

                $price = (float) $type->base_price;
                $total = $price * $nights;
                $code  = 'RB-' . now()->format('ymd') . '-' . strtoupper(Str::random(5));

                $bookingId = DB::table('room_bookings')->insertGetId([
                    'booking_code'    => $code,
                    'user_id'         => auth()->id(),
                    'room_id'         => $roomId,
                    'check_in'        => $in->toDateString(),
                    'check_out'       => $out->toDateString(),
                    'nights'          => $nights,
                    'guests'          => $data['guests'],
                    'subtotal'        => $total,
                    'discount_amount' => 0,
                    'total_price'     => $total,
                    'status'          => 'pending',
                    'special_request' => $data['special_request'] ?? null,
                    'expires_at'      => now()->addHours(24),
                ]);

                for ($i = 0; $i < $nights; $i++) {
                    DB::table('room_booking_nights')->insert([
                        'room_booking_id' => $bookingId,
                        'stay_date'       => $in->copy()->addDays($i)->toDateString(),
                        'base_price'      => $price,
                        'markup_percent'  => 0,
                        'price'           => $price,
                        'rule_name'       => null,
                    ]);
                }

                DB::table('payments')->insert([
                    'payment_code'      => 'PAY-' . now()->format('ymd') . '-' . strtoupper(Str::random(6)),
                    'user_id'           => auth()->id(),
                    'booking_type'      => 'room',
                    'booking_id'        => $bookingId,
                    'payment_type'      => 'full',
                    'amount'            => $total,
                    'method'            => $method->type === 'cash' ? 'cash' : 'transfer',
                    'payment_method_id' => $method->id,
                    'status'            => 'pending',
                ]);
            });
        } catch (\RuntimeException $e) {
            if ($e->getMessage() === 'NO_ROOM') {
                return back()->withInput()->withErrors([
                    'check_in' => "Maaf, {$type->name} sudah penuh pada tanggal tersebut. Coba tanggal atau tipe kamar lain.",
                ]);
            }
            throw $e;
        }

        return redirect()->route('booking.room.payment', $code)
            ->with('success', 'Pesanan dibuat. Selesaikan pembayaran sebelum batas waktu.');
    }

    // =========================================================
    // HALAMAN PEMBAYARAN (QRIS / BANK / E-WALLET / TUNAI)
    // =========================================================
    public function showPayment(string $code)
    {
        $booking = $this->findBookingFor($code);

        $payment = DB::table('payments as p')
            ->leftJoin('payment_methods as pm', 'pm.id', '=', 'p.payment_method_id')
            ->where('p.booking_type', 'room')->where('p.booking_id', $booking->id)
            ->orderByDesc('p.id')
            ->select('p.*', 'pm.name as method_name', 'pm.type as method_type', 'pm.account_name',
                     'pm.account_number', 'pm.qr_image', 'pm.instructions')
            ->first();

        $type   = DB::table('room_types')->where('id', $booking->room_type_id)->first();
        $photos = $this->roomTypesForForm()->firstWhere('slug', $type->slug)['photos'] ?? [];

        return view('bookings.payment', [
            'booking' => $booking,
            'payment' => $payment,
            'type'    => $type,
            'photo'   => $photos[0] ?? null,
        ]);
    }

    public function uploadProof(Request $request, string $code)
    {
        $booking = $this->findBookingFor($code);

        $request->validate([
            'proof'          => 'required|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'reference_note' => 'nullable|string|max:120',
        ], [
            'proof.required' => 'Pilih file bukti pembayaran.',
            'proof.mimes'    => 'Bukti harus berupa JPG, PNG, atau PDF.',
            'proof.max'      => 'Ukuran bukti maksimal 4 MB.',
        ]);

        $path = $request->file('proof')->store('payments/proofs', 'public');

        DB::table('payments')
            ->where('booking_type', 'room')->where('booking_id', $booking->id)
            ->whereIn('status', ['pending', 'failed'])
            ->update([
                'proof_file'     => $path,
                'reference_note' => $request->input('reference_note'),
                'status'         => 'pending',
            ]);

        return back()->with('success', 'Bukti pembayaran terkirim. Tim kami akan memverifikasinya.');
    }

    // =========================================================
    // VERIFIKASI PEMBAYARAN (RESEPSIONIS / MANAJER / ADMIN)
    // =========================================================
    public function verifyPayment(Request $request, $payment)
    {
        abort_unless(in_array(auth()->user()->role_id, [2, 3, 4]), 403);

        $p = DB::table('payments')->where('id', $payment)->first();
        abort_if(!$p, 404);

        $approve = $request->input('action') !== 'reject';

        DB::transaction(function () use ($p, $approve) {
            if ($approve) {
                DB::table('payments')->where('id', $p->id)->update([
                    'status' => 'success', 'paid_at' => now(), 'verified_by' => auth()->id(),
                ]);
                $table = [
                    'room' => 'room_bookings', 'facility' => 'facility_bookings',
                    'hall' => 'hall_bookings', 'order' => 'orders',
                ][$p->booking_type] ?? null;
                if ($table) {
                    DB::table($table)->where('id', $p->booking_id)->where('status', 'pending')->update(['status' => 'paid']);
                }
            } else {
                DB::table('payments')->where('id', $p->id)->update([
                    'status' => 'failed', 'verified_by' => auth()->id(),
                ]);
            }
        });

        return back()->with('success', $approve ? 'Pembayaran diverifikasi.' : 'Pembayaran ditolak.');
    }

    // =========================================================
    // DAFTAR PEMBAYARAN UNTUK ADMIN
    // =========================================================
    public function adminPayments()
    {
        $payments = DB::table('payments as p')
            ->join('room_bookings as rb', 'rb.id', '=', 'p.booking_id')
            ->join('users as u', 'u.id', '=', 'p.user_id')
            ->where('p.booking_type', 'room')
            ->orderByDesc('p.created_at')
            ->select('p.*', 'rb.booking_code', 'u.full_name', 'rb.total_price')
            ->get();

        return view('admin.payments', compact('payments'));
    }

    // =========================================================
    // HELPER
    // =========================================================
    private function findBookingFor(string $code)
    {
        $booking = DB::table('room_bookings as b')
            ->join('rooms as r', 'r.id', '=', 'b.room_id')
            ->where('b.booking_code', $code)
            ->select('b.*', 'r.room_number', 'r.room_type_id')
            ->first();

        abort_if(!$booking, 404);
        abort_unless(
            (int) $booking->user_id === (int) auth()->id() || in_array(auth()->user()->role_id, [2, 3, 4]),
            403
        );

        return $booking;
    }

    private function paymentMethods()
    {
        if (!Schema::hasTable('payment_methods')) {
            return collect();
        }
        return DB::table('payment_methods')->where('is_active', 1)->orderBy('sort_order')->get();
    }

    /** Foto cadangan kalau tabel room_photos belum terisi */
    private function fallbackPhotos(): array
    {
        return [
            'audra'                  => 'images/kamar3.webp',
            'deluxe-room'            => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?q=80&w=1400&auto=format&fit=crop',
            'premier-room'           => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?q=80&w=1400&auto=format&fit=crop',
            'executive-suite'        => asset('images/Executive.jpg'),
            'family-suite'           => 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?q=80&w=1400&auto=format&fit=crop',
            'presidential-residence' => asset('images/Presidential3.jpg'),
        ];
    }

    private function roomTypesForForm()
    {
        $fallback = $this->fallbackPhotos();
        $photos   = DB::table('room_photos')->orderByDesc('is_cover')->orderBy('sort_order')->get()->groupBy('room_type_id');

        return DB::table('room_types')->where('is_active', 1)->orderBy('base_price')->get()
            ->map(function ($t) use ($photos, $fallback) {
                $list = collect($photos[$t->id] ?? [])->map(fn ($p) => asset('storage/' . $p->file_name))->values()->all();
                if (!$list) {
                    $list = [$fallback[$t->slug] ?? asset('images/logo.png')];
                }
                return [
                    'id'          => $t->id,
                    'slug'        => $t->slug,
                    'name'        => $t->name,
                    'price'       => (int) $t->base_price,
                    'capacity'    => (int) $t->capacity,
                    'size'        => $t->size_m2,
                    'bed'         => $t->bed_type,
                    'description' => $t->description,
                    'amenities'   => array_values(array_filter(array_map('trim', explode(',', (string) $t->amenities)))),
                    'photos'      => $list,
                ];
            });
    }
}