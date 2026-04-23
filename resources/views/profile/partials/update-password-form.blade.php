<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        {{-- Current Password --}}
        <div>
            <label for="update_password_current_password" class="block text-[13px] font-bold text-gray-700 mb-1.5">
                Current Password <span class="text-red-400">*</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                </div>
                <input id="update_password_current_password"
                       name="current_password"
                       type="password"
                       autocomplete="current-password"
                       placeholder="••••••••"
                       class="w-full pl-10 pr-11 py-2.5 text-sm text-gray-900 bg-gray-50/50 border rounded-xl
                              transition-all duration-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500
                              {{ $errors->updatePassword->has('current_password') ? 'border-red-400' : 'border-gray-200' }}">
                <button type="button" onclick="togglePassword('update_password_current_password', this)"
                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-4 h-4 eye-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>
            @if($errors->updatePassword->has('current_password'))
                <p class="mt-1.5 text-xs font-medium text-red-500 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ $errors->updatePassword->first('current_password') }}
                </p>
            @endif
        </div>

        {{-- New Password --}}
        <div>
            <label for="update_password_password" class="block text-[13px] font-bold text-gray-700 mb-1.5">
                New Password <span class="text-red-400">*</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <input id="update_password_password"
                       name="password"
                       type="password"
                       autocomplete="new-password"
                       placeholder="••••••••"
                       oninput="checkStrength(this.value)"
                       class="w-full pl-10 pr-11 py-2.5 text-sm text-gray-900 bg-gray-50/50 border rounded-xl
                              transition-all duration-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500
                              {{ $errors->updatePassword->has('password') ? 'border-red-400' : 'border-gray-200' }}">
                <button type="button" onclick="togglePassword('update_password_password', this)"
                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-4 h-4 eye-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>
            {{-- Password Strength Bar --}}
            <div class="mt-2 space-y-1.5" id="strength-container" style="display:none">
                <div class="flex gap-1">
                    <div id="str-1" class="h-1 flex-1 rounded-full bg-gray-200 transition-colors duration-300"></div>
                    <div id="str-2" class="h-1 flex-1 rounded-full bg-gray-200 transition-colors duration-300"></div>
                    <div id="str-3" class="h-1 flex-1 rounded-full bg-gray-200 transition-colors duration-300"></div>
                    <div id="str-4" class="h-1 flex-1 rounded-full bg-gray-200 transition-colors duration-300"></div>
                </div>
                <p id="strength-label" class="text-[11px] font-bold text-gray-400"></p>
            </div>
            @if($errors->updatePassword->has('password'))
                <p class="mt-1.5 text-xs font-medium text-red-500 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ $errors->updatePassword->first('password') }}
                </p>
            @endif
        </div>

        {{-- Confirm Password --}}
        <div>
            <label for="update_password_password_confirmation" class="block text-[13px] font-bold text-gray-700 mb-1.5">
                Confirm New Password <span class="text-red-400">*</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <input id="update_password_password_confirmation"
                       name="password_confirmation"
                       type="password"
                       autocomplete="new-password"
                       placeholder="••••••••"
                       class="w-full pl-10 pr-11 py-2.5 text-sm text-gray-900 bg-gray-50/50 border border-gray-200 rounded-xl
                              transition-all duration-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                <button type="button" onclick="togglePassword('update_password_password_confirmation', this)"
                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-4 h-4 eye-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Save --}}
        <div class="flex items-center gap-3 pt-1">
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5
                           bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600
                           text-white text-sm font-bold rounded-xl shadow-sm shadow-amber-500/20
                           transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md hover:shadow-amber-500/30
                           focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                Update Password
            </button>
            @if (session('status') === 'password-updated')
                <span class="text-sm text-emerald-600 font-bold flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Password updated!
                </span>
            @endif
        </div>
    </form>

    <script>
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            const icon = btn.querySelector('.eye-icon');
            icon.style.opacity = isPassword ? '0.5' : '1';
        }

        function checkStrength(val) {
            const container = document.getElementById('strength-container');
            const label = document.getElementById('strength-label');
            const bars = [document.getElementById('str-1'), document.getElementById('str-2'),
                          document.getElementById('str-3'), document.getElementById('str-4')];

            if (!val) { container.style.display = 'none'; return; }
            container.style.display = 'block';

            let score = 0;
            if (val.length >= 8)                        score++;
            if (/[A-Z]/.test(val) && /[a-z]/.test(val)) score++;
            if (/\d/.test(val))                          score++;
            if (/[^A-Za-z0-9]/.test(val))               score++;

            const colors = ['bg-red-400', 'bg-orange-400', 'bg-yellow-400', 'bg-emerald-500'];
            const labels = ['Weak', 'Fair', 'Good', 'Strong'];
            const textColors = ['text-red-500', 'text-orange-500', 'text-yellow-600', 'text-emerald-600'];

            bars.forEach((bar, i) => {
                bar.className = `h-1 flex-1 rounded-full transition-colors duration-300 ${i < score ? colors[score - 1] : 'bg-gray-200'}`;
            });
            label.textContent = labels[score - 1] || '';
            label.className = `text-[11px] font-bold ${textColors[score - 1] || 'text-gray-400'}`;
        }
    </script>
</section>
