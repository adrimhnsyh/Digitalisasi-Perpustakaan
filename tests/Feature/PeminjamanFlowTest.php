<?php

namespace Tests\Feature;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PeminjamanFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_loan_and_return_keep_stock_consistent(): void
    {
        $admin = User::factory()->create();
        $anggota = Anggota::query()->create([
            'nama' => 'Anggota Aktif',
            'no_telp' => '081234567890',
            'status' => 'Mahasiswa',
        ]);
        $buku = Buku::query()->create([
            'judul' => 'Koleksi Uji',
            'kategori' => 'Buku',
            'buku_sumbangan' => 'Tidak',
            'jumlah_dokumen' => 3,
            'jumlah_tersedia' => 3,
        ]);

        $this->actingAs($admin)
            ->post(route('admin.peminjaman.store'), [
                'anggota_id' => $anggota->no_anggota,
                'buku_dipinjam' => [$buku->no_document],
            ])
            ->assertRedirect(route('admin.peminjaman.index'));

        $loan = Peminjaman::query()->sole();
        $this->assertDatabaseHas('detail_peminjaman', [
            'id_peminjaman' => $loan->id_peminjaman,
            'no_document' => $buku->no_document,
            'status_item' => 'Dipinjam',
        ]);
        $this->assertSame(2, $buku->refresh()->jumlah_tersedia);
        $this->assertSame(3, $buku->jumlah_dokumen);

        $this->actingAs($admin)
            ->post(route('admin.peminjaman.return-items', $loan), [
                'details_kembali' => [$buku->no_document],
            ])
            ->assertRedirect(route('admin.peminjaman.show', $loan));

        $detail = DetailPeminjaman::query()->sole();
        $this->assertSame('Dikembalikan', $detail->status_item);
        $this->assertNotNull($detail->tanggal_dikembalikan);
        $this->assertSame(3, $buku->refresh()->jumlah_tersedia);
    }

    public function test_a_non_active_member_cannot_create_a_loan(): void
    {
        $admin = User::factory()->create();
        $anggota = Anggota::query()->create([
            'nama' => 'Anggota Non Aktif',
            'no_telp' => '081234567891',
            'status' => 'Non Aktif',
        ]);
        $buku = Buku::query()->create([
            'judul' => 'Koleksi Uji',
            'kategori' => 'Buku',
            'buku_sumbangan' => 'Tidak',
            'jumlah_dokumen' => 1,
            'jumlah_tersedia' => 1,
        ]);

        $this->actingAs($admin)
            ->from(route('admin.peminjaman.create'))
            ->post(route('admin.peminjaman.store'), [
                'anggota_id' => $anggota->no_anggota,
                'buku_dipinjam' => [$buku->no_document],
            ])
            ->assertRedirect(route('admin.peminjaman.create'))
            ->assertSessionHasErrors('anggota_id');

        $this->assertDatabaseCount('peminjaman', 0);
        $this->assertSame(1, $buku->refresh()->jumlah_tersedia);
    }

    public function test_total_stock_cannot_be_reduced_below_active_loans(): void
    {
        $admin = User::factory()->create();
        $anggota = Anggota::query()->create([
            'nama' => 'Anggota Aktif',
            'no_telp' => '081234567892',
            'status' => 'Mahasiswa',
        ]);
        $buku = Buku::query()->create([
            'judul' => 'Koleksi dengan Pinjaman Aktif',
            'kategori' => 'Buku',
            'buku_sumbangan' => 'Tidak',
            'jumlah_dokumen' => 2,
            'jumlah_tersedia' => 1,
        ]);
        $loan = Peminjaman::query()->create([
            'no_anggota' => $anggota->no_anggota,
            'tanggal_pinjam' => today(),
            'tanggal_kembali' => today()->addDays(7),
        ]);
        $loan->detailPeminjaman()->create([
            'no_document' => $buku->no_document,
            'jumlah_pinjam' => 1,
            'status_item' => 'Dipinjam',
        ]);

        $this->actingAs($admin)
            ->from(route('admin.buku.edit', $buku))
            ->put(route('admin.buku.update', $buku), [
                'judul' => $buku->judul,
                'kategori' => 'Buku',
                'buku_sumbangan' => 'Tidak',
                'jumlah_dokumen' => 0,
            ])
            ->assertRedirect(route('admin.buku.edit', $buku))
            ->assertSessionHasErrors('jumlah_dokumen');

        $this->assertSame(2, $buku->refresh()->jumlah_dokumen);
        $this->assertSame(1, $buku->jumlah_tersedia);
    }
}
