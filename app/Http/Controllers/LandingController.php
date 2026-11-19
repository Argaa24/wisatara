<?php

namespace App\Http\Controllers;

use App\Models\Bahasa;
use App\Models\KategoriTur;
use App\Models\KotaDestinasi;
use App\Models\PaketTur;
use App\Models\PemanduLokal;
use App\Models\UlasanTur;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        $kotaList = KotaDestinasi::withCount(['pemandu', 'paketTur'])->get();
        $kategoriList = KategoriTur::withCount('paketTur')->get();
        $bahasaList = Bahasa::all();

        // Pemandu terverifikasi
        $pemanduQuery = PemanduLokal::where('status_verifikasi', 'Terverifikasi')
            ->with(['kota', 'bahasa', 'ulasan']);

        // Paket tur
        $paketQuery = PaketTur::with(['pemandu', 'kategori', 'kota', 'itinerary']);

        // Filter jika ada input dari search bar
        if ($request->filled('kota')) {
            $pemanduQuery->where('id_kota', $request->kota);
            $paketQuery->where('id_kota', $request->kota);
        }

        if ($request->filled('kategori')) {
            $paketQuery->where('id_kategori', $request->kategori);
        }

        $pemanduList = $pemanduQuery->take(4)->get();
        $paketList = $paketQuery->take(6)->get();
        $ulasanList = UlasanTur::with(['wisatawan', 'pemandu'])->latest()->take(3)->get();

        return view('landing', compact('kotaList', 'kategoriList', 'bahasaList', 'pemanduList', 'paketList', 'ulasanList'));
    }
}
