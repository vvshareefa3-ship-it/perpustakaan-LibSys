<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Siswa;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $siswa = Siswa::where('nis_siswa', $user->username)->first() ?? Siswa::where('id_user', $user->id ?? $user->id_user)->first();
        $rekomendasiBuku = Buku::where('is_rekomendasi', 1)->get();

        $peminjamanAktif = $siswa ? Peminjaman::where('id_siswa', $siswa->nis_siswa)
            ->whereIn('status', ['PENDING', 'DIPINJAM', 'RESERVASI', 'TERLAMBAT'])
            ->get() : collect();
        $totalPinjam = $siswa ? Peminjaman::where('id_siswa', $siswa->nis_siswa)->count() : 0;
        $bukuDipinjamCount = $peminjamanAktif->count();

        return view('siswa.dashboard', compact(
            'user',
            'siswa',
            'rekomendasiBuku',
            'bukuDipinjamCount',
            'totalPinjam',
            'peminjamanAktif'
        ));
    }

    public function infoKelas()
    {
        $user = auth()->user();

        // Mengambil data siswa beserta relasi kelasnya yang sedang login
        $siswa = Siswa::with('kelas')
            ->where('nis_siswa', $user->username)
            ->first() ?? Siswa::with('kelas')->where('id_user', $user->id ?? $user->id_user)->first();

        return view('siswa.info-kelas', compact('user', 'siswa'));
    }

    public function riwayatPeminjaman()
    {
        $user = auth()->user();

        $siswa = Siswa::where('nis_siswa', $user->username)
            ->first()
            ?? Siswa::where('id_user', $user->id ?? $user->id_user)->first()
            ?? Siswa::where('nis_siswa', $user->id_siswa ?? null)->first();

        $riwayatPeminjaman = collect();

        if ($siswa) {
            $riwayatPeminjaman = Peminjaman::with('buku')
                ->where(function ($query) use ($siswa, $user) {
                    $query->where('id_siswa', $siswa->nis_siswa);
                    $userId = $user->id ?? $user->id_user ?? null;
                    if ($userId) {
                        $query->orWhere('id_user', $userId);
                    }
                })
                ->orderByDesc('id_peminjaman')
                ->get();
        }

        return view('siswa.riwayat', compact('user', 'siswa', 'riwayatPeminjaman'));
    }
}