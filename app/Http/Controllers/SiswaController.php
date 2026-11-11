<?php

namespace App\Controllers\Http;
namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');

    // Ambil data siswa beserta relasi kelas, dan filter jika ada pencarian nama/NIS
    $siswa = Siswa::with('kelas')
        ->when($search, function ($query, $search) {
            return $query->where('nama_siswa', 'like', "%{$search}%")
                         ->orWhere('nis_siswa', 'like', "%{$search}%");
        })
        ->get();

    return view('siswa.index', compact('siswa', 'search'));
}
}