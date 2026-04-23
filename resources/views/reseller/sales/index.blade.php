<x-app-layout title="My Sales">

    {{-- ── Success notice ──────────────────────────────────────────────────── --}}
    @if(session('success'))
        <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-[13px] font-bold px-4 py-3 rounded-xl shadow-sm">
            <svg class="w-5 h-5 shrink-0 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- ═══════════════════════════════════════════════════════════════
         HEADER
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-900 tracking-tight">Sales History</h1>
            <p class="text-sm font-medium text-gray-500 mt-1">Your registered transactions for the selected period</p>
        </div>
        <a href="{{ route('reseller.sales.create') }}"
           class="inline-flex items-center gap-1.5 px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700
                  text-white text-[13px] font-bold rounded-xl shadow-md shadow-blue-500/30 transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/40 hover:-translate-y-0.5 shrink-0">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Record Sale
        </a>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════
         MONTH FILTER
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-4 mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        
        <form method="GET" action="{{ route('reseller.sales.index') }}" id="filter-form" class="flex flex-col sm:flex-row sm:items-center gap-3 w-full">
            <div class="flex items-center gap-2 text-[11px] font-bold text-gray-400 uppercase tracking-widest shrink-0 px-2">
                <svg class="w-4 h-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                Timeframe
            </div>
            
            <div class="flex-1 flex flex-col sm:flex-row items-center gap-3">
                <select id="year" name="year" onchange="document.getElementById('filter-form').submit()"
                        class="w-full sm:w-auto px-4 py-2.5 text-sm font-bold text-gray-800 bg-gray-50/50 border border-gray-200 rounded-xl
                               focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500
                               cursor-pointer appearance-none transition-all duration-300 pr-10"
                        style="background-image:url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 20 20%22 fill=%22%239ca3af%22><path fill-rule=%22evenodd%22 d=%22M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z%22 clip-rule=%22evenodd%22/></svg>');
                               background-repeat:no-repeat;background-position:right 1rem center;background-size:1rem;">
                    @foreach($availableYears as $year)
                        <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>

                <select id="month" name="month" onchange="document.getElementById('filter-form').submit()"
                        class="w-full sm:w-auto px-4 py-2.5 text-sm font-bold text-gray-800 bg-gray-50/50 border border-gray-200 rounded-xl
                               focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500
                               cursor-pointer appearance-none transition-all duration-300 pr-10"
                        style="background-image:url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 20 20%22 fill=%22%239ca3af%22><path fill-rule=%22evenodd%22 d=%22M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z%22 clip-rule=%22evenodd%22/></svg>');
                               background-repeat:no-repeat;background-position:right 1rem center;background-size:1rem;">
                    <option value="">All Months</option>
                    @foreach($availableMonths as $m)
                        <option value="{{ $m }}" {{ $selectedMonth == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>

        <div class="px-2 shrink-0">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gray-100/80 text-[11px] font-black text-gray-500 rounded-lg tracking-wider uppercase border border-gray-200/50">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 shadow-[0_0_6px_rgba(59,130,246,0.5)]"></span>
                {{ $periodLabel }}
            </span>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════
         KPI TOP ROW & CHART
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
        
        {{-- KPIs Column --}}
        <div class="col-span-1 flex flex-col gap-5">
            {{-- Revenue --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-lg shadow-gray-200/50 p-5 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300 flex-1">
                <div class="absolute bottom-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-50 to-transparent rounded-tl-[80px] -mr-8 -mb-8 transition-transform duration-500 group-hover:scale-110"></div>
                <div class="flex items-start justify-between mb-4 relative z-10">
                    <span class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100/50 flex items-center justify-center text-blue-600 shadow-[0_2px_10px_rgba(59,130,246,0.15)]">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </span>
                </div>
                <div class="relative z-10">
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">My Revenue</p>
                    <p class="text-2xl font-black text-gray-900 tracking-tight">RM{{ number_format($monthRevenue, 0) }}</p>
                </div>
            </div>

            {{-- Units Sold --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-lg shadow-gray-200/50 p-5 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300 flex-1">
                <div class="absolute bottom-0 right-0 w-32 h-32 bg-gradient-to-br from-violet-50 to-transparent rounded-tl-[80px] -mr-8 -mb-8 transition-transform duration-500 group-hover:scale-110"></div>
                <div class="flex items-start justify-between mb-4 relative z-10">
                    <span class="w-10 h-10 rounded-xl bg-violet-50 border border-violet-100/50 flex items-center justify-center text-violet-600 shadow-[0_2px_10px_rgba(139,92,246,0.15)]">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </span>
                </div>
                <div class="relative z-10">
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Units Sold</p>
                    <p class="text-2xl font-black text-gray-900 tracking-tight">{{ number_format($monthUnitsSold) }}</p>
                </div>
            </div>

            {{-- Transactions --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-lg shadow-gray-200/50 p-5 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300 flex-1">
                <div class="absolute bottom-0 right-0 w-32 h-32 bg-gradient-to-br from-amber-50 to-transparent rounded-tl-[80px] -mr-8 -mb-8 transition-transform duration-500 group-hover:scale-110"></div>
                <div class="flex items-start justify-between mb-4 relative z-10">
                    <span class="w-10 h-10 rounded-xl bg-amber-50 border border-amber-100/50 flex items-center justify-center text-amber-600 shadow-[0_2px_10px_rgba(245,158,11,0.15)]">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </span>
                </div>
                <div class="relative z-10">
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Total Transactions</p>
                    <p class="text-2xl font-black text-gray-900 tracking-tight">{{ number_format($monthTransactions) }}</p>
                </div>
            </div>
        </div>

        {{-- Main Trend Chart --}}
        <div class="col-span-1 lg:col-span-3 bg-white rounded-3xl border border-gray-100 shadow-md shadow-gray-200/40 p-7 relative">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-[15px] font-bold text-gray-900 tracking-tight">Performance Trend</h2>
                    <p class="text-[12px] font-medium text-gray-500 mt-1">Your revenue & volume for {{ $periodLabel }}</p>
                </div>
                <div class="flex items-center gap-5 text-[11px] font-bold text-gray-500 uppercase tracking-wider">
                    <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-md bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.6)]"></span>Revenue</span>
                    <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-md bg-violet-400 opacity-60"></span>Units</span>
                </div>
            </div>
            <div class="relative h-[360px] w-full">
                <canvas id="trendChart"></canvas>
            </div>
        </div>

    </div>

    {{-- ═══════════════════════════════════════════════════════════════
         SALES TABLE
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-md shadow-gray-200/40 overflow-hidden mb-12">
        <div class="px-7 py-5 border-b border-gray-50/80 flex items-center justify-between">
            <div>
                <h2 class="text-[15px] font-bold text-gray-900 tracking-tight">Sales Ledger</h2>
                <p class="text-xs font-medium text-gray-500 mt-1">
                    {{ $monthTransactions }} processing {{ Str::plural('record', $monthTransactions) }}
                </p>
            </div>
            @if($monthTransactions > 0)
                <span class="inline-block text-[11px] font-black bg-gray-100/80 border border-gray-200/50 text-gray-500 px-3 py-1 rounded-full uppercase tracking-widest shadow-sm">
                    Showing {{ $sales->firstItem() ?? 0 }}-{{ $sales->lastItem() ?? 0 }}
                </span>
            @endif
        </div>

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
                    @forelse($sales as $sale)
                        <tr class="hover:bg-gray-50/60 transition-colors duration-100">
                            <td class="px-7 py-4.5 whitespace-nowrap">
                                <p class="text-[13px] font-medium text-gray-900">{{ $sale->created_at->format('d M Y') }}</p>
                                <p class="text-[11px] font-medium text-gray-400 mt-0.5 uppercase tracking-wider">{{ $sale->created_at->format('h:i A') }}</p>
                            </td>
                            <td class="px-7 py-4.5">
                                <p class="text-[13px] font-medium text-gray-900">{{ $sale->product->name }}</p>
                            </td>
                            <td class="px-7 py-4.5 text-center hidden sm:table-cell">
                                <span class="inline-block text-[11px] font-medium bg-gray-100 border border-gray-200/80 text-gray-500 px-2.5 py-0.5 rounded-md shadow-sm">
                                    {{ $sale->product->volume_ml }}ml
                                </span>
                            </td>
                            <td class="px-7 py-4.5 text-center">
                                <span class="inline-flex items-center justify-center min-w-[2rem] px-1.5 h-6 rounded-lg bg-white border border-gray-200 text-gray-600 shadow-sm text-[12px] font-medium">
                                    {{ $sale->quantity }}
                                </span>
                            </td>
                            <td class="px-7 py-4.5 text-right">
                                <span class="text-[14px] font-black text-gray-900">
                                    RM{{ number_format($sale->total_price, 2) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-7 py-16 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 bg-gray-50 border border-gray-100 rounded-full flex items-center justify-center mb-1">
                                        <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                        </svg>
                                    </div>
                                    <p class="text-[15px] font-bold text-gray-900">No sales recorded yet</p>
                                    <p class="text-[12px] text-gray-500">Record a new sale or adjust your timeframe filter.</p>
                                    <a href="{{ route('reseller.sales.create') }}" class="text-[12px] font-bold text-blue-600 bg-blue-50 px-4 py-2 rounded-xl hover:bg-blue-100 transition-colors inline-flex cursor-pointer mt-2">Record Sale</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

                {{-- Page total footer --}}
                @if($sales->count() > 0)
                    <tfoot>
                        <tr class="border-t border-gray-100 bg-gray-50/80">
                            <td colspan="3" class="px-7 py-5 text-[11px] font-bold text-gray-500 uppercase tracking-widest text-right">
                                Page Total
                            </td>
                            <td class="px-7 py-5 text-center text-[14px] font-black text-gray-700">
                                {{ number_format($sales->sum('quantity')) }}
                            </td>
                            <td class="px-7 py-5 text-right text-[15px] font-black text-gray-900">
                                RM{{ number_format($sales->sum('total_price'), 2) }}
                            </td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>

        {{-- Pagination --}}
        @if(method_exists($sales, 'hasPages') && $sales->hasPages())
            <div class="px-7 py-5 border-t border-gray-50">
                {{ $sales->links() }}
            </div>
        @endif
    </div>

    {{-- ═══════════════════════════════════════════════════════════════
         CHART JS
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

        const canvas = document.getElementById('trendChart');
        if(canvas) {
            const trendCtx = canvas.getContext('2d');
            const revGradient = createGradient(trendCtx, 'rgba(59, 130, 246, 0.25)', 'rgba(59, 130, 246, 0)');
            
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
                        yRevenue: { 
                            position: 'left', beginAtZero: true, 
                            grid: { color: gridColor }, border: { display: false }, 
                            ticks: { callback: v => 'RM' + Number(v).toLocaleString(), padding: 10, font: { weight: '600' } } 
                        },
                        yUnits: { 
                            position: 'right', beginAtZero: true, 
                            grid: { display: false }, border: { display: false }, 
                            ticks: { stepSize: Math.max(1, Math.ceil(Math.max(...@json($trendUnits))/5)), padding: 10 } 
                        },
                        x: { 
                            grid: { display: false }, border: { display: false }, 
                            ticks: { maxTicksLimit: 12, padding: 10, font: { weight: '600' } } 
                        }
                    }
                }
            });
        }
    </script>

</x-app-layout>
