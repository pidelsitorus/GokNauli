<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuCategory;
use Illuminate\Database\Seeder;

class CafeRestoSeeder extends Seeder
{
    public function run(): void
    {
        $makanan = MenuCategory::updateOrCreate(
            ['slug' => 'makanan'],
            [
                'name' => 'Makanan',
                'description' => 'Pilihan makanan Gok Nauli.',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        $minuman = MenuCategory::updateOrCreate(
            ['slug' => 'minuman'],
            [
                'name' => 'Minuman',
                'description' => 'Pilihan minuman segar.',
                'sort_order' => 2,
                'is_active' => true,
            ]
        );

        $coffee = MenuCategory::updateOrCreate(
            ['slug' => 'coffee'],
            [
                'name' => 'Coffee',
                'description' => 'Pilihan kopi Gok Nauli.',
                'sort_order' => 3,
                'is_active' => true,
            ]
        );

        $snack = MenuCategory::updateOrCreate(
            ['slug' => 'snack'],
            [
                'name' => 'Snack',
                'description' => 'Camilan untuk menemani waktu santai.',
                'sort_order' => 4,
                'is_active' => true,
            ]
        );

        Menu::updateOrCreate(
            ['slug' => 'nasi-goreng-gok-nauli'],
            [
                'menu_category_id' => $makanan->id,
                'name' => 'Nasi Goreng Gok Nauli',
                'description' => 'Nasi goreng khas Gok Nauli.',
                'price' => 35000,
                'is_available' => true,
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        Menu::updateOrCreate(
            ['slug' => 'mie-goreng'],
            [
                'menu_category_id' => $makanan->id,
                'name' => 'Mie Goreng',
                'description' => 'Mie goreng dengan bumbu pilihan.',
                'price' => 30000,
                'is_available' => true,
                'is_active' => true,
                'sort_order' => 2,
            ]
        );

        Menu::updateOrCreate(
            ['slug' => 'kopi-hitam'],
            [
                'menu_category_id' => $coffee->id,
                'name' => 'Kopi Hitam',
                'description' => 'Kopi hitam hangat.',
                'price' => 15000,
                'is_available' => true,
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        Menu::updateOrCreate(
            ['slug' => 'es-teh-manis'],
            [
                'menu_category_id' => $minuman->id,
                'name' => 'Es Teh Manis',
                'description' => 'Teh manis dingin.',
                'price' => 10000,
                'is_available' => true,
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        Menu::updateOrCreate(
            ['slug' => 'kentang-goreng'],
            [
                'menu_category_id' => $snack->id,
                'name' => 'Kentang Goreng',
                'description' => 'Kentang goreng renyah.',
                'price' => 25000,
                'is_available' => true,
                'is_active' => true,
                'sort_order' => 1,
            ]
        );
    }
}
