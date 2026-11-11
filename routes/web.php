<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboard;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboard;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\DendaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PenggunaController;


// Halaman utama di arahkan ke Login
Route::get('/', function () {
    return redirect()->route('login');
});

// Route Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route Khusus Siswa (yang sudah login)
Route::middleware(['auth'])->group(function () {
    Route::get('/siswa/dashboard', [SiswaDashboard::class, 'index'])->name('siswa.dashboard');
});

// Route Khusus Petugas (yang sudah login)
Route::middleware(['auth'])->group(function () {
    Route::get('petugas/dashboard', [PetugasDashboard::class, 'index'])->name('petugas.dashboard');
    Route::get('petugas/buku', [BukuController::class, 'index'])->name('petugas.buku.index');
    Route::get('petugas/laporan', [LaporanController::class, 'index'])->name('petugas.laporan');
    
    Route::get('petugas/kategori', [KategoriController::class, 'index'])->name('petugas.kategori.index');
    Route::get('petugas/kelas', [KelasController::class, 'index'])->name('petugas.kelas.index');
    Route::get('/denda', [DendaController::class, 'index'])->name('denda.index');
    Route::patch('/denda/bayar/{id}', [DendaController::class, 'bayar'])->name('denda.bayar');
});

// Route Khusus Admin (Ditambahkan route untuk kelola pengguna admin)
Route::middleware(['auth'])->group(function () {
    Route::get('admin/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');
    
    // Tambahan agar menu "Kelola Pengguna" di sidebar admin tidak error:
    Route::get('admin/users', [UserController::class, 'index'])->name('admin.users.index');
});

// Route Umum / Buku / Kategori / Rekomendasi
Route::middleware(['auth'])->group(function () {
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');

    Route::get('/buku/reservasi/{id}', [BukuController::class, 'reservasi'])->name('buku.reservasi');
    Route::get('/buku/rekomendasi/kelola', [BukuController::class, 'kelolaRekomendasi'])->name('buku.rekomendasi');
    Route::post('/buku/rekomendasi/toggle/{id}', [BukuController::class, 'toggleRekomendasi'])->name('buku.toggleRekomendasi');

    // Route halaman data buku (CRUD Lengkap), Kelas, Denda, Pengguna
    Route::resource('buku', BukuController::class);
    Route::resource('kelas', KelasController::class);
    Route::resource('denda', DendaController::class);
    Route::resource('pengguna', UserController::class);

    Route::post('/buku/reservasi/{id}', [PeminjamanController::class, 'reservasiCepat'])->name('reservasi.store');
    
    Route::get('/petugas/peminjaman', [PeminjamanController::class, 'indexPetugas'])->name('petugas.peminjaman');
    Route::post('/petugas/peminjaman/setujui/{id}', [PeminjamanController::class, 'setujui'])->name('petugas.peminjaman.setujui');

    Route::patch('/peminjaman/{id}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');

    Route::post('/petugas/peminjaman/kembalikan/{id}', [PeminjamanController::class, 'kembalikan'])->name('petugas.peminjaman.kembalikan'); 
    Route::delete('/peminjaman/{id}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');

    // Route untuk Laporan Peminjaman (Admin & Petugas)
    Route::get('/petugas/laporan', [LaporanController::class, 'index'])->name('petugas.laporan');
    Route::get('/petugas/laporan/cetak', [LaporanController::class, 'cetak'])->name('petugas.laporan.cetak');
    Route::get('/admin/laporan', [LaporanController::class, 'index'])->name('admin.laporan');
    
    // Route SiswaController
    Route::middleware(['auth'])->group(function () {
    // Bisa diakses petugas & admin
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');

    // Route PenggunaController
    Route::middleware(['auth'])->group(function () {
    Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna.index');
    Route::get('/pengguna/create', [PenggunaController::class, 'create'])->name('pengguna.create');
    Route::post('/pengguna', [PenggunaController::class, 'store'])->name('pengguna.store');
});
});
});