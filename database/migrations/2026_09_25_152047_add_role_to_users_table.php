<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table
                ->string('role', 30)
                ->default('receptionist')
                ->after('is_admin')
                ->index();
        });

        /*
         * Admin yang sudah ada sebelum sistem role
         * dianggap sebagai owner.
         */
        DB::table('users')
            ->where('is_admin', true)
            ->update([
                'role' => 'owner',
            ]);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']);
            $table->dropColumn('role');
        });
    }
};
