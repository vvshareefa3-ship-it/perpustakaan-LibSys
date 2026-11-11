<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Denda;
use Carbon\Carbon;

class DendaController extends Controller
{
    public function index()
    {
        // 1. Ambil semua peminjaman aktif yang melewati tenggat waktu
        $peminjamanAktif = Peminjaman::where('status', 'DIPINJAM')->get();

        foreach ($peminjamanAktif as $pinjam) {
            // Gunakan 'tenggat_waktu' sesuai kolom di tabel_peminjaman
            $tenggat = Carbon::parse($pinjam->tenggat_waktu);
            $sekarang = Carbon::now();

            if ($sekarang->greaterThan($tenggat)) {
                $terlambatHari = $tenggat->diffInDays($sekarang);
                $jumlahDenda = $terlambatHari * 1000;

                $dendaExist = Denda::where('id_peminjaman', $pinjam->id_peminjaman)->first();

                if (!$dendaExist) {
                    Denda::create([
                        'id_peminjaman' => $pinjam->id_peminjaman,
                        'jenis_denda' => 'KETERLAMBATAN',
                        'jumlah_hari_terlambat' => $terlambatHari,
                        'nominal_keterlambatan' => $jumlahDenda,
                        'total_denda' => $jumlahDenda,
                        'keterangan' => 'Belum Dibayar',
                    ]);
                } else {
                    $dendaExist->update([
                        'jumlah_hari_terlambat' => $terlambatHari,
                        'nominal_keterlambatan' => $jumlahDenda,
                        'total_denda' => $jumlahDenda,
                    ]);
                }
            }
        }

        // 2. Filter Denda Berdasarkan User Login & Role
        $user = auth()->user();

        if (strtoupper($user->peran) === 'SISWA') {
            // Jika SISWA: Ambil denda yang berelasi dengan id_user milik siswa aktif
            $dendas = Denda::with(['peminjaman.buku', 'peminjaman.user'])
                ->whereHas('peminjaman', function ($query) use ($user) {
                    $query->where('id_user', $user->id_user);
                })
                ->get();
        } else {
            // Jika ADMIN atau PETUGAS: Tampilkan seluruh data denda
            $dendas = Denda::with(['peminjaman.buku', 'peminjaman.user'])->get();
        }

        return view('denda.index', compact('dendas'));
    }

    public function bayar(Request $request, $id)
{
    if (strtoupper(auth()->user()->peran) === 'SISWA') {
        abort(403, 'Aksi ini hanya diperbolehkan untuk Petugas/Admin.');
    }

    $denda = Denda::findOrFail($id);

    if ($request->has('status_reset')) {
        $denda->update([
            'keterangan' => 'Belum Dibayar',
            'tanggal_dibayar' => null,
        ]);
        $pesan = 'Status denda berhasil diubah menjadi Belum Dibayar.';
    } else {
        $denda->update([
            'keterangan' => 'Sudah Dibayar',
            'tanggal_dibayar' => Carbon::now(),
        ]);
        $pesan = 'Pembayaran denda tunai berhasil dikonfirmasi!';
    }

    return redirect()->back()->with('success', $pesan);
}

public function store(Request $request)
{
    if (strtoupper(auth()->user()->peran) === 'SISWA') {
        abort(403, 'Unauthorized action.');
    }

    $request->validate([
        'id_peminjaman'   => 'required|exists:tabel_peminjaman,id_peminjaman',
        'nominal'         => 'required|numeric|min:0',
        'jumlah_hari'     => 'nullable|integer|min:0', // Input jumlah hari terlambat
        'keterangan_buku' => 'nullable|string',
    ]);

    // Simpan data denda khusus keterlambatan
    Denda::create([
        'id_peminjaman'         => $request->id_peminjaman,
        'jenis_denda'           => 'KETERLAMBATAN', // Ditetapkan langsung secara otomatis
        'jumlah_hari_terlambat' => $request->jumlah_hari ?? 0,
        'nominal_keterlambatan' => $request->nominal,
        'nominal_kerusakan'     => 0, 
        'total_denda'           => $request->nominal,      
        'keterangan'            => $request->keterangan_buku ?? 'Keterlambatan pengembalian buku',
        'status_pembayaran'     => 'BELUM BAYAR',
    ]);

    return redirect()->route('denda.index')->with('success', 'Data denda keterlambatan berhasil ditambahkan!');
}

public function update(Request $request, $id)
{
    $denda = Denda::findOrFail($id);
    $denda->keterangan = 'Belum Dibayar';
    
    $denda->save();

    return redirect()->back()->with('success', 'Status denda berhasil dibatalkan/diubah!');
}
}