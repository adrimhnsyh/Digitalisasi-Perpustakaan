<?php

namespace App\Services;

use App\Mail\LoanDueReminderMail;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Mail;

class LoanReminderService
{
    public function sendUpcoming(int $days = 2): int
    {
        $sent = 0;

        Peminjaman::query()
            ->with(['anggota', 'detailPeminjaman.buku'])
            ->whereNull('reminder_sent_at')
            ->whereBetween('tanggal_kembali', [today(), today()->addDays(max($days, 0))])
            ->whereHas('anggota', function ($query): void {
                $query->whereNotNull('email')->where('reminder_opt_in', true);
            })
            ->whereHas('detailPeminjaman', fn ($query) => $query->where('status_item', 'Dipinjam'))
            ->orderBy('tanggal_kembali')
            ->each(function (Peminjaman $loan) use (&$sent): void {
                Mail::to($loan->anggota->email)->send(new LoanDueReminderMail($loan));
                $loan->update(['reminder_sent_at' => now()]);
                $sent++;
            });

        return $sent;
    }
}
