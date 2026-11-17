<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Peminjaman - LibSys</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar-custom { background-color: #0f172a; }
        .card-custom { border: none; border-radius: 14px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); }
        .stat-card { border-radius: 12px; border: none; box-shadow: 0 2px 4px rgba(0,0,0,0.02); transition: transform 0.2s; }
        .stat-card:hover { transform: translateY(-3px); }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark navbar-custom px-4 py-3 shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="#">
                <i class="fa-solid fa-chart-line text-warning"></i> LibSys <span class="fs-6 fw-normal text-light opacity-75">| Laporan Peminjaman</span>
            </a>
            <div class="d-flex gap-2">
                <a href="{{ route('petugas.laporan.cetak') }}" target="_blank" class="btn btn-success rounded-pill px-4">
    <i class="fa-solid fa-print me-1"></i> Cetak / Print Laporan
</a>
                <a href="{{ route('petugas.dashboard') }}" class="btn btn-outline-light rounded-pill px-4">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>
    </nav>

    <div class="container py-4">

        <div class="mb-4">
            <h3 class="fw-bold text-dark mb-1">Rekapitulasi Data Peminjaman Buku</h3>
            <p class="text-muted">Kelola dan pantau laporan transaksi aktif dan riwayat perpustakaan.</p>
        </div>

        <!-- 3 KOTAK STATISTIK (Tanpa Pending) -->
    <div class="row g-4 mb-4">
    <!-- 3 Kotak Statistik Angka -->
    <div class="col-lg-7">
        <div class="row g-3">
            <div class="col-12">
                <div class="card stat-card p-3 border-start border-primary border-4">
                    <div class="text-muted small fw-semibold text-uppercase">Total Seluruh Transaksi</div>
                    <h2 class="fw-bold text-dark mt-2 mb-0">{{ $totalTransaksi ?? 0 }}</h2>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card stat-card p-3 border-start border-warning border-4">
                    <div class="text-muted small fw-semibold text-uppercase">Sedang Dipinjam</div>
                    <h2 class="fw-bold text-dark mt-2 mb-0">{{ $sedangDipinjam ?? 0 }}</h2>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card stat-card p-3 border-start border-success border-4">
                    <div class="text-muted small fw-semibold text-uppercase">Sudah Dikembalikan</div>
                    <h2 class="fw-bold text-dark mt-2 mb-0">{{ $sudahDikembali ?? 0 }}</h2>
                </div>
            </div>
        </div>
    </div>

   <div class="col-lg-5">
        <div class="card card-custom p-3 h-100 d-flex flex-column justify-content-center align-items-center">
            <h6 class="fw-bold text-secondary mb-2">Persentase Status Peminjaman</h6>
            <div style="width: 100%; max-width: 250px; height: 250px;">
                <canvas id="pieChartStatus"></canvas>
            </div>
        </div>
    </div>
</div>

        <!-- Tabel Laporan dengan Kolom Kode Buku -->
        <div class="card card-custom p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th class="py-3 px-3 rounded-start">No</th>
                            <th class="py-3">Kode Buku</th>
                            <th class="py-3">Nama Siswa (NIS)</th>
                            <th class="py-3">Judul Buku</th>
                            <th class="py-3">Tgl Pinjam</th>
                            <th class="py-3">Tenggat Waktu</th>
                            <th class="py-3 px-3 rounded-end text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporans as $index => $item)
                            <tr>
                                <td class="px-3 fw-semibold">{{ $index + 1 }}</td>
                                <td><span class="badge bg-light text-dark border font-monospace">{{ $item->buku->id_buku ?? '-' }}</span></td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $item->siswa->nama_siswa ?? '-' }}</div>
                                    <small class="text-muted">NIS: {{ $item->id_siswa }}</small>
                                </td>
                                <td class="fw-semibold">{{ $item->buku->judul_buku ?? '-' }}</td>
                                <td>{{ $item->tanggal_pinjam ? \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') : '-' }}</td>
                                <td>{{ $item->tenggat_waktu ? \Carbon\Carbon::parse($item->tenggat_waktu)->format('d/m/Y') : '-' }}</td>
                                <td class="text-center px-3">
                                    @if($item->status == 'DIPINJAM')
                                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">DIPINJAM</span>
                                    @else
                                        <span class="badge bg-success px-3 py-2 rounded-pill">DIKEMBALIKAN</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
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

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('pieChartStatus').getContext('2d');

        // Ambil data dari Controller
        const jmlDipinjam = {{ $sedangDipinjam ?? 0 }};
        const jmlDikembalikan = {{ $sudahDikembali ?? 0 }};

        new Chart(ctx, {
            type: 'pie', // Bisa diganti 'doughnut' jika ingin model donat
            data: {
                labels: ['Sedang Dipinjam', 'Sudah Dikembalikan'],
                datasets: [{
                    data: [jmlDipinjam, jmlDikembalikan],
                    backgroundColor: ['#ffc107', '#198754'], // Warna kuning warning & hijau success
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            font: { size: 12 }
                        }
                    }
                }
            }
        });
    });
</script>
</body>
</html>