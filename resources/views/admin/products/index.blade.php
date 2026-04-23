<x-app-layout title="Product Inventory">

    {{-- ── Success / Error Toast ─────────────────────────────────────────── --}}
    @if(session('success'))
        <div class="mb-5 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-medium px-4 py-3 rounded-xl shadow-sm">
            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- ═══════════════════════════════════════════════════════════════
         HEADER — Title + Action Buttons
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-900 tracking-tight">Product Inventory</h1>
            <p class="text-sm font-medium text-gray-500 mt-1">Manage your full product catalog and stock levels</p>
        </div>
        <div class="flex items-center gap-3 shrink-0">
            <a href="{{ route('admin.products.create') }}"
               class="inline-flex items-center gap-1.5 px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700
                      text-white text-[13px] font-bold rounded-xl shadow-md shadow-blue-500/30 transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/40 hover:-translate-y-0.5">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Add Product
            </a>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════
         STOCK KPI SUMMARY
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        {{-- Total SKUs --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-lg shadow-gray-200/50 p-5 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div class="absolute bottom-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-50 to-transparent rounded-tl-[80px] -mr-8 -mb-8 transition-transform duration-500 group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex items-start justify-between mb-4">
                    <span class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100/50 flex items-center justify-center text-blue-600 shadow-[0_2px_10px_rgba(59,130,246,0.15)]">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                    </span>
                </div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Total SKUs</p>
                <p class="text-2xl font-black text-gray-900 tracking-tight">{{ $totalProducts }}</p>
            </div>
        </div>

        {{-- Total Stock --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-lg shadow-gray-200/50 p-5 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div class="absolute bottom-0 right-0 w-32 h-32 bg-gradient-to-br from-emerald-50 to-transparent rounded-tl-[80px] -mr-8 -mb-8 transition-transform duration-500 group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex items-start justify-between mb-4">
                    <span class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100/50 flex items-center justify-center text-emerald-600 shadow-[0_2px_10px_rgba(16,185,129,0.15)]">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                        </svg>
                    </span>
                </div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Ecosystem Stock</p>
                <div class="flex items-end justify-between">
                    <div>
                        <p class="text-2xl font-black text-gray-900 tracking-tight">{{ number_format($totalStock) }}</p>
                        <p class="text-[10px] font-bold text-gray-500 mt-1">
                            {{ number_format($adminStock) }} Admin &middot; {{ number_format($resellerStock) }} Reseller
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Low Stock --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-lg shadow-gray-200/50 p-5 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div class="absolute bottom-0 right-0 w-32 h-32 bg-gradient-to-br from-amber-50 to-transparent rounded-tl-[80px] -mr-8 -mb-8 transition-transform duration-500 group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex items-start justify-between mb-4">
                    <span class="w-10 h-10 rounded-xl bg-amber-50 border border-amber-100/50 flex items-center justify-center text-amber-600 shadow-[0_2px_10px_rgba(245,158,11,0.15)]">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </span>
                    @if($lowStockCount > 0)
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2.5 py-1 rounded-full text-amber-700 bg-amber-100 animate-pulse">
                            Action Needed
                        </span>
                    @endif
                </div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Low Stock Warning</p>
                <p class="text-2xl font-black {{ $lowStockCount > 0 ? 'text-amber-600' : 'text-gray-900' }} tracking-tight">{{ $lowStockCount }}</p>
            </div>
        </div>

        {{-- Out of Stock --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-lg shadow-gray-200/50 p-5 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div class="absolute bottom-0 right-0 w-32 h-32 bg-gradient-to-br from-red-50 to-transparent rounded-tl-[80px] -mr-8 -mb-8 transition-transform duration-500 group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex items-start justify-between mb-4">
                    <span class="w-10 h-10 rounded-xl bg-red-50 border border-red-100/50 flex items-center justify-center text-red-600 shadow-[0_2px_10px_rgba(239,68,68,0.15)]">
                         <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                        </svg>
                    </span>
                </div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Out of Stock</p>
                <p class="text-2xl font-black {{ $outOfStock > 0 ? 'text-red-600' : 'text-gray-900' }} tracking-tight">{{ $outOfStock }}</p>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════
         SEARCH & FILTERS
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-5 mb-6">
        <form id="filter-form" method="GET" action="{{ route('admin.products.index') }}" class="flex flex-col lg:flex-row gap-4">
            
            {{-- Search --}}
            <div class="relative flex-1 flex gap-2">
                {{-- Input wrapper --}}
                <div class="relative flex-1">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text"
                           id="search-input"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Search by product name or SKU…"
                           autocomplete="off"
                           class="w-full pl-10 pr-9 py-2.5 text-sm font-medium text-gray-800 bg-gray-50/50 border border-gray-200 rounded-xl
                                  focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300">
                    {{-- Clear button (shown only when there's a value) --}}
                    <button type="button" id="search-clear"
                            onclick="clearSearch()"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700 transition-colors {{ request('search') ? '' : 'hidden' }}">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                {{-- Explicit Search button --}}
                <button type="submit"
                        class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-blue-600 hover:bg-blue-700
                               text-white text-[13px] font-bold rounded-xl transition-colors duration-200 shrink-0
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Search
                </button>
            </div>

            {{-- Stock Level Filter --}}
            <select name="stock"
                    class="pl-4 pr-10 py-2.5 text-sm font-medium text-gray-700 bg-gray-50/50 border border-gray-200 rounded-xl
                           focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300
                           cursor-pointer appearance-none bg-no-repeat bg-[position:right_1rem_center] bg-[length:1em_1em]"
                    style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22currentColor%22%3E%3Cpath%20fill-rule%3D%22evenodd%22%20d%3D%22M5.293%207.293a1%201%200%20011.414%200L10%2010.586l3.293-3.293a1%201%200%20111.414%201.414l-4%204a1%201%200%2001-1.414%200l-4-4a1%201%200%20010-1.414z%22%20clip-rule%3D%22evenodd%22%2F%3E%3C%2Fsvg%3E');">
                <option value="">All Stock Levels</option>
                <option value="high"   {{ request('stock') === 'high'   ? 'selected' : '' }}>High (> 100)</option>
                <option value="medium" {{ request('stock') === 'medium' ? 'selected' : '' }}>Medium (50–100)</option>
                <option value="low"    {{ request('stock') === 'low'    ? 'selected' : '' }}>Low (1–49)</option>
                <option value="out"    {{ request('stock') === 'out'    ? 'selected' : '' }}>Out of Stock</option>
            </select>

            {{-- Volume Filter --}}
            <select name="volume"
                    class="pl-4 pr-10 py-2.5 text-sm font-medium text-gray-700 bg-gray-50/50 border border-gray-200 rounded-xl
                           focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300
                           cursor-pointer appearance-none bg-no-repeat bg-[position:right_1rem_center] bg-[length:1em_1em]"
                    style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22currentColor%22%3E%3Cpath%20fill-rule%3D%22evenodd%22%20d%3D%22M5.293%207.293a1%201%200%20011.414%200L10%2010.586l3.293-3.293a1%201%200%20111.414%201.414l-4%204a1%201%200%2001-1.414%200l-4-4a1%201%200%20010-1.414z%22%20clip-rule%3D%22evenodd%22%2F%3E%3C%2Fsvg%3E');">
                <option value="">All Volumes</option>
                @foreach($volumes as $vol)
                    <option value="{{ $vol }}" {{ request('volume') == $vol ? 'selected' : '' }}>{{ $vol }}ml</option>
                @endforeach
            </select>

            {{-- Sort --}}
            <select name="sort"
                    class="pl-4 pr-10 py-2.5 text-sm font-medium text-gray-700 bg-gray-50/50 border border-gray-200 rounded-xl
                           focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300
                           cursor-pointer appearance-none bg-no-repeat bg-[position:right_1rem_center] bg-[length:1em_1em]"
                    style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22currentColor%22%3E%3Cpath%20fill-rule%3D%22evenodd%22%20d%3D%22M5.293%207.293a1%201%200%20011.414%200L10%2010.586l3.293-3.293a1%201%200%20111.414%201.414l-4%204a1%201%200%2001-1.414%200l-4-4a1%201%200%20010-1.414z%22%20clip-rule%3D%22evenodd%22%2F%3E%3C%2Fsvg%3E');">
                <option value="name"   {{ request('sort', 'name') === 'name'   ? 'selected' : '' }}>Name A–Z</option>
                <option value="retail_price"  {{ request('sort') === 'retail_price'  ? 'selected' : '' }}>Retail Price ↓</option>
                <option value="wholesale_price" {{ request('sort') === 'wholesale_price' ? 'selected' : '' }}>Wholesale Price ↓</option>
                <option value="stock"  {{ request('sort') === 'stock'  ? 'selected' : '' }}>Stock ↑</option>
                <option value="volume" {{ request('sort') === 'volume' ? 'selected' : '' }}>Volume</option>
            </select>

            @if(request()->hasAny(['search', 'stock', 'volume', 'sort']))
                <a href="{{ route('admin.products.index') }}"
                   class="px-4 py-2.5 text-[13px] font-bold text-gray-500 hover:text-gray-700 bg-white border border-gray-200
                          rounded-xl hover:bg-gray-50 hover:shadow-sm transition-all duration-300 shrink-0 text-center flex items-center justify-center">
                    Clear Filters
                </a>
            @endif
        </form>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════
         INVENTORY TABLE
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-md shadow-gray-200/40 overflow-hidden mb-12">
        <div class="px-7 py-5 border-b border-gray-50/80 flex items-center justify-between">
            <div>
                <h2 class="text-[15px] font-bold text-gray-900 tracking-tight">Product Catalog</h2>
                <p class="text-xs font-medium text-gray-500 mt-1">
                    Showing {{ $products->count() }} out of {{ $totalProducts }} total products.
                </p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100/80">
                        <th class="text-left px-7 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Product</th>
                        <th class="text-center px-7 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Volume</th>
                        <th class="text-left px-7 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest hidden lg:table-cell">Fragrance Notes</th>
                        <th class="text-right px-7 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Pricing</th>
                        <th class="text-left px-7 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest min-w-[200px]">Inventory Breakdown</th>
                        <th class="text-center px-7 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest hidden md:table-cell">Total Sales</th>
                        <th class="px-7 py-4"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50/80">
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50/60 transition-colors duration-100">
                            
                            {{-- Product Name + SKU --}}
                            <td class="px-7 py-4.5 whitespace-nowrap">
                                <p class="text-[13px] font-medium text-gray-900">{{ $product->name }}</p>
                                <p class="text-[11px] font-medium text-gray-400 mt-0.5 tracking-wider uppercase">
                                    {{ $product->sku }}@if($product->category) &middot; <span class="text-gray-500">{{ ucfirst($product->category->name) }}</span>@endif
                                </p>
                                @if($product->isPromotionActive())
                                    <div class="mt-1.5">
                                        <span class="inline-flex items-center gap-1 text-[9px] font-bold px-2 py-0.5 rounded text-amber-700 bg-amber-50 border border-amber-100">
                                            <svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                            {{ $product->promotion_badge ?? 'PROMO' }}
                                        </span>
                                    </div>
                                @endif
                            </td>

                            {{-- Volume --}}
                            <td class="px-7 py-4.5 text-center">
                                <span class="inline-block text-[11px] font-medium bg-gray-100 border border-gray-200/80 text-gray-500 px-2.5 py-0.5 rounded-md shadow-sm">
                                    {{ $product->volume_ml }}ml
                                </span>
                            </td>

                            {{-- Fragrance Notes --}}
                            <td class="px-7 py-4.5 hidden lg:table-cell min-w-[200px]">
                                <div class="flex flex-wrap gap-1.5 align-middle">
                                    @if($product->top_note)
                                        <span class="text-[10px] font-bold bg-blue-50 border border-blue-100/50 text-blue-600 px-2 py-0.5 rounded-md shadow-sm" title="Top Note">T: {{ $product->top_note }}</span>
                                    @endif
                                    @if($product->heart_note)
                                        <span class="text-[10px] font-bold bg-rose-50 border border-rose-100/50 text-rose-600 px-2 py-0.5 rounded-md shadow-sm" title="Heart Note">H: {{ $product->heart_note }}</span>
                                    @endif
                                    @if($product->base_note)
                                        <span class="text-[10px] font-bold bg-amber-50 border border-amber-100/50 text-amber-600 px-2 py-0.5 rounded-md shadow-sm" title="Base Note">B: {{ $product->base_note }}</span>
                                    @endif
                                </div>
                            </td>

                            {{-- Prices --}}
                            <td class="px-7 py-4.5 text-right whitespace-nowrap">
                                <p class="text-[14px] font-black text-gray-900">
                                    <span class="text-[9px] font-bold text-gray-400 mr-1 uppercase">Retail:</span>RM{{ number_format($product->retail_price, 2) }}
                                </p>
                                <p class="text-[10px] font-bold text-gray-400 mt-0.5 tracking-tight">WS: RM{{ number_format($product->wholesale_price, 2) }}</p>
                            </td>

                            {{-- Stock Level Progress Bar --}}
                            <td class="px-7 py-4.5">
                                @php
                                    $combinedStock = $product->stock + ($product->reseller_stocks_sum_quantity ?? 0);
                                    $percent = min(max(($combinedStock / 150) * 100, 5), 100); 
                                    if($combinedStock == 0) $percent = 0;
                                    $barColor = $combinedStock === 0 ? 'bg-red-500' 
                                            : (($combinedStock < 50) ? 'bg-amber-500' 
                                            : 'bg-emerald-500');
                                @endphp
                                <div class="flex items-center justify-between mb-1.5">
                                    <div class="flex flex-col">
                                        <span class="text-[11px] font-black text-gray-900">{{ number_format($combinedStock) }} <span class="text-gray-400 text-[10px] font-bold">TOTAL</span></span>
                                        <span class="text-[9px] font-bold text-gray-500 uppercase tracking-tight">
                                            {{ $product->stock }} Admin &middot; {{ $product->reseller_stocks_sum_quantity ?? 0 }} Reseller
                                        </span>
                                    </div>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden shadow-inner">
                                    <div class="h-1.5 rounded-full {{ $barColor }} transition-all duration-1000 ease-in-out" style="width: {{ $percent }}%"></div>
                                </div>
                            </td>

                            {{-- Total Sales --}}
                            <td class="px-7 py-4.5 text-center hidden md:table-cell">
                                <span class="inline-flex items-center justify-center min-w-[2.5rem] px-1.5 h-6 rounded-lg bg-white border border-gray-200 text-gray-800 shadow-sm text-[11px] font-black">
                                    {{ number_format($product->sales_sum_quantity ?? 0) }}
                                </span>
                            </td>

                            {{-- Actions --}}
                            <td class="px-7 py-4.5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.products.edit', $product) }}"
                                       class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white hover:shadow-md transition-all duration-200" title="Edit">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <button type="button"
                                            onclick="confirmDelete('{{ route('admin.products.destroy', $product) }}', '{{ addslashes($product->name) }}')"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white hover:shadow-md transition-all duration-200" title="Delete">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-16 text-center">
                                <div class="mx-auto w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 border border-gray-100">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                    </svg>
                                </div>
                                <p class="text-[15px] font-bold text-gray-900 mb-1">No products match your search</p>
                                <p class="text-[12px] text-gray-500 mb-5">Try adjusting your filters or search terms.</p>
                                <a href="{{ route('admin.products.index') }}" class="text-[12px] font-bold text-blue-600 bg-blue-50 px-4 py-2 rounded-xl hover:bg-blue-100 transition-colors inline-flex cursor-pointer">Clear all filters</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if(method_exists($products, 'hasPages') && $products->hasPages())
            <div class="px-7 py-5 border-t border-gray-50">
                {{ $products->links() }}
            </div>
        @endif
    </div>

    {{-- ═══════════════════════════════════════════════════════════════
         DELETE CONFIRM MODAL
    ═══════════════════════════════════════════════════════════════ --}}
    <div id="delete-modal"
         class="fixed inset-0 z-[100] hidden items-center justify-center p-4 transition-all duration-300 opacity-0"
         style="background:rgba(17,24,39,0.6); backdrop-filter:blur(4px);">
        <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 w-full max-w-md p-7 transform scale-95 transition-transform duration-300" id="delete-modal-content">
            <div class="flex flex-col items-center text-center mb-6">
                <div class="w-16 h-16 rounded-full bg-red-50 flex items-center justify-center shrink-0 mb-4 border border-red-100 shadow-sm">
                    <svg class="w-8 h-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-black text-gray-900 tracking-tight">Delete Product?</h3>
                <p class="text-[13px] text-gray-500 mt-2 leading-relaxed">
                    You are about to delete <span id="delete-name" class="font-bold text-gray-900"></span>.
                    All associated sales records will be removed. This action cannot be undone.
                </p>
            </div>
            <div class="mb-7 bg-gray-50 p-4 rounded-2xl border border-gray-100">
                <label for="delete-confirm-input" class="block text-[11px] font-bold text-gray-500 mb-2 uppercase tracking-wide text-center">
                    Type <span id="delete-name-hint" class="font-black text-gray-900 bg-white px-2 py-0.5 rounded shadow-sm border border-gray-200 select-all tracking-normal"></span> below
                </label>
                <input autocomplete="off" type="text" id="delete-confirm-input" class="w-full text-center px-4 py-3 text-[14px] font-bold text-gray-900 bg-white border border-gray-200 rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 placeholder:text-gray-300 placeholder:font-normal placeholder:text-[13px]">
            </div>
            <div class="flex gap-3">
                <button onclick="closeDeleteModal()"
                        class="flex-1 px-5 py-3 text-[13px] font-bold text-gray-600 bg-gray-100 hover:bg-gray-200
                               rounded-xl transition-all duration-300 hover:shadow-sm">
                    Cancel
                </button>
                <form id="delete-form" method="POST" class="flex-1">
                    @csrf @method('DELETE')
                    <button type="submit" id="delete-confirm-btn" disabled
                            class="w-full px-5 py-3 text-[13px] font-bold text-white bg-red-600 hover:bg-red-700
                                   rounded-xl transition-all duration-300 opacity-50 cursor-not-allowed shadow-md shadow-red-500/20">
                        Yes, Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════
         JAVASCRIPT
    ═══════════════════════════════════════════════════════════════ --}}
    <script>
        // ── Search: submit on Enter key or button click (no debounce) ─────────
        const filterForm = document.getElementById('filter-form');
        const searchInput = document.getElementById('search-input');
        const searchClear = document.getElementById('search-clear');

        // Show/hide clear (×) button as user types
        searchInput.addEventListener('input', function() {
            searchClear.classList.toggle('hidden', this.value === '');
        });

        // Clear search and re-submit
        function clearSearch() {
            searchInput.value = '';
            searchClear.classList.add('hidden');
            filterForm.submit();
        }

        // Dropdowns still auto-submit (single-action, no ambiguity)
        document.querySelectorAll('select[name="stock"], select[name="volume"], select[name="sort"]')
            .forEach(el => el.addEventListener('change', () => filterForm.submit()));

        // ── Delete modal ──────────────────────────────────────────────────
        let expectedDeleteName = '';

        function confirmDelete(url, name) {
            expectedDeleteName = name;
            document.getElementById('delete-name').textContent = name;
            document.getElementById('delete-name-hint').textContent = name;
            document.getElementById('delete-form').action = url;
            
            const input = document.getElementById('delete-confirm-input');
            const btn = document.getElementById('delete-confirm-btn');
            input.value = '';
            input.placeholder = name;
            btn.disabled = true;
            btn.classList.add('opacity-50', 'cursor-not-allowed');
            
            const modal = document.getElementById('delete-modal');
            const content = document.getElementById('delete-modal-content');
            
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                content.classList.remove('scale-95');
                input.focus();
            }, 10);
        }

        document.getElementById('delete-confirm-input').addEventListener('input', function(e) {
            const btn = document.getElementById('delete-confirm-btn');
            if (e.target.value === expectedDeleteName) {
                btn.disabled = false;
                btn.classList.remove('opacity-50', 'cursor-not-allowed');
                btn.classList.add('hover:-translate-y-0.5', 'hover:shadow-lg');
            } else {
                btn.disabled = true;
                btn.classList.add('opacity-50', 'cursor-not-allowed');
                btn.classList.remove('hover:-translate-y-0.5', 'hover:shadow-lg');
            }
        });

        function closeDeleteModal() {
            const modal = document.getElementById('delete-modal');
            const content = document.getElementById('delete-modal-content');
            
            modal.classList.add('opacity-0');
            content.classList.add('scale-95');
            setTimeout(() => modal.classList.add('hidden'), 300);
        }

        document.getElementById('delete-modal').addEventListener('click', function(e) {
            if (e.target === this) closeDeleteModal();
        });

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeDeleteModal();
        });
    </script>
</x-app-layout>
