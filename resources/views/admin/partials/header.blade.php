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

    .admin-notification-section {
        padding: 9px 18px;
        background: #f3f5f1;
        border-bottom: 1px solid #e2e6df;
        color: #647063;
        font-size: 11px;
        font-weight: bold;
        letter-spacing: .6px;
        text-transform: uppercase;
    }

    .admin-notification-item.inventory {
        border-left: 4px solid #d59a00;
    }

    .admin-notification-item.facility {
        border-left: 4px solid #c0392b;
    }

    .admin-notification-item.maintenance {
        border-left: 4px solid #df8b00;
    }

    .admin-notification-item.inventory
    .admin-notification-status {
        color: #a56d00;
    }

    .admin-notification-item.facility
    .admin-notification-status {
        color: #c0392b;
    }

    .admin-notification-item.maintenance
    .admin-notification-status {
        color: #ad7000;
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
                'admin.inventory.index',
                [],
                false
            ) }}"
            class="{{ request()->routeIs(
                'admin.inventory.*'
            ) ? 'active' : '' }}"
        >
            Inventory
        </a>


        <a
            href="{{ route(
                'admin.facilities.index',
                [],
                false
            ) }}"
            class="{{ request()->routeIs(
                'admin.facilities.*'
            ) ? 'active' : '' }}"
        >
            Facilities
        </a>


        {{-- Owner Financial Menu --}}
        @if (auth()->user()?->isOwner())

        <a
            href="{{ route(
                'admin.expenses.index',
                [],
                false
            ) }}"
            class="{{ request()->routeIs(
                'admin.expenses.*'
            ) ? 'active' : '' }}"
        >
            Expenses
        </a>


        <a
            href="{{ route(
                'admin.financial-summary.index',
                [],
                false
            ) }}"
            class="{{ request()->routeIs(
                'admin.financial-summary.*'
            ) ? 'active' : '' }}"
        >
            Finance
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


        <a
            href="{{ route(
                'admin.operational-reports.index',
                [],
                false
            ) }}"
            class="{{ request()->routeIs(
                'admin.operational-reports.*'
            ) ? 'active' : '' }}"
        >
            Ops Report
        </a>

        @endif
        {{-- End Owner Financial Menu --}}


        <details class="admin-notification">

            <summary title="Notifikasi Operasional">

                <span class="admin-bell">
                    🔔
                </span>

                @if (
                    ($adminOperationalNotificationCount ?? 0)
                    > 0
                )

                    <span class="admin-notification-badge">
                        {{ $adminOperationalNotificationCount }}
                    </span>

                @endif

            </summary>


            <div class="admin-notification-dropdown">

                <div class="admin-notification-title">
                    Notifikasi Operasional
                </div>


                @if (
                    ($adminOperationalNotificationCount ?? 0)
                    > 0
                )

                    {{-- ================================= --}}
                    {{-- CHECKOUT                          --}}
                    {{-- ================================= --}}

                    @if (
                        ($adminCheckoutNotificationCount ?? 0)
                        > 0
                    )

                        <div class="admin-notification-section">
                            Homestay · Checkout
                        </div>

                        @foreach (
                            $adminCheckoutNotifications
                            as $booking
                        )

                            @php
                                $checkoutOverdue =
                                    $booking->check_out
                                        ->lt(today());
                            @endphp

                            <a
                                class="
                                    admin-notification-item
                                    {{ $checkoutOverdue
                                        ? 'overdue'
                                        : 'today' }}
                                "
                                href="{{ route(
                                    'admin.bookings.index',
                                    [
                                        'search' =>
                                            $booking->booking_code
                                    ],
                                    false
                                ) }}"
                            >

                                <span
                                    class="
                                        admin-notification-status
                                    "
                                >
                                    {{ $checkoutOverdue
                                        ? '🔴 Terlambat Checkout'
                                        : '🟠 Checkout Hari Ini' }}
                                </span>

                                <span
                                    class="
                                        admin-notification-code
                                    "
                                >
                                    {{ $booking->booking_code }}
                                </span>

                                <div
                                    class="
                                        admin-notification-meta
                                    "
                                >
                                    {{ $booking->guest_name }}

                                    · Kamar
                                    {{ $booking
                                        ->room
                                        ?->room_number
                                        ?? '-' }}

                                    <br>

                                    Checkout:
                                    {{ $booking
                                        ->check_out
                                        ->format('d/m/Y') }}
                                </div>

                            </a>

                        @endforeach

                    @endif


                    {{-- ================================= --}}
                    {{-- INVENTORY                         --}}
                    {{-- ================================= --}}

                    @if (
                        ($adminLowStockCount ?? 0)
                        > 0
                    )

                        <div class="admin-notification-section">
                            Inventory
                        </div>

                        @foreach (
                            $adminLowStockItems
                            as $item
                        )

                            <a
                                class="
                                    admin-notification-item
                                    inventory
                                "
                                href="{{ route(
                                    'admin.inventory.movements',
                                    $item,
                                    false
                                ) }}"
                            >

                                <span
                                    class="
                                        admin-notification-status
                                    "
                                >
                                    ⚠ Stok Rendah
                                </span>

                                <span
                                    class="
                                        admin-notification-code
                                    "
                                >
                                    {{ $item->name }}
                                </span>

                                <div
                                    class="
                                        admin-notification-meta
                                    "
                                >
                                    {{ $item->area_label }}

                                    @if ($item->location)
                                        ·
                                        {{ $item->location }}
                                    @endif

                                    <br>

                                    Stok:
                                    <strong>
                                        {{ number_format(
                                            $item->current_stock,
                                            3,
                                            ',',
                                            '.'
                                        ) }}
                                        {{ $item->unit }}
                                    </strong>

                                    · Minimum:
                                    {{ number_format(
                                        $item->minimum_stock,
                                        3,
                                        ',',
                                        '.'
                                    ) }}
                                    {{ $item->unit }}
                                </div>

                            </a>

                        @endforeach

                    @endif


                    {{-- ================================= --}}
                    {{-- FACILITY ATTENTION                --}}
                    {{-- ================================= --}}

                    @if (
                        ($adminFacilityAttentionCount ?? 0)
                        > 0
                    )

                        <div class="admin-notification-section">
                            Facilities
                        </div>

                        @foreach (
                            $adminFacilityAttentionItems
                            as $asset
                        )

                            <a
                                class="
                                    admin-notification-item
                                    facility
                                "
                                href="{{ route(
                                    'admin.facilities.histories',
                                    $asset,
                                    false
                                ) }}"
                            >

                                <span
                                    class="
                                        admin-notification-status
                                    "
                                >
                                    🔧
                                    {{ $asset->condition_label }}
                                </span>

                                <span
                                    class="
                                        admin-notification-code
                                    "
                                >
                                    {{ $asset->name }}
                                </span>

                                <div
                                    class="
                                        admin-notification-meta
                                    "
                                >
                                    {{ $asset->asset_code }}

                                    <br>

                                    {{ $asset->area_label }}

                                    @if ($asset->location)
                                        ·
                                        {{ $asset->location }}
                                    @endif
                                </div>

                            </a>

                        @endforeach

                    @endif


                    {{-- ================================= --}}
                    {{-- MAINTENANCE                       --}}
                    {{-- ================================= --}}

                    @if (
                        ($adminMaintenanceDueCount ?? 0)
                        > 0
                    )

                        <div class="admin-notification-section">
                            Maintenance
                        </div>

                        @foreach (
                            $adminMaintenanceDueItems
                            as $asset
                        )

                            @php
                                $maintenanceOverdue =
                                    $asset
                                        ->next_maintenance_at
                                        ->lt(today());
                            @endphp

                            <a
                                class="
                                    admin-notification-item
                                    maintenance
                                "
                                href="{{ route(
                                    'admin.facilities.histories',
                                    $asset,
                                    false
                                ) }}"
                            >

                                <span
                                    class="
                                        admin-notification-status
                                    "
                                >
                                    📅
                                    {{ $maintenanceOverdue
                                        ? 'Maintenance Terlambat'
                                        : 'Maintenance Hari Ini' }}
                                </span>

                                <span
                                    class="
                                        admin-notification-code
                                    "
                                >
                                    {{ $asset->name }}
                                </span>

                                <div
                                    class="
                                        admin-notification-meta
                                    "
                                >
                                    {{ $asset->area_label }}

                                    @if ($asset->location)
                                        ·
                                        {{ $asset->location }}
                                    @endif

                                    <br>

                                    Jadwal:
                                    {{ $asset
                                        ->next_maintenance_at
                                        ->format('d/m/Y') }}
                                </div>

                            </a>

                        @endforeach

                    @endif


                    <a
                        class="admin-notification-footer"
                        href="{{ route(
                            'admin.dashboard',
                            [],
                            false
                        ) }}"
                    >
                        Lihat Dashboard Operasional
                    </a>

                @else

                    <div class="admin-notification-empty">
                        ✓ Tidak ada notifikasi operasional
                        yang membutuhkan perhatian.
                    </div>

                @endif

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
