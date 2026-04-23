<x-guest-layout>
    <div class="flex flex-col md:flex-row min-h-screen">
        <!-- Left Side: Form -->
        <div class="w-full md:w-[45%] bg-white flex flex-col justify-center items-center p-8 sm:p-12 lg:p-24 relative overflow-y-auto">
            <!-- Back Button -->
            <div class="absolute top-8 left-8 sm:top-12 sm:left-12">
                <a href="{{ (url()->previous() && !str_contains(url()->previous(), 'login') && !str_contains(url()->previous(), 'register') && !str_contains(url()->previous(), 'forgot-password')) ? url()->previous() : route('storefront.index') }}" 
                   class="group flex items-center gap-3 text-[10px] font-black uppercase tracking-[0.3em] text-gray-300 hover:text-black transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Back to Shop</span>
                </a>
            </div>

            <div class="max-w-[420px] w-full animate-fade-in-up">
                <!-- Branding -->
                <div class="mb-16 text-center md:text-left">
                    <a href="/" class="inline-block group">
                        <h2 class="text-2xl font-luxury font-black tracking-[0.3em] uppercase text-black group-hover:opacity-60 transition-opacity">
                            {{ \App\Models\Setting::getValue('brand_name', 'Laman Store') }}
                        </h2>
                    </a>
                </div>

                <!-- Header -->
                <div class="mb-12">
                    <div class="flex items-center gap-6 mb-6">
                        <p class="w-8 h-[1px] bg-gray-200"></p>
                        <h1 class="text-gray-400 text-2xl font-light uppercase tracking-[0.4em] leading-none whitespace-nowrap">
                            SIGN <span class="text-gray-800 font-medium">IN</span>
                        </h1>
                        <p class="w-8 h-[1px] bg-gray-200"></p>
                    </div>
                    <p class="text-[13px] font-bold text-gray-400 uppercase tracking-[0.4em] leading-relaxed">
                        Welcome back to our signature selection.
                    </p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-6" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-8">
                    @csrf

                    <!-- Email Address -->
                    <div class="space-y-2">
                        <label for="email" class="text-[11px] font-bold uppercase tracking-[0.2em] text-gray-500">Email Address</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                               class="w-full bg-white border-0 border-b border-gray-100 py-4 text-base focus:ring-0 focus:border-black transition-colors placeholder-gray-300 px-0 font-medium"
                               placeholder="your@email.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <label for="password" class="text-[11px] font-bold uppercase tracking-[0.2em] text-gray-500">Password</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-[11px] font-bold uppercase tracking-widest text-gray-300 hover:text-black transition-colors">Forgot?</a>
                            @endif
                        </div>
                        <input id="password" type="password" name="password" required 
                               class="w-full bg-white border-0 border-b border-gray-100 py-4 text-base focus:ring-0 focus:border-black transition-colors placeholder-gray-300 px-0 font-medium"
                               placeholder="••••••••">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-100 text-black focus:ring-0 w-4 h-4 transition-all cursor-pointer" name="remember">
                            <span class="ms-3 text-[12px] font-bold uppercase tracking-widest text-gray-400 group-hover:text-black transition-colors">Keep me signed in</span>
                        </label>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-6 bg-black text-white text-[13px] font-black uppercase tracking-[0.4em] hover:bg-gray-900 transition-all active:scale-[0.98] shadow-2xl shadow-black/10">
                            Enter Store
                        </button>
                    </div>
                </form>

                <!-- Footer / Sign Up Link -->
                <div class="mt-20 pt-10 border-t border-gray-50 text-center">
                    <a href="{{ route('register') }}" class="group inline-block">
                        <p class="text-[12px] font-bold text-gray-400 uppercase tracking-widest mb-4 group-hover:text-black transition-colors">New to {{ \App\Models\Setting::getValue('brand_name', 'Laman Store') }}?</p>
                        <span class="text-[12px] font-black uppercase tracking-[0.3em] text-black border-b-2 border-black pb-1 group-hover:opacity-50 transition-opacity">Create Account</span>
                    </a>
                </div>
            </div>

            <!-- Absolute Copy -->
            <div class="absolute bottom-8 left-12 hidden lg:block">
                <p class="text-[9px] font-black text-gray-300 uppercase tracking-[0.2em]">&copy; {{ date('Y') }} {{ \App\Models\Setting::getValue('brand_name', 'Laman Store') }}. All rights reserved.</p>
            </div>
        </div>

        <!-- Right Side: Imagery -->
        <div class="hidden md:block w-full md:w-[55%] bg-black relative overflow-hidden">
            <!-- Cinematic Background -->
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('storage/' . (\App\Models\Setting::getValue('hero_image', 'hero/hero_cinematic.png'))) }}" 
                     class="w-full h-full object-cover opacity-60 animate-zoom-slow" 
                     alt="Luxury Fragrance">
            </div>
            
            <div class="absolute inset-0 bg-gradient-to-r from-white via-transparent to-transparent z-10 w-32"></div>
            <div class="absolute inset-0 bg-black/10 z-10"></div>
            
            <div class="absolute inset-0 flex items-center justify-center z-20">
                <div class="text-center animate-fade-in-up delay-300">
                    <p class="text-white text-[11px] font-bold uppercase tracking-[0.6em] mb-6 opacity-60">ESTABLISHED MMXXIV</p>
                    <h3 class="font-serif text-7xl text-white italic drop-shadow-2xl opacity-90">
                        {{ \App\Models\Setting::getValue('brand_name', 'Laman Store') }}
                    </h3>
                </div>
            </div>

            <!-- Scroll Decor -->
            <div class="absolute bottom-12 right-12 flex flex-col items-center gap-4 text-white/20">
                <div class="w-px h-24 bg-white/10 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1/2 bg-white/40 animate-[scroll-down_3s_infinite]"></div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
