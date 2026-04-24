<!DOCTYPE html>
<html lang="en">
<?php $__env->startSection('title'); ?>
Manage Cities
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.includes.headlinks', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
    <?php echo $__env->make('admin.includes.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('admin.includes.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Manage Cities</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="<?php echo e(route('cities.create')); ?>" class="btn btn-primary">+ Add New City</a>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-light">All Cities</div>
                            <div class="card-body">
                                <?php echo $__env->make('admin.includes.success', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                                <table class="table table-bordered table-striped example1" id="example1">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Image</th>
                                            <th>City Name</th>
                                            <th>Slug</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e($city->id); ?></td>
                                            <td>
                                                <?php if($city->pic): ?>
                                                    <img src="/<?php echo e($city->pic); ?>" width="60" height="60" style="object-fit: cover;">
                                                <?php else: ?>
                                                    <img src="/assets/images/favicon.png" width="60">
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e($city->name); ?></td>
                                            <td><?php echo e($city->slug); ?></td>
                                            <td>
                                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                    <input type="checkbox"
                                                           class="custom-control-input toggle-city-status"
                                                           id="citySwitch<?php echo e($city->id); ?>"
                                                           data-id="<?php echo e($city->id); ?>"
                                                           <?php echo e($city->is_active ? 'checked' : ''); ?>>
                                                    <label class="custom-control-label" for="citySwitch<?php echo e($city->id); ?>"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="<?php echo e(route('cities.edit', $city->id)); ?>" class="btn btn-sm btn-warning">Edit</a>
                                                <form action="<?php echo e(route('cities.destroy', $city->id)); ?>" method="POST" style="display:inline-block;">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this city?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr><td colspan="6" class="text-center">No cities found.</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>

                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <?php echo $__env->make('admin.includes.version', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>
<?php echo $__env->make('admin.includes.footer_links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<!-- AJAX Toggle Script -->
<script>
$(document).ready(function() {
    $('.toggle-city-status').on('change', function() {
        var checkbox = $(this);
        var id = checkbox.data('id');
        var originalState = checkbox.prop('checked');

        $.ajax({
            url: '/cities/' + id + '/toggle-active',
            type: 'POST',
            data: {
                _token: '<?php echo e(csrf_token()); ?>',
                _method: 'POST'
            },
            success: function(response) {
                if (!response.success) {
                    checkbox.prop('checked', originalState);
                    alert('Failed to update status');
                }
            },
            error: function() {
                checkbox.prop('checked', originalState);
                alert('Error toggling status');
            }
        });
    });
});
</script>
</body>
</html><?php /**PATH E:\xampp\htdocs\zipGo\resources\views/admin/cities/index.blade.php ENDPATH**/ ?>