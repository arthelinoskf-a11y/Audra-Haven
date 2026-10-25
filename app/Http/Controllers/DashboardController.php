<?php

namespace App\Http\Controllers;

use App\Models\FacilityBooking;
use App\Models\HallBooking;
use App\Models\Order;
use App\Models\Room;
use App\Models\RoomBooking;
use App\Models\TableReservation;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $range = (int) $request->query('range', 30);
        if (!in_array($range, [7, 30, 90, 365], true)) {
            $range = 30;
        }

        $from     = now()->subDays($range - 1)->startOfDay();
        $prevFrom = $from->copy()->subDays($range);
        $monthly  = $range > 90;

        // ---------- Pendapatan (pembayaran berstatus success) ----------
        $fmt  = $monthly ? '%Y-%m' : '%Y-%m-%d';
        $rows = DB::table('payments')
            ->where('status', 'success')
            ->whereRaw('COALESCE(paid_at, created_at) >= ?', [$from])
            ->selectRaw("DATE_FORMAT(COALESCE(paid_at, created_at), '{$fmt}') as d, SUM(amount) as total")
            ->groupBy('d')->pluck('total', 'd');

        $revLabels = [];
        $revValues = [];
        if ($monthly) {
            foreach (CarbonPeriod::create($from->copy()->startOfMonth(), '1 month', now()->startOfMonth()) as $d) {
                $revLabels[] = $d->copy()->locale('id')->translatedFormat('M Y');
                $revValues[] = (float) ($rows[$d->format('Y-m')] ?? 0);
            }
        } else {
            foreach (CarbonPeriod::create($from, '1 day', now()->startOfDay()) as $d) {
                $revLabels[] = $d->copy()->locale('id')->translatedFormat('d M');
                $revValues[] = (float) ($rows[$d->format('Y-m-d')] ?? 0);
            }
        }

        $revenue     = array_sum($revValues);
        $prevRevenue = (float) DB::table('payments')->where('status', 'success')
            ->whereRaw('COALESCE(paid_at, created_at) >= ? AND COALESCE(paid_at, created_at) < ?', [$prevFrom, $from])
            ->sum('amount');
        $revDelta = $prevRevenue > 0 ? round((($revenue - $prevRevenue) / $prevRevenue) * 100) : null;

        // ---------- Pesanan per kategori & per status ----------
        $categoryTables = [
            'Kamar'     => 'room_bookings',
            'Fasilitas' => 'facility_bookings',
            'Meja'      => 'table_reservations',
            'Makanan'   => 'orders',
            'Gedung'    => 'hall_bookings',
        ];
        $categories = [];
        foreach ($categoryTables as $label => $table) {
            $categories[$label] = DB::table($table)->where('created_at', '>=', $from)->count();
        }

        $statusGroups = [
            'Menunggu'     => ['pending'],
            'Dibayar'      => ['paid', 'dp_paid'],
            'Dikonfirmasi' => ['confirmed'],
            'Check-in'     => ['checked_in', 'seated'],
            'Selesai'      => ['completed'],
            'Batal'        => ['cancelled', 'expired', 'no_show'],
        ];
        $statusCounts = array_fill_keys(array_keys($statusGroups), 0);
        foreach ($categoryTables as $table) {
            $perStatus = DB::table($table)->where('created_at', '>=', $from)
                ->selectRaw('status, COUNT(*) as n')->groupBy('status')->pluck('n', 'status');
            foreach ($statusGroups as $label => $members) {
                foreach ($members as $s) {
                    $statusCounts[$label] += (int) ($perStatus[$s] ?? 0);
                }
            }
        }

        // ---------- Metode pembayaran ----------
        if (Schema::hasTable('payment_methods') && Schema::hasColumn('payments', 'payment_method_id')) {
            $methodRows = DB::table('payments as p')
                ->leftJoin('payment_methods as pm', 'pm.id', '=', 'p.payment_method_id')
                ->whereIn('p.status', ['pending', 'success'])
                ->where('p.created_at', '>=', $from)
                ->selectRaw("COALESCE(pm.name, CASE p.method WHEN 'midtrans' THEN 'Midtrans' WHEN 'transfer' THEN 'Transfer' ELSE 'Tunai' END) as label, COUNT(*) as n")
                ->groupBy('label')->orderByDesc('n')->get();
        } else {
            $methodRows = DB::table('payments')->whereIn('status', ['pending', 'success'])
                ->where('created_at', '>=', $from)
                ->selectRaw("CASE method WHEN 'midtrans' THEN 'Midtrans' WHEN 'transfer' THEN 'Transfer' ELSE 'Tunai' END as label, COUNT(*) as n")
                ->groupBy('label')->get();
        }

        // ---------- Kamar ----------
        $roomStatus = Room::selectRaw('status, COUNT(*) as n')->groupBy('status')->pluck('n', 'status');
        $totalRooms = (int) $roomStatus->sum();
        $occupied   = (int) ($roomStatus['occupied'] ?? 0);

        // ---------- Pembayaran menunggu ----------
        $pendingProof = DB::table('payments')->where('status', 'pending')->whereNotNull('proof_file')->count();
        $pendingNone  = DB::table('payments')->where('status', 'pending')->whereNull('proof_file')->count();

        $charts = [
            'revenue'  => ['labels' => $revLabels, 'values' => $revValues],
            'category' => ['labels' => array_keys($categories), 'values' => array_values($categories)],
            'status'   => ['labels' => array_keys($statusCounts), 'values' => array_values($statusCounts)],
            'method'   => ['labels' => $methodRows->pluck('label')->all(), 'values' => $methodRows->pluck('n')->map(fn ($n) => (int) $n)->all()],
            'rooms'    => [
                'labels' => ['Tersedia', 'Terisi', 'Dibersihkan', 'Perawatan'],
                'values' => [
                    (int) ($roomStatus['available'] ?? 0),
                    $occupied,
                    (int) ($roomStatus['cleaning'] ?? 0),
                    (int) ($roomStatus['maintenance'] ?? 0),
                ],
            ],
            'monthly' => $monthly,
        ];

        return view('dashboard', [
            'range'         => $range,
            'revenue'       => $revenue,
            'revDelta'      => $revDelta,
            'totalOrders'   => array_sum($categories),
            'ordersToday'   => RoomBooking::whereDate('created_at', today())->count()
                             + FacilityBooking::whereDate('created_at', today())->count()
                             + HallBooking::whereDate('created_at', today())->count()
                             + TableReservation::whereDate('created_at', today())->count()
                             + Order::whereDate('created_at', today())->count(),
            'totalRooms'    => $totalRooms,
            'occupied'      => $occupied,
            'available'     => (int) ($roomStatus['available'] ?? 0),
            'totalUsers'    => User::count(),
            'pendingProof'  => $pendingProof,
            'pendingNone'   => $pendingNone,
            'charts'        => $charts,
            'recent'        => RoomBooking::with(['user', 'room.roomType'])->latest()->take(6)->get(),
        ]);
    }
}