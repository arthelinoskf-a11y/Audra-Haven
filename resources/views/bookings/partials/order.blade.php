<table class="w-full text-sm">
    <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
        <tr>
            <th class="px-4 py-3 text-left">Kode</th>
            <th class="px-4 py-3 text-left">Tamu</th>
            <th class="px-4 py-3 text-left">Tipe</th>
            <th class="px-4 py-3 text-left">Item</th>
            <th class="px-4 py-3 text-left">Total</th>
            <th class="px-4 py-3 text-left">Status</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-100">
        @forelse ($data as $b)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-mono text-xs">{{ $b->order_code }}</td>
                <td class="px-4 py-3">{{ $b->user->full_name ?? '-' }}</td>
                <td class="px-4 py-3 capitalize">{{ $b->order_type }}</td>
                <td class="px-4 py-3">{{ $b->items->count() }} item</td>
                <td class="px-4 py-3">Rp {{ number_format($b->total_price, 0, ',', '.') }}</td>
                <td class="px-4 py-3">@include('bookings.partials.status-badge', ['status' => $b->status])</td>
            </tr>
        @empty
            <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">Belum ada pesanan makanan.</td></tr>
        @endforelse
    </tbody>
</table>