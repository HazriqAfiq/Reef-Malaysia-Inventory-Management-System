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
                                @if($setting->value)
                                    <div class="mb-3">
                                        <div class="h-32 w-48 rounded-lg overflow-hidden border border-gray-200 bg-gray-50 flex items-center justify-center">
                                            <img src="{{ asset('storage/' . $setting->value) }}" alt="{{ $setting->key }}" class="h-full w-full object-cover">
                                        </div>
                                    </div>
                                @endif
                                <input type="file" name="{{ $setting->key }}" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                
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
