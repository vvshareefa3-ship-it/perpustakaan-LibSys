<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa - LibSys SMK Budi Bakti Ciwidey</title>
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
            padding: 16px;
            font-size: 1.1rem;
            font-weight: bold;
            color: #0f172a;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            white-space: nowrap;
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

    <!-- SIDEBAR KIRI -->
    <div class="sidebar" id="appSidebar">
        <div class="sidebar-brand">
            <div class="d-flex align-items-center gap-2" style="overflow: hidden;">
                <img src="{{ asset('Images\Logo_LibSys.png') }}" alt="Logo LibSys" style="width: 60px; height: 60px; min-width: 60px; object-fit: contain; border-radius: 9px;">
                <div style="display: flex; flex-direction: column; line-height: 1.2;">
                    <span style="font-weight: 990; font-size: 0.99rem; color: #0f172a; white-space: nowrap;">LIBSYS</span>
                    <span style="font-size: 15px; color: #64748b; white-space: nowrap;">Perpustakaan Digital</span>
                </div>
            </div>
            <!-- Tombol Tutup (X) khusus HP -->
            <button class="sidebar-toggle-btn d-lg-none border-0 bg-transparent text-secondary" onclick="toggleSidebar()">
                <i class="fa-solid fa-xmark fs-5"></i>
            </button>
        </div>

        <div class="sidebar-menu">
            <div class="menu-category">Utama</div>
            <a href="{{ route('siswa.dashboard') ?? '#' }}" class="nav-link-custom active">
                <i class="fa-solid fa-house-chimney"></i> Dashboard
            </a>
            
            <div class="menu-category mt-4">Menu Perpustakaan</div>
            <a href="{{ route('kategori.index') }}" class="nav-link-custom">
                <i class="fa-solid fa-book"></i> Katalog Buku
            </a>
            <a href="{{ route('kelas.index') }}" class="nav-link-custom">
                <i class="fa-solid fa-school"></i> Info Kelas
            </a>
            <a href="{{ route('denda.index') }}" class="nav-link-custom">
                <i class="fa-solid fa-triangle-exclamation"></i> Cek Denda
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
        
        <!-- TOP HEADER -->
        <div class="top-header">
            <div class="d-flex align-items-center gap-3">
                <!-- Tombol Buka/Tutup Sidebar di Header -->
                <button class="sidebar-toggle-btn" onclick="toggleSidebar()" title="Buka/Tutup Menu">
                    <i class="fa-solid fa-outdent"></i>
                </button>
                <div>
                    <p class="breadcrumb-custom mb-0">PORTAL SISWA &rsaquo; <span class="text-primary">DASHBOARD</span></p>
                    <h4 class="fw-bold m-0 text-dark">Dashboard</h4>
                </div>
            </div>

            <!-- PROFIL KANAN ATAS -->
            <div class="d-flex align-items-center gap-3">
                <div class="profile-badge">
                    <div class="profile-avatar">
                        {{ strtoupper(substr($siswa->nama_siswa ?? $user->nama ?? $user->name ?? 'S', 0, 1)) }}
                    </div>
                    <div class="lh-sm">
                        <span class="d-block fw-bold text-dark" style="font-size: 0.85rem;">
                            {{ $siswa->nama_siswa ?? $user->nama ?? $user->name ?? 'Pengguna' }}
                        </span>
                        <span class="badge bg-primary text-white" style="font-size: 9px;">Siswa</span>
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
                                <i class="fa-solid fa-circle-check me-1"></i> Siswa Terautentikasi
                            </span>
                        </div>
                        <h2 class="fw-bold mb-2">Halo, {{ auth()->user()->nama_user ?? 'Siswa' }}! 👋</h2>
                        <p class="text-light text-opacity-75 mb-0 small" style="line-height: 1.6;">
                            Selamat datang di portal perpustakaan digital LibSys SMK Budi Bakti Ciwidey. Jelajahi literatur dan pantau status peminjaman buku Anda dengan mudah di sini.
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                        <a href="{{ route('kategori.index') }}" class="btn btn-warning fw-semibold px-4 py-2 rounded-pill text-dark shadow-sm text-nowrap">
                            <i class="fa-solid fa-book me-1"></i> Katalog Buku
                        </a>
                    </div>
                </div>
            </div>

            <!-- REKOMENDASI BUKU UNTUK SISWA -->
            <div class="card card-custom border-0 overflow-hidden mb-4">
                <div class="card-header bg-white py-3 px-4 border-bottom border-light d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="fa-solid fa-star text-warning me-2"></i> Rekomendasi Buku Pilihan
                    </h5>
                    <a href="{{ route('kategori.index') }}" class="text-decoration-none small fw-semibold text-primary">Lihat Semua <i class="fa-solid fa-arrow-right ms-1"></i></a>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
    @forelse($rekomendasiBuku ?? [] as $buku)
        <div class="col-md-3">
            <div class="p-3 border rounded-4 h-100 d-flex flex-column justify-content-between bg-light bg-opacity-50">
                <div>
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge bg-warning text-dark px-2 py-1" style="font-size: 10px;">{{ $buku->kategori ?? 'Umum' }}</span>
                        <small class="text-muted"><i class="fa-solid fa-book-open me-1"></i>Stok: {{ $buku->stok_tersedia }}</small>
                    </div>
                    <h6 class="fw-bold text-dark mb-1 text-truncate" title="{{ $buku->judul_buku }}">{{ $buku->judul_buku }}</h6>
                    <p class="text-muted small mb-3">Penulis: {{ $buku->penulis ?? '-' }}</p>
                </div>
                <div>
                    <a href="{{ route('buku.reservasi', $buku->id_buku ?? $buku->id) }}" class="btn btn-sm btn-outline-primary w-100 rounded-pill fw-semibold">
                        <i class="fa-solid fa-bookmark me-1"></i> Reservasi Buku
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-4 text-muted">
            <i class="fa-solid fa-star-half-stroke fa-2x mb-2 text-secondary opacity-50"></i>
            <p class="mb-0 small">Belum ada rekomendasi buku khusus saat ini. Silakan cek di menu Katalog Buku.</p>
        </div>
    @endforelse
