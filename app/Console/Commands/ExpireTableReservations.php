<?php

namespace App\Console\Commands;

use App\Models\TableReservation;
use Illuminate\Console\Command;

class ExpireTableReservations extends Command
{
    protected $signature = 'reservations:expire';

    protected $description =
        'Mark past pending or confirmed table reservations as expired';

    public function handle(): int
    {
        $today = today()->toDateString();
        $currentTime = now()->format('H:i:s');

        $expiredCount = TableReservation::query()
            ->whereIn(
                'status',
                [
                    'pending',
                    'confirmed',
                ]
            )
            ->where(function ($query) use (
                $today,
                $currentTime
            ) {
                $query
                    ->whereDate(
                        'reservation_date',
                        '<',
                        $today
                    )
                    ->orWhere(function ($query) use (
                        $today,
                        $currentTime
                    ) {
                        $query
                            ->whereDate(
                                'reservation_date',
                                $today
                            )
                            ->whereTime(
                                'reservation_time',
                                '<',
                                $currentTime
                            );
                    });
            })
            ->update([
                'status' => 'expired',
            ]);

        $this->info(
            "{$expiredCount} reservation(s) marked as expired."
        );

        return self::SUCCESS;
    }
}
