<x-account-layout>
    {{-- ── OVERVIEW GRID ────────────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8 mb-16">

        {{-- Latest Order --}}
        <div class="bg-gray-50 border border-gray-100 p-10 group hover:border-gray-200 transition-all duration-500">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.4em] mb-8">Latest Order</p>
            @if($latestOrder)
                <p class="text-3xl font-bold text-gray-900 mb-3">RM {{ number_format($latestOrder->total_price, 2) }}</p>
                <p class="text-[11px] text-gray-400 font-medium uppercase tracking-[0.2em] mb-8">
                    {{ $latestOrder->created_at->format('d M Y') }} &bull;
                    <span class="{{ $latestOrder->status === 'paid' ? 'text-emerald-600' : 'text-amber-600' }} font-bold">
                        {{ ucfirst($latestOrder->status) }}
                    </span>
                </p>
                <a href="{{ route('account.orders') }}" class="inline-flex items-center gap-3 text-[10px] font-bold uppercase tracking-[0.3em] text-black border-b border-black pb-1 hover:opacity-40 transition-opacity">
                    View History
                </a>
            @else
                <p class="text-2xl font-bold text-gray-300 mb-8">No current orders</p>
                <a href="{{ route('storefront.collection') }}" class="inline-flex items-center gap-3 text-[10px] font-bold uppercase tracking-[0.3em] text-black border-b border-black pb-1 hover:opacity-40 transition-opacity">
                    Shop Collection
                </a>
            @endif
        </div>

        {{-- Default Address --}}
        <div class="bg-gray-50 border border-gray-100 p-10 group hover:border-gray-200 transition-all duration-500">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.4em] mb-8">Shipping Profile</p>
            @if($defaultAddress)
                <p class="text-[12px] font-bold text-gray-900 uppercase tracking-[0.2em] mb-2">{{ $defaultAddress->label ?? 'Default' }}</p>
                <p class="text-[14px] text-gray-600 font-bold mb-1">{{ $defaultAddress->recipient_name }}</p>
                <p class="text-[13px] text-gray-400 font-medium leading-relaxed">{{ $defaultAddress->address_line_1 }}</p>
                <p class="text-[13px] text-gray-400 font-medium leading-relaxed mb-8">{{ $defaultAddress->city }}, {{ $defaultAddress->postal_code }}</p>
                <a href="{{ route('account.addresses') }}" class="inline-flex items-center gap-3 text-[10px] font-bold uppercase tracking-[0.3em] text-black border-b border-black pb-1 hover:opacity-40 transition-opacity">
                    Manage Addresses
                </a>
            @else
                <p class="text-2xl font-bold text-gray-300 mb-8">No address saved</p>
                <a href="{{ route('account.addresses') }}" class="inline-flex items-center gap-3 text-[10px] font-bold uppercase tracking-[0.3em] text-black border-b border-black pb-1 hover:opacity-40 transition-opacity">
                    Add Address
                </a>
            @endif
        </div>

        {{-- Member Card --}}
        <div class="bg-black p-10 text-white relative overflow-hidden md:col-span-2 xl:col-span-1 shadow-2xl">
            <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/5 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full border border-white/5 m-4 pointer-events-none"></div>
            
            <div class="relative z-10 h-full flex flex-col">
                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-[0.5em] mb-8">Membership</p>
                <div class="mb-auto">
                    <p class="text-4xl font-bold text-white mb-2 tracking-tight">Signature</p>
                    <p class="text-[11px] text-gray-500 font-medium tracking-[0.3em] uppercase">Since {{ Auth::user()->created_at->format('Y') }}</p>
                </div>
                <div class="pt-8 border-t border-white/10">
                    <div class="flex flex-wrap gap-x-6 gap-y-2">
                        <span class="text-[9px] text-gray-400 uppercase tracking-[0.3em]">Priority Access</span>
                        <span class="text-[9px] text-gray-400 uppercase tracking-[0.3em]">•</span>
                        <span class="text-[9px] text-gray-400 uppercase tracking-[0.3em]">Complimentary Shipping</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── QUICK LINKS ──────────────────────────────────────────────────── --}}
    <div class="pt-8 border-t border-gray-100">
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.5em] mb-10">Account Navigation</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <a href="{{ route('storefront.collection') }}" class="group block">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.3em] mb-3 group-hover:text-black transition-colors">Catalog</p>
                <div class="flex items-end justify-between border-b border-gray-100 pb-4 group-hover:border-black transition-all">
                    <p class="text-xl font-bold text-gray-900 tracking-tight">Shop Collection</p>
                    <svg class="w-5 h-5 text-gray-300 group-hover:text-black translate-y-1 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </div>
            </a>
            <a href="{{ route('account.orders') }}" class="group block">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.3em] mb-3 group-hover:text-black transition-colors">Records</p>
                <div class="flex items-end justify-between border-b border-gray-100 pb-4 group-hover:border-black transition-all">
                    <p class="text-xl font-bold text-gray-900 tracking-tight">Order History</p>
                    <svg class="w-5 h-5 text-gray-300 group-hover:text-black translate-y-1 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </div>
            </a>
            <a href="{{ route('account.settings') }}" class="group block">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.3em] mb-3 group-hover:text-black transition-colors">Identity</p>
                <div class="flex items-end justify-between border-b border-gray-100 pb-4 group-hover:border-black transition-all">
                    <p class="text-xl font-bold text-gray-900 tracking-tight">Account Settings</p>
                    <svg class="w-5 h-5 text-gray-300 group-hover:text-black translate-y-1 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </div>
            </a>
        </div>
    </div>
</x-account-layout>
