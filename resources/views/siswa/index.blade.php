<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Siswa - LibSys</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <!-- Header & Tombol Kembali -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fa-solid fa-user-graduate me-2"></i> Daftar Data Siswa</h2>
            <a href="{{ url()->previous() }}" class="btn btn-secondary rounded-pill px-4">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-4">
                
                <!-- FORM PENCARIAN -->
                <form action="{{ route('siswa.index') }}" method="GET" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan Nama Siswa atau NIS..." value="{{ $search ?? '' }}">
                        <button class="btn btn-primary px-4" type="submit">
                            <i class="fa-solid fa-magnifying-glass me-1"></i> Cari
                        </button>
                        @if(isset($search) && $search != '')
                            <a href="{{ route('siswa.index') }}" class="btn btn-outline-secondary" title="Reset Pencarian">
                                <i class="fa-solid fa-rotate-left"></i>
                            </a>
                        @endif
                    </div>
                </form>

                <!-- TABEL DATA SISWA -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th class="ps-3">No</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Kelas / Jurusan</th>
                                <th class="text-center">Aksi Riwayat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($siswa ?? [] as $index => $item)
                                <tr>
                                    <td class="ps-3">{{ $index + 1 }}</td>
                                    <td>{{ $item->nis_siswa }}</td>
                                    <td class="fw-bold">{{ $item->nama_siswa }}</td>
                                    <td>{{ $item->kelas->nama_kelas ?? $item->kelas_jurusan ?? '-' }}</td>
                                    <td class="text-center">
                                        <!-- Tombol untuk memicu Modal Riwayat -->
                                        <button type="button" class="btn btn-sm btn-info text-white rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#riwayatModal{{ $item->nis_siswa }}">
                                            <i class="fa-solid fa-clock-rotate-left me-1"></i> Riwayat
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        <i class="fa-solid fa-face-sad-tear fa-2x mb-2"></i><br>
                                        Data siswa tidak ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- SEMUA MODAL DITEMPATKAN DI LUAR TABEL AGAR RAPI DAN TIDAK BERANTAKAN -->
    @foreach($siswa ?? [] as $item)
        <div class="modal fade" id="riwayatModal{{ $item->nis_siswa }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 rounded-4 shadow">
                    <div class="modal-header bg-dark text-white">
                        <h5 class="modal-title fw-bold">
                            <i class="fa-solid fa-book-open-reader me-2"></i> Riwayat Peminjaman: {{ $item->nama_siswa }} (NIS: {{ $item->nis_siswa }})
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle small">
                                <thead class="table-secondary text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Judul Buku</th>
                                        <th>Tgl Pinjam</th>
                                        <th>Batas / Tgl Kembali</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                tbody>
                                    {{-- Mengambil riwayat berdasarkan nis_siswa --}}
                                    @php
                                        $riwayatPeminjaman = \App\Models\Peminjaman::where('id_siswa', $item->nis_siswa)->get();
                                    @endphp

                                    @forelse($riwayatPeminjaman as $i => $p)
                                        <tr>
                                            <td class="text-center">{{ $i + 1 }}</td>
                                            <td>{{ $p->buku->judul_buku ?? 'Buku tidak ditemukan' }}</td>
                                            <td class="text-center">{{ $p->tanggal_pinjam ? date('d/m/Y', strtotime($p->tanggal_pinjam)) : '-' }}</td>
                                            <td class="text-center">{{ $p->tanggal_kembali ? date('d/m/Y', strtotime($p->tanggal_kembali)) : '-' }}</td>
                                            <td class="text-center">
                                                @if($p->status == 'PENDING')
                                                    <span class="badge bg-warning text-dark px-2 py-1">Pending</span>
                                                @elseif($p->status == 'DIPINJAM')
                                                    <span class="badge bg-primary px-2 py-1">Dipinjam</span>
                                                @elseif($p->status == 'DIKEMBALIKAN')
                                                    <span class="badge bg-success px-2 py-1">Dikembalikan</span>
                                                @else
                                                    <span class="badge bg-secondary px-2 py-1">{{ $p->status }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-3">
                                                Siswa ini belum memiliki riwayat peminjaman buku.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Bootstrap JS (Penting agar modal pop-up berfungsi) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>