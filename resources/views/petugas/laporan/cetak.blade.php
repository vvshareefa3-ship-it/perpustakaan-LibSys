<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Peminjaman - LibSys</title>
    <style>
        @page {
            size: A4;
            margin: 15mm; 
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 20px;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header-table td {
            vertical-align: middle;
        }
        .logo-left {
            text-align: left;
            width: 15%;
        }
        .logo-right {
            text-align: right;
            width: 15%;
        }
        .title-center {
            text-align: center;
            width: 70%;
        }
        .title-center h2, .title-center h3 {
            margin: 2px 0;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table.data-table th, table.data-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        table.data-table th {
            background-color: #f4f4f4;
        }
        .signature-section {
            margin-top: 50px;
            width: 100%;
            page-break-inside: avoid;
        }
        .signature-box {
            float: right;
            text-align: center;
            width: 250px;
        }
        .signature-space {
            height: 70px;
        }
    </style>
</head>
<body onload="window.print()">

    <!-- HEADER DENGAN DUA LOGO -->
    <table class="header-table">
        <tr>
            <td class="logo-left">
                <!-- Ganti dengan path logo sekolah Anda -->
                <img src="{{ asset('Images/Logo_BBC.jpeg') }}" alt="Logo Sekolah" width="70" height="70" style="object-fit: contain;">
            </td>
            <td class="title-center">
                <h2>PERPUSTAKAAN DIGITAL LIBSYS</h2>
                <h3>Laporan Rekapitulasi Peminjaman Buku</h3>
                <p style="margin: 5px 0 0 0; font-size: 11px; color: #666;">Dicetak pada: {{ date('d-m-Y H:i') }}</p>
            </td>
            <td class="logo-right">
                <!-- Ganti dengan path logo LibSys Anda -->
                <img src="{{ asset('Images/Logo_LibSys.png') }}" alt="Logo LibSys" width="70" height="70" style="object-fit: contain;">
            </td>
        </tr>
    </table>

    <!-- TABEL DATA PEMINJAMAN -->
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>NIS</th>
                <th>Judul Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Tenggat Waktu</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($peminjaman ?? [] as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->siswa->nama_siswa ?? '-' }}</td>
                    <td>{{ $item->id_siswa ?? '-' }}</td>
                    <td>{{ $item->buku->judul_buku ?? '-' }}</td>
                    <td>{{ $item->tanggal_pinjam ? date('d/m/Y', strtotime($item->tanggal_pinjam)) : '-' }}</td>
                    <td>{{ $item->tenggat_waktu ? date('d/m/Y', strtotime($item->tenggat_waktu)) : '-' }}</td>
                    <td><strong>{{ $item->status }}</strong></td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">Tidak ada data peminjaman.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

<table width="100%" class="text-center" style="margin-top: 410px; font-size: 13px; border-collapse: collapse; page-break-inside: avoid;">
    <tr>
        <td style="width: 33%; vertical-align: top;">
            <p class="mb-1">Mengetahui,</p>
            <p class="fw-bold mb-4">Kepala Sekolah</p>
            <br><br><br>
            <p class="mb-0 fw-bold text-decoration-underline">( Ahmad Fadhla Fauzan,S.Pd.I)</p>
            <p class="mb-0">NUPTK. 1538769670130223</p>
        </td>
        
        <td style="width: 33%; vertical-align: top;">
            <p class="mb-1">Mengetahui,</p>
            <p class="fw-bold mb-4">Kepala Perpustakaan</p>
            <br><br><br>
            <p class="mb-0 fw-bold text-decoration-underline">( Ani Rohaeni )</p>
            <p class="mb-0">NUPTK/NIK. 5241758659230183</p>
        </td>
    </tr>
</table>

</body>
</html>