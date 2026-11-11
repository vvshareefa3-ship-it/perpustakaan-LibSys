<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Denda - LibSys</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark px-4 shadow-sm mb-4">
        <span class="navbar-brand mb-0 h1"><i class="fa-solid fa-triangle-exclamation me-2"></i> LibSys | Manajemen Denda</span>
        <a href="{{ url()->previous() }}" class="btn btn-outline-light btn-sm rounded-pill px-3">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Dashboard
        </a>
    </nav>

    <div class="container py-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-4">
                <h4 class="fw-bold mb-1">Daftar Denda Peminjaman</h4>
                <p class="text-muted small mb-4">Pantau dan kelola status pembayaran denda keterlambatan.</p>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark text-center">
                            <tr>
                                <th class="ps-3">No</th>
                                <th>ID Peminjaman</th>
                                <th>Peminjam (Siswa)</th>
                                <th>Jenis Denda</th>
                                <th>Keterlambatan</th>
                                <th>Total Denda</th>
                                <th>Status</th>
                                <th class="text-center">Aksi (Tunai)</th>
                            </tr>
                        </thead>
                        <tbody>
                           @forelse($dendas ?? [] as $index => $d)
                                <tr>
                                    <td class="ps-3 text-center">{{ $index + 1 }}</td>
                                    <td class="text-center">#{{ $d->id_peminjaman }}</td>
                                    <td>{{ $d->peminjaman->siswa->nama_siswa ?? $d->peminjaman->nama_siswa ?? 'Siswa' }}</td>
                                    <td>
                                       @if($d->jenis_denda == 'KETERLAMBATAN')
                                      <span class="badge bg-secondary">Keterlambatan</span>
                                       @elseif($d->jenis_denda == 'KERUSAKAN')
                                      <span class="badge bg-warning text-dark">Kerusakan Buku</span>
                                       @else
                                      <span class="badge bg-danger">Kehilangan Buku</span>
                                       @endif
                                    </td>
                                    <td class="text-center">
                                      @if($d->jenis_denda == 'KETERLAMBATAN')
                                         {{ $d->jumlah_hari_terlambat }} Hari
                                      @else
                                    <span class="text-muted fst-italic">N/A</span>
                                     @endif
                                     </td>
                                    <td class="fw-bold text-danger">Rp {{ number_format($d->total_denda, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        @if($d->keterangan == 'Sudah Dibayar')
                                            <span class="badge bg-success px-3 py-2 rounded-pill">Sudah Dibayar</span>
                                        @else
                                         <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Belum Dibayar</span>
                                        @endif
                                    </td>
                                  <td class="text-center">
                                 @php
                                 $roleUser = strtoupper(trim(auth()->user()->peran ?? ''));
                                  @endphp

                                    @if($roleUser !== 'SISWA')
                                 {{-- Tampilan untuk ADMIN atau PETUGAS (Muncul Tombol Aksi) --}}
                                 @if($d->keterangan != 'Sudah Dibayar')
            <form action="{{ route('denda.bayar', $d->id_denda ?? $d->id) }}" method="POST" class="d-inline">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm" title="Lunasi Denda">
                    <i class="fa-solid fa-money-bill-wave me-1"></i> Lunasi Tunai
                </button>
            </form>
        @else
            <form action="{{ route('denda.update', $d->id_denda) }}" method="POST" class="d-inline">
                @csrf
                @method('PATCH')
               <button type="button" class="btn btn-sm btn-warning fw-bold px-3 py-1 rounded-pill" onclick="konfirmasiDenda(this)">
                   <i class="fa-solid fa-rotate-left me-1"></i> Batalkan / Belum
               </button>
            </form>
        @endif
    @else
        {{-- Tampilan khusus untuk SISWA --}}
        @if($d->keterangan == 'Sudah Dibayar')
            <span class="badge bg-success px-3 py-2 rounded-pill">Sudah Dibayar</span>
        @else
            <span class="text-muted small fst-italic">Silakan bayar ke petugas</span>
        @endif
     @endif
      </td>
         </tr>
     @empty
    <tr>
        <td colspan="8" class="text-center py-4 text-muted">Belum ada data denda.</td>
    </tr>
@endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function konfirmasiDenda(button) {
    Swal.fire({
        title: 'Ubah Status Denda?',
        text: "Ubah status kembali menjadi belum dibayar?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#ffc107', // Warna kuning / oranye khas tombol denda (warning)
        cancelButtonColor: '#6c757d',  // Warna abu-abu untuk batal
        confirmButtonText: 'Ya, Ubah!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Mengirimkan form secara otomatis jika diklik "Ya, Ubah!"
            button.closest('form').submit();
        }
    });
}
</script>
</body>
</html>