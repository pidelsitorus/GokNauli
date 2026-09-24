<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Room;

class HomeController extends Controller
{
    public function index()
    {
        $rooms = Room::with('roomType')
            ->where('is_active', true)
            ->where('status', '!=', 'maintenance')
            ->orderBy('room_number')
            ->take(3)
            ->get();

        $menus = Menu::with('category')
            ->where('is_active', true)
            ->where('is_available', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->take(4)
            ->get();

        return view(
            'welcome',
            compact('rooms', 'menus')
        );
    }
}
