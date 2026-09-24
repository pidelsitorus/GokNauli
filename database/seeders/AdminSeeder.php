<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use RuntimeException;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = config('admin.email');
        $password = config('admin.password');

        if (!$email || !$password) {
            throw new RuntimeException(
                'Email atau password admin belum dikonfigurasi.'
            );
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => config('admin.name', 'Administrator'),
                'password' => $password,
                'is_admin' => true,
            ]
        );
    }
}
