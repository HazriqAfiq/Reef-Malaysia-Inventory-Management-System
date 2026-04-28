<?php if (isset($component)) { $__componentOriginal15d9730126555fea898e8a62f8938736 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal15d9730126555fea898e8a62f8938736 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.storefront-layout','data' => ['hasHero' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('storefront-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['hasHero' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
     <?php $__env->slot('title', null, []); ?> My Account <?php $__env->endSlot(); ?>

    <?php
        $initials = collect(explode(' ', Auth::user()->name))
            ->map(fn($w) => strtoupper(substr($w, 0, 1)))
            ->take(2)->implode('');
    ?>

    <div class="bg-[#FBFBFD] min-h-screen">

        
        <div class="bg-white border-b border-gray-100/80">
            <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 pt-12">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">

                    
                    <div class="flex items-center gap-6">
                        <div class="relative">
                            <div class="w-16 h-16 rounded-3xl bg-gray-900 flex items-center justify-center flex-shrink-0 shadow-lg shadow-gray-200">
                                <span class="text-xl text-white font-medium tracking-[0.3em] uppercase"><?php echo e($initials); ?></span>
                            </div>
                            <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-500 border-4 border-white rounded-full"></div>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.4em] mb-1.5">Member Dashboard</p>
                            <h1 class="text-3xl md:text-4xl font-light tracking-[0.05em] text-gray-900 leading-none uppercase"><?php echo e(Auth::user()->name); ?></h1>
                        </div>
                    </div>

                    
                    <div class="flex items-center gap-4">
                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit"
                                    class="px-5 py-2.5 rounded-full text-[11px] font-bold text-gray-500 hover:text-black uppercase tracking-[0.2em] transition-all bg-gray-50 hover:bg-gray-100 border border-gray-100">
                                Sign Out
                            </button>
                        </form>
                    </div>
                </div>

                
                <nav class="flex space-x-1 overflow-x-auto scrollbar-hide">
                    <?php
                        $navItems = [
                            ['route' => 'account.index', 'label' => 'Overview'],
                            ['route' => 'account.orders', 'label' => 'Orders'],
                            ['route' => 'account.addresses', 'label' => 'Addresses'],
                            ['route' => 'account.wishlist', 'label' => 'Wishlist'],
                            ['route' => 'account.settings', 'label' => 'Settings'],
                        ];
                    ?>

                    <?php $__currentLoopData = $navItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route($item['route'])); ?>"
                           class="group relative px-4 py-4 text-[11px] font-bold uppercase tracking-[0.25em] transition-all duration-300 whitespace-nowrap
                                  <?php echo e(request()->routeIs($item['route']) ? 'text-black' : 'text-gray-400 hover:text-gray-600'); ?>">
                            <?php echo e($item['label']); ?>

                            <?php if(request()->routeIs($item['route'])): ?>
                                <span class="absolute bottom-0 left-0 w-full h-0.5 bg-black rounded-full"></span>
                            <?php else: ?>
                                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gray-200 group-hover:w-full transition-all duration-300 rounded-full"></span>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </nav>
            </div>
        </div>

        
        <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <?php echo e($slot); ?>

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

<?php /**PATH C:\Users\USER\Documents\Project Code\rpims\resources\views/components/account-layout.blade.php ENDPATH**/ ?>