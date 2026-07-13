<?php

namespace Tests\Feature;

use App\Models\KontenPublik;
use App\Models\PermintaanPublik;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminExperienceTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_operational_pages_are_available(): void
    {
        $admin = User::factory()->create();
        $request = PermintaanPublik::query()->create([
            'type' => 'aspirasi',
            'name' => 'Pengunjung',
            'email' => 'visitor@example.test',
            'subject' => 'Jam layanan',
            'message' => 'Mohon informasi jam layanan pada masa ujian.',
        ]);

        foreach ([
            route('admin.dashboard'),
            route('admin.buku.index'),
            route('admin.buku.create'),
            route('admin.klasifikasi.index'),
            route('admin.konten.index'),
            route('admin.konten.create'),
            route('admin.permintaan.index'),
            route('admin.permintaan.show', $request),
        ] as $url) {
            $this->actingAs($admin)->get($url)->assertOk();
        }
    }

    public function test_admin_navigation_is_focused_on_management_tasks(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Data Perpustakaan')
            ->assertSee('Kelola Website')
            ->assertSee('Publikasi Website')
            ->assertSee('Inbox Layanan')
            ->assertSee('Lihat Website');
    }

    public function test_admin_can_publish_content_and_process_a_request(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)->post(route('admin.konten.store'), [
            'type' => 'berita',
            'title' => 'Layanan Referensi Baru',
            'excerpt' => 'Informasi layanan referensi terbaru untuk sivitas akademika.',
            'body' => 'Konten layanan referensi dapat dikelola langsung dari panel administrasi.',
            'sort_order' => 10,
            'is_published' => 1,
        ])->assertRedirect(route('admin.konten.index'));

        $content = KontenPublik::query()->where('title', 'Layanan Referensi Baru')->sole();
        $this->assertTrue($content->is_published);
        $this->assertNotNull($content->published_at);

        $request = PermintaanPublik::query()->create([
            'type' => 'tanya_pustakawan',
            'name' => 'Mahasiswa',
            'phone' => '081234567890',
            'subject' => 'Bantuan referensi',
            'message' => 'Saya membutuhkan bantuan mencari referensi tugas akhir.',
        ]);

        $this->actingAs($admin)->put(route('admin.permintaan.update', $request), [
            'status' => 'selesai',
            'admin_notes' => 'Referensi sudah dikirim kepada mahasiswa.',
        ])->assertRedirect();

        $request->refresh();
        $this->assertSame('selesai', $request->status);
        $this->assertTrue($request->handler->is($admin));
        $this->assertNotNull($request->handled_at);
    }
}
