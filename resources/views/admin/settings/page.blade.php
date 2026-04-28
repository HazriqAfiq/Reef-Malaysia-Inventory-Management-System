<x-app-layout>
    <x-slot name="title">
        {{ ucfirst(str_replace('_', ' ', $page)) }} Settings
    </x-slot>

    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 capitalize">{{ str_replace('_', ' ', $page) }} Configuration</h1>
            <p class="text-sm text-gray-500 mt-1">Manage content, images, and preferences for the {{ str_replace('_', ' ', $page) }} section.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 text-green-700 p-4 rounded-lg flex items-center border border-green-200">
                <svg class="w-5 h-5 mr-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                <div class="text-sm font-medium">{{ session('success') }}</div>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <form action="{{ route('admin.settings.page.update', $page) }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf

                <div class="space-y-6">
                    @foreach($settings as $setting)
                        <div class="border-b border-gray-100 pb-6 last:border-0 last:pb-0">
                            <label class="block text-sm font-black text-gray-800 mb-2 capitalize">{{ str_replace(['_', $page . ' '], [' ', ''], $setting->key) }}</label>
                            
                            @if($setting->type === 'image')
                                @php
                                    $aspectRatio = 'aspect-video'; // Default 16:9
                                    if (str_contains($setting->key, 'hero_image')) {
                                        $isBanner = str_contains($setting->key, 'results') || 
                                                    str_contains($setting->key, 'collection') || 
                                                    str_contains($setting->key, 'arrivals') || 
                                                    str_contains($setting->key, 'sellers');
                                        $aspectRatio = $isBanner ? 'aspect-[21/9]' : 'aspect-[16/9]';
                                    }
                                @endphp
                                <div x-data="{ preview: '{{ $setting->value ? (str_contains($setting->value, 'http') ? $setting->value : asset('storage/' . $setting->value)) : '' }}' }" class="space-y-4">
                                    <div x-show="preview" class="relative group">
                                        <div class="{{ $aspectRatio }} w-full max-w-2xl rounded-2xl overflow-hidden border border-gray-200 bg-gray-50 flex items-center justify-center shadow-sm transition-all duration-300 group-hover:border-blue-300">
                                            <img :src="preview" class="h-full w-full object-cover">
                                        </div>
                                    </div>
                                    <div x-show="!preview" class="aspect-video w-full max-w-2xl rounded-2xl border-2 border-dashed border-gray-200 flex flex-col items-center justify-center text-gray-400 bg-gray-50/30">
                                        <svg class="w-10 h-10 mb-2 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <span class="text-[10px] font-black uppercase tracking-widest">No Image Selected</span>
                                    </div>
                                    <input type="file" name="{{ $setting->key }}" accept="image/*" 
                                           @change="if($event.target.files[0]) preview = URL.createObjectURL($event.target.files[0])"
                                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-6 file:rounded-full file:border-0 file:text-[11px] file:font-black file:uppercase file:tracking-widest file:bg-blue-600 file:text-white hover:file:bg-blue-700 transition-all cursor-pointer">
                                </div>
                                
                            @elseif($setting->type === 'textarea')
                                <textarea name="{{ $setting->key }}" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">{{ old($setting->key, $setting->value) }}</textarea>
                                
                            @elseif($setting->type === 'boolean')
                                <div class="flex items-center">
                                    <input type="checkbox" name="{{ $setting->key }}" value="1" {{ $setting->value === '1' || $setting->value === 'true' ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-600">Enable {{ str_replace('_', ' ', $setting->key) }}</span>
                                </div>
                                
                            @else
                                <input type="text" name="{{ $setting->key }}" value="{{ old($setting->key, $setting->value) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            @endif

                        </div>
                    @endforeach
                </div>

                <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition-colors shadow-sm">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>
