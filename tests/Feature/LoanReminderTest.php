<?php

namespace Tests\Feature;

use App\Mail\LoanDueReminderMail;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class LoanReminderTest extends TestCase
{
    use RefreshDatabase;

    public function test_due_reminder_is_sent_once_to_an_opted_in_member(): void
    {
        Mail::fake();

        $member = Anggota::query()->create([
            'nama' => 'Anggota Email',
            'no_telp' => '081234567890',
            'status' => 'Mahasiswa',
            'email' => 'anggota@example.test',
            'reminder_opt_in' => true,
        ]);
        $book = Buku::query()->create([
            'judul' => 'Buku Jatuh Tempo',
            'kategori' => 'Buku',
            'buku_sumbangan' => 'Tidak',
            'jumlah_dokumen' => 1,
            'jumlah_tersedia' => 0,
        ]);
        $loan = Peminjaman::query()->create([
            'no_anggota' => $member->getKey(),
            'tanggal_pinjam' => today()->subDays(5),
            'tanggal_kembali' => today()->addDay(),
        ]);
        $loan->detailPeminjaman()->create([
            'no_document' => $book->getKey(),
            'jumlah_pinjam' => 1,
            'status_item' => 'Dipinjam',
        ]);

        $this->artisan('library:send-due-reminders', ['--days' => 2])
            ->expectsOutput('1 pengingat berhasil dikirim.')
            ->assertSuccessful();

        Mail::assertSent(LoanDueReminderMail::class, fn (LoanDueReminderMail $mail): bool => $mail->hasTo('anggota@example.test'));
        $this->assertNotNull($loan->refresh()->reminder_sent_at);

        $this->artisan('library:send-due-reminders', ['--days' => 2])
            ->expectsOutput('0 pengingat berhasil dikirim.')
            ->assertSuccessful();
        Mail::assertSentCount(1);
    }
}
