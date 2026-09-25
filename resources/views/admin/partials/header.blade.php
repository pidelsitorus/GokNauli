<style>
    .admin-shared-header {
        position: relative;
        z-index: 1000;
        background: #26372a;
        color: white;
        padding: 18px 5%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
    }

    .admin-shared-brand {
        color: white;
        text-decoration: none;
        font-weight: bold;
        white-space: nowrap;
    }

    .admin-shared-nav {
        display: flex;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .admin-shared-nav > a {
        color: white;
        text-decoration: none;
        font-size: 14px;
    }

    .admin-shared-nav > a:hover,
    .admin-shared-nav > a.active {
        text-decoration: underline;
    }

    .admin-notification {
        position: relative;
    }

    .admin-notification summary {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 35px;
        min-height: 35px;
        padding: 5px 8px;
        border-radius: 8px;
        cursor: pointer;
        list-style: none;
        background: rgba(255,255,255,.08);
        user-select: none;
    }

    .admin-notification summary::-webkit-details-marker {
        display: none;
    }

    .admin-notification[open] summary,
    .admin-notification summary:hover {
        background: rgba(255,255,255,.16);
    }

    .admin-bell {
        font-size: 19px;
    }

    .admin-notification-badge {
        position: absolute;
        top: -7px;
        right: -7px;
        min-width: 19px;
        height: 19px;
        padding: 0 5px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #d83a2e;
        color: white;
        border: 2px solid #26372a;
        font-size: 10px;
        font-weight: bold;
    }

    .admin-notification-dropdown {
        position: absolute;
        top: calc(100% + 12px);
        right: 0;
        width: 380px;
        max-height: 460px;
        overflow-y: auto;
        background: white;
        color: #293229;
        border-radius: 12px;
        box-shadow: 0 15px 45px rgba(0,0,0,.20);
    }

    .admin-notification-title {
        padding: 16px 18px;
        border-bottom: 1px solid #eee;
        font-weight: bold;
    }

    .admin-notification-item {
        display: block;
        padding: 14px 18px;
        border-bottom: 1px solid #eee;
        color: #293229;
        text-decoration: none;
    }

    .admin-notification-item:hover {
        background: #f7f8f5;
    }

    .admin-notification-item.overdue {
        border-left: 4px solid #c0392b;
    }

    .admin-notification-item.today {
        border-left: 4px solid #e0a800;
    }

    .admin-notification-status {
        display: block;
        margin-bottom: 6px;
        font-size: 12px;
        font-weight: bold;
    }

    .admin-notification-item.overdue
    .admin-notification-status {
        color: #c0392b;
    }

    .admin-notification-item.today
    .admin-notification-status {
        color: #b27d00;
    }

    .admin-notification-code {
        font-weight: bold;
        color: #31563a;
    }

    .admin-notification-meta {
        margin-top: 5px;
        color: #666;
        font-size: 12px;
        line-height: 1.6;
    }

    .admin-notification-empty {
        padding: 20px 18px;
        color: #667066;
        font-size: 13px;
    }

    .admin-notification-footer {
        display: block;
        padding: 13px 18px;
        color: #31563a;
        text-align: center;
        text-decoration: none;
        font-size: 13px;
        font-weight: bold;
    }

    .admin-notification-footer:hover {
        background: #f7f8f5;
    }

    .admin-shared-logout {
        margin: 0;
    }

    .admin-shared-logout button {
        background: none;
        border: 0;
        color: white;
        cursor: pointer;
        padding: 0;
        font-size: 14px;
    }

    @media (max-width: 900px) {
        .admin-shared-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .admin-notification-dropdown {
            position: fixed;
            top: 100px;
            right: 4%;
            left: 4%;
            width: auto;
        }
    }
</style>


<header class="admin-shared-header">

    <a
        class="admin-shared-brand"
        href="{{ route('admin.dashboard', [], false) }}"
    >
        Gok Nauli Admin
    </a>


    <nav class="admin-shared-nav">

        <a
            href="{{ route('admin.dashboard', [], false) }}"
            class="{{ request()->routeIs('admin.dashboard')
                ? 'active'
                : '' }}"
        >
            Dashboard
        </a>

        <a
            href="{{ route('admin.bookings.index', [], false) }}"
            class="{{ request()->routeIs('admin.bookings.*')
                ? 'active'
                : '' }}"
        >
            Booking
        </a>

        <a
            href="{{ route('admin.rooms.index', [], false) }}"
            class="{{ request()->routeIs('admin.rooms.*')
                ? 'active'
                : '' }}"
        >
            Rooms
        </a>

        <a
            href="{{ route('admin.room-types.index', [], false) }}"
            class="{{ request()->routeIs('admin.room-types.*')
                ? 'active'
                : '' }}"
        >
            Room Types
        </a>

        <a
            href="{{ route('admin.menus.index', [], false) }}"
            class="{{ request()->routeIs('admin.menus.*')
                ? 'active'
                : '' }}"
        >
            Menu
        </a>

        <a
            href="{{ route(
                'admin.reservations.index',
                [],
                false
            ) }}"
            class="{{ request()->routeIs(
                'admin.reservations.*'
            ) ? 'active' : '' }}"
        >
            Reservations
        </a>

        <a
            href="{{ route('admin.tables.index', [], false) }}"
            class="{{ request()->routeIs('admin.tables.*')
                ? 'active'
                : '' }}"
        >
            Tables
        </a>

        <a
            href="{{ route('admin.orders.index', [], false) }}"
            class="{{ request()->routeIs('admin.orders.*')
                ? 'active'
                : '' }}"
        >
            Orders
        </a>

        <a
            href="{{ route(
                'admin.statements.index',
                [],
                false
            ) }}"
            class="{{ request()->routeIs(
                'admin.statements.*'
            ) ? 'active' : '' }}"
        >
            Statement
        </a>


        <details class="admin-notification">

            <summary title="Notifikasi Checkout">

                <span class="admin-bell">
                    🔔
                </span>

                @if (
                    ($adminCheckoutNotificationCount ?? 0) > 0
                )

                    <span class="admin-notification-badge">
                        {{ $adminCheckoutNotificationCount }}
                    </span>

                @endif

            </summary>


            <div class="admin-notification-dropdown">

                <div class="admin-notification-title">
                    Notifikasi Checkout
                </div>


                @forelse (
                    ($adminCheckoutNotifications ?? collect())
                    as $notification
                )

                    @php
                        $isOverdue =
                            $notification->check_out
                                ->isBefore(today());
                    @endphp

                    <a
                        class="
                            admin-notification-item
                            {{ $isOverdue
                                ? 'overdue'
                                : 'today' }}
                        "
                        href="{{ route(
                            'admin.bookings.index',
                            [
                                'search' =>
                                    $notification->booking_code,
                            ],
                            false
                        ) }}"
                    >

                        <span class="admin-notification-status">

                            @if ($isOverdue)
                                🔴 Terlambat Checkout
                            @else
                                🟠 Checkout Hari Ini
                            @endif

                        </span>


                        <span class="admin-notification-code">
                            {{ $notification->booking_code }}
                        </span>


                        <div class="admin-notification-meta">

                            Tamu:
                            {{ $notification->guest_name }}

                            <br>

                            Kamar:
                            {{ $notification
                                ->room
                                ?->room_number ?? '-' }}

                            @if ($notification->room?->name)
                                -
                                {{ $notification->room->name }}
                            @endif

                            <br>

                            Checkout:
                            {{ $notification
                                ->check_out
                                ->format('d/m/Y') }}

                        </div>

                    </a>

                @empty

                    <div class="admin-notification-empty">
                        ✓ Tidak ada checkout hari ini
                        atau checkout yang terlambat.
                    </div>

                @endforelse


                <a
                    class="admin-notification-footer"
                    href="{{ route(
                        'admin.bookings.index',
                        [
                            'status' => 'checked_in',
                        ],
                        false
                    ) }}"
                >
                    Lihat Semua Check In Aktif
                </a>

            </div>

        </details>


        <form
            class="admin-shared-logout"
            method="POST"
            action="{{ route('admin.logout', [], false) }}"
        >
            @csrf

            <button type="submit">
                Logout
            </button>

        </form>

    </nav>

</header>
