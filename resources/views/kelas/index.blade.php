<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LibSys | Manajemen Kelas</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen">
    
    <!-- Header & Navigasi Atas -->
    <!-- Header & Navigasi Atas dengan latar belakang gelap khas LibSys -->
<div class="bg-slate-900 shadow-sm mb-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center text-white">
        <div class="flex items-center gap-2">
            <span class="text-xl font-bold">🏢 LibSys | Manajemen Kelas</span>
        </div>
        
        <!-- Tombol Kembali ke Dashboard -->
        <div>
            @if(auth()->user()->peran === 'ADMIN')
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 bg-slate-800 text-white px-4 py-2 rounded-full text-xs font-semibold hover:bg-slate-700 transition shadow-sm border border-slate-700">
                    ← Kembali ke Dashboard
                </a>
            @elseif(auth()->user()->peran === 'PETUGAS')
                <a href="{{ route('petugas.dashboard') }}" class="inline-flex items-center gap-2 bg-slate-800 text-white px-4 py-2 rounded-full text-xs font-semibold hover:bg-slate-700 transition shadow-sm border border-slate-700">
                    ← Kembali ke Dashboard
                </a>
            @else
                <a href="{{ route('siswa.dashboard') }}" class="inline-flex items-center gap-2 bg-slate-800 text-white px-4 py-2 rounded-full text-xs font-semibold hover:bg-slate-700 transition shadow-sm border border-slate-700">
                    ← Kembali ke Dashboard
                </a>
            @endif
        </div>
    </div>
</div>

    <!-- Konten Utama -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                <div>
                    <h2 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                        Daftar Kelas & Jurusan
                    </h2>
                    <p class="text-xs text-slate-500 mt-1">Kelola data kelas siswa perpustakaan.</p>
                </div>

                {{-- Tombol Tambah Kelas (Hanya untuk Admin & Petugas) --}}
                @if(auth()->user()->peran === 'ADMIN' || auth()->user()->peran === 'PETUGAS')
                    <a href="{{ route('kelas.create') }}" class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-blue-700 transition shadow-sm">
                        + Tambah Kelas
                    </a>
                @endif
            </div>

            {{-- Tabel Data --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-900 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider rounded-l-xl">No</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Nama Kelas</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Jurusan</th>
                            @if(auth()->user()->peran === 'ADMIN' || auth()->user()->peran === 'PETUGAS')
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider rounded-r-xl">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @foreach($data as $key => $item)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">{{ $key + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-900">{{ $item->nama_kelas }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                <span class="px-3 py-1 text-xs font-medium bg-slate-100 text-slate-700 rounded-full border border-slate-200">
                                    {{ $item->nama_jurusan }}
                                </span>
                            </td>
                            
                            {{-- Kolom Aksi Tombol Edit & Hapus (Sama persis seperti menu Buku) --}}
                            @if(auth()->user()->peran === 'ADMIN' || auth()->user()->peran === 'PETUGAS')
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex items-center gap-2">
                                {{-- Tombol Edit --}}
                                <a href="{{ route('kelas.edit', $item) }}" class="inline-flex items-center gap-1 px-3 py-1 text-xs font-semibold text-amber-600 bg-amber-50 border border-amber-200 rounded-full hover:bg-amber-100 transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Edit
                                </a>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('kelas.destroy', $item) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 px-3 py-1 text-xs font-semibold text-rose-600 bg-rose-50 border border-rose-200 rounded-full hover:bg-rose-100 transition" onclick="return confirm('Yakin ingin menghapus kelas ini?')">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        Hapus
                                    </button>
                                </form>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>