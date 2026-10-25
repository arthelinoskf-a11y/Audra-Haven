<h3 style="font-size:11pt;">A. Rincian Pendapatan</h3>
<table class="data">
    <thead>
        <tr>
            <th style="width:8%;">No</th>
            <th>Kategori</th>
            <th style="width:30%;">Jumlah</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($revenues as $kategori => $jumlah)
            <tr>
                <td class="center">{{ $loop->iteration }}</td>
                <td>{{ $kategori }}</td>
                <td class="num">Rp {{ number_format($jumlah, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" style="text-align:right;"><b>GRAND TOTAL</b></td>
            <td class="num"><b>Rp {{ number_format($grandTotal, 0, ',', '.') }}</b></td>
        </tr>
    </tfoot>
</table>