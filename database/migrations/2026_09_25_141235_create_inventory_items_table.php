<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();

            $table
                ->string('item_code', 50)
                ->unique();

            $table->string('name');

            $table
                ->string('area', 30)
                ->index();

            $table
                ->string('item_type', 50)
                ->index();

            $table
                ->string('category')
                ->nullable();

            $table
                ->string('unit', 30);

            $table
                ->decimal('current_stock', 12, 3)
                ->default(0);

            $table
                ->decimal('minimum_stock', 12, 3)
                ->default(0);

            $table
                ->decimal('purchase_price', 15, 2)
                ->nullable();

            $table
                ->string('location')
                ->nullable();

            $table
                ->text('notes')
                ->nullable();

            $table
                ->boolean('is_active')
                ->default(true);

            $table->timestamps();

            $table->index([
                'area',
                'is_active',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};
