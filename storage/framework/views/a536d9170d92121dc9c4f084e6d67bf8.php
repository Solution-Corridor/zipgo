<!DOCTYPE html>
<html lang="en">
<?php $__env->startSection('title'); ?>
Users
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
        <!-- end Sidebar -->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"> Users</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6"></div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">

                            <div class="card card-primary card-outline card-outline-tabs">

                                <?php echo $__env->make('admin.includes.success', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                                <div class="card-body">

                                    <table id="example1" class="table table-bordered table-striped example1">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>UserName</th>
                                                <th>WhatsApp</th>
                                                <th>Ref</th>
                                                <th>Invested</th>
                                                <th>Withdraws</th>
                                                <th>Balance</th>
                                                <th>Plans</th>
                                                <th>Status</th>
                                                <th>Since</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($u->id); ?></td>
                                                <td><a target="_blank" href="<?php echo e(route('userDetails', ['id' => $u->id])); ?>"><?php echo e($u->username); ?>

                                                        <small class="d-block text-muted"><?php echo e($u->phone); ?></small>
                                                    </a>
                                                </td>
                                                <td>
                                                    <?php if($u->whatsapp): ?>
                                                    <a href="https://wa.me/<?php echo e($u->whatsapp); ?>" target="_blank" class="btn btn-success btn-sm">
                                                        <i class="fab fa-whatsapp"></i> <?php echo e($u->whatsapp); ?>

                                                    </a>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($u->referrer): ?>
                                                    <a target="_blank" href="<?php echo e(route('userDetails', $u->referrer->id)); ?>">
                                                        <?php echo e($u->referrer->username ?? '—'); ?>

                                                        <small class="d-block text-muted"><?php echo e($u->referrer->phone ?? '—'); ?></small>
                                                    </a>
                                                    <?php else: ?>
                                                    <span class="text-muted">—</span>
                                                    <?php endif; ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $total_invested = $u->payments()->where('status', 'approved')->sum('amount');
                                                    ?>
                                                    <?php echo e(number_format($total_invested)); ?>

                                                </td>

                                                <td>
                                                    <?php
                                                    $total_withdraw = $u->withdraws()->where('status', 'approved')->sum('amount');
                                                    ?>
                                                    <?php echo e(number_format($total_withdraw)); ?>

                                                </td>
                                                <td><?php echo e(number_format($u->balance ?? 0)); ?></td>



                                                <td>
                                                    <?php if($u->active_plans_count > 0): ?>
                                                    <span class="badge bg-success"><?php echo e($u->active_plans_count); ?></span>
                                                    <?php else: ?>
                                                    <span class="badge bg-secondary">0</span>
                                                    <?php endif; ?>
                                                </td>

                                                <td>
                                                    <?php switch($u->status):
                                                        case (0): ?>
                                                            <span class="badge bg-warning">Pending</span>
                                                            <?php break; ?>
                                                        <?php case (1): ?>
                                                            <span class="badge bg-success">Active</span>
                                                            <?php break; ?>
                                                        <?php case (2): ?>
                                                            <span class="badge bg-danger">Suspended</span>
                                                            <?php break; ?>
                                                    <?php endswitch; ?>
                                                </td>

                                                <td><?php echo e(\Carbon\Carbon::parse($u->created_at)->format('d M y • h:i:s A')); ?></td>

                                                <td>
                                                    <div class="d-flex align-items-center" style="gap:6px;">

                                                        <form action="<?php echo e(route('deleteUser', ['id' => $u->id])); ?>" method="POST">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('DELETE'); ?>
                                                            <button type="submit" class="btn btn-danger btn-xs" title="Delete"
                                                                onclick="return confirm('Are you sure to delete this user?')">
                                                                <i class="fa fa-trash-alt"></i>
                                                            </button>
                                                        </form>

                                                        <a href="<?php echo e(route('editUser', ['id' => $u->id])); ?>" class="btn btn-primary btn-xs" title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>

                                                        <?php if($u->status == 0): ?>
                                                        <a href="<?php echo e(route('activateUser', ['id' => $u->id])); ?>" class="btn btn-success btn-xs" title="Activate">
                                                            <i class="fas fa-check-circle"></i>
                                                        </a>
                                                        <?php endif; ?>

                                                        <?php if($u->status == 1): ?>
                                                        <a href="<?php echo e(route('suspendUser', ['id' => $u->id])); ?>" class="btn btn-warning btn-xs" title="Suspend">
                                                            <i class="fas fa-pause"></i>
                                                        </a>
                                                        <?php endif; ?>

                                                        <?php if($u->status == 2): ?>
                                                        <a href="<?php echo e(route('activateUser', ['id' => $u->id])); ?>" class="btn btn-success btn-xs" title="Activate">
                                                            <i class="fas fa-check-circle"></i>
                                                        </a>
                                                        <?php endif; ?>

                                                        <form action="<?php echo e(route('admin.force-logout', $u->id)); ?>" method="POST">
                                                            <?php echo csrf_field(); ?>
                                                            <button type="submit" class="btn btn-dark btn-xs"
                                                                title="Force Logout (end all sessions)"
                                                                onclick="return confirm('Force logout this user from all devices? They will be logged out immediately.')">
                                                                <i class="fas fa-sign-out-alt"></i>
                                                            </button>
                                                        </form>

                                                    </div>
                                                </td>

                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
            </section>

            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!------ Start Footer -->
        <?php echo $__env->make('admin.includes.version', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <!------ end Footer -->

    </div>
    <!-- ./wrapper -->
    <!------ Start Footer links-->
    <?php echo $__env->make('admin.includes.footer_links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <!------ end Footer links -->

</body>

</html><?php /**PATH E:\xampp\htdocs\FeatureDesk\resources\views/admin/users.blade.php ENDPATH**/ ?>