<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\RestaurantTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);

        if (empty($cart)) {
            return response('', 302)
                ->header(
                    'Location',
                    route('cart.index', [], false)
                );
        }

        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        $tables = RestaurantTable::where('is_active', true)
            ->where('status', 'available')
            ->orderBy('capacity')
            ->orderBy('table_number')
            ->get();

        return view(
            'checkout.index',
            compact('cart', 'total', 'tables')
        );
    }

    public function store(Request $request)
    {
        $cart = $request->session()->get('cart', []);

        if (empty($cart)) {
            return back()->withErrors([
                'cart' => 'Keranjang pesanan kosong.',
            ]);
        }

        $validated = $request->validate([
            'customer_name' => [
                'required',
                'string',
                'max:255',
            ],
            'customer_phone' => [
                'required',
                'string',
                'max:30',
            ],
            'order_type' => [
                'required',
                Rule::in([
                    'dine_in',
                    'takeaway',
                ]),
            ],
            'restaurant_table_id' => [
                'nullable',
                'exists:restaurant_tables,id',
            ],
            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        if ($validated['order_type'] === 'dine_in') {
            if (empty($validated['restaurant_table_id'])) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'restaurant_table_id' =>
                            'Silakan pilih meja untuk pesanan Dine In.',
                    ]);
            }

            $table = RestaurantTable::whereKey(
                $validated['restaurant_table_id']
            )
                ->where('is_active', true)
                ->where('status', 'available')
                ->first();

            if (!$table) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'restaurant_table_id' =>
                            'Meja yang dipilih sedang tidak tersedia.',
                    ]);
            }
        }

        $menuIds = collect($cart)
            ->pluck('menu_id')
            ->all();

        $menus = Menu::whereIn('id', $menuIds)
            ->where('is_active', true)
            ->where('is_available', true)
            ->get()
            ->keyBy('id');

        if ($menus->count() !== count($cart)) {
            return back()->withErrors([
                'cart' =>
                    'Ada menu di keranjang yang sudah tidak tersedia. Silakan periksa kembali keranjang.',
            ]);
        }

        $order = DB::transaction(function () use (
            $validated,
            $cart,
            $menus
        ) {
            $subtotal = 0;

            foreach ($cart as $item) {
                $menu = $menus->get($item['menu_id']);

                $subtotal +=
                    (float) $menu->price
                    * (int) $item['quantity'];
            }

            $order = Order::create([
                'order_code' =>
                    'GN-ORD-' . strtoupper(Str::random(8)),

                'user_id' => auth()->id(),

                'restaurant_table_id' =>
                    $validated['order_type'] === 'dine_in'
                        ? $validated['restaurant_table_id']
                        : null,

                'customer_name' =>
                    $validated['customer_name'],

                'customer_phone' =>
                    $validated['customer_phone'],

                'order_type' =>
                    $validated['order_type'],

                'status' => 'pending',

                'payment_status' => 'unpaid',

                'subtotal' => $subtotal,

                'notes' =>
                    $validated['notes'] ?? null,
            ]);

            foreach ($cart as $item) {
                $menu = $menus->get($item['menu_id']);

                $quantity = (int) $item['quantity'];
                $price = (float) $menu->price;

                $order->items()->create([
                    'menu_id' => $menu->id,
                    'menu_name' => $menu->name,
                    'price' => $price,
                    'quantity' => $quantity,
                    'subtotal' => $price * $quantity,
                ]);
            }

            return $order;
        });

        $request->session()->forget('cart');

        return response('', 302)
            ->header(
                'Location',
                route(
                    'orders.success',
                    ['order' => $order],
                    false
                )
            );
    }

    public function success(Order $order)
    {
        $order->load([
            'items',
            'restaurantTable',
        ]);

        return view(
            'checkout.success',
            compact('order')
        );
    }
}
