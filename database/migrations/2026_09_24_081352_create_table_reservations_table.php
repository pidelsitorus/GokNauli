<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('table_reservations', function (Blueprint $table) {
            $table->id();

            $table->string('reservation_code')->unique();

            $table->foreignId('restaurant_table_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('guest_name');
            $table->string('guest_phone', 30);
            $table->string('guest_email')->nullable();

            $table->date('reservation_date');
            $table->time('reservation_time');

            $table->unsignedInteger('guests');

            $table->string('status')
                ->default('pending');

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(
                [
                    'reservation_date',
                    'reservation_time',
                    'status',
                ],
                'reservation_schedule_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('table_reservations');
    }
};
