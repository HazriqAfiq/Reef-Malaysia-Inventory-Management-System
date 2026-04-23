<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title . ' — ' : '' }}RPIMS · Reef Perfume</title>

    <!-- Inter Font (full weight range) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
            font-feature-settings: 'cv02', 'cv03', 'cv04', 'cv11';
        }
    </style>
</head>
<body class="bg-gray-50 antialiased text-gray-900">

{{-- ===== MOBILE OVERLAY ===== --}}
<div id="sidebar-overlay"
     class="fixed inset-0 bg-black/50 z-40 hidden transition-opacity duration-300 opacity-0 lg:hidden"
     onclick="closeSidebar()">
</div>

<div class="flex h-screen overflow-hidden">

    {{-- ===== SIDEBAR ===== --}}
    <aside id="sidebar"
           class="fixed lg:relative top-0 left-0 h-screen w-72 lg:w-60 bg-white border-r border-gray-200
                  shadow-[2px_0_20px_rgba(0,0,0,0.06)] flex flex-col shrink-0 overflow-hidden
                  z-50 lg:z-20 group/sidebar
                  -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">

        <!-- Sidebar Top Glow -->
        <div class="absolute top-0 left-0 right-0 h-32 bg-gradient-to-b from-blue-50/50 to-transparent pointer-events-none"></div>

        <!-- Logo + Mobile Close -->
        <div class="h-16 lg:h-24 flex items-center justify-center px-5 lg:px-7 border-b border-gray-50 shrink-0 relative z-10">
            <a href="{{ Auth::check() && Auth::user()->isAdmin() ? route('admin.dashboard') : (Auth::check() ? route('reseller.dashboard') : '/') }}"
               class="hidden lg:flex items-center gap-3 transition-transform hover:scale-[1.02]">
                <img src="{{ asset('storage/branding/logo.png') }}"
                     alt="Reef Perfume"
                     class="h-8 lg:h-10 w-auto object-contain drop-shadow-sm"
                     onerror="this.style.display='none'; document.getElementById('logo-fallback').style.display='flex';">
                <div id="logo-fallback" class="hidden items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-600 shadow-md shadow-blue-500/20 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[15px] font-black text-gray-900 leading-none tracking-tight">RPIMS</p>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-none mt-1">Reef Perfume</p>
                    </div>
                </div>
            </a>
            <!-- Close button (mobile only) — absolute so it doesn't affect logo centering -->
            <button onclick="closeSidebar()" class="lg:hidden absolute right-4 top-1/2 -translate-y-1/2 w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Nav -->
        <nav class="flex-1 overflow-y-auto py-4 lg:py-5 px-3 lg:px-4 space-y-0.5 relative z-10 scrollbar-hide">

            @auth
                @if(Auth::user()->isAdmin())
                    <p class="px-3 pt-2 pb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest">Main</p>

                    <a href="{{ route('admin.dashboard') }}"
                       class="sidebar-link group {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" onclick="closeSidebar()">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Dashboard
                    </a>

                    <p class="px-3 pt-5 pb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest">Inventory</p>

                    <a href="{{ route('admin.products.index') }}"
                       class="sidebar-link group {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" onclick="closeSidebar()">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                        Products Catalog
                    </a>

                    <a href="{{ route('admin.orders.index') }}"
                       class="sidebar-link group {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" onclick="closeSidebar()">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        Wholesale Orders
                    </a>

                    <p class="px-3 pt-5 pb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest">Sales</p>

                    <a href="{{ route('admin.sales.index') }}"
                       class="sidebar-link group {{ request()->routeIs('admin.sales.*') ? 'active' : '' }}" onclick="closeSidebar()">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        Global Sales
                    </a>

                    <p class="px-3 pt-5 pb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest">Partnerships</p>

                    <a href="{{ route('admin.resellers.index') }}"
                       class="sidebar-link group {{ request()->routeIs('admin.resellers.*') ? 'active' : '' }}" onclick="closeSidebar()">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Resellers Network
                    </a>

                    <p class="px-3 pt-5 pb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest">Configuration</p>

                    <div x-data="{ expanded: {{ request()->routeIs('admin.settings.*') ? 'true' : 'false' }} }">
                        <button @click="expanded = !expanded" 
                                class="w-full flex items-center justify-between sidebar-link group {{ request()->routeIs('admin.settings.*') ? 'active text-blue-600' : '' }}">
                            <div class="flex items-center">
                                <svg class="mr-3 text-gray-400 group-hover:text-blue-600 transition-colors duration-200" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span class="text-[13px] font-bold">Storefront Settings</span>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-600 transition-transform duration-200" :class="{ 'rotate-180': expanded }" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        
                        <div x-show="expanded" x-collapse>
                            <div class="mt-1 space-y-1 pl-11 relative before:absolute before:left-5 before:top-0 before:bottom-3 before:w-px before:bg-gray-200">
                                <a href="{{ route('admin.settings.page', ['page' => 'global']) }}" class="block py-2 text-[12px] font-semibold {{ request()->is('admin/settings/global') ? 'text-blue-600' : 'text-gray-500 hover:text-gray-900' }}">Global Info</a>
                                <a href="{{ route('admin.settings.page', ['page' => 'homepage']) }}" class="block py-2 text-[12px] font-semibold {{ request()->is('admin/settings/homepage') ? 'text-blue-600' : 'text-gray-500 hover:text-gray-900' }}">Homepage</a>
                                <a href="{{ route('admin.settings.page', ['page' => 'collection']) }}" class="block py-2 text-[12px] font-semibold {{ request()->is('admin/settings/collection') ? 'text-blue-600' : 'text-gray-500 hover:text-gray-900' }}">Collection</a>
                                <a href="{{ route('admin.settings.page', ['page' => 'new_arrivals']) }}" class="block py-2 text-[12px] font-semibold {{ request()->is('admin/settings/new_arrivals') ? 'text-blue-600' : 'text-gray-500 hover:text-gray-900' }}">New Arrivals</a>
                                <a href="{{ route('admin.settings.page', ['page' => 'best_sellers']) }}" class="block py-2 text-[12px] font-semibold {{ request()->is('admin/settings/best_sellers') ? 'text-blue-600' : 'text-gray-500 hover:text-gray-900' }}">Best Sellers</a>
                                <a href="{{ route('admin.settings.page', ['page' => 'promotions']) }}" class="block py-2 text-[12px] font-semibold {{ request()->is('admin/settings/promotions') ? 'text-blue-600' : 'text-gray-500 hover:text-gray-900' }}">Promotions Configuration</a>
                            </div>
                        </div>
                    </div>

                @elseif(Auth::user()->isReseller())
                    <p class="px-3 pt-2 pb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest">Main</p>

                    <a href="{{ route('reseller.dashboard') }}"
                       class="sidebar-link group {{ request()->routeIs('reseller.dashboard') ? 'active' : '' }}" onclick="closeSidebar()">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Dashboard
                    </a>

                    <p class="px-3 pt-5 pb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest">Inventory</p>

                    <a href="{{ route('reseller.stock.index') }}"
                       class="sidebar-link group {{ request()->routeIs('reseller.stock.*') ? 'active' : '' }}" onclick="closeSidebar()">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                        My Stock
                    </a>

                    <a href="{{ route('reseller.orders.index') }}"
                       class="sidebar-link group {{ request()->routeIs('reseller.orders.*') ? 'active' : '' }}" onclick="closeSidebar()">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        Restock / Orders
                    </a>

                    <p class="px-3 pt-5 pb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest">Sales</p>

                    <a href="{{ route('reseller.sales.create') }}"
                       class="sidebar-link group {{ request()->routeIs('reseller.sales.create') ? 'active' : '' }}" onclick="closeSidebar()">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        Record Sale
                    </a>

                    <a href="{{ route('reseller.sales.index') }}"
                       class="sidebar-link group {{ request()->routeIs('reseller.sales.index') ? 'active' : '' }}" onclick="closeSidebar()">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        My Sales History
                    </a>
                @endif
            @endauth
        </nav>

        <!-- User Profile Footer -->
        @auth
        <div class="border-t border-gray-50/80 p-4 lg:p-5 bg-gray-50/30 shrink-0 relative z-10 transition-colors hover:bg-gray-50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-100/80 flex items-center justify-center text-blue-700 font-black text-xs shrink-0 border border-blue-200/50 shadow-inner">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-[13px] font-bold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[11px] font-bold text-gray-400 truncate capitalize tracking-wide">{{ Auth::user()->role }}</p>
                </div>
            </div>
            <div class="mt-3 flex rounded-xl border border-gray-200/60 overflow-hidden bg-white shadow-sm">
                <a href="{{ route('profile.edit') }}"
                   class="flex-1 py-2.5 flex justify-center text-gray-500 hover:text-blue-600 hover:bg-blue-50/50 transition-colors border-r border-gray-100"
                   title="Profile Settings" onclick="closeSidebar()">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full h-full py-2.5 flex justify-center text-gray-500 hover:text-red-600 hover:bg-red-50/50 transition-colors" title="Sign Out">
                        <svg class="w-4 h-4 ml-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
        </div>
        @endauth
    </aside>

    {{-- ===== MAIN AREA ===== --}}
    <div class="flex-1 flex flex-col overflow-hidden bg-gray-50 min-w-0">

        {{-- Flat Full-Width Header --}}
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 md:px-8 shrink-0 relative">
            <div class="flex items-center gap-3">
                {{-- Hamburger (mobile only) --}}
                <button id="sidebar-toggle"
                        onclick="openSidebar()"
                        class="lg:hidden w-9 h-9 flex items-center justify-center rounded-lg text-gray-500 hover:text-gray-900 hover:bg-gray-100 transition-colors -ml-1">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                @isset($title)
                    <div class="w-2 h-2 rounded-full bg-blue-500 shadow-[0_0_6px_rgba(59,130,246,0.5)] hidden sm:block"></div>
                    <h1 class="text-[12px] sm:text-[13px] font-black tracking-widest uppercase text-gray-800 truncate">{{ $title }}</h1>
                @endisset
            </div>

            {{-- Centered logo — mobile only --}}
            <a href="{{ Auth::check() && Auth::user()->isAdmin() ? route('admin.dashboard') : (Auth::check() ? route('reseller.dashboard') : '/') }}"
               class="lg:hidden absolute left-1/2 -translate-x-1/2 top-1/2 -translate-y-1/2">
                <img src="{{ asset('storage/branding/logo.png') }}"
                     alt="Reef Perfume"
                     class="h-8 w-auto object-contain drop-shadow-sm"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="hidden items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                    </div>
                    <span class="text-[13px] font-black text-gray-900 tracking-tight">RPIMS</span>
                </div>
            </a>

            <div class="flex items-center gap-2 md:gap-4">

                {{-- ═══════════════════════════════════════════════════════ --}}
                {{--  NOTIFICATION BELL                                      --}}
                {{-- ═══════════════════════════════════════════════════════ --}}
                @auth
                <div
                    id="notif-root"
                    class="relative"
                    x-data="notificationCenter()"
                    x-init="init()"
                >
                    {{-- Bell Button --}}
                    <button
                        id="notif-bell-btn"
                        @click="toggle()"
                        class="relative w-9 h-9 rounded-lg bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400 hover:text-blue-600 hover:bg-blue-50 hover:border-blue-100 transition-all duration-200 focus:outline-none"
                        aria-label="Notifications"
                    >
                        {{-- Bell SVG --}}
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002
                                   6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388
                                   6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3
                                   0 11-6 0v-1m6 0H9" />
                        </svg>

                        {{-- Unread Badge --}}
                        <span
                            x-show="unreadCount > 0"
                            x-cloak
                            x-text="unreadCount > 99 ? '99+' : unreadCount"
                            class="absolute -top-1 -right-1 min-w-[18px] h-[18px] px-1 rounded-full
                                   bg-red-500 text-white text-[10px] font-black flex items-center
                                   justify-center border-2 border-white shadow-sm
                                   animate-pulse"
                        ></span>
                    </button>

                    {{-- Dropdown Panel --}}
                    <div
                        x-show="open"
                        x-cloak
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                        @click.outside="open = false"
                        id="notif-panel"
                        class="absolute right-0 top-[calc(100%+10px)] w-[380px] max-h-[520px]
                               bg-white rounded-2xl shadow-[0_8px_40px_rgba(0,0,0,0.12)]
                               border border-gray-100 z-[999] flex flex-col overflow-hidden"
                    >
                        {{-- Panel Header --}}
                        <div class="flex items-center justify-between px-4 py-3.5 border-b border-gray-100 shrink-0">
                            <div class="flex items-center gap-2">
                                <span class="text-[13px] font-black text-gray-900 tracking-tight">Notifications</span>
                                <span
                                    x-show="unreadCount > 0"
                                    x-cloak
                                    x-text="unreadCount"
                                    class="text-[10px] font-black bg-blue-100 text-blue-700 rounded-full px-2 py-0.5"
                                ></span>
                            </div>
                            <button
                                @click="markAllRead()"
                                x-show="unreadCount > 0"
                                x-cloak
                                class="text-[11px] font-bold text-blue-500 hover:text-blue-700 transition-colors px-2 py-1 rounded-md hover:bg-blue-50"
                            >Mark all read</button>
                        </div>

                        {{-- Notification List --}}
                        <div class="overflow-y-auto flex-1 divide-y divide-gray-50" id="notif-list">
                            {{-- Empty state --}}
                            <div x-show="notifications.length === 0" class="flex flex-col items-center justify-center py-12 text-center">
                                <div class="w-12 h-12 rounded-2xl bg-gray-100 flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                </div>
                                <p class="text-[12px] font-bold text-gray-400">You're all caught up!</p>
                                <p class="text-[11px] text-gray-300 mt-1">No notifications yet.</p>
                            </div>

                            {{-- Notification Items --}}
                            <template x-for="notif in notifications" :key="notif.id">
                                <div
                                    @click="handleClick(notif)"
                                    class="flex items-start gap-3 px-4 py-3.5 cursor-pointer transition-colors duration-150"
                                    :class="notif.is_read ? 'bg-white hover:bg-gray-50' : 'bg-blue-50/40 hover:bg-blue-50/70'"
                                >
                                    {{-- Type Icon --}}
                                    <div
                                        class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0 mt-0.5"
                                        :class="iconBg(notif.type)"
                                    >
                                        <span x-html="iconSvg(notif.type)" class="w-4 h-4 block"></span>
                                    </div>

                                    {{-- Content --}}
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-start justify-between gap-2">
                                            <p
                                                class="text-[12px] font-bold leading-snug truncate"
                                                :class="notif.is_read ? 'text-gray-600' : 'text-gray-900'"
                                                x-text="notif.title"
                                            ></p>
                                            <span class="text-[10px] text-gray-400 shrink-0 mt-0.5 font-medium" x-text="timeAgo(notif.created_at)"></span>
                                        </div>
                                        <p class="text-[11px] text-gray-500 leading-relaxed mt-0.5 line-clamp-2" x-text="notif.message"></p>
                                    </div>

                                    {{-- Unread Dot --}}
                                    <div x-show="!notif.is_read" class="w-2 h-2 rounded-full bg-blue-500 shrink-0 mt-2"></div>
                                </div>
                            </template>
                        </div>

                        {{-- Panel Footer --}}
                        <div class="px-4 py-2.5 border-t border-gray-100 shrink-0">
                            <p class="text-[10px] text-gray-400 text-center font-medium">Refreshes every 30 seconds · Last 20 notifications</p>
                        </div>
                    </div>
                </div>
                @endauth

                <div class="h-5 w-px bg-gray-200 hidden sm:block"></div>

                {{-- Date (hidden on very small screens) --}}
                <div class="hidden sm:flex items-center gap-2 text-gray-500">
                    <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-[12px] font-bold text-gray-500 tracking-wide">{{ now()->format('d M Y') }}</span>
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 sm:p-6 lg:p-8">
            {{ $slot }}
        </main>
    </div>

