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
        Schema::create('peminjaman', function (Blueprint $table) {
            // Primary Key: id_peminjaman (sesuai gambar)
            $table->bigIncrements('id_peminjaman')->unsigned();

            // Foreign Key ke tabel anggota: no_anggota
            // Referensi kolom 'no_anggota' di tabel 'anggota'
            $table->foreignId('no_anggota')->constrained('anggota', 'no_anggota')->onDelete('cascade');

            // Kolom 'nip' dihapus sesuai permintaan

            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali')->nullable(); // Sesuai gambar

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
