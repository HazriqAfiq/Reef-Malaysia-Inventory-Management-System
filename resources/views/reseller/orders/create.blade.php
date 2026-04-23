<x-app-layout title="Order Stock from Admin">

    <div class="max-w-5xl mx-auto pb-32">
        {{-- Header --}}
        <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4 relative z-10">
            <div>
                <h1 class="text-xl font-bold text-gray-900 tracking-tight">Order Wholesale Stock</h1>
                <p class="text-sm font-medium text-gray-500 mt-1">Browse the global catalog and purchase raw stock from HQ immediately.</p>
            </div>
            <a href="{{ route('reseller.orders.index') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white border border-gray-200 text-gray-600 hover:text-blue-600 hover:bg-blue-50 text-[13px] font-bold rounded-xl transition-all duration-300 shadow-sm hover:-translate-y-0.5 hover:shadow-md group">
                Purchase History
                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
        </div>

        <form id="order-form" action="{{ route('reseller.orders.store') }}" method="POST" class="needs-validation">
            @csrf

            @if($errors->any())
                <div class="mb-8 p-5 rounded-xl bg-red-50 border border-red-200/50 shadow-sm flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center shrink-0 border border-red-200/50">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-[14px] font-black text-red-800 tracking-tight">Whoops! Something went wrong.</h3>
                        <ul class="text-[12px] font-bold text-red-600 mt-1 list-disc pl-4 space-y-0.5">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($products as $product)
                    <div class="bg-white rounded-3xl border {{ $product->stock === 0 ? 'border-red-100 opacity-75 grayscale-[0.8]' : 'border-gray-100' }} shadow-md shadow-gray-200/40 hover:shadow-lg transition-all duration-300 overflow-hidden flex flex-col relative group transform {{ $product->stock > 0 ? 'hover:-translate-y-1' : '' }}">
                        
                        {{-- Image/Gradient Placeholder --}}
                        <div class="h-32 bg-gradient-to-br from-blue-50/50 to-white flex items-center justify-center border-b border-gray-50/80 relative overflow-hidden">
                            <div class="absolute inset-0 bg-blue-600/5 mix-blend-multiply opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            
                            @if($product->stock === 0)
                                <div class="absolute top-4 right-4 bg-red-50 text-red-600 border border-red-200/50 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest shadow-sm">
                                    Sold Out
                                </div>
                            @elseif($product->stock < 50)
                                <div class="absolute top-4 right-4 bg-amber-50 text-amber-600 border border-amber-200/50 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest shadow-sm flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse shadow-[0_0_6px_rgba(245,158,11,0.5)]"></span>
                                    Only {{ $product->stock }} Left
                                </div>
                            @else
                                <div class="absolute top-4 right-4 bg-blue-50 text-blue-600 border border-blue-200/50 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest shadow-sm">
                                    {{ $product->stock }} in stock
                                </div>
                            @endif

                            <svg class="w-12 h-12 text-blue-200 drop-shadow-sm group-hover:scale-110 transition-transform duration-500 delay-75" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />
                            </svg>
                        </div>

                        {{-- Details --}}
                        <div class="p-6 flex-1 flex flex-col">
                            <div class="flex justify-between items-start mb-6">
                                <div class="pr-3 min-w-0 flex-1">
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 shadow-sm">{{ $product->volume_ml }}ml &bull; {{ $product->sku }}</p>
                                    <h3 class="text-[15px] font-black text-gray-900 truncate">{{ $product->name }}</h3>
                                </div>
                                <div class="text-right shrink-0">
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Unit Price</p>
                                    <p class="text-[15px] font-black text-blue-600">RM{{ number_format($product->price, 2) }}</p>
                                    <input type="hidden" class="product-price" value="{{ $product->price }}">
                                </div>
                            </div>
                            
                            <div class="mt-auto pt-5 border-t border-gray-100/80 flex items-center justify-between">
                                <span class="text-[11px] font-black text-gray-500 uppercase tracking-widest">Order Qty</span>
                                
                                <div class="flex items-center gap-1.5 bg-gray-50/50 p-1 rounded-xl border border-gray-100 shadow-inner">
                                    <input type="hidden" name="product_id[{{ $loop->index }}]" value="{{ $product->id }}">
                                    
                                    <button type="button" 
                                            class="qty-btn minus w-8 h-8 rounded-lg flex items-center justify-center bg-white border border-gray-200 text-gray-500 hover:bg-gray-50 hover:text-gray-900 transition-colors shadow-sm {{ $product->stock === 0 ? 'opacity-50 cursor-not-allowed' : '' }}" 
                                            {{ $product->stock === 0 ? 'disabled' : '' }}>
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/></svg>
                                    </button>
                                    
                                    <input type="number" 
                                           name="quantity[{{ $loop->index }}]" 
                                           class="qty-input w-12 text-center text-[13px] font-black border-transparent bg-transparent p-0 focus:ring-0 focus:border-transparent text-gray-900" 
                                           value="0" 
                                           min="0" 
                                           max="{{ $product->stock }}"
                                           {{ $product->stock === 0 ? 'disabled' : '' }}>
                                           
                                    <button type="button" 
                                            class="qty-btn plus w-8 h-8 rounded-lg flex items-center justify-center bg-white border border-gray-200 text-gray-500 hover:bg-gray-50 hover:text-gray-900 transition-colors shadow-sm {{ $product->stock === 0 ? 'opacity-50 cursor-not-allowed' : '' }}" 
                                            {{ $product->stock === 0 ? 'disabled' : '' }}>
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Sticky Checkout Footer --}}
            <div class="fixed bottom-0 left-0 right-0 bg-white/90 backdrop-blur-xl border-t border-gray-200/50 shadow-[0_-10px_40px_-5px_rgba(0,0,0,0.1)] px-8 py-5 transform translate-y-0 transition-transform duration-300 z-50">
                <div class="max-w-5xl mx-auto flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="flex items-center gap-8">
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Cart Summary</p>
                            <p class="text-[14px] font-bold text-gray-900"><span id="total-items" class="font-black text-blue-600">0</span> units selected</p>
                        </div>
                        <div class="h-10 w-px bg-gray-200"></div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Total Payable</p>
                            <p id="total-price" class="text-2xl font-black text-gray-900 tracking-tight">RM0.00</p>
                        </div>
                    </div>
                    
                    <button type="submit" id="checkout-btn" disabled class="group relative px-10 py-4 bg-gray-200 text-gray-400 font-bold text-[14px] rounded-2xl transition-all duration-300 overflow-hidden shadow-sm">
                        <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-blue-600 to-indigo-600 opacity-0 group-[.active]:opacity-100 transition-opacity duration-300"></div>
                        <div class="absolute inset-0 w-full h-full opacity-0 group-[.active]:opacity-100 bg-white/10 group-[.active]:hover:bg-transparent transition-all"></div>
                        <span class="relative flex items-center gap-2 group-[.active]:text-white z-10 font-black">
                            Proceed to Checkout
                            <svg class="w-4 h-4 transform group-[.active]:group-hover:translate-x-1.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </span>
                    </button>
                </div>
            </div>
            
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const inputs = document.querySelectorAll('.qty-input');
            const totalItemsEl = document.getElementById('total-items');
            const totalPriceEl = document.getElementById('total-price');
            const checkoutBtn = document.getElementById('checkout-btn');

            function updateCart() {
                let items = 0;
                let price = 0;

                inputs.forEach(input => {
                    const qty = parseInt(input.value) || 0;
                    if (qty > 0) {
                        const row = input.closest('.flex-col');
                        const unitPrice = parseFloat(row.querySelector('.product-price').value) || 0;
                        items += qty;
                        price += (qty * unitPrice);
                    }
                });

                totalItemsEl.textContent = items;
                totalPriceEl.textContent = 'RM' + price.toLocaleString('en-MY', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                
                if (items > 0) {
                    checkoutBtn.classList.add('active');
                    checkoutBtn.classList.replace('bg-gray-200', 'bg-blue-600');
                    checkoutBtn.classList.replace('text-gray-400', 'text-white');
                    checkoutBtn.classList.add('shadow-lg', 'shadow-blue-500/30', 'hover:-translate-y-0.5');
                    checkoutBtn.disabled = false;
                } else {
                    checkoutBtn.classList.remove('active');
                    checkoutBtn.classList.replace('bg-blue-600', 'bg-gray-200');
                    checkoutBtn.classList.replace('text-white', 'text-gray-400');
                    checkoutBtn.classList.remove('shadow-lg', 'shadow-blue-500/30', 'hover:-translate-y-0.5');
                    checkoutBtn.disabled = true;
                }
            }

            document.querySelectorAll('.qty-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const isPlus = btn.classList.contains('plus');
                    const input = btn.parentElement.querySelector('.qty-input');
                    const max = parseInt(input.max) || 0;
                    let val = parseInt(input.value) || 0;

                    if (isPlus && val < max) {
                        input.value = val + 1;
                    } else if (!isPlus && val > 0) {
                        input.value = val - 1;
                    }
                    updateCart();
                });
            });

            inputs.forEach(input => {
                input.addEventListener('change', () => {
                    const max = parseInt(input.max) || 0;
                    let val = parseInt(input.value) || 0;
                    if (val < 0) input.value = 0;
                    if (val > max) input.value = max;
                    updateCart();
                });
            });
        });
    </script>
</x-app-layout>
