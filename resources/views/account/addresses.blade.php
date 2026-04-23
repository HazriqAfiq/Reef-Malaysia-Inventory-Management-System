<x-account-layout>
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-8 mb-16 pb-8 border-b border-gray-100" x-data="{ open: false }">
        <div>
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.5em] mb-4">Saved Locations</p>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 leading-none tracking-tight">Shipping Registry</h2>
        </div>

        <button @click="open = true"
                class="inline-flex items-center gap-4 px-12 py-4 bg-black text-white text-[10px] font-bold uppercase tracking-[0.4em] hover:bg-gray-800 transition-all shadow-xl">
            Register Location
        </button>

        {{-- ── ADD ADDRESS MODAL ─────────────────────────────────────────── --}}
        <div x-show="open" x-cloak
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/80 backdrop-blur-md">
            <div @click.away="open = false"
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 translate-y-12"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="bg-white w-full max-w-2xl border border-gray-100 shadow-2xl overflow-hidden">

                <div class="flex justify-between items-center px-12 py-10 border-b border-gray-100 bg-gray-50/50">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.5em] mb-2">New Entry</p>
                        <h3 class="text-3xl font-bold text-gray-900 tracking-tight">Add Residence</h3>
                    </div>
                    <button @click="open = false" class="p-2 text-gray-300 hover:text-black transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form action="{{ route('account.addresses.store') }}" method="POST" class="px-12 py-10 space-y-8">
                    @csrf
                    <div class="grid grid-cols-2 gap-x-8 gap-y-10">
                        <div class="col-span-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.4em] block mb-4">Registry Label (e.g. Home Or Office)</label>
                            <input type="text" name="label" placeholder="Personal Residence"
                                   class="w-full bg-white border-0 border-b border-gray-200 py-3 px-0 text-[14px] text-gray-900 font-bold focus:ring-0 focus:border-black transition-colors placeholder-gray-200">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.4em] block mb-4">Recipient Name</label>
                            <input type="text" name="recipient_name" required
                                   class="w-full bg-white border-0 border-b border-gray-200 py-3 px-0 text-[14px] font-bold text-gray-900 focus:ring-0 focus:border-black transition-colors">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.4em] block mb-4">Contact Phone</label>
                            <input type="text" name="phone" required
                                   class="w-full bg-white border-0 border-b border-gray-200 py-3 px-0 text-[14px] font-bold text-gray-900 focus:ring-0 focus:border-black transition-colors">
                        </div>
                        <div class="col-span-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.4em] block mb-4">Principal Address</label>
                            <input type="text" name="address_line_1" required
                                   class="w-full bg-white border-0 border-b border-gray-200 py-3 px-0 text-[14px] font-bold text-gray-900 focus:ring-0 focus:border-black transition-colors placeholder-gray-200" placeholder="Street name and building number">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.4em] block mb-4">City / Region</label>
                            <input type="text" name="city" required
                                   class="w-full bg-white border-0 border-b border-gray-200 py-3 px-0 text-[14px] font-bold text-gray-900 focus:ring-0 focus:border-black transition-colors">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.4em] block mb-4">Postal Code</label>
                            <input type="text" name="postal_code" required
                                   class="w-full bg-white border-0 border-b border-gray-200 py-3 px-0 text-[14px] font-bold text-gray-900 focus:ring-0 focus:border-black transition-colors">
                        </div>
                        <div class="col-span-2 flex items-center gap-5 pt-4">
                            <input type="checkbox" name="is_default" id="is_default" value="1"
                                   class="w-5 h-5 rounded-none border-gray-200 text-black focus:ring-0 focus:ring-offset-0 transition-all cursor-pointer">
                            <label for="is_default" class="text-[10px] font-bold text-gray-500 uppercase tracking-[0.3em] cursor-pointer">Mark as Primary Dispatch Address</label>
                        </div>
                    </div>
                    <div class="pt-8 flex justify-end gap-10 items-center">
                        <button type="button" @click="open = false"
                                class="text-[10px] font-bold uppercase tracking-[0.4em] text-gray-400 hover:text-black transition-colors">
                            Dismiss
                        </button>
                        <button type="submit"
                                class="px-12 py-5 bg-black text-white text-[10px] font-bold uppercase tracking-[0.4em] hover:bg-gray-800 transition-all shadow-xl">
                            Register Address
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if($addresses->isEmpty())
        <div class="py-40 text-center bg-gray-50/50 border border-dashed border-gray-200">
            <p class="text-3xl font-bold text-gray-300 mb-8 tracking-tight">No registered locations</p>
            <button @click="open = true" class="text-[11px] font-bold uppercase tracking-[0.4em] text-gray-900 border-b border-gray-900 pb-2 hover:opacity-50 transition-opacity">
                Add New Residence
            </button>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
            @foreach($addresses as $address)
                <div class="bg-white border-b border-gray-100 pb-12 transition-all relative group">
                    @if($address->is_default)
                        <div class="mb-6">
                            <span class="text-[9px] font-bold text-gray-400 uppercase tracking-[0.5em] border border-gray-200 px-3 py-1">Primary</span>
                        </div>
                    @endif

                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.4em] mb-4">{{ $address->label ?? 'Location' }}</p>
                    <p class="text-2xl font-bold text-gray-900 mb-2 leading-tight tracking-tight">{{ $address->recipient_name }}</p>
                    <p class="text-[13px] text-gray-400 font-bold mb-6 tracking-wide">{{ $address->phone }}</p>
                    
                    <div class="space-y-1 mb-10">
                        <p class="text-[14px] text-gray-600 font-bold tracking-tight">{{ $address->address_line_1 }}</p>
                        <p class="text-[14px] text-gray-600 font-bold tracking-tight">{{ $address->city }}, {{ $address->postal_code }}</p>
                        <p class="text-[14px] text-gray-600 font-bold tracking-widest uppercase">{{ $address->state }}</p>
                    </div>

                    <div class="flex items-center gap-10">
                        <form action="{{ route('account.addresses.delete', $address) }}" method="POST"
                              onsubmit="return confirm('Note: Deleting this entry is permanent. Proceed?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-[10px] font-bold uppercase tracking-[0.3em] text-red-300 hover:text-red-500 transition-colors">
                                Remove
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-account-layout>
