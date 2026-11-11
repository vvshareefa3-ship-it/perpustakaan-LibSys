<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    // Menampilkan daftar pengguna
    public function index()
    {
        $daftarPengguna = User::all();
        return view('pengguna.index', compact('daftarPengguna'));
    }

    // Menampilkan form tambah pengguna
    public function create()
    {
        return view('pengguna.create');
    }

    // Menyimpan data pengguna baru (termasuk kondisi dinamis Siswa / Petugas)
    public function store(Request $request)
    {
        $request->validate([
            'nama_user'     => 'required|string|max:255',
            'username'      => 'required|string|max:255|unique:tabel_user,username', 
            'email'         => 'required|email|max:255|unique:tabel_user,email',   
            'peran'         => 'required|in:SISWA,PETUGAS,ADMIN',
            'password_user' => 'required|min:8',
        ]);

        // 1. Simpan ke tabel_user utama (Perbaiki mapping data di sini)
        $user = User::create([
            'nama_user'     => $request->nama_user,
            'username'      => $request->username, // Ditambahkan agar username tersimpan
            'email'         => $request->email,    // Diperbaiki dari $request->username
            'password_user' => Hash::make($request->password_user),
            'peran'         => $request->peran,
        ]);

        // 2. Jika role yang dipilih SISWA, simpan juga ke tabel siswa
        if ($request->peran == 'SISWA') {
            Siswa::create([
                'id_siswa'   => $request->nis,
                'nama_siswa' => $request->nama_user, 
                'nis_siswa'  => $request->nis,
                'id_kelas'   => $request->id_kelas,
                'id_user'    => $user->id_user,
                'alamat'     => '-',
                'no_telepon' => '-',
                'id_jurusan' => '-',
            ]);
        }

        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil ditambahkan!');
    }
}