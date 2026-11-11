<!DOCTYPE html>
<html lang="id"><head><meta charset="utf-8"><meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover" name="viewport"><meta content="mobile_stack" name="shell-type"><link href="https://fonts.googleapis.com/css2?family=Literata:ital,opsz,wght@0,7..72,500;0,7..72,600;1,7..72,500&amp;family=Manrope:wght@400;500;600;700&amp;display=swap" rel="stylesheet"><link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"><style>@layer base{html,body{width:100vw;margin:0;padding:0;}body{overscroll-behavior:none;}.pb-safe{padding-bottom:env(safe-area-inset-bottom,0px);}.pt-safe{padding-top:env(safe-area-inset-top,0px);}main>:first-child{margin-top:0!important;}main>:last-child{margin-bottom:0!important;}}::-webkit-scrollbar{display:none;}</style><script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script><script id="tailwind-config">tailwind.config = { darkMode: "class", theme: { extend: { colors: { "on-secondary": "#ffffff", "inverse-surface": "#2d3133", "tertiary-container": "#00301f", "on-background": "#191c1e", "surface-tint": "#545f73", "on-primary-container": "#8590a6", "on-error": "#ffffff", "tertiary": "#00190e", "inverse-primary": "#bcc7de", "on-secondary-fixed": "#2f1500", "secondary-fixed": "#ffdcc3", "on-secondary-container": "#663500", "on-tertiary-fixed-variant": "#005137", "on-error-container": "#93000a", "surface-variant": "#e0e3e5", "tertiary-fixed": "#85f8c4", "surface-bright": "#f7f9fb", "outline": "#75777d", "surface-container": "#eceef0", "secondary": "#904d00", "on-tertiary-fixed": "#002114", "primary-fixed-dim": "#bcc7de", "on-primary-fixed-variant": "#3c475a", "error": "#ba1a1a", "inverse-on-surface": "#eff1f3", "on-tertiary": "#ffffff", "on-primary": "#ffffff", "on-tertiary-container": "#24a375", "on-primary-fixed": "#111c2d", "surface-container-high": "#e6e8ea", "on-surface-variant": "#45474c", "tertiary-fixed-dim": "#68dba9", "surface-container-highest": "#e0e3e5", "surface-dim": "#d8dadc", "primary-fixed": "#d8e3fb", "secondary-fixed-dim": "#ffb77d", "surface-container-lowest": "#ffffff", "background": "#f7f9fb", "outline-variant": "#c5c6cd", "error-container": "#ffdad6", "primary-container": "#1e293b", "on-secondary-fixed-variant": "#6e3900", "surface-container-low": "#f2f4f6", "secondary-container": "#fe932c", "on-surface": "#191c1e", "surface": "#f7f9fb", "primary": "#091426" }, borderRadius: { "DEFAULT": "0.125rem", "lg": "0.25rem", "xl": "0.5rem", "full": "0.75rem" }, spacing: { "space-xs": "0.25rem", "margin": "2rem", "margin-mobile": "1rem", "gutter-mobile": "1rem", "space-xl": "2.5rem", "gutter": "1.5rem", "space-lg": "1.5rem", "space-md": "1rem", "space-sm": "0.5rem" }, fontFamily: { "body-md": ["Manrope"], "headline-lg-mobile": ["Literata"], "label-md": ["Manrope"], "title-md": ["Manrope"], "body-lg": ["Manrope"], "label-sm": ["Manrope"], "headline-sm": ["Literata"], "headline-md": ["Literata"], "body-sm": ["Manrope"], "display-lg": ["Literata"], "headline-lg": ["Literata"], "display-lg-mobile": ["Literata"] }, fontSize: { "body-md": ["14px", { "lineHeight": "22px", "fontWeight": "400" }], "headline-lg-mobile": ["24px", { "lineHeight": "32px", "letterSpacing": "0em", "fontWeight": "600" }], "label-md": ["12px", { "lineHeight": "16px", "letterSpacing": "0.04em", "fontWeight": "600" }], "title-md": ["16px", { "lineHeight": "24px", "letterSpacing": "0.005em", "fontWeight": "600" }], "body-lg": ["16px", { "lineHeight": "26px", "fontWeight": "400" }], "label-sm": ["11px", { "lineHeight": "14px", "letterSpacing": "0.05em", "fontWeight": "600" }], "headline-sm": ["20px", { "lineHeight": "28px", "fontWeight": "500" }], "headline-md": ["24px", { "lineHeight": "32px", "fontWeight": "500" }], "body-sm": ["12px", { "lineHeight": "18px", "fontWeight": "400" }], "display-lg": ["48px", { "lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "600" }], "headline-lg": ["32px", { "lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "600" }], "display-lg-mobile": ["32px", { "lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "600" }] } } } };</script><style>
    body {
      min-height: max(884px, 100dvh);
    }
  </style>
