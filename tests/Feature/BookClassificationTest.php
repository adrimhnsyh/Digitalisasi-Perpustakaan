<?php

namespace Tests\Feature;

use App\Models\Buku;
use App\Models\KlasifikasiBuku;
use App\Models\User;
use App\Services\BookClassificationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookClassificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_classifies_a_book_from_its_title_subject_and_abstract(): void
    {
        $result = app(BookClassificationService::class)->preview(
            'Penerapan Machine Learning pada Sistem Informasi Persediaan',
            'Penelitian ini membangun perangkat lunak berbasis database untuk analisis data dan prediksi kebutuhan industri menggunakan algoritma machine learning.',
            'Sistem informasi dan data mining',
        );

        $this->assertSame('SIIO', $result['code']);
        $this->assertGreaterThan(25, $result['confidence']);
        $this->assertContains('machine learning', $result['matched_keywords']);
    }

    public function test_admin_can_store_a_book_with_automatic_classification(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.buku.store'), [
            'judul' => 'Karakterisasi Material Komposit Polimer Daur Ulang',
            'subyek' => 'Polimer dan komposit',
            'abstrak' => 'Penelitian ini menganalisis karakterisasi material komposit polimer dari plastik daur ulang, termasuk sifat termal, kekuatan, resin, dan proses kimia material.',
            'kategori' => 'Tugas Akhir',
            'buku_sumbangan' => 'Tidak',
            'jumlah_dokumen' => 2,
        ]);

        $book = Buku::query()->sole();
        $response->assertRedirect(route('admin.buku.show', $book));

        $this->assertSame('TKP', $book->klasifikasi?->kode);
        $this->assertSame('auto', $book->classification_source);
        $this->assertGreaterThan(0, $book->classification_score);
        $this->assertSame(2, $book->jumlah_tersedia);
    }

    public function test_admin_can_override_the_automatic_classification(): void
    {
        $admin = User::factory()->create();
        $classification = KlasifikasiBuku::query()->where('kode', 'UMUM')->sole();

        $this->actingAs($admin)->post(route('admin.buku.store'), [
            'judul' => 'Buku Referensi Pilihan',
            'abstrak' => 'Buku ini berisi pembahasan lintas disiplin yang dipilih oleh pustakawan sebagai referensi pendukung kegiatan belajar dan pengembangan diri mahasiswa.',
            'kategori' => 'Buku',
            'buku_sumbangan' => 'Tidak',
            'jumlah_dokumen' => 1,
            'classification_mode' => 'manual',
            'klasifikasi_id' => $classification->getKey(),
        ])->assertRedirect();

        $book = Buku::query()->sole();
        $this->assertTrue($book->klasifikasi->is($classification));
        $this->assertSame('manual', $book->classification_source);
        $this->assertNull($book->classification_score);
    }
}
