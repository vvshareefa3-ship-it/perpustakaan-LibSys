<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku - LibSys</title>
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
                <i class="fa-solid fa-book-bookmark text-warning"></i> LibSys <span class="fs-6 fw-normal text-light opacity-75">| Edit Buku</span>
            </a>
            <a href="{{ route('buku.index') }}" class="btn btn-outline-light btn-sm px-3 rounded-pill">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </nav>

    <div class="container py-4" style="max-width: 700px;">
        <div class="card card-custom p-4">
            <h4 class="fw-bold text-dark mb-3"><i class="fa-solid fa-pen-to-square text-warning me-2"></i> Form Edit Data Buku</h4>
            
            <form action="{{ route('buku.update', $buku->id_buku) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Judul Buku</label>
        <input type="text" name="judul_buku" class="form-control" value="{{ $buku->judul_buku }}" required>
    </div>

    <!-- KHUSUS NOVEL: Penulis & Tahun Terbit hanya muncul jika kategori buku adalah novel -->
    @if($buku->kategori == 'novel')
        <div class="mb-3">
            <label class="form-label">Penulis</label>
            <input type="text" name="penulis" class="form-control" value="{{ $buku->penulis }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tahun Terbit</label>
            <input type="number" name="tahun_terbit" class="form-control" value="{{ $buku->tahun_terbit }}" required>
        </div>
    @endif

    <div class="mb-3">
        <label class="form-label">Lokasi Rak Buku</label>
        <input type="text" name="lokasi_rak_buku" class="form-control" value="{{ $buku->lokasi_rak_buku }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Stok Tersedia</label>
        <input type="number" name="stok_tersedia" class="form-control" value="{{ $buku->stok_tersedia }}" required>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('buku.index', ['kategori' => $buku->kategori]) }}" class="btn btn-secondary rounded-pill px-4">
            Batalkan
        </a>
        <button type="submit" class="btn btn-primary rounded-pill px-4">
            Perbarui Buku
        </button>
    </div>
</form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>