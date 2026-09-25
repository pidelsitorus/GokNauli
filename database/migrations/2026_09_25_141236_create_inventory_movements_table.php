<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'inventory_movements',
            function (Blueprint $table) {
                $table->id();

                $table
                    ->foreignId('inventory_item_id')
                    ->constrained('inventory_items')
                    ->restrictOnDelete();

                $table
                    ->foreignId('user_id')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete();

                $table
                    ->string('movement_type', 50)
                    ->index();

                $table
                    ->decimal('quantity', 12, 3);

                $table
                    ->decimal('stock_before', 12, 3);

                $table
                    ->decimal('stock_after', 12, 3);

                $table
                    ->decimal('unit_cost', 15, 2)
                    ->nullable();

                $table
                    ->decimal('total_cost', 15, 2)
                    ->nullable();

                $table
                    ->string('reference')
                    ->nullable();

                $table
                    ->text('notes')
                    ->nullable();

                $table
                    ->dateTime('occurred_at')
                    ->index();

                $table->timestamps();

                $table->index([
                    'inventory_item_id',
                    'occurred_at',
                ]);
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'inventory_movements'
        );
    }
};
