<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Edit Product']); ?>

    <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8">

        <a href="<?php echo e(route('admin.products.index')); ?>"
           class="inline-flex items-center gap-1.5 text-[13px] font-bold text-gray-400 hover:text-gray-700 mb-6 transition-all duration-200 hover:-translate-x-1">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to Inventory
        </a>

        <div class="bg-white rounded-3xl border border-gray-100 shadow-md shadow-gray-200/40 overflow-hidden">
            
            <div class="px-8 py-6 border-b border-gray-50/80 bg-gray-50/30 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-[17px] font-bold text-gray-900 tracking-tight">Edit Product</h1>
                    <p class="text-[13px] font-medium text-gray-500 mt-1"><?php echo e($product->name); ?> &middot; <span class="font-mono text-[11px] tracking-wider bg-gray-200/50 px-1.5 py-0.5 rounded"><?php echo e($product->sku); ?></span></p>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <?php if($product->stock === 0): ?>
                        <span class="text-[11px] font-bold bg-red-50 text-red-600 border border-red-100/50 px-3 py-1 rounded-full shadow-sm">Out of Stock</span>
                    <?php elseif($product->stock < 50): ?>
                        <span class="text-[11px] font-bold bg-amber-50 text-amber-600 border border-amber-100/50 px-3 py-1 rounded-full shadow-sm">Low Stock · <?php echo e($product->stock); ?> left</span>
                    <?php else: ?>
                        <span class="text-[11px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-100/50 px-3 py-1 rounded-full shadow-sm">In Stock · <?php echo e($product->stock); ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <form action="<?php echo e(route('admin.products.update', $product)); ?>" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                
                <div>
                    <h2 class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-5 border-b border-gray-100 pb-2">Product Identity</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div>
                            <label for="sku" class="block text-[13px] font-bold text-gray-700 mb-2">SKU</label>
                            <input id="sku" name="sku" type="text" value="<?php echo e(old('sku', $product->sku)); ?>"
                                   class="w-full px-4 py-3 text-[14px] font-mono font-medium text-gray-900 bg-gray-50/50 border rounded-xl transition-all duration-300
                                          focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500
                                          <?php echo e($errors->has('sku') ? 'border-red-400' : 'border-gray-200'); ?>">
                            <?php $__errorArgs = ['sku'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1.5 text-xs font-semibold text-red-500"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div>
                            <label for="name" class="block text-[13px] font-bold text-gray-700 mb-2">Product Name <span class="text-red-500">*</span></label>
                            <input id="name" name="name" type="text" value="<?php echo e(old('name', $product->name)); ?>"
                                   class="w-full px-4 py-3 text-[14px] font-medium text-gray-900 bg-gray-50/50 border rounded-xl transition-all duration-300
                                          focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500
                                          <?php echo e($errors->has('name') ? 'border-red-400' : 'border-gray-200'); ?>">
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1.5 text-xs font-semibold text-red-500"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div>
                            <label for="type" class="block text-[13px] font-bold text-gray-700 mb-2">Type</label>
                            <select id="type" name="product_type_id"
                                    class="w-full px-4 py-3 text-[14px] font-medium text-gray-900 bg-gray-50/50 border rounded-xl transition-all duration-300
                                           focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 cursor-pointer appearance-none bg-no-repeat bg-[position:right_1rem_center] bg-[length:1em_1em] border-gray-200"
                                    style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22currentColor%22%3E%3Cpath%20fill-rule%3D%22evenodd%22%20d%3D%22M5.293%207.293a1%201%200%20011.414%200L10%2010.586l3.293-3.293a1%201%200%20111.414%201.414l-4%204a1%201%200%2001-1.414%200l-4-4a1%201%200%20010-1.414z%22%20clip-rule%3D%22evenodd%22%2F%3E%3C%2Fsvg%3E');">
                                <option value="">Select Type</option>
                                <?php $__currentLoopData = $productTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($pt->id); ?>" <?php echo e(old('product_type_id', $product->product_type_id) == $pt->id ? 'selected' : ''); ?>><?php echo e($pt->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div>
                            <label for="category" class="block text-[13px] font-bold text-gray-700 mb-2">Category</label>
                            <select id="category" name="category_id"
                                    class="w-full px-4 py-3 text-[14px] font-medium text-gray-900 bg-gray-50/50 border rounded-xl transition-all duration-300
                                           focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 cursor-pointer appearance-none bg-no-repeat bg-[position:right_1rem_center] bg-[length:1em_1em] border-gray-200"
                                    style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2020%2020%22%20fill%3D%22currentColor%22%3E%3Cpath%20fill-rule%3D%22evenodd%22%20d%3D%22M5.293%207.293a1%201%200%20011.414%200L10%2010.586l3.293-3.293a1%201%200%20111.414%201.414l-4%204a1%201%200%2001-1.414%200l-4-4a1%201%200%20010-1.414z%22%20clip-rule%3D%22evenodd%22%2F%3E%3C%2Fsvg%3E');">
                                <option value="">Select Category</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($cat->id); ?>" <?php echo e(old('category_id', $product->category_id) == $cat->id ? 'selected' : ''); ?>><?php echo e(ucfirst($cat->name)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>

                
                <div x-data="{ 
                    deletedImages: [],
                    newPreviews: [],
                    primaryType: '<?php echo e($product->primaryImage ? 'existing' : 'none'); ?>',
                    primaryId: <?php echo e($product->primaryImage->id ?? 'null'); ?>,
                    primaryIndex: 0,
                    dataTransfer: new DataTransfer(),
                    handleNewFiles(event) {
                        const files = Array.from(event.target.files);
                        
                        files.forEach((file) => {
                            this.dataTransfer.items.add(file);
                            const reader = new FileReader();
                            const previewIndex = this.newPreviews.length;
                            this.newPreviews.push({ url: '', name: file.name });
                            
                            reader.onload = (e) => {
                                this.newPreviews[previewIndex].url = e.target.result;
                            };
                            reader.readAsDataURL(file);
                        });

                        this.$refs.fileInput.files = this.dataTransfer.files;

                        if (files.length > 0 && this.primaryType === 'none') {
                            this.primaryType = 'new';
                            this.primaryIndex = 0;
                        }
                    },
                    setPrimary(type, identifier) {
                        this.primaryType = type;
                        if (type === 'existing') this.primaryId = identifier;
                        else this.primaryIndex = identifier;
                    }
                }">
                    <h2 class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-5 border-b border-gray-100 pb-2">Product Images</h2>
                    
                    <?php if($errors->has('delete_images') || $errors->has('images') || $errors->has('images.*')): ?>
                        <div class="mb-6 p-4 bg-red-50 border border-red-100 rounded-2xl">
                            <?php $__currentLoopData = $errors->get('delete_images'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <p class="text-xs font-bold text-red-600"><?php echo e($message); ?></p> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $errors->get('images'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <p class="text-xs font-bold text-red-600"><?php echo e($message); ?></p> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $errors->get('images.*'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <p class="text-xs font-bold text-red-600"><?php echo e($message); ?></p> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                    
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-8">
                        
                        <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="relative group aspect-square rounded-2xl overflow-hidden border-2 transition-all duration-300"
                                 x-show="!deletedImages.includes(<?php echo e($image->id); ?>)"
                                 :class="primaryType === 'existing' && primaryId === <?php echo e($image->id); ?> ? 'border-blue-600 ring-4 ring-blue-500/10' : 'border-gray-100 hover:border-gray-300'">
                                <img src="<?php echo e(asset('storage/' . $image->image_path)); ?>" class="w-full h-full object-cover" @click="setPrimary('existing', <?php echo e($image->id); ?>)">
                                <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center gap-2 px-4">
                                    <button type="button" x-show="!(primaryType === 'existing' && primaryId === <?php echo e($image->id); ?>)"
                                            @click="setPrimary('existing', <?php echo e($image->id); ?>)" 
                                            class="w-full py-2 bg-blue-600 text-white text-[10px] font-black uppercase tracking-widest rounded-lg hover:bg-blue-700 transition-colors">
                                        Set as Primary
                                    </button>
                                    <button type="button" @click="
                                        deletedImages.push(<?php echo e($image->id); ?>); 
                                        if(primaryType === 'existing' && primaryId === <?php echo e($image->id); ?>) {
                                            primaryType = 'none';
                                            // Auto-fallback: try to find another existing image
                                            <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $other): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                if (!deletedImages.includes(<?php echo e($other->id); ?>)) {
                                                    primaryType = 'existing';
                                                    primaryId = <?php echo e($other->id); ?>;
                                                }
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            // If still none, try new previews
                                            if (primaryType === 'none' && newPreviews.length > 0) {
                                                primaryType = 'new';
                                                primaryIndex = 0;
                                            }
                                        }
                                    " class="w-full py-2 bg-white text-red-600 text-[10px] font-black uppercase tracking-widest rounded-lg hover:bg-red-50 transition-colors">
                                        Delete Image
                                    </button>
                                </div>
                                <div x-show="primaryType === 'existing' && primaryId === <?php echo e($image->id); ?>" class="absolute top-2 left-2 bg-blue-600 text-white text-[9px] font-black uppercase tracking-widest px-2 py-0.5 rounded-full shadow-sm">
                                    Primary
                                </div>
                                <input type="checkbox" name="delete_images[]" value="<?php echo e($image->id); ?>" class="hidden" :checked="deletedImages.includes(<?php echo e($image->id); ?>)">
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        
                        <template x-for="(preview, index) in newPreviews" :key="index">
                            <div class="relative group aspect-square rounded-2xl overflow-hidden border-2 transition-all duration-300"
                                 :class="primaryType === 'new' && primaryIndex === index ? 'border-blue-600 ring-4 ring-blue-500/10' : 'border-gray-100 hover:border-gray-300'">
                                <img :src="preview.url" class="w-full h-full object-cover" @click="setPrimary('new', index)">
                                <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center gap-2 px-4">
                                    <button type="button" x-show="!(primaryType === 'new' && primaryIndex === index)"
                                            @click="setPrimary('new', index)" 
                                            class="w-full py-2 bg-blue-600 text-white text-[10px] font-black uppercase tracking-widest rounded-lg hover:bg-blue-700 transition-colors">
                                        Set as Primary
                                    </button>
                                    <button type="button" @click="
                                        newPreviews.splice(index, 1);
                                        const dt = new DataTransfer();
                                        Array.from(dataTransfer.files).filter((_, i) => i !== index).forEach(f => dt.items.add(f));
                                        dataTransfer = dt;
                                        $refs.fileInput.files = dataTransfer.files;
                                        if(primaryType === 'new' && primaryIndex === index) {
                                            primaryType = 'none';
                                            // Fallback to existing
                                            <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $other): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                if (!deletedImages.includes(<?php echo e($other->id); ?>)) {
                                                    primaryType = 'existing';
                                                    primaryId = <?php echo e($other->id); ?>;
                                                }
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            // If no existing, fallback to another new
                                            if (primaryType === 'none' && newPreviews.length > 0) {
                                                primaryType = 'new';
                                                primaryIndex = 0;
                                            }
                                        }
                                        else if(primaryType === 'new' && primaryIndex > index) primaryIndex--;
                                    " class="w-full py-2 bg-white text-red-600 text-[10px] font-black uppercase tracking-widest rounded-lg hover:bg-red-50 transition-colors">
                                        Remove
                                    </button>
                                </div>
                                <div x-show="primaryType === 'new' && primaryIndex === index" class="absolute top-2 left-2 bg-blue-600 text-white text-[9px] font-black uppercase tracking-widest px-2 py-0.5 rounded-full shadow-sm">
                                    Primary
                                </div>
                            </div>
                        </template>
                    </div>

                    
                    <div class="bg-gray-50/50 border-2 border-dashed border-gray-200 rounded-3xl p-10 flex flex-col items-center justify-center text-center group hover:border-blue-400 hover:bg-blue-50/30 transition-all duration-300">
                        <div class="w-16 h-16 bg-white rounded-2xl shadow-sm flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15m10.5-11.25L3 3m0 0l18 18M3 3l18 18" />
                            </svg>
                        </div>
                        <p class="text-[14px] font-bold text-gray-700 mb-1">Add More Photos</p>
                        <p class="text-[12px] text-gray-400 mb-6">Select new images (JPG, PNG, WEBP). Click any image (old or new) to set as primary.</p>
                        
                        <input type="file" name="images[]" multiple accept="image/*" @change="handleNewFiles" x-ref="fileInput"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-6 file:rounded-full file:border-0 file:text-[12px] file:font-black file:uppercase file:tracking-widest file:bg-blue-600 file:text-white hover:file:bg-blue-700 transition-all cursor-pointer">
                        
                        <input type="hidden" name="primary_type" :value="primaryType">
                        <input type="hidden" name="primary_id" :value="primaryId">
                        <input type="hidden" name="primary_index" :value="primaryIndex">
                        
                        <?php $__errorArgs = ['images.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-2 text-xs font-semibold text-red-500"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                
                <div x-data="{ 
                    variants: <?php echo e($product->variants->map(fn($v) => [
                        'id' => $v->id,
                        'name' => $v->name,
                        'retail_price' => $v->retail_price,
                        'wholesale_price' => $v->wholesale_price,
                        'stock' => $v->stock,
                        'sku' => $v->sku
                    ])->toJson()); ?>,
                    addVariant() {
                        this.variants.push({ id: null, name: '', retail_price: '', wholesale_price: '', stock: 0, sku: '' });
                    },
                    removeVariant(index) {
                        this.variants.splice(index, 1);
                    }
                }">
                    <div class="flex items-center justify-between mb-5 border-b border-gray-100 pb-2">
                        <h2 class="text-[11px] font-black text-gray-400 uppercase tracking-widest">Product Variants (Sizes/Volumes)</h2>
                        <button type="button" @click="addVariant()" class="text-[10px] font-black uppercase tracking-widest text-blue-600 hover:text-blue-700 flex items-center gap-1.5 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                            Add Variant
                        </button>
                    </div>

                    <div class="space-y-4">
                        <template x-for="(variant, index) in variants" :key="index">
                            <div class="bg-gray-50/50 border border-gray-100 rounded-2xl p-6 relative group/variant">
                                <button type="button" @click="removeVariant(index)" 
                                        class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center opacity-0 group-hover/variant:opacity-100 transition-opacity shadow-lg">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>

                                <input type="hidden" :name="'variants['+index+'][id]'" :value="variant.id">
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
                                    <div class="lg:col-span-1">
                                        <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-2">Size Name (e.g. 50ml)</label>
                                        <input type="text" :name="'variants['+index+'][name]'" x-model="variant.name" required
                                               class="w-full px-4 py-3 text-[14px] font-medium text-gray-900 bg-white border border-gray-200 rounded-xl focus:ring-0 focus:border-blue-500 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-2">SKU (Suffix)</label>
                                        <input type="text" :name="'variants['+index+'][sku]'" x-model="variant.sku"
                                               class="w-full px-4 py-3 text-[14px] font-mono font-medium text-gray-900 bg-white border border-gray-200 rounded-xl focus:ring-0 focus:border-blue-500 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-2">Retail Price (RM)</label>
                                        <input type="number" step="0.01" :name="'variants['+index+'][retail_price]'" x-model="variant.retail_price" required
                                               class="w-full px-4 py-3 text-[14px] font-medium text-gray-900 bg-white border border-gray-200 rounded-xl focus:ring-0 focus:border-blue-500 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-2">Wholesale (RM)</label>
                                        <input type="number" step="0.01" :name="'variants['+index+'][wholesale_price]'" x-model="variant.wholesale_price" required
                                               class="w-full px-4 py-3 text-[14px] font-medium text-gray-900 bg-white border border-gray-200 rounded-xl focus:ring-0 focus:border-blue-500 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-2">Stock</label>
                                        <input type="number" :name="'variants['+index+'][stock]'" x-model="variant.stock" required
                                               class="w-full px-4 py-3 text-[14px] font-medium text-gray-900 bg-white border border-gray-200 rounded-xl focus:ring-0 focus:border-blue-500 transition-all">
                                    </div>
                                </div>
                            </div>
                        </template>

                        <div x-show="variants.length === 0" class="py-10 text-center border-2 border-dashed border-gray-100 rounded-3xl">
                            <p class="text-sm font-medium text-gray-400">No variants added. Click "Add Variant" to begin.</p>
                        </div>
                    </div>

                    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="release_date" class="block text-[13px] font-bold text-gray-700 mb-2">Release Date</label>
                            <input id="release_date" name="release_date" type="date" value="<?php echo e(old('release_date', $product->release_date ? $product->release_date->format('Y-m-d') : date('Y-m-d'))); ?>"
                                   class="w-full px-4 py-3 text-[14px] font-medium text-gray-900 bg-gray-50/50 border rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 border-gray-200">
                        </div>
                        <div>
                            <label for="volume_ml" class="block text-[13px] font-bold text-gray-700 mb-2">Default Volume (Legacy ml) <span class="text-gray-400 font-normal text-[11px]">(display only)</span></label>
                            <input id="volume_ml" name="volume_ml" type="number" min="1" value="<?php echo e(old('volume_ml', $product->volume_ml)); ?>"
                                   class="w-full px-4 py-3 text-[14px] font-medium text-gray-500 bg-gray-100/50 border border-gray-200 rounded-xl cursor-not-allowed" readonly>
                        </div>
                    </div>
                </div>

                
                <div>
                     <h2 class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-5 border-b border-gray-100 pb-2">Fragrance Layers</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="top_note" class="block text-[13px] font-bold text-gray-700 mb-2">
                                <span class="inline-block w-2 h-2 rounded-full bg-blue-500 mr-1.5 mb-0.5"></span>Top Note
                            </label>
                            <input id="top_note" name="top_note" type="text" value="<?php echo e(old('top_note', $product->top_note)); ?>" placeholder="e.g. Citrus"
                                   class="w-full px-4 py-3 text-[14px] font-medium text-gray-900 bg-gray-50/50 border border-gray-200 rounded-xl transition-all duration-300
                                          focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="heart_note" class="block text-[13px] font-bold text-gray-700 mb-2">
                                <span class="inline-block w-2 h-2 rounded-full bg-rose-500 mr-1.5 mb-0.5"></span>Heart Note
                            </label>
                            <input id="heart_note" name="heart_note" type="text" value="<?php echo e(old('heart_note', $product->heart_note)); ?>" placeholder="e.g. Rose"
                                   class="w-full px-4 py-3 text-[14px] font-medium text-gray-900 bg-gray-50/50 border border-gray-200 rounded-xl transition-all duration-300
                                          focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500">
                        </div>
                        <div>
                            <label for="base_note" class="block text-[13px] font-bold text-gray-700 mb-2">
                                <span class="inline-block w-2 h-2 rounded-full bg-amber-500 mr-1.5 mb-0.5"></span>Base Note
                            </label>
                            <input id="base_note" name="base_note" type="text" value="<?php echo e(old('base_note', $product->base_note)); ?>" placeholder="e.g. Sandalwood"
                                   class="w-full px-4 py-3 text-[14px] font-medium text-gray-900 bg-gray-50/50 border border-gray-200 rounded-xl transition-all duration-300
                                          focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                        </div>
                    </div>
                </div>

                
                <div>
                    <h2 class="text-[11px] font-black text-gray-400 uppercase tracking-widest mb-5 border-b border-gray-100 pb-2 flex items-center justify-between">
                        Promotions
                        <span class="text-[9px] font-bold bg-amber-50 text-amber-600 px-2 py-0.5 rounded-full border border-amber-200">Marketing</span>
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                        <div>
                            <label for="promotion_type" class="block text-[13px] font-bold text-gray-700 mb-2">Promotion Type</label>
                            <select id="promotion_type" name="promotion_type"
                                    class="w-full px-4 py-3 text-[14px] font-medium text-gray-900 bg-gray-50/50 border rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 cursor-pointer border-gray-200">
                                <option value="">None</option>
                                <option value="discount_percent" <?php echo e(old('promotion_type', $product->promotion_type) == 'discount_percent' ? 'selected' : ''); ?>>Percentage Discount (%)</option>
                                <option value="bogo" <?php echo e(old('promotion_type', $product->promotion_type) == 'bogo' ? 'selected' : ''); ?>>Buy 1 Free 1 (1+1)</option>
                            </select>
                        </div>
                        <div>
                            <label for="promotion_value" class="block text-[13px] font-bold text-gray-700 mb-2">Discount Value (%)</label>
                            <input id="promotion_value" name="promotion_value" type="number" min="1" max="100" value="<?php echo e(old('promotion_value', $product->promotion_value)); ?>" placeholder="e.g. 20"
                                   class="w-full px-4 py-3 text-[14px] font-medium text-gray-900 bg-gray-50/50 border rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 border-gray-200">
                        </div>
                        <div class="lg:col-span-2">
                            <label for="promotion_badge" class="block text-[13px] font-bold text-gray-700 mb-2">Badge Text</label>
                            <input id="promotion_badge" name="promotion_badge" type="text" value="<?php echo e(old('promotion_badge', $product->promotion_badge)); ?>" placeholder="e.g. 20% OFF or 1+1"
                                   class="w-full px-4 py-3 text-[14px] font-medium text-gray-900 bg-gray-50/50 border rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 border-gray-200">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="promotion_starts_at" class="block text-[13px] font-bold text-gray-700 mb-2">Promotion Starts</label>
                            <input id="promotion_starts_at" name="promotion_starts_at" type="datetime-local" value="<?php echo e(old('promotion_starts_at', isset($product->promotion_starts_at) ? $product->promotion_starts_at->format('Y-m-d\TH:i') : '')); ?>"
                                   class="w-full px-4 py-3 text-[14px] font-medium text-gray-900 bg-gray-50/50 border rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 border-gray-200">
                        </div>
                        <div>
                            <label for="promotion_ends_at" class="block text-[13px] font-bold text-gray-700 mb-2">Promotion Ends</label>
                            <input id="promotion_ends_at" name="promotion_ends_at" type="datetime-local" value="<?php echo e(old('promotion_ends_at', isset($product->promotion_ends_at) ? $product->promotion_ends_at->format('Y-m-d\TH:i') : '')); ?>"
                                   class="w-full px-4 py-3 text-[14px] font-medium text-gray-900 bg-gray-50/50 border rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 border-gray-200">
                        </div>
                    </div>
                </div>

                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2">
                        <label for="description" class="block text-[13px] font-bold text-gray-700 mb-2">Description <span class="text-gray-400 font-normal text-[11px]">(optional)</span></label>
                        <textarea id="description" name="description" rows="4"
                                  class="w-full px-4 py-3 text-[14px] font-medium text-gray-900 bg-gray-50/50 border border-gray-200 rounded-xl transition-all duration-300
                                         focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 resize-none"><?php echo e(old('description', $product->description)); ?></textarea>
                    </div>
                    <div>
                        <label class="block text-[13px] font-bold text-gray-700 mb-4">Product Status</label>
                        <div class="flex flex-col gap-3">
                            <label class="relative inline-flex items-center cursor-pointer group">
                                <input type="checkbox" name="is_active" value="1" class="sr-only peer" <?php echo e(old('is_active', $product->is_active) ? 'checked' : ''); ?>>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                <span class="ml-3 text-[13px] font-bold text-gray-700 group-hover:text-blue-600 transition-colors">Active for Sale</span>
                            </label>
                            <p class="text-[11px] text-gray-400 leading-relaxed italic mt-1">Inactive products are hidden from resellers but remain in the inventory catalog.</p>
                        </div>
                    </div>
                </div>

                
                <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100">
                    <a href="<?php echo e(route('admin.products.index')); ?>"
                       class="px-5 py-3 text-[13px] font-bold text-gray-500 hover:text-gray-700 bg-white border border-gray-200 hover:bg-gray-50 rounded-xl transition-all duration-300 hover:shadow-sm">
                        Cancel
                    </a>
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700
                                   text-white text-[13px] font-bold rounded-xl shadow-md shadow-blue-500/30 transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/40 hover:-translate-y-0.5
                                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Update Product
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
<?php /**PATH C:\Users\USER\Documents\Project Code\rpims\resources\views/admin/products/edit.blade.php ENDPATH**/ ?>