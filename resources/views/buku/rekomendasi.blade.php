<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Rekomendasi Buku - LibSys</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold"><i class="fa-solid fa-star text-warning me-2"></i> Kelola Rekomendasi Buku Pilihan</h3>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="ps-4">No</th>
                                <th>Judul Buku</th>
                                <th>Penulis</th>
                                <th>Kategori</th>
                                <th class="text-center">Status Rekomendasi</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($daftarBuku as $index => $buku)
                                <tr>
                                    <td class="ps-4 fw-semibold">{{ $index + 1 }}</td>
                                    <td class="fw-bold text-dark">{{ $buku->judul_buku }}</td>
                                    <td>{{ $buku->penulis ?? '-' }}</td>
                                    <td><span class="badge bg-secondary">{{ ucfirst($buku->kategori) }}</span></td>
                                    <td class="text-center">
                                        @if($buku->is_rekomendasi == 1)
                                            <span class="badge bg-success px-3 py-2 rounded-pill">Aktif (Rekomendasi)</span>
                                        @else
                                            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('buku.toggleRekomendasi', $buku->id_buku) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm {{ $buku->is_rekomendasi == 1 ? 'btn-outline-danger' : 'btn-outline-success' }} rounded-pill px-3">
                                                <i class="fa-solid {{ $buku->is_rekomendasi == 1 ? 'fa-xmark' : 'fa-check' }} me-1"></i>
                                                {{ $buku->is_rekomendasi == 1 ? 'Batalkan' : 'Jadikan Rekomendasi' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">Belum ada data buku di database.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>