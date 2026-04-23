<x-storefront-layout :hasHero="true">
    <x-slot name="title">My Account</x-slot>

    <div class="bg-white min-h-screen">

        {{-- ── ACCOUNT HERO STRIP ───────────────────────────────────────── --}}
        <div class="bg-black text-white pt-44 pb-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
                    <div>
                        <p class="text-[10px] font-bold text-white/50 uppercase tracking-[0.3em] mb-3">My Account</p>
                        <h1 class="text-4xl md:text-5xl font-bold tracking-tight text-white mb-2">{{ Auth::user()->name }}</h1>
                        <p class="text-[11px] text-white/50 font-medium tracking-widest uppercase">{{ Auth::user()->email }}</p>
                    </div>
                    <div class="flex items-center gap-8">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-[10px] font-bold text-white/50 hover:text-white uppercase tracking-[0.25em] border border-white/20 hover:border-white/60 px-5 py-2.5 transition-all">
                                Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── TAB NAVIGATION ───────────────────────────────────────────── --}}
        <div class="bg-gray-900 border-t border-white/5 sticky top-[72px] z-40 shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <nav class="flex overflow-x-auto scrollbar-hide">
                    <a href="{{ route('account.index') }}"
                       class="flex-shrink-0 px-7 py-4 text-[10px] font-bold uppercase tracking-[0.3em] transition-all border-b-2 whitespace-nowrap
                              {{ request()->routeIs('account.index') ? 'text-white border-white' : 'text-gray-500 border-transparent hover:text-gray-200 hover:border-gray-600' }}">
                        Overview
                    </a>
                    <a href="{{ route('account.orders') }}"
                       class="flex-shrink-0 px-7 py-4 text-[10px] font-bold uppercase tracking-[0.3em] transition-all border-b-2 whitespace-nowrap
                              {{ request()->routeIs('account.orders') ? 'text-white border-white' : 'text-gray-500 border-transparent hover:text-gray-200 hover:border-gray-600' }}">
                        Orders
                    </a>
                    <a href="{{ route('account.addresses') }}"
                       class="flex-shrink-0 px-7 py-4 text-[10px] font-bold uppercase tracking-[0.3em] transition-all border-b-2 whitespace-nowrap
                              {{ request()->routeIs('account.addresses') ? 'text-white border-white' : 'text-gray-500 border-transparent hover:text-gray-200 hover:border-gray-600' }}">
                        Addresses
                    </a>
                    <a href="{{ route('account.settings') }}"
                       class="flex-shrink-0 px-7 py-4 text-[10px] font-bold uppercase tracking-[0.3em] transition-all border-b-2 whitespace-nowrap
                              {{ request()->routeIs('account.settings') ? 'text-white border-white' : 'text-gray-500 border-transparent hover:text-gray-200 hover:border-gray-600' }}">
                        Settings
                    </a>
                </nav>
            </div>
        </div>

        {{-- ── PAGE CONTENT ─────────────────────────────────────────────── --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            {{ $slot }}
        </div>

    </div>
</x-storefront-layout>
