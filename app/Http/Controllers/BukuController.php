<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Siswa;

class BukuController extends Controller
{
    public function index(Request $request)
{
    $kategori = $request->get('kategori');
    $search = $request->get('cari'); // Ambil keyword pencarian dari input form
    $query = Buku::query();
    
    // Filter berdasarkan kategori jika ada
    if ($kategori) {
        $query->where('kategori', $kategori);
    }
    
    // Filter berdasarkan pencarian (Judul Buku atau Penulis)
    if ($search) {
        $query->where(function($q) use ($search) {
            $q->where('judul_buku', 'LIKE', "%{$search}%")
              ->orWhere('penulis', 'LIKE', "%{$search}%");
        });
    }

    $daftarBuku = $query->get();
    $user = auth()->user();
    $bukuDipinjamIds = [];

    if ($user && $user->peran == 'SISWA') {
        $siswa = Siswa::where('id_user', $user->id ?? $user->id_user)->first()
              ?? Siswa::where('nis_siswa', $user->username)->first();

        if ($siswa) {
            $bukuDipinjamIds = Peminjaman::where('id_siswa', $siswa->nis_siswa)
                ->whereIn('status', ['PENDING', 'DIPINJAM'])
                ->pluck('id_buku')
                ->toArray();
        }
    }

    return view('buku.index', compact('daftarBuku', 'kategori', 'bukuDipinjamIds'));
}

    public function create(Request $request)
{
    $kategori = $request->kategori ?? 'bebas';
    return view('buku.create', compact('kategori'));
}

   public function store(Request $request)
{
    $request->validate([
        'judul_buku' => 'required|string|max:255',
        'lokasi_rak_buku' => 'nullable|string',
        'stok_tersedia' => 'required|integer|min:0',
        'kategori' => 'nullable|string',
    ]);

    $kategori = $request->kategori ?? 'bebas';

    Buku::create([
        'judul_buku'      => $request->judul_buku,
        'lokasi_rak_buku' => $request->lokasi_rak_buku,
        'stok_tersedia'   => $request->stok_tersedia,
        'kategori'        => $kategori,
        'penulis'         => $request->penulis ?? '-',
        'tahun_terbit'    => $request->tahun_terbit ?? date('Y'),
        'is_rekomendasi'  => 0,
    ]);

    return redirect()->route('buku.index', ['kategori' => $kategori])
                     ->with('success', 'Buku berhasil ditambahkan!');
}

    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        return view('buku.edit', compact('buku'));
    }

    public function update(Request $request, $id)
{
    $buku = Buku::findOrFail($id);

    $request->validate([
        'judul_buku' => 'required|string|max:255',
        'lokasi_rak_buku' => 'nullable|string',
        'stok_tersedia' => 'required|integer|min:0',
    ]);

    $buku->update([
        'judul_buku'      => $request->judul_buku,
        'lokasi_rak_buku' => $request->lokasi_rak_buku,
        'stok_tersedia'   => $request->stok_tersedia,
        'penulis'         => $request->penulis ?? $buku->penulis,
        'tahun_terbit'    => $request->tahun_terbit ?? $buku->tahun_terbit,
    ]);

    return redirect()->route('buku.index', ['kategori' => $buku->kategori])
                     ->with('success', 'Buku berhasil diperbarui!');
}

    public function kelolaRekomendasi()
    {
        $daftarBuku = Buku::all();
        return view('buku.rekomendasi', compact('daftarBuku'));
    }

    public function toggleRekomendasi($id)
    {
    $buku = Buku::where('id_buku', $id)->firstOrFail();

    $buku->is_rekomendasi = ($buku->is_rekomendasi == 1) ? 0 : 1;
    $buku->save();

    return redirect()->back()->with('success', 'Status rekomendasi buku berhasil diperbarui!');
    }

   public function reservasi($id)
    {
        $user = auth()->user();
        
        $siswa = Siswa::where('nis_siswa', $user->username)->first() ?? Siswa::where('id_user', $user->id ?? $user->id_user)->first();

        if (!$siswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
        }

        $buku = Buku::where('id_buku', $id)->firstOrFail();
        if ($buku->stok_tersedia <= 0) {
            return redirect()->back()->with('error', 'Maaf, stok buku ini sedang habis.');
        }

        Peminjaman::create([
            'id_user' => $user->id ?? $user->id_user, 
            'id_siswa' => $siswa->nis_siswa,
            'id_buku' => $buku->id_buku,
            'tanggal_pinjam' => now(),
            'tenggat_waktu' => now()->addDays(7),
            'status' => 'PENDING', 
        ]);

        return redirect()->back()->with('success', 'Reservasi berhasil diajukan! Menunggu persetujuan petugas.');
    }

    public function destroy($id)
{
    $buku = Buku::where('id_buku', $id)->firstOrFail();
    $kategori = $buku->kategori;
    $buku->delete();

    return redirect()->route('buku.index', ['kategori' => $kategori])
                     ->with('success', 'Buku berhasil dihapus!');
}
    
}