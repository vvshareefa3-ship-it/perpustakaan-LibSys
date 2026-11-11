<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Petugas - LibSys SMK Budi Bakti Ciwidey</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --sidebar-width: 260px;
        }
        body {
            background-color: #f8fafc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }
        /* Sidebar Styling */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: #ffffff;
            border-right: 1px solid #e2e8f0;
            z-index: 1050;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }
        .sidebar-brand {
            padding: 20px;
            font-size: 1.1rem;
            font-weight: bold;
            color: #0f172a;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .sidebar-menu {
            padding: 20px 16px;
            overflow-y: auto;
            flex-grow: 1;
        }
        .menu-category {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #94a3b8;
            font-weight: 600;
            margin-bottom: 10px;
            padding-left: 12px;
        }
        .nav-link-custom {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            color: #475569;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 500;
            margin-bottom: 4px;
            transition: all 0.2s ease;
        }
        .nav-link-custom:hover, .nav-link-custom.active {
            background-color: #eff6ff;
            color: #2563eb;
        }
        .nav-link-custom.active {
            font-weight: 600;
        }

        /* Main Content Wrapper */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            width: calc(100% - var(--sidebar-width));
            transition: all 0.3s ease;
        }

        /* Top Header */
        .top-header {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 15px 35px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 999;
        }
        .breadcrumb-custom {
            font-size: 0.75rem;
            color: #64748b;
            margin: 0;
            letter-spacing: 0.03em;
        }
        .breadcrumb-custom span {
            color: #0f172a;
            font-weight: 600;
        }

        /* Toggle Button Style */
        .sidebar-toggle-btn {
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            color: #0f172a;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            cursor: pointer;
        }
        .sidebar-toggle-btn:hover {
            background: #e2e8f0;
        }

        /* Profile Badge */
        .profile-badge {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 50px;
            padding: 6px 16px 6px 6px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }
        .profile-avatar {
            width: 36px;
            height: 36px;
            background: #f59e0b;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        /* Content Body & Hero Banner */
        .content-body {
            padding: 30px 35px;
            flex-grow: 1;
        }
        .hero-banner {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #ffffff;
            border-radius: 20px;
            padding: 35px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.1);
        }
        .card-custom {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
            background: #ffffff;
            transition: all 0.3s ease;
        }
        .card-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(15, 23, 42, 0.08);
        }
        .table-custom th {
            background-color: #0f172a;
            color: white;
            font-weight: 500;
            border: none;
            padding: 12px 16px;
        }
        .table-custom td {
            padding: 14px 16px;
            vertical-align: middle;
        }

        /* Mode Minimize Sidebar di Desktop */
        body.sidebar-collapsed .sidebar {
            left: calc(var(--sidebar-width) * -1);
        }
        body.sidebar-collapsed .main-content {
            margin-left: 0;
            width: 100%;
        }

        /* Mode Responsive untuk Handphone (Layar < 992px) */
        @media (max-width: 992px) {
            .sidebar {
                left: calc(var(--sidebar-width) * -1);
            }
            body.sidebar-mobile-show .sidebar {
                left: 0;
            }
            .main-content {
                margin-left: 0 !important;
                width: 100% !important;
            }
        }
    </style>
