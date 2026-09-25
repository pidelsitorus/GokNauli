<?php

use App\Http\Controllers\RoomController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\Admin\RoomTypeController as AdminRoomTypeController;
use App\Http\Controllers\Admin\TableReservationController as AdminTableReservationController;
use App\Http\Controllers\Admin\StatementController as AdminStatementController;

use App\Http\Controllers\Admin\RestaurantTableController as AdminRestaurantTableController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\CafeMenuController;
use App\Http\Controllers\TableReservationController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/rooms', [RoomController::class, 'index'])
    ->name('rooms.index');

Route::get('/menu', [CafeMenuController::class, 'index'])
    ->name('menu.index');

Route::get('/rooms/{room}/booking', [RoomController::class, 'createBooking'])
    ->name('rooms.booking');

Route::post('/rooms/{room}/booking', [RoomController::class, 'storeBooking'])
    ->name('rooms.booking.store');

Route::get('/booking/{booking}/success', [RoomController::class, 'bookingSuccess'])
    ->name('booking.success');

Route::prefix('admin')->group(function () {

    Route::get('/', function () {
        return response('', 302)
            ->header(
                'Location',
                route('admin.dashboard', [], false)
            );
    });

    Route::get('/login', [AdminAuthController::class, 'showLogin'])
        ->name('admin.login');

    Route::post('/login', [AdminAuthController::class, 'login'])
        ->name('admin.login.submit');

    Route::middleware(AdminMiddleware::class)->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('admin.dashboard');

        Route::post('/logout', [AdminAuthController::class, 'logout'])
            ->name('admin.logout');

        Route::get('/bookings', [AdminBookingController::class, 'index'])
            ->name('admin.bookings.index');

        Route::patch('/bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])
            ->name('admin.bookings.status');

        Route::patch('/bookings/{booking}/payment', [AdminBookingController::class, 'updatePayment'])
            ->name('admin.bookings.payment');

        Route::get('/rooms', [AdminRoomController::class, 'index'])
            ->name('admin.rooms.index');

        Route::get('/rooms/create', [AdminRoomController::class, 'create'])
            ->name('admin.rooms.create');

        Route::post('/rooms', [AdminRoomController::class, 'store'])
            ->name('admin.rooms.store');

        Route::get('/rooms/{room}/edit', [AdminRoomController::class, 'edit'])
            ->name('admin.rooms.edit');

        Route::put('/rooms/{room}', [AdminRoomController::class, 'update'])
            ->name('admin.rooms.update');

        Route::get('/room-types', [AdminRoomTypeController::class, 'index'])
            ->name('admin.room-types.index');

        Route::get('/room-types/create', [AdminRoomTypeController::class, 'create'])
            ->name('admin.room-types.create');

        Route::post('/room-types', [AdminRoomTypeController::class, 'store'])
            ->name('admin.room-types.store');

        Route::get('/room-types/{roomType}/edit', [AdminRoomTypeController::class, 'edit'])
            ->name('admin.room-types.edit');

        Route::put('/room-types/{roomType}', [AdminRoomTypeController::class, 'update'])
            ->name('admin.room-types.update');


        Route::get('/menus', [AdminMenuController::class, 'index'])
            ->name('admin.menus.index');

        Route::get('/menus/create', [AdminMenuController::class, 'create'])
            ->name('admin.menus.create');

        Route::post('/menus', [AdminMenuController::class, 'store'])
            ->name('admin.menus.store');

        Route::get('/menus/{menu}/edit', [AdminMenuController::class, 'edit'])
            ->name('admin.menus.edit');

        Route::put('/menus/{menu}', [AdminMenuController::class, 'update'])
            ->name('admin.menus.update');

        Route::get(
            '/reservations',
            [AdminTableReservationController::class, 'index']
        )->name('admin.reservations.index');

        Route::patch(
            '/reservations/{reservation}/status',
            [AdminTableReservationController::class, 'updateStatus']
        )->name('admin.reservations.status');

        Route::get('/tables', [AdminRestaurantTableController::class, 'index'])
            ->name('admin.tables.index');

        Route::get('/tables/create', [AdminRestaurantTableController::class, 'create'])
            ->name('admin.tables.create');

        Route::post('/tables', [AdminRestaurantTableController::class, 'store'])
            ->name('admin.tables.store');

        Route::get('/tables/{table}/edit', [AdminRestaurantTableController::class, 'edit'])
            ->name('admin.tables.edit');

        Route::put('/tables/{table}', [AdminRestaurantTableController::class, 'update'])
            ->name('admin.tables.update');

        Route::get(
            '/orders',
            [AdminOrderController::class, 'index']
        )->name('admin.orders.index');

        Route::patch(
            '/orders/{order}/status',
            [AdminOrderController::class, 'updateStatus']
        )->name('admin.orders.status');

        Route::patch(
            '/orders/{order}/payment',
            [AdminOrderController::class, 'updatePayment']
        )->name('admin.orders.payment');

        Route::get(
    '/statements',
    [AdminStatementController::class, 'index']
)->name('admin.statements.index');

Route::get(
    '/statements/homestay',
    [AdminStatementController::class, 'homestay']
)->name('admin.statements.homestay');

Route::get(
    '/statements/cafe',
    [AdminStatementController::class, 'cafe']
)->name('admin.statements.cafe');
    });
});

Route::get('/reservation', [TableReservationController::class, 'create'])
    ->name('reservations.create');

Route::post('/reservation', [TableReservationController::class, 'store'])
    ->name('reservations.store');

Route::get(
    '/reservation/{reservation}/success',
    [TableReservationController::class, 'success']
)->name('reservations.success');

Route::get('/cart', [CartController::class, 'index'])
    ->name('cart.index');

Route::post('/cart/{menu}', [CartController::class, 'add'])
    ->name('cart.add');

Route::patch('/cart/{menu}', [CartController::class, 'update'])
    ->name('cart.update');

Route::delete('/cart/{menu}', [CartController::class, 'remove'])
    ->name('cart.remove');

Route::delete('/cart', [CartController::class, 'clear'])
    ->name('cart.clear');

Route::get('/checkout', [CheckoutController::class, 'index'])
    ->name('checkout.index');

Route::post('/checkout', [CheckoutController::class, 'store'])
    ->name('checkout.store');

Route::get(
    '/order/{order}/success',
    [CheckoutController::class, 'success']
)->name('orders.success');
