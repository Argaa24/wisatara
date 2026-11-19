<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dasbor Pemandu Lokal - Wisatara</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col justify-between">

    <!-- NAVBAR HOST -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="/" class="flex items-center space-x-3">
                <span class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-400 flex items-center justify-center text-white font-bold text-xl shadow-md">W</span>
                <div>
                    <span class="text-2xl font-black tracking-tight text-slate-900">Wisatara</span>
                    <span class="ml-2 px-2 py-0.5 text-xs font-semibold bg-emerald-50 text-emerald-800 rounded-full border border-emerald-200">Panel Host / Pemandu</span>
                </div>
            </a>

            <div class="flex items-center space-x-4">
                <a href="/" class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition">
                    Lihat Web Publik &rarr;
                </a>

                <div class="h-6 w-px bg-slate-200"></div>

                <div class="flex items-center space-x-3">
                    <span class="text-sm font-bold text-slate-800">{{ $pemandu->nama_pemandu ?? $user->name }}</span>
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
        <!-- Banner Host & Status Verifikasi -->
        <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-slate-900 rounded-3xl p-8 sm:p-10 text-white mb-8 shadow-lg relative overflow-hidden">
            <div class="relative z-10 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                <div class="flex items-center space-x-5">
                    <img src="{{ $pemandu->foto_profil ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}" 
                         alt="{{ $user->name }}" 
                         class="w-20 h-20 rounded-2xl object-cover border-2 border-emerald-400 shadow-md">
                    <div>
                        <div class="flex items-center space-x-2">
                            <h1 class="text-2xl sm:text-3xl font-extrabold">{{ $pemandu->nama_pemandu ?? $user->name }}</h1>
                            @if($pemandu && $pemandu->status_verifikasi === 'Terverifikasi')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-500 text-white flex items-center space-x-1">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    <span>Terverifikasi</span>
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-400 text-slate-900">
                                    ⏳ Menunggu Verifikasi Admin
                                </span>
                            @endif
                        </div>
                        <p class="text-emerald-300 text-sm mt-1 font-semibold italic">"{{ $pemandu->tagline_pemandu ?? 'Pemandu Lokal Wisatara' }}"</p>
                        <p class="text-slate-400 text-xs mt-1">📍 Domisili: {{ $pemandu->kota->nama_kota ?? 'Indonesia' }} • Kontak: {{ $pemandu->no_hp ?? '-' }}</p>
                    </div>
                </div>

                <div class="text-right">
                    <span class="text-xs uppercase tracking-wider font-bold text-slate-400 block mb-1">Status Ketersediaan:</span>
                    <span class="px-4 py-1.5 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                        ● {{ $pemandu->status_ketersediaan ?? 'Tersedia' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- 3 Kartu Metrik Pemandu -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Paket Tur Saya</span>
                <div class="flex items-baseline space-x-2 mt-2">
                    <span class="text-3xl font-black text-slate-900">{{ $pemandu ? $pemandu->paketTur->count() : 0 }}</span>
                    <span class="text-xs font-semibold text-slate-500">Pengalaman Aktif</span>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Pesanan Masuk</span>
                <div class="flex items-baseline space-x-2 mt-2">
                    <span class="text-3xl font-black text-emerald-600">{{ $pesananMasuk->count() }}</span>
                    <span class="text-xs font-semibold text-slate-500">Reservasi Tamu</span>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Rata-rata Rating</span>
                <div class="flex items-baseline space-x-2 mt-2">
                    <span class="text-3xl font-black text-amber-500">⭐ {{ $pemandu ? $pemandu->rata_rata_rating : '5.0' }}</span>
                    <span class="text-xs font-semibold text-slate-500">({{ $pemandu ? $pemandu->ulasan->count() : 0 }} Ulasan)</span>
                </div>
            </div>
        </div>

        <!-- Section: Pesanan Masuk dari Wisatawan -->
        <div class="mb-10">
            <div class="mb-6">
                <h2 class="text-2xl font-extrabold text-slate-900">Daftar Pesanan Masuk (Bookings)</h2>
                <p class="text-sm text-slate-500">Permintaan reservasi tur privat beserta catatan kustomisasi dari wisatawan.</p>
            </div>

            <div class="space-y-4">
                @forelse($pesananMasuk as $order)
                    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm">
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                            <div>
                                <div class="flex items-center space-x-2">
                                    <span class="text-xs font-mono font-bold text-slate-400">#WST-{{ str_pad($order->id_reservasi, 4, '0', STR_PAD_LEFT) }}</span>
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold 
                                        {{ $order->status_reservasi == 'Selesai' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                        {{ $order->status_reservasi == 'Dikonfirmasi' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $order->status_reservasi == 'Menunggu' ? 'bg-amber-100 text-amber-800' : '' }}">
                                        {{ $order->status_reservasi }}
                                    </span>
                                </div>
                                <h3 class="font-extrabold text-lg text-slate-900 mt-1">{{ $order->paket->judul_tur ?? '-' }}</h3>
                                <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-slate-500 mt-2">
                                    <span>👤 Tamu: <strong class="text-slate-800">{{ $order->wisatawan->nama_lengkap ?? 'Wisatawan' }}</strong> ({{ $order->wisatawan->negara_asal ?? '-' }})</span>
                                    <span>📅 {{ \Carbon\Carbon::parse($order->tgl_tur)->translatedFormat('d F Y') }}</span>
                                    <span>⏰ {{ $order->jam_mulai }} WIB</span>
                                    <span>👥 {{ $order->jumlah_peserta }} Orang</span>
                                </div>

                                @if($order->catatan_kustomisasi)
                                    <div class="mt-3 p-3 rounded-2xl bg-amber-50/70 border border-amber-200 text-xs text-amber-900">
                                        <span class="font-bold flex items-center space-x-1">
                                            <span>✏️ Permintaan Kustomisasi dari Wisatawan:</span>
                                        </span>
                                        <p class="mt-0.5 italic">"{{ $order->catatan_kustomisasi }}"</p>
                                    </div>
                                @endif
                            </div>

                            <div class="lg:text-right border-t lg:border-t-0 pt-4 lg:pt-0 border-slate-100 flex lg:flex-col justify-between items-end gap-3">
                                <div>
                                    <span class="text-xs text-slate-400 block">Total Pembayaran</span>
                                    <span class="text-xl font-black text-emerald-600">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                                </div>
                                <div>
                                    <span class="text-xs font-semibold px-2.5 py-1 rounded-md bg-slate-100 text-slate-700">
                                        {{ $order->pembayaran ? 'Status Bayar: ' . $order->pembayaran->status_bayar : 'Belum Ada Pembayaran' }}
                                    </span>
                                </div>

                                <!-- Tombol Aksi Pemandu: Terima / Selesaikan Tur -->
                                <div class="mt-2 flex items-center space-x-2">
                                    @if($order->status_reservasi === 'Menunggu')
                                        <form action="/pemandu/reservasi/{{ $order->id_reservasi }}/status" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="status" value="Dikonfirmasi">
                                            <button type="submit" class="px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-sm transition">
                                                ✓ Terima Pesanan
                                            </button>
                                        </form>

                                        <form action="/pemandu/reservasi/{{ $order->id_reservasi }}/status" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="status" value="Ditolak">
                                            <button type="submit" onclick="return confirm('Yakin ingin menolak pesanan ini?')" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-xs rounded-xl border border-rose-200 transition">
                                                Tolak
                                            </button>
                                        </form>
                                    @elseif($order->status_reservasi === 'Dikonfirmasi')
                                        <form action="/pemandu/reservasi/{{ $order->id_reservasi }}/status" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="status" value="Selesai">
                                            <button type="submit" onclick="return confirm('Apakah tur privat ini sudah selesai dilaksanakan bersama wisatawan?')" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs rounded-xl shadow-md shadow-blue-500/20 transition flex items-center space-x-1.5">
                                                <span>🎯 Tandai Tur Selesai</span>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs font-bold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                                            ✓ Tur Selesai
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-3xl p-10 text-center border border-slate-200">
                        <span class="text-3xl block mb-2">📬</span>
                        <h3 class="font-bold text-slate-800 text-base">Belum Ada Pesanan Masuk</h3>
                        <p class="text-xs text-slate-500 mt-1">Pesanan reservasi dari wisatawan akan otomatis muncul di sini.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Section: Paket Tur Saya -->
        <div>
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-extrabold text-slate-900">Paket Tur Saya & Itinerary</h2>
                    <p class="text-sm text-slate-500">Paket pengalaman privat yang Anda tawarkan ke wisatawan.</p>
                </div>
                <a href="/pemandu/paket/create" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-2xl text-xs transition shadow-md shadow-emerald-600/20 flex items-center space-x-1.5">
                    <span>+ Buat Paket Tur Baru</span>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if($pemandu)
                    @foreach($pemandu->paketTur as $paket)
                        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex flex-col justify-between">
                            <div>
                                <h3 class="font-bold text-lg text-slate-900">{{ $paket->judul_tur }}</h3>
                                <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $paket->deskripsi_tur }}</p>

                                <div class="mt-4 p-3 rounded-2xl bg-slate-50 border border-slate-100">
                                    <span class="text-xs font-bold text-slate-500 block mb-1">Rute Titik Singgah (Itinerary):</span>
                                    <ul class="text-xs text-slate-700 space-y-1">
                                        @foreach($paket->itinerary as $spot)
                                            <li>• <strong>{{ $spot->nama_lokasi_spot }}</strong> (±{{ $spot->estimasi_menit }} menit)</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                                <span class="font-black text-emerald-600 text-base">Rp {{ number_format($paket->harga_per_orang, 0, ',', '.') }} / orang</span>
                                <span class="text-slate-500">⏱️ {{ $paket->durasi_jam }} Jam</span>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </main>

    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-400">
        © 2026 Wisatara • Platform Marketplace Pemandu Wisata Lokal & Private Tour
    </footer>

</body>
</html>
