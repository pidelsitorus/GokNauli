<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();

            $table->foreignId('room_type_id')
                ->constrained()
                ->restrictOnDelete();

            $table->string('room_number')->unique();
            $table->string('name');
            $table->decimal('price', 12, 2)->nullable();

            $table->string('status')->default('available');

            $table->text('description')->nullable();
            $table->string('image')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
