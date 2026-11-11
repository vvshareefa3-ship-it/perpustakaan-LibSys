<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Siswa;

class DashboardController extends Controller
{
   public function dashboard()
{
    $user = auth()->user();
    $rekomendasiBuku = Buku::where('is_rekomendasi', 1)->get();
    
    dd([
        'user_login' => $user,
        'jumlah_buku_rekomendasi' => $rekomendasiBuku->count(),
        'data_buku' => $rekomendasiBuku
    ]);

}
}