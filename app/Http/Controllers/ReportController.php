<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomBooking;
use App\Models\FacilityBooking;
use App\Models\TableReservation;
use App\Models\Order;
use App\Models\HallBooking;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    // Halaman daftar laporan
    public function index(Request $request)
{
    // Ringkasan singkat
    $summary = [
        'total_rooms'        => Room::count(),
        'total_users'        => User::count(),
        'total_bookings'     => RoomBooking::count()
                              + FacilityBooking::count()
                              + TableReservation::count()
                              + Order::count()
                              + HallBooking::count(),
        'revenue_this_month' => RoomBooking::whereMonth('created_at', now()->month)
                                ->whereYear('created_at', now()->year)
                                ->sum('total_price'),
    ];

    // Parameter untuk preview
    $type     = $request->get('type', 'bookings');
    $fromDate = $request->get('from', now()->startOfMonth()->format('Y-m-d'));
    $toDate   = $request->get('to', now()->format('Y-m-d'));

    $from = Carbon::parse($fromDate)->startOfDay();
    $to   = Carbon::parse($toDate)->endOfDay();

    // Data untuk preview
    $previewData = $this->buildReportData($type, $from, $to);

    $typeLabel = $this->getTypeLabel($type);

    return view('reports.index', compact(
        'summary', 'type', 'typeLabel',
        'fromDate', 'toDate', 'previewData'
    ));
}

    // Halaman cetak (print preview)
    public function print(Request $request)
    {
        $type     = $request->get('type', 'bookings');
        $fromDate = $request->get('from');
        $toDate   = $request->get('to');

        // Default: awal bulan ini s/d hari ini
        if (!$fromDate) $fromDate = now()->startOfMonth()->format('Y-m-d');
        if (!$toDate)   $toDate   = now()->format('Y-m-d');

        $from = Carbon::parse($fromDate)->startOfDay();
        $to   = Carbon::parse($toDate)->endOfDay();

        $data = $this->buildReportData($type, $from, $to);

        return view('reports.print', array_merge($data, [
            'type'      => $type,
            'typeLabel' => $this->getTypeLabel($type),
            'fromDate'  => $fromDate,
            'toDate'    => $toDate,
            'printedAt' => now(),
        ]));
    }

    // Bangun data laporan sesuai tipe
    private function buildReportData(string $type, Carbon $from, Carbon $to): array
    {
        return match ($type) {
            'bookings'   => $this->reportBookings($from, $to),
            'revenue'    => $this->reportRevenue($from, $to),
            'rooms'      => $this->reportRooms(),
            'users'      => $this->reportUsers(),
            default      => $this->reportBookings($from, $to),
        };
    }

    private function reportBookings(Carbon $from, Carbon $to): array
    {
        $rooms = RoomBooking::with(['user','room.roomType'])
            ->whereBetween('created_at', [$from, $to])
            ->orderBy('created_at')->get();

        $facilities = FacilityBooking::with(['user','facility'])
            ->whereBetween('created_at', [$from, $to])
            ->orderBy('created_at')->get();

        $tables = TableReservation::with(['user','table'])
            ->whereBetween('created_at', [$from, $to])
            ->orderBy('created_at')->get();

        $halls = HallBooking::with(['user','hall'])
            ->whereBetween('created_at', [$from, $to])
            ->orderBy('created_at')->get();

        return [
            'rooms'      => $rooms,
            'facilities' => $facilities,
            'tables'     => $tables,
            'halls'      => $halls,
            'grandTotal' => $rooms->sum('total_price')
                          + $facilities->sum('total_price')
                          + $halls->sum('total_price'),
        ];
    }

    private function reportRevenue(Carbon $from, Carbon $to): array
    {
        $roomRevenue = RoomBooking::whereBetween('created_at', [$from, $to])
            ->sum('total_price');
        $facilityRevenue = FacilityBooking::whereBetween('created_at', [$from, $to])
            ->sum('total_price');
        $hallRevenue = HallBooking::whereBetween('created_at', [$from, $to])
            ->sum('total_price');
        $orderRevenue = Order::whereBetween('created_at', [$from, $to])
            ->sum('total_price');

        return [
            'revenues' => [
                'Kamar'      => $roomRevenue,
                'Fasilitas'  => $facilityRevenue,
                'Gedung'     => $hallRevenue,
                'Restoran'   => $orderRevenue,
            ],
            'grandTotal' => $roomRevenue + $facilityRevenue + $hallRevenue + $orderRevenue,
        ];
    }

    private function reportRooms(): array
    {
        $rooms = Room::with('roomType')->orderBy('room_number')->get();
        return ['rooms' => $rooms];
    }

    private function reportUsers(): array
    {
        $users = User::with('role')->orderBy('full_name')->get();
        return ['users' => $users];
    }

    private function getTypeLabel(string $type): string
    {
        return [
            'bookings' => 'Laporan Pemesanan',
            'revenue'  => 'Laporan Pendapatan',
            'rooms'    => 'Laporan Data Kamar',
            'users'    => 'Laporan Data Pengguna',
        ][$type] ?? 'Laporan';
    }
}