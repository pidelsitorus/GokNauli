<?php

namespace App\Http\Controllers;

use App\Models\MenuCategory;

class CafeMenuController extends Controller
{
    public function index()
    {
        $categories = MenuCategory::where('is_active', true)
            ->with([
                'menus' => function ($query) {
                    $query
                        ->where('is_active', true)
                        ->orderBy('sort_order')
                        ->orderBy('name');
                }
            ])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('menu.index', compact('categories'));
    }
}
