<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Peminjaman;
use App\Models\Siswa;
use App\Models\Buku;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
 public function reservasiCepat($id)
{
    $user = auth()->user();
    
    $siswa = Siswa::where('id_user', $user->id ?? $user->id_user)->first()
        ?? Siswa::where('nis_siswa', $user->username)->first();

    if (!$siswa) {
        return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
    }

    $idSiswaValue = $siswa->id_siswa ?? $siswa->id ?? $siswa->nis_siswa;

    if (!$idSiswaValue) {
        return redirect()->back()->with('error', 'ID Siswa tidak valid.');
    }

    $sudahAdaBukuIni = Peminjaman::where('id_siswa', $idSiswaValue)
        ->where('id_buku', $id)
        ->whereIn('status', ['PENDING', 'DIPINJAM'])
        ->exists();

    if ($sudahAdaBukuIni) {
        return redirect()->back()->with('error', 'Anda sudah melakukan reservasi atau sedang meminjam buku ini.');
    }

    $totalPinjamanAktif = Peminjaman::where('id_siswa', $idSiswaValue)
        ->whereIn('status', ['PENDING', 'DIPINJAM'])
        ->count();

    if ($totalPinjamanAktif >= 3) {
        return redirect()->back()->with('error', 'Batas maksimal peminjaman adalah 3 buku. Selesaikan atau kembalikan buku terlebih dahulu.');
    }

    $buku = Buku::where('id_buku', $id)->firstOrFail();

    if ($buku->stok_tersedia <= 0) {
        return redirect()->back()->with('error', 'Maaf, stok buku ini sedang habis.');
    }

    Peminjaman::create([
        'id_siswa'        => $idSiswaValue,
        'id_user'         => $user->id ?? $user->id_user,
        'id_buku'         => $buku->id_buku,
        'tanggal_pinjam'  => now()->toDateString(),
        'tanggal_kembali' => now()->addDays(7)->toDateString(),
        'tenggat_waktu'   => now()->addDays(7)->toDateString(),
        'status'          => 'PENDING'
    ]);

    return redirect()->back()->with('success', 'Reservasi berhasil diajukan! Menunggu persetujuan petugas.');
}

public function setujui($id)
{
    $peminjaman = \App\Models\Peminjaman::findOrFail($id);
    
    if ($peminjaman->status == 'DIPINJAM' || $peminjaman->status == 'Dipinjam') {
        return redirect()->back()->with('error', 'Peminjaman ini sudah disetujui sebelumnya.');
    }

    $peminjaman->status = 'DIPINJAM'; 
    
    $tglPinjam = $peminjaman->tanggal_pinjam ? \Carbon\Carbon::parse($peminjaman->tanggal_pinjam) : \Carbon\Carbon::now();
    $peminjaman->tanggal_kembali = $tglPinjam->copy()->addDays(7);
    
    $peminjaman->save();

    if ($peminjaman->buku) {
        $peminjaman->buku->decrement('stok_tersedia'); 
    }

    return redirect()->back()->with('success', 'Peminjaman berhasil disetujui dan stok buku diperbarui.');
}