</head><body class="bg-surface font-body-md text-body-md text-on-surface antialiased flex flex-col min-h-screen"><header class="fixed top-0 w-full z-50 pt-safe bg-surface/80 backdrop-blur-xl shadow-[0_1px_8px_rgba(0,0,0,0.04)]"><div class="h-16 px-gutter-mobile flex items-center justify-between gap-space-sm"><div class="flex items-center gap-space-xs"><button aria-label="Kembali" class="w-11 h-11 flex items-center justify-center rounded-lg text-on-surface hover:bg-surface-container-high transition-colors" onclick="history.back()" type="button"><span class="material-symbols-outlined text-[22px]">arrow_back</span></button><div class="flex flex-col"><h1 class="font-headline-sm text-headline-sm text-on-surface leading-tight truncate">Reservasi Buku</h1></div></div><div class="flex items-center gap-space-sm"><div aria-label="Profil Pengguna" class="w-8 h-8 rounded-full bg-primary flex items-center justify-center shrink-0"><span class="material-symbols-outlined text-on-primary text-[18px]">person</span></div></div></div></header><main class="flex flex-col relative w-full pt-16 pb-safe bg-surface min-h-screen"><div class="flex flex-col w-full px-gutter-mobile pb-space-xl">
<!-- Progress / Flow Bar Tracker -->
<div class="mt-space-md mb-space-sm bg-surface-container-low rounded-xl p-space-md shadow-sm">
<div class="flex items-center justify-between mb-space-xs">
<div class="flex items-center gap-space-xs">
<span class="w-6 h-6 rounded-full bg-primary flex items-center justify-center text-on-primary font-label-sm text-label-sm font-semibold">1</span>
<span class="font-label-md text-label-md text-primary font-semibold tracking-wide uppercase">Langkah 1 dari 2</span>
</div>
<span class="font-label-sm text-label-sm text-on-surface-variant font-medium">Verifikasi Reservasi</span>
</div>
<div class="w-full bg-surface-variant h-1.5 rounded-full overflow-hidden flex">
<div class="bg-primary h-full w-1/2 rounded-full transition-all duration-300"></div>
</div>
<!-- Alert Notice Card -->
<div class="mt-space-md flex items-start gap-space-sm bg-secondary-fixed/40 p-space-sm rounded-lg text-on-secondary-fixed">
<span class="material-symbols-outlined text-[20px] text-secondary shrink-0 mt-0.5" style="font-variation-settings: 'FILL' 1;">info</span>
<p class="font-body-sm text-body-sm leading-snug">
        Buku akan disisihkan dan disimpan di Meja Sirkulasi khusus pemustaka selama <span class="font-semibold text-secondary">1x24 jam</span> setelah konfirmasi.
      </p>
</div>
</div>
<!-- Ringkasan Buku yang Direservasi -->
<div class="mt-space-sm bg-surface-container-lowest rounded-xl p-space-md shadow-sm">
<div class="flex items-center justify-between mb-space-sm">
<span class="font-label-sm text-label-sm text-secondary uppercase tracking-wider font-semibold">Koleksi Terpilih</span>
<span class="inline-flex items-center px-2 py-0.5 rounded-full text-label-sm font-label-sm bg-tertiary-fixed text-on-tertiary-fixed font-medium">
        Tersedia
      </span>
