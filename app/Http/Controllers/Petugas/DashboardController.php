<?php

namespace App\Http\Controllers\Petugas;

use App\Models\Denda;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Buku;
use App\Models\Siswa;
use App\Models\Peminjaman;
use Carbon\Carbon; 

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $totalBuku = Buku::count();
        $bukuDipinjamCount = Peminjaman::where('status', 'DIPINJAM')->count();
        $totalSiswa = Siswa::count();
        
        $totalTerlambat = Denda::where('keterangan', 'Belum Dibayar')->count();
        
        $peminjaman = Peminjaman::with(['buku', 'siswa'])
            ->orderBy('tanggal_pinjam', 'DESC')
            ->take(10)
            ->get();

        return view('petugas.dashboard', compact(
            'user', 
            'totalBuku', 
            'bukuDipinjamCount', 
            'totalSiswa', 
            'totalTerlambat', 
            'peminjaman'
        ));
    }
}