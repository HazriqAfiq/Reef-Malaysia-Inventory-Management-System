<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\StorefrontController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;

// ── Storefront (Guest Accessible) ───────────────────────────────────
Route::get('/', [StorefrontController::class, 'index'])->name('storefront.index');
Route::get('/collection', [StorefrontController::class, 'collection'])->name('storefront.collection');
Route::get('/product/{slug}', [StorefrontController::class, 'show'])->name('storefront.show');
Route::get('/new-arrivals', [StorefrontController::class, 'newArrivals'])->name('storefront.newArrivals');
Route::get('/best-sellers', [StorefrontController::class, 'bestSellers'])->name('storefront.bestSellers');
Route::get('/promotions', [StorefrontController::class, 'promotions'])->name('storefront.promotions');


// ── Shopping Cart ────────────────────────────────────────────────────
Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{productId}', [\App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');

// ── Checkout ─────────────────────────────────────────────────────────
Route::get('/checkout', [\App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [\App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/success', [\App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');


Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    
    if ($user->isReseller()) {
        return redirect()->route('reseller.dashboard');
    }

    // Default for Buyers: Redirect to Account Page
    return redirect()->route('account.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', \App\Http\Controllers\ProductController::class);
    Route::resource('resellers', \App\Http\Controllers\Admin\ResellerController::class);
    Route::get('/sales', [\App\Http\Controllers\SaleController::class, 'index'])->name('sales.index');
    Route::get('/sales/report', [\App\Http\Controllers\SaleController::class, 'report'])->name('sales.report');
    Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
    
    // Storefront Settings
    Route::get('/settings/{page?}', [\App\Http\Controllers\Admin\SettingsController::class, 'showPage'])->name('settings.page');
    Route::post('/settings/global-promotion', [\App\Http\Controllers\Admin\SettingsController::class, 'globalPromotion'])->name('settings.globalPromotion');
    Route::post('/settings/{page}', [\App\Http\Controllers\Admin\SettingsController::class, 'updatePage'])->name('settings.page.update');
});

Route::middleware(['auth', 'verified', 'role:reseller'])->prefix('reseller')->name('reseller.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Reseller\ResellerDashboardController::class, 'index'])->name('dashboard');
    Route::resource('sales', \App\Http\Controllers\SaleController::class)->only(['index', 'create', 'store']);
    Route::resource('orders', \App\Http\Controllers\Reseller\OrderController::class)->only(['index', 'create', 'store', 'show']);
    Route::get('orders/{order}/payment', [\App\Http\Controllers\Reseller\OrderController::class, 'payment'])->name('orders.payment');
    Route::post('orders/{order}/callback', [\App\Http\Controllers\Reseller\OrderController::class, 'callback'])->name('orders.callback');
    Route::get('orders/{order}/invoice', [\App\Http\Controllers\Reseller\OrderController::class, 'invoice'])->name('orders.invoice');
    Route::get('/stock', [\App\Http\Controllers\Reseller\StockController::class, 'index'])->name('stock.index');
});

// ── Buyer Account ──────────────────────────────────────────────────
Route::middleware('auth')->prefix('account')->group(function () {
    Route::get('/', [AccountController::class, 'index'])->name('account.index');
    Route::get('/orders', [AccountController::class, 'orders'])->name('account.orders');
    Route::get('/addresses', [AccountController::class, 'addresses'])->name('account.addresses');
    Route::post('/addresses', [AccountController::class, 'storeAddress'])->name('account.addresses.store');
    Route::delete('/addresses/{address}', [AccountController::class, 'deleteAddress'])->name('account.addresses.delete');
    Route::get('/settings', [AccountController::class, 'settings'])->name('account.settings');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Notifications API (used by frontend polling)
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::post('/read-all', [NotificationController::class, 'markAllRead'])->name('readAll');
        Route::post('/{notification}/read', [NotificationController::class, 'markRead'])->name('read');
    });
});

require __DIR__.'/auth.php';
