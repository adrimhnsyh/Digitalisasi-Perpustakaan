<?php

namespace Tests\Feature;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\KontenPublik;
use App\Models\Peminjaman;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicExperienceTest extends TestCase
{
    use RefreshDatabase;

    public function test_catalog_content_and_exploration_pages_are_available(): void
    {
        $book = Buku::query()->create([
            'judul' => 'Koleksi Publik',
            'kategori' => 'Buku',
            'buku_sumbangan' => 'Tidak',
            'jumlah_dokumen' => 1,
            'jumlah_tersedia' => 1,
        ]);
        $content = KontenPublik::query()->published()->firstOrFail();

        $this->get(route('catalog.index'))->assertOk();
        $this->get(route('catalog.show', $book))->assertOk()->assertSee('Koleksi Publik');
        $this->get(route('explore.index'))->assertOk();
        $this->get(route('public-content.show', $content))->assertOk()->assertSee($content->title);
    }

    public function test_visitor_can_submit_a_library_request(): void
    {
        $this->from(route('explore.index'))->post(route('public-request.store'), [
            'type' => 'usulan_buku',
            'name' => 'Mahasiswa STMI',
            'email' => 'mahasiswa@example.test',
            'subject' => 'Usulan buku kendaraan listrik',
            'message' => 'Mohon menambahkan buku terbaru tentang desain dan perawatan kendaraan listrik.',
        ])->assertRedirect(route('explore.index'))
            ->assertSessionHas('request_success');

        $this->assertDatabaseHas('permintaan_publik', [
            'type' => 'usulan_buku',
            'email' => 'mahasiswa@example.test',
            'status' => 'baru',
        ]);
    }

    public function test_member_can_check_their_loan_history_with_phone_verification(): void
    {
        $member = Anggota::query()->create([
            'nama' => 'Anggota Terverifikasi',
            'no_telp' => '0812-3456-7890',
            'no_identitas' => '20260001',
            'status' => 'Mahasiswa',
        ]);
        $book = Buku::query()->create([
            'judul' => 'Buku Sedang Dipinjam',
            'kategori' => 'Buku',
            'buku_sumbangan' => 'Tidak',
            'jumlah_dokumen' => 1,
            'jumlah_tersedia' => 0,
        ]);
        $loan = Peminjaman::query()->create([
            'no_anggota' => $member->getKey(),
            'tanggal_pinjam' => today(),
            'tanggal_kembali' => today()->addDays(7),
        ]);
        $loan->detailPeminjaman()->create([
            'no_document' => $book->getKey(),
            'jumlah_pinjam' => 1,
            'status_item' => 'Dipinjam',
        ]);

        $this->post(route('loan-status.check'), [
            'no_identitas' => '20260001',
            'phone_last_four' => '7890',
        ])->assertOk()
            ->assertSee('Anggota Terverifikasi')
            ->assertSee('Buku Sedang Dipinjam');
    }
}
