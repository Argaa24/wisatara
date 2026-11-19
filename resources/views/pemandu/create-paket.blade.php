<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Paket Tur Baru - Wisatara Host</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen py-10 px-4 sm:px-6 lg:px-8">

    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center space-x-3">
                <a href="/pemandu/dashboard" class="w-10 h-10 rounded-2xl bg-white border border-slate-200 flex items-center justify-center text-slate-600 hover:text-slate-900 shadow-sm transition">
                    &larr;
                </a>
                <div>
                    <h1 class="text-2xl font-extrabold text-slate-900">Rancang Paket Tur Privat Baru</h1>
                    <p class="text-xs text-slate-500">Tawarkan pengalaman autentik dan rute perjalanan terbaik kepada wisatawan.</p>
                </div>
            </div>
            <a href="/pemandu/dashboard" class="text-xs font-bold text-slate-500 hover:text-slate-800">Batal</a>
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

        <form action="/pemandu/paket" method="POST" class="space-y-8">
            @csrf

            <!-- Section 1: Informasi Utama -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-5">
                <h2 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-3">1. Informasi Utama Paket Tur</h2>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Judul Pengalaman (Experience)</label>
                    <input type="text" name="judul_tur" value="{{ old('judul_tur') }}" required
                           placeholder="Contoh: The 10 Tastings of Yogyakarta: Street Food & Hidden Alley" 
                           class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-emerald-500 text-sm outline-none transition">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Kategori Pengalaman</label>
                        <select name="id_kategori" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm outline-none">
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoriList as $kat)
                                <option value="{{ $kat->id_kategori }}" {{ old('id_kategori') == $kat->id_kategori ? 'selected' : '' }}>
                                    {{ $kat->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Kota Lokasi Tur</label>
                        <select name="id_kota" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm outline-none">
                            <option value="">Pilih Kota</option>
                            @foreach($kotaList as $kota)
                                <option value="{{ $kota->id_kota }}" {{ old('id_kota', $pemandu->id_kota) == $kota->id_kota ? 'selected' : '' }}>
                                    {{ $kota->nama_kota }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Tarif per Orang (Rp)</label>
                        <input type="number" name="harga_per_orang" value="{{ old('harga_per_orang', 250000) }}" required min="10000" step="5000"
                               class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-emerald-500 text-sm outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Durasi Tur (Jam)</label>
                        <input type="number" name="durasi_jam" value="{{ old('durasi_jam', 3) }}" required min="1" max="24"
                               class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-emerald-500 text-sm outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Maksimal Peserta</label>
                        <input type="number" name="kuota_maksimal" value="{{ old('kuota_maksimal', 5) }}" required min="1" max="20"
                               class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-emerald-500 text-sm outline-none transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Titik Lokasi Bertemu (Meeting Point)</label>
                        <input type="text" name="titik_kumpul" value="{{ old('titik_kumpul') }}" required
                               placeholder="Contoh: Depan Museum Benteng Vredeburg" 
                               class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-emerald-500 text-sm outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">URL Foto Sampul (Gambar)</label>
                        <input type="url" name="foto_sampul" value="{{ old('foto_sampul') }}"
                               placeholder="https://images.unsplash.com/..." 
                               class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-emerald-500 text-sm outline-none transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Deskripsi Lengkap Tur</label>
                    <textarea name="deskripsi_tur" rows="4" required
                              placeholder="Ceritakan gambaran pengalaman yang akan didapatkan wisatawan pada tur privat ini..." 
                              class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-emerald-500 text-sm outline-none transition">{{ old('deskripsi_tur') }}</textarea>
                </div>
            </div>

            <!-- Section 2: Rute Perhentian (Itinerary Spots) -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6">
                <div>
                    <h2 class="text-lg font-bold text-slate-900">2. Rute Perhentian & Aktivitas (Itinerary)</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Rincikan urutan lokasi yang akan dikunjungi beserta perkiraan waktunya.</p>
                </div>

                <!-- Spot 1 -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                    <span class="inline-block px-2.5 py-0.5 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-md">Spot 1 (Perhentian Pertama)</span>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="sm:col-span-2">
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Nama Lokasi / Spot</label>
                            <input type="text" name="spots[0][nama]" value="{{ old('spots.0.nama') }}" required placeholder="Contoh: Titik Nol Malioboro" class="w-full px-3 py-2 text-xs rounded-lg bg-white border border-slate-200">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Estimasi Waktu (Menit)</label>
                            <input type="number" name="spots[0][estimasi]" value="{{ old('spots.0.estimasi', 45) }}" required class="w-full px-3 py-2 text-xs rounded-lg bg-white border border-slate-200">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Aktivitas & Cerita</label>
                        <input type="text" name="spots[0][aktivitas]" value="{{ old('spots.0.aktivitas') }}" required placeholder="Contoh: Berjalan santai dan mencicipi wedang ronde hangat" class="w-full px-3 py-2 text-xs rounded-lg bg-white border border-slate-200">
                    </div>
                </div>

                <!-- Spot 2 -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                    <span class="inline-block px-2.5 py-0.5 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-md">Spot 2 (Perhentian Kedua)</span>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="sm:col-span-2">
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Nama Lokasi / Spot</label>
                            <input type="text" name="spots[1][nama]" value="{{ old('spots.1.nama') }}" placeholder="Contoh: Sentra Gudeg Wijilan" class="w-full px-3 py-2 text-xs rounded-lg bg-white border border-slate-200">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Estimasi Waktu (Menit)</label>
                            <input type="number" name="spots[1][estimasi]" value="{{ old('spots.1.estimasi', 60) }}" class="w-full px-3 py-2 text-xs rounded-lg bg-white border border-slate-200">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Aktivitas & Cerita</label>
                        <input type="text" name="spots[1][aktivitas]" value="{{ old('spots.1.aktivitas') }}" placeholder="Contoh: Menikmati seporsi gudeg basah legendaris bersama pemiliknya" class="w-full px-3 py-2 text-xs rounded-lg bg-white border border-slate-200">
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-4">
                <a href="/pemandu/dashboard" class="px-6 py-3 rounded-xl border border-slate-200 text-sm font-bold text-slate-600 hover:bg-slate-100 transition">
                    Batal
                </a>
                <button type="submit" class="px-8 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-sm transition shadow-lg shadow-emerald-600/20">
                    Terbitkan Paket Tur Sekarang 🚀
                </button>
            </div>
        </form>
    </div>

</body>
</html>
