
<?php if(session()->has('success')): ?>
    <div style="
        display: flex; 
        align-items: center; 
        gap: 12px; 
        padding: 12px 16px; 
        background-color: rgba(16, 185, 129, 0.15); 
        border: 1px solid rgba(16, 185, 129, 0.4); 
        border-radius: 16px; 
        color: rgb(134, 239, 172); 
        font-size: 14px; 
        margin-bottom: 16px;
    ">
        <svg xmlns="http://www.w3.org/2000/svg" style="width: 20px; height: 20px; flex-shrink: 0;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 01-18 0 9 9 0 0118 0z" />
        </svg>
        <p style="font-weight: 500; margin: 0;"><?php echo e(session('success')); ?></p>
    </div>
<?php endif; ?>


<?php if($errors->any() || session()->has('error')): ?>
    <div style="
        display: flex; 
        align-items: center; 
        gap: 12px; 
        padding: 12px 16px; 
        background-color: rgba(239, 68, 68, 0.15); 
        border: 1px solid rgba(239, 68, 68, 0.4); 
        border-radius: 16px; 
        color: rgb(252, 165, 165); 
        font-size: 14px; 
        margin-bottom: 16px;
    ">
        <svg xmlns="http://www.w3.org/2000/svg" style="width: 20px; height: 20px; flex-shrink: 0;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 01-18 0 9 9 0 0118 0z" />
        </svg>
        <div style="flex: 1;">
            <?php if($errors->any()): ?>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <p style="font-weight: 500; margin: 0 0 4px 0;"><?php echo e($error); ?></p>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            <?php if(session()->has('error')): ?>
                <p style="font-weight: 500; margin: 0;"><?php echo e(session('error')); ?></p>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?><?php /**PATH E:\xampp\htdocs\FeatureDesk\resources\views/includes/success.blade.php ENDPATH**/ ?>