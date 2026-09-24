<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);

        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'quantity' => [
                'nullable',
                'integer',
                'min:1',
                'max:99',
            ],
        ]);

        if (!$menu->is_active || !$menu->is_available) {
            return back()->withErrors([
                'cart' => 'Menu tersebut sedang tidak tersedia.',
            ]);
        }

        $quantity = $validated['quantity'] ?? 1;

        $cart = $request->session()->get('cart', []);

        if (isset($cart[$menu->id])) {
            $cart[$menu->id]['quantity'] += $quantity;
        } else {
            $cart[$menu->id] = [
                'menu_id' => $menu->id,
                'name' => $menu->name,
                'price' => (float) $menu->price,
                'quantity' => $quantity,
            ];
        }

        $request->session()->put('cart', $cart);

        return response('', 302)
            ->header(
                'Location',
                route('cart.index', [], false)
            );
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'quantity' => [
                'required',
                'integer',
                'min:1',
                'max:99',
            ],
        ]);

        $cart = $request->session()->get('cart', []);

        if (isset($cart[$menu->id])) {
            $cart[$menu->id]['quantity'] = $validated['quantity'];

            $request->session()->put('cart', $cart);
        }

        return response('', 302)
            ->header(
                'Location',
                route('cart.index', [], false)
            );
    }

    public function remove(Request $request, Menu $menu)
    {
        $cart = $request->session()->get('cart', []);

        unset($cart[$menu->id]);

        $request->session()->put('cart', $cart);

        return response('', 302)
            ->header(
                'Location',
                route('cart.index', [], false)
            );
    }

    public function clear(Request $request)
    {
        $request->session()->forget('cart');

        return response('', 302)
            ->header(
                'Location',
                route('cart.index', [], false)
            );
    }
}
