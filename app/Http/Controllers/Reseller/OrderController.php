<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\ResellerStock;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->latest()->paginate(15);
        return view('reseller.orders.index', compact('orders'));
    }

    public function create()
    {
        $products = Product::where('stock', '>', 0)->get();
        return view('reseller.orders.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|array',
            'quantity' => 'required|array',
        ]);

        $products = $request->input('product_id');
        $quantities = $request->input('quantity');

        $totalPrice = 0;
        $orderItems = [];

        foreach ($products as $i => $id) {
            $qty = $quantities[$i] ?? 0;
            if ($qty > 0) {
                $product = Product::findOrFail($id);
                if ($product->stock < $qty) {
                    return back()->withErrors(['quantity' => "Not enough stock for {$product->name}."]);
                }
                
                $price = $product->wholesale_price * $qty;
                $totalPrice += $price;

                $orderItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'price' => $product->wholesale_price,
                ];
            }
        }

        if (empty($orderItems)) {
            return back()->withErrors(['quantity' => 'Please select at least one item.']);
        }

        $order = auth()->user()->orders()->create([
            'total_price' => $totalPrice,
            'status' => 'pending',
            'billplz_id' => 'MOCK_' . uniqid(),
        ]);

        $order->items()->createMany($orderItems);

        // Notify admins of the new wholesale order
        NotificationService::newOrder($order, auth()->user());

        return redirect()->route('reseller.orders.payment', $order);
    }

    public function payment(Order $order)
    {
        if ($order->user_id !== auth()->id()) abort(403);
        if ($order->status === 'paid') {
            return redirect()->route('reseller.orders.show', $order);
        }
        return view('reseller.orders.payment', compact('order'));
    }

    public function callback(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) abort(403);
        if ($order->status === 'paid') {
            return redirect()->route('reseller.orders.show', $order);
        }

        $order->update(['status' => 'paid']);

        foreach ($order->items as $item) {
            $item->product->decrement('stock', $item->quantity);

            $stock = ResellerStock::firstOrCreate([
                'user_id' => $order->user_id,
                'product_id' => $item->product_id,
            ]);
            $stock->increment('quantity', $item->quantity);

            // Check admin inventory threshold after decrement
            $freshProduct = $item->product->fresh();
            if ($freshProduct->stock === 0) {
                NotificationService::outOfStock($freshProduct);
            } elseif ($freshProduct->stock < 50) {
                NotificationService::lowStock($freshProduct);
            }
        }

        // Notify the reseller that their order was approved
        NotificationService::orderApproved($order);

        return redirect()->route('reseller.orders.show', $order)->with('success', 'Payment successful. Order confirmed.');
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) abort(403);
        $order->load('items.product');
        return view('reseller.orders.show', compact('order'));
    }

    public function invoice(Order $order)
    {
        if ($order->user_id !== auth()->id()) abort(403);
        $order->load('items.product', 'user');
        
        $pdf = Pdf::loadView('reseller.orders.invoice', compact('order'));
        return $pdf->download("invoice_ORD_{$order->id}.pdf");
    }
}
