<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    /**
     * Display a specific settings page.
     */
    public function showPage($page = 'global')
    {
        $validPages = ['global', 'homepage', 'collection', 'new_arrivals', 'best_sellers', 'promotions'];
        
        if (!in_array($page, $validPages)) {
            return redirect()->route('admin.settings.page', 'global');
        }

        $settings = Setting::where('group', $page)->get();

        if ($page === 'promotions') {
            return view('admin.settings.promotions', compact('settings', 'page'));
        }

        return view('admin.settings.page', compact('settings', 'page'));
    }

    /**
     * Update storefront settings for a specific page.
     */
    public function updatePage(Request $request, $page)
    {
        $data = $request->except('_token');

        // Note: Checkbox boolean fields don't send anything if unchecked. 
        // Iterate through all boolean settings in this group to address unchecked ones.
        $groupSettings = Setting::where('group', $page)->get();

        foreach ($groupSettings as $setting) {
            if ($setting->type === 'boolean') {
                $newValue = $request->has($setting->key) ? '1' : '0';

                // Specific logic: Reset all product promotions if the promotions page is being disabled.
                if ($page === 'promotions' && $setting->key === 'enable_promotions_page' && $newValue === '0' && $setting->value === '1') {
                    Product::query()->update([
                        'promotion_type' => null,
                        'promotion_value' => null,
                        'promotion_badge' => null,
                        'promotion_starts_at' => null,
                        'promotion_ends_at' => null,
                    ]);
                }

                $setting->update(['value' => $newValue]);
            }
        }

        foreach ($data as $key => $value) {
            $setting = Setting::where('key', $key)->first();
            
            if (!$setting || $setting->type === 'boolean') continue; // Booleans handled above

            // Handle Image Upload
            if ($setting->type === 'image' && $request->hasFile($key)) {
                $file = $request->file($key);
                $filename = time() . '_' . $file->getClientOriginalName();
                
                // Determine folder based on key
                $folder = 'hero';
                if (str_contains($key, 'logo')) $folder = 'branding';
                
                $path = $file->storeAs($folder, $filename, 'public');
                $dbPath = $folder . '/' . $filename;
                
                // Delete old image if it exists and is not the original protected default
                $protectedDefaults = ['hero/hero_cinematic.png', 'branding/logo.png'];
                if ($setting->value && !in_array($setting->value, $protectedDefaults)) {
                    if (Storage::disk('public')->exists($setting->value)) {
                        Storage::disk('public')->delete($setting->value);
                    }
                }

                $setting->update(['value' => $dbPath]);
                continue;
            }

            // Handle Text/TextArea
            if (!is_null($value)) {
                $setting->update(['value' => $value]);
            }
        }

        return redirect()->back()->with('success', ucfirst(str_replace('_', ' ', $page)) . ' settings updated successfully.');
    }

    /**
     * Set a global promotion across all products in the catalog.
     */
    public function globalPromotion(Request $request)
    {
        $request->validate([
            'promotion_type' => 'required|in:discount_percent,bogo',
            'discount_percentage' => 'nullable|required_if:promotion_type,discount_percent|integer|min:1|max:100',
            'promotion_badge' => 'nullable|string|max:50',
            'promotion_starts_at' => 'nullable|date',
            'promotion_ends_at' => 'nullable|date|after_or_equal:promotion_starts_at',
        ]);

        Product::query()->update([
            'promotion_type' => $request->promotion_type,
            'promotion_value' => $request->promotion_type === 'discount_percent' ? $request->discount_percentage : null,
            'promotion_badge' => $request->promotion_badge ?? ($request->promotion_type === 'bogo' ? 'BUY 1 GET 1' : 'PROMO'),
            'promotion_starts_at' => $request->promotion_starts_at,
            'promotion_ends_at' => $request->promotion_ends_at,
        ]);

        $message = $request->promotion_type === 'bogo' 
            ? 'Global "Buy 1 Free 1" promotion successfully applied to all products.'
            : 'Global promotion of ' . $request->discount_percentage . '% successfully applied to all products.';

        return redirect()->back()->with('success', $message);
    }
}
