<?php

namespace App\Mail;

use App\Models\Peminjaman;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LoanDueReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public readonly Peminjaman $loan) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pengingat Pengembalian Koleksi Perpustakaan STMI',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.loan-due-reminder',
        );
    }
}
