<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('category')
            ->orderBy('menu_category_id')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        $categories = MenuCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.menus.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'menu_category_id' => ['required', 'exists:menu_categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_available' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $baseSlug = Str::slug($validated['name']);
        $slug = $baseSlug;
        $counter = 2;

        while (Menu::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $validated['slug'] = $slug;
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_available'] = $request->boolean('is_available');
        $validated['is_active'] = $request->boolean('is_active');

        Menu::create($validated);

        return redirect(
            route('admin.menus.index', [], false)
        )->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit(Menu $menu)
    {
        $categories = MenuCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view(
            'admin.menus.edit',
            compact('menu', 'categories')
        );
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'menu_category_id' => ['required', 'exists:menu_categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_available' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $baseSlug = Str::slug($validated['name']);
        $slug = $baseSlug;
        $counter = 2;

        while (
            Menu::where('slug', $slug)
                ->where('id', '!=', $menu->id)
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $validated['slug'] = $slug;
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_available'] = $request->boolean('is_available');
        $validated['is_active'] = $request->boolean('is_active');

        $menu->update($validated);

        return redirect(
            route('admin.menus.index', [], false)
        )->with('success', 'Menu berhasil diperbarui.');
    }
}
