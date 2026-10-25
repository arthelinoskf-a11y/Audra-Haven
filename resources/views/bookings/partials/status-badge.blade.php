@php
    $badge = [
        'pending'    => 'bg-yellow-100 text-yellow-700',
        'paid'       => 'bg-blue-100 text-blue-700',
        'dp_paid'    => 'bg-blue-100 text-blue-700',
        'confirmed'  => 'bg-indigo-100 text-indigo-700',
        'checked_in' => 'bg-green-100 text-green-700',
        'seated'     => 'bg-green-100 text-green-700',
        'completed'  => 'bg-gray-200 text-gray-700',
        'cancelled'  => 'bg-red-100 text-red-700',
        'expired'    => 'bg-gray-200 text-gray-500',
        'no_show'    => 'bg-red-100 text-red-700',
    ][$status] ?? 'bg-gray-100 text-gray-600';

    $label = [
        'pending'    => 'Menunggu',
        'paid'       => 'Dibayar',
        'dp_paid'    => 'DP Dibayar',
        'confirmed'  => 'Dikonfirmasi',
        'checked_in' => 'Check-in',
        'seated'     => 'Duduk',
        'completed'  => 'Selesai',
        'cancelled'  => 'Batal',
        'expired'    => 'Kedaluwarsa',
        'no_show'    => 'Tidak Hadir',
    ][$status] ?? $status;
@endphp
<span class="px-2 py-1 rounded text-xs font-medium {{ $badge }}">{{ $label }}</span>