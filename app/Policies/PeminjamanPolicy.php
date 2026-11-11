<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Peminjaman;

class PeminjamanPolicy
{
    public function view(User $user, Peminjaman $peminjaman): bool
    {
        if (in_array($user->role, ['ADMIN', 'PETUGAS'])) {
            return true;
        }
        return $user->nis_siswa === $peminjaman->id_siswa; 
    }
}