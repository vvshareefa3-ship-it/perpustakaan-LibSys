<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Peminjaman - LibSys</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar-custom { background-color: #0f172a; }
        .card-custom { border: none; border-radius: 14px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark navbar-custom px-4 py-3 shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="#">
                <i class="fa-solid fa-chart-line text-warning"></i> LibSys <span class="fs-6 fw-normal text-light opacity-75">| Laporan Peminjaman</span>
            </a>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke dashboard
            </a>
        </div>
    </nav>

    <div class="container py-4">
        <div class="card card-custom p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
                <div>
                    <h4 class="fw-bold text-dark mb-1">
                        <i class="fa-solid fa-file-invoice text-primary me-2"></i> Rekapitulasi Data Peminjaman Buku
                    </h4>
                    <p class="text-muted mb-0">Kelola dan cetak laporan transaksi perpustakaan.</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('petugas.laporan.cetak', request()->all()) }}" target="_blank" class="btn btn-success fw-semibold px-4 rounded-pill shadow-sm">
                        <i class="fa-solid fa-print me-2"></i> Cetak / Print Laporan
                    </a>
                </div>
            </div>

            {{-- Form Filter Status --}}
    <div class="row g-3 align-items-center mt-2">
        <div class="col-auto">
        <label class="fw-semibold text-secondary">Filter Status:</label>
    </div>
    <div class="col-auto">
        <select id="statusFilter" class="form-select rounded-pill px-4" onchange="window.location.href='{{ route('petugas.laporan') }}?status=' + this.value">
            <option value="">Semua Status</option>
            <option value="PENDING" {{ request('status') == 'PENDING' ? 'selected' : '' }}>PENDING</option>
            <option value="DIPINJAM" {{ request('status') == 'DIPINJAM' ? 'selected' : '' }}>DIPINJAM</option>
            <option value="DIKEMBALIKAN" {{ request('status') == 'DIKEMBALIKAN' ? 'selected' : '' }}>DIKEMBALIKAN</option>
        </select>
    </div>
    <div class="col-auto">
        <a href="{{ route('petugas.laporan') }}" class="btn btn-outline-secondary rounded-pill px-3">Reset</a>
    </div>
</div>
        </div>

        <div class="card card-custom p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th class="py-3 px-3 rounded-start">No</th>
                            <th class="py-3">Nama Siswa (NIS)</th>
                            <th class="py-3">Judul Buku</th>
                            <th class="py-3 text-center">Tgl Pinjam</th>
                            <th class="py-3 text-center">Tenggat Waktu</th>
                            <th class="py-3 text-center rounded-end">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporanPeminjaman as $index => $item)
                            <tr>
                                <td class="px-3 fw-semibold">{{ $index + 1 }}</td>
                                <td>
                                    <span class="fw-bold text-dark">{{ $item->siswa->nama_siswa ?? 'Siswa Tidak Ditemukan' }}</span>
                                    <br><small class="text-muted">NIS: {{ $item->id_siswa }}</small>
                                </td>
                                <td class="fw-semibold text-primary">{{ $item->buku->judul_buku ?? 'Buku Tidak Ditemukan' }}</td>
                                <td class="text-center">{{ $item->tanggal_pinjam }}</td>
                                <td class="text-center">{{ $item->tenggat_waktu }}</td>
                                <td class="text-center">
                                    @if($item->status == 'PENDING')
                                        <span class="badge bg-secondary px-3 py-2 rounded-pill">PENDING</span>
                                    @elseif($item->status == 'DIPINJAM')
                                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">DIPINJAM</span>
                                    @else
                                        <span class="badge bg-success px-3 py-2 rounded-pill">DIKEMBALIKAN</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-folder-open fs-2 mb-2 d-block opacity-50"></i>
                                    Belum ada data laporan transaksi yang tercatat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>