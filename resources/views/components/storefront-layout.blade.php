@props(['darkHero' => false, 'hasHero' => false, 'title' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Laman Store') }} | Laman Store Malaysia</title>

    <!-- Fonts: Premium Serif & Clean Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prata&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- CSS & JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        :root {
            --font-serif: "Prata", serif;
            --font-sans: 'Inter', sans-serif;
        }
        .font-luxury { font-family: var(--font-serif); }
        body { 
            font-family: var(--font-sans);
            letter-spacing: -0.01em;
        }
        .glass-nav {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
        .nav-link {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: #666;
            transition: color 0.3s ease;
        }
        .nav-link:hover { color: #000; }

        /* Cinematic Animations */
        @keyframes zoom-slow {
            from { transform: scale(1); }
            to { transform: scale(1.15); }
        }
        @keyframes fade-in-up {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes scroll-down {
            0% { transform: translateY(-100%); }
            100% { transform: translateY(200%); }
        }
        .animate-zoom-slow { animation: zoom-slow 20s infinite alternate ease-in-out; }
        .animate-fade-in-up { animation: fade-in-up 1.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .animate-fade-in-up.delay-300 { animation-delay: 0.3s; opacity: 0; }

        @php
            $menuRoutes = ['storefront.index', 'storefront.collection', 'storefront.newArrivals', 'storefront.bestSellers', 'storefront.promotions'];
            $isMenuPage = request()->routeIs($menuRoutes);
        @endphp

        @if(!$isMenuPage)
        .animate-zoom-slow, .animate-fade-in-up, .animate-fade-in, .animate-ping, .animate-bounce {
            animation: none !important;
            opacity: 1 !important;
            transform: none !important;
        }
        @endif
    </style>
</head>
<body class="antialiased bg-white text-gray-900 scroll-smooth">

    <!-- ── HEADER ───────────────────────────────────────────────────────── -->
    <header class="fixed w-full top-0 z-50 {{ $isMenuPage ? 'transition-all duration-300 ease-in-out' : '' }}">
        <!-- Announcement Bar -->
        @php $announcementEnabled = \App\Models\Setting::getValue('announcement_bar_enabled', '0') === '1'; @endphp
        @if($announcementEnabled)
            <div class="bg-black text-white text-[10px] font-bold tracking-[0.2em] uppercase text-center py-2.5 relative w-full z-[60]">
                {{ \App\Models\Setting::getValue('announcement_bar_text', '') }}
            </div>
        @endif

        <!-- Navigation -->
        <nav x-data="{ 
                mobileMenu: false, 
                scrolled: false, 
                cartCount: {{ array_sum(session('cart', [])) }},
                searchOpen: false 
             }"          @scroll.window="scrolled = (window.pageYOffset > 50)"
              @cart-updated.window="cartCount = $event.detail.count"
              :class="{ 
                'bg-white border-b border-gray-100 py-4 shadow-sm': scrolled || !@json($isMenuPage), 
                'bg-transparent py-4': !scrolled && @json($isMenuPage)
              }"
              class="w-full {{ $isMenuPage ? 'transition-all duration-300 ease-in-out' : '' }} relative">
         
         <!-- Top Scrim (Only visible on Menu Pages with Dark Hero before scroll) -->
         <div x-show="!scrolled && @json($isMenuPage) && @json($darkHero ?? false)" 
              x-transition:enter="transition ease-out duration-700"
              x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100"
              class="absolute inset-x-0 top-0 h-40 bg-gradient-to-b from-black/60 via-black/20 to-transparent pointer-events-none -z-10">
         </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-full">
                
                <!-- Logo (Left) -->
                <div class="flex-shrink-0">
                    <a href="{{ route('storefront.index') }}" 
                       class="text-3xl font-serif tracking-tight transition-all duration-500 uppercase"
                       :class="{ 'text-gray-800': scrolled || !@json($isMenuPage) || !@json($darkHero ?? false), 'text-white': !scrolled && @json($isMenuPage) && @json($darkHero ?? false) }">
                        {{ \App\Models\Setting::getValue('brand_name', 'Laman Store') }}
                    </a>
                </div>

                <!-- Desktop Links (Center) -->
                <div class="hidden md:flex items-center space-x-14">
                    @php
                        $navItems = [
                            ['route' => 'storefront.index', 'label' => 'Home'],
                            ['route' => 'storefront.collection', 'label' => 'Collection'],
                            ['route' => 'storefront.newArrivals', 'label' => 'New Arrivals'],
                            ['route' => 'storefront.bestSellers', 'label' => 'Best Sellers'],
                        ];
                        if (\App\Models\Setting::getValue('enable_promotions_page', '1') === '1') {
                            $navItems[] = ['route' => 'storefront.promotions', 'label' => 'Promotions'];
                        }
                    @endphp
                    @foreach($navItems as $item)
                        <a href="{{ $item['route'] ? route($item['route']) : '#' }}" 
                            class="text-[10px] font-bold tracking-[0.25em] transition-all duration-300 uppercase relative group"
                            :class="{ 
                                'text-black': scrolled || !@json($isMenuPage) || !@json($darkHero ?? false), 
                                'text-white/70 hover:text-white': !scrolled && @json($isMenuPage) && @json($darkHero ?? false),
                                'text-gray-500 hover:text-black': scrolled || !@json($isMenuPage) || !@json($darkHero ?? false)
                            }">
                            {{ $item['label'] }}
                            @if($item['route'] && request()->routeIs($item['route']))
                                <span class="absolute -bottom-3 left-1/2 -translate-x-1/2 w-4 h-[1.5px] bg-current transition-all duration-500"></span>
                            @else
                                <span class="absolute -bottom-3 left-1/2 -translate-x-1/2 w-0 h-[1.5px] bg-current transition-all duration-500 group-hover:w-4"></span>
                            @endif
                        </a>
                    @endforeach
                </div>

                <!-- Icons (Right) -->
                <div class="flex items-center space-x-5">
                    <button @click="searchOpen = !searchOpen" 
                            class="p-2 transition-all duration-500 hover:opacity-50"
                            :class="{ 'text-black': scrolled || !@json($isMenuPage) || !@json($darkHero ?? false), 'text-white': !scrolled && @json($isMenuPage) && @json($darkHero ?? false) }">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    </button>
                    
                    @auth
                        <a href="{{ route('dashboard') }}" 
                           class="p-2 transition-all duration-500 hover:opacity-50"
                           :class="{ 'text-black': scrolled || !@json($isMenuPage) || !@json($darkHero ?? false), 'text-white': !scrolled && @json($isMenuPage) && @json($darkHero ?? false) }"
                           title="My Account">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="p-2 transition-all duration-500 hover:opacity-50"
                           :class="{ 'text-black': scrolled || !@json($isMenuPage) || !@json($darkHero ?? false), 'text-white': !scrolled && @json($isMenuPage) && @json($darkHero ?? false) }"
                           title="Login">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                        </a>
                    @endauth

                    <a href="{{ route('cart.index') }}" 
                       class="p-2 transition-all duration-500 hover:opacity-50 relative"
                       :class="{ 'text-black': scrolled || !@json($isMenuPage) || !@json($darkHero ?? false), 'text-white': !scrolled && @json($isMenuPage) && @json($darkHero ?? false) }">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                        <template x-if="cartCount > 0">
                            <span x-text="cartCount" class="absolute top-1 right-1 bg-black text-white text-[8px] font-black px-1.5 py-0.5 rounded-full ring-1 ring-white transition-all transform scale-90"></span>
                        </template>
                    </a>
                </div>
                </div>
        <!-- Search Overlay -->
        <div x-show="searchOpen" x-cloak @click.away="searchOpen = false" 
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-10" x-transition:enter-end="opacity-100 translate-y-0"
             class="absolute top-full left-0 right-0 bg-white border-b border-gray-100 p-8 shadow-xl shadow-gray-200/20">
            <div class="max-w-3xl mx-auto relative">
                <form action="{{ route('storefront.collection') }}" method="GET">
                    <input type="text" name="search" placeholder="Type to search fragrances..." 
                           class="w-full text-2xl font-luxury italic border-none focus:ring-0 placeholder-gray-200 py-4">
                    <button class="absolute right-0 top-1/2 -translate-y-1/2 p-2">
                        <svg class="w-8 h-8 text-gray-200 hover:text-black transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- Mobile Menu Overlay -->
        <div x-show="mobileMenu" x-cloak 
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
             class="md:hidden fixed inset-0 bg-white z-50 p-6 flex flex-col pt-24">
            <a href="{{ route('storefront.index') }}" class="text-3xl font-luxury font-bold mb-8">Home</a>
            <a href="{{ route('storefront.collection') }}" class="text-3xl font-luxury font-bold mb-8">Collection</a>
            <a href="{{ route('storefront.newArrivals') }}" class="text-3xl font-luxury font-bold mb-8">New Arrivals</a>
            <a href="{{ route('storefront.bestSellers') }}" class="text-3xl font-luxury font-bold mb-8">Best Sellers</a>
            <a href="{{ route('storefront.promotions') }}" class="text-3xl font-luxury font-bold mb-8">Promotions</a>
            
            <div class="mt-auto pb-10 flex flex-col gap-5">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-lg font-bold">My Account</a>
                @else
                    <a href="{{ route('login') }}" class="text-lg font-bold">Login</a>
                @endauth
            </div>
        </div>
    </nav>
    </header>

    <!-- ── MAIN CONTENT ────────────────────────────────────────────────── -->
    <main class="{{ $hasHero ? 'pt-0' : 'pt-20' }} min-h-screen">
        {{ $slot }}
    </main>

    <!-- ── FOOTER ──────────────────────────────────────────────────────────── -->
    <footer class="bg-gray-50 border-t border-gray-100 pt-20 pb-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-20">
                <div class="col-span-1 md:col-span-1">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center text-white">
                            <span class="font-luxury text-lg font-bold italic">R</span>
                        </div>
                        <span class="font-luxury text-lg font-black tracking-widest uppercase">{{ \App\Models\Setting::getValue('brand_name', 'Laman Store') }}</span>
                    </div>
                    <p class="text-[14px] text-gray-500 font-medium leading-relaxed">Crafting luxury fragrances that evoke memories. Born in Malaysia, curated for the world.</p>
                </div>
                
                <div>
                    <h4 class="text-[13px] font-black uppercase tracking-widest text-black mb-6">Shop All</h4>
                    <ul class="space-y-4">
                        <li><a href="{{ route('storefront.collection', ['category' => 'men']) }}" class="text-[14px] text-gray-500 hover:text-black font-medium">For Men</a></li>
                        <li><a href="{{ route('storefront.collection', ['category' => 'woman']) }}" class="text-[14px] text-gray-500 hover:text-black font-medium">For Women</a></li>
                        <li><a href="{{ route('storefront.collection', ['category' => 'unisex']) }}" class="text-[14px] text-gray-500 hover:text-black font-medium">Unisex</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-[13px] font-black uppercase tracking-widest text-black mb-6">Help</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-[14px] text-gray-500 hover:text-black font-medium">Shipping Policy</a></li>
                        <li><a href="#" class="text-[14px] text-gray-500 hover:text-black font-medium">Returns & Exchanges</a></li>
                        <li><a href="#" class="text-[14px] text-gray-500 hover:text-black font-medium">FAQ</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-[13px] font-black uppercase tracking-widest text-black mb-6">Stay Inspired</h4>
                    <form @submit.prevent="alert('Subscribed!')" class="relative">
                        <input type="email" placeholder="Your email address" class="w-full bg-transparent border-0 border-b-2 border-gray-200 focus:ring-0 focus:border-black py-2 pl-0 text-[14px]">
                        <button class="absolute right-0 top-1/2 -translate-y-1/2 p-2">
                            <svg class="w-5 h-5 text-gray-400 hover:text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 border-t border-gray-100 pt-10">
                <p class="text-[12px] text-gray-400 font-bold">&copy; {{ date('Y') }} {{ \App\Models\Setting::getValue('brand_name', 'Laman Store') }} Malaysia. All rights reserved.</p>
                <div class="flex items-center gap-6">
                    <a href="{{ \App\Models\Setting::getValue('footer_instagram', '#') }}" class="text-[12px] text-gray-400 hover:text-black transition-colors font-bold uppercase tracking-widest" target="_blank" rel="noopener noreferrer">Instagram</a>
                    <a href="{{ \App\Models\Setting::getValue('footer_facebook', '#') }}" class="text-[12px] text-gray-400 hover:text-black transition-colors font-bold uppercase tracking-widest" target="_blank" rel="noopener noreferrer">Facebook</a>
                    <a href="#" class="text-[12px] text-gray-400 hover:text-black transition-colors font-bold uppercase tracking-widest">Tiktok</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Notifications -->
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" 
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-y-10 opacity-0" x-transition:enter-end="translate-y-0 opacity-100"
             x-transition:leave="transition ease-in duration-300" x-transition:leave-start="translate-y-0 opacity-100" x-transition:leave-end="translate-y-10 opacity-0"
             class="fixed bottom-10 right-10 z-[60] bg-black text-white px-8 py-4 rounded-2xl shadow-2xl flex items-center gap-4 ring-4 ring-black/10">
            <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            <span class="text-[13px] font-black tracking-wide uppercase">{{ session('success') }}</span>
        </div>
    @endif

</body>
</html>
