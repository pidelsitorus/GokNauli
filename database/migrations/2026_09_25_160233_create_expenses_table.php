<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();

            $table
                ->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table
                ->string('area', 30)
                ->index();

            $table
                ->string('category', 50)
                ->index();

            $table->string('description');

            $table->decimal(
                'amount',
                15,
                2
            );

            $table
                ->date('expense_date')
                ->index();

            $table
                ->string('payment_method', 50)
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

            $table->timestamps();

            $table->index([
                'area',
                'expense_date',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
