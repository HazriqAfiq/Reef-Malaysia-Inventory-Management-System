<x-storefront-layout>
    <x-slot name="title">Your Shopping Cart</x-slot>

    <div class="bg-white py-12 lg:py-24">
        <div class="w-full px-4 sm:px-8 lg:px-12 xl:px-16">
            <div class="text-center mb-16">
                <div class="inline-flex gap-8 items-center mb-4">
                    <p class="w-8 md:w-16 h-[1px] bg-gray-200"></p>
                    <h1 class="text-gray-400 text-2xl md:text-3xl font-light uppercase tracking-[0.4em] leading-none whitespace-nowrap">
                        SHOPPING <span class="text-gray-800 font-medium">CART</span>
                    </h1>
                    <p class="w-8 md:w-16 h-[1px] bg-gray-200"></p>
                </div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">{{ count($cartData) }} Items ready for checkout</p>
            </div>

            @if(empty($cartData))
                <div class="py-32 text-center bg-[#FAFAFA] border border-gray-100">
                    <div class="w-20 h-20 bg-white border border-gray-100 flex items-center justify-center mx-auto mb-8 shadow-sm">
                        <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    </div>
                    <h2 class="text-3xl font-serif italic text-gray-900 mb-4 font-medium">Your cart is empty</h2>
                    <p class="text-[11px] text-gray-400 font-bold uppercase tracking-widest mb-10">Discover your next signature scent in our shop.</p>
                    <a href="{{ route('storefront.collection') }}" class="inline-block px-12 py-5 bg-black text-white text-[11px] font-bold uppercase tracking-[0.2em] hover:bg-gray-800 transition-all">Start Exploring</a>
                </div>
            @else
                <div class="flex flex-col lg:flex-row gap-16">
                    
                    <!-- ── ITEMS LIST ─────────────────────────────────────────── -->
                    <div class="flex-1">
                        <div class="border-t border-gray-100">
                            @foreach($cartData as $item)
                                <div class="py-10 border-b border-gray-100 flex gap-8 items-start relative group">
                                    <div class="w-32 h-40 bg-[#FAFAFA] border border-gray-100 overflow-hidden flex-shrink-0 p-1 group-hover:bg-[#F5F5F5] transition-colors">
                                        <img src="{{ $item['product']->primaryImage ? asset('storage/' . $item['product']->primaryImage->image_path) : 'https://placehold.co/400x500?text=' . urlencode($item['product']->name) }}" 
                                             class="w-full h-full object-contain mix-blend-multiply" alt="{{ $item['product']->name }}">
                                    </div>

                                    <div class="flex-1 pt-2">
                                        <div class="flex justify-between mb-2">
                                            <div class="flex flex-col">
                                                <span class="text-[9px] font-bold uppercase tracking-widest text-gray-400">{{ $item['product']->category }}</span>
                                                @if($item['product']->isPromotionActive() && $item['product']->promotion_badge)
                                                    <span class="text-[9px] font-bold text-emerald-600 uppercase tracking-widest mt-1">{{ $item['product']->promotion_badge }}</span>
                                                @endif
                                            </div>
                                            <div class="text-right">
                                                @if($item['discount'] > 0)
                                                    <p class="text-[11px] font-medium tracking-widest text-gray-400 line-through decoration-1 mb-0.5">RM {{ number_format($item['original_subtotal'], 2) }}</p>
                                                    <p class="text-[14px] font-bold tracking-widest text-red-700">RM {{ number_format($item['subtotal'], 2) }}</p>
                                                @else
                                                    <p class="text-[14px] font-medium tracking-widest">RM {{ number_format($item['subtotal'], 2) }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <h3 class="text-[16px] font-medium text-gray-900 mb-1 uppercase tracking-[0.1em]">{{ $item['product']->name }}</h3>
                                        <p class="text-[10px] text-gray-400 font-medium capitalize mb-6 flex items-center justify-between">
                                            <span>{{ $item['product']->volume_ml }}ml</span>
                                            @if($item['free_items'] > 0)
                                                <span class="text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-0.5 border border-amber-100/50">+{{ $item['free_items'] }} Free Item(s) Applied</span>
                                            @endif
                                        </p>

                                        <div class="flex items-center gap-6 mt-4">
                                            <!-- Quantity Update -->
                                            <form action="{{ route('cart.update') }}" method="POST" x-data="{ qty: {{ $item['quantity'] }} }" class="flex items-center gap-4 bg-[#FAFAFA] border border-gray-100 px-4 py-2">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
                                                <button type="submit" name="quantity" :value="qty - 1" class="text-gray-400 hover:text-black transition-colors">
                                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/></svg>
                                                </button>
                                                <span class="text-[12px] font-medium w-6 text-center text-gray-900" x-text="qty"></span>
                                                <button type="submit" name="quantity" :value="qty + 1" class="text-gray-400 hover:text-black transition-colors">
                                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                                </button>
                                            </form>

                                            <!-- Remove -->
                                            <form action="{{ route('cart.remove', $item['product']->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-[10px] font-bold uppercase tracking-widest text-gray-300 hover:text-red-600 transition-colors">Remove</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- ── SUMMARY ────────────────────────────────────────────── -->
                    <div class="w-full lg:w-[400px]">
                        <div class="bg-[#FAFAFA] border border-gray-100 p-10 sticky top-32">
                            <h2 class="text-[11px] font-bold uppercase tracking-[0.4em] mb-10 text-gray-400">Order Summary</h2>
                            
                            <div class="space-y-6 mb-10 pb-10 border-b border-gray-200">
                                <div class="flex justify-between items-center">
                                    <span class="text-[11px] font-bold text-gray-500 uppercase tracking-widest">Subtotal</span>
                                    <span class="text-[13px] font-medium tracking-widest">RM {{ number_format($originalTotal, 2) }}</span>
                                </div>
                                @if($totalDiscount > 0)
                                <div class="flex justify-between items-center">
                                    <span class="text-[11px] font-bold text-red-600 uppercase tracking-widest flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                                        Promotional Savings
                                    </span>
                                    <span class="text-[13px] font-bold tracking-widest text-red-600">-RM {{ number_format($totalDiscount, 2) }}</span>
                                </div>
                                @endif
                                <div class="flex justify-between items-center">
                                    <span class="text-[11px] font-bold text-gray-500 uppercase tracking-widest">Shipping</span>
                                    <span class="text-[11px] font-medium tracking-widest text-gray-900 uppercase">Complimentary</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-[11px] font-bold text-gray-500 uppercase tracking-widest">Tax</span>
                                    <span class="text-[10px] font-medium tracking-widest text-gray-400 uppercase">Calculated at checkout</span>
                                </div>
                            </div>

                            <div class="flex justify-between items-end mb-12">
                                <span class="text-[14px] font-serif font-medium italic text-gray-900">Total Est.</span>
                                <span class="text-2xl font-medium tracking-widest text-gray-900">RM {{ number_format($total, 2) }}</span>
                            </div>

                            <a href="{{ route('checkout.index') }}" class="block w-full py-6 bg-black text-white text-center text-[11px] font-bold uppercase tracking-[0.3em] hover:bg-gray-800 transition-all shadow-sm mb-6">
                                Checkout Securely
                            </a>
                            
                            <div class="flex items-center justify-center gap-4 py-4 grayscale opacity-40">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" class="h-3" alt="Visa">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" class="h-4" alt="Mastercard">
                                <div class="w-[1px] h-3 bg-gray-300"></div>
                                <span class="text-[8px] font-bold tracking-[0.2em] uppercase">Secure SSL Payment</span>
                            </div>
                        </div>
                    </div>

                </div>
            @endif
        </div>
    </div>
</x-storefront-layout>
