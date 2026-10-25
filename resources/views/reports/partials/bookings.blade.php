{{-- ==================== PEMESANAN KAMAR ==================== --}}
@if ($rooms->count())
    <h3 style="font-size:11pt; margin-top:15px;">A. Pemesanan Kamar</h3>
    <table class="data">
        <thead>
            <tr>
                <th style="width:5%;">No</th>
                <th style="width:18%;">Kode</th>
                <th>Tamu</th>
                <th>Kamar</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rooms as $i => $b)
                <tr>
                    <td class="center">{{ $i + 1 }}</td>
                    <td>{{ $b->booking_code }}</td>
                    <td>{{ $b->user->full_name ?? '-' }}</td>
                    <td>{{ $b->room->room_number ?? '-' }}</td>
                    <td class="center">{{ $b->check_in?->format('d/m/Y') }}</td>
                    <td class="center">{{ $b->check_out?->format('d/m/Y') }}</td>
                    <td class="num">Rp {{ number_format($b->total_price, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" style="text-align:right;">Subtotal Kamar</td>
                <td class="num">Rp {{ number_format($rooms->sum('total_price'), 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
@endif

{{-- ==================== PEMESANAN FASILITAS ==================== --}}
@if ($facilities->count())
    <h3 style="font-size:11pt; margin-top:15px;">B. Pemesanan Fasilitas</h3>
    <table class="data">
        <thead>
            <tr>
                <th style="width:5%;">No</th>
                <th>Kode</th>
                <th>Tamu</th>
                <th>Fasilitas</th>
                <th>Tanggal</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($facilities as $i => $b)
                <tr>
                    <td class="center">{{ $i + 1 }}</td>
                    <td>{{ $b->booking_code }}</td>
                    <td>{{ $b->user->full_name ?? '-' }}</td>
                    <td>{{ $b->facility->name ?? '-' }}</td>
                    <td class="center">{{ $b->booking_date?->format('d/m/Y') }}</td>
                    <td class="num">Rp {{ number_format($b->total_price, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

{{-- ==================== RESERVASI MEJA ==================== --}}
@if ($tables->count())
    <h3 style="font-size:11pt; margin-top:15px;">C. Reservasi Meja Restoran</h3>
    <table class="data">
        <thead>
            <tr>
                <th style="width:5%;">No</th>
                <th>Kode</th>
                <th>Tamu</th>
                <th>Meja</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Orang</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tables as $i => $b)
                <tr>
                    <td class="center">{{ $i + 1 }}</td>
                    <td>{{ $b->booking_code }}</td>
                    <td>{{ $b->user->full_name ?? '-' }}</td>
                    <td class="center">{{ $b->table->table_number ?? '-' }}</td>
                    <td class="center">{{ $b->reservation_date?->format('d/m/Y') }}</td>
                    <td class="center">
                        {{ \Carbon\Carbon::parse($b->start_time)->format('H:i') }} –
                        {{ \Carbon\Carbon::parse($b->end_time)->format('H:i') }}
                    </td>
                    <td class="center">{{ $b->guests }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

{{-- ==================== PEMESANAN GEDUNG ==================== --}}
@if ($halls->count())
    <h3 style="font-size:11pt; margin-top:15px;">D. Pemesanan Gedung</h3>
    <table class="data">
        <thead>
            <tr>
                <th style="width:5%;">No</th>
                <th>Kode</th>
                <th>Pemesan</th>
                <th>Acara</th>
                <th>Gedung</th>
                <th>Tanggal</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($halls as $i => $b)
                <tr>
                    <td class="center">{{ $i + 1 }}</td>
                    <td>{{ $b->booking_code }}</td>
                    <td>{{ $b->user->full_name ?? '-' }}</td>
                    <td>{{ $b->event_name }}</td>
                    <td>{{ $b->hall->name ?? '-' }}</td>
                    <td class="center">{{ $b->event_date?->format('d/m/Y') }}</td>
                    <td class="num">Rp {{ number_format($b->total_price, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

{{-- ==================== RINGKASAN TOTAL ==================== --}}
<div class="ringkasan">
    <h3 style="font-size:11pt;">E. Ringkasan Total</h3>
    <table>
        <tr><td>Subtotal Pemesanan Kamar</td>
            <td>Rp {{ number_format($rooms->sum('total_price'), 0, ',', '.') }}</td></tr>
        <tr><td>Subtotal Pemesanan Fasilitas</td>
            <td>Rp {{ number_format($facilities->sum('total_price'), 0, ',', '.') }}</td></tr>
        <tr><td>Subtotal Pemesanan Gedung</td>
            <td>Rp {{ number_format($halls->sum('total_price'), 0, ',', '.') }}</td></tr>
        <tr style="border-top:2px solid #000;">
            <td><b>GRAND TOTAL</b></td>
            <td><b>Rp {{ number_format($grandTotal, 0, ',', '.') }}</b></td>
        </tr>
    </table>
</div>

@if ($rooms->isEmpty() && $facilities->isEmpty() && $tables->isEmpty() && $halls->isEmpty())
    <p style="text-align:center; padding:40px 0; color:#777; font-style:italic;">
        Tidak ada data pemesanan pada periode ini.
    </p>
@endif