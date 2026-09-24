<?php

namespace Database\Seeders;

use App\Models\RestaurantTable;
use Illuminate\Database\Seeder;

class RestaurantTableSeeder extends Seeder
{
    public function run(): void
    {
        $tables = [
            [
                'table_number' => 'T01',
                'name' => 'Table 01',
                'capacity' => 2,
                'location' => 'Indoor',
            ],
            [
                'table_number' => 'T02',
                'name' => 'Table 02',
                'capacity' => 2,
                'location' => 'Indoor',
            ],
            [
                'table_number' => 'T03',
                'name' => 'Table 03',
                'capacity' => 4,
                'location' => 'Indoor',
            ],
            [
                'table_number' => 'T04',
                'name' => 'Table 04',
                'capacity' => 4,
                'location' => 'Outdoor',
            ],
            [
                'table_number' => 'T05',
                'name' => 'Family Table',
                'capacity' => 6,
                'location' => 'Outdoor',
            ],
        ];

        foreach ($tables as $table) {
            RestaurantTable::updateOrCreate(
                [
                    'table_number' => $table['table_number'],
                ],
                [
                    'name' => $table['name'],
                    'capacity' => $table['capacity'],
                    'location' => $table['location'],
                    'status' => 'available',
                    'is_active' => true,
                ]
            );
        }
    }
}
