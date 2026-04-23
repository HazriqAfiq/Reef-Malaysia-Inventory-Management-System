@props(['product'])

@php
    $isNew = $product->release_date && $product->release_date >= now()->subMonths(3);
    $isHot = $product->sales_sum_quantity && $product->sales_sum_quantity > 10;
@endphp

<a href="{{ route('storefront.show', $product->slug) }}" 
   x-data="{ 
        adding: false, 
        added: false,
        async quickAdd(id) {
            if (this.adding || this.added) return;
            this.adding = true;
            try {
                const response = await fetch('{{ route('cart.add') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ product_id: id, quantity: 1 })
                });
                const data = await response.json();
                if (data.success) {
                    this.added = true;
                    window.dispatchEvent(new CustomEvent('cart-updated', { detail: { count: data.cart_count } }));
                    setTimeout(() => this.added = false, 2000);
                }
            } finally { this.adding = false; }
        }
   }"
   class="group block relative text-center">
   
    <!-- Image & Badges Container -->
    <div class="relative bg-[#FAFAFA] aspect-[4/5] mb-4 overflow-hidden transition-colors group-hover:bg-[#F5F5F5] border border-transparent hover:border-gray-100">
        
        <!-- Badges (Top Left Floating without Background) -->
        <div class="absolute top-4 left-4 z-10 flex flex-col gap-1 text-left">
            @if($isNew)
                <span class="text-black text-[10px] font-bold uppercase tracking-[0.2em]">New</span>
            @endif
            @if($isHot)
                <span class="text-black text-[10px] font-bold uppercase tracking-[0.2em]">Hot</span>
            @endif
        </div>

        <!-- Promo Badge (Top Right) -->
        @if($product->isPromotionActive() && $product->promotion_badge)
        <div class="absolute top-4 right-4 z-10">
            <span class="text-black text-[10px] font-bold uppercase tracking-[0.2em]">{{ $product->promotion_badge }}</span>
        </div>
        @endif

        <img src="{{ $product->primaryImage ? asset('storage/' . $product->primaryImage->image_path) : 'https://placehold.co/600x800?text=' . urlencode($product->name) }}" 
             class="w-full h-full object-contain mix-blend-multiply transition-transform duration-700 ease-out group-hover:scale-105" alt="{{ $product->name }}">
        
        <!-- Quick Add Bar (Full Width, Desktop Only) -->
        <button @click.prevent.stop="quickAdd({{ $product->id }})" 
                class="absolute bottom-0 left-0 w-full bg-black/90 text-white py-4 text-[10px] font-bold tracking-[0.2em] uppercase transition-transform duration-300 translate-y-full group-hover:translate-y-0 hidden md:flex items-center justify-center gap-2 hover:bg-black backdrop-blur-sm">
            <template x-if="adding">
                <svg class="animate-spin h-3 w-3 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
            </template>
            <span x-text="added ? 'ADDED ✓' : (adding ? 'ADDING...' : 'ADD TO CART')"></span>
        </button>
    </div>

    <!-- Product Info -->
    <div class="px-1 flex flex-col items-center text-center">
        <!-- Title (Clean Sans-Serif - Aligned Spacing) -->
        <h4 class="text-[13px] font-medium text-gray-900 mb-1.5 group-hover:text-gray-500 transition-colors uppercase tracking-[0.2em] leading-tight">{{ $product->name }}</h4>
        
        <!-- Category (Under Title) -->
        <p class="text-[10px] font-medium text-gray-400 uppercase tracking-widest mb-1.5">{{ $product->category?->name ?? '' }}</p>

        <!-- All Fragrance Notes -->
        <p class="text-[9px] font-medium text-gray-400 uppercase tracking-[0.2em] mb-4 line-clamp-1 h-3 overflow-hidden">
            {{ collect([$product->top_note, $product->heart_note, $product->base_note])->filter()->join(' · ') ?: ($product->volume_ml ? $product->volume_ml . 'ml' : 'Signature Scent') }}
        </p>

        <!-- Price & Sales -->
        <div class="flex flex-col items-center gap-1.5">
            @if($product->isPromotionActive())
                @if($product->promotion_type === 'discount_percent')
                    <div class="flex items-center gap-2">
                        <p class="text-[11px] font-medium text-gray-400 tracking-[0.1em] line-through decoration-1">RM {{ number_format($product->retail_price, 2) }}</p>
                        <p class="text-[12px] font-bold text-red-700 tracking-[0.1em]">RM {{ number_format($product->discounted_price, 2) }}</p>
                    </div>
                @elseif($product->promotion_type === 'bogo')
                    <div class="flex flex-col items-center">
                        <div class="flex items-center gap-2">
                            <p class="text-[11px] font-medium text-gray-400 tracking-[0.1em] line-through decoration-1">RM {{ number_format($product->retail_price, 2) }}</p>
                            <p class="text-[12px] font-bold text-red-700 tracking-[0.1em]">RM {{ number_format($product->retail_price / 2, 2) }}*</p>
                        </div>
                        <p class="text-[8px] font-bold text-gray-400 uppercase mt-0.5 tracking-tighter">*With Buy 1 Free 1</p>
                    </div>
                @else
                    <p class="text-[12px] font-medium text-black tracking-[0.1em]">RM {{ number_format($product->retail_price, 2) }}</p>
                @endif
            @else
                <p class="text-[12px] font-medium text-black tracking-[0.1em]">RM {{ number_format($product->retail_price, 2) }}</p>
            @endif
            
            <div class="h-4">
                @if($product->sales_sum_quantity && $product->sales_sum_quantity > 0)
                    <p class="text-[10px] font-medium text-gray-400 tracking-wider flex items-center gap-1">
                        {{ $product->sales_sum_quantity }}+ Sold
                    </p>
                @endif
            </div>
        </div>
    </div>
</a>
