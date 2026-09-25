<?php

namespace App\Providers;

use App\Models\Booking;
use App\Models\InventoryItem;
use App\Models\FacilityAsset;
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
                'admin.operational-reports.*',
                'admin.financial-summary.*',
                'admin.expenses.*',
                'admin.inventory.*',
                'admin.facilities.*',
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

                $adminLowStockCount =
                    InventoryItem::query()
                        ->where('is_active', true)
                        ->lowStock()
                        ->count();

                $adminLowStockItems =
                    InventoryItem::query()
                        ->where('is_active', true)
                        ->lowStock()
                        ->orderBy('current_stock')
                        ->take(5)
                        ->get();


                $adminFacilityAttentionCount =
                    FacilityAsset::query()
                        ->where('is_active', true)
                        ->needsAttention()
                        ->count();

                $adminFacilityAttentionItems =
                    FacilityAsset::query()
                        ->where('is_active', true)
                        ->needsAttention()
                        ->orderBy('name')
                        ->take(5)
                        ->get();


                $adminMaintenanceDueCount =
                    FacilityAsset::query()
                        ->where('is_active', true)
                        ->maintenanceDue()
                        ->count();

                $adminMaintenanceDueItems =
                    FacilityAsset::query()
                        ->where('is_active', true)
                        ->maintenanceDue()
                        ->orderBy('next_maintenance_at')
                        ->take(5)
                        ->get();


                $adminCheckoutNotificationCount =
                    $adminCheckoutNotifications->count();

                $adminOperationalNotificationCount =
                    $adminCheckoutNotificationCount
                    + $adminLowStockCount
                    + $adminFacilityAttentionCount
                    + $adminMaintenanceDueCount;


                $view->with(
                    'adminCheckoutNotifications',
                    $adminCheckoutNotifications
                );

                $view->with(
                    'adminCheckoutNotificationCount',
                    $adminCheckoutNotificationCount
                );

                $view->with(
                    'adminLowStockItems',
                    $adminLowStockItems
                );

                $view->with(
                    'adminLowStockCount',
                    $adminLowStockCount
                );

                $view->with(
                    'adminFacilityAttentionItems',
                    $adminFacilityAttentionItems
                );

                $view->with(
                    'adminFacilityAttentionCount',
                    $adminFacilityAttentionCount
                );

                $view->with(
                    'adminMaintenanceDueItems',
                    $adminMaintenanceDueItems
                );

                $view->with(
                    'adminMaintenanceDueCount',
                    $adminMaintenanceDueCount
                );

                $view->with(
                    'adminOperationalNotificationCount',
                    $adminOperationalNotificationCount
                );
            }
        );
    }
}
