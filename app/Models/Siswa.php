<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'tabel_siswa';
    protected $primaryKey = 'nis_siswa';
    public $incrementing = false; 
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'nis_siswa',
        'nama_siswa',
        'jenis_kelamin',
        'alamat',
        'no_telepon',
        'id_kelas',
        'id_user',
    ];

    // Relasi ke tabel_user
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    // Relasi ke tabel_kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    public function peminjaman()
{
    // Sesuaikan foreign key ('id_siswa' atau 'nis') dengan kolom di database Anda
    return $this->hasMany(Peminjaman::class, 'nis_siswa', 'nama_siswa'); 
}
}