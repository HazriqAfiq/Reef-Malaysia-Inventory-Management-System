<x-app-layout title="Order Details">

    <div class="max-w-4xl mx-auto pb-12">
        <div class="mb-6">
            <a href="{{ route('reseller.orders.index') }}" class="inline-flex items-center gap-1.5 text-[13px] font-bold text-gray-400 hover:text-indigo-600 transition-all duration-200 hover:-translate-x-1 group">
                <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to History
            </a>
        </div>

        @if(session('success'))
            <div class="mb-8 p-4 rounded-xl bg-emerald-50 border border-emerald-200/50 shadow-sm flex items-start gap-4">
                <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-200/50">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div>
                    <h3 class="text-[14px] font-black text-emerald-800 tracking-tight">Success</h3>
                    <p class="text-[12px] font-bold text-emerald-600 mt-0.5">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-3xl border border-gray-100 shadow-md shadow-gray-200/40 overflow-hidden">
            
            {{-- Header section --}}
            <div class="px-8 py-8 border-b border-gray-100 bg-gradient-to-b from-gray-50/50 to-white flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-3 mb-3">
                        @if($order->status === 'paid')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-black bg-emerald-50 text-emerald-600 uppercase tracking-widest shadow-sm border border-emerald-200/50">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-[0_0_6px_#10b981]"></span>
                                Paid Status
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-black bg-amber-50 text-amber-600 uppercase tracking-widest shadow-sm border border-amber-200/50">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse shadow-[0_0_6px_rgba(245,158,11,0.5)]"></span>
                                Pending Status
                            </span>
                        @endif
                        <span class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">{{ $order->created_at->format('d M Y, h:i A') }}</span>
                    </div>
                    <h1 class="text-3xl font-black text-gray-900 tracking-tight flex items-center gap-2">
                        <span class="text-gray-300 font-mono">#</span>{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                    </h1>
                </div>
                
                <div class="shrink-0">
                    @if($order->status === 'paid')
                        <a href="{{ route('reseller.orders.invoice', $order) }}" target="_blank" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white border-2 border-indigo-50 text-indigo-600 font-bold text-[13px] rounded-xl hover:bg-indigo-50 transition-all duration-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 hover:-translate-y-0.5 hover:shadow-md">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Download PDF Invoice
                        </a>
                    @else
                        <a href="{{ route('reseller.orders.payment', $order) }}" class="inline-flex items-center justify-center gap-2 px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-[13px] rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 shadow-md shadow-indigo-500/30 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 active:scale-95 transform hover:-translate-y-0.5 hover:shadow-lg hover:shadow-indigo-500/40">
                            Pay Now
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    @endif
                </div>
            </div>

            {{-- Summary metrics --}}
            <div class="grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-gray-100 bg-gray-50/30 border-b border-gray-100">
                <div class="px-8 py-6">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Gateway Ref</p>
                    <p class="font-mono text-[13px] font-bold text-gray-900 bg-gray-100/80 border border-gray-200/50 px-2.5 py-1 rounded-md inline-block shadow-inner">{{ $order->billplz_id ?? 'N/A' }}</p>
                </div>
                <div class="px-8 py-6">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Total Quantity</p>
                    <p class="text-2xl font-black text-gray-900">{{ $order->items->sum('quantity') }} <span class="text-[12px] font-bold text-gray-400 lowercase tracking-wide">units</span></p>
                </div>
                <div class="px-8 py-6">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Total Amount</p>
                    <p class="text-2xl font-black tracking-tight text-indigo-600">RM{{ number_format($order->total_price, 2) }}</p>
                </div>
            </div>

            {{-- Items Array --}}
            <div class="p-8">
                <h3 class="text-[11px] font-black text-gray-900 uppercase tracking-widest mb-6 flex items-center gap-2">
                    <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" /></svg>
                    Items Ordered
                </h3>
                
                <div class="border border-gray-100 rounded-3xl overflow-hidden shadow-sm">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50/80 border-b border-gray-100">
                            <tr>
                                <th class="text-left px-7 py-4 font-black text-gray-400 text-[10px] uppercase tracking-widest">Product</th>
                                <th class="text-center px-7 py-4 font-black text-gray-400 text-[10px] uppercase tracking-widest border-l border-r border-gray-100">Qty</th>
                                <th class="text-right px-7 py-4 font-black text-gray-400 text-[10px] uppercase tracking-widest">Unit Price</th>
                                <th class="text-right px-7 py-4 font-black text-gray-400 text-[10px] uppercase tracking-widest border-l border-gray-100">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50/80">
                            @foreach($order->items as $item)
                                <tr class="hover:bg-gray-50/50 transition-colors duration-100">
                                    <td class="px-7 py-4.5">
                                        <div class="text-[14px] font-black text-gray-900">{{ $item->product->name }}</div>
                                        <div class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">{{ $item->product->volume_ml }}ml</div>
                                    </td>
                                    <td class="px-7 py-4.5 text-center border-l border-r border-gray-50">
                                        <span class="inline-flex items-center justify-center min-w-[2rem] px-1.5 h-6 rounded-lg bg-gray-100 border border-gray-200 text-gray-800 text-[12px] font-black shadow-sm">
                                            {{ $item->quantity }}
                                        </span>
                                    </td>
                                    <td class="px-7 py-4.5 text-right text-[13px] font-bold text-gray-600">
                                        RM{{ number_format($item->price, 2) }}
                                    </td>
                                    <td class="px-7 py-4.5 text-right font-black text-[14px] text-gray-900 border-l border-gray-50 bg-gray-50/30">
                                        RM{{ number_format($item->price * $item->quantity, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="border-t border-gray-200 bg-gray-100/50">
                            <tr>
                                <td colspan="3" class="px-7 py-5 text-right font-black text-gray-500 uppercase tracking-widest text-[11px]">
                                    Grand Total
                                </td>
                                <td class="px-7 py-5 text-right text-xl font-black text-indigo-600 tracking-tight border-l border-gray-200">
                                    RM{{ number_format($order->total_price, 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            
        </div>
    </div>

</x-app-layout>
