<?php

namespace App\Http\Controllers;

use App\Models\KategoriTur;
use App\Models\KotaDestinasi;
use App\Models\PaketTur;
use App\Models\PemanduLokal;
use App\Models\RuteItinerary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemanduController extends Controller
{
    public function createPaket()
    {
        $user = Auth::user();
        if ($user->role !== 'pemandu') {
            return redirect('/');
        }

        $pemandu = PemanduLokal::where('id_user', $user->id_user)->first();
        if (!$pemandu) {
            return redirect('/pemandu/dashboard')->with('error', 'Profil pemandu belum lengkap.');
        }

        $kategoriList = KategoriTur::all();
        $kotaList = KotaDestinasi::all();

        return view('pemandu.create-paket', compact('pemandu', 'kategoriList', 'kotaList'));
    }

    public function storePaket(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'pemandu') {
            return redirect('/');
        }

        $pemandu = PemanduLokal::where('id_user', $user->id_user)->firstOrFail();

        $request->validate([
            'judul_tur' => ['required', 'string', 'max:150'],
            'id_kategori' => ['required', 'exists:kategori_tur,id_kategori'],
            'id_kota' => ['required', 'exists:kota_destinasi,id_kota'],
            'harga_per_orang' => ['required', 'numeric', 'min:10000'],
            'durasi_jam' => ['required', 'integer', 'min:1', 'max:24'],
            'kuota_maksimal' => ['required', 'integer', 'min:1', 'max:20'],
            'titik_kumpul' => ['required', 'string', 'max:150'],
            'foto_sampul' => ['nullable', 'url'],
            'deskripsi_tur' => ['required', 'string'],
            // Validasi Itinerary Spots
            'spots' => ['nullable', 'array'],
            'spots.*.nama' => ['required', 'string', 'max:150'],
            'spots.*.aktivitas' => ['required', 'string'],
            'spots.*.estimasi' => ['required', 'integer', 'min:5'],
        ]);

        $paket = PaketTur::create([
            'id_pemandu' => $pemandu->id_pemandu,
            'id_kategori' => $request->id_kategori,
            'id_kota' => $request->id_kota,
            'judul_tur' => $request->judul_tur,
            'deskripsi_tur' => $request->deskripsi_tur,
            'durasi_jam' => $request->durasi_jam,
            'harga_per_orang' => $request->harga_per_orang,
            'kuota_maksimal' => $request->kuota_maksimal,
            'titik_kumpul' => $request->titik_kumpul,
            'bisa_kustom' => $request->boolean('bisa_kustom', true),
            'foto_sampul' => $request->foto_sampul ?? 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80',
        ]);

        // Simpan titik itinerary jika diisi
        if ($request->has('spots')) {
            $urutan = 1;
            foreach ($request->spots as $spot) {
                if (!empty($spot['nama'])) {
                    RuteItinerary::create([
                        'id_paket' => $paket->id_paket,
                        'urutan_ke' => $urutan++,
                        'nama_lokasi_spot' => $spot['nama'],
                        'aktivitas_cerita' => $spot['aktivitas'],
                        'estimasi_menit' => $spot['estimasi'] ?? 45,
                    ]);
                }
            }
        }

        return redirect('/pemandu/dashboard')->with('success', 'Paket tur privat baru berhasil diterbitkan!');
    }
}
