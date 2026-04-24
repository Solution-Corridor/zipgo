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
                            <h1 class="m-0 font-weight-bold text-dark">Dashboard Overview</h1>
                            <small class="text-muted">Quick financial & activity snapshot • <?php echo e(date('F j, Y')); ?></small>
                        </div>
                    </div>
                </div>
            </section>

            <?php if(Auth::user()->type == '0'): ?>
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
                                            <?php echo e($serviceFeeCount ?? 0); ?>

                                        </span>
                                        <div class="card-body d-flex align-items-center">
                                            <div class="icon-wrapper bg-primary-soft text-primary mr-3">
                                                <i class="fas fa-coins fa-2x"></i>
                                            </div>
                                            <div>
                                                <div class="text-uppercase text-muted small font-weight-bold">
                                                    Service Fee Collected
                                                </div>
                                                <a href="<?php echo e(route('service.fee.collection')); ?>" class="h4 mb-0 text-dark d-block">
                                                    <?php echo e(number_format($serviceFeeSum ?? 0)); ?> PKR
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Service Paid / Fees Deducted -->
                                <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
                                    <div class="card shadow-sm border-0 h-100 hover-lift position-relative">
                                        <span class="badge badge-success position-absolute" style="top: 10px; right: 10px; font-size: 12px;"><?php echo e($servicePaidCount ?? 0); ?></span>
                                        <div class="card-body d-flex align-items-center">
                                            <div class="icon-wrapper bg-success-soft text-success mr-3">
                                                <i class="fas fa-money-check-alt fa-2x"></i>
                                            </div>
                                            <div>
                                                <div class="text-uppercase text-muted small font-weight-bold">
                                                    Service Fee Paid
                                                </div>
                                                <a href="#" class="h4 mb-0 text-dark d-block">
                                                    <?php echo e(number_format($servicePaid ?? 0)); ?> PKR
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ==================== FINANCIAL OVERVIEW ==================== -->
                    <div class="row">
                        <div class="col-12 mb-4">
                            <h5 class="font-weight-bold text-muted mb-3">Financial Overview</h5>
                            <div class="row">
                                <!-- Total Users -->
                                <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
                                    <div class="card shadow-sm border-0 h-100 hover-lift position-relative">
                                        <span class="badge bg-warning-soft text-warning position-absolute" style="top: 10px; right: 10px; font-size: 12px;">
                                            Never Subscribed <strong><?php echo e($users_never_had_plan ?? 0); ?></strong>
                                        </span>
                                        <div class="card-body d-flex align-items-center">
                                            <div class="icon-wrapper bg-primary-soft text-primary mr-3">
                                                <i class="fas fa-users fa-2x"></i>
                                            </div>
                                            <div>
                                                <div class="text-uppercase text-muted small font-weight-bold">Total Users</div>
                                                <a href="<?php echo e(route('package_requests')); ?>" class="h4 mb-0 text-dark d-block">
                                                    <?php echo e($total_users ?? 0); ?>

                                                </a>
                                            </div>
                                        </div>
                                        <span class="badge bg-danger-soft text-danger position-absolute" style="bottom: 10px; right: 10px; font-size: 12px;">
                                            Expired Plans <strong><?php echo e($users_with_expired_or_no_active_plan ?? 0); ?></strong>
                                        </span>
                                    </div>
                                </div>

                                <!-- Total Deposits -->
                                <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
                                    <div class="card shadow-sm border-0 h-100 hover-lift position-relative">
                                        <span class="badge bg-success position-absolute" style="top: 10px; right: 10px; font-size: 12px;">
                                            <?php echo e($total_deposits_count ?? 0); ?>

                                        </span>
                                        <div class="card-body d-flex align-items-center">
                                            <div class="icon-wrapper bg-success-soft text-success mr-3">
                                                <i class="fas fa-arrow-down fa-2x"></i>
                                            </div>
                                            <div>
                                                <div class="text-uppercase text-muted small font-weight-bold">Total Deposits</div>
                                                <a href="<?php echo e(route('package_requests')); ?>" class="h4 mb-0 text-dark d-block">
                                                    <?php echo e(number_format($total_deposits ?? 0)); ?>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Total Withdrawals -->
                                <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
                                    <div class="card shadow-sm border-0 h-100 hover-lift position-relative">
                                        <span class="badge bg-danger position-absolute" style="top: 10px; right: 10px; font-size: 12px;">
                                            <?php echo e($total_withdrawals_count ?? 0); ?>

                                        </span>
                                        <div class="card-body d-flex align-items-center">
                                            <div class="icon-wrapper bg-danger-soft text-danger mr-3">
                                                <i class="fas fa-arrow-up fa-2x"></i>
                                            </div>
                                            <div>
                                                <div class="text-uppercase text-muted small font-weight-bold">Total Withdrawals</div>
                                                <a href="<?php echo e(route('withdraw_requests')); ?>" class="h4 mb-0 text-dark d-block">
                                                    <?php echo e(number_format($total_withdrawals ?? 0)); ?>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Internal Balance Usage -->
                                <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
                                    <div class="card shadow-sm border-0 h-100 hover-lift position-relative">
                                        <span class="badge bg-warning position-absolute" style="top: 10px; right: 10px; font-size: 12px;">
                                            <?php echo e($internalBalanceUsageCount ?? 0); ?>

                                        </span>
                                        <div class="card-body d-flex align-items-center">
                                            <div class="icon-wrapper bg-warning-soft text-warning mr-3">
                                                <i class="fas fa-exchange-alt fa-2x"></i>
                                            </div>
                                            <div>
                                                <div class="text-uppercase text-muted small font-weight-bold">Internal Balance Usage</div>
                                                <a href="<?php echo e(route('internal.balance.usage')); ?>" class="h4 mb-0 text-dark d-block">
                                                    <?php echo e(number_format($internalBalanceUsageAmount ?? 0)); ?>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Balance Share -->
                                <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
                                    <div class="card shadow-sm border-0 h-100 hover-lift position-relative">
                                        <span class="badge bg-purple position-absolute" style="top: 10px; right: 10px; font-size: 12px;">
                                            <?php echo e($balanceShareCount ?? 0); ?>

                                        </span>
                                        <div class="card-body d-flex align-items-center">
                                            <div class="icon-wrapper bg-purple-soft text-purple mr-3">
                                                <i class="fas fa-share-alt fa-2x"></i>
                                            </div>
                                            <div>
                                                <div class="text-uppercase text-muted small font-weight-bold">Balance Share</div>
                                                <a href="<?php echo e(route('balance.shares')); ?>" class="h4 mb-0 text-dark d-block">
                                                    <?php echo e(number_format($balanceShareAmount ?? 0)); ?>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- All Users Current Balance -->
                                <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
                                    <div class="card shadow-sm border-0 h-100 hover-lift">
                                        <div class="card-body d-flex align-items-center">
                                            <div class="icon-wrapper bg-info-soft text-info mr-3">
                                                <i class="fas fa-wallet fa-2x"></i>
                                            </div>
                                            <div>
                                                <div class="text-uppercase text-muted small font-weight-bold">Total Balance</div>
                                                <a href="<?php echo e(route('users')); ?>" class="h4 mb-0 text-dark d-block">
                                                    <?php echo e(number_format($allUsersCurrentBalance ?? 0)); ?>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ==================== TODAY'S ACTIVITY & PENDING ==================== -->
                    <div class="row">
                        <div class="col-12 mb-4">
                            <h5 class="font-weight-bold text-muted mb-3">Today's Activity & Pending</h5>
                            <div class="row">
                                <!-- Today's Activity Summary -->
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                    <div class="card shadow-sm border-0 h-100 hover-lift position-relative">
                                        <span class="badge badge-success position-absolute" style="top: 10px; right: 30px; font-size: 12px;">
                                            <?php echo e($todays_deposits_count ?? 0); ?>

                                        </span>
                                        <span class="badge badge-danger position-absolute" style="top: 10px; right: 10px; font-size: 12px;">
                                            <?php echo e($todayswithdrawals_count ?? 0); ?>

                                        </span>
                                        <div class="card-body d-flex align-items-center">
                                            <div class="icon-wrapper bg-warning-soft text-warning mr-3">
                                                <i class="fas fa-chart-line fa-2x"></i>
                                            </div>
                                            <div>
                                                <div class="text-uppercase text-muted small font-weight-bold">Today's Activity</div>
                                                <div class="h5 mb-0">
                                                    Dep: <strong class="text-success"><?php echo e(number_format($todays_deposits ?? 0)); ?></strong><br>
                                                    Wd: <strong class="text-danger"><?php echo e(number_format($todayswithdrawals ?? 0)); ?></strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Today's Pending Deposits -->
                                <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
                                    <div class="card shadow-sm border-0 h-100 hover-lift position-relative">
                                        <span class="badge badge-warning position-absolute" style="top: 10px; right: 10px; font-size: 12px;">
                                            <?php echo e($todaysPendingDeposits_count ?? 0); ?>

                                        </span>
                                        <div class="card-body d-flex align-items-center">
                                            <div class="icon-wrapper bg-orange-soft text-orange mr-3">
                                                <i class="fas fa-clock fa-2x"></i>
                                            </div>
                                            <div>
                                                <div class="text-uppercase text-muted small font-weight-bold">Pending Deposits</div>
                                                <a href="<?php echo e(route('package_requests')); ?>" class="h4 mb-0 text-dark d-block">
                                                    <?php echo e(number_format($todaysPendingDeposits ?? 0)); ?>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Today's Pending Withdrawals -->
                                <div class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4">
                                    <div class="card shadow-sm border-0 h-100 hover-lift position-relative">
                                        <span class="badge badge-warning position-absolute" style="top: 10px; right: 10px; font-size: 12px;">
                                            <?php echo e($todayspendingWithdrawals_count ?? 0); ?>

                                        </span>
                                        <div class="card-body d-flex align-items-center">
                                            <div class="icon-wrapper bg-danger-soft text-danger mr-3">
                                                <i class="fas fa-exclamation-triangle fa-2x"></i>
                                            </div>
                                            <div>
                                                <div class="text-uppercase text-muted small font-weight-bold">Pending Withdrawals</div>
                                                <a href="<?php echo e(route('withdraw_requests')); ?>" class="h4 mb-0 text-dark d-block">
                                                    <?php echo e(number_format($todayspendingWithdrawals ?? 0)); ?>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tasks & Rewards -->
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                    <div class="card shadow-sm border-0 h-100 hover-lift">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="icon-wrapper bg-secondary-soft text-secondary mr-3">
                                                    <i class="fas fa-tasks fa-2x"></i>
                                                </div>
                                                <div>
                                                    <div class="text-uppercase text-muted small font-weight-bold">Total Tasks</div>
                                                    <a href="<?php echo e(route('tasks')); ?>" class="h5 mb-0 text-dark">
                                                        <?php echo e($totaltasks ?? 0); ?>

                                                    </a>
                                                </div>
                                            </div>
                                            <hr class="my-2">
                                            <div class="small text-muted d-flex justify-content-between">
                                                <span>Rewards</span>
                                                <span>Claims</span>
                                            </div>
                                            <div class="font-weight-bold d-flex justify-content-between">
                                                <span>
                                                    Today: <span class="text-success"><?php echo e(number_format($tasksRewardToday ?? 0)); ?></span><br>
                                                    Total: <?php echo e(number_format($tasksRewardTotal ?? 0)); ?>

                                                </span>
                                                <span class="text-right">
                                                    <span class="badge badge-info badge-pill"><?php echo e($tasksClaimedToday_count ?? 0); ?></span><br>
                                                    <span class="badge badge-secondary badge-pill"><?php echo e($tasksClaimedTotal_count ?? 0); ?></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Spins Overview Card -->
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                    <div class="card shadow-sm border-0 h-100 hover-lift">
                                        <a href="<?php echo e(route('spins')); ?>" class="stretched-link">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="icon-wrapper bg-primary-soft text-primary mr-3">
                                                        <i class="fas fa-dice fa-2x"></i>
                                                    </div>
                                                    <div>
                                                        <div class="text-uppercase text-muted small font-weight-bold">Spin Activity</div>
                                                        <h5 class="mb-0 text-dark">
                                                            <?php echo e(number_format($allTimeSpins->total_spins ?? 0)); ?>

                                                        </h5>
                                                    </div>
                                                </div>

                                                <hr class="my-3">

                                                <div class="row small text-muted mb-2">
                                                    <div class="col-6">Wins</div>
                                                    <div class="col-6 text-right">Bets</div>
                                                </div>

                                                <div class="row font-weight-bold">
                                                    <!-- All Time -->
                                                    <div class="col-6">
                                                        <span class="text-success">
                                                            <?php echo e(number_format($allTimeSpins->total_wins ?? 0)); ?>

                                                        </span><br>
                                                        <small class="text-muted">Total</small><br>
                                                        <?php echo e(number_format($allTimeSpins->total_wins_amount ?? 0, 0)); ?>

                                                    </div>

                                                    <div class="col-6 text-right">
                                                        <span class="text-danger">
                                                            <?php echo e(number_format($allTimeSpins->total_bets ?? 0)); ?>

                                                        </span><br>
                                                        <small class="text-muted">Total</small><br>
                                                        <?php echo e(number_format($allTimeSpins->total_bets_amount ?? 0, 0)); ?>

                                                    </div>
                                                </div>

                                                <hr class="my-3">

                                                <!-- Today -->
                                                <div class="row small text-muted mb-1">
                                                    <div class="col-12">Today</div>
                                                </div>

                                                <div class="row font-weight-bold">
                                                    <div class="col-6 text-success">
                                                        <?php echo e(number_format($todaySpins->today_wins ?? 0)); ?>

                                                        <br>
                                                        <?php echo e(number_format($todaySpins->today_wins_amount ?? 0, 0)); ?>

                                                    </div>
                                                    <div class="col-6 text-right text-danger">
                                                        <?php echo e(number_format($todaySpins->today_bets ?? 0)); ?>

                                                        <br>
                                                        <?php echo e(number_format($todaySpins->today_bets_amount ?? 0, 0)); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>



                                <!-- Burst Numbers Overview Card -->
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                    <div class="card shadow-sm border-0 h-100 hover-lift">
                                        <a href="<?php echo e(route('bursts')); ?>" class="stretched-link text-decoration-none">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="icon-wrapper bg-primary-soft text-warning mr-3">
                                                        <i class="fas fa-bomb fa-2x"></i>
                                                    </div>
                                                    <div>
                                                        <div class="text-uppercase text-muted small font-weight-bold">Burst Numbers</div>
                                                        <h5 class="mb-0 text-dark">
                                                            <?php echo e(number_format($allTimeBursts->total_bursts ?? 0)); ?>

                                                        </h5>
                                                    </div>
                                                </div>

                                                <hr class="my-3">

                                                <!-- All Time Stats -->
                                                <div class="row small text-muted mb-2">
                                                    <div class="col-6">Wins</div>
                                                    <div class="col-6 text-right">Bets</div>
                                                </div>

                                                <div class="row font-weight-bold">
                                                    <!-- All Time Wins -->
                                                    <div class="col-6">
                                                        <span class="text-success">
                                                            <?php echo e(number_format($allTimeBursts->total_burst_wins ?? 0)); ?>

                                                        </span><br>
                                                        <small class="text-muted">Total</small><br>
                                                        <span class="text-primary">
                                                            <?php echo e(number_format($allTimeBursts->total_burst_wins_amount ?? 0)); ?>

                                                        </span>
                                                    </div>

                                                    <!-- All Time Bets -->
                                                    <div class="col-6 text-right">
                                                        <span class="text-danger">
                                                            <?php echo e(number_format($allTimeBursts->total_burst_bets ?? 0)); ?>

                                                        </span><br>
                                                        <small class="text-muted">Total</small><br>
                                                        <span class="text-primary">
                                                            <?php echo e(number_format($allTimeBursts->total_burst_bets_amount ?? 0)); ?>

                                                        </span>
                                                    </div>
                                                </div>

                                                <hr class="my-3">

                                                <!-- Today Stats -->
                                                <div class="row small text-muted mb-1">
                                                    <div class="col-12">Today</div>
                                                </div>

                                                <div class="row font-weight-bold">
                                                    <!-- Today Wins -->
                                                    <div class="col-6 text-success">
                                                        <?php echo e(number_format($todayBursts->today_wins ?? 0)); ?><br>
                                                        <small><?php echo e(number_format($todayBursts->today_wins_amount ?? 0)); ?></small>
                                                    </div>

                                                    <!-- Today Bets -->
                                                    <div class="col-6 text-right text-danger">
                                                        <?php echo e(number_format($todayBursts->today_bets ?? 0)); ?><br>
                                                        <small><?php echo e(number_format($todayBursts->today_bets_amount ?? 0)); ?></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>




                                <!-- Profit Balls Overview Card -->
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                    <div class="card shadow-sm border-0 h-100 hover-lift">
                                        <a href="<?php echo e(route('profit.balls')); ?>" class="stretched-link text-decoration-none">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="icon-wrapper bg-success-soft text-success mr-3">
                                                        <i class="fas fa-football-ball fa-2x"></i>
                                                    </div>
                                                    <div>
                                                        <div class="text-uppercase text-muted small font-weight-bold">Profit Balls</div>
                                                        <h5 class="mb-0 text-dark">
                                                            <?php echo e(number_format($allTimeProfitBalls->total_profit_balls ?? 0)); ?>

                                                        </h5>
                                                    </div>
                                                </div>

                                                <hr class="my-3">

                                                <!-- All Time Stats -->
                                                <div class="row small text-muted mb-2">
                                                    <div class="col-6">Wins</div>
                                                    <div class="col-6 text-right">Bets</div>
                                                </div>

                                                <div class="row font-weight-bold">
                                                    <!-- All Time Wins -->
                                                    <div class="col-6">
                                                        <span class="text-success">
                                                            <?php echo e(number_format($allTimeProfitBalls->total_profit_balls_wins ?? 0)); ?>

                                                        </span><br>
                                                        <small class="text-muted">Total</small><br>
                                                        <span class="text-success">
                                                            <?php echo e(number_format($allTimeProfitBalls->total_profit_balls_wins_amount ?? 0)); ?>

                                                        </span>
                                                    </div>

                                                    <!-- All Time Bets -->
                                                    <div class="col-6 text-right">
                                                        <span class="text-danger">
                                                            <?php echo e(number_format($allTimeProfitBalls->total_profit_balls_bets ?? 0)); ?>

                                                        </span><br>
                                                        <small class="text-muted">Total</small><br>
                                                        <span class="text-danger">
                                                            <?php echo e(number_format($allTimeProfitBalls->total_profit_balls_bets_amount ?? 0)); ?>

                                                        </span>
                                                    </div>
                                                </div>

                                                <hr class="my-3">

                                                <!-- Today Stats -->
                                                <div class="row small text-muted mb-1">
                                                    <div class="col-12">Today</div>
                                                </div>

                                                <div class="row font-weight-bold">
                                                    <!-- Today Wins -->
                                                    <div class="col-6 text-success">
                                                        <?php echo e(number_format($todayProfitBalls->today_wins ?? 0)); ?><br>
                                                        <small><?php echo e(number_format($todayProfitBalls->today_wins_amount ?? 0)); ?></small>
                                                    </div>

                                                    <!-- Today Bets -->
                                                    <div class="col-6 text-right text-danger">
                                                        <?php echo e(number_format($todayProfitBalls->today_bets ?? 0)); ?><br>
                                                        <small><?php echo e(number_format($todayProfitBalls->today_bets_amount ?? 0)); ?></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>

                    <!-- ==================== TOP PERFORMERS ==================== -->
                    <div class="row">
                        <div class="col-12 mb-4">
                            <h5 class="font-weight-bold text-muted mb-3">Top Performers</h5>
                            <div class="row">
                                <!-- Top 5 Investors -->
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card h-100 shadow-sm border-0">
                                        <div class="card-header bg-success text-white">
                                            Top 5 Investors (by total deposited)
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <?php $__empty_1 = true; $__currentLoopData = $topDepositors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <a href="<?php echo e(route('userDetails', $user->id)); ?>" target="_blank" class="text-decoration-none text-dark">
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <strong><?php echo e($user->username); ?></strong><br>
                                                        <small class="text-muted">
                                                            <?php echo e($user->name); ?> • <?php echo e($user->phone); ?>

                                                        </small>
                                                    </div>
                                                    <div class="text-end">
                                                        <div class="fw-bold text-success fs-5">
                                                            <?php echo e(number_format($user->total_deposited, 0)); ?>

                                                        </div>
                                                        <small class="text-muted">
                                                            <?php echo e($user->deposit_count); ?> deposit<?php echo e($user->deposit_count == 1 ? '' : 's'); ?>

                                                        </small>
                                                    </div>
                                                </li>
                                            </a>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <li class="list-group-item text-center text-muted py-4">
                                                No investors found
                                            </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Top 5 Withdrawers -->
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card h-100 shadow-sm border-0">
                                        <div class="card-header bg-danger text-white">
                                            Top 5 Withdrawers (by total withdrawn)
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <?php $__empty_1 = true; $__currentLoopData = $topWithdrawers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <a href="<?php echo e(route('userDetails', $user->id)); ?>" target="_blank" class="text-decoration-none text-dark">
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <strong><?php echo e($user->username); ?></strong><br>
                                                        <small class="text-muted">
                                                            <?php echo e($user->name); ?> • <?php echo e($user->phone); ?>

                                                        </small>
                                                    </div>
                                                    <div class="text-end">
                                                        <div class="fw-bold text-danger fs-5">
                                                            <?php echo e(number_format($user->total_withdrawn, 0)); ?>

                                                        </div>
                                                        <small class="text-muted">
                                                            <?php echo e($user->withdrawal_count); ?> withdrawal<?php echo e($user->withdrawal_count == 1 ? '' : 's'); ?>

                                                        </small>
                                                    </div>
                                                </li>
                                            </a>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <li class="list-group-item text-center text-muted py-4">
                                                No withdrawers found
                                            </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Top 5 Task Users (by claimed tasks) -->
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card h-100 shadow-sm border-0">
                                        <div class="card-header bg-primary text-white">
                                            Top 5 Most Active Task Users (by claimed tasks)
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <?php $__empty_1 = true; $__currentLoopData = $topTaskUsersByCount; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <a href="<?php echo e(route('userDetails', $user->id)); ?>" target="_blank" class="text-decoration-none text-dark">
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <strong><?php echo e($user->username); ?></strong><br>
                                                        <small class="text-muted">
                                                            <?php echo e($user->name ?? '—'); ?> • <?php echo e($user->phone ?? '—'); ?>

                                                        </small>
                                                    </div>
                                                    <div class="text-end">
                                                        <div class="fw-bold text-primary fs-5">
                                                            <?php echo e($user->task_count); ?>

                                                        </div>
                                                        <small class="text-muted">
                                                            tasks • earned <?php echo e(number_format($user->total_task_reward, 0)); ?>

                                                        </small>
                                                    </div>
                                                </li>
                                            </a>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <li class="list-group-item text-center text-muted py-4">
                                                No task activity found
                                            </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Top 5 Spin Bettors -->
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card h-100 shadow-sm border-0">
                                        <div class="card-header bg-warning text-dark fw-bold">
                                            Top 5 Spin Bettors (highest total bet amount)
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <?php $__empty_1 = true; $__currentLoopData = $topSpinBetUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <a href="<?php echo e(route('userDetails', $user->id)); ?>" target="_blank" class="text-decoration-none text-dark">
                                                <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                                    <div>
                                                        <strong><?php echo e($user->username); ?></strong><br>
                                                        <small class="text-muted">
                                                            <?php echo e($user->name ?? '—'); ?> • <?php echo e($user->phone ?? '—'); ?>

                                                        </small>
                                                    </div>
                                                    <div class="text-end">
                                                        <div class="fw-bold text-warning fs-5">
                                                            <?php echo e(number_format($user->total_bet_amount, 0)); ?>

                                                        </div>
                                                        <small class="text-muted">
                                                            from <?php echo e($user->bet_count); ?> spin<?php echo e($user->bet_count == 1 ? '' : 's'); ?>

                                                        </small>
                                                    </div>
                                                </li>
                                            </a>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <li class="list-group-item text-center text-muted py-4">
                                                No spin bets recorded
                                            </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Top 5 Spin Winners -->
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card h-100 shadow-sm border-0">
                                        <div class="card-header bg-success text-white fw-bold">
                                            Top 5 Spin Winners (highest total win amount)
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <?php $__empty_1 = true; $__currentLoopData = $topSpinWinUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <a href="<?php echo e(route('userDetails', $user->id)); ?>" target="_blank" class="text-decoration-none text-dark">
                                                <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                                    <div>
                                                        <strong><?php echo e($user->username); ?></strong><br>
                                                        <small class="text-muted">
                                                            <?php echo e($user->name ?? '—'); ?> • <?php echo e($user->phone ?? '—'); ?>

                                                        </small>
                                                    </div>
                                                    <div class="text-end">
                                                        <div class="fw-bold text-success fs-5">
                                                            <?php echo e(number_format($user->total_win_amount, 0)); ?>

                                                        </div>
                                                        <small class="text-muted">
                                                            from <?php echo e($user->win_count); ?> win<?php echo e($user->win_count == 1 ? '' : 's'); ?>

                                                        </small>
                                                    </div>
                                                </li>
                                            </a>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <li class="list-group-item text-center text-muted py-4">
                                                No spin wins recorded
                                            </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Top 5 Users by Current Balance -->
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card h-100 shadow-sm border-0">
                                        <div class="card-header bg-info text-white fw-bold">
                                            Top 5 Users by Current Balance
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <?php $__empty_1 = true; $__currentLoopData = $topBalances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <a href="<?php echo e(route('userDetails', $user->id)); ?>" target="_blank" class="text-decoration-none text-dark">
                                                <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                                    <div>
                                                        <strong><?php echo e($user->username); ?></strong><br>
                                                        <small class="text-muted">
                                                            <?php echo e($user->name ?? '—'); ?> • <?php echo e($user->phone ?? '—'); ?>

                                                        </small>
                                                    </div>
                                                    <div class="text-end">
                                                        <div class="fw-bold text-info fs-5">
                                                            <?php echo e(number_format($user->balance, 0)); ?>

                                                        </div>
                                                    </div>
                                                </li>
                                            </a>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <li class="list-group-item text-center text-muted py-4">
                                                No users with balance recorded
                                            </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
             <?php endif; ?>

             <?php if(Auth::user()->type == '2' || Auth::user()->type == '0'): ?>
             <?php echo $__env->make('market.admin.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
             <?php endif; ?>

        </div>
        <!-- /.content-wrapper -->

        <!-- Footer -->
        <?php echo $__env->make('admin.includes.version', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <!-- /.footer -->

    </div>
    <!-- ./wrapper -->

    <!-- Footer links / scripts -->
    <?php echo $__env->make('admin.includes.footer_links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Optional: Add this to your CSS file or headlinks blade -->
    <style>
        :root {
            --primary-soft: rgba(0, 123, 255, 0.12);
            --success-soft: rgba(40, 167, 69, 0.12);
            --danger-soft: rgba(220, 53, 69, 0.12);
            --warning-soft: rgba(255, 193, 7, 0.12);
            --info-soft: rgba(23, 162, 184, 0.12);
            --secondary-soft: rgba(108, 117, 125, 0.12);
            --orange: #fd7e14;
            --orange-soft: rgba(253, 126, 20, 0.12);
        }

        .icon-wrapper {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--primary-soft);
        }

        .card {
            border-radius: 12px;
            transition: all 0.2s ease;
        }

        .card:hover,
        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08) !important;
        }

        @media (max-width: 576px) {
            .h4 {
                font-size: 1.4rem;
            }

            .h5 {
                font-size: 1.25rem;
            }

            .icon-wrapper {
                width: 50px;
                height: 50px;
            }

            .icon-wrapper i {
                font-size: 1.6rem !important;
            }
        }
    </style>

</body>

</html><?php /**PATH E:\xampp\htdocs\FeatureDesk\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>