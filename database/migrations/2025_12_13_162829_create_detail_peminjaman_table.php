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
        Schema::create('detail_peminjaman', function (Blueprint $table) {

            // Foreign Key ke tabel peminjaman (id_peminjaman)
            $table->unsignedBigInteger('id_peminjaman');
            $table->foreign('id_peminjaman')->references('id_peminjaman')->on('peminjaman')->onDelete('cascade');

            // Foreign Key ke tabel buku (no_document)
            $table->unsignedBigInteger('no_document');
            $table->foreign('no_document')->references('no_document')->on('buku')->onDelete('cascade');

            // Kolom jumlah_pinjam
            $table->integer('jumlah_pinjam')->unsigned()->default(1);

            // Kolom status_item (ENUM)
            $table->enum('status_item', ['Dipinjam', 'Dikembalikan'])->default('Dipinjam');

            $table->timestamps();

            // Mengatur kunci gabungan (composite unique key)
            $table->unique(['id_peminjaman', 'no_document']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_peminjaman');
    }
};
