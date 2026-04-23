<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display the cart page
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get();

        $cartData = [];
        $total = 0;
        $originalTotal = 0;
        $totalDiscount = 0;

        foreach ($products as $product) {
            $quantity = $cart[$product->id];
            $basePrice = $product->retail_price;
            
            $payableQuantity = $quantity;
            $itemDiscountedPrice = $basePrice;
            $freeItems = 0;

            if ($product->isPromotionActive()) {
                if ($product->promotion_type === 'discount_percent') {
                    $itemDiscountedPrice = max(0, $basePrice - ($basePrice * ($product->promotion_value / 100)));
                } elseif ($product->promotion_type === 'bogo') {
                    $freeItems = floor($quantity / 2);
                    $payableQuantity = $quantity - $freeItems;
                }
            }

            $originalSubtotal = $basePrice * $quantity;
            
            if ($product->isPromotionActive() && $product->promotion_type === 'bogo') {
                $subtotal = $basePrice * $payableQuantity;
            } else {
                $subtotal = $itemDiscountedPrice * $quantity;
            }

            $itemDiscount = $originalSubtotal - $subtotal;

            $total += $subtotal;
            $originalTotal += $originalSubtotal;
            $totalDiscount += $itemDiscount;

            $cartData[] = [
                'product' => $product,
                'quantity' => $quantity,
                'original_subtotal' => $originalSubtotal,
                'subtotal' => $subtotal,
                'discount' => $itemDiscount,
                'free_items' => $freeItems,
            ];
        }

        return view('storefront.cart', compact('cartData', 'total', 'originalTotal', 'totalDiscount'));
    }

    /**
     * Add product to cart via AJAX/Form
     */
    public function add(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = (int) $request->input('quantity', 1);

        $product = Product::findOrFail($productId);
        
        if ($product->stock < $quantity) {
            return back()->with('error', 'Not enough stock available.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId] += $quantity;
        } else {
            $cart[$productId] = $quantity;
        }

        session()->put('cart', $cart);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart!',
                'cart_count' => array_sum($cart),
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    /**
     * Update cart quantity
     */
    public function update(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = (int) $request->input('quantity');

        if ($quantity <= 0) {
            return $this->remove($productId);
        }

        $cart = session()->get('cart', []);
        if (isset($cart[$productId])) {
            $cart[$productId] = $quantity;
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Cart updated!');
    }

    /**
     * Remove item from cart
     */
    public function remove($productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Item removed from cart.');
    }
}
