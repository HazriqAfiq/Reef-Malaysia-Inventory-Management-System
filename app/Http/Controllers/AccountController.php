<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $latestOrder = Order::where('user_id', $user->id)->latest()->first();
        $defaultAddress = $user->addresses()->where('is_default', true)->first() ?? $user->addresses()->latest()->first();
        
        return view('account.index', compact('user', 'latestOrder', 'defaultAddress'));
    }

    public function orders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with(['items.product.primaryImage'])
            ->latest()
            ->paginate(10);

        return view('account.orders', compact('orders'));
    }

    public function addresses()
    {
        $addresses = Auth::user()->addresses()->latest()->get();
        return view('account.addresses', compact('addresses'));
    }

    public function storeAddress(Request $request)
    {
        $request->validate([
            'label' => 'nullable|string|max:255',
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
        ]);

        $isDefault = $request->has('is_default') || Auth::user()->addresses()->count() === 0;

        if ($isDefault) {
            Auth::user()->addresses()->update(['is_default' => false]);
        }

        Auth::user()->addresses()->create(array_merge($request->all(), ['is_default' => $isDefault]));

        return back()->with('success', 'Address added successfully.');
    }

    public function deleteAddress(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $address->delete();
        return back()->with('success', 'Address removed successfully.');
    }

    public function settings()
    {
        $user = Auth::user();
        return view('account.settings', compact('user'));
    }
}
