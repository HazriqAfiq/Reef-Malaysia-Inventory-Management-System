<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class StorefrontSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Global Settings
            ['key' => 'brand_name', 'value' => 'Laman Store', 'type' => 'text', 'group' => 'global'],
            ['key' => 'announcement_bar_enabled', 'value' => '1', 'type' => 'boolean', 'group' => 'global'],
            ['key' => 'announcement_bar_text', 'value' => 'Complimentary Shipping on all orders over RM150', 'type' => 'text', 'group' => 'global'],
            ['key' => 'footer_instagram', 'value' => 'https://instagram.com', 'type' => 'text', 'group' => 'global'],
            ['key' => 'footer_facebook', 'value' => 'https://facebook.com', 'type' => 'text', 'group' => 'global'],

            // Homepage Settings
            ['key' => 'homepage_title', 'value' => 'The Art of Pure Essence', 'type' => 'text', 'group' => 'homepage'],
            ['key' => 'homepage_subtitle', 'value' => 'The Laman Signature', 'type' => 'text', 'group' => 'homepage'],
            ['key' => 'homepage_hero_image', 'value' => 'hero/hero_cinematic.png', 'type' => 'image', 'group' => 'homepage'],

            // Collection Settings
            ['key' => 'collection_title', 'value' => 'OUR COLLECTION', 'type' => 'text', 'group' => 'collection'],
            ['key' => 'collection_description', 'value' => 'Timeless Scents. Curated for You.', 'type' => 'textarea', 'group' => 'collection'],
            ['key' => 'collection_hero_image', 'value' => 'hero/shop_banner_cinematic.png', 'type' => 'image', 'group' => 'collection'],

            // New Arrivals Settings
            ['key' => 'new_arrivals_hero_image', 'value' => 'hero/shop_banner_cinematic.png', 'type' => 'image', 'group' => 'new_arrivals'],

            // Best Sellers Settings
            ['key' => 'best_sellers_hero_image', 'value' => 'hero/shop_banner_cinematic.png', 'type' => 'image', 'group' => 'best_sellers'],

            // Promotions Settings
            ['key' => 'enable_promotions_page', 'value' => '1', 'type' => 'boolean', 'group' => 'promotions'],
            ['key' => 'promotions_title', 'value' => 'Exclusive Promos', 'type' => 'text', 'group' => 'promotions'],
            ['key' => 'promotions_description', 'value' => 'Discover our latest promotional events and seasonal discounts.', 'type' => 'textarea', 'group' => 'promotions'],
            ['key' => 'promotions_hero_image', 'value' => 'hero/shop_banner_cinematic.png', 'type' => 'image', 'group' => 'promotions'],

            // Scent Finder Settings
            ['key' => 'scent_finder_hero_image', 'value' => 'https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?auto=format&fit=crop&q=80&w=2000', 'type' => 'image', 'group' => 'scent_finder'],
            ['key' => 'scent_finder_results_hero_image', 'value' => 'https://images.unsplash.com/photo-1557170334-a9632e77c6e4?auto=format&fit=crop&q=80&w=2000', 'type' => 'image', 'group' => 'scent_finder'],

            // Auth Settings
            ['key' => 'sign_in_image', 'value' => 'hero/hero_cinematic.png', 'type' => 'image', 'group' => 'auth'],
            ['key' => 'sign_up_image', 'value' => 'https://images.unsplash.com/photo-1594035910387-fea47794261f?q=80&w=1974&auto=format&fit=crop', 'type' => 'image', 'group' => 'auth'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
