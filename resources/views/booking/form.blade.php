<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Tur Privat - {{ $paket->judul_tur }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen py-10 px-4 sm:px-6 lg:px-8">

    <div class="max-w-6xl mx-auto">
        <!-- Header Nav Back -->
        <div class="flex items-center justify-between mb-8">
            <a href="/" class="flex items-center space-x-2 text-sm font-bold text-slate-600 hover:text-emerald-600 transition">
                <span>&larr;</span>
                <span>Kembali ke Beranda Wisatara</span>
            </a>
            <span class="px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full">
                🔒 100% Private Tour & Aman
            </span>
        </div>

        @if($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Kolom Kiri: Rincian Paket Tur yang Dipesan -->
            <div class="lg:col-span-5 bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6">
                <div>
                    <img src="{{ $paket->foto_sampul }}" 
                         alt="{{ $paket->judul_tur }}" 
                         class="w-full h-48 sm:h-56 object-cover rounded-2xl mb-4">
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-600">{{ $paket->kategori->nama_kategori }}</span>
                    <h1 class="text-xl font-extrabold text-slate-900 mt-1 leading-snug">{{ $paket->judul_tur }}</h1>
                    <p class="text-xs text-slate-500 mt-1">📍 {{ $paket->kota->nama_kota }} • ⏱️ Durasi: {{ $paket->durasi_jam }} Jam</p>
                </div>

                <!-- Info Pemandu -->
                <div class="flex items-center space-x-3 p-4 rounded-2xl bg-slate-50 border border-slate-100">
                    <img src="{{ $paket->pemandu->foto_profil ?? 'https://ui-avatars.com/api/?name='.urlencode($paket->pemandu->nama_pemandu) }}" 
                         alt="{{ $paket->pemandu->nama_pemandu }}" 
                         class="w-12 h-12 rounded-xl object-cover border border-emerald-400">
                    <div>
                        <span class="text-[10px] uppercase font-bold text-slate-400 block">Pemandu Lokal Anda:</span>
                        <span class="text-sm font-bold text-slate-900 block">{{ $paket->pemandu->nama_pemandu }}</span>
                        <span class="text-xs text-slate-500 line-clamp-1 italic">"{{ $paket->pemandu->tagline_pemandu }}"</span>
                    </div>
                </div>

                <!-- Rute Itinerary -->
                @if($paket->itinerary->count() > 0)
                    <div>
                        <span class="text-xs font-bold text-slate-700 uppercase tracking-wider block mb-2">Rute Singgah (Itinerary):</span>
                        <ul class="text-xs text-slate-600 space-y-2">
                            @foreach($paket->itinerary as $spot)
                                <li class="flex items-start space-x-2">
                                    <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-800 font-bold flex items-center justify-center text-[10px] flex-shrink-0 mt-0.5">{{ $spot->urutan_ke }}</span>
                                    <div>
                                        <strong class="text-slate-800">{{ $spot->nama_lokasi_spot }}</strong> (±{{ $spot->estimasi_menit }} mnt)
                                        <p class="text-[11px] text-slate-400">{{ $spot->aktivitas_cerita }}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="pt-4 border-t border-slate-100 text-xs text-slate-500">
                    <p>📍 <strong>Titik Kumpul:</strong> {{ $paket->titik_kumpul }}</p>
                </div>
            </div>

            <!-- Kolom Kanan: Form Reservasi & Pembayaran -->
            <div class="lg:col-span-7 bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm">
                <div class="mb-6 border-b border-slate-100 pb-4">
                    <h2 class="text-xl font-extrabold text-slate-900">Formulir Pemesanan Tur</h2>
                    <p class="text-xs text-slate-500 mt-1">Lengkapi tanggal perjalanan dan permintaan kustomisasi rombongan Anda.</p>
                </div>

                <form action="/paket/{{ $paket->id_paket }}/pesan" method="POST" class="space-y-5">
                    @csrf

                    <!-- Pemesan Info -->
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs flex items-center justify-between">
                        <div>
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">Wisatawan Pemesan:</span>
                            <span class="font-bold text-slate-800">{{ $wisatawan->nama_lengkap }} ({{ $wisatawan->negara_asal }})</span>
                        </div>
                        <span class="text-slate-500">{{ $wisatawan->no_hp ?? '-' }}</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Tanggal Tur</label>
                            <input type="date" name="tgl_tur" value="{{ old('tgl_tur', now()->addDay()->format('Y-m-d')) }}" 
                                   min="{{ date('Y-m-d') }}" required
                                   class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-emerald-500 text-sm outline-none transition cursor-pointer">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Jam Mulai</label>
                            <input type="time" name="jam_mulai" value="{{ old('jam_mulai', '09:00') }}" required
                                   class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-emerald-500 text-sm outline-none transition cursor-pointer">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">
                            Jumlah Anggota Rombongan (Maks. {{ $paket->kuota_maksimal }} Orang)
                        </label>
                        <input type="number" id="jumlah_peserta" name="jumlah_peserta" value="{{ old('jumlah_peserta', 1) }}" 
                               min="1" max="{{ $paket->kuota_maksimal }}" required
                               oninput="hitungTotal()"
                               class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-emerald-500 text-sm outline-none transition">
                        <span class="text-[11px] text-slate-400 mt-1 block">Tur ini privat (tidak digabung dengan wisatawan lain).</span>
                    </div>

                    <!-- Catatan Kustomisasi (UR-05) -->
                    <div>
                        <label class="block text-xs font-bold text-emerald-800 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                            <span>✏️ Catatan Kustomisasi Rute (Opsional)</span>
                            <span class="text-[10px] font-normal text-emerald-600">100% Fleksibel</span>
                        </label>
                        <textarea name="catatan_kustomisasi" rows="3" 
                                  placeholder="Contoh: Kami ingin berhenti sejenak untuk berfoto di spot tertentu, kurangi level kepedasan makanan, atau kami bepergian bersama anak kecil..." 
                                  class="w-full px-4 py-3 rounded-xl bg-emerald-50/30 border border-emerald-200 focus:bg-white focus:border-emerald-500 text-xs outline-none transition">{{ old('catatan_kustomisasi') }}</textarea>
                    </div>

                    <!-- Metode Pembayaran -->
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Metode Pembayaran</label>
                        <div class="grid grid-cols-3 gap-3">
                            <label class="flex flex-col items-center p-3 rounded-xl border border-slate-200 cursor-pointer hover:border-emerald-500 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/50 transition">
                                <input type="radio" name="metode_bayar" value="BCA Virtual Account" checked class="sr-only">
                                <span class="text-sm font-black text-blue-800">BCA</span>
                                <span class="text-[10px] text-slate-500 mt-0.5">Virtual Account</span>
                            </label>

                            <label class="flex flex-col items-center p-3 rounded-xl border border-slate-200 cursor-pointer hover:border-emerald-500 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/50 transition">
                                <input type="radio" name="metode_bayar" value="Mandiri Virtual Account" class="sr-only">
                                <span class="text-sm font-black text-amber-700">Mandiri</span>
                                <span class="text-[10px] text-slate-500 mt-0.5">Virtual Account</span>
                            </label>

                            <label class="flex flex-col items-center p-3 rounded-xl border border-slate-200 cursor-pointer hover:border-emerald-500 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/50 transition">
                                <input type="radio" name="metode_bayar" value="QRIS Instan" class="sr-only">
                                <span class="text-sm font-black text-rose-700">QRIS</span>
                                <span class="text-[10px] text-slate-500 mt-0.5">GoPay / OVO / Dana</span>
                            </label>
                        </div>
                    </div>

                    <!-- Ringkasan Biaya Otomatis -->
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2 text-xs">
                        <div class="flex justify-between text-slate-600">
                            <span>Tarif per Orang</span>
                            <span class="font-bold">Rp {{ number_format($paket->harga_per_orang, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>Jumlah Anggota Rombongan</span>
                            <span id="label_pax" class="font-bold">1 Orang</span>
                        </div>
                        <div class="pt-2 border-t border-slate-200 flex justify-between items-center text-sm">
                            <span class="font-extrabold text-slate-900">Total Biaya Pembayaran</span>
                            <span id="label_total" class="font-black text-lg text-emerald-600">
                                Rp {{ number_format($paket->harga_per_orang, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold rounded-2xl text-sm transition shadow-lg shadow-emerald-600/30">
                        Bayar & Konfirmasi Reservasi Sekarang &rarr;
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const hargaPerOrang = {{ $paket->harga_per_orang }};
        function hitungTotal() {
            const paxInput = document.getElementById('jumlah_peserta');
            let pax = parseInt(paxInput.value) || 1;
            if (pax < 1) pax = 1;
            const max = {{ $paket->kuota_maksimal }};
            if (pax > max) pax = max;

            const total = hargaPerOrang * pax;
            document.getElementById('label_pax').innerText = pax + ' Orang';
            document.getElementById('label_total').innerText = 'Rp ' + total.toLocaleString('id-ID');
        }
    </script>
</body>
</html>
