<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->string('booking_code')->unique();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('room_id')
                ->constrained()
                ->restrictOnDelete();

            $table->string('guest_name');
            $table->string('guest_phone', 30);
            $table->string('guest_email')->nullable();

            $table->date('check_in');
            $table->date('check_out');

            $table->unsignedInteger('adults')->default(1);
            $table->unsignedInteger('children')->default(0);

            $table->decimal('total_price', 12, 2);

            $table->string('status')->default('pending');
            $table->string('payment_status')->default('unpaid');

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['room_id', 'check_in', 'check_out']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
