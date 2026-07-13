<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_are_available(): void
    {
        foreach ([
            route('home'),
            route('catalog.index'),
            route('explore.index'),
            route('loan-status.index'),
            route('tampilan.sejarah'),
            route('tampilan.visi-misi'),
            route('tampilan.tujuan-fungsi'),
            route('tampilan.struktur-organisasi'),
            route('tampilan.peraturan-tata-tertib'),
            route('tampilan.layanan'),
            route('e-resources'),
        ] as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_public_navigation_exposes_self_service_and_admin_login_separately(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Layanan Saya')
            ->assertSee('Cek Peminjaman')
            ->assertSee('Usulkan Buku')
            ->assertSee('Masuk Admin');
    }
}
