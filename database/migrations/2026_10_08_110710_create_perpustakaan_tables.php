<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user', function (Blueprint $t) {
            $t->id('id_user');
            $t->string('nama_user', 100)->unique();
            $t->string('password_user');
            $t->enum('peran', ['SISWA', 'PETUGAS', 'ADMIN'])->default('SISWA');
            $t->rememberToken();
            $t->timestamps();
        });

        Schema::create('tabel_kelas', function (Blueprint $t) {
            $t->id('id_kelas');
            $t->string('nama_kelas', 100);
        });

        Schema::create('tabel_jurusan', function (Blueprint $t) {
            $t->id('id_jurusan');
            $t->string('nama_jurusan', 100);
        });

        Schema::create('tabel_siswa', function (Blueprint $t) {
            $t->unsignedInteger('nis_siswa')->primary();
            $t->string('nama_siswa', 100);
            $t->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $t->text('alamat');
            $t->string('no_telepon', 13);
            $t->foreignId('id_kelas')->constrained('tabel_kelas', 'id_kelas');
            $t->foreignId('id_jurusan')->constrained('tabel_jurusan', 'id_jurusan');
            $t->foreignId('id_user')->unique()->constrained('user', 'id_user')->cascadeOnDelete();
        });

        Schema::create('tabel_kategori', function (Blueprint $t) {
            $t->id('id_kategori');
            $t->string('nama_kategori', 100)->unique();
            $t->text('deskripsi')->nullable();
        });

        Schema::create('tabel_buku', function (Blueprint $t) {
            $t->id('id_buku');
            $t->foreignId('id_kategori')->constrained('tabel_kategori', 'id_kategori');
            $t->string('judul_buku', 100);
            $t->string('penulis', 100);
            $t->year('tahun_terbit');
            $t->string('lokasi_rak_buku', 50);
            $t->string('ddc', 20)->nullable();
            $t->unsignedSmallInteger('stok_tersedia')->default(0);
            $t->string('cover')->nullable();
        });

        Schema::create('tabel_peminjaman', function (Blueprint $t) {
            $t->id('id_peminjaman');
            $t->unsignedInteger('id_siswa');
            $t->foreign('id_siswa')->references('nis_siswa')->on('tabel_siswa');
            $t->foreignId('id_buku')->constrained('tabel_buku', 'id_buku');
            $t->foreignId('id_user')->constrained('user', 'id_user');
            $t->dateTime('tanggal_pinjam');
            $t->date('tenggat_waktu');
            $t->date('tanggal_kembali')->nullable();
            $t->enum('status', ['RESERVASI', 'DIPINJAM', 'DIKEMBALIKAN', 'TERLAMBAT', 'DIBATALKAN']);
        });

        Schema::create('tabel_detail_peminjaman', function (Blueprint $t) {
            $t->id('id_detail_peminjaman');
            $t->foreignId('id_peminjaman')->constrained('tabel_peminjaman', 'id_peminjaman')->cascadeOnDelete();
            $t->foreignId('id_buku')->constrained('tabel_buku', 'id_buku');
            $t->tinyInteger('jumlah')->default(1);
            $t->enum('status_buku', ['DIPINJAM', 'DIKEMBALIKAN', 'HILANG']);
        });

        Schema::create('tabel_pengembalian', function (Blueprint $t) {
            $t->id('id_pengembalian');
            $t->foreignId('id_peminjaman')->unique()->constrained('tabel_peminjaman', 'id_peminjaman')->cascadeOnDelete();
            $t->foreignId('id_user')->constrained('user', 'id_user');
            $t->date('tanggal_kembali');
            $t->enum('kondisi_buku', ['baik', 'rusak ringan', 'rusak berat', 'hilang']);
            $t->unsignedInteger('denda')->default(0);
            $t->enum('status_pembayaran', ['LUNAS', 'BELUM LUNAS']);
        });

        Schema::create('tabel_denda', function (Blueprint $t) {
            $t->id('id_denda');
            $t->foreignId('id_pengembalian')->constrained('tabel_pengembalian', 'id_pengembalian')->cascadeOnDelete();
            $t->enum('jenis_denda', ['KETERLAMBATAN', 'KERUSAKAN', 'KEHILANGAN', 'KETERLAMBATAN_KERUSAKAN_DAN_KEHILANGAN']);
            $t->unsignedInteger('jumlah_hari_terlambat')->default(0);
            $t->unsignedInteger('nominal_keterlambatan')->default(0);
            $t->unsignedInteger('nominal_kerusakan')->default(0);
            $t->unsignedInteger('total_denda')->default(0);
            $t->text('keterangan')->nullable();
            $t->date('tanggal_dibayar')->nullable();
        });
    }

    public function down()
    {
        foreach (['tabel_denda', 'tabel_pengembalian', 'tabel_detail_peminjaman', 'tabel_peminjaman',
                  'tabel_buku', 'tabel_kategori', 'tabel_siswa', 'tabel_jurusan', 'tabel_kelas', 'user'] as $table) {
            Schema::dropIfExists($table);
        }
    }
};