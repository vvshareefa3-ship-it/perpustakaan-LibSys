<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman - LibSys</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card-custom {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
            background: #ffffff;
        }
        .table-custom th {
            background-color: #0f172a;
            color: #ffffff;
            font-weight: 500;
            border: none;
            padding: 12px 16px;
        }
        .table-custom td {
            padding: 14px 16px;
            vertical-align: middle;
        }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark px-4 shadow-sm mb-4">
        <span class="navbar-brand mb-0 h1">
            <i class="fa-solid fa-clock-rotate-left me-2"></i> LibSys | Riwayat Peminjaman
        </span>
        <a href="{{ route('siswa.dashboard') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Dashboard
        </a>
    </nav>

    <div class="container py-3">
        <div class="card card-custom border-0 overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
                    <div>
                        <h4 class="fw-bold mb-1 text-dark">Riwayat Peminjaman Buku</h4>
                        <p class="text-muted small mb-0">
                            Daftar buku yang sedang dipinjam maupun sudah dikembalikan oleh {{ $siswa->nama_siswa ?? ($user->nama_user ?? 'Siswa') }}.
                        </p>
                    </div>
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-semibold">
                        Total: {{ $riwayatPeminjaman->count() }} Transaksi
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 table-custom">
                        <thead>
                            <tr>
                                <th class="ps-4">No</th>
                                <th>Judul Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Batas / Tanggal Kembali</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayatPeminjaman as $index => $item)
                                @php
                                    $statusUpper = strtoupper(trim($item->status ?? ''));
                                @endphp
                                <tr>
                                    <td class="ps-4 fw-semibold text-secondary">{{ $index + 1 }}</td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $item->buku->judul_buku ?? 'Buku Perpustakaan' }}</div>
                                        @if(!empty($item->buku->penulis))
                                            <small class="text-muted">Penulis: {{ $item->buku->penulis }}</small>
                                        @endif
                                    </td>
                                    <td class="text-secondary">
                                        {{ !empty($item->tanggal_pinjam) ? date('d/m/Y', strtotime($item->tanggal_pinjam)) : '-' }}
                                    </td>
                                    <td class="text-secondary">
                                        @if(!empty($item->tanggal_kembali))
                                            {{ date('d/m/Y', strtotime($item->tanggal_kembali)) }}
                                        @elseif(!empty($item->tenggat_waktu))
                                            {{ date('d/m/Y', strtotime($item->tenggat_waktu)) }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($statusUpper == 'DIKEMBALIKAN')
                                            <span class="badge bg-success px-3 py-2 rounded-pill">Dikembalikan</span>
                                        @elseif($statusUpper == 'DIPINJAM')
                                            <span class="badge bg-primary px-3 py-2 rounded-pill">Dipinjam</span>
                                        @elseif($statusUpper == 'PENDING')
                                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Pending</span>
                                        @elseif($statusUpper == 'TERLAMBAT')
                                            <span class="badge bg-danger px-3 py-2 rounded-pill">Terlambat</span>
                                        @else
                                            <span class="badge bg-secondary px-3 py-2 rounded-pill">{{ $item->status ?? '-' }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-book-open-reader fa-2x mb-2 text-secondary opacity-50"></i>
                                        <p class="mb-0">Belum ada riwayat peminjaman buku.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>
</html>