</div>

{{-- ===== SIDEBAR JS ===== --}}
<script>
    const sidebar  = document.getElementById('sidebar');
    const overlay  = document.getElementById('sidebar-overlay');

    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        sidebar.classList.add('translate-x-0');
        overlay.classList.remove('hidden', 'opacity-0');
        overlay.classList.add('opacity-100');
        document.body.classList.add('overflow-hidden', 'lg:overflow-auto');
    }

    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        sidebar.classList.remove('translate-x-0');
        overlay.classList.add('opacity-0');
        setTimeout(() => {
            overlay.classList.add('hidden');
            overlay.classList.remove('opacity-100');
        }, 300);
        document.body.classList.remove('overflow-hidden');
    }

    // Close sidebar on window resize to desktop
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024) closeSidebar();
    });
</script>

{{-- ===== NOTIFICATION JS ===== --}}
@auth
<script>
function notificationCenter() {
    return {
        open: false,
        notifications: [],
        unreadCount: 0,
        pollTimer: null,

        init() {
            this.fetchNotifications();
            // Poll every 30 seconds
            this.pollTimer = setInterval(() => this.fetchNotifications(), 30000);
        },

        toggle() {
            this.open = !this.open;
        },

        async fetchNotifications() {
            try {
                const resp = await fetch('{{ route('notifications.index') }}', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                });
                if (!resp.ok) return;
                const data = await resp.json();
                this.notifications = data.notifications;
                this.unreadCount   = data.unread_count;
            } catch (e) {
                // silently fail — network may be temporarily unavailable
            }
        },

        async markRead(notif) {
            if (notif.is_read) return;
            try {
                await fetch(`/notifications/${notif.id}/read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });
                notif.is_read = true;
                this.unreadCount = Math.max(0, this.unreadCount - 1);
            } catch (e) {}
        },

        async markAllRead() {
            try {
                await fetch('{{ route('notifications.readAll') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });
                this.notifications.forEach(n => n.is_read = true);
                this.unreadCount = 0;
            } catch (e) {}
        },

        handleClick(notif) {
            this.markRead(notif);
            const url = notif.data && notif.data.action_url;
            if (url) {
                window.location.href = url;
            }
        },

        timeAgo(isoString) {
            const now  = new Date();
            const date = new Date(isoString);
            const diff = Math.floor((now - date) / 1000);
            if (diff < 60)            return 'Just now';
            if (diff < 3600)          return Math.floor(diff / 60) + 'm ago';
            if (diff < 86400)         return Math.floor(diff / 3600) + 'h ago';
            if (diff < 86400 * 7)     return Math.floor(diff / 86400) + 'd ago';
            return date.toLocaleDateString('en-MY', { day: 'numeric', month: 'short' });
        },

        iconBg(type) {
            const map = {
                inventory_low:  'bg-amber-100 text-amber-600',
                inventory_out:  'bg-red-100 text-red-600',
                new_sale:       'bg-emerald-100 text-emerald-600',
                new_order:      'bg-blue-100 text-blue-600',
                order_approved: 'bg-violet-100 text-violet-600',
                new_reseller:   'bg-indigo-100 text-indigo-600',
            };
            return map[type] || 'bg-gray-100 text-gray-500';
        },

        iconSvg(type) {
            const icons = {
                inventory_low: `<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>`,
                inventory_out: `<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>`,
                new_sale:      `<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
                new_order:     `<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>`,
                order_approved:`<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
                new_reseller:  `<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>`,
            };
            return icons[type] || `<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`;
        },
    };
}
</script>
@endauth

</body>
</html>
