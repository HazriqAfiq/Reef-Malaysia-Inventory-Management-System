<x-app-layout title="Reseller Dashboard">

    {{-- ═══════════════════════════════════════════════════════════════
         HEADER
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="mb-6 flex justify-between items-end">
        <div>
            <h1 class="text-xl font-bold text-gray-900 tracking-tight">My Dashboard</h1>
            <p class="text-sm text-gray-500 mt-1">Track your performance and maximize your earnings</p>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════
         PERFORMANCE INSIGHTS
    ═══════════════════════════════════════════════════════════════ --}}
    @if(count($insights) > 0)
    <div class="mb-8 bg-violet-50 border border-violet-100 rounded-2xl px-5 py-3.5 flex flex-wrap items-center gap-x-6 gap-y-2 mt-2">
        @foreach($insights as $insight)
            <div class="flex items-center gap-2 text-[13px] font-semibold text-violet-700">
                <span class="w-1.5 h-1.5 rounded-full bg-violet-400 shadow-[0_0_6px_rgba(167,139,250,0.7)] animate-pulse shrink-0"></span>
                {{ $insight }}
            </div>
        @endforeach
    </div>
    @endif

    {{-- ═══════════════════════════════════════════════════════════════
         KPI CARDS
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        {{-- Total Revenue --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-lg shadow-gray-200/50 p-5 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div class="absolute bottom-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-50 to-transparent rounded-tl-[80px] -mr-8 -mb-8 transition-transform duration-500 group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex items-start justify-between mb-4">
                    <span class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100/50 flex items-center justify-center text-blue-600 shadow-[0_2px_10px_rgba(59,130,246,0.15)]">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </span>
                    @if($revenueChange !== null)
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2.5 py-1 rounded-full {{ $revenueChange >= 0 ? 'text-emerald-700 bg-emerald-50 border border-emerald-100/60' : 'text-red-700 bg-red-50 border border-red-100/60' }}">
                            {{ $revenueChange >= 0 ? '▲' : '▼' }} {{ abs($revenueChange) }}%
                        </span>
                    @endif
                </div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Total Revenue</p>
                <div class="flex items-end justify-between">
                    <p class="text-2xl font-black text-gray-900 tracking-tight">RM{{ number_format($myTotalRevenue, 0) }}</p>
                    <div class="w-16 h-8"><canvas id="sparklineRev"></canvas></div>
                </div>
            </div>
        </div>

        {{-- Units Sold --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-lg shadow-gray-200/50 p-5 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div class="absolute bottom-0 right-0 w-32 h-32 bg-gradient-to-br from-violet-50 to-transparent rounded-tl-[80px] -mr-8 -mb-8 transition-transform duration-500 group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex items-start justify-between mb-4">
                    <span class="w-10 h-10 rounded-xl bg-violet-50 border border-violet-100/50 flex items-center justify-center text-violet-600 shadow-[0_2px_10px_rgba(139,92,246,0.15)]">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </span>
                    <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2.5 py-1 rounded-full text-violet-700 bg-violet-50 border border-violet-100/60">
                        {{ number_format($myTotalSales) }} TXs
                    </span>
                </div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Units Sold</p>
                <div class="flex items-end justify-between">
                    <p class="text-2xl font-black text-gray-900 tracking-tight">{{ number_format($myTotalUnits) }}</p>
                    <div class="w-16 h-8"><canvas id="sparklineUnits"></canvas></div>
                </div>
            </div>
        </div>

        {{-- Commission Earned --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-lg shadow-gray-200/50 p-5 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div class="absolute bottom-0 right-0 w-32 h-32 bg-gradient-to-br from-indigo-50 to-transparent rounded-tl-[80px] -mr-8 -mb-8 transition-transform duration-500 group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex items-start justify-between mb-4">
                    <span class="w-10 h-10 rounded-xl bg-indigo-50 border border-indigo-100/50 flex items-center justify-center text-indigo-600 shadow-[0_2px_10px_rgba(79,70,229,0.15)]">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </span>
                    @if($commissionChange !== null)
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2.5 py-1 rounded-full {{ $commissionChange >= 0 ? 'text-emerald-700 bg-emerald-50 border border-emerald-100/60' : 'text-red-700 bg-red-50 border border-red-100/60' }}">
                            {{ $commissionChange >= 0 ? '▲' : '▼' }} {{ abs($commissionChange) }}%
                        </span>
                    @endif
                </div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Earnings (Est.)</p>
                <div class="flex items-end justify-between">
                    <p class="text-2xl font-black text-gray-900 tracking-tight">RM{{ number_format($myCommission, 0) }}</p>
                    <div class="w-16 h-8"><canvas id="sparklineCommission"></canvas></div>
                </div>
            </div>
        </div>

        {{-- Your Stock --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-lg shadow-gray-200/50 p-5 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div class="absolute bottom-0 right-0 w-32 h-32 {{ $lowStockProducts->count() > 0 ? 'bg-gradient-to-br from-red-50 to-transparent' : 'bg-gradient-to-br from-amber-50 to-transparent' }} rounded-tl-[80px] -mr-8 -mb-8 transition-transform duration-500 group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex items-start justify-between mb-4">
                    <span class="w-10 h-10 rounded-xl {{ $lowStockProducts->count() > 0 ? 'bg-red-50 border border-red-100 text-red-600 shadow-[0_2px_10px_rgba(239,68,68,0.15)]' : 'bg-amber-50 border border-amber-100 text-amber-600 shadow-[0_2px_10px_rgba(245,158,11,0.15)]' }} flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                        </svg>
                    </span>
                    @if($lowStockProducts->count() > 0)
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2.5 py-1 rounded-full text-red-700 bg-red-100 shadow-sm animate-pulse">
                            {{ $lowStockProducts->count() }} Low
                        </span>
                    @endif
                </div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Your Stock (Units)</p>
                <div class="flex items-end justify-between">
                    <p class="text-2xl font-black text-gray-900 tracking-tight">{{ number_format(auth()->user()->resellerStocks()->sum('quantity')) }}</p>
                    <div class="w-16 h-8"><canvas id="sparklineSkus"></canvas></div>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════
         MAIN CHART — Personal Sales Trend
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-md shadow-gray-200/40 p-7 mb-8 relative">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-[15px] font-bold text-gray-900 tracking-tight">Your Sales Trend</h2>
                <p class="text-[12px] font-medium text-gray-500 mt-1">Daily personal revenue and units moved across the last 30 days.</p>
            </div>
            <div class="flex items-center gap-5 text-[11px] font-bold text-gray-500 uppercase tracking-wider">
                <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-md bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.6)]"></span>Revenue</span>
                <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-md bg-violet-400 opacity-60"></span>Units</span>
            </div>
        </div>
        <div class="relative h-72">
            <canvas id="trendChart"></canvas>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════
         MIDDLE ROW — Charts (Top Products | Donut | Inventory Radar)
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        {{-- Top Products Bar Chart --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-md shadow-gray-200/40 p-6 flex flex-col">
            <div class="mb-5">
                <h2 class="text-[14px] font-bold text-gray-900 tracking-tight">Top Sellers</h2>
                <p class="text-[11px] font-medium text-gray-500 mt-1 uppercase tracking-widest">Your Highest Volume</p>
            </div>
            @if($myTopProducts->isEmpty())
                <div class="flex-1 flex flex-col items-center justify-center opacity-70">
                    <svg class="w-10 h-10 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                    </svg>
                    <span class="text-xs font-semibold text-gray-500">Not enough data</span>
                </div>
            @else
                <div class="relative flex-1 min-h-[220px]">
                    <canvas id="topProductsChart"></canvas>
                </div>
            @endif
        </div>

        {{-- Sales Distribution Donut Chart --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-md shadow-gray-200/40 p-6 flex flex-col relative group">
            <div class="mb-3 text-center">
                <h2 class="text-[14px] font-bold text-gray-900 tracking-tight">Revenue Breakdown</h2>
                <p class="text-[11px] font-medium text-gray-500 mt-1 uppercase tracking-widest">Sales Distribution</p>
            </div>
            @if($myTopProducts->isEmpty())
                <div class="flex-1 flex flex-col items-center justify-center opacity-70">
                    <svg class="w-10 h-10 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                    </svg>
                    <span class="text-xs font-semibold text-gray-500">Not enough data</span>
                </div>
            @else
                <div class="relative flex-1 min-h-[200px] flex items-center justify-center">
                    <canvas id="distributionDonutChart"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none mt-2 transition-transform duration-300 group-hover:scale-105">
                        <span class="text-[10px] font-bold text-gray-400/80 uppercase tracking-widest mb-0.5">Top 5 Total</span>
                        <span class="text-lg font-black text-gray-900 shadow-sm" id="donutTotalText">RM{{ number_format($topProductRev->sum(), 0) }}</span>
                    </div>
                </div>
            @endif
        </div>

        {{-- Restock Radar (Progress Bars) --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-md shadow-gray-200/40 p-6 flex flex-col">
            <div class="mb-5 flex items-center justify-between">
                <div>
                    <h2 class="text-[14px] font-bold text-gray-900 tracking-tight">Stock Monitoring</h2>
                    <p class="text-[11px] font-medium text-gray-500 mt-1 uppercase tracking-widest">Your Private Inventory</p>
                </div>
                @if($lowStockProducts->count() > 0)
                    <span class="text-[11px] font-bold text-red-700 bg-red-50 border border-red-100 px-2.5 py-1 rounded flex items-center gap-1.5 animate-pulse">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span>{{ $lowStockProducts->count() }} Alert
                    </span>
                @endif
            </div>

            @if($lowStockProducts->isEmpty())
                <div class="flex-1 flex flex-col items-center justify-center">
                    <div class="w-16 h-16 rounded-full bg-emerald-50 border border-emerald-100 flex items-center justify-center mb-4 shadow-[0_2px_15px_rgba(16,185,129,0.15)]">
                        <svg class="w-8 h-8 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-[15px] font-bold text-gray-900">Catalogue is full!</p>
                    <p class="text-xs font-medium text-gray-500 mt-1">Plenty of stock ready to be sold.</p>
                </div>
            @else
                <ul class="flex flex-col gap-4 flex-1 overflow-y-auto" style="max-height: 220px;">
                    @foreach($lowStockProducts->take(4) as $p)
                        @php
                            // For resellers, we use 20 as a reference for 'healthy' personal stock
                            $percent = min(max(($p->quantity / 20) * 100, 5), 100); 
                            if($p->quantity == 0) $percent = 0;
                            
                            $barColor = $p->quantity <= 3 ? 'bg-red-500 shadow-[0_0_8px_rgba(239,68,68,0.5)]' 
                                      : (($p->quantity < 8) ? 'bg-amber-500 shadow-[0_0_8px_rgba(245,158,11,0.5)]' 
                                      : 'bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.5)]');
                        @endphp
                        <li class="group">
                            <div class="flex items-center justify-between mb-1.5">
                                <p class="text-[12px] font-bold text-gray-900 truncate pr-3">{{ $p->product->name }}</p>
                                @if($p->quantity === 0)
                                    <span class="text-[9px] font-black bg-red-50 text-red-700 px-2 py-0.5 rounded-full border border-red-100 tracking-wider uppercase shrink-0">Empty</span>
                                @else
                                    <span class="text-[11px] font-black text-gray-700 shrink-0">{{ $p->quantity }} <span class="text-gray-400 font-bold tracking-wider text-[10px]">units</span></span>
                                @endif
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden shadow-inner">
                                <div class="h-2 rounded-full {{ $barColor }} transition-all duration-1000 ease-in-out" style="width: {{ $percent }}%"></div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════
         RECENT TRANSACTIONS TABLE
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-md shadow-gray-200/40 overflow-hidden mb-12">
        <div class="px-7 py-6 border-b border-gray-50 flex items-center justify-between">
            <div>
                <h2 class="text-[15px] font-bold text-gray-900 tracking-tight">Recent Sales Activity</h2>
                <p class="text-xs font-medium text-gray-500 mt-1">Your latest registered transactions.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('reseller.sales.index') }}"
                   class="text-[11px] font-bold text-blue-600 bg-blue-50 border border-blue-100/50 px-3 py-2 rounded-xl hover:bg-blue-100 hover:shadow-sm transition-all hidden sm:inline-flex">
                    View Ledger
                </a>
                <a href="{{ route('reseller.sales.create') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700
                          text-white text-[12px] font-bold rounded-xl shadow-md shadow-blue-500/30 transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/40 hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Record Sale
                </a>
            </div>
        </div>

        @if($myRecentSales->isEmpty())
            <div class="py-16 text-center">
                <div class="mx-auto w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mb-4 border border-blue-100">
                    <svg class="w-8 h-8 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <p class="text-[15px] font-bold text-gray-900 mb-2">No sales recorded yet</p>
                <p class="text-[12px] text-gray-500 mb-5">Start logging your transactions to populate your dashboard.</p>
                <a href="{{ route('reseller.sales.create') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-[13px] font-bold rounded-xl shadow-md transition-colors">
                    Make Your First Sale
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100/80">
                            <th class="text-left px-7 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Date & Time</th>
                            <th class="text-left px-7 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Product</th>
                            <th class="text-center px-7 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest hidden sm:table-cell">Volume</th>
                            <th class="text-center px-7 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Qty</th>
                            <th class="text-right px-7 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50/80">
                        @foreach($myRecentSales as $sale)
                            <tr class="hover:bg-gray-50/60 transition-colors duration-100">
                                <td class="px-7 py-4.5 whitespace-nowrap">
                                    <p class="text-[13px] font-bold text-gray-900">{{ $sale->created_at->format('d M Y') }}</p>
                                    <p class="text-[11px] font-semibold text-gray-400 mt-0.5 uppercase tracking-wider">{{ $sale->created_at->format('h:i A') }}</p>
                                </td>
                                <td class="px-7 py-4.5">
                                    <p class="text-[13px] font-bold text-gray-900">{{ $sale->product->name }}</p>
                                </td>
                                <td class="px-7 py-4.5 text-center hidden sm:table-cell">
                                    <span class="inline-block text-[11px] font-bold bg-gray-100 border border-gray-200/80 text-gray-600 px-2.5 py-0.5 rounded-md shadow-sm">
                                        {{ $sale->product->volume_ml }}ml
                                    </span>
                                </td>
                                <td class="px-7 py-4.5 text-center">
                                    <span class="inline-flex items-center justify-center min-w-[2rem] px-1.5 h-6 rounded-lg bg-white border border-gray-200 text-gray-800 shadow-sm text-xs font-black">
                                        {{ $sale->quantity }}
                                    </span>
                                </td>
                                <td class="px-7 py-4.5 text-right">
                                    <span class="text-[14px] font-black text-gray-900">RM{{ number_format($sale->total_price, 2) }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- ═══════════════════════════════════════════════════════════════
         CHART.JS SCRIPTS
    ═══════════════════════════════════════════════════════════════ --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
    <script>
        Chart.defaults.font.family = "'Inter', 'Poppins', ui-sans-serif, sans-serif";
        Chart.defaults.font.size   = 11;
        Chart.defaults.color       = '#9ca3af';
        
        const gridColor = 'rgba(0,0,0,0.03)';
        const tooltipConfig = {
            backgroundColor: 'rgba(255,255,255,0.98)',
            borderColor: 'rgba(0,0,0,0.05)',
            borderWidth: 1,
            titleColor: '#111827',
            titleFont: { size: 13, weight: '800' },
            bodyColor: '#4b5563',
            bodyFont: { size: 12, weight: '600' },
            padding: 12, boxPadding: 8,
            usePointStyle: true, boxWidth: 8, boxHeight: 8,
            cornerRadius: 12, boxShadow: '0 4px 6px -1px rgba(0,0,0,0.1)'
        };

        const createGradient = (ctx, startColor, endColor, top=400, bottom=0) => {
            const gradient = ctx.createLinearGradient(0, top, 0, bottom);
            gradient.addColorStop(0, startColor);
            gradient.addColorStop(1, endColor);
            return gradient;
        };

        // ── KPI Sparklines ───────────────────────────────────────────────────
        const sparklineOptions = {
            responsive: true, maintainAspectRatio: false,
            plugins: { tooltip: { enabled: false }, legend: { display: false } },
            scales: { x: { display: false }, y: { display: false } },
            elements: { point: { radius: 0 } },
            interaction: { intersect: false, mode: 'index' },
        };

        const drawSparkline = (id, data, color, fill) => {
            if(!document.getElementById(id)) return;
            new Chart(document.getElementById(id).getContext('2d'), {
                type: 'line',
                data: { labels: ['1','2','3','4','5','6','7'], datasets: [{ data: data, borderColor: color, backgroundColor: fill, borderWidth: 2, tension: 0.4, fill: true }] },
                options: sparklineOptions
            });
        };

        const sparkRevs = @json($sparkRevenue);
        const sparkUnits = @json($sparkUnits);
        
        // Mock proxy shapes for Commissions and SKUs
        const sparkComm = sparkRevs.map(v => v * 0.15);
        const sparkSkus = [1, 1, 1, 1.05, 1, 1.1, 1];

        drawSparkline('sparklineRev', sparkRevs, '#3b82f6', 'rgba(59,130,246,0.1)');
        drawSparkline('sparklineUnits', sparkUnits, '#8b5cf6', 'rgba(139,92,246,0.1)');
        drawSparkline('sparklineCommission', sparkComm, '#6366f1', 'rgba(99,102,241,0.1)');
        drawSparkline('sparklineSkus', sparkSkus, '#f59e0b', 'rgba(245,158,11,0.1)');

        // ── Daily Trend Chart (dramatic curves & glow) ───────────────────────
        const trendCanvas = document.getElementById('trendChart');
        if(trendCanvas) {
            const trendCtx = trendCanvas.getContext('2d');
            const revGradient = createGradient(trendCtx, 'rgba(59, 130, 246, 0.25)', 'rgba(59, 130, 246, 0)', 300, 0);
            
            new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: @json($trendLabels),
                    datasets: [
                        {
                            label: 'Revenue (RM)',
                            data: @json($trendRevenue),
                            borderColor: '#3b82f6',
                            backgroundColor: revGradient,
                            fill: true, tension: 0.5,
                            pointRadius: 0, pointHoverRadius: 6,
                            pointBackgroundColor: '#ffffff', pointBorderColor: '#3b82f6',
                            borderWidth: 3, yAxisID: 'yRevenue',
                        },
                        {
                            label: 'Units Sold',
                            data: @json($trendUnits),
                            borderColor: '#a78bfa',
                            backgroundColor: 'transparent',
                            fill: false, tension: 0.5,
                            pointRadius: 0, pointHoverRadius: 6,
                            pointBackgroundColor: '#ffffff', pointBorderColor: '#a78bfa',
                            borderWidth: 2, borderDash: [6, 4], yAxisID: 'yUnits',
                        }
                    ]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            ...tooltipConfig,
                            callbacks: {
                                label: ctx => {
                                    if (ctx.datasetIndex === 0) return ` RM ${Number(ctx.parsed.y).toLocaleString('en-MY', {minimumFractionDigits:2})}`;
                                    return ` ${ctx.parsed.y} Units`;
                                }
                            }
                        }
                    },
                    scales: {
                        yRevenue: { position: 'left', beginAtZero: true, grid: { color: gridColor }, border: { display: false }, ticks: { callback: v => 'RM' + Number(v).toLocaleString(), padding: 10, font: { weight: '600' } } },
                        yUnits: { position: 'right', beginAtZero: true, grid: { display: false }, border: { display: false }, ticks: { stepSize: 5, padding: 10 } },
                        x: { grid: { display: false }, border: { display: false }, ticks: { maxTicksLimit: 8, padding: 10, font: { weight: '600' } } }
                    }
                }
            });
        }

        // ── Top Products Horizontal Bar ────────────────────────────────────
        const topProdCanvas = document.getElementById('topProductsChart');
        if(topProdCanvas) {
            const topProdCtx = topProdCanvas.getContext('2d');
            const prodData = @json($topProductData);
            const maxVal = Math.max(...(prodData.length ? prodData : [0]));
            const bgColors = prodData.map(val => val === maxVal ? 'rgba(79, 70, 229, 0.9)' : 'rgba(147, 197, 253, 0.7)');
            const hoverBgColors = prodData.map(val => val === maxVal ? 'rgba(67, 56, 202, 1)' : 'rgba(96, 165, 250, 0.9)');

            new Chart(topProdCtx, {
                type: 'bar',
                data: {
                    labels: @json($topProductLabels),
                    datasets: [{
                        label: 'Units Sold',
                        data: prodData,
                        backgroundColor: bgColors, hoverBackgroundColor: hoverBgColors,
                        borderRadius: 8, borderSkipped: false, barPercentage: 0.6,
                    }]
                },
                options: {
                    indexAxis: 'y', responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { display: false }, tooltip: tooltipConfig },
                    scales: {
                        x: { beginAtZero: true, grid: { color: gridColor, drawBorder: false }, border: { display: false }, ticks: { stepSize: 10, padding: 10, font: { weight: '600' } } },
                        y: { grid: { display: false, drawBorder: false }, border: { display: false }, ticks: { padding: 10, font: { weight: '700', color: '#4b5563' } } }
                    }
                }
            });
        }

        // ── Sales Distribution Donut Chart ─────────────────────────────────
        const donutCanvas = document.getElementById('distributionDonutChart');
        if(donutCanvas) {
            const donutCtx = donutCanvas.getContext('2d');
            new Chart(donutCtx, {
                type: 'doughnut',
                data: {
                    labels: @json($topProductLabels),
                    datasets: [{
                        data: @json($topProductRev),
                        backgroundColor: ['#4f46e5', '#3b82f6', '#0ea5e9', '#38bdf8', '#818cf8', '#a78bfa', '#c084fc', '#e879f9'],
                        borderWidth: 2, borderColor: '#ffffff', hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false, cutout: '75%',
                    plugins: {
                        legend: { display: false },
                        tooltip: { ...tooltipConfig, callbacks: { label: ctx => ` RM ${Number(ctx.parsed).toLocaleString('en-MY', {minimumFractionDigits:2})}` } }
                    }
                }
            });
        }
    </script>
</x-app-layout>
