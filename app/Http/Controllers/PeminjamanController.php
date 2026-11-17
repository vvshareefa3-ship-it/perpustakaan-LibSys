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

    // 1. Ambil data siswa berdasarkan relasi id_user atau username (nis_siswa)
    $siswa = Siswa::where('id_user', $user->id ?? $user->id_user)->first()
        ?? Siswa::where('nis_siswa', $user->username)->first();

    if (!$siswa) {
        return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
    }

    // 2. Gunakan nis_siswa sebagai Primary Key utama sesuai skema tabel_siswa
    $nisSiswa = $siswa->nis_siswa;

    if (!$nisSiswa) {
        return redirect()->back()->with('error', 'NIS Siswa tidak valid.');
    }

    try {
        return \DB::transaction(function () use ($id, $nisSiswa, $user) {

            // 3. Kunci baris buku dengan row-level locking
            $buku = Buku::where('id_buku', $id)->lockForUpdate()->firstOrFail();

            // 4. Cek stok tersedia di tabel_buku
            if ($buku->stok_tersedia <= 0) {
                throw new \Exception('Maaf, stok buku ini sudah habis atau sedang diajukan oleh siswa lain!');
            }

            // 5. Cek apakah siswa ini sudah meminjam/reservasi buku ini sebelumnya (status belum dikembalikan)
            $sudahAdaBukuIni = Peminjaman::where('id_siswa', $nisSiswa)
                ->where('id_buku', $id)
                ->where('status', '!=', 'DIKEMBALIKAN')
                ->exists();

            if ($sudahAdaBukuIni) {
                throw new \Exception('Anda sudah melakukan reservasi atau sedang meminjam buku ini.');
            }

            // 6. Cek batas maksimal peminjaman (Maksimal 3 buku aktif: PENDING / DIPINJAM)
            $totalPinjamanAktif = Peminjaman::where('id_siswa', $nisSiswa)
                ->whereIn('status', ['PENDING', 'DIPINJAM'])
                ->count();

            if ($totalPinjamanAktif >= 3) {
                throw new \Exception('Batas maksimal peminjaman adalah 3 buku. Selesaikan atau kembalikan buku terlebih dahulu.');
            }

            // 7. KURANGI STOK FISIK BUKU SEKARANG JUGA (Saat status PENDING)
            $buku->stok_tersedia -= 1;
            $buku->save();

            // 8. SIMPAN DATA PEMINJAMAN UTAMA (Sesuai kolom tabel_peminjaman)
            $peminjaman = Peminjaman::create([
                'id_siswa'        => $nisSiswa,
                'id_user'         => $user->id ?? $user->id_user,
                'id_buku'         => $id,
                'tanggal_pinjam'  => now()->toDateString(),
                'tanggal_kembali' => now()->addDays(7)->toDateString(),
                'tenggat_waktu'   => now()->addDays(7)->toDateString(),
                'status'          => 'PENDING'
            ]);

            // 9. SIMPAN KE TABEL DETAIL PEMINJAMAN (Sesuai relasi skema)
            \DB::table('tabel_detail_peminjaman')->insert([
                'id_peminjaman' => $peminjaman->id_peminjaman,
                'id_buku'       => $id,
                'jumlah'        => 1,
                'status_buku'   => 'PENDING',
            ]);

            return redirect()->back()->with('success', 'Reservasi berhasil diajukan! Menunggu persetujuan petugas.');
        });
    } catch (\Exception $e) {
        return redirect()->back()->with('error', $e->getMessage());
    }
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

    if ($peminjaman->buku && $peminjaman->buku->stok_tersedia > 0) {
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
        'id_buku' => 'required|exists:tabel_buku,id_buku',
    ]);

    $idSiswa = auth()->user()->id_siswa;
    $idBuku = $request->id_buku;

    try {
        return \DB::transaction(function () use ($request, $idSiswa, $idBuku) {

            // 1. KUNCI DATA BUKU DI DATABASE (Row-Level Locking)
            $buku = \App\Models\Buku::where('id_buku', $idBuku)->lockForUpdate()->firstOrFail();

            // 2. CEK APAKAH BUKU INI SEDANG DIPINJAM/PENDING OLEH SIAPA PUN
            // Kita cek langsung ke tabel_peminjaman berdasarkan id_buku dan status aktifnya
            $sedangDipinjamOrangLain = \App\Models\Peminjaman::where('id_buku', $idBuku)
                ->whereIn('status', ['PENDING', 'DIPINJAM'])
                ->exists();

            // 3. CEK STOK ATAU STATUS BUKU
            if ($buku->stok_tersedia <= 0 || $sedangDipinjamOrangLain) {
                return redirect()->back()->with('error', 'Maaf, buku ini sedang dalam antrean pengajuan (Pending) atau sedang dipinjam oleh siswa lain!');
            }

            // 4. Cek apakah siswa ybs sudah meminjam buku ini sebelumnya dan belum dikembalikan
            $sudahAda = \App\Models\Peminjaman::where('id_siswa', $idSiswa)
                ->where('id_buku', $idBuku)
                ->where('status', '!=', 'DIKEMBALIKAN')
                ->exists();

            if ($sudahAda) {
                return redirect()->back()->with('error', 'Maaf, Anda sudah mengajukan/meminjam buku ini sebelumnya dan belum dikembalikan.');
            }

            // 5. Cek denda
            $peminjamanIds = \App\Models\Peminjaman::where('id_siswa', $idSiswa)->pluck('id_peminjaman');
            $adaDendaBelumBayar = \App\Models\Denda::whereIn('id_peminjaman', $peminjamanIds)
                ->where('keterangan', '!=', 'Sudah Dibayar')
                ->exists();

            if ($adaDendaBelumBayar) {
                return redirect()->back()->with('error', 'Maaf, Anda memiliki tanggungan denda yang belum dibayar.');
            }

            // 6. Cek batas maksimal peminjaman (3 buku)
            $jumlahPeminjamanAktif = \App\Models\Peminjaman::where('id_siswa', $idSiswa)
                ->whereIn('status', ['PENDING', 'DIPINJAM'])
                ->count();

            if ($jumlahPeminjamanAktif >= 3) {
                return redirect()->back()->with('error', 'Maaf, Anda telah mencapai batas maksimal peminjaman (3 buku).');
            }

            // 7. KURANGI STOK DI TABEL BUKU
            $buku->stok_tersedia -= 1;
            $buku->save();

            // 8. SIMPAN DATA PEMINJAMAN UTAMA (Karena ada kolom id_buku di tabel_peminjaman)
            $peminjaman = \App\Models\Peminjaman::create([
                'id_siswa'        => $idSiswa,
                'id_buku'         => $idBuku, // Disimpan langsung di tabel utama sesuai struktur tabelmu
                'tanggal_pinjam'  => now(),
                'tanggal_kembali' => now()->addDays(7),
                'tenggat_waktu'   => now()->addDays(7),
                'status'          => 'PENDING',
            ]);

            // 9. (Opsional jika ingin tetap mengisi tabel detail peminjaman)
            \DB::table('tabel_detail_peminjaman')->insert([
                'id_peminjaman' => $peminjaman->id_peminjaman,
                'id_buku'       => $idBuku,
                'jumlah'        => 1,
                'status_buku'   => 'PENDING',
            ]);

            return redirect()->back()->with('success', 'Pengajuan peminjaman buku berhasil dikirim! Menunggu konfirmasi petugas.');
        });
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan sistem atau buku sedang diproses oleh siswa lain. Silakan coba lagi.');
    }
}
}