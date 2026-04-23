<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Show the checkout page
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('storefront.index')->with('error', 'Your cart is empty.');
        }

        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get();
        
        $total = 0;
        foreach ($products as $product) {
            $total += $product->retail_price * $cart[$product->id];
        }

        return view('storefront.checkout', compact('products', 'cart', 'total'));
    }

    /**
     * Process order placement (Mock Success)
     */
    public function store(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('storefront.index');
        }

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'phone'      => 'required|string|max:20',
            'address'    => 'required|string',
            'city'       => 'required|string',
            'postcode'   => 'required|string',
            'state'      => 'required|string',
        ]);

        return DB::transaction(function () use ($cart) {
            $productIds = array_keys($cart);
            $products = Product::whereIn('id', $productIds)->lockForUpdate()->get();
            
            $totalPrice = 0;
            $itemsData = [];
            $salesData = [];

            foreach ($products as $product) {
                $qty = $cart[$product->id];

                if ($product->stock < $qty) {
                    throw new \Exception("Stock for {$product->name} has changed. Please review your cart.");
                }

                $itemSubtotal = $product->retail_price * $qty;
                $totalPrice += $itemSubtotal;

                // Prepare Order Item
                $itemsData[] = [
                    'product_id' => $product->id,
                    'quantity'   => $qty,
                    'price'      => $product->retail_price,
                ];

                // Prepare Sale Record (for analytics)
                $salesData[] = [
                    'user_id'     => Auth::id(), // Can be null if guest, but user confirmed explicit buyer role
                    'product_id'  => $product->id,
                    'quantity'    => $qty,
                    'total_price' => $itemSubtotal,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ];

                // Decrement Stock
                $product->decrement('stock', $qty);
            }

            // 1. Create Order
            $order = Order::create([
                'user_id'     => Auth::id(),
                'total_price' => $totalPrice,
                'status'      => 'paid', // Mock Success
                'billplz_id'  => 'MOCK_STORE_' . uniqid(),
            ]);

            // 2. Snapshot the shipping address (critical for data integrity)
            OrderAddress::create([
                'order_id'   => $order->id,
                'first_name' => request('first_name'),
                'last_name'  => request('last_name'),
                'email'      => request('email'),
                'phone'      => request('phone'),
                'address'    => request('address'),
                'city'       => request('city'),
                'state'      => request('state'),
                'postcode'   => request('postcode'),
            ]);

            // 3. Create Order Items
            $order->items()->createMany($itemsData);

            // 4. Create Sales Records (bulk insert for performance)
            Sale::insert($salesData);

            // Clear Cart
            session()->forget('cart');

            return redirect()->route('checkout.success')->with('order_id', $order->id);
        });
    }

    /**
     * Show success page
     */
    public function success()
    {
        return view('storefront.success');
    }
}
