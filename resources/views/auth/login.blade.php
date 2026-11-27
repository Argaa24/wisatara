<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Wisatara</title>
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
        <a href="/" class="text-sm font-semibold text-slate-500 hover:text-slate-900">&larr; Kembali ke Beranda</a>
    </header>

    <!-- Form Login Box -->
    <main class="flex-grow flex items-center justify-center px-4 py-8">
        <div class="max-w-md w-full bg-white rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-200 p-8 sm:p-10">
            <div class="text-center mb-8">
                <span class="inline-block p-3 rounded-2xl bg-emerald-50 text-emerald-600 mb-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                </span>
                <h1 class="text-2xl font-extrabold text-slate-900">Selamat Datang Kembali</h1>
                <p class="text-sm text-slate-500 mt-1">Masuk untuk mengakses akun Wisatara Anda.</p>
            </div>

            @if($errors->any())
                <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="/login" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           placeholder="nama@email.com" 
                           class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 text-sm outline-none transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Kata Sandi (Password)</label>
                    <input type="password" name="password" required
                           placeholder="••••••••" 
                           class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 text-sm outline-none transition">
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center space-x-2 cursor-pointer text-slate-600">
                        <input type="checkbox" name="remember" class="rounded text-emerald-600 focus:ring-emerald-500">
                        <span>Ingat saya</span>
                    </label>
                </div>

                <button type="submit" class="w-full py-3.5 bg-slate-900 hover:bg-emerald-600 text-white font-bold rounded-xl transition shadow-md shadow-slate-900/20 text-sm">
                    Masuk Sekarang
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-slate-100 text-center text-xs text-slate-500">
                Belum punya akun? 
                <a href="/register" class="text-emerald-600 font-bold hover:underline">Daftar Akun Baru</a>
            </div>

            <!-- Akun Uji Coba Demo -->
            <div class="mt-6 p-4 rounded-2xl bg-slate-50 border border-slate-200 text-xs text-slate-600">
                <span class="font-bold text-slate-800 block mb-1.5">💡 Akun Demo untuk Pengujian:</span>
                <ul class="space-y-1 font-mono text-[11px]">
                    <li>• <span class="font-semibold text-emerald-700">Pemandu:</span> bagus@wisatara.com (pw: password123)</li>
                    <li>• <span class="font-semibold text-blue-700">Wisatawan:</span> michael@gmail.com (pw: password123)</li>
                </ul>
            </div>
        </div>
    </main>

    <footer class="py-6 text-center text-xs text-slate-400">
        © 2026 Wisatara. PSAS SMK Telkom Purwokerto.
    </footer>

</body>
</html>
