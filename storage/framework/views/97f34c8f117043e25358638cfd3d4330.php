<!DOCTYPE html>
<html lang="en">
<?php $__env->startSection('title'); ?>
Dashboard
<?php $__env->stopSection(); ?>

<!-- Start top links -->
<?php echo $__env->make('admin.includes.headlinks', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<!-- end top links -->

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
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-3">
                        <div class="col-12">
                            <h1 class="m-0 font-weight-bold text-dark">Dashboard</h1>                            
                        </div>
                    </div>
                </div>
            </section>

           
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <!-- ==================== SERVICE FEES ==================== -->
                    <div class="row">
                        <div class="col-12 mb-4">
                            <h5 class="font-weight-bold text-muted mb-3">Service Fees</h5>
                            <div class="row">
                                <!-- Total Service Fee Collected -->
                                <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
                                    <div class="card shadow-sm border-0 h-100 hover-lift position-relative">
                                        <span class="badge badge-danger position-absolute"
                                            style="top: 10px; right: 10px; font-size: 12px; padding: 6px 10px;">
                                            <?php echo e($total_users ?? 0); ?>

                                        </span>
                                        
                                    </div>
                                </div>

                                
                            </div>
                        </div>
                    </div>

                   
                    

                    

                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
             
        </div>
        <!-- /.content-wrapper -->

        <!-- Footer -->
        <?php echo $__env->make('admin.includes.version', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <!-- /.footer -->

    </div>
    <!-- ./wrapper -->

    <!-- Footer links / scripts -->
    <?php echo $__env->make('admin.includes.footer_links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    

</body>

</html><?php /**PATH E:\xampp\htdocs\zipGo\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>