<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Database\Seeder;

class HomestaySeeder extends Seeder
{
    public function run(): void
    {
        $standard = RoomType::create([
            'name' => 'Standard Room',
            'description' => 'Kamar nyaman untuk 1-2 tamu dengan fasilitas dasar.',
            'capacity' => 2,
            'base_price' => 350000,
            'is_active' => true,
        ]);

        $deluxe = RoomType::create([
            'name' => 'Deluxe Room',
            'description' => 'Kamar lebih luas dengan fasilitas tambahan untuk kenyamanan tamu.',
            'capacity' => 2,
            'base_price' => 500000,
            'is_active' => true,
        ]);

        $family = RoomType::create([
            'name' => 'Family Room',
            'description' => 'Kamar keluarga yang cocok untuk beberapa tamu.',
            'capacity' => 4,
            'base_price' => 750000,
            'is_active' => true,
        ]);

        Room::create([
            'room_type_id' => $standard->id,
            'room_number' => 'GN-101',
            'name' => 'Standard Room 101',
            'price' => 350000,
            'status' => 'available',
            'description' => 'Kamar standard Gok Nauli.',
            'is_active' => true,
        ]);

        Room::create([
            'room_type_id' => $standard->id,
            'room_number' => 'GN-102',
            'name' => 'Standard Room 102',
            'price' => 350000,
            'status' => 'available',
            'description' => 'Kamar standard Gok Nauli.',
            'is_active' => true,
        ]);

        Room::create([
            'room_type_id' => $deluxe->id,
            'room_number' => 'GN-201',
            'name' => 'Deluxe Room 201',
            'price' => 500000,
            'status' => 'available',
            'description' => 'Kamar deluxe Gok Nauli.',
            'is_active' => true,
        ]);

        Room::create([
            'room_type_id' => $deluxe->id,
            'room_number' => 'GN-202',
            'name' => 'Deluxe Room 202',
            'price' => 500000,
            'status' => 'available',
            'description' => 'Kamar deluxe Gok Nauli.',
            'is_active' => true,
        ]);

        Room::create([
            'room_type_id' => $family->id,
            'room_number' => 'GN-301',
            'name' => 'Family Room 301',
            'price' => 750000,
            'status' => 'available',
            'description' => 'Kamar keluarga Gok Nauli.',
            'is_active' => true,
        ]);
    }
}
