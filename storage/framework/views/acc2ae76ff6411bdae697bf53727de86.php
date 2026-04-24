<!DOCTYPE html>
<html lang="en">
<?php $__env->startSection('title'); ?>
Manage Services
<?php $__env->stopSection(); ?>
<!-- Start top links -->
<?php echo $__env->make('admin.includes.headlinks', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
 <div class="wrapper">
  <!-- Start navbar -->
  <?php echo $__env->make('admin.includes.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  <!-- end navbar -->

  <!-- Start Sidebar -->
  <?php echo $__env->make('admin.includes.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Manage Services</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="<?php echo e(route('services.create')); ?>" class="btn btn-primary">+ Add New Service</a>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-light">All Services</div>
                        <div class="card-body">
                            <?php echo $__env->make('admin.includes.success', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>   <!-- your existing success partial -->

                            <table class="table table-bordered table-striped">
                                <thead>
    <tr>
        <th>ID</th>
        <th>Image</th>
        <th>Name</th>
        <th>Slug</th>
        <th>Price (Rs.)</th>
        <th>Status</th>      
        <th>Actions</th>
    </tr>
</thead>
<tbody>
    <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <tr>
        <td><?php echo e($service->id); ?></td>
        <td><img src="/<?php echo e($service->pic); ?>" width="60"></td>
        <td><?php echo e($service->name); ?></td>
        <td><?php echo e($service->slug); ?></td>
        <td><?php echo e(number_format($service->price)); ?></td>
        <td>
    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
        <input type="checkbox"
               class="custom-control-input toggle-status"
               id="serviceSwitch<?php echo e($service->id); ?>"
               data-id="<?php echo e($service->id); ?>"
               <?php echo e($service->is_active ? 'checked' : ''); ?>>
        <label class="custom-control-label" for="serviceSwitch<?php echo e($service->id); ?>"></label>
    </div>
</td>
        <td>
            <a href="<?php echo e(route('services.edit', $service->id)); ?>" class="btn btn-sm btn-warning">Edit</a>
            <form action="<?php echo e(route('services.destroy', $service->id)); ?>" method="POST" style="display:inline-block;">
                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
            </form>
        </td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <tr><td colspan="7" class="text-center">No services found.</td></tr>
    <?php endif; ?>
</tbody>
                            </table>

                            <?php echo e($services->links()); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php echo $__env->make('admin.includes.version', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<!------ end Footer -->

</div>
<!-- ./wrapper -->
<!------ Start Footer links-->
<?php echo $__env->make('admin.includes.footer_links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<!------ end Footer links -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.toggle-status').click(function() {
        var btn = $(this);
        var id = btn.data('id');
        $.ajax({
            url: '/services/' + id + '/toggle-active',
            type: 'POST',
            data: {
                _token: '<?php echo e(csrf_token()); ?>',
                _method: 'POST'
            },
            success: function(response) {
                if (response.success) {
                    if (response.is_active) {
                        btn.prop('checked', true);
                    } else {
                        btn.prop('checked', false);
                    }
                }
            },
            error: function() {
                alert('Error toggling status');
            }
        });
    });
});
</script>

</body>
</html><?php /**PATH E:\xampp\htdocs\zipGo\resources\views/admin/services/index.blade.php ENDPATH**/ ?>