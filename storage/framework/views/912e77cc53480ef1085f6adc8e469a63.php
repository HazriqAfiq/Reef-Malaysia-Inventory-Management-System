<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Edit Reseller']); ?>

    <div class="max-w-2xl mx-auto">

        <a href="<?php echo e(route('admin.resellers.index')); ?>"
           class="inline-flex items-center gap-1.5 text-[13px] font-bold text-gray-400 hover:text-gray-700 mb-6 transition-all duration-200 hover:-translate-x-1">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to Resellers
        </a>

        <div class="bg-white rounded-3xl border border-gray-100 shadow-lg shadow-gray-200/40 overflow-hidden">
            
            <div class="px-8 py-6 border-b border-gray-50/80 bg-gray-50/30 flex items-center gap-5">
                <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-black text-[17px] shrink-0 border border-blue-200/50 shadow-sm">
                    <?php echo e(strtoupper(substr($reseller->name, 0, 2))); ?>

                </div>
                <div>
                    <h1 class="text-[17px] font-bold text-gray-900 tracking-tight"><?php echo e($reseller->name); ?></h1>
                    <p class="text-[13px] font-medium text-gray-500 mt-1"><?php echo e($reseller->email); ?></p>
                </div>
            </div>

            <form action="<?php echo e(route('admin.resellers.update', $reseller)); ?>" method="POST" class="p-8 space-y-6">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="grid grid-cols-1 gap-6">
                    
                    <div>
                        <label for="name" class="block text-[13px] font-bold text-gray-700 mb-2">Full Name <span class="text-red-500">*</span></label>
                        <input id="name" name="name" type="text" value="<?php echo e(old('name', $reseller->name)); ?>"
                               class="w-full px-4 py-3 text-[14px] font-medium text-gray-900 bg-gray-50/50 border rounded-xl transition-all duration-300
                                      focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500
                                      <?php echo e($errors->has('name') ? 'border-red-400 focus:ring-red-500/20 focus:border-red-500' : 'border-gray-200'); ?>">
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1.5 text-xs font-semibold text-red-500 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                <?php echo e($message); ?>

                            </p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div>
                        <label for="email" class="block text-[13px] font-bold text-gray-700 mb-2">Email Address <span class="text-red-500">*</span></label>
                        <input id="email" name="email" type="email" value="<?php echo e(old('email', $reseller->email)); ?>"
                               class="w-full px-4 py-3 text-[14px] font-medium text-gray-900 bg-gray-50/50 border rounded-xl transition-all duration-300
                                      focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500
                                      <?php echo e($errors->has('email') ? 'border-red-400 focus:ring-red-500/20 focus:border-red-500' : 'border-gray-200'); ?>">
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1.5 text-xs font-semibold text-red-500 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                <?php echo e($message); ?>

                            </p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div>
                        <label for="commission_rate" class="block text-[13px] font-bold text-gray-700 mb-2">Commission Rate (%) <span class="text-red-500">*</span></label>
                        <input id="commission_rate" name="commission_rate" type="number" step="0.01" value="<?php echo e(old('commission_rate', $reseller->commission_rate)); ?>"
                               class="w-full px-4 py-3 text-[14px] font-medium text-gray-900 bg-gray-50/50 border rounded-xl transition-all duration-300
                                      focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500
                                      <?php echo e($errors->has('commission_rate') ? 'border-red-400 focus:ring-red-500/20 focus:border-red-500' : 'border-gray-200'); ?>">
                        <?php $__errorArgs = ['commission_rate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1.5 text-xs font-semibold text-red-500 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                <?php echo e($message); ?>

                            </p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                
                <div class="border-t border-gray-100 pt-8 mt-4">
                    <div class="flex items-start gap-3 mb-6">
                        <div class="w-8 h-8 rounded-full bg-amber-50 flex items-center justify-center shrink-0 border border-amber-100/50">
                            <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[13px] font-black text-gray-900 tracking-tight">Security Credentials</p>
                            <p class="text-[12px] font-medium text-gray-500 mt-0.5">Leave blank to keep the current password unchanged.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-5 bg-gray-50/50 rounded-2xl border border-gray-100">
                        <div>
                            <label for="password" class="block text-[13px] font-bold text-gray-700 mb-2">New Password</label>
                            <input id="password" name="password" type="password"
                                   placeholder="Min. 8 characters"
                                   class="w-full px-4 py-3 text-[14px] font-medium text-gray-900 bg-white border rounded-xl transition-all duration-300
                                          focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 placeholder:text-gray-400
                                          <?php echo e($errors->has('password') ? 'border-red-400 focus:ring-red-500/20 focus:border-red-500' : 'border-gray-200'); ?>">
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1.5 text-xs font-semibold text-red-500 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    <?php echo e($message); ?>

                                </p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-[13px] font-bold text-gray-700 mb-2">Confirm New Password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password"
                                   placeholder="Re-type password"
                                   class="w-full px-4 py-3 text-[14px] font-medium text-gray-900 bg-white border border-gray-200 rounded-xl transition-all duration-300
                                          focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 placeholder:text-gray-400">
                        </div>
                    </div>
                </div>

                
                <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100 mt-8">
                    <a href="<?php echo e(route('admin.resellers.index')); ?>"
                       class="px-5 py-3 text-[13px] font-bold text-gray-500 hover:text-gray-700 bg-white border border-gray-200 hover:bg-gray-50 rounded-xl transition-all duration-300 hover:shadow-sm">
                        Cancel
                    </a>
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700
                                   text-white text-[13px] font-bold rounded-xl shadow-md shadow-blue-500/30 transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/40 hover:-translate-y-0.5
                                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Save Changes
                    </button>
                </div>
            </form>
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
<?php /**PATH C:\Users\USER\Documents\Project Code\rpims\resources\views/admin/resellers/edit.blade.php ENDPATH**/ ?>