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

    public function kirimUlasan(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->role !== 'wisatawan') {
            return redirect('/');
        }

        $wisatawan = Wisatawan::where('id_user', $user->id_user)->firstOrFail();
        $reservasi = ReservasiTur::where('id_wisatawan', $wisatawan->id_wisatawan)
            ->where('status_reservasi', 'Selesai')
            ->findOrFail($id);

        if (\App\Models\UlasanTur::where('id_reservasi', $reservasi->id_reservasi)->exists()) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk tur ini.');
        }

        $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'komentar' => ['required', 'string', 'max:500'],
        ]);

        \App\Models\UlasanTur::create([
            'id_reservasi' => $reservasi->id_reservasi,
            'id_wisatawan' => $wisatawan->id_wisatawan,
            'id_pemandu' => $reservasi->id_pemandu,
            'rating' => $request->rating,
            'komentar' => $request->komentar,
            'tgl_ulasan' => now()->format('Y-m-d'),
        ]);

        return back()->with('success', 'Terima kasih! Ulasan dan rating Anda telah berhasil dikirim.');
    }

    public function unduhPdf($id)
    {
        $user = Auth::user();
        if ($user->role !== 'wisatawan') {
            return redirect('/');
        }

        $wisatawan = Wisatawan::where('id_user', $user->id_user)->firstOrFail();
        $reservasi = ReservasiTur::where('id_wisatawan', $wisatawan->id_wisatawan)
            ->with(['wisatawan', 'paket.kota', 'paket.itinerary', 'pemandu', 'pembayaran'])
            ->findOrFail($id);

        if (! $reservasi->pembayaran || $reservasi->pembayaran->status_bayar !== 'Lunas') {
            return back()->with('error', 'Bukti PDF hanya dapat diunduh setelah pembayaran berstatus Lunas.');
        }

        $kode = '#WST-' . str_pad($reservasi->id_reservasi, 4, '0', STR_PAD_LEFT);
        $fileKode = 'WST-' . str_pad($reservasi->id_reservasi, 4, '0', STR_PAD_LEFT);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('wisatawan.invoice-pdf', compact('reservasi', 'kode'))
            ->setPaper('a4', 'portrait');

        return $pdf->download("E-Tiket-Wisatara-{$fileKode}.pdf");
    }
}
