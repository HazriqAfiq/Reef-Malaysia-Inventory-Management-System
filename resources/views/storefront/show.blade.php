<x-storefront-layout>
    <x-slot name="title">{{ $product->name }}</x-slot>

    <div class="bg-white border-t-2 pt-16" x-data="{ activeImage: 0 }">
        <div class="w-full px-4 sm:px-8 lg:px-12 xl:px-16 pb-24">
            <div class="flex flex-col lg:flex-row gap-12 lg:gap-16">
                
                <!-- ── PRODUCT IMAGES (Kakikaw Style) ───────────────────────── -->
                <div class="w-full lg:w-[60%] flex flex-col md:flex-row-reverse gap-4">
                    <!-- Main Image Display -->
                    <div class="flex-1 aspect-square bg-[#FAFAFA] overflow-hidden flex items-center justify-center p-4">
                        @if($product->images->isNotEmpty())
                            @foreach($product->images as $index => $img)
                                <img x-show="activeImage === {{ $index }}" 
                                     x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 pb-10" x-transition:enter-end="opacity-100 pb-0"
                                     src="{{ asset('storage/' . $img->image_path) }}" 
                                     class="w-full h-full object-contain mix-blend-multiply" alt="{{ $product->name }}">
                            @endforeach
                        @else
                            <img src="https://placehold.co/800x1000?text={{ urlencode($product->name) }}" class="w-full h-full object-contain opacity-10" alt="Placeholder">
                        @endif
                    </div>

                    <!-- Thumbnails -->
                    <div class="flex md:flex-col gap-3 overflow-x-auto md:overflow-x-visible pb-4 md:pb-0 scrollbar-hide md:w-[20%]">
                        @foreach($product->images as $index => $img)
                            <button @click="activeImage = {{ $index }}" 
                                    :class="activeImage === {{ $index }} ? 'border-gray-800' : 'border-transparent opacity-60'"
                                    class="w-full aspect-square bg-[#FAFAFA] border-2 transition-all overflow-hidden p-2">
                                <img src="{{ asset('storage/' . $img->image_path) }}" class="w-full h-full object-contain mix-blend-multiply" alt="Thumbnail {{ $index + 1 }}">
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- ── PRODUCT DETAILS ───────────────────────────────────────── -->
                <div class="w-full lg:w-[40%] flex flex-col pt-2">
                    <div class="pb-10 border-b border-gray-100">
                        <h1 class="text-4xl lg:text-5xl font-serif text-gray-900 font-medium italic tracking-wide mb-2 mt-4">{{ $product->name }}</h1>
                        
                        <div class="flex flex-col gap-1 mb-8">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $product->category?->name ?? '' }}</span>
                            <span class="text-[11px] font-medium text-gray-500 uppercase tracking-widest">
                                {{ collect([$product->top_note, $product->heart_note, $product->base_note])->filter()->join(' · ') ?: 'Signature Composition' }}
                            </span>
                        </div>
                        
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-6 border border-gray-100 inline-block px-4 py-2">Volume: {{ $product->volume_ml }}ml</p>
                        
                        <div class="flex items-baseline gap-4 mb-8">
                            <span class="text-2xl font-black text-black tracking-widest uppercase">RM {{ number_format($product->retail_price, 2) }}</span>
                        </div>

                        <div class="text-[13px] text-gray-500 font-medium leading-relaxed tracking-wide mb-10">
                            {{ $product->description }}
                        </div>

                        <div class="flex items-center gap-6">
                             <div class="flex items-center gap-2">
                                <span class="text-[11px] font-bold uppercase tracking-widest text-emerald-600">
                                    {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                                </span>
                             </div>
                        </div>
                    </div>

                    <!-- Add to Cart (AJAX Enabled) -->
                    <div class="py-10" x-data="{ 
                        adding: false, 
                        added: false,
                        quantity: 1,
                        async addToCart() {
                            this.adding = true;
                            try {
                                const response = await fetch('{{ route('cart.add') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Accept': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        product_id: {{ $product->id }},
                                        quantity: this.quantity
                                    })
                                });
                                const data = await response.json();
                                if (data.success) {
                                    this.added = true;
                                    window.dispatchEvent(new CustomEvent('cart-updated', { detail: { count: data.cart_count } }));
                                    setTimeout(() => this.added = false, 2000);
                                }
                            } catch (error) {
                                console.error('Error adding to cart:', error);
                            } finally {
                                this.adding = false;
                            }
                        }
                    }">
                        <form @submit.prevent="addToCart">
                            <div class="flex flex-col gap-8">
                                <button type="submit" 
                                        :disabled="adding || added || {{ $product->stock <= 0 ? 'true' : 'false' }}"
                                        class="w-full bg-black text-white px-12 py-4 text-sm font-medium hover:bg-gray-800 transition-all disabled:bg-gray-400 flex items-center justify-center gap-2">
                                    <template x-if="adding">
                                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    </template>
                                    <span x-text="added ? 'ADDED TO CART ✓' : (adding ? 'ADDING...' : '{{ $product->stock > 0 ? 'ADD TO CART' : 'OUT OF STOCK' }}')"></span>
                                </button>
                                
                                <hr class="border-gray-100" />
                                
                                <div class="grid grid-cols-3 gap-3">
                                    <!-- Golden Guarantee -->
                                    <div class="border border-gray-200 rounded-2xl p-4 flex flex-col items-center justify-center text-center bg-white">
                                        <svg class="w-7 h-7 text-gray-900 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                        </svg>
                                        <p class="text-[11px] lg:text-[12px] font-bold text-gray-900 mb-1 leading-tight tracking-wide">Golden Guarantee</p>
                                        <p class="text-[9px] lg:text-[10px] text-gray-400">Return within 30 days</p>
                                    </div>

                                    <!-- High Stability -->
                                    <div class="border border-gray-200 rounded-2xl p-4 flex flex-col items-center justify-center text-center bg-white">
                                        <svg class="w-7 h-7 text-gray-900 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5" />
                                        </svg>
                                        <p class="text-[11px] lg:text-[12px] font-bold text-gray-900 mb-1 leading-tight tracking-wide">High Stability</p>
                                        <p class="text-[9px] lg:text-[10px] text-gray-400">Lasts for hours</p>
                                    </div>

                                    <!-- Fast Delivery -->
                                    <div class="border border-gray-200 rounded-2xl p-4 flex flex-col items-center justify-center text-center bg-white">
                                        <svg class="w-7 h-7 text-gray-900 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.129-1.125V11.25c0-4.446-3.51-8.31-7.962-8.447-4.062-.123-7.514 3.018-8.134 6.84a1.875 1.875 0 000 .375v2.25M17.25 18.75V11.25M17.25 18.75H6.75V11.25m10.5 0V7.5a3.75 3.75 0 10-7.5 0v3.75m0 0h7.5" />
                                        </svg>
                                        <p class="text-[11px] lg:text-[12px] font-bold text-gray-900 mb-1 leading-tight tracking-wide">Fast Delivery</p>
                                        <p class="text-[9px] lg:text-[10px] text-gray-400">within 6 hours.</p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- ── DESCRIPTION & RELATED ────────────────────────────────────── -->
            <div class="mt-20">
                <div class="flex">
                    <b class="border border-gray-100 px-8 py-4 text-sm bg-white">Description</b>
                    <p class="border border-gray-100 px-8 py-4 text-sm text-gray-400 bg-[#FAFAFA]">Reviews (122)</p>
                </div>
                <div class="flex flex-col gap-4 border border-gray-100 p-8 text-sm text-gray-500 leading-relaxed">
                    <p>{{ $product->description }}</p>
                    <p>Experience the ultimate fragrance journey with Laman Store. Crafted with precision and passion, this scent is designed for those who seek perfection in every detail.</p>
                </div>
            </div>

            <!-- ── RELATED PRODUCTS ────────────────────────────────────────── -->
            @if($relatedProducts->isNotEmpty())
                <div class="mt-32">
                    <div class="text-center mb-16">
                        <div class="inline-flex gap-4 items-center mb-4">
                            <p class="text-gray-400 text-3xl font-light uppercase tracking-widest">
                                YOU MAY <span class="text-gray-800 font-medium">ALSO LIKE</span>
                            </p>
                            <p class="w-12 h-[2px] bg-gray-800 sm:w-20"></p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-x-8 gap-y-16">
                        @foreach($relatedProducts as $rel)
                            <x-product-card :product="$rel" />
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-storefront-layout>
