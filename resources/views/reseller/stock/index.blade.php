<x-app-layout title="My Personal Stock">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-900 tracking-tight">My Personal Stock</h1>
            <p class="text-sm font-medium text-gray-500 mt-1">Manage your local inventory acquired from HQ</p>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('reseller.orders.create') }}"
               class="inline-flex items-center gap-1.5 px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700
                      text-white text-[13px] font-bold rounded-xl shadow-md shadow-blue-500/30 transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/40 hover:-translate-y-0.5">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Restock Inventory
            </a>
        </div>
    </div>

    {{-- STOCK CARDS GRID --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        @forelse($stocks as $stock)
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-lg shadow-gray-200/50 p-6 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
                <div class="absolute bottom-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-50 to-transparent rounded-tl-[80px] -mr-8 -mb-8 transition-transform duration-500 group-hover:scale-110"></div>
                
                <div class="relative z-10">
                    <div class="flex items-start justify-between mb-4">
                        <span class="w-12 h-12 rounded-xl {{ $stock->quantity <= 5 ? 'bg-amber-50 text-amber-600 shadow-[0_2px_10px_rgba(245,158,11,0.15)] border-amber-100/50' : 'bg-blue-50 text-blue-600 shadow-[0_2px_10px_rgba(59,130,246,0.15)] border-blue-100/50' }} border flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />
                            </svg>
                        </span>
                        @if($stock->quantity <= 5)
                            <span class="inline-flex items-center gap-1.5 text-[11px] font-black px-2.5 py-1 rounded-full text-amber-600 bg-amber-50 border border-amber-200/50 uppercase tracking-widest animate-pulse">
                                Low Stock
                            </span>
                        @endif
                    </div>
                    <p class="text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-1">{{ $stock->product->sku }} &middot; {{ $stock->product->volume_ml }}ml</p>
                    <p class="text-[15px] font-black text-gray-900 truncate mb-5">{{ $stock->product->name }}</p>
                    
                    <div class="flex items-end justify-between border-t border-gray-50 pt-4">
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Available Qty</p>
                        <p class="text-3xl font-black tracking-tight {{ $stock->quantity <= 5 ? 'text-amber-600' : 'text-gray-900' }}">{{ $stock->quantity }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-3xl border border-gray-100 shadow-md shadow-gray-200/40 p-16 text-center">
                <div class="mx-auto w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-5 border border-gray-100 shadow-sm">
                    <svg class="w-10 h-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />
                    </svg>
                </div>
                <p class="text-[17px] font-bold text-gray-900 mb-1">Your warehouse is empty</p>
                <p class="text-[13px] font-medium text-gray-500 mt-1">Order stock from HQ to start generating sales.</p>
                <div class="mt-6">
                    <a href="{{ route('reseller.orders.create') }}" class="px-5 py-2.5 bg-blue-50 text-blue-600 text-[13px] font-bold rounded-xl hover:bg-blue-600 hover:text-white transition-all duration-300">Restock Now &rarr;</a>
                </div>
            </div>
        @endforelse
    </div>
    
    @if($stocks->hasPages())
        <div class="mb-6">
            {{ $stocks->links() }}
        </div>
    @endif

</x-app-layout>
