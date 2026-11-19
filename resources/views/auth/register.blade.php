<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Baru - Wisatara</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col justify-between">

    <!-- Header Sederhana -->
    <header class="py-6 px-4 sm:px-8 max-w-7xl mx-auto w-full flex items-center justify-between">
        <a href="/" class="flex items-center space-x-3">
            <span class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-400 flex items-center justify-center text-white font-bold text-xl shadow-md">W</span>
            <span class="text-2xl font-black tracking-tight text-slate-900">Wisatara</span>
        </a>
        <a href="/login" class="text-sm font-semibold text-slate-500 hover:text-slate-900">Sudah punya akun? Masuk &rarr;</a>
    </header>

    <!-- Form Register Box -->
    <main class="flex-grow flex items-center justify-center px-4 py-8">
        <div class="max-w-xl w-full bg-white rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-200 p-8 sm:p-10">
            <div class="text-center mb-8">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Bergabung Bersama Wisatara</h1>
                <p class="text-sm text-slate-500 mt-1">Daftar sebagai wisatawan atau pemandu wisata lokal.</p>
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

            <form action="/register" method="POST" class="space-y-4">
                @csrf

                <!-- Pilihan Peran (Role) -->
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Saya Mendaftar Sebagai:</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex flex-col items-center p-4 rounded-2xl border-2 border-slate-200 cursor-pointer hover:border-emerald-500 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/50 transition">
                            <input type="radio" name="role" value="wisatawan" {{ old('role', 'wisatawan') == 'wisatawan' ? 'checked' : '' }} class="sr-only" onchange="toggleGuideFields()">
                            <span class="text-2xl mb-1">🎒</span>
                            <span class="text-xs font-bold text-slate-800">Wisatawan (Guest)</span>
                            <span class="text-[10px] text-slate-500 text-center mt-0.5">Mencari tur privat</span>
                        </label>

                        <label class="flex flex-col items-center p-4 rounded-2xl border-2 border-slate-200 cursor-pointer hover:border-emerald-500 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/50 transition">
                            <input type="radio" name="role" value="pemandu" {{ old('role') == 'pemandu' ? 'checked' : '' }} class="sr-only" onchange="toggleGuideFields()">
                            <span class="text-2xl mb-1">🧭</span>
                            <span class="text-xs font-bold text-slate-800">Pemandu Lokal (Host)</span>
                            <span class="text-[10px] text-slate-500 text-center mt-0.5">Menawarkan tur privat</span>
                        </label>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               placeholder="Nama Anda" 
                               class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-emerald-500 text-sm outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Username</label>
                        <input type="text" name="username" value="{{ old('username') }}" required
                               placeholder="username_anda" 
                               class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-emerald-500 text-sm outline-none transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               placeholder="nama@email.com" 
                               class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-emerald-500 text-sm outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">No. WhatsApp / HP</label>
                        <input type="tel" name="no_hp" value="{{ old('no_hp') }}"
                               placeholder="081234567890" 
                               class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-emerald-500 text-sm outline-none transition">
                    </div>
                </div>

                <!-- Kolom Khusus Pemandu Lokal -->
                <div id="guideFields" class="{{ old('role') == 'pemandu' ? '' : 'hidden' }} space-y-4 p-4 rounded-2xl bg-emerald-50/40 border border-emerald-100">
                    <div>
                        <label class="block text-xs font-bold text-emerald-900 uppercase tracking-wider mb-1.5">Kota Domisili Memandu</label>
                        <select name="id_kota" class="w-full px-4 py-3 rounded-xl bg-white border border-emerald-200 text-sm outline-none">
                            <option value="">Pilih Kota Domisili</option>
                            @foreach($kotaList as $kota)
                                <option value="{{ $kota->id_kota }}" {{ old('id_kota') == $kota->id_kota ? 'selected' : '' }}>
                                    {{ $kota->nama_kota }} ({{ $kota->provinsi }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-emerald-900 uppercase tracking-wider mb-1.5">Tagline Personal Anda</label>
                        <input type="text" name="tagline" value="{{ old('tagline') }}"
                               placeholder="contoh: The Street Foodie Specialist" 
                               class="w-full px-4 py-3 rounded-xl bg-white border border-emerald-200 text-sm outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Kata Sandi</label>
                        <input type="password" name="password" required
                               placeholder="Minimal 6 karakter" 
                               class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-emerald-500 text-sm outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Ulangi Kata Sandi</label>
                        <input type="password" name="password_confirmation" required
                               placeholder="Konfirmasi kata sandi" 
                               class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-emerald-500 text-sm outline-none transition">
                    </div>
                </div>

                <button type="submit" class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition shadow-lg shadow-emerald-600/20 text-sm mt-2">
                    Daftar Sekarang
                </button>
            </form>

            <div class="mt-6 text-center text-xs text-slate-500">
                Sudah punya akun? 
                <a href="/login" class="text-emerald-600 font-bold hover:underline">Masuk di sini</a>
            </div>
        </div>
    </main>

    <footer class="py-6 text-center text-xs text-slate-400">
        © 2026 Wisatara. PSAS SMK Telkom Purwokerto.
    </footer>

    <script>
        function toggleGuideFields() {
            const role = document.querySelector('input[name="role"]:checked').value;
            const guideFields = document.getElementById('guideFields');
            if (role === 'pemandu') {
                guideFields.classList.remove('hidden');
            } else {
                guideFields.classList.add('hidden');
            }
        }
    </script>
</body>
</html>
