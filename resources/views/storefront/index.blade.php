<x-storefront-layout :hasHero="true" :darkHero="true">
    <x-slot name="title">Luxury Fragrances</x-slot>

    <!-- ── IMMERSIVE HERO SECTION ─────────────────────────────────────────── -->
    <section class="relative h-[85vh] min-h-[600px] flex items-center justify-center overflow-hidden bg-black text-white">
        <!-- Cinematic Scrim System -->
        <div class="absolute inset-0 z-[1] bg-black/30"></div> <!-- Global Tint -->
        <div class="absolute inset-x-0 bottom-0 h-2/3 bg-gradient-to-t from-black/90 via-black/20 to-transparent z-[2]"></div> <!-- Bottom Scrim -->

        <!-- Background Scaling Image -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('storage/' . ($settings['homepage_hero_image'] ?? 'hero/hero_cinematic.png')) }}" 
                 class="w-full h-full object-cover animate-zoom-slow" 
                 alt="Cinematic Perfume">
        </div>

        <!-- Hero Content -->
        <div class="relative z-[3] text-center px-4 max-w-4xl mx-auto space-y-8">
            <div class="space-y-6 animate-fade-in-up">
                <p class="text-[11px] font-bold uppercase tracking-[0.6em] text-white drop-shadow-lg" style="text-shadow: 0 2px 4px rgba(0,0,0,0.5);">
                    {{ $settings['homepage_subtitle'] ?? 'The Laman Signature' }}
                </p>
                <h1 class="font-serif text-[50px] md:text-[80px] leading-tight font-medium drop-shadow-2xl text-white" 
                    style="text-shadow: 0 4px 20px rgba(0,0,0,0.6), 0 0 40px rgba(0,0,0,0.4);">
                    {!! nl2br(e($settings['homepage_title'] ?? "The Art of \n Pure Essence")) !!}
                </h1>
            </div>

            <div class="flex flex-col items-center gap-12 animate-fade-in-up delay-300">
                <a href="{{ route('storefront.collection') }}" 
                   class="inline-block border border-white px-12 py-4 text-[11px] font-bold tracking-[0.3em] uppercase hover:bg-white hover:text-black transition-all duration-500">
                    Explore Collection
                </a>

                <!-- Scroll Indicator -->
                <div class="flex flex-col items-center gap-4 text-white/30 cursor-pointer" @click="window.scrollTo({ top: window.innerHeight * 0.85, behavior: 'smooth' })">
                    <span class="text-[9px] font-bold uppercase tracking-[0.4em] rotate-90 origin-left ml-2 mb-4">Scroll</span>
                    <div class="w-px h-16 bg-white/20 relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-1/2 bg-white animate-[scroll-down_2s_infinite]"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ── NEW ARRIVALS ──────────────────────────────────────────────────── -->
    <section class="py-24 bg-white overflow-hidden">
        <div class="w-full px-4 sm:px-8 lg:px-12 xl:px-16">
            <div class="text-center mb-16">
                <div class="inline-flex gap-8 items-center mb-4">
                    <p class="w-8 md:w-16 h-[1px] bg-gray-300"></p>
                    <p class="text-gray-400 text-2xl md:text-3xl font-light uppercase tracking-[0.4em] leading-none whitespace-nowrap">
                        NEW <span class="text-gray-800 font-medium">ARRIVALS</span>
                    </p>
                    <p class="w-8 md:w-16 h-[1px] bg-gray-300"></p>
                </div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">Timeless scents, recently unveiled</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-x-8 gap-y-16">
                @foreach($newArrivals as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
            <div class="mt-16 text-center">
                <a href="{{ route('storefront.newArrivals') }}" class="inline-block border border-gray-800 px-12 py-4 text-[11px] font-bold tracking-[0.3em] uppercase text-gray-800 hover:bg-gray-800 hover:text-white transition-all duration-500">
                    Explore New Arrivals
                </a>
            </div>
        </div>
    </section>

    <!-- ── BRAND PHILOSOPHY ─────────────────────────────────────────────── -->
    <section class="py-40 bg-white overflow-hidden relative border-t border-b border-gray-50">
        <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
            <div class="flex items-center justify-center gap-4 mb-20">
                <p class="w-10 h-0.5 bg-gray-800"></p>
                <h2 class="text-[11px] font-bold uppercase tracking-[0.5em] text-gray-400 italic">Our Philosophy</h2>
                <p class="w-10 h-0.5 bg-gray-800"></p>
            </div>
            <p class="text-3xl sm:text-5xl font-serif text-black font-medium leading-[1.4] mb-16 italic">
                "{{ $settings['philosophy_quote'] ?? 'Fragrances are not just scents, they are stories bottled in glass, waiting to be told across your skin.' }}"
            </p>
            <a href="{{ route('storefront.collection') }}" class="inline-block text-[11px] font-bold uppercase tracking-[0.4em] text-gray-800 border-b border-gray-800 pb-2 hover:opacity-50 transition-opacity">Our Heritage</a>
        </div>
    </section>

    <!-- ── BEST SELLERS ─────────────────────────────────────────────────── -->
    <section class="py-24 bg-white">
        <div class="w-full px-4 sm:px-8 lg:px-12 xl:px-16">
            <div class="text-center mb-16">
                <div class="inline-flex gap-8 items-center mb-4">
                    <p class="w-8 md:w-16 h-[1px] bg-gray-300"></p>
                    <p class="text-gray-400 text-2xl md:text-3xl font-light uppercase tracking-[0.4em] leading-none whitespace-nowrap">
                        BEST <span class="text-gray-800 font-medium">SELLERS</span>
                    </p>
                    <p class="w-8 md:w-16 h-[1px] bg-gray-300"></p>
                </div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">Our most celebrated signature scents</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                @foreach($bestSellers as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
            <div class="mt-16 text-center">
                <a href="{{ route('storefront.bestSellers') }}" class="inline-block border border-gray-800 px-12 py-4 text-[11px] font-bold tracking-[0.3em] uppercase text-gray-800 hover:bg-gray-800 hover:text-white transition-all duration-500">
                    Explore Best Sellers
                </a>
            </div>
        </div>
    </section>

</x-storefront-layout>
