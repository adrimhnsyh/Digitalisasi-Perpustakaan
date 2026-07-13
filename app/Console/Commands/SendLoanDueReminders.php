<?php

namespace App\Console\Commands;

use App\Services\LoanReminderService;
use Illuminate\Console\Command;

class SendLoanDueReminders extends Command
{
    protected $signature = 'library:send-due-reminders {--days=2 : Jumlah hari menuju jatuh tempo}';

    protected $description = 'Mengirim email pengingat untuk peminjaman yang mendekati jatuh tempo';

    public function handle(LoanReminderService $reminderService): int
    {
        $days = max((int) $this->option('days'), 0);
        $sent = $reminderService->sendUpcoming($days);

        $this->info("{$sent} pengingat berhasil dikirim.");

        return self::SUCCESS;
    }
}
