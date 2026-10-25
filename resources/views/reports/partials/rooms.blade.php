<h3 style="font-size:11pt;">Daftar Kamar</h3>
<table class="data">
    <thead>
        <tr>
            <th style="width:5%;">No</th>
            <th>No. Kamar</th>
            <th>Tipe</th>
            <th>Lantai</th>
            <th>Kapasitas</th>
            <th>Harga/Malam</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($rooms as $i => $r)
            <tr>
                <td class="center">{{ $i + 1 }}</td>
                <td class="center">{{ $r->room_number }}</td>
                <td>{{ $r->roomType->name ?? '-' }}</td>
                <td class="center">{{ $r->floor }}</td>
                <td class="center">{{ $r->roomType->capacity ?? '-' }} orang</td>
                <td class="num">Rp {{ number_format($r->roomType->base_price ?? 0, 0, ',', '.') }}</td>
                <td class="center">{{ ucfirst($r->status) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>