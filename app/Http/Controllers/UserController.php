<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $daftarPengguna = User::orderBy('id_user', 'DESC')->get();
        return view('pengguna.index', compact('daftarPengguna'));
    }

    public function create()
    {
        return view('pengguna.create');
    }

public function store(Request $request)
{
    $request->validate([
        'role'         => 'required',
        'nama_lengkap' => 'required|string|max:255',
        'username'     => 'required|string|max:255|unique:users', 
        'password'     => 'required|min:4',
        
        'nis_siswa'    => 'required_if:role,Siswa',
        'id_kelas'     => 'required_if:role,Siswa',
    ], [
        'role.required'         => 'Silakan pilih hak akses.',
        'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
        'username.required'     => 'Username / Email wajib diisi.',
        'password.required'     => 'Password wajib diisi.',
        'password.min'          => 'Password minimal harus 4 karakter.',
        'nis_siswa.required_if' => 'NIS wajib diisi untuk akun siswa.',
        'id_kelas.required_if'  => 'Kelas / Jurusan wajib dipilih.',
    ]);

}
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pengguna.edit', compact('user')); 
    }

    public function update(Request $request, $id)
{
    $user = User::where('id_user', $id)->firstOrFail();

    $request->validate([
        'nama_user' => 'required|string|max:255',
        'username'  => 'required|string|max:255',
        'email'     => 'nullable|email|max:255',
        'peran'     => 'required|in:SISWA,PETUGAS,ADMIN',
    ]);

    $user->nama_user = $request->nama_user;
    $user->username  = $request->username;
    $user->email     = $request->email;
    $user->peran     = $request->peran;

    if ($request->filled('password_user')) {
        $user->password_user = Hash::make($request->password_user);
    }

    $user->save();

    if (auth()->check() && auth()->id() == $user->id_user) {
        auth()->setUser($user->fresh());
    }

    return redirect()->route('pengguna.index')->with('success', 'Data pengguna berhasil diperbarui!');
}

    public function destroy($id)
    {
        $pengguna = User::findOrFail($id);
        $pengguna->delete();

        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil dihapus!');
    }
}