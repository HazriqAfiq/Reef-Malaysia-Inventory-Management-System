<x-account-layout>
    {{-- ── PAGE HEADER ──────────────────────────────────────────────────── --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-8 mb-16 pb-8 border-b border-gray-100">
        <div>
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.5em] mb-4">Historical Registry</p>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 leading-none tracking-tight">Order History</h2>
        </div>
        <a href="{{ route('storefront.collection') }}"
           class="inline-flex items-center gap-3 text-[10px] font-bold uppercase tracking-[0.3em] text-gray-900 border-b border-gray-900 pb-1 hover:opacity-40 transition-opacity whitespace-nowrap">
            Continue Shopping
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
    </div>

    @if($orders->isEmpty())
        <div class="py-40 text-center bg-gray-50/50 border border-dashed border-gray-200">
            <p class="text-3xl font-bold text-gray-300 mb-8 tracking-tight">Registry is empty</p>
            <a href="{{ route('storefront.collection') }}" class="text-[11px] font-bold uppercase tracking-[0.4em] text-gray-900 border-b border-gray-900 pb-2 hover:opacity-50 transition-opacity">
                Discover the Collection
            </a>
        </div>
    @else
        <div class="space-y-12">
            @foreach($orders as $order)
                <div class="group">
                    {{-- Minimalist Order Header --}}
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-8 pb-6 border-b border-gray-100 items-end">
                        <div class="col-span-1">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.3em] mb-3">Reference</p>
                            <p class="text-[16px] font-bold text-gray-900 tracking-tight">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <div class="col-span-1">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.3em] mb-3">Placed On</p>
                            <p class="text-[14px] text-gray-600 font-bold tracking-tight">{{ $order->created_at->format('d M Y') }}</p>
                        </div>
                        <div class="col-span-1">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.3em] mb-3">Status</p>
                            <span class="text-[11px] font-bold uppercase tracking-[0.2em] {{ $order->status === 'paid' ? 'text-emerald-600' : 'text-amber-600' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <div class="col-span-1 md:text-right">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.3em] mb-3">Total Value</p>
                            <p class="text-2xl font-bold text-gray-900 tracking-tight">RM {{ number_format($order->total_price, 2) }}</p>
                        </div>
                    </div>

                    {{-- Expanded Items --}}
                    <div class="py-8 grid grid-cols-1 lg:grid-cols-3 gap-12">
                        <div class="lg:col-span-2 space-y-8">
                            @foreach($order->items as $item)
                                <div class="flex items-center gap-8 group/item">
                                    <div class="w-20 h-20 flex-shrink-0 bg-gray-50 border border-gray-100 flex items-center justify-center p-3 opacity-80 group-hover/item:opacity-100 transition-opacity">
                                        <img src="{{ $item->product->primaryImage ? asset('storage/' . $item->product->primaryImage->image_path) : 'https://placehold.co/100x100?text=' . urlencode($item->product->name) }}"
                                             class="w-full h-full object-contain mix-blend-multiply"
                                             alt="{{ $item->product->name }}">
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-lg font-bold text-gray-900 mb-1 tracking-tight">{{ $item->product->name }}</p>
                                        <p class="text-[11px] text-gray-400 font-bold uppercase tracking-widest">
                                            Quantity: {{ $item->quantity }} <span class="mx-3 text-gray-200">|</span> RM {{ number_format($item->price, 2) }}
                                        </p>
                                    </div>
                                    <div class="text-right flex-shrink-0">
                                        <p class="text-[14px] font-bold text-gray-900 tracking-tight">RM {{ number_format($item->quantity * $item->price, 2) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Order Metadata (Shipping) --}}
                        @if($order->shippingAddress)
                            <div class="bg-gray-50/50 p-8 border border-gray-100 h-fit">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.4em] mb-6">Dispatch Details</p>
                                <div class="space-y-1">
                                    <p class="text-[13px] font-bold text-gray-800 uppercase tracking-wide mb-2">{{ $order->shippingAddress->full_name }}</p>
                                    <p class="text-[13px] text-gray-500 font-medium">{{ $order->shippingAddress->address }}</p>
                                    <p class="text-[13px] text-gray-500 font-medium">{{ $order->shippingAddress->city }}, {{ $order->shippingAddress->postal_code }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        @if($orders->hasPages())
            <div class="mt-20 pt-10 border-t border-gray-100 flex justify-center">
                {{ $orders->links() }}
            </div>
        @endif
    @endif
</x-account-layout>
