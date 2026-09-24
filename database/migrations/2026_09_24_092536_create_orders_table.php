<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->string('order_code')->unique();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('restaurant_table_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('customer_name');
            $table->string('customer_phone', 30);

            $table->string('order_type')
                ->default('dine_in');

            $table->string('status')
                ->default('pending');

            $table->string('payment_status')
                ->default('unpaid');

            $table->decimal('subtotal', 12, 2);

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(
                ['status', 'created_at'],
                'order_status_idx'
            );

            $table->index(
                'payment_status',
                'order_payment_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
