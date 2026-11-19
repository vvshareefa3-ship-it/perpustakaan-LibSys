<?php

namespace App\Http\Controllers\Admin;

use App\Models\Denda;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Buku;
use App\Models\Siswa;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $totalBuku = Buku::count();
        $totalSiswa = Siswa::count();
        $bukuDipinjamCount = Peminjaman::where('status', 'DIPINJAM')->count();
        $totalTerlambat = Denda::where('keterangan', 'Belum Dibayar')->count();

        $peminjamanTerbaru = Peminjaman::with(['buku', 'siswa', 'denda'])
            ->orderByDesc('id_peminjaman')
            ->orderByDesc('tanggal_pinjam')
            ->get();

        // Kelompokkan per siswa agar tiap siswa muncul 1 baris di log utama
        $logPerSiswa = $peminjamanTerbaru->groupBy(function ($item) {
            return $item->id_siswa ?? ($item->siswa->nis_siswa ?? 'unknown_' . $item->id_peminjaman);
        })->map(function ($items) {
            $terbaru = $items->first();
            $daftarDenda = $items->pluck('denda')->filter()->values();

            return [
                'id_siswa'           => $terbaru->id_siswa ?? ($terbaru->siswa->nis_siswa ?? '-'),
                'nama_siswa'         => $terbaru->siswa->nama_siswa ?? $terbaru->nama_siswa ?? 'Siswa',
                'total_transaksi'    => $items->count(),
                'pinjaman_terbaru'   => $terbaru,
                'riwayat_peminjaman' => $items->values(),
                'riwayat_denda'      => $daftarDenda,
            ];
        })->values();

        return view('admin.dashboard', compact(
            'user',
            'totalBuku',
            'totalSiswa',
            'bukuDipinjamCount',
            'totalTerlambat',
            'peminjamanTerbaru',
            'logPerSiswa'
        ));
    }
}