<section>
    <p class="text-sm text-gray-600 mb-5">
        Once your account is deleted, all data will be permanently removed. This action cannot be undone.
    </p>

    {{-- Trigger button --}}
    <button type="button"
            id="delete-account-btn"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-600 hover:bg-red-700 active:bg-red-800
                   text-white text-sm font-semibold rounded-lg transition-colors duration-150
                   focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
        </svg>
        Delete My Account
    </button>

    {{-- Confirm Modal --}}
    <div id="delete-account-modal"
         class="fixed inset-0 z-50 hidden items-center justify-center p-4"
         style="background:rgba(0,0,0,0.3);backdrop-filter:blur(2px);">
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 w-full max-w-sm p-6">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-gray-900">Delete Account?</h3>
                    <p class="text-xs text-gray-500 mt-0.5">This is permanent and cannot be undone.</p>
                </div>
            </div>

            <form method="post" action="{{ route('profile.destroy') }}" class="space-y-4">
                @csrf
                @method('delete')

                <div>
                    <label for="delete_password" class="block text-sm font-medium text-gray-700 mb-1.5">Confirm your password</label>
                    <input id="delete_password"
                           name="password"
                           type="password"
                           placeholder="Your current password"
                           class="w-full px-3.5 py-2.5 text-sm text-gray-900 bg-white border rounded-lg transition duration-150
                                  focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent
                                  {{ $errors->userDeletion->has('password') ? 'border-red-400' : 'border-gray-200' }}">
                    @if($errors->userDeletion->has('password'))
                        <p class="mt-1.5 text-xs text-red-500">{{ $errors->userDeletion->first('password') }}</p>
                    @endif
                </div>

                <div class="flex gap-3">
                    <button type="button"
                            id="cancel-delete-btn"
                            class="flex-1 px-4 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors duration-150">
                        Cancel
                    </button>
                    <button type="submit"
                            class="flex-1 px-4 py-2.5 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors duration-150">
                        Yes, Delete
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('delete-account-modal');
        document.getElementById('delete-account-btn').addEventListener('click', () => {
            modal.classList.remove('hidden'); modal.classList.add('flex');
        });
        document.getElementById('cancel-delete-btn').addEventListener('click', () => {
            modal.classList.add('hidden'); modal.classList.remove('flex');
        });
        modal.addEventListener('click', e => { if (e.target === modal) { modal.classList.add('hidden'); modal.classList.remove('flex'); } });

        // Auto-open if there were validation errors
        @if($errors->userDeletion->isNotEmpty())
            document.getElementById('delete-account-modal').classList.remove('hidden');
            document.getElementById('delete-account-modal').classList.add('flex');
        @endif
    </script>
</section>
