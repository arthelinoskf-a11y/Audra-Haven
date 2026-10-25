<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $typeLabel }} - Audra Haven</title>
    <style>
        /* ============ PENGATURAN UMUM ============ */
        * { box-sizing: border-box; }
        
        body {
            font-family: 'Georgia', 'Times New Roman', serif;
            font-size: 12pt;
            color: #2d2317;
            margin: 0;
            padding: 0;
            background: #f3f4f6;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 15mm;
            margin: 10mm auto;
            background: #fff;
            box-shadow: 0 2px 8px rgba(61,47,31,0.1);
        }

                /* ============ KOP SURAT RESMI ============ */
        .kop {
            border-bottom: 3px double #3d2f1f;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .kop-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kop-logo-cell {
            width: 80px;                 /* ← Perkecil dari 130px jadi 80px */
            vertical-align: middle;
            text-align: center;
            padding-right: 0;            /* ← Hapus padding kanan */
        }

        .kop-logo {
            width: 100px;                 /* ← Sesuaikan ukuran logo */
            height: auto;
            max-height: 100px;
            object-fit: contain;
            display: inline-block;
        }

        .kop-text-cell {
            vertical-align: middle;
            text-align: center;          /* ← Teks di tengah */
            line-height: 1.4;
            padding-left: 10px;          /* ← Jarak aman dari logo */
            padding-right: 50px;         /* ← Dorong teks sedikit ke kiri agar pas */
        }

        .kop-nama {
            font-size: 16pt;             /* ← Sedikit perkecil font biar tidak kepotong */
            font-weight: bold;
            letter-spacing: 1px;         /* ← Kurangi jarak antar huruf */
            color: #3d2f1f;
            margin: 0 0 6px 0;
            text-transform: uppercase;
        }

        .kop-alamat {
            font-size: 10pt;
            color: #3d2f1f;
            margin-top: 4px;
        }

        /* ============ JUDUL LAPORAN ============ */
        .judul-laporan {
            text-align: center;
            margin: 20px 0 5px;
        }
        .judul-laporan h2 {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            margin: 0;
        }
        .judul-laporan .periode {
            font-size: 10pt;
            margin-top: 4px;
        }

        /* ============ TABEL ============ */
        table.data {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt;
            margin-top: 8px;
        }
        table.data th,
        table.data td {
            border: 1px solid #3d2f1f;
            padding: 5px 6px;
            vertical-align: top;
        }
        table.data th {
            background: #f5efe3;
            text-align: center;
            font-weight: bold;
            font-size: 9.5pt;
        }
        table.data td.num { text-align: right; }
        table.data td.center { text-align: center; }
        table.data tfoot td {
            font-weight: bold;
            background: #faf6ef;
        }

        /* ============ RINGKASAN ============ */
        .ringkasan { margin: 15px 0; }
        .ringkasan table {
            width: 60%;
            border-collapse: collapse;
            font-size: 10pt;
        }
        .ringkasan td {
            padding: 4px 8px;
            border-bottom: 1px solid #e8dfd0;
        }
        .ringkasan td:last-child {
            text-align: right;
            font-weight: bold;
        }

        /* ============ TANDA TANGAN ============ */
        .ttd {
            margin-top: 40px;
            display: flex;
            justify-content: flex-end;
        }
        .ttd .box {
            width: 60mm;
            text-align: center;
            font-size: 10pt;
        }
        .ttd .garis {
            margin-top: 60px;
            border-top: 1px solid #3d2f1f;
            padding-top: 3px;
        }

        /* ============ PENGATURAN CETAK (HAPUS HEADER/FOOTER) ============ */
        @media print {
            @page {
                size: A4;
                margin: 0 !important; /* Memaksa margin 0 agar header/footer browser hilang */
            }
            body { 
                background: #fff; 
                margin: 0 !important;
                padding: 0 !important;
            }
            .page {
                width: 210mm;
                min-height: 297mm;
                margin: 0 !important; 
                /* Pindahkan margin cetak ke padding halaman */
                padding: 15mm 15mm !important; 
                box-shadow: none !important;
            }
            table.data { page-break-inside: auto; }
            tr { page-break-inside: avoid; }
            thead { display: table-header-group; }
            tfoot { display: table-footer-group; }
        }
    </style>
</head>
<body>

    <div class="page">

        {{-- ============ KOP SURAT RESMI ============ --}}
        <div class="kop">
            <table class="kop-table">
                <tr>
                    <td class="kop-logo-cell">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="kop-logo">
                    </td>
                    <td class="kop-text-cell">
                        <div class="kop-nama">AUDRA HAVEN SUITES & RESIDENCES</div>
                        <div class="kop-alamat">
                            Jl. Contoh Raya No. 123, Semarang, Jawa Tengah 50123<br>
                            Telp: (024) 123-4567 &nbsp;|&nbsp; Email: info@audrahaven.com
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        {{-- ============ JUDUL LAPORAN ============ --}}
        <div class="judul-laporan">
            <h2>{{ $typeLabel }}</h2>
            <div class="periode">
                Periode: {{ \Carbon\Carbon::parse($fromDate)->translatedFormat('d F Y') }}
                s/d {{ \Carbon\Carbon::parse($toDate)->translatedFormat('d F Y') }}
            </div>
        </div>

        {{-- ============ KONTEN LAPORAN ============ --}}
        @if ($type === 'bookings')
            @include('reports.partials.bookings')
        @elseif ($type === 'revenue')
            @include('reports.partials.revenue')
        @elseif ($type === 'rooms')
            @include('reports.partials.rooms')
        @elseif ($type === 'users')
            @include('reports.partials.users')
        @endif

        {{-- ============ TANDA TANGAN ============ --}}
        <div class="ttd">
            <div class="box">
                Semarang, {{ $printedAt->translatedFormat('d F Y') }}<br>
                Manajer,
                <div class="garis">( ................................ )</div>
            </div>
        </div>

    </div>

    {{-- ============ AUTO PRINT ============ --}}
    <script>
        window.addEventListener('load', function () {
            setTimeout(function () { window.print(); }, 400);
        });
    </script>

</body>
</html>