</div>
            </div>

            <!-- KARTU STATISTIK -->
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="card card-custom p-4 border-start border-primary border-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 bg-primary bg-opacity-10 text-primary p-3 rounded-4 me-3 fs-3">
                                <i class="fa-solid fa-book-bookmark"></i>
                            </div>
                            <div>
                                <h6 class="text-muted small fw-semibold text-uppercase mb-1">Buku Sedang Dipinjam</h6>
                                <h2 class="fw-bold text-dark mb-0">{{ $bukuDipinjamCount ?? 0 }} <span class="fs-6 fw-normal text-muted">Buku</span></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-custom p-4 border-start border-success border-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 bg-success bg-opacity-10 text-success p-3 rounded-4 me-3 fs-3">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                            </div>
                            <div>
                                <h6 class="text-muted small fw-semibold text-uppercase mb-1">Total Riwayat Peminjaman</h6>
                                <h2 class="fw-bold text-dark mb-0">{{ $totalPinjam ?? 0 }} <span class="fs-6 fw-normal text-muted">Kali</span></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TABEL STATUS PEMINJAMAN -->
            <div class="card card-custom border-0 overflow-hidden mb-4">
                <div class="card-header bg-white py-3 px-4 border-bottom border-light">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="fa-solid fa-list-check text-primary me-2"></i> Status Peminjaman Buku Aktif
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 table-custom">
                            <thead>
                                <tr>
                                    <th class="ps-4">No</th>
                                    <th>Judul Buku</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Batas Pengembalian</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($peminjamanAktif ?? [] as $index => $pinjam)
                                    <tr>
                                        <td class="ps-4 fw-semibold text-secondary">{{ $index + 1 }}</td>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $pinjam->buku->judul_buku ?? 'Buku Perpustakaan' }}</div>
                                            <small class="text-muted">Penulis: {{ $pinjam->buku->penulis ?? '-' }}</small>
                                        </td>
                                        <td class="text-secondary">{{ date('d/m/Y', strtotime($pinjam->tanggal_pinjam)) }}</td>
                                        <td class="text-secondary">{{ date('d/m/Y', strtotime($pinjam->tanggal_kembali)) }}</td>
                                        <td class="text-center">
                                            @if($pinjam->status == 'DIPINJAM')
                                        <span class="badge bg-primary px-3 py-2 rounded-pill">Dipinjam</span>
                                           @elseif($pinjam->status == 'PENDING' || $pinjam->status == 'RESERVASI')
                                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Menunggu Persetujuan (Pending)</span>
                                           @elseif($pinjam->status == 'TERLAMBAT')
                                        <span class="badge bg-danger px-3 py-2 rounded-pill">Terlambat</span>
                                           @else
                                        <span class="badge bg-secondary px-3 py-2 rounded-pill">{{ $pinjam->status }}</span>
                                           @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <div class="py-3">
                                                <i class="fa-solid fa-books fa-2x mb-3 text-secondary opacity-50"></i>
                                                <p class="mb-0 fw-medium">Tidak ada peminjaman buku aktif saat ini.</p>
                                            </div>
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
</body>
</html>