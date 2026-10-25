<table class="w-full text-sm">
    <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
        <tr>
            <th class="px-4 py-3 text-left">Kode</th>
            <th class="px-4 py-3 text-left">Tamu</th>
            <th class="px-4 py-3 text-left">Meja</th>
            <th class="px-4 py-3 text-left">Tanggal</th>
            <th class="px-4 py-3 text-left">Jam</th>
            <th class="px-4 py-3 text-left">Tamu</th>
            <th class="px-4 py-3 text-left">Status</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-100">
        @forelse ($data as $b)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-mono text-xs">{{ $b->booking_code }}</td>
                <td class="px-4 py-3">{{ $b->user->full_name ?? '-' }}</td>
                <td class="px-4 py-3">{{ $b->table->table_number ?? '-' }}</td>
                <td class="px-4 py-3">{{ $b->reservation_date?->format('d M Y') }}</td>
                <td class="px-4 py-3">
                    {{ \Carbon\Carbon::parse($b->start_time)->format('H:i') }} –
                    {{ \Carbon\Carbon::parse($b->end_time)->format('H:i') }}
                </td>
                <td class="px-4 py-3">{{ $b->guests }} orang</td>
                <td class="px-4 py-3">@include('bookings.partials.status-badge', ['status' => $b->status])</td>
            </tr>
        @empty
            <tr><td colspan="7" class="px-4 py-6 text-center text-gray-500">Belum ada reservasi meja.</td></tr>
        @endforelse
    </tbody>
</table>