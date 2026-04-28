<?php if (isset($component)) { $__componentOriginalcf324bfcd6feee0107a23f728e62ecac = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcf324bfcd6feee0107a23f728e62ecac = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.account-layout','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('account-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    
    <div class="mb-14 pb-10 border-b border-gray-100 flex justify-between items-end">
        <div>
            <div class="inline-flex items-center gap-6">
                <p class="w-8 md:w-12 h-[1px] bg-black opacity-10"></p>
                <h2 class="text-3xl md:text-4xl font-light tracking-[0.2em] text-gray-900 leading-none uppercase">Wishlist</h2>
                <p class="w-8 md:w-12 h-[1px] bg-black opacity-10"></p>
            </div>
        </div>
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.3em] mb-1">
            <?php echo e($wishlistItems->count()); ?> <?php echo e(Str::plural('Item', $wishlistItems->count())); ?>

        </p>
    </div>

    <?php if($wishlistItems->isEmpty()): ?>
        
        <div class="py-24 text-center border border-dashed border-gray-200 bg-gray-50/30">
            <div class="w-16 h-16 rounded-full bg-white border border-gray-100 flex items-center justify-center mx-auto mb-6">
                <svg class="w-6 h-6 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                </svg>
            </div>
            <h3 class="text-xl font-light text-gray-900 mb-2 uppercase tracking-[0.1em]">Your wishlist is empty</h3>
            <p class="text-[13px] text-gray-400 font-medium mb-8 max-w-xs mx-auto leading-relaxed">Save your favorite fragrances to keep track of them and receive stock updates.</p>
            <a href="<?php echo e(route('storefront.collection')); ?>" 
               class="inline-flex items-center px-10 py-4 bg-black text-white text-[10px] font-bold uppercase tracking-[0.4em] hover:bg-gray-800 transition-colors">
                Explore Collection
            </a>
        </div>
    <?php else: ?>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-16">
            <?php $__currentLoopData = $wishlistItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="relative group">
                    
                    <form action="<?php echo e(route('wishlist.toggle', $item->product)); ?>" method="POST" class="absolute top-4 right-4 z-20">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full shadow-sm flex items-center justify-center text-gray-400 hover:text-red-500 transition-all opacity-0 group-hover:opacity-100">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </form>
                    
                    <?php if (isset($component)) { $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.product-card','data' => ['product' => $item->product]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('product-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item->product)]); ?>
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
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <?php if($wishlistItems->hasPages()): ?>
            <div class="mt-12">
                <?php echo e($wishlistItems->links()); ?>

            </div>
        <?php endif; ?>
    <?php endif; ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcf324bfcd6feee0107a23f728e62ecac)): ?>
<?php $attributes = $__attributesOriginalcf324bfcd6feee0107a23f728e62ecac; ?>
<?php unset($__attributesOriginalcf324bfcd6feee0107a23f728e62ecac); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcf324bfcd6feee0107a23f728e62ecac)): ?>
<?php $component = $__componentOriginalcf324bfcd6feee0107a23f728e62ecac; ?>
<?php unset($__componentOriginalcf324bfcd6feee0107a23f728e62ecac); ?>
<?php endif; ?>
<?php /**PATH C:\Users\USER\Documents\Project Code\rpims\resources\views/account/wishlist.blade.php ENDPATH**/ ?>