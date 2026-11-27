<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Reservasi {{ $kode }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #1e293b;
            font-size: 12px;
            line-height: 1.5;
            margin: 0;
            padding: 24px;
        }
        .header {
            border-bottom: 2px solid #059669;
            padding-bottom: 14px;
            margin-bottom: 20px;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
        }
        .brand {
            font-size: 22px;
            font-weight: bold;
            color: #059669;
            margin: 0;
        }
        .subtitle {
            font-size: 11px;
            color: #64748b;
            margin: 2px 0 0 0;
        }
        .badge-lunas {
            display: inline-block;
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #10b981;
            font-weight: bold;
            font-size: 11px;
            padding: 4px 12px;
            border-radius: 4px;
        }
        .code-text {
            font-size: 14px;
            font-weight: bold;
            color: #0f172a;
            margin: 4px 0;
        }
        .section-title {
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            color: #059669;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 4px;
            margin: 18px 0 10px 0;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 4px 6px;
            vertical-align: top;
        }
        .label {
            color: #64748b;
            width: 32%;
        }
        .value {
            color: #0f172a;
            font-weight: bold;
        }
        .box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 12px;
            margin-top: 8px;
        }
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .summary-table th {
            background-color: #0f172a;
            color: #ffffff;
            text-align: left;
            padding: 8px 10px;
            font-size: 11px;
        }
        .summary-table td {
            border-bottom: 1px solid #e2e8f0;
            padding: 8px 10px;
        }
        .text-right {
            text-align: right;
        }
        .total-row td {
            font-size: 14px;
            font-weight: bold;
            color: #059669;
            background-color: #ecfdf5;
            border-top: 2px solid #059669;
        }
        .itinerary-item {
            margin-bottom: 6px;
        }
        .footer {
            margin-top: 28px;
            padding-top: 12px;
            border-top: 1px dashed #cbd5e1;
            text-align: center;
            font-size: 10px;
            color: #64748b;
        }
    </style>
</head>
<body>

    <div class="header">
        <table class="header-table">
            <tr>
                <td>
                    <p class="brand">WISATARA</p>
                    <p class="subtitle">Marketplace Pemandu Wisata Lokal &amp; Private Tour Nusantara</p>
                </td>
                <td class="text-right">
                    <div class="code-text">E-TIKET {{ $kode }}</div>
                    <span class="badge-lunas">PEMBAYARAN LUNAS</span>
                </td>
            </tr>
        </table>
    </div>

    <div class="section-title">Informasi Wisatawan &amp; Pemandu</div>
    <table class="info-table">
        <tr>
            <td class="label">Nama Wisatawan</td>
            <td class="value">{{ $reservasi->wisatawan->nama_lengkap ?? '-' }}</td>
            <td class="label">Pemandu Lokal</td>
            <td class="value">{{ $reservasi->pemandu->nama_pemandu ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Asal Negara</td>
            <td class="value">{{ $reservasi->wisatawan->negara_asal ?? 'Indonesia' }}</td>
            <td class="label">Kontak Pemandu</td>
            <td class="value">{{ $reservasi->pemandu->no_hp ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Kontak Wisatawan</td>
            <td class="value">{{ $reservasi->wisatawan->no_hp ?? '-' }}</td>
            <td class="label">Kota Destinasi</td>
            <td class="value">{{ $reservasi->paket->kota->nama_kota ?? '-' }}</td>
        </tr>
    </table>

    <div class="section-title">Detail Jadwal Private Tour</div>
    <div class="box">
        <table class="info-table">
            <tr>
                <td class="label">Paket Pengalaman</td>
                <td class="value">{{ $reservasi->paket->judul_tur ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal &amp; Jam Mulai</td>
                <td class="value">{{ \Carbon\Carbon::parse($reservasi->tgl_tur)->translatedFormat('d F Y') }}, Pukul {{ $reservasi->jam_mulai }} WIB</td>
            </tr>
            <tr>
                <td class="label">Durasi &amp; Peserta</td>
                <td class="value">{{ $reservasi->paket->durasi_jam ?? 3 }} Jam &bull; {{ $reservasi->jumlah_peserta }} Orang (100% Private)</td>
            </tr>
            <tr>
                <td class="label">Titik Kumpul</td>
                <td class="value">{{ $reservasi->paket->titik_kumpul ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Status Reservasi</td>
                <td class="value">{{ $reservasi->status_reservasi }}</td>
            </tr>
        </table>
    </div>

    @if($reservasi->catatan_kustomisasi)
        <div class="section-title">Catatan Kustomisasi Rute</div>
        <div class="box">
            {{ $reservasi->catatan_kustomisasi }}
        </div>
    @endif

    @if($reservasi->paket && $reservasi->paket->itinerary && $reservasi->paket->itinerary->count() > 0)
        <div class="section-title">Rencana Titik Singgah (Itinerary)</div>
        <div class="box">
            @foreach($reservasi->paket->itinerary as $spot)
                <div class="itinerary-item">
                    <strong>{{ $spot->urutan_ke }}. {{ $spot->nama_lokasi_spot }}</strong> ({{ $spot->estimasi_menit }} menit) &mdash; {{ $spot->aktivitas_cerita }}
                </div>
            @endforeach
        </div>
    @endif

    <div class="section-title">Rincian Pembayaran</div>
    <table class="summary-table">
        <thead>
            <tr>
                <th>Deskripsi</th>
                <th class="text-right">Tarif / Orang</th>
                <th class="text-right">Peserta</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $reservasi->paket->judul_tur ?? 'Paket Tur Privat' }}</td>
                <td class="text-right">Rp {{ number_format($reservasi->paket->harga_per_orang ?? 0, 0, ',', '.') }}</td>
                <td class="text-right">{{ $reservasi->jumlah_peserta }} Orang</td>
                <td class="text-right">Rp {{ number_format($reservasi->total_harga, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="3">TOTAL DIBAYAR ({{ $reservasi->pembayaran->metode_bayar ?? '-' }})</td>
                <td class="text-right">Rp {{ number_format($reservasi->pembayaran->jumlah_bayar ?? $reservasi->total_harga, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <p style="font-size: 10px; color: #64748b; margin-top: 8px;">
        Waktu Pembayaran: {{ $reservasi->pembayaran && $reservasi->pembayaran->waktu_bayar ? \Carbon\Carbon::parse($reservasi->pembayaran->waktu_bayar)->translatedFormat('d F Y, H:i') . ' WIB' : '-' }}
    </p>

    <div class="footer">
        Tunjukkan E-Tiket PDF ini kepada Pemandu Lokal saat bertemu di titik kumpul.<br>
        Dicetak otomatis oleh sistem Wisatara pada {{ now()->translatedFormat('d F Y, H:i') }} WIB.
    </div>

</body>
</html>
