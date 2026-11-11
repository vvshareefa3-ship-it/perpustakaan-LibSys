<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'tabel_peminjaman';
    protected $primaryKey = 'id_peminjaman';

    public $timestamps = false;

    protected $fillable = [
        'id_siswa',
        'id_user',
        'id_buku',
        'tanggal_pinjam',
        'tanggal_kembali',
        'tenggat_waktu',
        'status',
    ];

    protected static function booted()
    {
        static::deleting(function ($peminjaman) {
            // Jika statusnya PENDING, RESERVASI, atau DIPINJAM saat dihapus, 
            // kembalikan stok buku secara otomatis.
            if (in_array($peminjaman->status, ['PENDING', 'RESERVASI', 'DIPINJAM'])) {
                $buku = $peminjaman->buku;
                if ($buku) {
                    $buku->increment('stok_tersedia');
                }
            }
        });
    }

    public function user()
    {
    return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku', 'id_buku'); 
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'nis_siswa');
    }
}