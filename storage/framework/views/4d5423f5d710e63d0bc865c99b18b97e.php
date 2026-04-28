<?php if (isset($component)) { $__componentOriginal15d9730126555fea898e8a62f8938736 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal15d9730126555fea898e8a62f8938736 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.storefront-layout','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('storefront-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('title', null, []); ?> Checkout <?php $__env->endSlot(); ?>

    <div class="bg-white py-12 lg:py-24">
        <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-16">
                <h1 class="text-5xl font-luxury font-black italic">Finalize Order</h1>
            </div>

            <form action="<?php echo e(route('checkout.store')); ?>" method="POST" class="flex flex-col lg:flex-row gap-16">
                <?php echo csrf_field(); ?>
                
                <!-- ── SHIPPING DETAILS ───────────────────────────────────── -->
                <div class="flex-1">
                    <h2 class="text-[11px] font-black uppercase tracking-[0.4em] mb-10 text-gray-400 italic font-bold">Shipping Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                        <div class="space-y-2">
                            <label class="text-[11px] font-black uppercase tracking-widest text-gray-400 px-1">First Name</label>
                            <input type="text" name="first_name" value="<?php echo e(auth()->user()->name ?? ''); ?>" required 
                                   class="w-full bg-gray-50 border-gray-100 rounded-xl focus:border-black focus:ring-0 py-4 px-5 text-[14px] font-bold">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-black uppercase tracking-widest text-gray-400 px-1">Last Name</label>
                            <input type="text" name="last_name" required 
                                   class="w-full bg-gray-50 border-gray-100 rounded-xl focus:border-black focus:ring-0 py-4 px-5 text-[14px] font-bold">
                        </div>
                        <div class="md:col-span-2 space-y-2">
                            <label class="text-[11px] font-black uppercase tracking-widest text-gray-400 px-1">Email Address</label>
                            <input type="email" name="email" value="<?php echo e(auth()->user()->email ?? ''); ?>" required 
                                   class="w-full bg-gray-50 border-gray-100 rounded-xl focus:border-black focus:ring-0 py-4 px-5 text-[14px] font-bold">
                        </div>
                        <div class="md:col-span-2 space-y-2">
                            <label class="text-[11px] font-black uppercase tracking-widest text-gray-400 px-1">Phone Number</label>
                            <input type="text" name="phone" placeholder="+60 12 345 6789" required 
                                   class="w-full bg-gray-50 border-gray-100 rounded-xl focus:border-black focus:ring-0 py-4 px-5 text-[14px] font-bold">
                        </div>
                    </div>

                    <h2 class="text-[11px] font-black uppercase tracking-[0.4em] mb-10 text-gray-400 italic font-bold">Delivery Address</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2 space-y-2">
                            <label class="text-[11px] font-black uppercase tracking-widest text-gray-400 px-1">Street Address</label>
                            <textarea name="address" rows="3" required placeholder="Unit, Floor, Building, Street Name" 
                                      class="w-full bg-gray-50 border-gray-100 rounded-xl focus:border-black focus:ring-0 py-4 px-5 text-[14px] font-bold"></textarea>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-black uppercase tracking-widest text-gray-400 px-1">City</label>
                            <input type="text" name="city" required 
                                   class="w-full bg-gray-50 border-gray-100 rounded-xl focus:border-black focus:ring-0 py-4 px-5 text-[14px] font-bold">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-black uppercase tracking-widest text-gray-400 px-1">Postcode</label>
                            <input type="text" name="postcode" required 
                                   class="w-full bg-gray-50 border-gray-100 rounded-xl focus:border-black focus:ring-0 py-4 px-5 text-[14px] font-bold">
                        </div>
                        <div class="md:col-span-2 space-y-2">
                            <label class="text-[11px] font-black uppercase tracking-widest text-gray-400 px-1">State</label>
                            <select name="state" required class="w-full bg-gray-50 border-gray-100 rounded-xl focus:border-black focus:ring-0 py-4 px-5 text-[14px] font-bold appearance-none">
                                <option value="">Select State</option>
                                <option value="Johor">Johor</option>
                                <option value="Kedah">Kedah</option>
                                <option value="Kelantan">Kelantan</option>
                                <option value="Kuala Lumpur">Kuala Lumpur</option>
                                <option value="Melaka">Melaka</option>
                                <option value="Negeri Sembilan">Negeri Sembilan</option>
                                <option value="Pahang">Pahang</option>
                                <option value="Penang">Penang</option>
                                <option value="Perak">Perak</option>
                                <option value="Perlis">Perlis</option>
                                <option value="Sabah">Sabah</option>
                                <option value="Sarawak">Sarawak</option>
                                <option value="Selangor">Selangor</option>
                                <option value="Terengganu">Terengganu</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- ── ORDER SUMMARY ──────────────────────────────────────── -->
                <div class="w-full lg:w-[400px]">
                    <div class="bg-gray-50 rounded-3xl p-10 border border-gray-100 sticky top-32">
                        <h2 class="text-[11px] font-black uppercase tracking-[0.4em] mb-10 text-gray-400 italic">Cart Summary</h2>
                        
                        <div class="space-y-6 mb-10 max-h-64 overflow-y-auto pr-2 custom-scrollbar">
                            <?php $__currentLoopData = $checkoutItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-16 bg-white rounded-xl overflow-hidden flex-shrink-0 border border-gray-100">
                                        <img src="<?php echo e($item['variant']->product->primaryImage ? asset('storage/' . $item['variant']->product->primaryImage->image_path) : 'https://placehold.co/100x100?text=' . urlencode($item['variant']->product->name)); ?>" class="w-full h-full object-cover" alt="<?php echo e($item['variant']->product->name); ?>">
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-[12px] font-black uppercase tracking-tight truncate w-32"><?php echo e($item['variant']->product->name); ?></h4>
                                        <p class="text-[11px] text-gray-400 font-bold">Size: <?php echo e($item['variant']->name); ?> | Qty: <?php echo e($item['quantity']); ?></p>
                                    </div>
                                    <span class="text-[13px] font-black tracking-tight">RM <?php echo e(number_format($item['subtotal'], 2)); ?></span>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <?php if(auth()->guard()->check()): ?>
                            <div class="mb-8 p-6 bg-white border border-gray-100 rounded-2xl shadow-sm">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full bg-amber-400"></div>
                                        <span class="text-[11px] font-black uppercase tracking-widest text-gray-400">Loyalty Rewards</span>
                                    </div>
                                    <span class="text-[11px] font-black text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full"><?php echo e(number_format($userPoints)); ?> pts</span>
                                </div>
                                
                                <div class="flex items-center gap-3 cursor-pointer group" x-data="{ used: false }">
                                    <input type="checkbox" name="use_points" value="1" id="use_points" @change="used = !used" class="w-5 h-5 rounded-md border-gray-200 text-black focus:ring-black">
                                    <label for="use_points" class="text-[13px] font-bold text-gray-700 cursor-pointer select-none">
                                        Redeem points for discount
                                        <span x-show="used" class="block text-[10px] text-emerald-600 font-black uppercase mt-0.5 animate-pulse">- RM <?php echo e(number_format(min($total * 0.5, $userPoints / 100), 2)); ?> Applied</span>
                                    </label>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="space-y-4 pt-10 border-t border-gray-100 mb-10">
                            <?php if($totalDiscount > 0): ?>
                                <div class="flex justify-between items-center text-[13px] text-gray-500 font-bold">
                                    <span>Subtotal</span>
                                    <span>RM <?php echo e(number_format($originalTotal, 2)); ?></span>
                                </div>
                                <div class="flex justify-between items-center text-[13px] font-bold text-red-600">
                                    <span>Promotional Savings</span>
                                    <span>- RM <?php echo e(number_format($totalDiscount, 2)); ?></span>
                                </div>
                            <?php endif; ?>
                            <div class="flex justify-between items-center text-[13px] text-gray-500 font-bold">
                                <span>Shipping Cost</span>
                                <span class="uppercase tracking-widest text-emerald-600 text-[11px]">Free</span>
                            </div>
                            <div class="flex justify-between items-center text-[13px] text-gray-500 font-bold">
                                <span>Processing Fee</span>
                                <span class="uppercase tracking-widest text-gray-400 text-[11px]">Included</span>
                            </div>
                            <div class="flex justify-between items-baseline pt-4">
                                <span class="text-lg font-luxury font-black italic">Grand Total</span>
                                <div class="text-right">
                                    <span class="text-3xl font-black tracking-tighter">RM <?php echo e(number_format($total, 2)); ?></span>
                                    <p class="text-[10px] text-emerald-600 font-black uppercase tracking-widest mt-1">+<?php echo e(floor($total)); ?> Points Earned</p>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full py-6 bg-black text-white text-[12px] font-black uppercase tracking-[0.3em] rounded-2xl hover:bg-gray-800 transition-all hover:scale-[1.02] active:scale-[0.98] shadow-2xl shadow-black/20 relative group">
                            Place Order Now
                            <svg class="w-5 h-5 absolute right-6 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 group-hover:translate-x-2 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </button>
                        
                        <p class="mt-8 text-[11px] text-center text-gray-400 font-bold uppercase tracking-widest leading-relaxed px-4">
                            By placing your order, you agree to our <a href="#" class="text-black underline">Terms of Service</a> and <a href="#" class="text-black underline">Privacy Policy</a>.
                        </p>
                    </div>
                </div>

            </form>
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
<?php /**PATH C:\Users\USER\Documents\Project Code\rpims\resources\views/storefront/checkout.blade.php ENDPATH**/ ?>