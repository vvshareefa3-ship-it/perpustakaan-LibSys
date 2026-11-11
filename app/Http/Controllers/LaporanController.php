<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;

class LaporanController extends Controller
{
   public function index(Request $request)
{
    if (auth()->user()->peran == 'SISWA') {
        abort(403, 'Unauthorized action.');
    }

    $query = Peminjaman::with(['buku', 'siswa']);

    // Tangkap parameter status
    if ($request->has('status') && $request->status != '') {
        $query->where('status', $request->status);
    }

    $laporanPeminjaman = $query->latest('id_peminjaman')->get();

    return view('petugas.laporan.index', compact('laporanPeminjaman'));
}

   public function cetak(Request $request)
{
    if (auth()->user()->peran == 'SISWA') {
        abort(403, 'Unauthorized action.');
    }

    $query = Peminjaman::with(['buku', 'siswa']);

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $peminjaman = $query->latest('id_peminjaman')->get();

    return view('petugas.laporan.cetak', compact('peminjaman'));
}
}