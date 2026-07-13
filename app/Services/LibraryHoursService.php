<?php

namespace App\Services;

use Carbon\CarbonInterface;

class LibraryHoursService
{
    /**
     * @return array{is_open: bool, label: string, detail: string, closes_at: string|null}
     */
    public function current(?CarbonInterface $moment = null): array
    {
        $now = $moment?->copy() ?? now();
        $day = $now->dayOfWeekIso;

        if ($day >= 6) {
            return [
                'is_open' => false,
                'label' => 'Tutup hari ini',
                'detail' => 'Buka kembali Senin pukul 08.00 WIB',
                'closes_at' => null,
            ];
        }

        $open = $now->copy()->setTime(8, 0);
        $close = $now->copy()->setTime($day === 5 ? 16 : 16, $day === 5 ? 30 : 0);
        $isOpen = $now->betweenIncluded($open, $close);

        if ($isOpen) {
            return [
                'is_open' => true,
                'label' => 'Buka sekarang',
                'detail' => 'Layanan tersedia hingga '.$close->format('H.i').' WIB',
                'closes_at' => $close->format('H.i'),
            ];
        }

        return [
            'is_open' => false,
            'label' => 'Di luar jam layanan',
            'detail' => $now->lessThan($open)
                ? 'Buka hari ini pukul 08.00 WIB'
                : ($day === 5 ? 'Buka kembali Senin pukul 08.00 WIB' : 'Buka kembali besok pukul 08.00 WIB'),
            'closes_at' => null,
        ];
    }
}
