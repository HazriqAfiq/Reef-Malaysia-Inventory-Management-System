<?php if (isset($component)) { $__componentOriginal15d9730126555fea898e8a62f8938736 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal15d9730126555fea898e8a62f8938736 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.storefront-layout','data' => ['hasHero' => true,'darkHero' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('storefront-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['hasHero' => true,'darkHero' => true]); ?>
     <?php $__env->slot('title', null, []); ?> <?php echo e($pageTitle ?? 'Collection'); ?> <?php $__env->endSlot(); ?>

    <div class="bg-white min-h-screen">
        <!-- ── CINEMATIC SHOP BANNER ────────────────────────────────────────────────── -->
        <header class="relative h-[40vh] min-h-[350px] flex flex-col items-center justify-center overflow-hidden bg-black text-white">
            <!-- Cinematic Scrim System -->
            <div class="absolute inset-0 z-[1] bg-black/40"></div> <!-- Global Tint -->
            <div class="absolute inset-x-0 bottom-0 h-[80%] bg-gradient-to-t from-black/90 via-black/40 to-transparent z-[2]"></div> <!-- Bottom Scrim -->

            <!-- Background Image -->
            <div class="absolute inset-0 z-0">
                <img src="<?php echo e(asset('storage/' . ($bannerImage ?? $settings['shop_banner_image'] ?? ($settings['hero_image'] ?? 'hero/hero_cinematic.png')))); ?>" 
                     class="w-full h-full object-cover animate-zoom-slow" 
                     alt="Shop cinematic background">
            </div>

            <div class="relative z-[3] text-center px-4 animate-fade-in-up mt-16">
                <div class="inline-flex gap-8 items-center mb-6">
                    <p class="w-8 md:w-16 h-[1px] bg-white opacity-40"></p>
                    <p class="text-white/60 text-3xl md:text-5xl font-light uppercase tracking-[0.3em] leading-none whitespace-nowrap">
                        <?php echo e(explode(' ', $pageTitle ?? 'OUR COLLECTION')[0] ?? 'OUR'); ?> 
                        <span class="text-white font-semibold">
                            <?php echo e(implode(' ', array_slice(explode(' ', $pageTitle ?? 'OUR COLLECTION'), 1)) ?: 'COLLECTION'); ?>

                        </span>
                    </p>
                    <p class="w-8 md:w-16 h-[1px] bg-white opacity-40"></p>
                </div>
                <p class="text-[11px] font-bold text-white uppercase tracking-[0.5em] drop-shadow-lg" style="text-shadow: 0 2px 4px rgba(0,0,0,0.5);">
                    <?php echo e($pageSubtitle ?? 'Timeless Scents. Curated for You.'); ?>

                </p>
            </div>

            <?php if (isset($component)) { $__componentOriginal8a1da42b5539951aa0bda9418cd9c7de = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8a1da42b5539951aa0bda9418cd9c7de = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.scroll-indicator','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('scroll-indicator'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8a1da42b5539951aa0bda9418cd9c7de)): ?>
<?php $attributes = $__attributesOriginal8a1da42b5539951aa0bda9418cd9c7de; ?>
<?php unset($__attributesOriginal8a1da42b5539951aa0bda9418cd9c7de); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8a1da42b5539951aa0bda9418cd9c7de)): ?>
<?php $component = $__componentOriginal8a1da42b5539951aa0bda9418cd9c7de; ?>
<?php unset($__componentOriginal8a1da42b5539951aa0bda9418cd9c7de); ?>
<?php endif; ?>
        </header>

        <div class="max-w-[1600px] mx-auto px-6 sm:px-8 lg:px-12 py-16">
            <!-- ── REFINED TOP BAR ────────────────────────── -->
            <div class="flex flex-col sm:flex-row justify-between items-center mb-16 pb-8 border-b border-gray-100 gap-8">
                <div class="flex items-center gap-12">
                     <p class="text-[13px] font-black uppercase tracking-widest text-black"><?php echo e($pageTitle ?? 'Collection'); ?></p>
                </div>

                <div class="flex items-center gap-12">
                     <p class="text-[11px] font-bold text-gray-300 uppercase tracking-widest"><?php echo e($products->count()); ?> Results</p>
                </div>
            </div>

            <!-- ── PRODUCT GRID ─────────────────────────────────────────── -->
            <div>
                <?php if($products->isEmpty()): ?>
                    <div class="py-40 text-center">
                        <h3 class="text-2xl font-serif mb-4 text-gray-400">No fragrances found</h3>
                        <p class="text-[11px] text-gray-300 font-bold uppercase tracking-widest">More coming soon</p>
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-x-8 gap-y-16">
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if (isset($component)) { $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.product-card','data' => ['product' => $product]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('product-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $attributes = $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $component = $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal15d9730126555fea898e8a62f8938736)): ?>
<?php $attributes = $__attributesOriginal15d9730126555fea898e8a62f8938736; ?>
<?php unset($__attributesOriginal15d9730126555fea898e8a62f8938736); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal15d9730126555fea898e8a62f8938736)): ?>
<?php $component = $__componentOriginal15d9730126555fea898e8a62f8938736; ?>
<?php unset($__componentOriginal15d9730126555fea898e8a62f8938736); ?>
<?php endif; ?>
<?php /**PATH C:\Users\USER\Documents\Project Code\rpims\resources\views/storefront/simple-collection.blade.php ENDPATH**/ ?>