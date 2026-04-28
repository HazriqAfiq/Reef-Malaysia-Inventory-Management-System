<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('title', null, []); ?> 
        Promotions Configuration
     <?php $__env->endSlot(); ?>

    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 capitalize">Promotions Configuration</h1>
            <p class="text-sm text-gray-500 mt-1">Manage content and visibility for the automated Promotions page, and execute global sale events.</p>
        </div>

        <?php if(session('success')): ?>
            <div class="mb-6 bg-green-50 text-green-700 p-4 rounded-lg flex items-center border border-green-200">
                <svg class="w-5 h-5 mr-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                <div class="text-sm font-medium"><?php echo e(session('success')); ?></div>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <!-- Left Column: Page Settings -->
            <div class="xl:col-span-2 space-y-6">
                <!-- Content Settings Block -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="border-b border-gray-100 px-6 py-4 bg-gray-50/50">
                        <h2 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Page Content</h2>
                    </div>
                    
                    <?php
                        $isPromotionsEnabled = $settings->where('key', 'enable_promotions_page')->first()->value === '1';
                    ?>
                    <form action="<?php echo e(route('admin.settings.page.update', 'promotions')); ?>" method="POST" enctype="multipart/form-data" class="p-6" x-data="{ 
                            promoOriginallyEnabled: <?php echo json_encode($isPromotionsEnabled, 15, 512) ?>, 
                            promoCurrentlyEnabled: <?php echo json_encode($isPromotionsEnabled, 15, 512) ?> 
                        }" 
                        @submit="if(promoOriginallyEnabled && !promoCurrentlyEnabled) { if(!confirm('⚠️ WARNING: Disabling the promotions page will permanently REMOVE all active promotions (discounts, buy 1 get 1, etc.) from ALL products across the catalog. Are you absolutely sure you want to proceed?')) { $event.preventDefault(); } }">
                        <?php echo csrf_field(); ?>
                        
                        <div class="space-y-6">
                            <?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="border-b border-gray-100 pb-6 last:border-0 last:pb-0">
                                    <label class="block text-sm font-black text-gray-800 mb-2 capitalize"><?php echo e(str_replace(['_', 'promotions '], [' ', ''], $setting->key)); ?></label>
                                    
                                    <?php if($setting->type === 'image'): ?>
                                        <?php
                                            $aspectRatio = str_contains($setting->key, 'hero_image') ? 'aspect-[21/9]' : 'aspect-video';
                                        ?>
                                        <div x-data="{ preview: '<?php echo e($setting->value ? (str_contains($setting->value, 'http') ? $setting->value : asset('storage/' . $setting->value)) : ''); ?>' }" class="space-y-4">
                                            <div x-show="preview" class="relative group">
                                                <div class="<?php echo e($aspectRatio); ?> w-full max-w-2xl rounded-2xl overflow-hidden border border-gray-200 bg-gray-50 flex items-center justify-center shadow-sm transition-all duration-300 group-hover:border-blue-300">
                                                    <img :src="preview" class="h-full w-full object-cover">
                                                </div>
                                            </div>
                                            <div x-show="!preview" class="<?php echo e($aspectRatio); ?> w-full max-w-2xl rounded-2xl border-2 border-dashed border-gray-200 flex flex-col items-center justify-center text-gray-400 bg-gray-50/30">
                                                <svg class="w-10 h-10 mb-2 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                <span class="text-[10px] font-black uppercase tracking-widest">No Image Selected</span>
                                            </div>
                                            <input type="file" name="<?php echo e($setting->key); ?>" accept="image/*" 
                                                   @change="if($event.target.files[0]) preview = URL.createObjectURL($event.target.files[0])"
                                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-6 file:rounded-full file:border-0 file:text-[11px] file:font-black file:uppercase file:tracking-widest file:bg-blue-600 file:text-white hover:file:bg-blue-700 transition-all cursor-pointer">
                                        </div>
                                        
                                    <?php elseif($setting->type === 'textarea'): ?>
                                        <textarea name="<?php echo e($setting->key); ?>" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"><?php echo e(old($setting->key, $setting->value)); ?></textarea>
                                        
                                    <?php elseif($setting->type === 'boolean'): ?>
                                        <div class="flex items-center">
                                            <?php if($setting->key === 'enable_promotions_page'): ?>
                                                <input type="checkbox" name="<?php echo e($setting->key); ?>" value="1" x-model="promoCurrentlyEnabled" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                            <?php else: ?>
                                                <input type="checkbox" name="<?php echo e($setting->key); ?>" value="1" <?php echo e($setting->value === '1' || $setting->value === 'true' ? 'checked' : ''); ?> class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                            <?php endif; ?>
                                            <span class="ml-2 text-sm text-gray-600">Enable <?php echo e(str_replace('_', ' ', $setting->key)); ?> (If disabled, the storefront link will be hidden)</span>
                                        </div>
                                        
                                    <?php else: ?>
                                        <input type="text" name="<?php echo e($setting->key); ?>" value="<?php echo e(old($setting->key, $setting->value)); ?>" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    <?php endif; ?>

                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition-colors shadow-sm">
                                Save Page Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Column: Global Promotion Actions -->
            <div class="space-y-6">
                <!-- Global Promo Card -->
                <div class="bg-gradient-to-b from-blue-600 to-indigo-700 rounded-2xl shadow-md border border-blue-800 overflow-hidden text-white relative">
                    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 mix-blend-overlay"></div>
                    
                    <div class="px-6 py-5 border-b border-white/10 relative z-10">
                        <h2 class="text-sm font-black uppercase tracking-widest text-white/90">Global Promotion Event</h2>
                    </div>
                    
                    <form action="<?php echo e(route('admin.settings.globalPromotion')); ?>" method="POST" class="p-6 relative z-10" x-data="{ promoType: 'discount_percent' }">
                        <?php echo csrf_field(); ?>
                        <p class="text-xs text-blue-100 mb-6 leading-relaxed">
                            Need to throw a quick store-wide sale? Use this tool to instantly apply a chosen promotion to <strong>every</strong> active product in your catalog. This will overwrite existing active promotions.
                        </p>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-blue-100 uppercase tracking-widest mb-1">Promotion Type</label>
                                <select name="promotion_type" x-model="promoType" class="w-full rounded-lg border-white/20 bg-white/10 text-white shadow-sm focus:border-white focus:ring-white sm:text-sm [&>option]:text-gray-900">
                                    <option value="discount_percent">Percentage Discount</option>
                                    <option value="bogo">Buy 1 Free 1 (BOGO)</option>
                                </select>
                            </div>

                            <div x-show="promoType === 'discount_percent'">
                                <label class="block text-xs font-bold text-blue-100 uppercase tracking-widest mb-1">Discount %</label>
                                <input type="number" name="discount_percentage" min="1" max="100" :required="promoType === 'discount_percent'" class="w-full rounded-lg border-white/20 bg-white/10 text-white placeholder-blue-300 shadow-sm focus:border-white focus:ring-white sm:text-sm" placeholder="e.g. 20">
                            </div>
                            
                            <div>
                                <label class="block text-xs font-bold text-blue-100 uppercase tracking-widest mb-1">Badge Text</label>
                                <input type="text" name="promotion_badge" :placeholder="promoType === 'bogo' ? 'BUY 1 GET 1' : 'SALE'" class="w-full rounded-lg border-white/20 bg-white/10 text-white shadow-sm focus:border-white focus:ring-white sm:text-sm">
                            </div>

                            <div class="grid grid-cols-2 gap-4 pt-2">
                                <div>
                                    <label class="block text-[10px] font-bold text-blue-200 uppercase tracking-widest mb-1">Starts At (Optional)</label>
                                    <input type="datetime-local" name="promotion_starts_at" class="w-full rounded-lg border-white/20 bg-white/10 text-white shadow-sm focus:border-white focus:ring-white text-xs px-2 py-1.5 [&::-webkit-calendar-picker-indicator]:filter [&::-webkit-calendar-picker-indicator]:invert">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-blue-200 uppercase tracking-widest mb-1">Ends At (Optional)</label>
                                    <input type="datetime-local" name="promotion_ends_at" class="w-full rounded-lg border-white/20 bg-white/10 text-white shadow-sm focus:border-white focus:ring-white text-xs px-2 py-1.5 [&::-webkit-calendar-picker-indicator]:filter [&::-webkit-calendar-picker-indicator]:invert">
                                </div>
                            </div>
                        </div>

                        <div class="mt-8">
                            <button type="submit" class="w-full bg-white text-blue-700 hover:bg-gray-50 font-black py-2.5 px-6 rounded-lg transition-colors shadow-lg uppercase text-sm tracking-wide" onclick="return confirm('Are you sure you want to apply this promotion to ALL products in the catalog? This will overwrite existing promotions.')">
                                Execute Global Sale
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Quick Link -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <p class="text-sm text-gray-500 mb-4">Want to manage individual product promotions instead?</p>
                    <a href="<?php echo e(route('admin.products.index')); ?>" class="inline-flex w-full items-center justify-center px-4 py-2 border border-blue-200 text-sm font-medium rounded-lg text-blue-700 bg-blue-50 hover:bg-blue-100 transition-colors">
                        Go to Product Inventory
                    </a>
                </div>
            </div>
        </div>

    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\Users\USER\Documents\Project Code\rpims\resources\views/admin/settings/promotions.blade.php ENDPATH**/ ?>