<?php

namespace App\Http\Controllers;

use App\Models\PaketTur;
use App\Models\Pembayaran;
use App\Models\ReservasiTur;
use App\Models\Wisatawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function showForm($id)
    {
        $paket = PaketTur::with(['pemandu.kota', 'kategori', 'itinerary'])->findOrFail($id);

        if (!Auth::check()) {
            return redirect('/login')->with('warning', 'Silakan masuk terlebih dahulu untuk memesan tur privat ini.');
        }

        $user = Auth::user();
        if ($user->role !== 'wisatawan') {
            return back()->with('error', 'Hanya akun wisatawan yang dapat memesan paket tur.');
        }

        $wisatawan = Wisatawan::where('id_user', $user->id_user)->firstOrFail();

        return view('booking.form', compact('paket', 'wisatawan'));
    }

    public function processBooking(Request $request, $id)
    {
        $paket = PaketTur::findOrFail($id);
        $user = Auth::user();

        if ($user->role !== 'wisatawan') {
            return redirect('/');
        }

        $wisatawan = Wisatawan::where('id_user', $user->id_user)->firstOrFail();

        $request->validate([
            'tgl_tur' => ['required', 'date', 'after_or_equal:today'],
            'jam_mulai' => ['required'],
            'jumlah_peserta' => ['required', 'integer', 'min:1', 'max:' . $paket->kuota_maksimal],
            'catatan_kustomisasi' => ['nullable', 'string', 'max:500'],
            'metode_bayar' => ['required', 'string'],
        ]);

        // Kalkulasi Total Harga (Aturan Bisnis No 4)
        $totalHarga = $paket->harga_per_orang * $request->jumlah_peserta;

        // Buat Reservasi Tur
        $reservasi = ReservasiTur::create([
            'id_wisatawan' => $wisatawan->id_wisatawan,
            'id_paket' => $paket->id_paket,
            'id_pemandu' => $paket->id_pemandu,
            'tgl_tur' => $request->tgl_tur,
            'jam_mulai' => $request->jam_mulai,
            'jumlah_peserta' => $request->jumlah_peserta,
            'catatan_kustomisasi' => $request->catatan_kustomisasi,
            'total_harga' => $totalHarga,
            'status_reservasi' => 'Menunggu', // Menunggu konfirmasi pemandu
        ]);

        // Catat Pembayaran (FR-12)
        Pembayaran::create([
            'id_reservasi' => $reservasi->id_reservasi,
            'metode_bayar' => $request->metode_bayar,
            'jumlah_bayar' => $totalHarga,
            'waktu_bayar' => now(),
            'status_bayar' => 'Lunas',
        ]);

        return redirect('/wisatawan/dashboard')->with('success', 'Reservasi tur berhasil dipesan dan pembayaran telah tercatat!');
    }
}
