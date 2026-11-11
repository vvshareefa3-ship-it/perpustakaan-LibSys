<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Kategori Buku - LibSys</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fa-solid fa-layer-group me-2"></i> Pilih Kategori Buku</h2>
            @php
            $user = auth()->user();
            $dashboardUrl = url('/dashboard'); // default

            if ($user) {
                if ($user->peran == 'SISWA') {
                    $dashboardUrl = url('/siswa/dashboard');
                } elseif ($user->peran == 'PETUGAS') {
                    $dashboardUrl = url('/petugas/dashboard');
                } elseif ($user->peran == 'ADMIN') {
                    $dashboardUrl = url('/admin/dashboard'); 
                }
            }
            @endphp

            <a href="{{ $dashboardUrl }}" class="btn btn-secondary rounded-pill px-4">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="row g-4">
            <!-- Pilihan Kategori Novel -->
            <div class="col-md-3">
                <div class="card shadow-sm text-center p-3 border-0 rounded-4">
                    <div class="card-body">
                        <i class="fa-solid fa-book-open fa-3x text-primary mb-3"></i>
                        <h4 class="card-title">Buku Novel</h4>
                        <p class="text-muted small">Kumpulan novel dan fiksi menarik.</p>
                        <a href="{{ route('buku.index', ['kategori' => 'novel']) }}" class="btn btn-primary rounded-pill w-100">Pilih Kategori</a>
                    </div>
                </div>
            </div>

            <!-- Pilihan Kategori Kelas 10 -->
            <div class="col-md-3">
                <div class="card shadow-sm text-center p-3 border-0 rounded-4">
                    <div class="card-body">
                        <i class="fa-solid fa-graduation-cap fa-3x text-success mb-3"></i>
                        <h4 class="card-title">Buku Kelas 10</h4>
                        <p class="text-muted small">Materi pelajaran tingkat kelas 10.</p>
                        <a href="{{ route('buku.index', ['kategori' => 'kelas_10']) }}" class="btn btn-success rounded-pill w-100">Pilih Kategori</a>
                    </div>
                </div>
            </div>

            <!-- Pilihan Kategori Kelas 11 -->
            <div class="col-md-3">
                <div class="card shadow-sm text-center p-3 border-0 rounded-4">
                    <div class="card-body">
                        <i class="fa-solid fa-graduation-cap fa-3x text-warning mb-3"></i>
                        <h4 class="card-title">Buku Kelas 11</h4>
                        <p class="text-muted small">Materi pelajaran tingkat kelas 11.</p>
                        <a href="{{ route('buku.index', ['kategori' => 'kelas_11']) }}" class="btn btn-warning rounded-pill w-100 text-white">Pilih Kategori</a>
                    </div>
                </div>
            </div>

            <!-- Pilihan Kategori Kelas 12 -->
            <div class="col-md-3">
                <div class="card shadow-sm text-center p-3 border-0 rounded-4">
                    <div class="card-body">
                        <i class="fa-solid fa-graduation-cap fa-3x text-danger mb-3"></i>
                        <h4 class="card-title">Buku Kelas 12</h4>
                        <p class="text-muted small">Materi pelajaran tingkat kelas 12.</p>
                        <a href="{{ route('buku.index', ['kategori' => 'kelas_12']) }}" class="btn btn-danger rounded-pill w-100">Pilih Kategori</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>