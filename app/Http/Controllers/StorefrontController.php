<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\Setting;
use Illuminate\Http\Request;

class StorefrontController extends Controller
{
    /**
     * Storefront Homepage: Best Sellers & New Arrivals
     */
    public function index()
    {
        // 0. Settings
        $settings = Setting::all()->pluck('value', 'key');

        // 1. New Arrivals: Products released in the last 3 months
        $newArrivals = Product::active()
            ->withSum('sales', 'quantity')
            ->where('release_date', '>=', now()->subMonths(3))
            ->latest('release_date')
            ->limit(4)
            ->get();

        // 2. Best Sellers: Top products by total quantity sold
        $bestSellers = Product::active()
            ->withSum('sales', 'quantity')
            ->orderByDesc('sales_sum_quantity')
            ->limit(4)
            ->get();

        return view('storefront.index', compact('newArrivals', 'bestSellers', 'settings'));
    }

    /**
     * Shop / Collection Page: Filtering & Search
     */
    public function collection(Request $request)
    {
        $query = Product::active()->withSum('sales', 'quantity');

        // Filtering by Category (via normalized categories table, filtering by slug)
        if ($category = $request->input('category')) {
            $slugs = explode(',', $category);

            // Automatically include unisex when men or women is selected
            if (in_array('men', $slugs) || in_array('woman', $slugs)) {
                $slugs[] = 'unisex';
            }
            $slugs = array_unique($slugs);

            $query->whereHas('category', function ($q) use ($slugs) {
                $q->whereIn('slug', $slugs);
            });
        }

        // Filtering by Type (via normalized product_types table, filtering by slug)
        if ($type = $request->input('type')) {
            $slugs = explode(',', $type);
            $query->whereHas('productType', function ($q) use ($slugs) {
                $q->whereIn('slug', $slugs);
            });
        }

        // Sorting
        switch ($request->input('sort')) {
            case 'low-high':
                $query->orderBy('retail_price', 'asc');
                break;
            case 'high-low':
                $query->orderBy('retail_price', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->get();
        $settings = Setting::all()->pluck('value', 'key');

        return view('storefront.collection', compact('products', 'settings'));
    }

    /**
     * Product Detail Page
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->active()
            ->with(['images', 'category', 'productType'])
            ->withSum('sales', 'quantity')
            ->firstOrFail();

        $relatedProducts = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->withSum('sales', 'quantity')
            ->limit(4)
            ->get();

        return view('storefront.show', compact('product', 'relatedProducts'));
    }

    /**
     * New Arrivals Page
     */
    public function newArrivals(Request $request)
    {
        $products = Product::active()
            ->withSum('sales', 'quantity')
            ->where('release_date', '>=', now()->subMonths(3))
            ->latest('release_date')
            ->get();
        $settings = Setting::all()->pluck('value', 'key');
        
        $pageTitle = 'New Arrivals';
        $pageSubtitle = 'Recently Unveiled';
        $bannerImage = $settings['new_arrivals_hero_image'] ?? null;

        return view('storefront.simple-collection', compact('products', 'settings', 'pageTitle', 'pageSubtitle', 'bannerImage'));
    }

    /**
     * Best Sellers Page
     */
    public function bestSellers(Request $request)
    {
        $products = Product::active()
            ->withSum('sales', 'quantity')
            ->orderByDesc('sales_sum_quantity')
            ->get();
        $settings = Setting::all()->pluck('value', 'key');

        $pageTitle = 'Best Sellers';
        $pageSubtitle = 'Our Most Celebrated Scents';
        $bannerImage = $settings['best_sellers_hero_image'] ?? null;

        return view('storefront.simple-collection', compact('products', 'settings', 'pageTitle', 'pageSubtitle', 'bannerImage'));
    }

    /**
     * Promotions Page
     */
    public function promotions(Request $request)
    {
        $settings = Setting::all()->pluck('value', 'key');

        if (($settings['enable_promotions_page'] ?? '1') === '0') {
            abort(404);
        }

        $now = now();
        $products = Product::active()
            ->withSum('sales', 'quantity')
            ->whereNotNull('promotion_type')
            ->where(function ($query) use ($now) {
                $query->whereNull('promotion_starts_at')
                      ->orWhere('promotion_starts_at', '<=', $now);
            })
            ->where(function ($query) use ($now) {
                $query->whereNull('promotion_ends_at')
                      ->orWhere('promotion_ends_at', '>=', $now);
            })
            ->orderBy('retail_price', 'asc')
            ->get();

        $pageTitle = $settings['promotions_title'] ?? 'Exclusive Promos';
        $pageSubtitle = $settings['promotions_description'] ?? 'Discover our latest promotional events and seasonal discounts.';
        $bannerImage = $settings['promotions_hero_image'] ?? null;

        return view('storefront.simple-collection', compact('products', 'settings', 'pageTitle', 'pageSubtitle', 'bannerImage'));
    }
}
