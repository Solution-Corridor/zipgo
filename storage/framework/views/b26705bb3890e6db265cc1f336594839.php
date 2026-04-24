<?php
$pendingPackageRequests = DB::table('payments')->where('status', 'pending')->count();
$pendingWithdrawRequests = DB::table('withdrawals')->where('status', 'pending')->count();
$pendingComplaints = DB::table('complaints')->where('status', 'pending')->count();
$pendingKyc = DB::table('kyc_verifications')
->whereIn('status', ['pending', 'submitted'])
->count();
$pendingOrders = DB::table('mk_orders')->where('status', 'Pending')->count();
$totalOrders = DB::table('mk_orders')->count();

$blogsCount = DB::table('blogs')->count();
$productsCount = DB::table('mk_products')->count();
$categoriesCount = DB::table('mk_categories')->count();
$subCategoriesCount = DB::table('mk_sub_categories')->count();
?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-green elevation-4">
    <!-- Brand Logo -->
    <a href="/dashboard" class="brand-link">
        <img src="/assets/images/favicon.png" class="logo-one" alt="Logo" height="30">
        <span class="brand-text font-weight-light"><strong>Feature Desk</strong></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="/dashboard" class="nav-link <?php echo e(request()->segment(1) == 'dashboard' ? 'active' : ''); ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/user-dashboard" class="nav-link <?php echo e(request()->segment(1) == 'user-dashboard' ? 'active' : ''); ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>User Dashboard</p>
                    </a>
                </li>
                <?php if(Auth::user()->type == '0'): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('package_requests')); ?>" class="nav-link <?php echo e(request()->segment(1) == 'package-requests' ? 'active' : ''); ?>">
                        <i class="nav-icon fas fa-box"></i>
                        <p>
                            Investments
                            <?php if($pendingPackageRequests > 0): ?>
                            <span class="badge badge-warning right"><?php echo e($pendingPackageRequests); ?></span>
                            <?php endif; ?>
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo e(route('withdraw_requests')); ?>" class="nav-link <?php echo e(in_array(request()->segment(1), ['withdraw-requests', 'edit-withdraw']) ? 'active' : ''); ?>">
                        <i class="nav-icon fas fa-money-bill-wave"></i>
                        <p>
                            Withdrawals
                            <?php if($pendingWithdrawRequests > 0): ?>
                            <span class="badge badge-warning right"><?php echo e($pendingWithdrawRequests); ?></span>
                            <?php endif; ?>
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo e(route('all_complaints')); ?>" class="nav-link <?php echo e(request()->segment(1) == 'all-complaints' ? 'active' : ''); ?>">
                        <i class="nav-icon fas fa-exclamation-triangle"></i>
                        <p>
                            Complaints
                            <?php if($pendingComplaints > 0): ?>
                            <span class="badge badge-warning right"><?php echo e($pendingComplaints); ?></span>
                            <?php endif; ?>
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/transactions" class="nav-link <?php echo e(request()->segment(1) == 'transactions' ? 'active' : ''); ?>">
                        <i class="nav-icon fas fa-exchange-alt"></i>
                        <p>Transactions</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo e(route('running_packages')); ?>" class="nav-link <?php echo e(request()->segment(1) == 'running-packages' ? 'active' : ''); ?>">
                        <i class="nav-icon fas fa-spinner"></i>
                        <p>Running Packages</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/users" class="nav-link <?php echo e(in_array(request()->segment(1), ['users', 'user-details', 'edit_user']) ? 'active' : ''); ?>">
                        <i class="nav-icon fa fa-user"></i>
                        <p>Users</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo e(route('kyc_verification')); ?>" class="nav-link <?php echo e(request()->segment(1) == 'kyc' ? 'active' : ''); ?>">
                        <i class="nav-icon fa fa-user"></i>
                        <p>
                            KYC
                            <?php if($pendingKyc > 0): ?>
                            <span class="badge badge-warning right"><?php echo e($pendingKyc); ?></span>
                            <?php endif; ?>
                        </p>
                    </a>
                </li>

                <li class="nav-header">SETTINGS</li>

                <li class="nav-item">
                    <a href="<?php echo e(route('tasks')); ?>" class="nav-link <?php echo e(request()->segment(1) == 'tasks' ? 'active' : ''); ?>">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>Tasks</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo e(route('packages.index')); ?>" class="nav-link <?php echo e(request()->segment(1) == 'packages' ? 'active' : ''); ?>">
                        <i class="nav-icon fab fa-blogger"></i>
                        <p>Packages</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo e(route('payment-methods.index')); ?>" class="nav-link <?php echo e(request()->segment(1) == 'payment-methods' ? 'active' : ''); ?>">
                        <i class="nav-icon fas fa-credit-card"></i>
                        <p>Payment Methods</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo e(route('important_note')); ?>" class="nav-link <?php echo e(request()->segment(1) == 'important-note' ? 'active' : ''); ?>">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>Important Note</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo e(route('mobile_app_version')); ?>" class="nav-link <?php echo e(request()->segment(1) == 'mob-app-version' ? 'active' : ''); ?>">
                        <i class="nav-icon fa fa-mobile"></i>
                        <p>Mobile App Version</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo e(route('dollar_price')); ?>" class="nav-link <?php echo e(request()->segment(1) == 'dollar-price' ? 'active' : ''); ?>">
                        <i class="nav-icon fa fa-dollar-sign"></i>
                        <p>Dollar Price</p>
                    </a>
                </li>

                <?php endif; ?>
                <!-- if market user dataenty or admin then show market section -->
                <?php if(Auth::user()->type == '2' || Auth::user()->type == '0'): ?>

                <li class="nav-header">MARKET</li>
                <!-- Blogs Menu (Fixed Structure) -->
                <li class="nav-item <?php echo e(in_array(request()->segment(2), ['add_blogs','blogs_list','edit_blog','upload_images']) ? 'menu-open' : ''); ?>">
                    <a href="#" class="nav-link <?php echo e(in_array(request()->segment(1), ['add_blog','blogs_list','edit_blog','upload_images']) ? 'active' : ''); ?>">
                        <i class="nav-icon fa fa-blog"></i>
                        <p>
                            Blogs
                            <i class="fas fa-angle-left right"></i>
                            <span class="badge badge-info right mr-3"><?php echo e($blogsCount); ?></span>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo e(route('market.add_blogs')); ?>" class="nav-link <?php echo e(request()->segment(2) == 'add_blogs' ? 'active' : ''); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Blog</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(route('market.blogs_list')); ?>" class="nav-link <?php echo e(in_array(request()->segment(2), ['blogs_list','edit_blog']) ? 'active' : ''); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Blogs Listing</p>
                            </a>
                        </li>
                    </ul>

                    <!-- Products Submenu -->
                <li class="nav-item has-treeview <?php echo e(in_array(request()->segment(2), ['add_product','edit_product','all_products']) ? 'menu-open' : ''); ?>">
                    <a href="#" class="nav-link <?php echo e(in_array(request()->segment(2), ['add_product','edit_product','all_products']) ? 'active' : ''); ?>">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>
                            Products
                            <i class="fas fa-angle-left right"></i>
                            <span class="badge badge-info right mr-3"><?php echo e($productsCount); ?></span>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo e(route('market.add_products')); ?>" class="nav-link <?php echo e(request()->segment(2) == 'add_product' ? 'active' : ''); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Product</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(route('market.all_products')); ?>" class="nav-link <?php echo e(request()->segment(2) == 'all_products' ? 'active' : ''); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Products</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="<?php echo e(route('market.add_category')); ?>" class="nav-link <?php echo e(in_array(request()->segment(2), ['add_category','edit_category']) ? 'active' : ''); ?>">
                        <i class="nav-icon fa fa-layer-group"></i>
                        <p>Categories
                            <span class="badge badge-info right"><?php echo e($categoriesCount); ?></span>
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo e(route('market.add_sub_category')); ?>" class="nav-link <?php echo e(in_array(request()->segment(2), ['add_sub_category','edit_sub_category']) ? 'active' : ''); ?>">
                        <i class="nav-icon fa fa-stream"></i>
                        <p>Sub Categories
                            <span class="badge badge-info right"><?php echo e($subCategoriesCount); ?></span>
                        </p>
                    </a>
                </li>
                <?php endif; ?>

                <?php if(Auth::user()->type == '0'): ?>

                <li class="nav-item">
                    <a href="<?php echo e(route('market.orders')); ?>" class="nav-link <?php echo e(request()->segment(2) == 'orders' ? 'active' : ''); ?>">
                        <i class="nav-icon fa fa-envelope"></i>
                        <p>Orders
                            <span class="badge badge-info right"><?php echo e($totalOrders); ?></span>
                            <?php if($pendingOrders > 0): ?>
                            <span class="badge badge-warning right"><?php echo e($pendingOrders); ?></span>
                            <?php endif; ?>
                        </p>
                    </a>
                </li>
                <?php endif; ?>
                <li class="nav-item" style="height: 60px;"></li>

            </ul>
            </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside><?php /**PATH E:\xampp\htdocs\FeatureDesk\resources\views/admin/includes/sidebar.blade.php ENDPATH**/ ?>