<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->string('role', 20)->default('admin')->index();
            $table->boolean('is_active')->default(true);
        });

        Schema::table('buku', function (Blueprint $table): void {
            $table->unique('kode_panggil');
            $table->index('kategori');
        });

        Schema::table('peminjaman', function (Blueprint $table): void {
            $table->index('tanggal_kembali');
        });

        Schema::table('detail_peminjaman', function (Blueprint $table): void {
            $table->date('tanggal_dikembalikan')->nullable();
            $table->index('status_item');
        });

        $this->restoreLegacyStock();
        $this->hashLegacyPasswords();
        $this->protectLoanHistory();
    }

    public function down(): void
    {
        $this->restoreCascadeDeletes();

        Schema::table('detail_peminjaman', function (Blueprint $table): void {
            $table->dropIndex(['status_item']);
            $table->dropColumn('tanggal_dikembalikan');
        });

        Schema::table('peminjaman', function (Blueprint $table): void {
            $table->dropIndex(['tanggal_kembali']);
        });

        Schema::table('buku', function (Blueprint $table): void {
            $table->dropIndex(['kategori']);
            $table->dropUnique(['kode_panggil']);
        });

        Schema::table('users', function (Blueprint $table): void {
            $table->dropIndex(['role']);
            $table->dropColumn(['role', 'is_active']);
        });
    }

    private function restoreLegacyStock(): void
    {
        // Older code decremented jumlah_dokumen and never populated jumlah_tersedia.
        if (DB::table('buku')->where('jumlah_tersedia', '>', 0)->exists()) {
            return;
        }

        $borrowedByDocument = DB::table('detail_peminjaman')
            ->selectRaw('no_document, sum(jumlah_pinjam) as quantity')
            ->where('status_item', 'Dipinjam')
            ->groupBy('no_document')
            ->pluck('quantity', 'no_document');

        DB::table('buku')->orderBy('no_document')->each(function (object $buku) use ($borrowedByDocument): void {
            $available = (int) $buku->jumlah_dokumen;
            $borrowed = (int) ($borrowedByDocument[$buku->no_document] ?? 0);

            DB::table('buku')
                ->where('no_document', $buku->no_document)
                ->update([
                    'jumlah_dokumen' => $available + $borrowed,
                    'jumlah_tersedia' => $available,
                ]);
        });
    }

    private function hashLegacyPasswords(): void
    {
        DB::table('users')->orderBy('id')->each(function (object $user): void {
            if (Hash::isHashed($user->password)) {
                return;
            }

            DB::table('users')
                ->where('id', $user->id)
                ->update([
                    'password' => Hash::make($user->password),
                    'updated_at' => now(),
                ]);
        });
    }

    private function protectLoanHistory(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        Schema::table('detail_peminjaman', function (Blueprint $table): void {
            $table->dropForeign(['id_peminjaman']);
            $table->dropForeign(['no_document']);
        });

        Schema::table('peminjaman', function (Blueprint $table): void {
            $table->dropForeign(['no_anggota']);
        });

        Schema::table('peminjaman', function (Blueprint $table): void {
            $table->foreign('no_anggota')
                ->references('no_anggota')
                ->on('anggota')
                ->restrictOnDelete();
        });

        Schema::table('detail_peminjaman', function (Blueprint $table): void {
            $table->foreign('id_peminjaman')
                ->references('id_peminjaman')
                ->on('peminjaman')
                ->restrictOnDelete();
            $table->foreign('no_document')
                ->references('no_document')
                ->on('buku')
                ->restrictOnDelete();
        });
    }

    private function restoreCascadeDeletes(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        Schema::table('detail_peminjaman', function (Blueprint $table): void {
            $table->dropForeign(['id_peminjaman']);
            $table->dropForeign(['no_document']);
        });

        Schema::table('peminjaman', function (Blueprint $table): void {
            $table->dropForeign(['no_anggota']);
        });

        Schema::table('peminjaman', function (Blueprint $table): void {
            $table->foreign('no_anggota')
                ->references('no_anggota')
                ->on('anggota')
                ->cascadeOnDelete();
        });

        Schema::table('detail_peminjaman', function (Blueprint $table): void {
            $table->foreign('id_peminjaman')
                ->references('id_peminjaman')
                ->on('peminjaman')
                ->cascadeOnDelete();
            $table->foreign('no_document')
                ->references('no_document')
                ->on('buku')
                ->cascadeOnDelete();
        });
    }
};
