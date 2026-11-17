<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info Kelas Saya - LibSys</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8fafc; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-4 me-3 fs-3">
                            <i class="fa-solid fa-school"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1">Informasi Kelas Saya</h4>
                            <p class="text-muted small mb-0">Detail kelas dan jurusan Anda di SMK Budi Bakti Ciwidey</p>
                        </div>
                    </div>
                    <hr>
                    @if(isset($siswa) && $siswa && $siswa->kelas)
                        <div class="mb-3">
                            <label class="text-muted small fw-bold">NAMA LENGKAP SISWA</label>
                            <p class="fw-bold text-dark fs-5 mb-0">{{ $siswa->nama_siswa }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small fw-bold">NIS (NOMOR INDUK SISWA)</label>
                            <p class="fw-bold text-dark fs-5 mb-0">{{ $siswa->nis_siswa }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small fw-bold">KELAS</label>
                            <p class="fw-bold text-primary fs-4 mb-0">{{ $siswa->kelas->nama_kelas }}</p>
                        </div>
                        <div class="mb-4">
                            <label class="text-muted small fw-bold">JURUSAN</label>
                            <p class="fw-bold text-dark fs-6 mb-0">{{ $siswa->kelas->nama_jurusan }}</p>
                        </div>
                    @else
                        <div class="alert alert-warning text-center">
                            Data kelas belum diatur atau ditautkan ke akun Anda. Silakan hubungi Petugas/Admin.
                        </div>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('siswa.dashboard') }}" class="btn btn-secondary w-100 rounded-pill py-2 fw-semibold">
                            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>