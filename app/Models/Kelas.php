<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'tabel_kelas';
    protected $primaryKey = 'id_kelas';

    // Matikan timestamps karena tabel_kelas tidak memiliki kolom created_at/updated_at
    public $timestamps = false;

    protected $fillable = [
        'nama_kelas',
        'nama_jurusan',
    ];
}