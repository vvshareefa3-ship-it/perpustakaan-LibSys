<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LibSys | Edit Pengguna</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen">
    
    <!-- Header & Navigasi Atas -->
    <div class="bg-slate-900 shadow-sm mb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center text-white">
            <div class="flex items-center gap-2">
                <span class="text-xl font-bold">👥 LibSys | Edit Pengguna</span>
            </div>
            
            <!-- Tombol Kembali -->
            <div>
                <!-- Sesuaikan route kembali (misal: admin.users.index) -->
                <a href="{{ route('pengguna.index') }}" class="inline-flex items-center gap-2 bg-slate-800 text-white px-4 py-2 rounded-full text-xs font-semibold hover:bg-slate-700 transition shadow-sm border border-slate-700">
                    ← Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Konten Utama Form Edit -->
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
            <h2 class="text-xl font-bold text-slate-800 mb-1">Edit Akun Pengguna</h2>
            <p class="text-xs text-slate-500 mb-6">Perbarui informasi data diri atau hak akses peran pengguna.</p>

            <!-- PERHATIKAN ACTION ROUTE DIBAWAH INI -->
            <form action="{{ route('pengguna.update', $user->id_user) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Nama Lengkap -->
                <div class="mb-4">
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="nama_user" value="{{ old('nama_user', $user->nama_user ?? '') }}" required 
                           class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-50">
                </div>

                <!-- Username -->
                <div class="mb-4">
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-2">Username</label>
                    <input type="text" name="username" value="{{ old('username', $user->username ?? '') }}" required 
                           class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-50">
                </div>

                <!-- 1. TAMBAHKAN INPUT EMAIL DI SINI -->
                <div class="mb-4">
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" 
                           class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-50" placeholder="nama@email.com">
                </div>

                <!-- Peran (Role) -->
                <div class="mb-4">
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-2">Peran (Role)</label>
                    <select name="peran" required class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-50">
                        <option value="ADMIN" {{ (old('peran', $user->peran ?? '') == 'ADMIN') ? 'selected' : '' }}>ADMIN</option>
                        <option value="PETUGAS" {{ (old('peran', $user->peran ?? '') == 'PETUGAS') ? 'selected' : '' }}>PETUGAS</option>
                        <option value="SISWA" {{ (old('peran', $user->peran ?? '') == 'SISWA') ? 'selected' : '' }}>SISWA</option>
                    </select>
                </div>

                <!-- 2. TAMBAHKAN INPUT PASSWORD BARU (OPSIONAL) -->
                <div class="mb-6">
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-2">Password Baru <span class="text-slate-400 font-normal lowercase">(kosongkan jika tidak ingin diubah)</span></label>
                    <input type="password" name="password_user" 
                           class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-50" placeholder="********">
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-end gap-3">
                    <a href="{{ route('pengguna.index') }}" class="px-5 py-2.5 text-xs font-semibold text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 text-xs font-bold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition shadow-sm">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>