<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $rekomendasiBuku = Buku::where('is_rekomendasi', 1)->get();
        
        $rekapKategori = Peminjaman::select('tabel_buku.kategori', DB::raw('COUNT(tabel_peminjaman.id_peminjaman) as total_data'))
                            ->join('tabel_buku', 'tabel_peminjaman.id_buku', '=', 'tabel_buku.id_buku')
                            ->groupBy('tabel_buku.kategori')
                            ->get();

        $rekapDenda = DB::table('tabel_denda')
                            ->select('status_pembayaran', DB::raw('SUM(total_denda) as total_nominal'))
                            ->groupBy('status_pembayaran')
                            ->get();

        return view('dashboard', compact('user', 'rekomendasiBuku', 'rekapKategori', 'rekapDenda'));
    }
}