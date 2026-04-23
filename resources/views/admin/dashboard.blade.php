<x-app-layout title="Admin Dashboard">

    {{-- ═══════════════════════════════════════════════════════════════
         HEADER
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="mb-6 flex justify-between items-end">
        <div>
            <h1 class="text-xl font-bold text-gray-900 tracking-tight">Admin Dashboard</h1>
            <p class="text-sm text-gray-500 mt-1">Real-time performance and inventory metrics</p>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════
         SMART INSIGHTS
    ═══════════════════════════════════════════════════════════════ --}}
    @if(count($insights) > 0)
    <div class="mb-8 bg-blue-50 border border-blue-100 rounded-2xl px-5 py-3.5 flex flex-wrap items-center gap-x-6 gap-y-2 mt-2">
        @foreach($insights as $insight)
            <div class="flex items-center gap-2 text-[13px] font-semibold text-blue-700">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-400 shadow-[0_0_6px_rgba(96,165,250,0.7)] animate-pulse shrink-0"></span>
                {{ $insight }}
            </div>
        @endforeach
    </div>
    @endif

    {{-- ═══════════════════════════════════════════════════════════════
         GROUP 1: GLOBAL COMMAND CENTER
    ═══════════════════════════════════════════════════════════════ --}}
    <h2 class="text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-4">Global Command Center</h2>
    <div class="grid grid-cols-1 xl:grid-cols-4 gap-5 mb-10">
        
        {{-- Total Net Income --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 relative overflow-hidden group">
            <div class="absolute bottom-0 right-0 w-32 h-32 bg-gradient-to-br from-emerald-50 to-transparent rounded-tl-[80px] -mr-8 -mb-8"></div>
            <div class="relative z-10 h-full flex flex-col justify-between">
                <div>
                    <div class="flex items-start justify-between mb-2">
                        <span class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100/50 flex items-center justify-center text-emerald-600">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </span>
                        @if($incomeChange !== null)
                            <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2.5 py-1 rounded-full {{ $incomeChange >= 0 ? 'text-emerald-700 bg-emerald-50' : 'text-red-700 bg-red-50' }}">
                                {{ $incomeChange >= 0 ? '▲' : '▼' }} {{ abs($incomeChange) }}%
                            </span>
                        @endif
                    </div>
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1 mt-6">Total Net Income</p>
                    <p class="text-3xl font-black text-gray-900 tracking-tight">RM{{ number_format($totalNetIncome, 0) }}</p>
                </div>
                <div class="w-full h-12 mt-4"><canvas id="sparklineIncome"></canvas></div>
            </div>
        </div>

        {{-- Main Channel Trend --}}
        <div class="xl:col-span-2 bg-white rounded-3xl border border-gray-100 shadow-sm p-6 relative">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-[13px] font-bold text-gray-900 tracking-tight">Global Channel Trajectory</h3>
                </div>
                <div class="flex items-center gap-4 text-[10px] font-bold text-gray-500 uppercase tracking-wider">
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-sm bg-blue-500"></span>D2C Direct</span>
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-sm bg-indigo-500"></span>B2B Partner</span>
                    <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-sm bg-violet-400 opacity-60"></span>Network</span>
                </div>
            </div>
            <div class="relative h-40">
                <canvas id="trendChart"></canvas>
            </div>
        </div>

        {{-- Inventory Health --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 relative overflow-hidden group">
            <div class="absolute bottom-0 right-0 w-32 h-32 {{ $lowStockCount > 0 ? 'bg-gradient-to-br from-red-50 to-transparent' : 'bg-gradient-to-br from-blue-50 to-transparent' }} rounded-tl-[80px] -mr-8 -mb-8"></div>
            <div class="relative z-10 h-full flex flex-col justify-between">
                <div>
                    <span class="w-10 h-10 rounded-xl {{ $lowStockCount > 0 ? 'bg-red-50 text-red-600' : 'bg-blue-50 text-blue-600' }} flex items-center justify-center mb-6">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                        </svg>
                    </span>
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Global Stock</p>
                    <p class="text-3xl font-black text-gray-900 tracking-tight">{{ number_format($totalProductsInStock) }}</p>
                    <p class="text-[10px] font-bold text-gray-500 mt-1 uppercase tracking-wider">
                        {{ number_format($adminStock) }} HQ • {{ number_format($resellerStock) }} Ptnr
                    </p>
                </div>
                <div class="w-full h-10 mt-4"><canvas id="sparklineStock"></canvas></div>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-10 mb-10">
        
        {{-- ═══════════════════════════════════════════════════════════════
             GROUP 2: STOREFRONT BUSINESS FLOW (B2C)
        ═══════════════════════════════════════════════════════════════ --}}
        <div>
            <div class="mb-5 flex items-center gap-3 border-b border-gray-100 pb-3">
                <div class="w-8 h-8 rounded-lg bg-blue-500 text-white flex items-center justify-center shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <div>
                    <h2 class="text-[16px] font-black text-gray-900 tracking-tight">Direct Storefront</h2>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Public Website B2C Flow</p>
                </div>
            </div>

            {{-- Storefront KPI & Monthly Chart --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                <div class="bg-blue-50/30 rounded-3xl border border-blue-100/50 p-6 flex flex-col justify-center">
                    <p class="text-[11px] font-bold text-blue-400 uppercase tracking-wider mb-2">Direct Revenue</p>
                    <p class="text-3xl font-black text-gray-900 tracking-tight">RM{{ number_format($storefrontRevenue, 0) }}</p>
                    <div class="w-24 h-10 mt-4 opacity-70"><canvas id="sparklineRev"></canvas></div>
                </div>
                
                <div class="bg-white rounded-3xl border border-gray-100 p-5 flex flex-col">
                    <h3 class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-4">6-Month Ret.</h3>
                    <div class="relative flex-1 min-h-[100px]"><canvas id="monthlyRevenueChart"></canvas></div>
                </div>
            </div>

            {{-- Storefront Ledger --}}
            <div class="bg-white rounded-3xl border border-gray-100 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
                    <span class="text-[11px] font-bold text-gray-600 uppercase tracking-widest">Latest Direct Orders</span>
                </div>
                <ul class="divide-y divide-gray-50">
                    @forelse($recentStorefrontSales as $sale)
                        <li class="px-5 py-3 hover:bg-gray-50/50 flex justify-between items-center">
                            <div>
                                <p class="text-[12px] font-bold text-gray-900">{{ $sale->product->name }} <span class="text-[10px] text-gray-400 ml-1">x{{ $sale->quantity }}</span></p>
                                <p class="text-[10px] font-medium text-gray-400 mt-0.5">{{ $sale->created_at->diffForHumans() }} • Guest/Buyer</p>
                            </div>
                            <span class="text-[12px] font-black text-gray-900">RM{{ number_format($sale->total_price, 2) }}</span>
                        </li>
                    @empty
                        <li class="px-5 py-8 text-center text-[11px] font-bold text-gray-400 uppercase tracking-widest">No direct orders yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════════════════════
             GROUP 3: RESELLER BUSINESS FLOW (B2B2C)
        ═══════════════════════════════════════════════════════════════ --}}
        <div>
            <div class="mb-5 flex items-center gap-3 border-b border-gray-100 pb-3">
                <div class="w-8 h-8 rounded-lg bg-indigo-500 text-white flex items-center justify-center shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <div>
                    <h2 class="text-[16px] font-black text-gray-900 tracking-tight">Partner Network</h2>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Wholesale & Market Velocity</p>
                </div>
            </div>

            {{-- Reseller KPIs --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                <div class="bg-indigo-50/30 rounded-3xl border border-indigo-100/50 p-6 flex flex-col justify-center relative overflow-hidden">
                    <p class="text-[11px] font-bold text-indigo-400 uppercase tracking-wider mb-2">Wholesale B2B</p>
                    <p class="text-3xl font-black text-gray-900 tracking-tight">RM{{ number_format($wholesaleRevenue, 0) }}</p>
                </div>
                
                <div class="bg-violet-50/30 rounded-3xl border border-violet-100/50 p-6 flex flex-col justify-center relative">
                    <p class="text-[11px] font-bold text-violet-400 uppercase tracking-wider mb-2">Network Retail Vol.</p>
                    <div class="flex items-end justify-between">
                        <p class="text-3xl font-black text-gray-900 tracking-tight">RM{{ number_format($networkVolume, 0) }}</p>
                        <div class="w-12 h-6 opacity-70"><canvas id="sparklineUnits"></canvas></div>
                    </div>
                </div>
            </div>

            {{-- Reseller Split: Leaderboard & Recent --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                {{-- Leaderboard --}}
                <div class="bg-white rounded-3xl border border-gray-100 overflow-hidden flex flex-col">
                    <div class="px-5 py-4 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
                        <span class="text-[11px] font-bold text-gray-600 uppercase tracking-widest">Top Partners</span>
                    </div>
                    <ul class="divide-y divide-gray-50 flex-1">
                        @foreach($topResellers->take(4) as $reseller)
                            <li class="px-5 py-3 hover:bg-gray-50/50 flex justify-between items-center">
                                <div class="flex items-center gap-3">
                                    <div class="w-7 h-7 rounded-md bg-indigo-50 flex items-center justify-center text-[10px] font-bold text-indigo-700">{{ strtoupper(substr($reseller->name, 0, 2)) }}</div>
                                    <div>
                                        <p class="text-[12px] font-bold text-gray-900">{{ $reseller->name }}</p>
                                        <p class="text-[9px] font-medium text-gray-400 uppercase tracking-wider">{{ number_format($reseller->sales_sum_quantity ?? 0) }} Units</p>
                                    </div>
                                </div>
                                <span class="text-[11px] font-black text-gray-900">RM{{ number_format($reseller->sales_sum_total_price ?? 0, 0) }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Recent Reseller Sales --}}
                <div class="bg-white rounded-3xl border border-gray-100 overflow-hidden flex flex-col">
                    <div class="px-5 py-4 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
                        <span class="text-[11px] font-bold text-gray-600 uppercase tracking-widest">Recent Movement</span>
                    </div>
                    <ul class="divide-y divide-gray-50 flex-1">
                        @forelse($recentResellerSales->take(4) as $sale)
                            <li class="px-5 py-3 hover:bg-gray-50/50 flex justify-between items-center">
                                <div>
                                    <p class="text-[12px] font-bold text-gray-900">{{ $sale->product->name }} <span class="text-[10px] text-gray-400 ml-1">x{{ $sale->quantity }}</span></p>
                                    <p class="text-[10px] font-medium text-gray-400 mt-0.5">{{ $sale->user->name }} • {{ $sale->created_at->diffForHumans() }}</p>
                                </div>
                                <span class="text-[12px] font-black text-violet-700">RM{{ number_format($sale->total_price, 2) }}</span>
                            </li>
                        @empty
                            <li class="px-5 py-8 text-center text-[11px] font-bold text-gray-400 uppercase tracking-widest">No network sales yet.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
            
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════
         GROUP 4: PRODUCT HEALTH
    ═══════════════════════════════════════════════════════════════ --}}
    <h2 class="text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-4">Product Health & Distribution</h2>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        
        {{-- Distribution Donut --}}
        <div class="bg-white rounded-3xl border border-gray-100 p-6 flex flex-col shadow-sm">
            <div class="mb-3 text-center">
                <h3 class="text-[13px] font-bold text-gray-900 tracking-tight">Revenue Matrix</h3>
            </div>
            <div class="relative flex-1 min-h-[200px]">
                <canvas id="distributionDonutChart" class="absolute inset-0 w-full h-full"></canvas>
            </div>
        </div>

        {{-- Top Products Bar --}}
        <div class="bg-white rounded-3xl border border-gray-100 p-6 flex flex-col shadow-sm">
            <div class="mb-5">
                <h3 class="text-[13px] font-bold text-gray-900 tracking-tight">Volume Matrix</h3>
            </div>
            <div class="relative flex-1 min-h-[200px]">
                <canvas id="topProductsChart"></canvas>
            </div>
        </div>

        {{-- Restock Radar --}}
        <div class="bg-white rounded-3xl border border-gray-100 overflow-hidden flex flex-col shadow-sm">
            <div class="px-6 py-5 flex items-center justify-between border-b border-gray-50">
                <h3 class="text-[13px] font-bold text-gray-900">Restock Radar</h3>
                @if($lowStockProducts->count() > 0)
                    <span class="text-[10px] font-bold text-red-700 bg-red-50 px-2 py-1 rounded shadow-sm animate-pulse">
                        {{ $lowStockProducts->count() }} Alert
                    </span>
                @endif
            </div>
            @if($lowStockProducts->isEmpty())
                <div class="p-8 text-center flex-1 flex flex-col justify-center items-center">
                    <span class="text-[11px] font-bold text-emerald-600 bg-emerald-50 px-3 py-1 rounded">Fully Stocked</span>
                </div>
            @else
                <ul class="divide-y divide-gray-50 flex-1 overflow-y-auto max-h-[220px]">
                    @foreach($lowStockProducts as $p)
                        @php
                            $percent = min(max(($p->stock / 50) * 100, 5), 100); 
                            if($p->stock == 0) $percent = 0;
                            $barColor = $p->stock == 0 ? 'bg-red-500' : (($p->stock < 20) ? 'bg-amber-500' : 'bg-emerald-500');
                        @endphp
                        <li class="px-6 py-4 hover:bg-gray-50 transition-colors">
                            <div class="flex justify-between mb-2">
                                <p class="text-[12px] font-bold text-gray-900 truncate pr-3">{{ $p->name }}</p>
                                <span class="text-[11px] font-black {{ $p->stock == 0 ? 'text-red-600' : 'text-gray-700' }}">{{ $p->stock }} <span class="text-[9px] font-bold text-gray-400">LEFT</span></span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1">
                                <div class="h-1 rounded-full {{ $barColor }}" style="width: {{ $percent }}%"></div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
    {{-- ═══════════════════════════════════════════════════════════════
         CHART.JS SCRIPTS
    ═══════════════════════════════════════════════════════════════ --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
    <script>
        // ── Global defaults ──────────────────────────────────────────────────
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
            padding: 12,
            boxPadding: 8,
            usePointStyle: true,
            boxWidth: 8,
            boxHeight: 8,
            caretSize: 6,
            cornerRadius: 12,
            titleSpacing: 8,
            bodySpacing: 8,
            boxShadow: '0 4px 6px -1px rgba(0,0,0,0.1)'
        };

        const createGradient = (ctx, startColor, endColor, top=400, bottom=0) => {
            const gradient = ctx.createLinearGradient(0, top, 0, bottom);
            gradient.addColorStop(0, startColor);
            gradient.addColorStop(1, endColor);
            return gradient;
        };

        // ── 0. KPI Sparklines ────────────────────────────────────────────────
        const sparklineOptions = {
            responsive: true, maintainAspectRatio: false,
            plugins: { tooltip: { enabled: false }, legend: { display: false } },
            scales: { x: { display: false }, y: { display: false } },
            elements: { point: { radius: 0 } },
            interaction: { intersect: false, mode: 'index' },
        };

        const sparkIncome = @json($trendStorefront->slice(-7)->values());
        const sparkRevs   = @json($sparkRevenue);
        const sparkUnits  = @json($trendNetwork->slice(-7)->values());
        const sparkSkus   = @json($sparkSkus);
        const sparkStock  = @json($sparkStock);

        const drawSparkline = (id, data, color, fill) => {
            const ctx = document.getElementById(id);
            if (!ctx) return;
            new Chart(ctx.getContext('2d'), {
                type: 'line',
                data: { labels: ['1','2','3','4','5','6','7'], datasets: [{ data: data, borderColor: color, backgroundColor: fill, borderWidth: 2, tension: 0.4, fill: true }] },
                options: sparklineOptions
            });
        };

        drawSparkline('sparklineIncome', sparkIncome, '#10b981', 'rgba(16,185,129,0.1)');
        drawSparkline('sparklineRev', sparkRevs, '#3b82f6', 'rgba(59,130,246,0.1)');
        drawSparkline('sparklineUnits', sparkUnits, '#8b5cf6', 'rgba(139,92,246,0.1)');
        
        const lowStockStatus = {{ $lowStockCount > 0 ? 'true' : 'false' }};
        const stockColor = lowStockStatus ? '#ef4444' : '#10b981';
        const stockFill = lowStockStatus ? 'rgba(239,68,68,0.1)' : 'rgba(16,185,129,0.1)';
        drawSparkline('sparklineStock', sparkStock, stockColor, stockFill);


        // ── 1. Daily Trend Chart (dramatic curves & glow) ────────────────────
        const trendCtx = document.getElementById('trendChart').getContext('2d');
        const revGradient = createGradient(trendCtx, 'rgba(59, 130, 246, 0.25)', 'rgba(59, 130, 246, 0)', 300, 0);
        
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: @json($trendLabels),
                datasets: [
                    {
                        label: 'Storefront RM',
                        data: @json($trendStorefront),
                        borderColor: '#3b82f6',
                        backgroundColor: revGradient,
                        fill: true,
                        tension: 0.5,
                        pointRadius: 0,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#3b82f6',
                        pointBorderWidth: 2,
                        borderWidth: 3,
                        yAxisID: 'yRevenue',
                    },
                    {
                        label: 'Wholesale RM',
                        data: @json($trendWholesale),
                        borderColor: '#6366f1',
                        backgroundColor: 'transparent',
                        fill: false,
                        tension: 0.5,
                        pointRadius: 0,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#6366f1',
                        pointBorderWidth: 2,
                        borderWidth: 2.5,
                        yAxisID: 'yRevenue',
                    },
                    {
                        label: 'Network Retail RM',
                        data: @json($trendNetwork),
                        borderColor: '#a78bfa',
                        backgroundColor: 'transparent',
                        fill: false,
                        tension: 0.5,
                        pointRadius: 0,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#a78bfa',
                        borderWidth: 2,
                        borderDash: [6, 4],
                        yAxisID: 'yRevenue',
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
                                if (ctx.dataset.yAxisID === 'yRevenue') {
                                    return ` ${ctx.dataset.label}: RM ${Number(ctx.parsed.y).toLocaleString('en-MY', {minimumFractionDigits:2})}`;
                                }
                                return ` ${ctx.dataset.label}: ${ctx.parsed.y} Units`;
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
                        ticks: { stepSize: 5, padding: 10, display: false }
                    },
                    x: { grid: { display: false }, border: { display: false }, ticks: { maxTicksLimit: 8, padding: 10, font: { weight: '600' } } }
                }
            }
        });

        // ── 2. Top Products Horizontal Bar ───────────────────────────────────
        const topProdCtx = document.getElementById('topProductsChart').getContext('2d');
        const prodData = @json($topProductData);
        // Highlight max data point
        const maxVal = Math.max(...prodData);
        const bgColors = prodData.map(val => val === maxVal ? 'rgba(79, 70, 229, 0.9)' : 'rgba(147, 197, 253, 0.7)');
        const hoverBgColors = prodData.map(val => val === maxVal ? 'rgba(67, 56, 202, 1)' : 'rgba(96, 165, 250, 0.9)');

        new Chart(topProdCtx, {
            type: 'bar',
            data: {
                labels: @json($topProductLabels),
                datasets: [{
                    label: 'Units Sold',
                    data: prodData,
                    backgroundColor: bgColors,
                    hoverBackgroundColor: hoverBgColors,
                    borderRadius: 8,
                    borderSkipped: false,
                    barPercentage: 0.6,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false }, tooltip: tooltipConfig },
                scales: {
                    x: { beginAtZero: true, grid: { color: gridColor, drawBorder: false }, border: { display: false }, ticks: { stepSize: 10, padding: 10, font: { weight: '600' } } },
                    y: { grid: { display: false, drawBorder: false }, border: { display: false }, ticks: { padding: 10, font: { weight: '700', color: '#4b5563' } } }
                }
            }
        });

        // ── 3. Sales Distribution Donut Chart ────────────────────────────────
        const donutCtx = document.getElementById('distributionDonutChart').getContext('2d');
        new Chart(donutCtx, {
            type: 'doughnut',
            data: {
                labels: @json($topProductLabels),
                datasets: [{
                    data: @json($topProductRevenueData),
                    backgroundColor: [
                        '#4f46e5', '#3b82f6', '#0ea5e9', '#38bdf8', '#818cf8', '#a78bfa', '#c084fc', '#e879f9'
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        ...tooltipConfig,
                        callbacks: {
                            label: ctx => ` RM ${Number(ctx.parsed).toLocaleString('en-MY', {minimumFractionDigits:2})}`
                        }
                    }
                }
            }
        });

        // ── 4. Monthly Revenue Line ──────────────────────────────────────────
        const monthlyCtx = document.getElementById('monthlyRevenueChart').getContext('2d');
        const mRevGradient = createGradient(monthlyCtx, 'rgba(79, 70, 229, 0.2)', 'rgba(79, 70, 229, 0)', 300, 0);

        new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: @json($monthlySalesLabels),
                datasets: [{
                    label: 'Revenue (RM)',
                    data: @json($monthlySalesData),
                    borderColor: '#4f46e5',
                    backgroundColor: mRevGradient,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#4f46e5',
                    pointBorderWidth: 2,
                    borderWidth: 3,
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false }, tooltip: tooltipConfig },
                scales: {
                    y: { beginAtZero: true, grid: { color: gridColor }, border: { display: false }, ticks: { callback: v => 'RM' + Number(v / 1000).toFixed(0) + 'k', padding: 10, font: { weight: '600' } } },
                    x: { grid: { display: false }, border: { display: false }, ticks: { padding: 10, font: { weight: '700', color: '#6b7280' } } }
                }
            }
        });
    </script>
</x-app-layout>
