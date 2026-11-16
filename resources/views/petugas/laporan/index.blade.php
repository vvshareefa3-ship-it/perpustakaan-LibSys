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
    {{-- Navbar Atas --}}
    <nav class="navbar navbar-dark navbar-custom px-4 py-3 shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="#">
                <i class="fa-solid fa-chart-line text-warning"></i> LibSys <span class="fs-6 fw-normal text-light opacity-75">| Laporan Peminjaman</span>
            </a>
            
            {{-- Tombol Kembali Dinamis Berdasarkan Role --}}
            <div>
                @if(auth()->user()->peran == 'ADMIN')
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm px-3">
                        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Dashboard Admin
                    </a>
                @else
                    <a href="{{ route('petugas.dashboard') }}" class="btn btn-secondary btn-sm px-3">
                        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Dashboard Petugas
                    </a>
                @endif
            </div>
        </div>
    </nav>

    <div class="container py-5">
        
        {{-- Header Judul Laporan --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold text-dark mb-1">Rekapitulasi Data Peminjaman Buku</h1>
                <p class="text-muted mb-0">Kelola dan cetak laporan transaksi perpustakaan.</p>
            </div>
        </div>

        {{-- KARTU STATISTIK REKAPITULASI --}}
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card card-custom p-3 border-start border-primary border-4 shadow-sm bg-white">
                    <span class="text-muted small fw-semibold">Total Seluruh Transaksi</span>
                    <h3 class="fw-bold text-dark mt-1 mb-0">{{ $totalPeminjaman ?? 0 }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-custom p-3 border-start border-warning border-4 shadow-sm bg-white">
                    <span class="text-muted small fw-semibold">Status Pending</span>
                    <h3 class="fw-bold text-warning mt-1 mb-0">{{ $totalPending ?? 0 }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-custom p-3 border-start border-info border-4 shadow-sm bg-white">
                    <span class="text-muted small fw-semibold">Sedang Dipinjam</span>
                    <h3 class="fw-bold text-info mt-1 mb-0">{{ $totalDipinjam ?? 0 }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-custom p-3 border-start border-success border-4 shadow-sm bg-white">
                    <span class="text-muted small fw-semibold">Sudah Dikembalikan</span>
                    <h3 class="fw-bold text-success mt-1 mb-0">{{ $totalKembali ?? 0 }}</h3>
                </div>
            </div>
        </div>

        {{-- Form Filter Status --}}
        <div class="card card-custom p-3 mb-4 shadow-sm bg-white">
            <div class="row g-3 align-items-center">
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

        {{-- Tabel Data Laporan --}}
        <div class="card card-custom p-4 shadow-sm bg-white">
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

                                    @if(session('error'))
                                    <div class="bg-red-100 border-1-4 border-red-600 text-red-800 p-4 mb-4 rounded">
                                        <strong>Peringatan Validasi:</strong> {{
                                            session('error') }}
                                    </div>
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