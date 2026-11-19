<?php

namespace App\Http\Controllers;

use App\Models\KotaDestinasi;
use App\Models\PemanduLokal;
use App\Models\User;
use App\Models\Wisatawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return $this->redirectBasedOnRole(Auth::user());
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        $kotaList = KotaDestinasi::all();
        return view('auth.register', compact('kotaList'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'role' => ['required', 'in:wisatawan,pemandu'],
            'no_hp' => ['nullable', 'string', 'max:15'],
            'id_kota' => ['nullable', 'required_if:role,pemandu', 'exists:kota_destinasi,id_kota'],
            'tagline' => ['nullable', 'string', 'max:150'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status_aktif' => true,
        ]);

        if ($request->role === 'wisatawan') {
            Wisatawan::create([
                'id_user' => $user->id_user,
                'nama_lengkap' => $request->name,
                'negara_asal' => 'Indonesia',
                'no_hp' => $request->no_hp,
            ]);
        } elseif ($request->role === 'pemandu') {
            PemanduLokal::create([
                'id_user' => $user->id_user,
                'id_kota' => $request->id_kota,
                'nama_pemandu' => $request->name,
                'tagline_pemandu' => $request->tagline ?? 'Pemandu Lokal Wisatara',
                'no_hp' => $request->no_hp,
                'status_verifikasi' => 'Menunggu', // Wajib diverifikasi admin dulu sesuai aturan bisnis
                'status_ketersediaan' => 'Tersedia',
            ]);
        }

        Auth::login($user);

        return $this->redirectBasedOnRole($user);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    protected function redirectBasedOnRole($user)
    {
        if ($user->role === 'admin') {
            return redirect('/admin');
        } elseif ($user->role === 'pemandu') {
            return redirect('/pemandu/dashboard');
        } else {
            return redirect('/wisatawan/dashboard');
        }
    }
}
