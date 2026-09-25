<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table
                ->timestamp('paid_at')
                ->nullable()
                ->after('payment_status');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table
                ->timestamp('paid_at')
                ->nullable()
                ->after('payment_status');
        });

        /*
         * Data lama belum memiliki waktu pembayaran.
         * Untuk transaksi yang sudah berstatus paid,
         * gunakan created_at sebagai fallback historis.
         */

        DB::table('bookings')
            ->where('payment_status', 'paid')
            ->whereNull('paid_at')
            ->update([
                'paid_at' => DB::raw('created_at'),
            ]);

        DB::table('orders')
            ->where('payment_status', 'paid')
            ->whereNull('paid_at')
            ->update([
                'paid_at' => DB::raw('created_at'),
            ]);
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('paid_at');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('paid_at');
        });
    }
};
