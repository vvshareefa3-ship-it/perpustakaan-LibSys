<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Denda - LibSys</title>
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
                <i class="fa-solid fa-triangle-exclamation text-danger"></i> LibSys <span class="fs-6 fw-normal text-light opacity-75">| Tambah Denda</span>
            </a>
            <a href="{{ route('denda.index') }}" class="btn btn-outline-light btn-sm px-3 rounded-pill">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-custom p-4">
                    <h4 class="fw-bold text-dark mb-3"><i class="fa-solid fa-plus-circle text-danger me-2"></i> Form Tambah Denda</h4>
                    
                    @if ($errors->any())
                        <div class="alert alert-danger rounded-4">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('denda.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="id_pengembalian" class="form-label fw-semibold">ID Pengembalian</label>
                            <input type="number" class="form-control rounded-pill px-3" id="id_pengembalian" name="id_pengembalian" value="{{ old('id_pengembalian') }}" placeholder="Contoh: 1" required>
                        </div>

                        <div class="mb-3">
                            <label for="jenis_denda" class="form-label fw-semibold">Jenis Denda</label>
                            <select class="form-select rounded-pill px-3" id="jenis_denda" name="jenis_denda" required>
                                <option value="" disabled selected>Pilih Jenis Denda</option>
                                <option value="KETERLAMBATAN">KETERLAMBATAN</option>
                                <option value="KERUSAKAN">KERUSAKAN</option>
                                <option value="KEHILANGAN">KEHILANGAN</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="jumlah_hari_terlambat" class="form-label fw-semibold">Jumlah Hari Terlambat</label>
                                <input type="number" class="form-control rounded-pill px-3" id="jumlah_hari_terlambat" name="jumlah_hari_terlambat" value="{{ old('jumlah_hari_terlambat', 0) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="total_denda" class="form-label fw-semibold">Total Denda (Rp)</label>
                                <input type="number" class="form-control rounded-pill px-3" id="total_denda" name="total_denda" value="{{ old('total_denda', 0) }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nominal_keterlambatan" class="form-label fw-semibold">Nominal Keterlambatan (Rp)</label>
                                <input type="number" class="form-control rounded-pill px-3" id="nominal_keterlambatan" name="nominal_keterlambatan" value="{{ old('nominal_keterlambatan', 0) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nominal_kerusakan" class="form-label fw-semibold">Nominal Kerusakan (Rp)</label>
                                <input type="number" class="form-control rounded-pill px-3" id="nominal_kerusakan" name="nominal_kerusakan" value="{{ old('nominal_kerusakan', 0) }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_dibayar" class="form-label fw-semibold">Tanggal Dibayar</label>
                            <input type="date" class="form-control rounded-pill px-3" id="tanggal_dibayar" name="tanggal_dibayar" value="{{ old('tanggal_dibayar') }}">
                        </div>

                        <div class="mb-4">
                            <label for="keterangan" class="form-label fw-semibold">Keterangan</label>
                            <textarea class="form-control rounded-4 px-3 py-2" id="keterangan" name="keterangan" rows="3" placeholder="Tambahkan keterangan jika ada...">{{ old('keterangan') }}</textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('denda.index') }}" class="btn btn-light rounded-pill px-4">Batal</a>
                            <button type="submit" class="btn btn-danger rounded-pill px-4 fw-semibold shadow-sm">Simpan Denda</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>