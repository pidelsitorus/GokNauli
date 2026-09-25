<?php

namespace App\Providers;

use App\Models\Booking;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(
            [
                'admin.dashboard',
                'admin.bookings.*',
                'admin.rooms.*',
                'admin.room-types.*',
                'admin.menus.*',
                'admin.reservations.*',
                'admin.tables.*',
                'admin.orders.*',
                'admin.statements.index',
                'admin.inventory.*',
            ],
            function ($view) {
                $adminCheckoutNotifications = Booking::with([
                    'room.roomType',
                ])
                    ->where(
                        'status',
                        'checked_in'
                    )
                    ->whereDate(
                        'check_out',
                        '<=',
                        today()
                    )
                    ->orderBy('check_out')
                    ->get();

                $view->with(
                    'adminCheckoutNotifications',
                    $adminCheckoutNotifications
                );

                $view->with(
                    'adminCheckoutNotificationCount',
                    $adminCheckoutNotifications->count()
                );
            }
        );
    }
}
