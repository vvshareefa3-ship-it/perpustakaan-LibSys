<?php

namespace App\Http\Controllers\Admin;

use App\Models\Denda;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Buku;
use App\Models\Siswa;
use App\Models\Peminjaman;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $totalBuku = Buku::count();
        $totalSiswa = Siswa::count();
        $bukuDipinjamCount = Peminjaman::where('status', 'DIPINJAM')->count();

        $totalTerlambat = Denda::where('keterangan', 'Belum Dibayar')->count();

        $peminjamanTerbaru = Peminjaman::with(['buku', 'siswa'])
            ->orderBy('tanggal_pinjam', 'DESC')
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'user',
            'totalBuku',
            'totalSiswa',
            'bukuDipinjamCount',
            'totalTerlambat',
            'peminjamanTerbaru'
        ));
    }
}