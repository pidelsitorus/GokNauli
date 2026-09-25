<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'facility_histories',
            function (Blueprint $table) {
                $table->id();

                $table
                    ->foreignId('facility_asset_id')
                    ->constrained('facility_assets')
                    ->restrictOnDelete();

                $table
                    ->foreignId('user_id')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete();

                $table
                    ->string('activity_type', 50)
                    ->index();

                $table
                    ->string('condition_before', 50)
                    ->nullable();

                $table
                    ->string('condition_after', 50)
                    ->nullable();

                $table
                    ->decimal('cost', 15, 2)
                    ->nullable();

                $table
                    ->string('vendor')
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
                    'facility_asset_id',
                    'occurred_at',
                ]);
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'facility_histories'
        );
    }
};
