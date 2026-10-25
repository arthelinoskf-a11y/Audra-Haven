<table class="w-full text-sm">
    <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
        <tr>
            <th class="px-4 py-3 text-left">Kode</th>
            <th class="px-4 py-3 text-left">Pemesan</th>
            <th class="px-4 py-3 text-left">Acara</th>
            <th class="px-4 py-3 text-left">Gedung</th>
            <th class="px-4 py-3 text-left">Tanggal</th>
            <th class="px-4 py-3 text-left">Total</th>
            <th class="px-4 py-3 text-left">Status</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-100">
        @forelse ($data as $b)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-mono text-xs">{{ $b->booking_code }}</td>
                <td class="px-4 py-3">{{ $b->user->full_name ?? '-' }}</td>
                <td class="px-4 py-3">{{ $b->event_name }}</td>
                <td class="px-4 py-3">{{ $b->hall->name ?? '-' }}</td>
                <td class="px-4 py-3">{{ $b->event_date?->format('d M Y') }} <span class="text-gray-400 text-xs">({{ $b->session }})</span></td>
                <td class="px-4 py-3">Rp {{ number_format($b->total_price, 0, ',', '.') }}</td>
                <td class="px-4 py-3">@include('bookings.partials.status-badge', ['status' => $b->status])</td>
            </tr>
        @empty
            <tr><td colspan="7" class="px-4 py-6 text-center text-gray-500">Belum ada pesanan gedung.</td></tr>
        @endforelse
    </tbody>
</table>