<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denda extends Model
{
    use HasFactory;

    protected $table = 'tabel_denda';
    protected $primaryKey = 'id_denda';
    
    protected $fillable = [
        'id_peminjaman',
        'jenis_denda',
        'jumlah_hari_terlambat',
        'nominal_keterlambatan',
        'nominal_kerusakan',
        'total_denda',
        'keterangan',
        'tanggal_dibayar'
    ];

    // Relasi ke tabel_peminjaman
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }
}