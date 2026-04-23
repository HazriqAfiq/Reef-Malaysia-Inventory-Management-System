<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductType;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display the inventory list with search, filter, and pagination.
     */
    public function index(Request $request)
    {
        $query = Product::withSum('sales', 'quantity')
            ->withSum('resellerStocks', 'quantity');

        // Search by name or SKU
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Filter by stock level
        match ($request->input('stock')) {
            'out'    => $query->where('stock', 0),
            'low'    => $query->where('stock', '>', 0)->where('stock', '<', 50),
            'medium' => $query->where('stock', '>=', 50)->where('stock', '<=', 100),
            'high'   => $query->where('stock', '>', 100),
            default  => null,
        };

        // Filter by volume
        if ($volume = $request->input('volume')) {
            $query->where('volume_ml', $volume);
        }

        // Sort
        $sortMap = [
            'name'            => ['name', 'asc'],
            'retail_price'    => ['retail_price', 'desc'],
            'wholesale_price' => ['wholesale_price', 'desc'],
            'stock'           => ['stock', 'asc'],
            'volume'          => ['volume_ml', 'asc'],
        ];
        [$sortCol, $sortDir] = $sortMap[$request->input('sort', 'name')] ?? ['name', 'asc'];
        $query->orderBy($sortCol, $sortDir);

        $products = $query->get();

        // Summary stats for header
        $totalProducts   = Product::count();
        $adminStock      = Product::sum('stock');
        $resellerStock   = \App\Models\ResellerStock::sum('quantity');
        $totalStock      = $adminStock + $resellerStock;
        $lowStockCount   = Product::where('stock', '>', 0)->where('stock', '<', 50)->count();
        $outOfStock      = Product::where('stock', 0)->count();

        // Available volume options for filter dropdown
        $volumes = Product::distinct()->orderBy('volume_ml')->pluck('volume_ml');

        return view('admin.products.index', compact(
            'products', 'totalProducts', 'totalStock', 'adminStock', 'resellerStock',
            'lowStockCount', 'outOfStock', 'volumes'
        ));
    }

    public function create()
    {
        $categories   = Category::orderBy('name')->get();
        $productTypes = ProductType::orderBy('name')->get();
        return view('admin.products.create', compact('categories', 'productTypes'));
    }

    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());

        if ($product->stock === 0) {
            NotificationService::outOfStock($product);
        } elseif ($product->stock < 50) {
            NotificationService::lowStock($product);
        }

        return redirect()->route('admin.products.index')->with('success', 'Product added successfully.');
    }

    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories   = Category::orderBy('name')->get();
        $productTypes = ProductType::orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories', 'productTypes'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $oldStock = $product->stock;
        $product->update($request->validated());
        $product->refresh();

        // Fire inventory alerts only when stock transitions into a threshold
        if ($product->stock === 0 && $oldStock !== 0) {
            NotificationService::outOfStock($product);
        } elseif ($product->stock < 50 && $product->stock > 0 && $oldStock >= 50) {
            NotificationService::lowStock($product);
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    }
}
