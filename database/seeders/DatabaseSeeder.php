<?php

namespace Database\Seeders;

use App\Models\Bahasa;
use App\Models\KategoriTur;
use App\Models\KotaDestinasi;
use App\Models\PaketTur;
use App\Models\PemanduLokal;
use App\Models\RuteItinerary;
use App\Models\User;
use App\Models\Wisatawan;
use App\Models\ReservasiTur;
use App\Models\Pembayaran;
use App\Models\UlasanTur;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Admin Wisatara
        $admin = User::create([
            'name' => 'Administrator Wisatara',
            'username' => 'admin',
            'email' => 'admin@wisatara.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'status_aktif' => true,
        ]);

        // 2. Master Kota Destinasi
        $bali = KotaDestinasi::create([
            'nama_kota' => 'Denpasar & Ubud, Bali',
            'provinsi' => 'Bali',
            'deskripsi_kota' => 'Pusat seni, budaya spiritual, pemandangan sawah terasering, dan pantai eksotis.',
            'foto_kota' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=800&q=80',
        ]);

        $jogja = KotaDestinasi::create([
            'nama_kota' => 'Yogyakarta',
            'provinsi' => 'D.I. Yogyakarta',
            'deskripsi_kota' => 'Kota pelajar dan budaya dengan warisan keraton, candi megah, serta kuliner legendaris.',
            'foto_kota' => 'https://images.unsplash.com/photo-1584810359583-96fc3448beaa?auto=format&fit=crop&w=800&q=80',
        ]);

        $jakarta = KotaDestinasi::create([
            'nama_kota' => 'Jakarta',
            'provinsi' => 'DKI Jakarta',
            'deskripsi_kota' => 'Metropolitan dinamis dengan sejarah Kota Tua, ragam kuliner jalanan, dan modernitas.',
            'foto_kota' => 'https://images.unsplash.com/photo-1555899434-94d1368aa7af?auto=format&fit=crop&w=800&q=80',
        ]);

        $bandung = KotaDestinasi::create([
            'nama_kota' => 'Bandung',
            'provinsi' => 'Jawa Barat',
            'deskripsi_kota' => 'Kota kembang berhawa sejuk dengan pesona arsitektur art-deco dan keindahan alam pegunungan.',
            'foto_kota' => 'https://images.unsplash.com/photo-1549488344-1f9b8d2bd1f3?auto=format&fit=crop&w=800&q=80',
        ]);

        // 3. Master Kategori Tur
        $katKuliner = KategoriTur::create([
            'nama_kategori' => 'Food & Drink (Street Food)',
            'deskripsi' => 'Eksplorasi kuliner lokal autentik, jajanan pasar tradisional, dan minuman khas daerah.',
        ]);

        $katBudaya = KategoriTur::create([
            'nama_kategori' => 'History & Culture',
            'deskripsi' => 'Napak tilas warisan sejarah, kehidupan keraton, candi kuno, dan kearifan lokal.',
        ]);

        $katHiddenGems = KategoriTur::create([
            'nama_kategori' => 'Hidden Gems & Local Life',
            'deskripsi' => 'Kunjungi tempat-tempat tersembunyi yang jarang didatangi turis bersama warga lokal.',
        ]);

        $katDayTrip = KategoriTur::create([
            'nama_kategori' => 'Day Trip by Car',
            'deskripsi' => 'Perjalanan privat seharian nyaman dengan mobil didampingi pemandu berlisensi.',
        ]);

        // 4. Master Bahasa
        $langId = Bahasa::create(['nama_bahasa' => 'Bahasa Indonesia']);
        $langEn = Bahasa::create(['nama_bahasa' => 'English']);
        $langDe = Bahasa::create(['nama_bahasa' => 'Deutsch (Jerman)']);
        $langNl = Bahasa::create(['nama_bahasa' => 'Nederlands (Belanda)']);
        $langJp = Bahasa::create(['nama_bahasa' => 'Japanese']);

        // 5. Akun Pemandu Lokal 1 (Yogyakarta)
        $userGuide1 = User::create([
            'name' => 'Bagus Wicaksono',
            'username' => 'bagus_guide',
            'email' => 'bagus@wisatara.com',
            'password' => Hash::make('password123'),
            'role' => 'pemandu',
            'status_aktif' => true,
        ]);

        $guide1 = PemanduLokal::create([
            'id_user' => $userGuide1->id_user,
            'id_kota' => $jogja->id_kota,
            'nama_pemandu' => 'Bagus Wicaksono',
            'tagline_pemandu' => 'The Yogyakarta Historian & Culinary Storyteller',
            'tentang_saya' => 'Lahir dan besar di kawasan Kotagede, saya gemar menceritakan sejarah tersembunyi di balik lorong-lorong tua Jogja dan mengajak Anda menikmati jajanan malam legendaris.',
            'foto_profil' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=400&q=80',
            'video_perkenalan' => 'https://www.youtube.com/watch?v=sample1',
            'no_hp' => '081234567890',
            'status_verifikasi' => 'Terverifikasi',
            'status_ketersediaan' => 'Tersedia',
        ]);
        $guide1->bahasa()->attach([$langId->id_bahasa, $langEn->id_bahasa, $langNl->id_bahasa]);

        // 6. Akun Pemandu Lokal 2 (Bali)
        $userGuide2 = User::create([
            'name' => 'Wayan Sudarma',
            'username' => 'wayan_bali',
            'email' => 'wayan@wisatara.com',
            'password' => Hash::make('password123'),
            'role' => 'pemandu',
            'status_aktif' => true,
        ]);

        $guide2 = PemanduLokal::create([
            'id_user' => $userGuide2->id_user,
            'id_kota' => $bali->id_kota,
            'nama_pemandu' => 'Wayan Sudarma',
            'tagline_pemandu' => 'Ubud Hidden Waterfalls & Spiritual Guide',
            'tentang_saya' => 'Pemandu lokal berpengalaman lebih dari 8 tahun di Bali tengah. Saya akan menunjukkan keindahan alam pedesaan, air terjun rahasia, serta upacara adat Bali.',
            'foto_profil' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=400&q=80',
            'video_perkenalan' => 'https://www.youtube.com/watch?v=sample2',
            'no_hp' => '081298765432',
            'status_verifikasi' => 'Terverifikasi',
            'status_ketersediaan' => 'Tersedia',
        ]);
        $guide2->bahasa()->attach([$langId->id_bahasa, $langEn->id_bahasa, $langDe->id_bahasa]);

        // Pemandu 3 (Menunggu Verifikasi)
        $userGuide3 = User::create([
            'name' => 'Siti Rahmawati',
            'username' => 'siti_jkt',
            'email' => 'siti@wisatara.com',
            'password' => Hash::make('password123'),
            'role' => 'pemandu',
            'status_aktif' => true,
        ]);
        $guide3 = PemanduLokal::create([
            'id_user' => $userGuide3->id_user,
            'id_kota' => $jakarta->id_kota,
            'nama_pemandu' => 'Siti Rahmawati',
            'tagline_pemandu' => 'Old Batavia Street Foodie Specialist',
            'tentang_saya' => 'Pecinta kuliner kaki lima Jakarta. Siap mengajak turis menjelajahi cita rasa Betawi autentik.',
            'foto_profil' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=400&q=80',
            'no_hp' => '081377889900',
            'status_verifikasi' => 'Menunggu',
            'status_ketersediaan' => 'Tersedia',
        ]);
        $guide3->bahasa()->attach([$langId->id_bahasa, $langEn->id_bahasa]);

        // 7. Paket Tur Pemandu 1
        $paket1 = PaketTur::create([
            'id_pemandu' => $guide1->id_pemandu,
            'id_kategori' => $katKuliner->id_kategori,
            'id_kota' => $jogja->id_kota,
            'judul_tur' => 'The 10 Tastings of Yogyakarta: Night Street Food Tour',
            'deskripsi_tur' => 'Jelajahi kelezatan kuliner malam Jogja dari Gudeg legendaris, Bakpia basah hangat langsung dari oven, hingga Kopi Jos arang membara.',
            'durasi_jam' => 3,
            'harga_per_orang' => 250000,
            'kuota_maksimal' => 5,
            'titik_kumpul' => 'Depan Benteng Vredeburg, Malioboro',
            'bisa_kustom' => true,
            'foto_sampul' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=800&q=80',
        ]);

        RuteItinerary::create([
            'id_paket' => $paket1->id_paket,
            'urutan_ke' => 1,
            'nama_lokasi_spot' => 'Kawasan Titik Nol & Malioboro',
            'aktivitas_cerita' => 'Mencicipi wedang ronde hangat dan pengantar sejarah kuliner jalanan tempo dulu.',
            'estimasi_menit' => 45,
        ]);
        RuteItinerary::create([
            'id_paket' => $paket1->id_paket,
            'urutan_ke' => 2,
            'nama_lokasi_spot' => 'Sentra Gudeg Wijilan',
            'aktivitas_cerita' => 'Menikmati seporsi Gudeg basah otentik resep turun temurun lebih dari 50 tahun.',
            'estimasi_menit' => 60,
        ]);
        RuteItinerary::create([
            'id_paket' => $paket1->id_paket,
            'urutan_ke' => 3,
            'nama_lokasi_spot' => 'Angkringan Kopi Jos Lik Man',
            'aktivitas_cerita' => 'Sensasi unik kopi dicelup arang panas membara sambil bersantai seperti warga lokal.',
            'estimasi_menit' => 45,
        ]);

        // Paket Tur Pemandu 2
        $paket2 = PaketTur::create([
            'id_pemandu' => $guide2->id_pemandu,
            'id_kategori' => $katHiddenGems->id_kategori,
            'id_kota' => $bali->id_kota,
            'judul_tur' => 'Ubud Hidden Waterfalls & Traditional Village Life',
            'deskripsi_tur' => 'Tur privat santai menjauh dari keramaian turis menuju mata air suci, lembah sawah tersembunyi, dan rumah tradisional Bali.',
            'durasi_jam' => 5,
            'harga_per_orang' => 450000,
            'kuota_maksimal' => 4,
            'titik_kumpul' => 'Ubud Traditional Art Market',
            'bisa_kustom' => true,
            'foto_sampul' => 'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?auto=format&fit=crop&w=800&q=80',
        ]);

        RuteItinerary::create([
            'id_paket' => $paket2->id_paket,
            'urutan_ke' => 1,
            'nama_lokasi_spot' => 'Suwat Hidden Waterfall',
            'aktivitas_cerita' => 'Berenang di kolam alami air terjun tersembunyi berair jernih.',
            'estimasi_menit' => 90,
        ]);
        RuteItinerary::create([
            'id_paket' => $paket2->id_paket,
            'urutan_ke' => 2,
            'nama_lokasi_spot' => 'Desa Adat & Pembuat Canang Sari',
            'aktivitas_cerita' => 'Belajar membuat canang sari persembahan adat Bali bersama keluarga lokal.',
            'estimasi_menit' => 75,
        ]);

        // 8. Akun Wisatawan & Contoh Reservasi
        $userGuest = User::create([
            'name' => 'Michael van Dijk',
            'username' => 'michael_nl',
            'email' => 'michael@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'wisatawan',
            'status_aktif' => true,
        ]);

        $wisatawan = Wisatawan::create([
            'id_user' => $userGuest->id_user,
            'nama_lengkap' => 'Michael van Dijk',
            'negara_asal' => 'Belanda',
            'no_hp' => '+31612345678',
            'preferensi_bahasa' => 'Nederlands, English',
            'foto_profil' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=400&q=80',
        ]);

        $reservasi = ReservasiTur::create([
            'id_wisatawan' => $wisatawan->id_wisatawan,
            'id_paket' => $paket1->id_paket,
            'id_pemandu' => $guide1->id_pemandu,
            'tgl_tur' => now()->addDays(2)->format('Y-m-d'),
            'jam_mulai' => '18:00:00',
            'jumlah_peserta' => 2,
            'catatan_kustomisasi' => 'Tolong kurangi level kepedasan karena teman saya tidak bisa makan terlalu pedas.',
            'total_harga' => 500000,
            'status_reservasi' => 'Selesai',
        ]);

        Pembayaran::create([
            'id_reservasi' => $reservasi->id_reservasi,
            'metode_bayar' => 'BCA Virtual Account',
            'jumlah_bayar' => 500000,
            'waktu_bayar' => now()->subDay(),
            'status_bayar' => 'Lunas',
        ]);

        UlasanTur::create([
            'id_reservasi' => $reservasi->id_reservasi,
            'id_wisatawan' => $wisatawan->id_wisatawan,
            'id_pemandu' => $guide1->id_pemandu,
            'rating' => 5,
            'komentar' => 'Pengalaman luar biasa bersama Mas Bagus! Kami diajak ke tempat-tempat yang tidak ada di Google Maps. Sangat direkomendasikan!',
            'tgl_ulasan' => now()->format('Y-m-d'),
        ]);
    }
}