</div>
<div class="flex gap-space-md">
<!-- Book Thumbnail with rich overlay placeholder -->
<div class="relative w-24 h-36 rounded-lg overflow-hidden shrink-0 shadow-sm bg-surface-container-high">
<img alt="Sampul buku sastra Indonesia klasik Bumi Manusia karya Pramoedya Ananta Toer" class="w-full h-full object-cover" data-alt="Vintage Indonesian literature book cover of Bumi Manusia by Pramoedya Ananta Toer with warm sepia tones, classic typography, scholarly library setting with dark wood shelves in the background, soft warm lighting, academic archival aesthetic." src="https://lh3.googleusercontent.com/aida-public/AB6AXuAjFJ5Xo0Y9sra3w4ZwAPYu3bgECObyHiVqDxddVTJA4F8dY5iyOSrO5C-HxYG25bEqvjij0gCM6p93dXQlIVW3k2R6Iluma_TVBQglEgNuScLogGxRl9NOlrlSQY4_a3bePQMv6_2pTIE4WIH-OZw9rZP6VGcNxu44ZRqKDfOQqWay4hcV5pJCCaOZkwmQISYzdZt-78q0_bOqerOosb9lHJHv4yogP-rpH4Ja8FKy1G_UYXWFU7Fn">
<div class="absolute inset-0 bg-gradient-to-t from-primary/60 via-transparent to-transparent"></div>
<span class="absolute bottom-1 left-1.5 font-label-sm text-[10px] text-on-primary bg-primary/80 px-1 py-0.5 rounded">Fisik</span>
</div>
<!-- Book Metadata -->
<div class="flex flex-col justify-between flex-1 min-w-0">
<div>
<h2 class="font-headline-sm text-headline-sm text-on-surface leading-tight font-semibold line-clamp-2">
            Bumi Manusia
          </h2>
<p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">
            Pramoedya Ananta Toer
          </p>
<p class="font-label-sm text-label-sm text-outline mt-1 truncate">
            Hasta Mitra • 2022
          </p>
</div>
<div class="mt-space-xs pt-space-xs flex flex-wrap gap-1.5 items-center">
<span class="inline-flex items-center gap-1 bg-surface-container px-2 py-0.5 rounded text-label-sm font-label-sm text-on-surface-variant font-medium">
<span class="material-symbols-outlined text-[14px]">bookmark</span>
            899.221 TOE
          </span>
<span class="inline-flex items-center gap-1 bg-surface-container-high px-2 py-0.5 rounded text-label-sm font-label-sm text-primary font-semibold">
            #LIB-BUM-001
          </span>
</div>
</div>
</div>
<!-- Additional Book Attributes -->
<div class="mt-space-md grid grid-cols-2 gap-space-xs pt-space-sm bg-surface-container-low rounded-lg p-space-sm">
<div class="flex flex-col">
<span class="font-label-sm text-label-sm text-outline">Kondisi Eksemplar</span>
<span class="font-body-sm text-body-sm text-on-surface font-semibold flex items-center gap-1 mt-0.5">
<span class="material-symbols-outlined text-secondary text-[16px]">verified</span>
          Sangat Baik
        </span>
</div>
<div class="flex flex-col">
<span class="font-label-sm text-label-sm text-outline">Lokasi Rak Awal</span>
<span class="font-body-sm text-body-sm text-on-surface font-semibold flex items-center gap-1 mt-0.5">
<span class="material-symbols-outlined text-outline text-[16px]">shelves</span>
          Rak B-04 / Tk. 3
        </span>
