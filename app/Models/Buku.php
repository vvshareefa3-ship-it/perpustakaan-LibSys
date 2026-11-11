<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'tabel_buku'; 
    protected $primaryKey = 'id_buku'; 

    public $timestamps = false;

    protected $fillable = [
        'judul_buku',
        'penulis',
        'tahun_terbit',
        'lokasi_rak_buku',
        'stok_tersedia',
        'kategori',
        'is_rekomendasi'
    ];
}