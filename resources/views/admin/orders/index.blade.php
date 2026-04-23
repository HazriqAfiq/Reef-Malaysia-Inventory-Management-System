<x-app-layout title="Admin Wholesale Orders">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-900 tracking-tight">Wholesale Orders</h1>
            <p class="text-sm font-medium text-gray-500 mt-1">B2B orders placed by Resellers</p>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-md shadow-gray-200/40 overflow-hidden mb-12">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50/80 border-b border-gray-100/80">
                        <th class="text-left px-7 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Order Ref</th>
                        <th class="text-left px-7 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Reseller</th>
                        <th class="text-left px-7 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Date & Time</th>
                        <th class="text-center px-7 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Items</th>
                        <th class="text-right px-7 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Value</th>
                        <th class="text-center px-7 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</th>
                        <th class="px-7 py-4"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50/80">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50/60 transition-colors duration-100">
                            <td class="px-7 py-4.5">
                                <span class="font-mono text-[13px] bg-gray-100/80 px-2 py-0.5 rounded border border-gray-200/50 text-gray-500 font-medium tracking-wider">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td class="px-7 py-4.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-[11px] shrink-0 border border-blue-200/50">
                                        {{ strtoupper(substr($order->user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="text-[13px] font-medium text-gray-900">{{ $order->user->name }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-7 py-4.5 whitespace-nowrap">
                                <p class="text-[13px] font-medium text-gray-900">{{ $order->created_at->format('d M Y') }}</p>
                                <p class="text-[11px] font-medium text-gray-400 uppercase tracking-wider mt-0.5">{{ $order->created_at->format('h:i A') }}</p>
                            </td>
                            <td class="px-7 py-4.5 text-center">
                                <span class="inline-flex items-center justify-center min-w-[2.5rem] px-1.5 h-7 rounded-lg bg-white border border-gray-200 text-gray-600 shadow-sm text-[12px] font-medium">
                                    {{ $order->items->sum('quantity') }}
                                </span>
                            </td>
                            <td class="px-7 py-4.5 text-right">
                                <span class="text-[15px] font-black text-gray-900">RM{{ number_format($order->total_price, 2) }}</span>
                            </td>
                            <td class="px-7 py-4.5 text-center">
                                @if($order->status === 'paid')
                                    <span class="inline-flex items-center gap-1.5 text-[10px] font-black bg-emerald-50 text-emerald-600 border border-emerald-200/50 px-2.5 py-1 rounded-full uppercase tracking-widest shadow-sm">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-[0_0_6px_rgba(16,185,129,0.5)]"></span>
                                        Paid
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 text-[10px] font-black bg-amber-50 text-amber-600 border border-amber-200/50 px-2.5 py-1 rounded-full uppercase tracking-widest shadow-sm">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 shadow-[0_0_6px_rgba(245,158,11,0.5)] animate-pulse"></span>
                                        Pending
                                    </span>
                                @endif
                            </td>
                            <td class="px-7 py-4.5 text-right">
                                <a href="{{ route('admin.orders.show', $order) }}"
                                   class="inline-flex items-center gap-1.5 px-4 py-2 text-[12px] font-bold text-gray-600
                                          bg-white border border-gray-200 hover:bg-gray-50 rounded-xl transition-all duration-300 hover:shadow-sm">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-7 py-16 text-center">
                                <div class="mx-auto w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 border border-gray-100 shadow-sm">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                    </svg>
                                </div>
                                <p class="text-[15px] font-bold text-gray-900 mb-1">No B2B orders recorded yet.</p>
                                <p class="text-[12px] text-gray-500">When resellers purchase stock, their orders will appear here.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($orders->hasPages())
            <div class="px-7 py-5 border-t border-gray-50/80">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

</x-app-layout>
