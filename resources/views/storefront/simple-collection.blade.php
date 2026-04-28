<x-storefront-layout :hasHero="true" :darkHero="true">
    <x-slot name="title">{{ $pageTitle ?? 'Collection' }}</x-slot>

    <div class="bg-white min-h-screen">
        <!-- ── CINEMATIC SHOP BANNER ────────────────────────────────────────────────── -->
        <header class="relative h-[40vh] min-h-[350px] flex flex-col items-center justify-center overflow-hidden bg-black text-white">
            <!-- Cinematic Scrim System -->
            <div class="absolute inset-0 z-[1] bg-black/40"></div> <!-- Global Tint -->
            <div class="absolute inset-x-0 bottom-0 h-[80%] bg-gradient-to-t from-black/90 via-black/40 to-transparent z-[2]"></div> <!-- Bottom Scrim -->

            <!-- Background Image -->
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('storage/' . ($bannerImage ?? $settings['shop_banner_image'] ?? ($settings['hero_image'] ?? 'hero/hero_cinematic.png'))) }}" 
                     class="w-full h-full object-cover animate-zoom-slow" 
                     alt="Shop cinematic background">
            </div>

            <div class="relative z-[3] text-center px-4 animate-fade-in-up mt-16">
                <div class="inline-flex gap-8 items-center mb-6">
                    <p class="w-8 md:w-16 h-[1px] bg-white opacity-40"></p>
                    <p class="text-white/60 text-3xl md:text-5xl font-light uppercase tracking-[0.3em] leading-none whitespace-nowrap">
                        {{ explode(' ', $pageTitle ?? 'OUR COLLECTION')[0] ?? 'OUR' }} 
                        <span class="text-white font-semibold">
                            {{ implode(' ', array_slice(explode(' ', $pageTitle ?? 'OUR COLLECTION'), 1)) ?: 'COLLECTION' }}
                        </span>
                    </p>
                    <p class="w-8 md:w-16 h-[1px] bg-white opacity-40"></p>
                </div>
                <p class="text-[11px] font-bold text-white uppercase tracking-[0.5em] drop-shadow-lg" style="text-shadow: 0 2px 4px rgba(0,0,0,0.5);">
                    {{ $pageSubtitle ?? 'Timeless Scents. Curated for You.' }}
                </p>
            </div>

            <x-scroll-indicator />
        </header>

        <div class="max-w-[1600px] mx-auto px-6 sm:px-8 lg:px-12 py-16">
            <!-- ── REFINED TOP BAR ────────────────────────── -->
            <div class="flex flex-col sm:flex-row justify-between items-center mb-16 pb-8 border-b border-gray-100 gap-8">
                <div class="flex items-center gap-12">
                     <p class="text-[13px] font-black uppercase tracking-widest text-black">{{ $pageTitle ?? 'Collection' }}</p>
                </div>

                <div class="flex items-center gap-12">
                     <p class="text-[11px] font-bold text-gray-300 uppercase tracking-widest">{{ $products->count() }} Results</p>
                </div>
            </div>

            <!-- ── PRODUCT GRID ─────────────────────────────────────────── -->
            <div>
                @if($products->isEmpty())
                    <div class="py-40 text-center">
                        <h3 class="text-2xl font-serif mb-4 text-gray-400">No fragrances found</h3>
                        <p class="text-[11px] text-gray-300 font-bold uppercase tracking-widest">More coming soon</p>
                    </div>
                @else
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-x-8 gap-y-16">
                        @foreach($products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-storefront-layout>
