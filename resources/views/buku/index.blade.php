<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Buku - LibSys</title>
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
                <i class="fa-solid fa-book-bookmark text-warning"></i> LibSys <span class="fs-6 fw-normal text-light opacity-75">| Katalog Buku</span>
            </a>
            <a href="{{ route('kategori.index') }}" class="btn btn-outline-light rounded-pill px-4">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Pilih Kategori
            </a>
        </div>
    </nav>

    <div class="container py-4">
        {{-- Pesan Sukses --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Pesan Error / Peringatan --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-4 mb-4" role="alert">
                <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card card-custom p-4">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <div>
                    <h4 class="fw-bold text-dark mb-1">
                        <i class="fa-solid fa-book text-primary me-2"></i> Daftar Koleksi Buku 
                        <span class="text-muted fs-6 text-uppercase">({{ str_replace('_', ' ', $kategori ?? 'Bebas') }})</span>
                    </h4>
                    <p class="text-muted mb-0">Kelola dan pantau ketersediaan buku perpustakaan.</p>
                </div>
                
                {{-- Tombol Tambah Buku (Hanya Admin & Petugas) --}}
                @if(auth()->user()->peran != 'SISWA')
                <a href="{{ route('buku.create', ['kategori' => $kategori ?? 'bebas']) }}" class="btn btn-primary fw-semibold px-4 py-2 rounded-pill shadow-sm">
                    <i class="fa-solid fa-plus me-2"></i> Tambah Buku
                </a>
                @endif
            </div>

            <form action="{{ route('buku.index') }}" method="GET" class="mb-4">
            @if(request('kategori'))
                <input type="hidden" name="kategori" value="{{ request('kategori') }}">
            @endif

            <div class="input-group shadow-sm">
                <input type="text" name="cari" class="form-control" placeholder="Cari berdasarkan Judul Buku atau Penulis..." value="{{ request('cari') }}">
                <button class="btn btn-primary px-4" type="submit">
                    <i class="fa-solid fa-search me-1"></i> Cari
                </button>
                @if(request('cari'))
                    <a href="{{ route('buku.index', ['kategori' => request('kategori')]) }}" class="btn btn-outline-secondary">Reset</a>
                @endif
            </div>
        </form>

            <div class="table-responsive">            
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th class="py-3 px-3 rounded-start">No</th>
                            <th class="py-3">Judul Buku</th>
                            
                            {{-- Kolom Penulis & Tahun HANYA MUNCUL jika kategori == 'novel' / bebas --}}
                            @if(!in_array(($kategori ?? ''), ['kelas_10', 'kelas_11', 'kelas_12']))
                            <th class="py-3">Penulis</th>
                            <th class="py-3">Tahun</th>
                            @endif

                            <th class="py-3">Rak</th>
                            <th class="py-3 text-center">Stok</th>

                            {{-- Kolom Aksi / Kelola --}}
                            <th class="py-3 px-3 text-center rounded-end">
                                {{ auth()->user()->peran == 'SISWA' ? 'Aksi' : 'Kelola' }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($daftarBuku as $index => $buku)
                            <tr>
                                {{-- 1. No --}}
                                <td class="px-3 fw-semibold">{{ $index + 1 }}</td>

                                {{-- 2. Judul Buku --}}
                                <td class="fw-bold text-dark">{{ $buku->judul_buku }}</td>
                                
                                {{-- 3 & 4. Penulis & Tahun --}}
                                @if(!in_array(($kategori ?? ''), ['kelas_10', 'kelas_11', 'kelas_12']))
                                    <td>{{ $buku->penulis }}</td>
                                    <td>{{ $buku->tahun_terbit }}</td>
                                @endif

                                {{-- 5. Rak --}}
                                <td><span class="badge bg-light text-dark border">{{ $buku->lokasi_rak_buku ?? '-' }}</span></td>

                                {{-- 6. Stok --}}
                                <td class="text-center">
                                    <span class="badge {{ $buku->stok_tersedia > 0 ? 'bg-success' : 'bg-danger' }}">
                                        {{ $buku->stok_tersedia }}
                                    </span>
                                </td>

                                {{-- 7. Kelola / Aksi Berdasarkan Peran --}}
                                <td class="px-3 text-center">
                                    @if(auth()->user()->peran == 'SISWA')
                                        @php
                                            $user = auth()->user();
                                            $siswaLogin = \App\Models\Siswa::where('id_user', $user->id ?? $user->id_user)->first()
                                                ?? \App\Models\Siswa::where('nis_siswa', $user->username)->first();

                                            $peminjaman = null;
                                            $totalPinjamanAktif = 0;

                                            if ($siswaLogin) {
                                                $idSiswaVal = $siswaLogin->id_siswa ?? $siswaLogin->id ?? $siswaLogin->nis_siswa;
       
                                                $peminjaman = \App\Models\Peminjaman::where('id_buku', $buku->id_buku)
                                                    ->where('id_siswa', $idSiswaVal)
                                                    ->whereIn('status', ['PENDING', 'DIPINJAM'])
                                                    ->first();

                                                $totalPinjamanAktif = \App\Models\Peminjaman::where('id_siswa', $idSiswaVal)
                                                    ->whereIn('status', ['PENDING', 'DIPINJAM'])
                                                    ->count();
                                            }
                                        @endphp

                                        @if($peminjaman)
                                            @if($peminjaman->status == 'PENDING')
                                                <button class="btn btn-secondary btn-sm rounded-pill px-3" disabled>
                                                    <i class="fa-solid fa-clock me-1"></i> PENDING
                                                </button>
                                            @elseif($peminjaman->status == 'DIPINJAM')
                                                <button class="btn btn-warning btn-sm rounded-pill px-3 text-white" disabled>
                                                    <i class="fa-solid fa-book-reader me-1"></i> DIPINJAM
                                                </button>
                                            @endif
                                        @else
                                            @if($totalPinjamanAktif >= 3)
                                                <button class="btn btn-danger btn-sm rounded-pill px-3" disabled>
                                                    <i class="fa-solid fa-ban me-1"></i> Batas Maksimal 3 Buku
                                                </button>
                                            @else
                                                <form action="{{ route('reservasi.store', $buku->id_buku) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary btn-sm rounded-pill px-3">
                                                        <i class="fa-solid fa-bookmark me-1"></i> Reservasi
                                                    </button>
                                                </form>
                                            @endif
                                        @endif

                                    @else
                                        {{-- Tombol Edit & Hapus untuk Admin/Petugas --}}
                                        <a href="{{ route('buku.edit', $buku->id_buku) }}" class="btn btn-sm btn-outline-warning rounded-pill px-3 me-1">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </a>
                                        <form action="{{ route('buku.destroy', $buku->id_buku ?? $buku->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger px-3 py-1 rounded-pill" onclick="konfirmasiHapusBuku(this)">
                                            <i class="fa-solid fa-trash me-1"></i> Hapus
                                        </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ !in_array(($kategori ?? ''), ['kelas_10', 'kelas_11', 'kelas_12']) ? 7 : 5 }}" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-folder-open fs-2 mb-2 d-block opacity-50"></i>
                                    Belum ada data buku yang tersedia untuk kategori ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function konfirmasiHapusBuku(button) {
    Swal.fire({
        title: 'Hapus Buku?',
        text: "Yakin ingin menghapus data buku ini?",
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
</body>
</html>