<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna - LibSys</title>
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
                <i class="fa-solid fa-users-gear text-warning"></i> LibSys <span class="fs-6 fw-normal text-light opacity-75">| Manajemen Pengguna</span>
            </a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light btn-sm px-3 rounded-pill">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Dashboard
            </a>
        </div>
    </nav>

    <div class="container py-4">
        @if(session('success'))
            <div class="alert alert-success rounded-4 mb-4"><i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}</div>
        @endif

        <div class="card card-custom p-4">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <div>
                    <h4 class="fw-bold text-dark mb-1"><i class="fa-solid fa-users text-warning me-2"></i> Daftar Pengguna Sistem</h4>
                    <p class="text-muted mb-0">Kelola akun Admin, Petugas, dan Siswa.</p>
                </div>
                <a href="{{ route('pengguna.create') }}" class="btn btn-warning fw-semibold px-4 py-2 rounded-pill shadow-sm text-dark">
                    <i class="fa-solid fa-user-plus me-2"></i> Tambah Pengguna
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th class="py-3 px-3 rounded-start">No</th>
                            <th class="py-3">Nama Lengkap</th>
                            <th class="py-3">Username</th>
                            <th class="py-3">Peran (Role)</th>
                            <th class="py-3 px-3 text-center rounded-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($daftarPengguna as $index => $user)
                            <tr>
                                <td class="px-3 fw-semibold">{{ $index + 1 }}</td>
                                <td class="fw-bold text-dark">{{ $user->nama_user }}</td>
                                <td>{{ $user->username }}</td>
                                <td>
                                    <span class="badge {{ $user->peran == 'ADMIN' ? 'bg-danger' : ($user->peran == 'PETUGAS' ? 'bg-primary' : 'bg-success') }}">
                                        {{ $user->peran }}
                                    </span>
                                </td>
                                <td class="px-3 text-center">
                                    <a href="{{ route('pengguna.edit', $user->id_user) }}" class="btn btn-sm btn-outline-warning rounded-pill px-3 me-1">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </a>
                                    <form action="{{ route('pengguna.destroy', $user->id_user) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pengguna ini?')">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger px-3 py-1 rounded-pill" onclick="konfirmasiHapusPengguna(this)">
        <i class="fa-solid fa-trash me-1"></i> Hapus
    </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-5 text-muted">Belum ada data pengguna.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Pastikan CDN SweetAlert2 sudah dimuat -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function konfirmasiHapusPengguna(button) {
    Swal.fire({
        title: 'Hapus Pengguna?',
        text: "Yakin ingin menghapus akun pengguna ini?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545', // Warna merah khas tombol hapus
        cancelButtonColor: '#6c757d',  // Warna abu-abu untuk batal
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Mengirimkan form secara otomatis jika diklik "Ya, Hapus!"
            button.closest('form').submit();
        }
    });
}
</script>
</body>
</html>