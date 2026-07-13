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
        Schema::create('buku', function (Blueprint $table) {
            // Primary Key: no_document
            $table->bigIncrements('no_document')->unsigned();

            // Kolom metadata
            $table->string('kode_panggil', 100)->nullable();
            $table->string('judul', 255);
            $table->string('judul_pararel', 255)->nullable();
            $table->string('judul_lain', 255)->nullable();
            $table->string('penulis', 255)->nullable();
            $table->string('penulis_badan', 255)->nullable();
            $table->string('pertanggungjawaban', 255)->nullable();
            $table->string('pertanggungjawaban_pararel', 255)->nullable();
            $table->string('badan_lain', 255)->nullable();
            $table->string('konferensi', 255)->nullable();
            $table->string('nama_penerbit', 255)->nullable();
            $table->string('lokasi_penerbit', 255)->nullable();
            $table->year('tahun_terbit')->nullable();
            $table->string('edisi', 100)->nullable();
            $table->string('seri', 100)->nullable();

            // Kolom Subjek dan Deskripsi
            $table->string('kategori', 50)->nullable();
            $table->string('subyek', 255)->nullable();
            $table->string('bahasa_teks', 255)->nullable();
            $table->string('media_dokumen', 100)->nullable();
            $table->string('jenis_dokumen', 100)->nullable();
            $table->string('lokasi_dokumen', 255)->nullable();

            // Kolom ENUM
            $table->enum('buku_sumbangan', ['Ya', 'Tidak'])->default('Tidak');

            // Kolom Teks Panjang
            $table->string('deskripsi_fisik', 255)->nullable();
            $table->string('resensi', 255)->nullable();
            $table->text('catatan_umum')->nullable();
            $table->text('catatan_isi')->nullable();

            // Kolom Administrasi
            $table->date('tanggal_ketik')->nullable();
            $table->string('dokumentalis', 255)->nullable();

            // Kolom Stok (int unsigned)
            $table->integer('jumlah_dokumen')->unsigned()->default(0);
            $table->integer('jumlah_tersedia')->unsigned()->default(0);

            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};
