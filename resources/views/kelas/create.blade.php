<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kelas - LibSys</title>
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
                <i class="fa-solid fa-school text-success"></i> LibSys <span class="fs-6 fw-normal text-light opacity-75">| Tambah Kelas</span>
            </a>
            <a href="{{ route('kelas.index') }}" class="btn btn-outline-light btn-sm px-3 rounded-pill">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card card-custom p-4">
                    <h4 class="fw-bold text-dark mb-3"><i class="fa-solid fa-plus-circle text-success me-2"></i> Form Tambah Kelas</h4>
                    
                    @if ($errors->any())
                        <div class="alert alert-danger rounded-4">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('kelas.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_kelas" class="form-label fw-semibold">Nama Kelas</label>
                            <input type="text" class="form-control rounded-pill px-3" id="nama_kelas" name="nama_kelas" value="{{ old('nama_kelas') }}" placeholder="Contoh: XII RPL 1" required>
                        </div>

                        <div class="mb-4">
                            <label for="nama_jurusan" class="form-label fw-semibold">Nama Jurusan</label>
                            <input type="text" class="form-control rounded-pill px-3" id="nama_jurusan" name="nama_jurusan" value="{{ old('nama_jurusan') }}" placeholder="Contoh: Rekayasa Perangkat Lunak" required>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('kelas.index') }}" class="btn btn-light rounded-pill px-4">Batal</a>
                            <button type="submit" class="btn btn-success rounded-pill px-4 fw-semibold shadow-sm">Simpan Kelas</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>