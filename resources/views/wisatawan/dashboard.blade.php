<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dasbor Wisatawan - Wisatara</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col justify-between">

    <!-- NAVBAR WISATAWAN -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="/" class="flex items-center space-x-3">
                <span class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-400 flex items-center justify-center text-white font-bold text-xl shadow-md">W</span>
                <div>
                    <span class="text-2xl font-black tracking-tight text-slate-900">Wisatara</span>
                    <span class="ml-2 px-2 py-0.5 text-xs font-semibold bg-blue-50 text-blue-700 rounded-full border border-blue-200">Panel Wisatawan</span>
                </div>
            </a>

            <div class="flex items-center space-x-4">
                <a href="/" class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition flex items-center space-x-1">
                    <span>🔍 Cari Tur Baru</span>
                </a>

                <div class="h-6 w-px bg-slate-200"></div>

                <div class="flex items-center space-x-3">
                    <span class="text-sm font-bold text-slate-800">{{ $user->name }}</span>
                    <form action="/logout" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-3 py-1.5 text-xs font-bold text-rose-600 hover:bg-rose-50 rounded-lg transition border border-rose-200">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- CONTENT -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 flex-grow w-full">
        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-bold flex items-center space-x-2">
                <span>🎉</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        <!-- Hero Header -->
        <div class="bg-gradient-to-r from-slate-900 to-slate-800 rounded-3xl p-8 sm:p-10 text-white mb-10 shadow-lg relative overflow-hidden">
            <div class="relative z-10 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                <div>
                    <span class="text-xs uppercase tracking-widest font-bold text-emerald-400">Selamat Datang</span>
                    <h1 class="text-3xl font-extrabold mt-1">{{ $wisatawan->nama_lengkap ?? $user->name }}</h1>
                    <p class="text-slate-300 text-sm mt-2">Negara Asal: {{ $wisatawan->negara_asal ?? 'Indonesia' }} • Kontak: {{ $wisatawan->no_hp ?? '-' }}</p>
                </div>
                <a href="/#paket" class="px-6 py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-2xl transition shadow-lg shadow-emerald-500/30 text-sm flex items-center space-x-2">
                    <span>Eksplorasi Tur Privat</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>

        <!-- Section: Reservasi Tur Saya -->
        <div class="mb-10">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-extrabold text-slate-900">Reservasi Tur Privat Saya</h2>
                    <p class="text-sm text-slate-500">Daftar riwayat pemesanan tur dan kustomisasi perjalanan Anda.</p>
                </div>
            </div>

            <div class="space-y-4">
                @forelse($reservasiList as $res)
                    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition">
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                            <div class="flex items-start space-x-4">
                                <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-700 font-black flex items-center justify-center text-lg flex-shrink-0 border border-emerald-100">
                                    🎒
                                </div>
                                <div>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs font-mono font-bold text-slate-400">#WST-{{ str_pad($res->id_reservasi, 4, '0', STR_PAD_LEFT) }}</span>
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold 
                                            {{ $res->status_reservasi == 'Selesai' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                            {{ $res->status_reservasi == 'Dikonfirmasi' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $res->status_reservasi == 'Menunggu' ? 'bg-amber-100 text-amber-800' : '' }}">
                                            {{ $res->status_reservasi }}
                                        </span>
                                    </div>
                                    <h3 class="font-extrabold text-lg text-slate-900 mt-1">{{ $res->paket->judul_tur ?? 'Paket Tur Privat' }}</h3>
                                    <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-slate-500 mt-2">
                                        <span>🧭 Pemandu: <strong class="text-slate-700">{{ $res->pemandu->nama_pemandu ?? '-' }}</strong></span>
                                        <span>📅 {{ \Carbon\Carbon::parse($res->tgl_tur)->translatedFormat('d F Y') }}</span>
                                        <span>⏰ {{ $res->jam_mulai }} WIB</span>
                                        <span>👥 {{ $res->jumlah_peserta }} Orang</span>
                                    </div>

                                    @if($res->catatan_kustomisasi)
                                        <div class="mt-3 p-3 rounded-xl bg-slate-50 border border-slate-200/80 text-xs text-slate-600">
                                            <span class="font-bold text-slate-700">Catatan Kustomisasi Anda:</span>
                                            <p class="italic mt-0.5">"{{ $res->catatan_kustomisasi }}"</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="lg:text-right border-t lg:border-t-0 pt-4 lg:pt-0 border-slate-100 flex lg:flex-col justify-between items-end">
                                <div>
                                    <span class="text-xs text-slate-400 block">Total Biaya Tur</span>
                                    <span class="text-xl font-black text-emerald-600">Rp {{ number_format($res->total_harga, 0, ',', '.') }}</span>
                                </div>
                                <div class="mt-2">
                                    <span class="text-xs font-semibold px-2.5 py-1 rounded-md 
                                        {{ $res->pembayaran && $res->pembayaran->status_bayar == 'Lunas' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                                        {{ $res->pembayaran ? 'Status Bayar: ' . $res->pembayaran->status_bayar : 'Belum Ada Pembayaran' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Bagian Ulasan Pasca Tur (Aturan Bisnis No 5) -->
                        @if($res->status_reservasi === 'Selesai')
                            <div class="mt-4 pt-4 border-t border-slate-100" x-data="{ openReview: false }">
                                @if($res->ulasan)
                                    <div class="flex items-center space-x-2 text-xs">
                                        <span class="text-amber-500 font-bold">Ulasan Anda: {{ str_repeat('⭐', $res->ulasan->rating) }}</span>
                                        <span class="text-slate-600 italic">"{{ $res->ulasan->komentar }}"</span>
                                    </div>
                                @else
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-slate-500">Tur Anda telah selesai. Bagikan pengalaman Anda untuk membantu wisatawan lain!</span>
                                        <button @click="openReview = !openReview" class="px-4 py-1.5 bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs rounded-xl transition shadow-sm flex items-center space-x-1">
                                            <span>⭐ Beri Ulasan & Rating</span>
                                        </button>
                                    </div>

                                    <!-- Form Input Ulasan -->
                                    <div x-show="openReview" x-transition class="mt-4 p-4 rounded-2xl bg-amber-50/60 border border-amber-200">
                                        <form action="/wisatawan/reservasi/{{ $res->id_reservasi }}/ulasan" method="POST" class="space-y-3">
                                            @csrf
                                            <div>
                                                <label class="block text-xs font-bold text-slate-700 mb-1">Berapa bintang untuk pemandu Anda?</label>
                                                <div class="flex items-center space-x-4 text-xs font-semibold">
                                                    @for($i = 5; $i >= 1; $i--)
                                                        <label class="flex items-center space-x-1 cursor-pointer">
                                                            <input type="radio" name="rating" value="{{ $i }}" {{ $i == 5 ? 'checked' : '' }} class="text-amber-500 focus:ring-amber-400">
                                                            <span>{{ str_repeat('⭐', $i) }} ({{ $i }})</span>
                                                        </label>
                                                    @endfor
                                                </div>
                                            </div>

                                            <div>
                                                <label class="block text-xs font-bold text-slate-700 mb-1">Tuliskan ulasan & testimoni Anda:</label>
                                                <textarea name="komentar" rows="2" required placeholder="Ceritakan bagaimana keramahan pemandu, cerita menarik di lapangan, atau spot yang paling Anda sukai..." class="w-full p-3 rounded-xl bg-white border border-amber-200 text-xs outline-none focus:border-amber-400"></textarea>
                                            </div>

                                            <div class="flex justify-end space-x-2">
                                                <button type="button" @click="openReview = false" class="px-3 py-1.5 text-xs text-slate-500 hover:text-slate-800">Batal</button>
                                                <button type="submit" class="px-4 py-1.5 bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs rounded-xl shadow-sm transition">Kirim Ulasan</button>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="bg-white rounded-3xl p-12 text-center border border-slate-200">
                        <span class="text-4xl block mb-3">🏖️</span>
                        <h3 class="font-bold text-slate-800 text-lg">Belum Ada Reservasi Tur</h3>
                        <p class="text-sm text-slate-500 mt-1 max-w-md mx-auto">Anda belum memesan tur privat apapun. Jelajahi pengalaman unik bersama pemandu lokal di berbagai kota!</p>
                        <a href="/#paket" class="mt-5 inline-block px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs transition">
                            Lihat Katalog Tur
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </main>

    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-400">
        © 2026 Wisatara • Platform Marketplace Pemandu Wisata Lokal & Private Tour
    </footer>

</body>
</html>
