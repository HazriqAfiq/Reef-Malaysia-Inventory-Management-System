<x-app-layout title="Manage Resellers">

    {{-- Success Toast --}}
    @if(session('success'))
        <div class="mb-5 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-[13px] font-bold px-4 py-3 rounded-xl shadow-sm">
            <svg class="w-5 h-5 shrink-0 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- ═══════════════════════════════════════════════════════════════
         HEADER & ACTION BUTTONS
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-900 tracking-tight">Manage Resellers</h1>
            <p class="text-sm font-medium text-gray-500 mt-1">View and manage authorized reseller accounts.</p>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('admin.resellers.create') }}"
               class="inline-flex items-center gap-1.5 px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700
                      text-white text-[13px] font-bold rounded-xl shadow-md shadow-blue-500/30 transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/40 hover:-translate-y-0.5">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Add Reseller
            </a>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════
         KPI CARDS
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        {{-- Total Resellers --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-lg shadow-gray-200/50 p-6 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div class="absolute bottom-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-50 to-transparent rounded-tl-[80px] -mr-8 -mb-8 transition-transform duration-500 group-hover:scale-110"></div>
            <div class="flex items-start justify-between mb-4 relative z-10">
                <span class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center shrink-0 border border-blue-100/50 shadow-[0_2px_10px_rgba(59,130,246,0.15)]">
                    <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </span>
            </div>
            <div class="relative z-10">
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-1">Registered Accounts</p>
                <p class="text-2xl font-black text-gray-900 tracking-tight">{{ $totalResellers }}</p>
            </div>
        </div>

        {{-- Total Sales Count --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-lg shadow-gray-200/50 p-6 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div class="absolute bottom-0 right-0 w-32 h-32 bg-gradient-to-br from-emerald-50 to-transparent rounded-tl-[80px] -mr-8 -mb-8 transition-transform duration-500 group-hover:scale-110"></div>
            <div class="flex items-start justify-between mb-4 relative z-10">
                <span class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center shrink-0 border border-emerald-100/50 shadow-[0_2px_10px_rgba(16,185,129,0.15)]">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </span>
            </div>
            <div class="relative z-10">
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-1">Global Transactions</p>
                <p class="text-2xl font-black text-gray-900 tracking-tight">{{ number_format($totalSalesCount) }}</p>
            </div>
        </div>

        {{-- Total Revenue --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-lg shadow-gray-200/50 p-6 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div class="absolute bottom-0 right-0 w-32 h-32 bg-gradient-to-br from-violet-50 to-transparent rounded-tl-[80px] -mr-8 -mb-8 transition-transform duration-500 group-hover:scale-110"></div>
            <div class="flex items-start justify-between mb-4 relative z-10">
                <span class="w-10 h-10 rounded-xl bg-violet-50 flex items-center justify-center shrink-0 border border-violet-100/50 shadow-[0_2px_10px_rgba(139,92,246,0.15)]">
                    <svg class="w-5 h-5 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </span>
            </div>
            <div class="relative z-10">
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-1">Global Revenue</p>
                <p class="text-2xl font-black text-gray-900 tracking-tight">RM{{ number_format($totalRevenue, 2) }}</p>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════
         SEARCH BAR
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-md shadow-gray-200/40 p-5 mb-6 flex gap-3">
        <form method="GET" action="{{ route('admin.resellers.index') }}" class="flex w-full gap-3">
            <div class="relative flex-1 max-w-sm">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Search name or email…"
                       class="w-full pl-10 pr-4 py-2.5 text-[14px] font-medium text-gray-800 bg-gray-50/50 border border-gray-200 rounded-xl
                              focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition duration-300">
            </div>
            <button type="submit"
                    class="px-5 py-2.5 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white text-[13px] font-bold rounded-xl transition-all duration-300 shrink-0 shadow-sm border border-transparent hover:border-blue-500 hover:shadow-md">
                Search
            </button>
            @if(request('search'))
                <a href="{{ route('admin.resellers.index') }}"
                   class="px-5 py-2.5 text-[13px] font-bold text-gray-500 hover:text-gray-700 bg-white border border-gray-200
                          rounded-xl hover:bg-gray-50 transition-colors duration-150 shrink-0 flex items-center justify-center">
                    Clear Filters
                </a>
            @endif
        </form>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════
         TABLE
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-md shadow-gray-200/40 overflow-hidden mb-12">
        <div class="px-7 py-5 border-b border-gray-50 flex items-center justify-between">
            <div>
                <h2 class="text-[15px] font-bold text-gray-900 tracking-tight">Authorized Resellers</h2>
                <p class="text-xs font-medium text-gray-500 mt-1">
                    Showing {{ $resellers->firstItem() ?? 0 }}–{{ $resellers->lastItem() ?? 0 }} of {{ $resellers->total() }} accounts
                </p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-50">
                        <th class="px-7 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Account Profile</th>
                        <th class="px-7 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Transactions</th>
                        <th class="px-7 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Revenue Generated</th>
                        <th class="px-7 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest hidden sm:table-cell">Joined</th>
                        <th class="px-7 py-4"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50/80">
                    @forelse($resellers as $reseller)
                        <tr class="hover:bg-gray-50/60 transition-colors duration-100">
                            {{-- Identity --}}
                            <td class="px-7 py-4.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-black text-[13px] shrink-0 border border-blue-200/50">
                                        {{ strtoupper(substr($reseller->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="text-[14px] font-medium text-gray-900">{{ $reseller->name }}</p>
                                        <p class="text-[12px] font-medium text-gray-400 mt-0.5">{{ $reseller->email }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Transactions --}}
                            <td class="px-7 py-4.5 text-center">
                                <span class="inline-flex items-center justify-center min-w-[2.5rem] px-1.5 h-6 rounded-lg bg-gray-100 border border-gray-200 text-gray-900 text-[12px] font-medium shadow-sm">
                                    {{ number_format($reseller->sales_count) }}
                                </span>
                            </td>

                            {{-- Revenue --}}
                            <td class="px-7 py-4.5 text-right">
                                <p class="text-[15px] font-black text-gray-900">
                                    RM{{ number_format($reseller->sales_sum_total_price ?? 0, 2) }}
                                </p>
                            </td>

                            {{-- Joined --}}
                            <td class="px-7 py-4.5 hidden sm:table-cell">
                                <p class="text-[13px] font-medium text-gray-900">{{ $reseller->created_at->format('d M Y') }}</p>
                                <p class="text-[11px] font-medium text-gray-400 uppercase tracking-wider mt-0.5">{{ $reseller->created_at->diffForHumans() }}</p>
                            </td>

                            {{-- Actions --}}
                            <td class="px-7 py-4.5">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.resellers.edit', $reseller) }}"
                                       class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white hover:shadow-md transition-all duration-200" title="Edit">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <button type="button"
                                            onclick="confirmDelete('{{ route('admin.resellers.destroy', $reseller) }}', '{{ addslashes($reseller->name) }}')"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white hover:shadow-md transition-all duration-200" title="Delete">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-7 py-16 text-center">
                                <div class="mx-auto w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 border border-gray-100 shadow-sm">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <p class="text-[15px] font-bold text-gray-900 mb-1">No resellers found.</p>
                                @if(request('search'))
                                    <p class="text-[12px] text-gray-500 mb-5">No accounts align with your search parameter.</p>
                                    <a href="{{ route('admin.resellers.index') }}" class="text-[12px] font-bold text-blue-600 bg-blue-50 px-4 py-2 rounded-xl hover:bg-blue-100 transition-colors inline-flex cursor-pointer">Clear Search</a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($resellers->hasPages())
            <div class="px-7 py-5 border-t border-gray-50/80">
                {{ $resellers->links() }}
            </div>
        @endif
    </div>

    {{-- ═══════════════════════════════════════════════════════════════
         DELETE CONFIRM MODAL
    ═══════════════════════════════════════════════════════════════ --}}
    <div id="delete-modal"
         class="fixed inset-0 z-[100] hidden items-center justify-center p-4 transition-all duration-300 opacity-0"
         style="background:rgba(17,24,39,0.6); backdrop-filter:blur(4px);">
        <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 w-full max-w-md p-7 transform scale-95 transition-transform duration-300" id="delete-modal-content">
            <div class="flex flex-col items-center text-center mb-6">
                <div class="w-16 h-16 rounded-full bg-red-50 flex items-center justify-center shrink-0 mb-4 border border-red-100 shadow-sm">
                    <svg class="w-8 h-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-black text-gray-900 tracking-tight">Delete Reseller?</h3>
                <p class="text-[13px] text-gray-500 mt-2 leading-relaxed">
                    You are about to delete <span id="delete-name" class="font-bold text-gray-900"></span>.
                    All sales records attached to this user will also be permanently deleted. This action cannot be undone.
                </p>
            </div>
            <div class="mb-7 bg-gray-50 p-4 rounded-2xl border border-gray-100">
                <label for="delete-confirm-input" class="block text-[11px] font-bold text-gray-500 mb-2 uppercase tracking-wide text-center">
                    Type <span id="delete-name-hint" class="font-black text-gray-900 bg-white px-2 py-0.5 rounded shadow-sm border border-gray-200 select-all tracking-normal"></span> below
                </label>
                <input autocomplete="off" type="text" id="delete-confirm-input" class="w-full text-center px-4 py-3 text-[14px] font-bold text-gray-900 bg-white border border-gray-200 rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 placeholder:text-gray-300 placeholder:font-normal placeholder:text-[13px]">
            </div>
            <div class="flex gap-3">
                <button onclick="closeDeleteModal()"
                        class="flex-1 px-5 py-3 text-[13px] font-bold text-gray-600 bg-gray-100 hover:bg-gray-200
                               rounded-xl transition-all duration-300 hover:shadow-sm">
                    Cancel
                </button>
                <form id="delete-form" method="POST" class="flex-1">
                    @csrf @method('DELETE')
                    <button type="submit" id="delete-confirm-btn" disabled
                            class="w-full px-5 py-3 text-[13px] font-bold text-white bg-red-600 hover:bg-red-700
                                   rounded-xl transition-all duration-300 opacity-50 cursor-not-allowed shadow-md shadow-red-500/20">
                        Yes, Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════
         JAVASCRIPT
    ═══════════════════════════════════════════════════════════════ --}}
    <script>
        let expectedDeleteName = '';

        function confirmDelete(url, name) {
            expectedDeleteName = name;
            document.getElementById('delete-name').textContent = name;
            document.getElementById('delete-name-hint').textContent = name;
            document.getElementById('delete-form').action = url;
            
            const input = document.getElementById('delete-confirm-input');
            const btn = document.getElementById('delete-confirm-btn');
            input.value = '';
            input.placeholder = name;
            btn.disabled = true;
            btn.classList.add('opacity-50', 'cursor-not-allowed');
            
            const modal = document.getElementById('delete-modal');
            const content = document.getElementById('delete-modal-content');
            
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                content.classList.remove('scale-95');
                input.focus();
            }, 10);
        }

        document.getElementById('delete-confirm-input').addEventListener('input', function(e) {
            const btn = document.getElementById('delete-confirm-btn');
            if (e.target.value === expectedDeleteName) {
                btn.disabled = false;
                btn.classList.remove('opacity-50', 'cursor-not-allowed');
                btn.classList.add('hover:-translate-y-0.5', 'hover:shadow-lg');
            } else {
                btn.disabled = true;
                btn.classList.add('opacity-50', 'cursor-not-allowed');
                btn.classList.remove('hover:-translate-y-0.5', 'hover:shadow-lg');
            }
        });

        function closeDeleteModal() {
            const modal = document.getElementById('delete-modal');
            const content = document.getElementById('delete-modal-content');
            
            modal.classList.add('opacity-0');
            content.classList.add('scale-95');
            setTimeout(() => modal.classList.add('hidden'), 300);
        }

        document.getElementById('delete-modal').addEventListener('click', function(e) {
            if (e.target === this) closeDeleteModal();
        });

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeDeleteModal();
        });
    </script>
</x-app-layout>
