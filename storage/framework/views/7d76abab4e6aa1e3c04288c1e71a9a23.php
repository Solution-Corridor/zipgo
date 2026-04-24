<!DOCTYPE html>
<html lang="en">

<?php $__env->startSection('title'); ?>
Running Packages - Admin Panel
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
                            <h1 class="m-0">Running Packages</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Running Packages</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">

                            <div class="card">
                                <?php echo $__env->make('includes.success', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                                
                                <div class="card-header">
                                    <ul class="nav nav-tabs card-header-tabs" id="package-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="running-tab" data-toggle="tab" href="#running" role="tab" aria-controls="running" aria-selected="true">
                                                Running Packages
                                                <span class="badge badge-success ml-1"><?php echo e(count($runningPackages)); ?></span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="expired-tab" data-toggle="tab" href="#expired" role="tab" aria-controls="expired" aria-selected="false">
                                                Expired Packages
                                                <span class="badge badge-danger ml-1"><?php echo e(count($expiredPackages)); ?></span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                
                                <div class="card-body">
                                    <div class="tab-content" id="package-tabContent">

                                        
                                        <div class="tab-pane fade show active" id="running" role="tabpanel" aria-labelledby="running-tab">
                                            <div class="table-responsive">
                                                <table class="example1 table table-bordered table-hover table-striped" id="example1">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>User</th>
                                                            <th>Package</th>
                                                            <th>Investment</th>
                                                            <th>Daily Profit Range</th>
                                                            <th>Duration</th>
                                                            <th>Approved</th>
                                                            <th>Expires</th>
                                                            <th>Days Left</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $__empty_1 = true; $__currentLoopData = $runningPackages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                        <tr>
                                                            <td><?php echo e($package->id); ?></td>

                                                            <td>
                                                                <?php if($package->user): ?>
                                                                <a target="_blank" href="<?php echo e(route('userDetails', ['id' => $package->user->id])); ?>">
                                                                    <small class="d-block text-muted">ID: <?php echo e($package->user->id); ?></small>
                                                                    <?php echo e($package->user->username ?? 'N/A'); ?> <br>
                                                                    <?php echo e($package->user->phone ?? 'N/A'); ?>

                                                                </a>
                                                                <?php else: ?>
                                                                <span class="text-muted">— (Deleted User)</span>
                                                                <?php endif; ?>
                                                            </td>

                                                            <td>
                                                                <strong><?php echo e($package->package->name ?? '—'); ?></strong>
                                                                <small class="d-block text-muted">ID: <?php echo e($package->plan_id); ?></small>
                                                            </td>

                                                            <td class="text-bold">
                                                                <?php echo e(number_format($package->amount, 0)); ?>

                                                            </td>

                                                            <td>
                                                                <?php echo e(number_format($package->package->daily_profit_min ?? 0, 0)); ?> —
                                                                <?php echo e(number_format($package->package->daily_profit_max ?? 0, 0)); ?>

                                                            </td>

                                                            <td>
                                                                <?php echo e($package->package->duration_days ?? '—'); ?> days
                                                            </td>

                                                            <td>
                                                                <?php echo e($package->approved_at 
                                                                    ? \Carbon\Carbon::parse($package->approved_at)->format('d M Y . h:i A') 
                                                                    : '—'); ?>

                                                            </td>

                                                            <td class="<?php echo e(\Carbon\Carbon::parse($package->expires_at)->isPast() ? 'text-danger' : ''); ?>">
                                                                <?php echo e($package->expires_at 
                                                                    ? \Carbon\Carbon::parse($package->expires_at)->format('d M Y . h:i A') 
                                                                    : '—'); ?>

                                                            </td>

                                                            <td class="font-weight-bold">
                                                                <?php
                                                                    $daysLeft = now()->diffInDays($package->expires_at, false);
                                                                    $wholeDays = floor($daysLeft);
                                                                ?>

                                                                <?php if($wholeDays > 0): ?>
                                                                    <span class="badge badge-success"><?php echo e($wholeDays); ?></span>
                                                                <?php elseif($wholeDays === 0): ?>
                                                                    <span class="badge badge-warning">Expires today</span>
                                                                <?php else: ?>
                                                                    <span class="badge badge-danger"><?php echo e(abs($wholeDays)); ?></span>
                                                                <?php endif; ?>
                                                            </td>

                                                            <td class="d-flex align-items-center gap-1">

    
    <a href="<?php echo e(route('plan.edit', $package->id)); ?>" 
       class="btn btn-xs btn-primary m-auto" 
       title="Edit">
        <i class="fa fa-edit"></i>
    </a>

    
    <?php if(!\Carbon\Carbon::parse($package->expires_at)->isPast()): ?>
        <form action="<?php echo e(route('plan.expire', $package->id)); ?>" 
              method="POST" 
              style="display:inline-block; margin:0;">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <button type="submit" 
                    class="btn btn-xs btn-danger" 
                    title="Expire"
                    onclick="return confirm('Are you sure?')">
                <i class="fa fa-times"></i>
            </button>
        </form>
    <?php else: ?>
        <span class="badge badge-secondary">
            <i class="fa fa-check"></i>
        </span>
    <?php endif; ?>

</td>
                                                        </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                        <tr>
                                                            <td colspan="10" class="text-center text-muted py-5">
                                                                No running/active packages at the moment
                                                            </td>
                                                        </tr>
                                                        <?php endif; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        
                                        <div class="tab-pane fade" id="expired" role="tabpanel" aria-labelledby="expired-tab">
                                            <div class="table-responsive">
                                                <table class="example1 table table-bordered table-hover table-striped">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>User</th>
                                                            <th>Package</th>
                                                            <th>Investment</th>
                                                            <th>Daily Profit Range</th>
                                                            <th>Duration</th>
                                                            <th>Approved</th>
                                                            <th>Expires</th>
                                                            <th>Days Left</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $__empty_1 = true; $__currentLoopData = $expiredPackages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                        <tr>
                                                            <td><?php echo e($package->id); ?></td>

                                                            <td>
                                                                <?php if($package->user): ?>
                                                                <a target="_blank" href="<?php echo e(route('userDetails', ['id' => $package->user->id])); ?>">
                                                                    <small class="d-block text-muted">ID: <?php echo e($package->user->id); ?></small>
                                                                    <?php echo e($package->user->username ?? 'N/A'); ?> <br>
                                                                    <?php echo e($package->user->phone ?? 'N/A'); ?>

                                                                </a>
                                                                <?php else: ?>
                                                                <span class="text-muted">— (Deleted User)</span>
                                                                <?php endif; ?>
                                                            </td>

                                                            <td>
                                                                <strong><?php echo e($package->package->name ?? '—'); ?></strong>
                                                                <small class="d-block text-muted">ID: <?php echo e($package->plan_id); ?></small>
                                                            </td>

                                                            <td class="text-bold">
                                                                <?php echo e(number_format($package->amount, 0)); ?>

                                                            </td>

                                                            <td>
                                                                <?php echo e(number_format($package->package->daily_profit_min ?? 0, 0)); ?> —
                                                                <?php echo e(number_format($package->package->daily_profit_max ?? 0, 0)); ?>

                                                            </td>

                                                            <td>
                                                                <?php echo e($package->package->duration_days ?? '—'); ?> days
                                                            </td>

                                                            <td>
                                                                <?php echo e($package->approved_at 
                                                                    ? \Carbon\Carbon::parse($package->approved_at)->format('d M Y . h:i A') 
                                                                    : '—'); ?>

                                                            </td>

                                                            <td class="<?php echo e(\Carbon\Carbon::parse($package->expires_at)->isPast() ? 'text-danger' : ''); ?>">
                                                                <?php echo e($package->expires_at 
                                                                    ? \Carbon\Carbon::parse($package->expires_at)->format('d M Y . h:i A') 
                                                                    : '—'); ?>

                                                            </td>

                                                            <td class="font-weight-bold">
                                                                <?php
                                                                    $daysLeft = now()->diffInDays($package->expires_at, false);
                                                                    $wholeDays = floor($daysLeft);
                                                                ?>

                                                                <?php if($wholeDays > 0): ?>
                                                                    <span class="badge badge-success"><?php echo e($wholeDays); ?></span>
                                                                <?php elseif($wholeDays === 0): ?>
                                                                    <span class="badge badge-warning">Expires today</span>
                                                                <?php else: ?>
                                                                    <span class="badge badge-danger"><?php echo e(abs($wholeDays)); ?></span>
                                                                <?php endif; ?>
                                                            </td>

                                                            <td>
                                                                
                                                                <a href="<?php echo e(route('plan.edit', $package->id)); ?>" 
       class="btn btn-xs btn-primary m-auto" 
       title="Edit">
        <i class="fa fa-edit"></i>
    </a>
                                                               
                                                            </td>
                                                        </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                        <tr>
                                                            <td colspan="10" class="text-center text-muted py-5">
                                                                No expired packages at the moment
                                                            </td>
                                                        </tr>
                                                        <?php endif; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
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

</body>

</html><?php /**PATH E:\xampp\htdocs\FeatureDesk\resources\views/admin/running_packages.blade.php ENDPATH**/ ?>