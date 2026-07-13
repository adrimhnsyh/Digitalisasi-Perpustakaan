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
        Schema::create('anggota', function (Blueprint $table) {
            // Kolom Primary Key (disesuaikan dari id() menjadi no_anggota)
            $table->bigIncrements('no_anggota')->unsigned();

            $table->string('nama', 100);
            $table->text('alamat')->nullable(); // Menggunakan text
            $table->string('no_telp', 20)->unique();

            // Kolom ENUM
            $table->enum('status', ['Mahasiswa', 'Dosen', 'Dosen Luar', 'Non Aktif'])->default('Mahasiswa');

            $table->string('no_identitas', 50)->nullable(); // Nomor KTP/NIM/NIP

            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggota');
    }
};
