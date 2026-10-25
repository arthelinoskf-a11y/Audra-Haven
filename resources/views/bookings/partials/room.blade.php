<table class="w-full text-sm">
    <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
        <tr>
            <th class="px-4 py-3 text-left">Kode</th>
            <th class="px-4 py-3 text-left">Tamu</th>
            <th class="px-4 py-3 text-left">Kamar</th>
            <th class="px-4 py-3 text-left">Check-in</th>
            <th class="px-4 py-3 text-left">Check-out</th>
            <th class="px-4 py-3 text-left">Total</th>
            <th class="px-4 py-3 text-left">Pembayaran</th>
            <th class="px-4 py-3 text-left">Status</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-100">
        @forelse ($data as $b)
            @php $pay = $payments[$b->id] ?? null; @endphp
            <tr class="hover:bg-gray-50 align-top">
                <td class="px-4 py-3 font-mono text-xs">{{ $b->booking_code }}</td>
                <td class="px-4 py-3">{{ $b->user->full_name ?? '-' }}</td>
                <td class="px-4 py-3">
                    {{ $b->room->room_number ?? '-' }}
                    <span class="text-gray-400 text-xs">({{ $b->room->roomType->name ?? '-' }})</span>
                </td>
                <td class="px-4 py-3">{{ $b->check_in?->format('d M Y') }}</td>
                <td class="px-4 py-3">{{ $b->check_out?->format('d M Y') }}</td>
                <td class="px-4 py-3">Rp {{ number_format($b->total_price, 0, ',', '.') }}</td>
                <td class="px-4 py-3">
                    @if ($pay)
                        <div class="font-medium">{{ $pay->method_name ?? ucfirst($pay->method) }}</div>
                        <div class="text-xs text-gray-500 mb-1">
                            {{ ['pending' => 'Menunggu', 'success' => 'Berhasil', 'failed' => 'Ditolak', 'expired' => 'Kedaluwarsa', 'refunded' => 'Dikembalikan'][$pay->status] ?? $pay->status }}
                        </div>

                        @if ($pay->proof_file)
                            <a href="{{ asset('storage/' . $pay->proof_file) }}" target="_blank" rel="noopener"
                               class="text-xs text-blue-600 underline">Lihat bukti</a>
                        @elseif ($pay->status === 'pending')
                            <span class="text-xs text-gray-400">Belum ada bukti</span>
                        @endif

                        @if ($pay->status === 'pending' && in_array(auth()->user()->role_id, [2, 3, 4]))
                            <form action="{{ route('payments.verify', $pay->id) }}" method="POST" class="flex gap-1 mt-2">
                                @csrf @method('PATCH')
                                <button name="action" value="approve" class="px-2 py-1 rounded text-xs font-semibold bg-green-100 text-green-700 hover:bg-green-200"
                                        onclick="return confirm('Verifikasi pembayaran ini?')">Verifikasi</button>
                                <button name="action" value="reject" class="px-2 py-1 rounded text-xs font-semibold bg-red-100 text-red-700 hover:bg-red-200"
                                        onclick="return confirm('Tolak pembayaran ini?')">Tolak</button>
                            </form>
                        @endif
                    @else
                        <span class="text-gray-400">-</span>
                    @endif
                </td>
                <td class="px-4 py-3">@include('bookings.partials.status-badge', ['status' => $b->status])</td>
            </tr>
        @empty
            <tr><td colspan="8" class="px-4 py-6 text-center text-gray-500">Belum ada pesanan kamar.</td></tr>
        @endforelse
    </tbody>
</table>