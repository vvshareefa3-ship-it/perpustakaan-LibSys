<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'tabel_user';
    protected $primaryKey = 'id_user';

    public $timestamps = false;

    protected $fillable = [
        'nama_user',
        'username',     
        'email', 
        'password_user',
        'peran',
    ];

    protected $hidden = [
        'password_user',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->password_user;
    }

    public function siswa()
    {
        return $this->hasOne(Siswa::class, 'id_user', 'id_user');
    }
}