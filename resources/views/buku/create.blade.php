<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku - LibSys</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .card-custom { border: none; border-radius: 14px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-custom p-4">
                    <div class="d-flex align-items-center mb-4 gap-2">
                        <div class="bg-primary text-white p-2 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fa-solid fa-plus"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-0">
                            Form Tambah Buku Baru 
                            <span class="text-muted fs-6 text-uppercase">({{ str_replace('_', ' ', $kategori ?? 'bebas') }})</span>
                        </h4>
                    </div>

                    <form action="{{ route('buku.store') }}" method="POST">
    @csrf

    <!-- Input tersembunyi untuk kategori -->
    <input type="hidden" name="kategori" value="{{ request('kategori') }}">

    <div class="mb-3">
        <label class="form-label">Judul Buku</label>
        <input type="text" name="judul_buku" class="form-control" placeholder="Contoh: Laskar Pelangi" required>
    </div>

    <!-- KHUSUS NOVEL: Kolom Penulis dan Tahun Terbit akan muncul di sini -->
    @if(request('kategori') == 'novel')
        <div class="mb-3">
            <label class="form-label">Penulis</label>
            <input type="text" name="penulis" class="form-control" placeholder="Contoh: Andrea Hirata" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tahun Terbit</label>
            <input type="number" name="tahun_terbit" class="form-control" placeholder="Contoh: 2005" required>
        </div>
    @endif

    <div class="mb-3">
        <label class="form-label">Lokasi Rak Buku</label>
        <input type="text" name="lokasi_rak_buku" class="form-control" placeholder="Contoh: Rak A1">
    </div>

    <div class="mb-3">
        <label class="form-label">Stok Tersedia</label>
        <input type="number" name="stok_tersedia" class="form-control" placeholder="Contoh: 10" required>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ route('buku.index', ['kategori' => request('kategori')]) }}" class="btn btn-secondary rounded-pill px-4">
            Batalkan
        </a>
        <button type="submit" class="btn btn-primary rounded-pill px-4">
            Simpan Buku
        </button>
    </div>
</form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>