<x-account-layout>
    <div class="mb-20">
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.5em] mb-4">Identity & Security</p>
        <h2 class="text-4xl md:text-5xl font-bold text-gray-900 leading-none tracking-tight">Account Settings</h2>
    </div>

    {{-- Notices --}}
    @if(session('status') === 'profile-updated' || session('status') === 'password-updated')
        <div class="mb-16 flex items-center gap-6 px-10 py-6 bg-black text-white border border-black shadow-2xl animate-fade-in">
            <svg class="w-5 h-5 text-emerald-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            <p class="text-[11px] font-bold uppercase tracking-[0.4em]">Configuration successfully updated</p>
        </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-20 mb-20">

        {{-- ── PROFILE INFORMATION ──────────────────────────────────────── --}}
        <div>
            <div class="mb-10 pb-4 border-b border-gray-100">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.4em] mb-2">Registry</p>
                <h3 class="text-3xl font-bold text-gray-900 tracking-tight">Personal Details</h3>
            </div>

            <form method="post" action="{{ route('profile.update') }}" class="space-y-12 max-w-lg">
                @csrf
                @method('patch')

                <div>
                    <label for="name" class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.4em] block mb-4">Official Name</label>
                    <input id="name" name="name" type="text"
                           value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                           class="w-full bg-transparent border-0 border-b border-gray-200 py-4 px-0 text-[16px] font-bold text-gray-900 focus:ring-0 focus:border-black transition-all">
                    <x-input-error class="mt-4 text-[11px] font-bold uppercase tracking-widest text-red-500" :messages="$errors->get('name')" />
                </div>

                <div>
                    <label for="email" class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.4em] block mb-4">Email Address</label>
                    <input id="email" name="email" type="email"
                           value="{{ old('email', $user->email) }}" required autocomplete="username"
                           class="w-full bg-transparent border-0 border-b border-gray-200 py-4 px-0 text-[16px] font-bold text-gray-900 focus:ring-0 focus:border-black transition-all">
                    <x-input-error class="mt-4 text-[11px] font-bold uppercase tracking-widest text-red-500" :messages="$errors->get('email')" />
                </div>

                <div class="pt-8">
                    <button type="submit"
                            class="inline-flex items-center gap-6 px-12 py-5 bg-black text-white text-[10px] font-bold uppercase tracking-[0.4em] hover:bg-gray-800 transition-all shadow-xl">
                        Update Identity
                    </button>
                </div>
            </form>
        </div>

        {{-- ── PASSWORD / SECURITY ──────────────────────────────────────── --}}
        <div>
            <div class="mb-10 pb-4 border-b border-gray-100">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.4em] mb-2">Vault</p>
                <h3 class="text-3xl font-bold text-gray-900 tracking-tight">Security Credentials</h3>
            </div>

            <form method="post" action="{{ route('password.update') }}" class="space-y-12 max-w-lg">
                @csrf
                @method('put')

                <div>
                    <label for="update_password_current_password" class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.4em] block mb-4">Current Cipher</label>
                    <input id="update_password_current_password" name="current_password" type="password"
                           autocomplete="current-password"
                           class="w-full bg-transparent border-0 border-b border-gray-200 py-4 px-0 text-[16px] font-bold text-gray-900 focus:ring-0 focus:border-black transition-all">
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-4 text-[11px] font-bold uppercase tracking-widest text-red-500" />
                </div>

                <div>
                    <label for="update_password_password" class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.4em] block mb-4">New Credentials</label>
                    <input id="update_password_password" name="password" type="password"
                           autocomplete="new-password"
                           class="w-full bg-transparent border-0 border-b border-gray-200 py-4 px-0 text-[16px] font-bold text-gray-900 focus:ring-0 focus:border-black transition-all">
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-4 text-[11px] font-bold uppercase tracking-widest text-red-500" />
                </div>

                <div>
                    <label for="update_password_password_confirmation" class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.4em] block mb-4">Confirm New Cipher</label>
                    <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                           autocomplete="new-password"
                           class="w-full bg-transparent border-0 border-b border-gray-200 py-4 px-0 text-[16px] font-bold text-gray-900 focus:ring-0 focus:border-black transition-all">
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-4 text-[11px] font-bold uppercase tracking-widest text-red-500" />
                </div>

                <div class="pt-8">
                    <button type="submit"
                            class="inline-flex items-center gap-6 px-12 py-5 bg-black text-white text-[10px] font-bold uppercase tracking-[0.4em] hover:bg-gray-800 transition-all shadow-xl">
                        Solidify Security
                    </button>
                </div>
            </form>
        </div>

    </div>

    {{-- ── DANGER ZONE ──────────────────────────────────────────────────── --}}
    <div class="mt-32 pt-20 border-t border-gray-100">
        <div class="flex flex-col md:flex-row justify-between items-center gap-12 text-center md:text-left">
            <div>
                <p class="text-[10px] font-bold text-red-300 uppercase tracking-[0.6em] mb-4">Irreversible Action</p>
                <h4 class="text-3xl font-bold text-gray-900 mb-2 tracking-tight">Relinquish Membership?</h4>
                <p class="text-[13px] text-gray-400 font-bold">This will permanently dissolve your digital registry and history with us.</p>
            </div>
            <form method="post" action="{{ route('profile.destroy') }}"
                  onsubmit="return confirm('Note: Relinquishing your account is permanent. This cannot be undone. Proceed?')">
                @csrf
                @method('delete')
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
                    <input type="password" name="password" placeholder="Confirm with password"
                           class="bg-gray-50 border-0 border-b border-red-100 py-4 px-6 text-[13px] text-gray-700 focus:ring-0 focus:border-red-400 transition-all placeholder-gray-300 font-bold min-w-[240px]">
                    <button type="submit"
                            class="px-10 py-5 bg-red-50 text-red-400 text-[10px] font-bold uppercase tracking-[0.5em] hover:bg-red-500 hover:text-white transition-all">
                        Dissolve Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-account-layout>
