<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Kota Destinasi
        Schema::create('kota_destinasi', function (Blueprint $table) {
            $table->id('id_kota');
            $table->string('nama_kota', 100);
            $table->string('provinsi', 100);
            $table->text('deskripsi_kota')->nullable();
            $table->string('foto_kota')->nullable();
            $table->timestamps();
        });

        // 2. Kategori Tur
        Schema::create('kategori_tur', function (Blueprint $table) {
            $table->id('id_kategori');
            $table->string('nama_kategori', 100);
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        // 3. Bahasa
        Schema::create('bahasa', function (Blueprint $table) {
            $table->id('id_bahasa');
            $table->string('nama_bahasa', 50);
            $table->timestamps();
        });

        // 4. Wisatawan (Guest)
        Schema::create('wisatawan', function (Blueprint $table) {
            $table->id('id_wisatawan');
            $table->foreignId('id_user')->constrained('users', 'id_user')->cascadeOnDelete();
            $table->string('nama_lengkap', 100);
            $table->string('negara_asal', 50)->default('Indonesia');
            $table->string('no_hp', 15)->nullable();
            $table->string('preferensi_bahasa', 50)->nullable();
            $table->string('foto_profil')->nullable();
            $table->timestamps();
        });

        // 5. Pemandu Lokal (Local Host)
        Schema::create('pemandu_lokal', function (Blueprint $table) {
            $table->id('id_pemandu');
            $table->foreignId('id_user')->constrained('users', 'id_user')->cascadeOnDelete();
            $table->foreignId('id_kota')->constrained('kota_destinasi', 'id_kota')->cascadeOnDelete();
            $table->string('nama_pemandu', 100);
            $table->string('tagline_pemandu', 150)->nullable();
            $table->text('tentang_saya')->nullable();
            $table->string('foto_profil')->nullable();
            $table->string('video_perkenalan')->nullable();
            $table->string('no_hp', 15)->nullable();
            $table->enum('status_verifikasi', ['Menunggu', 'Terverifikasi', 'Ditolak'])->default('Menunggu');
            $table->enum('status_ketersediaan', ['Tersedia', 'Tidak Tersedia'])->default('Tersedia');
            $table->timestamps();
        });

        // Pivot Bahasa Pemandu
        Schema::create('bahasa_pemandu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pemandu')->constrained('pemandu_lokal', 'id_pemandu')->cascadeOnDelete();
            $table->foreignId('id_bahasa')->constrained('bahasa', 'id_bahasa')->cascadeOnDelete();
            $table->string('tingkat_kefasihan', 50)->default('Lancar');
            $table->timestamps();
        });

        // 6. Paket Tur (Unique Experiences)
        Schema::create('paket_tur', function (Blueprint $table) {
            $table->id('id_paket');
            $table->foreignId('id_pemandu')->constrained('pemandu_lokal', 'id_pemandu')->cascadeOnDelete();
            $table->foreignId('id_kategori')->constrained('kategori_tur', 'id_kategori')->cascadeOnDelete();
            $table->foreignId('id_kota')->constrained('kota_destinasi', 'id_kota')->cascadeOnDelete();
            $table->string('judul_tur', 150);
            $table->text('deskripsi_tur');
            $table->integer('durasi_jam')->default(3);
            $table->decimal('harga_per_orang', 12, 2);
            $table->integer('kuota_maksimal')->default(6);
            $table->string('titik_kumpul', 150);
            $table->boolean('bisa_kustom')->default(true);
            $table->string('foto_sampul')->nullable();
            $table->timestamps();
        });

        // 7. Rute Itinerary
        Schema::create('rute_itinerary', function (Blueprint $table) {
            $table->id('id_itinerary');
            $table->foreignId('id_paket')->constrained('paket_tur', 'id_paket')->cascadeOnDelete();
            $table->integer('urutan_ke');
            $table->string('nama_lokasi_spot', 150);
            $table->text('aktivitas_cerita');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->integer('estimasi_menit')->default(45);
            $table->timestamps();
        });

        // 8. Reservasi Tur
        Schema::create('reservasi_tur', function (Blueprint $table) {
            $table->id('id_reservasi');
            $table->foreignId('id_wisatawan')->constrained('wisatawan', 'id_wisatawan')->cascadeOnDelete();
            $table->foreignId('id_paket')->constrained('paket_tur', 'id_paket')->cascadeOnDelete();
            $table->foreignId('id_pemandu')->constrained('pemandu_lokal', 'id_pemandu')->cascadeOnDelete();
            $table->date('tgl_tur');
            $table->time('jam_mulai');
            $table->integer('jumlah_peserta');
            $table->text('catatan_kustomisasi')->nullable();
            $table->decimal('total_harga', 12, 2);
            $table->enum('status_reservasi', ['Menunggu', 'Dikonfirmasi', 'Ditolak', 'Selesai', 'Dibatalkan'])->default('Menunggu');
            $table->timestamps();
        });

        // 9. Pembayaran
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->foreignId('id_reservasi')->unique()->constrained('reservasi_tur', 'id_reservasi')->cascadeOnDelete();
            $table->string('metode_bayar', 50);
            $table->decimal('jumlah_bayar', 12, 2);
            $table->dateTime('waktu_bayar')->nullable();
            $table->enum('status_bayar', ['Belum Bayar', 'Lunas', 'Gagal', 'Refund'])->default('Belum Bayar');
            $table->timestamps();
        });

        // 10. Ulasan Tur
        Schema::create('ulasan_tur', function (Blueprint $table) {
            $table->id('id_ulasan');
            $table->foreignId('id_reservasi')->constrained('reservasi_tur', 'id_reservasi')->cascadeOnDelete();
            $table->foreignId('id_wisatawan')->constrained('wisatawan', 'id_wisatawan')->cascadeOnDelete();
            $table->foreignId('id_pemandu')->constrained('pemandu_lokal', 'id_pemandu')->cascadeOnDelete();
            $table->unsignedTinyInteger('rating');
            $table->text('komentar');
            $table->date('tgl_ulasan')->default(now());
            $table->timestamps();
        });

        // 11. Favorit Wisatawan
        Schema::create('favorit_wisatawan', function (Blueprint $table) {
            $table->id('id_favorit');
            $table->foreignId('id_wisatawan')->constrained('wisatawan', 'id_wisatawan')->cascadeOnDelete();
            $table->foreignId('id_paket')->nullable()->constrained('paket_tur', 'id_paket')->cascadeOnDelete();
            $table->foreignId('id_pemandu')->nullable()->constrained('pemandu_lokal', 'id_pemandu')->cascadeOnDelete();
            $table->dateTime('tgl_simpan')->default(now());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorit_wisatawan');
        Schema::dropIfExists('ulasan_tur');
        Schema::dropIfExists('pembayaran');
        Schema::dropIfExists('reservasi_tur');
        Schema::dropIfExists('rute_itinerary');
        Schema::dropIfExists('paket_tur');
        Schema::dropIfExists('bahasa_pemandu');
        Schema::dropIfExists('pemandu_lokal');
        Schema::dropIfExists('wisatawan');
        Schema::dropIfExists('bahasa');
        Schema::dropIfExists('kategori_tur');
        Schema::dropIfExists('kota_destinasi');
    }
};