</div>
</div>
</div>
<!-- Detail Pengambilan & Identitas Siswa -->
<div class="mt-space-md bg-surface-container-lowest rounded-xl p-space-md shadow-sm">
<div class="flex items-center justify-between mb-space-md">
<div class="flex items-center gap-space-xs">
<span class="material-symbols-outlined text-primary text-[20px]">local_library</span>
<h3 class="font-title-md text-title-md text-on-surface font-semibold">Jadwal &amp; Lokasi Pengambilan</h3>
</div>
<span class="px-2 py-0.5 rounded-full text-label-sm font-label-sm bg-secondary-fixed text-on-secondary-fixed font-semibold">
        23 Jam Tersisa
      </span>
</div>
<!-- Countdown & Pick-up Slot Card -->
<div class="bg-primary-container text-on-primary-container rounded-lg p-space-md flex flex-col gap-space-sm">
<div class="flex items-start justify-between">
<div>
<span class="font-label-sm text-label-sm text-inverse-primary uppercase tracking-wider block">Batas Akhir Mengambil</span>
<div class="font-headline-sm text-headline-sm text-on-primary font-semibold mt-0.5">
            Besok, 29 Okt 2026
          </div>
<span class="font-body-sm text-body-sm text-inverse-primary">Pukul 15.00 WIB (Sore)</span>
</div>
<div class="w-10 h-10 rounded-full bg-surface-container-lowest/10 flex items-center justify-center text-on-primary">
<span class="material-symbols-outlined text-[24px]">timer</span>
</div>
</div>
<div class="h-px bg-surface-container-highest/20 my-0.5"></div>
<div class="flex items-center gap-space-sm">
<span class="material-symbols-outlined text-secondary-container text-[20px] shrink-0">pin_drop</span>
<div class="flex flex-col">
<span class="font-label-sm text-label-sm text-inverse-primary">Titik Serah Terima:</span>
<span class="font-body-sm text-body-sm text-on-primary font-medium">Meja Sirkulasi Lt. 1 (Loket Mandiri / Kotak Pengambilan Mandiri)</span>
</div>
</div>
</div>
<!-- Student Bio Summary -->
<div class="mt-space-md bg-surface-container-low rounded-lg p-space-sm flex items-center justify-between">
<div class="flex items-center gap-space-sm min-w-0">
<div class="w-9 h-9 rounded-full bg-primary flex items-center justify-center text-on-primary font-title-md text-title-md font-semibold shrink-0">
          AF
        </div>
<div class="flex flex-col min-w-0">
<div class="flex items-center gap-1.5">
<span class="font-title-md text-title-md text-on-surface font-semibold truncate">Ahmad Fauzi</span>
<span class="material-symbols-outlined text-on-tertiary-container text-[16px]">check_circle</span>
</div>
<span class="font-body-sm text-body-sm text-on-surface-variant truncate">NIS: 212450243 • XII-BRP 5</span>
</div>
</div>
<div class="text-right shrink-0 pl-2">
<span class="font-label-sm text-label-sm text-outline block">Sisa Kuota</span>
<span class="font-label-md text-label-md font-semibold text-secondary">1/2 Aktif</span>
</div>
</div>
</div>
<!-- Opsi Notifikasi & Catatan -->
<div class="mt-space-md bg-surface-container-lowest rounded-xl p-space-md shadow-sm flex flex-col gap-space-md">
<h3 class="font-title-md text-title-md text-on-surface font-semibold flex items-center gap-space-xs">
<span class="material-symbols-outlined text-secondary text-[20px]">notifications_active</span>
      Preferensi &amp; Catatan
    </h3>
