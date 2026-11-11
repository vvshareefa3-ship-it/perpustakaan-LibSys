<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LibSys | Pilih Kategori Buku</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen">
    
    <!-- Header -->
    <div class="bg-slate-900 shadow-sm mb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center text-white">
            <span class="text-xl font-bold">📚 LibSys | Katalog Buku</span>
            
            @php
                $peran = strtoupper(auth()->user()->peran ?? '');
                $dashboardRoute = route('login');
                
                if($peran == 'ADMIN') {
                    $dashboardRoute = route('admin.dashboard');
                } elseif($peran == 'PETUGAS') {
                    $dashboardRoute = route('petugas.dashboard');
                } else {
                    $dashboardRoute = route('siswa.dashboard');
                }
            @endphp

            <a href="{{ $dashboardRoute }}" class="bg-slate-800 text-white px-4 py-2 rounded-full text-xs font-semibold hover:bg-slate-700 transition border border-slate-700">
                ← Kembali ke Dashboard
            </a>
        </div>
    </div>

    <!-- Konten Pilihan Kategori -->
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-slate-800">Silakan Pilih Kategori Buku</h2>
            <p class="text-sm text-slate-500 mt-1">Pilih salah satu kategori di bawah ini untuk melihat daftar koleksi buku.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Buku Cerita & Dongeng -->
            <a href="{{ route('buku.index', ['kategori' => 'novel']) }}" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 hover:border-blue-500 hover:shadow-md transition group">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl font-bold group-idx group-hover:bg-blue-600 group-hover:text-white transition">📖</div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-800 group-hover:text-blue-600 transition">Buku Cerita & Dongeng</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Koleksi novel, pengetahuan umum, dan bacaan bebas lainnya.</p>
                    </div>
                </div>
            </a>

            <!-- Buku Kelas 10 -->
            <a href="{{ route('buku.index', ['kategori' => 'kelas_10']) }}" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 hover:border-emerald-500 hover:shadow-md transition group">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-bold group-hover:bg-emerald-600 group-hover:text-white transition">10</div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-800 group-hover:text-emerald-600 transition">Buku Kelas 10</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Paket buku pelajaran sekolah khusus tingkat kelas 10.</p>
                    </div>
                </div>
            </a>

            <!-- Buku Kelas 11 -->
            <a href="{{ route('buku.index', ['kategori' => 'kelas_11']) }}" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 hover:border-amber-500 hover:shadow-md transition group">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl font-bold group-hover:bg-amber-600 group-hover:text-white transition">11</div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-800 group-hover:text-amber-600 transition">Buku Kelas 11</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Paket buku pelajaran sekolah khusus tingkat kelas 11.</p>
                    </div>
                </div>
            </a>

            <!-- Buku Kelas 12 -->
            <a href="{{ route('buku.index', ['kategori' => 'kelas_12']) }}" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 hover:border-purple-500 hover:shadow-md transition group">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl font-bold group-hover:bg-purple-600 group-hover:text-white transition">12</div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-800 group-hover:text-purple-600 transition">Buku Kelas 12</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Paket buku pelajaran sekolah khusus tingkat kelas 12.</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

</body>
</html>