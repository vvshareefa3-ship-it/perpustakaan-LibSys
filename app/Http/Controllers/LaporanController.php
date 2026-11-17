<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;

class LaporanController extends Controller
{
  public function index(Request $request)
{
    $query = Peminjaman::with(['buku', 'siswa'])
        ->whereIn('status', ['DIPINJAM', 'DIKEMBALIKAN']);

    // Filter berdasarkan status jika dipilih
    if ($request->filled('status') && in_array($request->status, ['DIPINJAM', 'DIKEMBALIKAN'])) {
        $query->where('status', $request->status);
    }

    $laporans = $query->latest('tanggal_pinjam')->get();

    // Hitung statistik (Hanya DIPINJAM dan DIKEMBALIKAN)
    $totalTransaksi = Peminjaman::whereIn('status', ['DIPINJAM', 'DIKEMBALIKAN'])->count();
    $sedangDipinjam = Peminjaman::where('status', 'DIPINJAM')->count();
    $sudahDikembali = Peminjaman::where('status', 'DIKEMBALIKAN')->count();

    return view('petugas.laporan.index', compact('laporans', 'totalTransaksi', 'sedangDipinjam', 'sudahDikembali'));
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