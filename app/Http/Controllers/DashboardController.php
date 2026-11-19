<?php

namespace App\Http\Controllers;

use App\Models\PemanduLokal;
use App\Models\ReservasiTur;
use App\Models\Wisatawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function wisatawan()
    {
        $user = Auth::user();
        if ($user->role !== 'wisatawan') {
            return redirect('/');
        }

        $wisatawan = Wisatawan::where('id_user', $user->id_user)->first();
        $reservasiList = $wisatawan ? ReservasiTur::where('id_wisatawan', $wisatawan->id_wisatawan)
            ->with(['paket', 'pemandu', 'pembayaran', 'ulasan'])
            ->latest()
            ->get() : collect();

        return view('wisatawan.dashboard', compact('user', 'wisatawan', 'reservasiList'));
    }

    public function pemandu()
    {
        $user = Auth::user();
        if ($user->role !== 'pemandu') {
            return redirect('/');
        }

        $pemandu = PemanduLokal::where('id_user', $user->id_user)
            ->with(['kota', 'bahasa', 'paketTur.itinerary', 'ulasan'])
            ->first();

        $pesananMasuk = $pemandu ? ReservasiTur::where('id_pemandu', $pemandu->id_pemandu)
            ->with(['wisatawan', 'paket', 'pembayaran'])
            ->latest()
            ->get() : collect();

        return view('pemandu.dashboard', compact('user', 'pemandu', 'pesananMasuk'));
    }
}