</head>
<body>

    <!-- SIDEBAR KIRI PETUGAS -->
    <div class="sidebar" id="appSidebar">
        <div class="sidebar-brand">
            <div class="d-flex align-items-center gap-2">
                <img src="{{ asset('Images\Logo_LibSys.png') }}" alt="Logo LibSys" style="width: 60px; height: 60px; min-width: 60px; object-fit: contain; border-radius: 6px;">
                <div style="display: flex; flex-direction: column; line-height: 1.2;">
                    <span style="font-weight: 990; font-size: 0.99rem; color: #0f172a; white-space: nowrap;">LIBSYS</span>
                    <span style="font-size: 15px; color: #64748b; white-space: nowrap;">Perpustakaan Digital</span>
                </div>
            </div>
            <!-- Tombol Tutup (X) di dalam Sidebar khusus HP -->
            <button class="sidebar-toggle-btn d-lg-none" onclick="toggleSidebar()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="sidebar-menu">
            <div class="menu-category">Utama</div>
            <a href="{{ route('petugas.dashboard') ?? '#' }}" class="nav-link-custom active">
                <i class="fa-solid fa-house-chimney"></i> Dashboard
            </a>
            
            <div class="menu-category mt-4">Manajemen</div>
            <a href="{{ route('petugas.buku.index') ?? '#' }}" class="nav-link-custom">
                <i class="fa-solid fa-book"></i> Data Buku
            </a>
            <a href="{{ route('buku.rekomendasi') }}" class="nav-link-custom">
                <i class="fa-solid fa-star"></i> Kelola Rekomendasi
            </a>
            <a href="{{ route('siswa.index') }}" class="nav-link-custom {{ request()->routeIs('siswa.index') ? 'active' : '' }}">
                <i class="fa-solid fa-user-graduate"></i> Data Siswa 
            </a>
            <a href="{{ route('kelas.index') ?? '#' }}" class="nav-link-custom">
                <i class="fa-solid fa-school"></i> Data Kelas
            </a>
            <a href="{{ route('denda.index') ?? '#' }}" class="nav-link-custom">
                <i class="fa-solid fa-triangle-exclamation"></i> Kelola Denda
            </a>
            <a href="{{ route('petugas.laporan') ?? '#' }}" class="nav-link-custom">
                <i class="fa-solid fa-file-invoice"></i> Laporan Peminjaman
            </a>

            <div class="menu-category mt-4">Akun</div>
            <form action="{{ route('logout') }}" method="POST" class="mt-2">
                @csrf
                <button type="submit" class="nav-link-custom w-100 border-0 bg-transparent text-danger text-start">
                    <i class="fa-solid fa-right-from-bracket"></i> Keluar
                </button>
            </form>
        </div>
    </div>

    <!-- MAIN CONTENT WRAPPER -->
    <div class="main-content">
        
        <!-- TOP HEADER (Diletakkan paling atas agar rapi) -->
        <div class="top-header">
            <div class="d-flex align-items-center gap-3">
                <!-- Tombol Buka/Tutup Sidebar -->
                <button class="sidebar-toggle-btn" onclick="toggleSidebar()" title="Buka/Tutup Menu">
                    <i class="fa-solid fa-outdent"></i>
                </button>
                <div>
                    <p class="breadcrumb-custom mb-0">PORTAL PETUGAS &rsaquo; <span class="text-primary">DASHBOARD</span></p>
                    <h4 class="fw-bold m-0 text-dark">Dashboard</h4>
                </div>
            </div>

            <!-- PROFIL KANAN ATAS (Memuat nama Ani Rohaeni) -->
            <div class="d-flex align-items-center gap-3">
                <div class="profile-badge">
                    <div class="profile-avatar">
                        {{ strtoupper(substr(auth()->user()->nama ?? auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="lh-sm">
                        <span class="d-block fw-bold text-dark" style="font-size: 0.85rem;">
                            {{ auth()->user()->nama ?? auth()->user()->name ?? 'Ani Rohaeni' }}
                        </span>
                        <span class="badge bg-warning text-dark" style="font-size: 9px;">Petugas</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- CONTENT BODY -->
        <div class="content-body">

            <!-- BANNER UTAMA -->
            <div class="hero-banner mb-4">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge bg-warning text-dark px-3 py-1 rounded-pill fw-semibold" style="font-size: 11px;">
                                <i class="fa-solid fa-circle-check me-1"></i> Panel Kontrol Petugas
                            </span>
                        </div>
                        <h2 class="fw-bold mb-2">Halo, {{ auth()->user()->nama_user ?? 'Petugas' }}! 👋</h2>
                        <p class="text-light text-opacity-75 mb-0 small" style="line-height: 1.6;">
                            Kelola data buku, pantau transaksi peminjaman, serta verifikasi aktivitas perpustakaan digital SMK Budi Bakti Ciwidey dengan mudah di sini.
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                        <a href="{{ route('petugas.buku.index') ?? '#' }}" class="btn btn-warning fw-semibold px-4 py-2 rounded-pill text-dark shadow-sm text-nowrap">
                            <i class="fa-solid fa-book me-1"></i> Data Buku
                        </a>
                    </div>
                </div>
            </div>

            <!-- KARTU STATISTIK PETUGAS -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card card-custom p-4 border-start border-primary border-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 bg-primary bg-opacity-10 text-primary p-3 rounded-4 me-3 fs-3">
                                <i class="fa-solid fa-book"></i>
                            </div>
                            <div>
                                <h6 class="text-muted small fw-semibold text-uppercase mb-1">Total Buku</h6>
                                <h3 class="fw-bold text-dark mb-0">{{ $totalBuku ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-custom p-4 border-start border-success border-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 bg-success bg-opacity-10 text-success p-3 rounded-4 me-3 fs-3">
                                <i class="fa-solid fa-book-bookmark"></i>
                            </div>
                            <div>
                                <h6 class="text-muted small fw-semibold text-uppercase mb-1">Dipinjam Aktif</h6>
                                <h3 class="fw-bold text-dark mb-0">{{ $bukuDipinjamCount ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-custom p-4 border-start border-warning border-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 bg-warning bg-opacity-10 text-warning p-3 rounded-4 me-3 fs-3">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <div>
                                <h6 class="text-muted small fw-semibold text-uppercase mb-1">Total Siswa</h6>
                                <h3 class="fw-bold text-dark mb-0">{{ $totalSiswa ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-custom p-4 border-start border-danger border-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 bg-danger bg-opacity-10 text-danger p-3 rounded-4 me-3 fs-3">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                            </div>
                            <div>
                                <h6 class="text-muted small fw-semibold text-uppercase mb-1">Terlambat</h6>
                                <h3 class="fw-bold text-dark mb-0">{{ $totalTerlambat ?? 2 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TABEL AKTIVITAS / PEMINJAMAN TERBARU -->
            <div class="card card-custom border-0 overflow-hidden mb-4">
                <div class="card-header bg-white py-3 px-4 border-bottom border-light">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="fa-solid fa-list-check text-primary me-2"></i> Aktivitas Peminjaman Terbaru
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 table-custom">
                            <thead>
                                <tr>
                                    <th class="ps-4">No</th>
                                    <th>Peminjam (Siswa)</th>
                                    <th>Judul Buku</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Batas Pengembalian</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
    @forelse($peminjaman ?? [] as $index => $item)
        <tr>
            <td class="ps-4">{{ $index + 1 }}</td>
            <td>{{ $item->siswa->nama_siswa ?? $item->id_siswa }}</td>
            <td>{{ $item->buku->judul_buku ?? 'Buku' }}</td>
            <td>{{ date('d/m/Y', strtotime($item->tanggal_pinjam)) }}</td>
            <td>{{ $item->tanggal_kembali ? date('d/m/Y', strtotime($item->tanggal_kembali)) : '-' }}</td>
            <td class="text-center">
    @if($item->status == 'PENDING')
        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Pending</span>
    @elseif($item->status == 'DIPINJAM')
        <span class="badge bg-primary px-3 py-2 rounded-pill">Dipinjam</span>
    @elseif($item->status == 'DIKEMBALIKAN')
        <span class="badge bg-success px-3 py-2 rounded-pill">Dikembalikan</span>
    @else
        <span class="badge bg-secondary px-3 py-2 rounded-pill">{{ $item->status }}</span>
    @endif
</td>

<td class="text-center">
    @if(strtoupper($item->status) == 'PENDING')
    <form action="{{ route('petugas.peminjaman.setujui', $item->id_peminjaman) }}" method="POST" class="d-inline form-setujui">
        @csrf
        <button type="button" class="btn btn-sm btn-success rounded-circle p-2 shadow-sm me-1" title="Setujui Peminjaman" onclick="konfirmasiSetujui(this)">
            <i class="fa-solid fa-check"></i>
        </button>
    </form>
@endif

    @if(strtoupper($item->status) == 'DIPINJAM')
    <form action="{{ route('peminjaman.kembalikan', $item->id_peminjaman) }}" method="POST" class="d-inline">
        @csrf
        @method('PATCH')
        <button type="button" class="btn btn-sm btn-success rounded-circle p-2 shadow-sm" title="Proses Pengembalian" onclick="konfirmasiKembalikan(this)">
            <i class="fa-solid fa-check"></i>
        </button>
    </form>
@endif

    <form action="{{ route('peminjaman.destroy', $item->id_peminjaman) }}" method="POST" class="d-inline form-hapus">
    @csrf
    @method('DELETE')
    <button type="button" class="btn btn-sm btn-danger rounded-circle p-2 shadow-sm" title="Hapus Data" onclick="konfirmasiHapus(this)">
        <i class="fa-solid fa-trash"></i>
    </button>
</form>
</td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center py-5 text-muted">
                <i class="fa-solid fa-folder-open fa-2x mb-2 text-secondary opacity-50"></i>
                <p class="mb-0 small">Belum ada aktivitas peminjaman terbaru.</p>
            </td>
        </tr>
    @endforelse
</tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

<script>
function toggleSidebar() {
    document.body.classList.toggle('sidebar-collapsed');
    document.body.classList.toggle('sidebar-mobile-show');
}
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function konfirmasiHapus(button) {
    Swal.fire({
        title: 'Hapus Data?',
        text: "Yakin ingin menghapus data ini?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545', 
        cancelButtonColor: '#6c757d',  
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            button.closest('form').submit();
        }
    });
}
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function konfirmasiSetujui(button) {
    Swal.fire({
        title: 'Setujui Peminjaman?',
        text: "Konfirmasi buku sudah disetujui untuk dipinjam siswa?",
        icon: 'question', // Menggunakan ikon tanya atau warning
        showCancelButton: true,
        confirmButtonColor: '#198754', // Warna hijau tombol setuju (Bootstrap success)
        cancelButtonColor: '#6c757d',  // Warna abu-abu untuk batal
        confirmButtonText: 'Ya, Setujui!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Mengirimkan form secara otomatis jika diklik "Ya, Setujui!"
            button.closest('form').submit();
        }
    });
}
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function konfirmasiKembalikan(button) {
    Swal.fire({
        title: 'Proses Pengembalian Buku?',
        text: "Pastikan buku sudah dikembalikan oleh siswa dengan baik.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#198754', // Warna hijau sukses
        cancelButtonColor: '#6c757d',  // Warna abu-abu untuk batal
        confirmButtonText: 'Ya, Selesaikan!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Mengirimkan form secara otomatis jika diklik "Ya, Selesaikan!"
            button.closest('form').submit();
        }
    });
}
</script>
</body>
</html>