public function kembalikan($id)
{
    $peminjaman = \App\Models\Peminjaman::findOrFail($id);

    if ($peminjaman->status == 'DIKEMBALIKAN') {
        return redirect()->back()->with('error', 'Buku ini sudah diproses pengembaliannya sebelumnya.');
    }

    // 1. Ubah status dan catat tanggal dikembalikan hari ini
    $peminjaman->status = 'DIKEMBALIKAN';
    $tanggalDikembalikan = \Carbon\Carbon::now();
    $peminjaman->tanggal_kembali = $tanggalDikembalikan;
    $peminjaman->save(); 

    // 2. Kembalikan stok buku (+1)
    if ($peminjaman->buku) {
        $peminjaman->buku->increment('stok_tersedia'); 
    }

    // 3. HITUNG DENDA JIKA TERLAMBAT
    $tenggatWaktu = \Carbon\Carbon::parse($peminjaman->tenggat_waktu);

    // Cek apakah tanggal dikembalikan melewati tenggat waktu
    if ($tanggalDikembalikan->greaterThan($tenggatWaktu)) {
        $jumlahHariTerlambat = $tanggalDikembalikan->diffInDays($tenggatWaktu);
        $tarifPerHari = 1000; // Sesuaikan tarif denda Anda
        $totalDenda = $jumlahHariTerlambat * $tarifPerHari;

        // Simpan ke tabel_denda
        \App\Models\Denda::create([
            'id_peminjaman'         => $peminjaman->id_peminjaman,
            'jenis_denda'           => 'KETERLAMBATAN',
            'jumlah_hari_terlambat' => $jumlahHariTerlambat,
            'nominal_keterlambatan' => $tarifPerHari,
            'total_denda'           => $totalDenda,
            'keterangan'            => 'Terlambat ' . $jumlahHariTerlambat . ' hari',
            'status_pembayaran'     => 'BELUM LUNAS',
        ]);
    }

    return redirect()->back()->with('success', 'Buku berhasil dikembalikan dan denda dicatat!');
}

public function destroy($id)
{
    $peminjaman = Peminjaman::findOrFail($id);
    $peminjaman->delete();

    return redirect()->back()->with('success', 'Data peminjaman berhasil dihapus dan stok buku dikembalikan.');
}

public function store(Request $request)
{
    // Validasi input buku yang dipilih
    $request->validate([
        'id_buku' => 'required|exists:tabel_buku,id_buku', // Sesuaikan nama tabel buku Anda
    ]);

    $idSiswa = auth()->user()->id_siswa;

    // 1. Cek apakah ada denda yang belum dibayar
    $peminjamanIds = \App\Models\Peminjaman::where('id_siswa', $idSiswa)->pluck('id_peminjaman');
    
    $adaDendaBelumBayar = \App\Models\Denda::whereIn('id_peminjaman', $peminjamanIds)
                                ->where('keterangan', '!=', 'Sudah Dibayar')
                                ->exists();

    if ($adaDendaBelumBayar) {
        return redirect()->back()->with('error', 'Maaf, Anda memiliki tanggungan denda yang belum dibayar. Harap lunasi denda ke petugas perpustakaan terlebih dahulu.');
    }

    // 2. Cek batas maksimal peminjaman aktif (maksimal 3 buku)
    $jumlahPeminjamanAktif = \App\Models\Peminjaman::where('id_siswa', $idSiswa)
                                ->whereIn('status', ['PENDING', 'DIPINJAM'])
                                ->count();

    if ($jumlahPeminjamanAktif >= 3) {
        return redirect()->back()->with('error', 'Maaf, Anda telah mencapai batas maksimal peminjaman (3 buku). Harap kembalikan buku terlebih dahulu.');
    }

    // 3. Cek ketersediaan stok buku
    $buku = \App\Models\Buku::findOrFail($request->id_buku);
    if ($buku->stok <= 0) {
        return redirect()->back()->with('error', 'Maaf, stok buku ini sedang habis.');
    }

    // 4. SIMPAN DATA PEMINJAMAN (Aturan 7 hari otomatis)
    $tanggalPinjam = now();
    $tanggalKembali = $tanggalPinjam->copy()->addDays(7); // Aturan 7 hari batas pengembalian

    \App\Models\Peminjaman::create([
        'id_siswa'        => $idSiswa,
        'id_buku'         => $request->id_buku,
        'tanggal_pinjam'  => $tanggalPinjam,
        'tanggal_kembali' => $tanggalKembali,
        'status'          => 'PENDING', // Atau 'DIPINJAM' jika langsung disetujui tanpa konfirmasi petugas
    ]);

    // 5. KURANGI STOK BUKU OTOMATIS
    // (Catatan: Jika ingin stok berkurang setelah disetujui petugas, proses pengurangan ini bisa dipindah ke fungsi 'setujui' petugas)
    $buku->stok -= 1;
    $buku->save();

    return redirect()->back()->with('success', 'Pengajuan peminjaman buku berhasil dikirim! Menunggu konfirmasi petugas.');
}
}