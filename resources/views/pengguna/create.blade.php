<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Pengguna - LibSys</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

    <!-- Navbar Atas -->
    <nav class="navbar navbar-dark bg-dark px-4 shadow-sm mb-4">
        <span class="navbar-brand mb-0 h1"><i class="fa-solid fa-users-gear me-2"></i> LibSys | Tambah Pengguna</span>
        <a href="{{ route('pengguna.index') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
        </a>
    </nav>

    <!-- Konten Utama -->
    <div class="container py-3">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-4 p-md-5">
                        
                        <h4 class="fw-bold text-dark mb-1">Tambah Akun Pengguna Baru</h4>
<p class="text-muted small mb-4">Silakan pilih peran terlebih dahulu untuk menampilkan formulir isian yang sesuai.</p>

<!-- TAMPILKAN ERROR VALIDASI JIKA GAGAL -->
@if ($errors->any())
    <div class="alert alert-danger mb-4 rounded-3">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('pengguna.store') }}" method="POST">
    @csrf

    <!-- 1. PILIH PERAN DI PALING ATAS -->
    <div class="mb-4">
        <label for="peran" class="form-label fw-bold text-secondary text-uppercase small">Peran (Role) Pengguna</label>
        <select name="peran" id="peran-select" class="form-select form-select-lg shadow-sm" required onchange="tampilkanForm()">
            <option value="">-- Pilih Peran Terlebih Dahulu --</option>
            <option value="SISWA">Siswa</option>
            <option value="PETUGAS">Petugas</option>
            <option value="ADMIN">Admin</option>
        </select>
    </div>

    <!-- 2. KONTAINER UTAMA -->
    <div id="form-container" style="display: none;">
        <hr class="my-4 text-muted">

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold small text-secondary">NAMA LENGKAP</label>
                <input type="text" name="nama_user" class="form-control" placeholder="Contoh: Ahmad Fauzi" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold small text-secondary">USERNAME</label>
                <input type="text" name="username" class="form-control" placeholder="Contoh: faund_user" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold small text-secondary">EMAIL</label>
                <input type="email" name="email" class="form-control" placeholder="Contoh: email@gmail.com" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold small text-secondary">PASSWORD</label>
                <input type="password" name="password_user" class="form-control" placeholder="Minimal 8 karakter" required>
            </div>
        </div>

        <!-- KOTAK KHUSUS SISWA -->
        <div id="kolom-siswa" style="display: none;" class="p-4 mb-4 border rounded-3 bg-light shadow-sm">
            <h6 class="text-primary fw-bold mb-3"><i class="fa-solid fa-user-graduate me-2"></i> Informasi Tambahan Siswa</h6>
            
            <div class="mb-3">
                <label class="form-label fw-bold small">NIS (Nomor Induk Siswa)</label>
                <input type="text" name="nis" class="form-control" placeholder="Contoh: 242510443">
            </div>

            <div class="mb-0">
                <label class="form-label fw-bold small">Kelas / Jurusan</label>
                <select name="id_kelas" class="form-select">
                    <option value="">-- Pilih Kelas --</option>
                    <option value="1">10 BRP</option>
                    <option value="1">11 BRP</option>
                    <option value="1">12 BRP</option>
                    <option value="1">10 RPL</option>
                    <option value="1">11 RPL</option>
                    <option value="1">12 RPL</option>
                    <option value="1">10 DKV</option>
                    <option value="1">11 DKV</option>
                    <option value="1">12 DKV</option>
                    <!-- Sesuaikan opsi kelas lainnya -->
                </select>
            </div>
        </div>
    </div>

    <!-- TOMBOL AKSI -->
    <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
        <a href="{{ route('pengguna.index') }}" class="btn btn-light border px-4 rounded-pill">Batal</a>
        <button type="submit" class="btn btn-primary px-4 rounded-pill shadow-sm">Simpan Pengguna</button>
    </div>
</form>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- SCRIPT JAVASCRIPT DINAMIS -->
    <script>
    function tampilkanForm() {
        let peran = document.getElementById('peran-select').value;
        let formContainer = document.getElementById('form-container');
        let kolomSiswa = document.getElementById('kolom-siswa');

        if (peran === "") {
            formContainer.style.display = 'none';
        } else {
            formContainer.style.display = 'block';

            if (peran === 'SISWA') {
                kolomSiswa.style.display = 'block';
            } else {
                kolomSiswa.style.display = 'none';
            }
        }
    }
    </script>

</body>
</html>