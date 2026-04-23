<x-app-layout title="Profile Settings">

    {{-- ═══════════════════════════════════════════
         PAGE HEADER
    ═══════════════════════════════════════════ --}}
    <div class="mb-6 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
        <div>
            <h1 class="text-xl font-bold text-gray-900 tracking-tight">Profile Settings</h1>
            <p class="text-sm text-gray-500 mt-1">Manage your account information, security, and preferences.</p>
        </div>
        {{-- Role badge --}}
        <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl text-[11px] font-black uppercase tracking-widest
            {{ auth()->user()->isAdmin() ? 'bg-indigo-50 text-indigo-700 border border-indigo-100' : 'bg-emerald-50 text-emerald-700 border border-emerald-100' }} self-start sm:self-auto">
            <span class="w-1.5 h-1.5 rounded-full {{ auth()->user()->isAdmin() ? 'bg-indigo-500' : 'bg-emerald-500' }}"></span>
            {{ ucfirst(auth()->user()->role) }}
        </span>
    </div>

    {{-- ═══════════════════════════════════════════
         TWO COLUMN GRID ON LARGE SCREENS
    ═══════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ── LEFT COLUMN (wider) ─────────────── --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Profile Information Card --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-50 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 border border-blue-100/50 flex items-center justify-center text-blue-600 shrink-0">
                        <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-[14px] font-bold text-gray-900">Profile Information</h2>
                        <p class="text-[11px] font-medium text-gray-400 mt-0.5">Update your name and email address.</p>
                    </div>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Change Password Card --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-50 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-amber-50 border border-amber-100/50 flex items-center justify-center text-amber-600 shrink-0">
                        <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-[14px] font-bold text-gray-900">Change Password</h2>
                        <p class="text-[11px] font-medium text-gray-400 mt-0.5">Use a strong, unique password to stay secure.</p>
                    </div>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Danger Zone (resellers only) --}}
            @if(auth()->user()->role === 'reseller')
                <div class="bg-white rounded-3xl border border-red-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-5 border-b border-red-50 flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-red-50 border border-red-100 flex items-center justify-center text-red-600 shrink-0">
                            <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-[14px] font-bold text-red-700">Danger Zone</h2>
                            <p class="text-[11px] font-medium text-red-400 mt-0.5">Permanently delete your account and all associated data.</p>
                        </div>
                    </div>
                    <div class="p-6">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            @endif

        </div>

        {{-- ── RIGHT COLUMN (narrower) ──────────── --}}
        <div class="space-y-6">

            {{-- Account Summary Card --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-50">
                    <h2 class="text-[14px] font-bold text-gray-900">Account Summary</h2>
                    <p class="text-[11px] font-medium text-gray-400 mt-0.5">Read-only account details.</p>
                </div>

                {{-- Avatar --}}
                <div class="px-6 py-5 flex flex-col items-center border-b border-gray-50">
                    <div class="relative group">
                        <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-100 to-indigo-100 border-2 border-blue-200/60 flex items-center justify-center text-blue-700 font-black text-2xl shadow-sm">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-6 h-6 rounded-lg bg-green-400 border-2 border-white flex items-center justify-center shadow-sm" title="Active">
                            <span class="w-2 h-2 rounded-full bg-white"></span>
                        </div>
                    </div>
                    <p class="mt-3 text-[15px] font-bold text-gray-900">{{ auth()->user()->name }}</p>
                    <p class="text-[12px] font-medium text-gray-400 mt-0.5">{{ auth()->user()->email }}</p>
                </div>

                {{-- Account Details --}}
                <div class="px-6 py-4 space-y-3.5">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-black text-gray-400 uppercase tracking-widest">Role</span>
                        <span class="text-[12px] font-bold text-gray-700 capitalize">{{ auth()->user()->role }}</span>
                    </div>
                    <div class="h-px bg-gray-50"></div>
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-black text-gray-400 uppercase tracking-widest">Member Since</span>
                        <span class="text-[12px] font-bold text-gray-700">{{ auth()->user()->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="h-px bg-gray-50"></div>
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-black text-gray-400 uppercase tracking-widest">Status</span>
                        <span class="inline-flex items-center gap-1.5 text-[11px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-100 px-2 py-0.5 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            Active
                        </span>
                    </div>
                    <div class="h-px bg-gray-50"></div>
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-black text-gray-400 uppercase tracking-widest">Email Verified</span>
                        @if(auth()->user()->email_verified_at)
                            <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                                Verified
                            </span>
                        @else
                            <span class="text-[11px] font-bold text-amber-600">Unverified</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Notification Preferences Card --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-50">
                    <h2 class="text-[14px] font-bold text-gray-900">Notifications</h2>
                    <p class="text-[11px] font-medium text-gray-400 mt-0.5">Choose what you're alerted about.</p>
                </div>
                <div class="px-6 py-4 space-y-4">
                    {{-- Toggle: Low Stock --}}
                    <div class="flex items-center justify-between gap-4">
                        <div class="min-w-0">
                            <p class="text-[13px] font-bold text-gray-800">Low Stock Alerts</p>
                            <p class="text-[11px] font-medium text-gray-400">Notify when stock is critical.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer shrink-0">
                            <input type="checkbox" checked class="sr-only peer">
                            <div class="w-10 h-5 bg-gray-200 peer-focus:ring-2 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-5 peer-checked:bg-blue-600 after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:w-4 after:h-4 after:transition-all"></div>
                        </label>
                    </div>
                    <div class="h-px bg-gray-50"></div>
                    {{-- Toggle: New Sales --}}
                    <div class="flex items-center justify-between gap-4">
                        <div class="min-w-0">
                            <p class="text-[13px] font-bold text-gray-800">Sales Recorded</p>
                            <p class="text-[11px] font-medium text-gray-400">Alerts for every new sale.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer shrink-0">
                            <input type="checkbox" class="sr-only peer">
                            <div class="w-10 h-5 bg-gray-200 peer-focus:ring-2 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-5 peer-checked:bg-blue-600 after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:w-4 after:h-4 after:transition-all"></div>
                        </label>
                    </div>
                    <div class="h-px bg-gray-50"></div>
                    {{-- Toggle: Orders --}}
                    <div class="flex items-center justify-between gap-4">
                        <div class="min-w-0">
                            <p class="text-[13px] font-bold text-gray-800">Order Updates</p>
                            <p class="text-[11px] font-medium text-gray-400">Status changes on wholesale orders.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer shrink-0">
                            <input type="checkbox" checked class="sr-only peer">
                            <div class="w-10 h-5 bg-gray-200 peer-focus:ring-2 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-5 peer-checked:bg-blue-600 after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:w-4 after:h-4 after:transition-all"></div>
                        </label>
                    </div>
                    <div class="h-px bg-gray-50"></div>
                    {{-- Toggle: Email --}}
                    <div class="flex items-center justify-between gap-4">
                        <div class="min-w-0">
                            <p class="text-[13px] font-bold text-gray-800">Email Notifications</p>
                            <p class="text-[11px] font-medium text-gray-400">Receive alerts via email.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer shrink-0">
                            <input type="checkbox" class="sr-only peer">
                            <div class="w-10 h-5 bg-gray-200 peer-focus:ring-2 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-5 peer-checked:bg-blue-600 after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:w-4 after:h-4 after:transition-all"></div>
                        </label>
                    </div>
                    <div class="pt-1">
                        <p class="text-[10px] font-medium text-gray-400 italic">* Notification preferences are saved locally for now.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>