<!-- Notification Toggle -->
<div class="flex items-center justify-between p-space-sm bg-surface-container-low rounded-lg">
<div class="flex flex-col pr-space-sm">
<span class="font-title-md text-body-md text-on-surface font-semibold">Notifikasi WhatsApp / Surel</span>
<span class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">Kirim tanda terima otomatis saat buku siap di loket</span>
</div>
<label class="relative inline-flex items-center cursor-pointer shrink-0">
<input checked="" class="sr-only peer" id="notify-toggle" type="checkbox">
<div class="w-11 h-6 bg-surface-variant peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
</label>
</div>
<!-- Note Input Box -->
<div class="flex flex-col gap-space-xs">
<label class="font-label-md text-label-md text-on-surface font-semibold flex items-center justify-between" for="pustakawan-note">
<span class="">Pesan Khusus untuk Pustakawan</span>
<span class="text-outline font-normal text-label-sm font-label-sm">Opsional</span>
</label>
<div class="relative w-full">
<input class="w-full bg-surface-container-low text-on-surface placeholder:text-outline text-body-sm font-body-sm rounded-lg px-space-md py-space-sm focus:outline-none focus:bg-surface-container-lowest transition-colors shadow-inner" id="pustakawan-note" maxlength="80" placeholder="Contoh: Diambil saat jam istirahat pertama" type="text">
<span class="material-symbols-outlined absolute right-space-sm top-2.5 text-[18px] text-outline pointer-events-none">edit_note</span>
</div>
</div>
</div>
<!-- Kebijakan & Ketentuan Reservasi -->
<div class="mt-space-md bg-surface-container-low rounded-xl p-space-md">
<div class="flex items-start gap-space-sm">
<span class="material-symbols-outlined text-[20px] text-error shrink-0 mt-0.5">gavel</span>
<div class="flex flex-col">
<span class="font-label-md text-label-md text-on-surface font-semibold uppercase tracking-wider">Ketentuan Hangus Otomatis</span>
<p class="font-body-sm text-body-sm text-on-surface-variant mt-1 leading-relaxed">
          Jika buku tidak diambil melewati batas waktu <span class="font-semibold text-on-surface">29 Oktober 2026 pukul 15.00 WIB</span>, antrean reservasi akan dibatalkan secara sistem dan buku dikembalikan ke sirkulasi publik tanpa penalti denda.
        </p>
</div>
</div>
</div>
<!-- Visual Delight Micro-Interaction Badge -->
<div class="mt-space-md flex items-center justify-center gap-space-xs py-space-xs text-outline font-label-sm text-label-sm">
<span class="material-symbols-outlined text-[16px] text-tertiary-fixed-dim">verified_user</span>
<span class="">Sistem Otomasi Perpustakaan LibSys • Terenkripsi</span>
</div>
<!-- Sticky Bottom Actions -->
<div class="sticky bottom-0 z-40 bg-surface/90 backdrop-blur-md pt-space-sm pb-space-sm mt-space-md flex flex-col gap-space-xs">
<button class="w-full bg-primary hover:bg-primary/95 text-on-primary font-title-md text-title-md font-semibold py-3 px-space-lg rounded-lg shadow-md transition-all active:scale-[0.99] flex items-center justify-center gap-space-xs" id="btn-confirm" type="button">
<span class="material-symbols-outlined text-[20px]">task_alt</span>
<span class="">Konfirmasi Reservasi Sekarang</span>
</button>
<button class="w-full bg-transparent hover:bg-surface-container-high text-on-surface-variant font-label-md text-label-md font-semibold py-2.5 px-space-md rounded-lg transition-colors text-center" onclick="history.back()" type="button">
      Batal &amp; Kembali ke Katalog
    </button>
</div>
</div>
<script>
  // Interaksi mikro untuk umpan balik tombol konfirmasi
  document.getElementById('btn-confirm')?.addEventListener('click', function() {
    this.disabled = true;
    this.innerHTML = `
      <span class="material-symbols-outlined animate-spin text-[20px]">progress_activity</span>
      <span>Menyimpan Reservasi...</span>
    `;
    setTimeout(() => {
      this.classList.remove('bg-primary');
      this.classList.add('bg-tertiary-container', 'text-on-tertiary-container');
      this.innerHTML = `
        <span class="material-symbols-outlined text-[20px]">check</span>
        <span>Reservasi Berhasil Diajukan!</span>
      `;
    }, 1000);
  });
</script></main>

</body></html>