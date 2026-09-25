<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'facility_assets',
            function (Blueprint $table) {
                $table->id();

                $table
                    ->string('asset_code', 50)
                    ->unique();

                $table->string('name');

                $table
                    ->string('area', 30)
                    ->index();

                $table
                    ->string('category')
                    ->nullable();

                $table
                    ->string('location')
                    ->nullable();

                $table
                    ->string('condition', 50)
                    ->default('good')
                    ->index();

                $table
                    ->string('status', 50)
                    ->default('active')
                    ->index();

                $table
                    ->string('brand')
                    ->nullable();

                $table
                    ->string('model')
                    ->nullable();

                $table
                    ->string('serial_number')
                    ->nullable();

                $table
                    ->date('purchase_date')
                    ->nullable();

                $table
                    ->decimal(
                        'purchase_price',
                        15,
                        2
                    )
                    ->nullable();

                $table
                    ->date('last_maintenance_at')
                    ->nullable();

                $table
                    ->date('next_maintenance_at')
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
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'facility_assets'
        );
    }
};
