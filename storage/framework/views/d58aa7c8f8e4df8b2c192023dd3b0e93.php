<?php if($errors->any()): ?>
    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <p><strong style="color:red;"><?php echo e($error); ?></strong></p>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
<?php endif; ?>

<?php if(session()->has('success')): ?>  
      <p><strong style="color:green;"><?php echo e(session()->get('success')); ?></strong></p>
<?php endif; ?>

<?php if(session()->has('error')): ?>  
      <p><strong style="color:red;"><?php echo e(session()->get('error')); ?></strong></p>
<?php endif; ?><?php /**PATH E:\xampp\htdocs\FeatureDesk\resources\views/admin/includes/success.blade.php ENDPATH**/ ?>