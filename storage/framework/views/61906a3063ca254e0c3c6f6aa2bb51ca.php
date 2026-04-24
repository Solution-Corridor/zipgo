<?php
$id = request()->segment(2);
?>
<!DOCTYPE html>
<html lang="en">
<!-- Start top links -->
<title>User Detail</title>
<?php echo $__env->make('admin.includes.headlinks', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">
    <!-- Start navbar -->
    <?php echo $__env->make('admin.includes.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <!-- end navbar -->

    <?php echo $__env->make('admin.includes.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-12">
              <h1>User Detail</h1>

              <?php
              $pkgCount = DB::table('payments')
              ->where('status', 'approved')
              ->where('user_id', $id)
              ->count();
              ?>

              <?php if($pkgCount < 1): ?>
                <div class="alert alert-danger" role="alert">
                InActive User
            </div>
            <?php else: ?>
            <div class="alert alert-success" role="alert">
              Active User
            </div>
            <?php endif; ?>

          </div>
        </div>
    </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <?php
                $imageUrl = '/' . $user->pic;

                $initials = strtoupper(substr($user->username, 0, 2));
                ?>

                <div class="text-center">

                  <?php if(!empty($user->pic)): ?>
                  <img class="profile-user-img img-fluid img-circle"
                    src="<?php echo e($imageUrl); ?>"
                    alt="User profile picture"
                    style="height:110px; width:110px; object-fit:cover;">
                  <?php else: ?>
                  <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary text-white fw-bold"
                    style="height:110px; width:110px; font-size:32px;">
                    <?php echo e($initials); ?>

                  </div>
                  <?php endif; ?>

                </div>

                <h3 class="profile-username text-center">
                  <strong><?php echo e($user->username); ?></strong>
                </h3>


                <p class="text-muted text-center"><i class="fas fa-phone"></i> <?php echo e($user->phone); ?></p>
                <p class="text-muted text-center">
                  <i class="fab fa-whatsapp"></i>
                  <a href="https://wa.me/<?php echo e($user->whatsapp); ?>" target="_blank">
                    <?php echo e($user->whatsapp); ?>

                  </a>
                </p>
                <?php if($user->email): ?>
                <p class="text-muted text-center"><i class="fas fa-envelope"></i> <?php echo e($user->email); ?></p>
                <?php endif; ?>
                <p>
                  <strong><i class="fas fa-wallet mr-1"></i> Balance: <?php echo e(number_format($user->balance ?? 0, 0)); ?></strong>

                </p>

                <p>
                  <?php if($user->referrer): ?>
                  <a href="<?php echo e(route('userDetails', $user->referrer->id)); ?>" target="_blank">
                    <strong><i class="fas fa-book mr-1"></i> <?php echo e($user->referrer->username); ?></strong>
                  </a>
                  <?php else: ?>
                  <strong><i class="fas fa-book mr-1"></i> —</strong>
                  <?php endif; ?>
                </p>
                <!-- KYC status  -->
                <!-- KYC Status - Enhanced Badge (Recommended) -->
                <div class="toggle-row">
                  <div class="toggle-label">
                    <i class="fas fa-shield-alt text-purple-400"></i>
                    <strong>KYC:</strong>
                  </div>

                  <?php
                  $kyc = $user->kyc_status;
                  ?>

                  <?php if($kyc == 'approved'): ?>
                  <span class="badge badge-success px-3 py-2">
                    Approved
                  </span>
                  <?php elseif($kyc == 'rejected'): ?>
                  <span class="badge badge-danger px-3 py-2">
                    Rejected
                  </span>
                  <?php elseif($kyc == 'submitted'): ?>
                  <span class="badge badge-warning px-3 py-2">
                    Under Review
                  </span>
                  <?php else: ?>
                  <span class="badge badge-secondary px-3 py-2">
                    Not Submitted
                  </span>
                  <?php endif; ?>
                </div>

                <p>
                  <strong><i class="fas fa-clock mr-1"></i>
                    <?php echo e($user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('d M y, h:i A') : '—'); ?>

                  </strong>
                </p>


                <div class="mt-4">
                  <style>
                    /* Ensure proper alignment */
                    .toggle-row {
                      display: flex;
                      align-items: center;
                      justify-content: space-between;
                      margin-bottom: 12px;
                      min-height: 38px;
                    }

                    .toggle-label {
                      display: flex;
                      align-items: center;
                      gap: 8px;
                    }

                    .toggle-label i {
                      width: 20px;
                      /* Fixed width for icons to align text */
                      text-align: center;
                    }

                    .custom-switch {
                      padding-left: 2.25rem;
                      /* Maintain Bootstrap default */
                    }
                  </style>

                  <!-- Sensitive -->
                  <div class="toggle-row">
                    <div class="toggle-label">
                      <i class="fas fa-user-shield text-indigo-400"></i>
                      <strong>Sensitive:</strong>
                    </div>
                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                      <input type="checkbox"
                        class="custom-control-input toggle-sensitive"
                        id="statusSensitive<?php echo e($user->id); ?>"
                        data-id="<?php echo e($user->id); ?>"
                        <?php echo e($user->is_sensitive ? 'checked' : ''); ?>>
                      <label class="custom-control-label" for="statusSensitive<?php echo e($user->id); ?>"></label>
                    </div>
                  </div>

                  <!-- Tasks Allowed -->
                  <div class="toggle-row">
                    <div class="toggle-label">
                      <i class="fas fa-tasks text-teal-400"></i>
                      <strong>Tasks Allowed:</strong>
                    </div>
                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                      <input type="checkbox"
                        class="custom-control-input toggle-tasks"
                        id="statusTasks<?php echo e($user->id); ?>"
                        data-id="<?php echo e($user->id); ?>"
                        <?php echo e($user->is_tasks_allowed ? 'checked' : ''); ?>>
                      <label class="custom-control-label" for="statusTasks<?php echo e($user->id); ?>"></label>
                    </div>
                  </div>

                  <!-- Balance Share Allowed -->
                  <div class="toggle-row">
                    <div class="toggle-label">
                      <i class="fas fa-share-alt text-info"></i>
                      <strong>Balance Share Allowed:</strong>
                    </div>
                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                      <input type="checkbox"
                        class="custom-control-input toggle-balance-sharing"
                        id="statusBalanceSharing<?php echo e($user->id); ?>"
                        data-id="<?php echo e($user->id); ?>"
                        <?php echo e($user->is_balance_sharing_allowed ? 'checked' : ''); ?>>
                      <label class="custom-control-label" for="statusBalanceSharing<?php echo e($user->id); ?>"></label>
                    </div>
                  </div>

                  <!-- Withdraw Allowed -->
                  <div class="toggle-row">
                    <div class="toggle-label">
                      <i class="fas fa-money-bill-wave text-success"></i>
                      <strong>Withdraw Allowed:</strong>
                    </div>
                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                      <input type="checkbox"
                        class="custom-control-input toggle-withdraw"
                        id="statusWithdraw<?php echo e($user->id); ?>"
                        data-id="<?php echo e($user->id); ?>"
                        <?php echo e((isset($user->is_withdraw_allowed) ? $user->is_withdraw_allowed : true) ? 'checked' : ''); ?>>
                      <label class="custom-control-label" for="statusWithdraw<?php echo e($user->id); ?>"></label>
                    </div>
                  </div>

                  <!-- Withdraw Timer -->
                  <div class="toggle-row">
                    <div class="toggle-label">
                      <i class="fas fa-clock text-warning"></i>
                      <strong>Withdraw Timer:</strong>
                    </div>
                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                      <input type="checkbox"
                        class="custom-control-input toggle-withdraw-timer"
                        id="statusWithdrawTimer<?php echo e($user->id); ?>"
                        data-id="<?php echo e($user->id); ?>"
                        <?php echo e((isset($user->withdraw_timer) ? $user->withdraw_timer : true) ? 'checked' : ''); ?>>
                      <label class="custom-control-label" for="statusWithdrawTimer<?php echo e($user->id); ?>"></label>
                    </div>
                  </div>

                  <!-- Withdraw Without Package -->
                  <div class="toggle-row">
                    <div class="toggle-label">
                      <i class="fa fa-archive text-danger"></i>
                      <strong>Withdraw Without Package:</strong>
                    </div>
                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                      <input type="checkbox"
                        class="custom-control-input toggle-withdraw-without-package"
                        id="statusWithdrawWithoutPackage<?php echo e($user->id); ?>"
                        data-id="<?php echo e($user->id); ?>"
                        <?php echo e((isset($user->withdraw_without_package) ? $user->withdraw_without_package : true) ? 'checked' : ''); ?>>
                      <label class="custom-control-label" for="statusWithdrawWithoutPackage<?php echo e($user->id); ?>"></label>
                    </div>
                  </div>

                  <!-- Complaints -->
                  <div class="toggle-row">
                    <div class="toggle-label">
                      <i class="fas fa-exclamation-triangle text-warning"></i>
                      <strong>Complaints:</strong>
                    </div>
                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                      <input type="checkbox"
                        class="custom-control-input toggle-complaint"
                        id="statusComplaint<?php echo e($user->id); ?>"
                        data-id="<?php echo e($user->id); ?>"
                        <?php echo e((isset($user->is_complaint_allowed) ? $user->is_complaint_allowed : true) ? 'checked' : ''); ?>>
                      <label class="custom-control-label" for="statusComplaint<?php echo e($user->id); ?>"></label>
                    </div>
                  </div>

                  <!-- Fixed Deposit (as badge, not toggle) -->
                  <div class="toggle-row">
                    <div class="toggle-label">
                      <i class="fas fa-coins text-warning"></i>
                      <strong>Fixed Deposit:</strong>
                    </div>
                    <?php if($user->is_fd ?? false): ?>
                    <span class="badge badge-primary px-3 py-2">Yes</span>
                    <?php else: ?>
                    <span class="badge badge-secondary px-3 py-2">No</span>
                    <?php endif; ?>
                  </div>
                </div>

                <p class="text-right">
                  <a href="<?php echo e(route('editUser', $user->id)); ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit User</a>
                </p>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#team" data-toggle="tab"><i class="fa fa-users"></i> Team</a></li>
                  <li class="nav-item"><a class="nav-link" href="#packages" data-toggle="tab"><i class="fa fa-box"></i> Packages</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tasks" data-toggle="tab"><i class="fa fa-tasks"></i> Tasks</a></li>
                  <li class="nav-item"><a class="nav-link" href="#trx" data-toggle="tab"><i class="fa fa-clock"></i> Transactions</a></li>                  
                  <li class="nav-item"><a class="nav-link" href="#withdraw" data-toggle="tab"><i class="fa fa-book"></i> Withdrawals</a></li>
                  <li class="nav-item">
                    <a class="nav-link" href="#complaints" data-toggle="tab">
                      <i class="fa fa-exclamation-triangle"></i> Complaints
                    </a>
                  </li>

                  <li class="nav-item">
                    <a class="nav-link" href="#orders" data-toggle="tab">
                      <i class="fa fa-shopping-cart"></i> Orders
                    </a>
                  </li>

                  <li class="nav-item">
                    <a class="nav-link" href="#spins" data-toggle="tab">
                      <i class="fa fa-spinner"></i> Spins
                    </a>
                  </li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">

                  <!-- TEAM TAB -->
                  <div class="tab-pane active" id="team">

                    <div class="row">
                      <!-- Level 1 -->
                      <div class="col-lg-3 col-6">
                        <div class="small-box">
                          <div class="inner" style="color:blue;">
                            <h3 id="l1">0</h3>
                            <p>Level 1</p>
                          </div>
                          <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                          </div>
                        </div>
                      </div>

                      <!-- Level 2 -->
                      <div class="col-lg-3 col-6">
                        <div class="small-box">
                          <div class="inner" style="color:green;">
                            <h3 id="l2">0</h3>
                            <p>Level 2</p>
                          </div>
                          <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                          </div>
                        </div>
                      </div>
                    </div>

                    <?php
                    $l1Count = 0;
                    $l2Count = 0;

                    $l1 = DB::select('SELECT * FROM users WHERE referred_by = ?', [$id]);
                    $l1Count = count($l1);
                    ?>

                    <ul class="l1">
                      <?php $__currentLoopData = $l1; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $li): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <li style="color: blue;">
                        <a href="<?php echo e(route('userDetails', ['id' => $li->id])); ?>" target="_blank" rel="noopener noreferrer" style="color:inherit;">
                          <?php echo e($li->name ?? $li->username ?? '—'); ?>

                        </a>
                        <?php
                        $pkg = DB::select('SELECT COUNT(*) as pkgCount FROM payments WHERE user_id = ? AND status = "approved"', [$li->id]);
                        $pkgCheck = $pkg[0]->pkgCount ?? 0;
                        ?>
                        <?php if($pkgCheck > 0): ?>
                        <span style="color:green;">(Active)</span>
                        <?php else: ?>
                        <span style="color:red;">(Inactive)</span>
                        <?php endif; ?>

                        <?php
                        $l2 = DB::select('SELECT * FROM users WHERE referred_by = ?', [$li->id]);
                        $l2Count += count($l2);
                        ?>

                        <?php if(!empty($l2)): ?>
                        <ul class="l2">
                          <?php $__currentLoopData = $l2; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lii): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <li style="color: green;">
                            <a href="<?php echo e(route('userDetails', ['id' => $lii->id])); ?>" target="_blank" rel="noopener noreferrer" style="color:inherit;">
                              <?php echo e($lii->name ?? $lii->username ?? '—'); ?>

                            </a>

                            <?php
                            $pkg = DB::select('SELECT COUNT(*) as pkgCount FROM payments WHERE user_id = ? AND status = "approved"', [$lii->id]);
                            $pkgCheck = $pkg[0]->pkgCount ?? 0;
                            ?>
                            <?php if($pkgCheck > 0): ?>
                            <span style="color:green;">(Active)</span>
                            <?php else: ?>
                            <span style="color:red;">(Inactive)</span>
                            <?php endif; ?>
                          </li>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <?php endif; ?>
                      </li>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>

                  </div>
                  <!-- /.tab-pane -->

                  <!-- PACKAGES TAB -->
                  <div class="tab-pane" id="packages">
                    <div class="card card-outline card-primary">
                      <div class="card-header">
                        <h3 class="card-title">
                          Purchased Packages
                          <?php
                          $activePkgCount = DB::table('payments')
                          ->where('user_id', $id)
                          ->where('status', 'approved')
                          ->count();
                          ?>
                          <span class="badge badge-info ml-2">Total: <?php echo e($activePkgCount); ?></span>
                        </h3>
                      </div>

                      <div class="card-body table-responsive p-0">
                        <?php
                        $userPackages = DB::table('payments')
                        ->leftJoin('packages', 'payments.plan_id', '=', 'packages.id')
                        ->where('payments.user_id', $id)
                        ->where('payments.status', 'approved')
                        ->select(
                        'payments.id as payment_id',
                        'payments.amount',
                        'payments.created_at as purchased_at',
                        'payments.expires_at as expiry',
                        'packages.name',
                        'packages.investment_amount',
                        'packages.duration_days',
                        'packages.daily_profit_min',
                        'packages.daily_profit_max'
                        )
                        ->orderBy('payments.created_at', 'desc')
                        ->get();
                        ?>

                        <?php if($userPackages->isEmpty()): ?>
                        <div class="alert alert-info m-3">
                          This user has not purchased any approved packages yet.
                        </div>
                        <?php else: ?>
                        <table class="table table-hover table-bordered text-nowrap">
                          <thead class="thead-light">
                            <tr>
                              <th>#</th>
                              <th>Package Name</th>
                              <th>Invested</th>
                              <th>Daily Profit Range</th>
                              <th>Duration</th>
                              <th>Purchased</th>
                              <th>Expiry</th>
                              <th>Status</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $__currentLoopData = $userPackages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pkg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                              <td><?php echo e($pkg->payment_id); ?></td>
                              <td>
                                <strong><?php echo e($pkg->name ?? 'Unnamed Package'); ?></strong>
                                <small class="d-block text-muted">ID: <?php echo e($pkg->payment_id); ?></small>
                              </td>
                              <td><?php echo e(number_format($pkg->amount ?? $pkg->investment_amount, 0)); ?></td>
                              <td>
                                <?php echo e(number_format($pkg->daily_profit_min, 0)); ?> —
                                <?php echo e(number_format($pkg->daily_profit_max, 0)); ?>

                              </td>
                              <td><?php echo e($pkg->duration_days); ?> days</td>
                              <td><?php echo e($pkg->purchased_at ? \Carbon\Carbon::parse($pkg->purchased_at)->format('d M y, H:i') : '—'); ?></td>
                              <td><?php echo e($pkg->expiry ? \Carbon\Carbon::parse($pkg->expiry)->format('d M y, H:i') : '—'); ?></td>
                              <td>
                                <?php
                                $expiry = \Carbon\Carbon::parse($pkg->purchased_at)->addDays((int) $pkg->duration_days);
                                $isExpired = $expiry->isPast();
                                ?>
                                <span class="badge badge-<?php echo e($isExpired ? 'danger' : 'success'); ?>">
                                  <?php echo e($isExpired ? 'Expired' : 'Active'); ?>

                                </span>
                              </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th colspan="2" class="text-right">Total Invested</th>
                              <th><?php echo e(number_format($userPackages->sum('amount'), 0)); ?></th>
                              <th colspan="4"></th>
                            </tr>
                          </tfoot>
                        </table>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>

                  <!-- TASKS TAB -->
                  <div class="tab-pane" id="tasks">
                    <div class="card card-outline card-success">
                      <div class="card-header">
                        <h3 class="card-title">User Tasks & Activities Latest 50</h3>
                      </div>

                      <div class="card-body">
                        <?php
                        // Summary counts
                        $taskStats = DB::table('user_task_logs')
                        ->where('user_id', $id)
                        ->selectRaw("
                        COUNT(*) as total_tasks,
                        SUM(CASE WHEN status = 'viewed' THEN 1 ELSE 0 END) as viewed,
                        SUM(CASE WHEN status = 'started' THEN 1 ELSE 0 END) as started,
                        SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed,
                        SUM(CASE WHEN status = 'claimed' THEN 1 ELSE 0 END) as claimed,
                        SUM(CASE WHEN status = 'skipped' THEN 1 ELSE 0 END) as skipped,
                        COALESCE(SUM(reward), 0) as total_reward
                        ")
                        ->first();

                        $tasks = DB::table('user_task_logs')
                        ->where('user_id', $id)
                        ->orderBy('created_at', 'desc')
                        ->limit(50)
                        ->get();
                        ?>

                        <div class="row mb-4">
                          <div class="col-md-2 col-6">
                            <div class="small-box bg-info">
                              <div class="inner">
                                <h3><?php echo e($taskStats->total_tasks ?? 0); ?></h3>
                                <p>Total Tasks</p>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-2 col-6">
                            <div class="small-box bg-primary">
                              <div class="inner">
                                <h3><?php echo e($taskStats->viewed ?? 0); ?></h3>
                                <p>Viewed</p>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-2 col-6">
                            <div class="small-box bg-warning">
                              <div class="inner">
                                <h3><?php echo e($taskStats->started ?? 0); ?></h3>
                                <p>Started</p>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-2 col-6">
                            <div class="small-box bg-success">
                              <div class="inner">
                                <h3><?php echo e($taskStats->completed ?? 0); ?></h3>
                                <p>Completed</p>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-2 col-6">
                            <div class="small-box bg-purple">
                              <div class="inner">
                                <h3><?php echo e($taskStats->claimed ?? 0); ?></h3>
                                <p>Claimed</p>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-2 col-6">
                            <div class="small-box bg-danger">
                              <div class="inner">
                                <h3><?php echo e(number_format($taskStats->total_reward ?? 0, 0)); ?></h3>
                                <p>Total Reward</p>
                              </div>
                            </div>
                          </div>
                        </div>

                        <?php if($tasks->isEmpty()): ?>
                        <div class="alert alert-info">
                          No task records found for this user.
                        </div>
                        <?php else: ?>
                        <table class="table table-bordered table-striped table-sm">
                          <thead>
                            <tr>
                              <th>ID</th>
                              <th>Task ID</th>
                              <th>Status</th>
                              <th>Reward</th>
                              <th>Created</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                              <td><?php echo e($task->id); ?></td>
                              <td><?php echo e($task->task_id); ?></td>
                              <td>
                                <span class="badge badge-<?php echo e($task->status === 'claimed' ? 'success' : 
                  ($task->status === 'completed' ? 'primary' : 
                  ($task->status === 'skipped' ? 'danger' : 'secondary'))); ?>">
                                  <?php echo e(ucfirst($task->status)); ?>

                                </span>
                              </td>
                              <td><?php echo e(number_format($task->reward ?? 0, 0)); ?></td>
                              <td><?php echo e($task->created_at 
                ? \Carbon\Carbon::parse($task->created_at )->format('d M y • h:i:s A') 
                : '—'); ?></td>

                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </tbody>
                        </table>

                        <?php if(count($tasks) >= 100): ?>
                        <div class="alert alert-warning mt-3 small">
                          Showing only the 100 most recent tasks. Contact support for full history if needed.
                        </div>
                        <?php endif; ?>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>

                  <!-- TRANSACTIONS TAB -->
                  <div class="tab-pane" id="trx">
                    <?php
                    $trx = DB::select('SELECT * FROM transactions WHERE user_id = ? ORDER BY id DESC', [$id]);
                    ?>
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Trx #</th>
                          <th>Amount</th>
                          <th>Type</th>
                          <th>Detail</th>
                          <th>Date</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $__currentLoopData = $trx; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                          <td><?php echo e($tr->id); ?></td>
                          <td><?php echo e(number_format($tr->amount, 0)); ?></td>
                          <td><?php echo e($tr->trx_type); ?></td>
                          <td><?php echo e($tr->detail); ?></td>
                          <td><?php echo e($tr->created_at ? \Carbon\Carbon::parse($tr->created_at)->format('d M y • h:i a') : '—'); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </tbody>
                    </table>
                  </div>


                  <!-- WITHDRAWALS TAB -->
                  <div class="tab-pane" id="withdraw">
                    <div class="card card-outline card-danger">
                      <div class="card-header">
                        <h3 class="card-title">
                          Withdrawal Requests
                          <?php
                          $wdStats = DB::table('withdrawals')
                          ->where('user_id', $id)
                          ->selectRaw("
                          COUNT(*) as total,
                          SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                          SUM(CASE WHEN status = 'returned' THEN 1 ELSE 0 END) as returned,
                          SUM(CASE WHEN approved_at IS NOT NULL
                          AND status != 'returned'
                          AND rejected_at IS NULL
                          AND cancelled_at IS NULL
                          THEN 1 ELSE 0 END) as approved,
                          SUM(CASE WHEN rejected_at IS NOT NULL THEN 1 ELSE 0 END) as rejected,
                          SUM(CASE WHEN cancelled_at IS NOT NULL THEN 1 ELSE 0 END) as cancelled,
                          COALESCE(SUM(amount), 0) as total_amount
                          ")->first();
                          ?>

                          <span class="badge badge-info ml-2">Total: <?php echo e($wdStats->total ?? 0); ?></span>
                          <?php if($wdStats->returned > 0): ?>
                          <span class="badge badge-info ml-2">Returned: <?php echo e($wdStats->returned); ?></span>
                          <?php endif; ?>
                        </h3>
                      </div>

                      <div class="card-body table-responsive p-0">
                        <?php
                        $withdrawals = DB::table('withdrawals')
                        ->where('user_id', $id)
                        ->orderBy('created_at', 'desc')
                        ->get();
                        ?>

                        <?php if($withdrawals->isEmpty()): ?>
                        <div class="alert alert-info m-3">
                          No withdrawal requests found.
                        </div>
                        <?php else: ?>
                        <table class="table table-hover table-bordered table-sm text-nowrap">
                          <thead class="thead-light">
                            <tr>
                              <th>ID</th>
                              <th>Amount</th>
                              <th>Method</th>
                              <th>Account</th>
                              <th>Status</th>
                              <th>Submitted</th>
                              <th>Processed</th>
                              <th>Remarks</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $__currentLoopData = $withdrawals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                              <td><?php echo e($wd->id); ?></td>
                              <td><?php echo e(number_format($wd->amount, 0)); ?></td>
                              <td><?php echo e($wd->method); ?></td>
                              <td>
                                <?php echo e($wd->account_title); ?><br>
                                <small class="text-muted"><?php echo e($wd->account_number); ?></small>
                              </td>
                              <td>
                                <span class="badge badge-<?php echo e($wd->status === 'returned' ? 'info' :
                                    ($wd->approved_at ? 'success' :
                                    ($wd->rejected_at ? 'danger' :
                                    ($wd->cancelled_at ? 'secondary' : 'warning')))); ?>">
                                  <?php echo e($wd->status === 'returned' ? 'Returned' :
                                        ($wd->approved_at ? 'Approved' :
                                        ($wd->rejected_at ? 'Rejected' :
                                        ($wd->cancelled_at ? 'Cancelled' : 'Pending')))); ?>

                                </span>
                              </td>
                              <td><?php echo e(\Carbon\Carbon::parse($wd->created_at)->format('d M Y • h:i a')); ?></td>
                              <td>
                                <?php if($wd->status === 'returned'): ?>
                                <span class="text-info">
                                  <?php echo e(\Carbon\Carbon::parse($wd->updated_at ?? $wd->created_at)->format('d M Y • h:i a')); ?>

                                </span>
                                <?php elseif($wd->approved_at): ?>
                                <?php echo e(\Carbon\Carbon::parse($wd->approved_at)->format('d M Y • h:i a')); ?>

                                <?php elseif($wd->rejected_at): ?>
                                <span class="text-danger"><?php echo e(\Carbon\Carbon::parse($wd->rejected_at)->format('d M Y • h:i a')); ?></span>
                                <?php elseif($wd->cancelled_at): ?>
                                <span class="text-secondary"><?php echo e(\Carbon\Carbon::parse($wd->cancelled_at)->format('d M Y • h:i a')); ?></span>
                                <?php else: ?>
                                —
                                <?php endif; ?>
                              </td>
                              <td>
                                <?php echo e($wd->remarks ?? ''); ?>

                              </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th colspan="1" class="text-right">Total Withdrawn</th>
                              <th><?php echo e(number_format($withdrawals->whereNotNull('approved_at')->where('status', '!=', 'returned')->sum('amount'), 0)); ?></th>
                              <th colspan="5"></th>
                            </tr>
                          </tfoot>
                        </table>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>


                  <!-- COMPLAINTS TAB -->
                  <div class="tab-pane" id="complaints">
                    <div class="card card-outline card-warning">
                      <div class="card-header">
                        <h3 class="card-title">
                          User Complaints / Support Tickets
                          <?php
                          $complaintStats = DB::table('complaints')
                          ->where('user_id', $id)
                          ->selectRaw("
                          COUNT(*) as total,
                          SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                          SUM(CASE WHEN status = 'replied' THEN 1 ELSE 0 END) as replied,
                          SUM(CASE WHEN status = 'resolved' THEN 1 ELSE 0 END) as resolved,
                          SUM(CASE WHEN status = 'closed' THEN 1 ELSE 0 END) as closed
                          ")->first();
                          ?>
                          <span class="badge badge-info ml-2">Total: <?php echo e($complaintStats->total ?? 0); ?></span>
                        </h3>
                      </div>

                      <div class="card-body table-responsive p-0">
                        <?php
                        $complaints = DB::table('complaints')
                        ->where('user_id', $id)
                        ->orderBy('created_at', 'desc')
                        ->get();
                        ?>

                        <?php if($complaints->isEmpty()): ?>
                        <div class="alert alert-info m-3">
                          This user has not submitted any complaints yet.
                        </div>
                        <?php else: ?>
                        <table class="table table-hover table-bordered table-sm">
                          <thead class="thead-light">
                            <tr>
                              <th>ID</th>
                              <th>Subject</th>
                              <th>Status</th>
                              <th>Submitted</th>
                              <th>Resolved</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $__currentLoopData = $complaints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $complaint): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                              <td><?php echo e($complaint->id); ?></td>
                              <td>
                                <strong><?php echo e($complaint->subject); ?></strong>
                                <div class="text-muted small mt-1">
                                  <?php echo nl2br(e(Str::limit($complaint->detail, 120))); ?>

                                </div>
                              </td>
                              <td>
                                <?php
                                $badgeClass = match($complaint->status) {
                                'pending' => 'warning',
                                'replied' => 'info',
                                'resolved' => 'success',
                                'closed' => 'secondary',
                                default => 'secondary',
                                };
                                ?>
                                <span class="badge badge-<?php echo e($badgeClass); ?>">
                                  <?php echo e(ucfirst($complaint->status)); ?>

                                </span>
                              </td>
                              <td><?php echo e($complaint->created_at ? \Carbon\Carbon::parse($complaint->created_at)->format('d M y • h:i a') : '—'); ?></td>
                              <td>
                                <?php echo e($complaint->resolved_at ? \Carbon\Carbon::parse($complaint->resolved_at)->format('d M y • h:i a') : '—'); ?>

                              </td>
                              
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </tbody>
                        </table>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>

<!-- Orders tab -->
<div class="tab-pane" id="orders">
  <div class="card card-outline card-secondary">
    <div class="card-header">
      <h3 class="card-title">
        User Orders
        <?php
          $orderStats = DB::table('mk_orders')
            ->where('user_id', $id)
            ->selectRaw("
              COUNT(*) as total_orders,
              SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
              SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed,
              COALESCE(SUM(total_price), 0) as total_amount
            ")->first();

            $orders = DB::table('mk_orders')
            ->leftJoin('mk_products', 'mk_orders.product_id', '=', 'mk_products.product_id')
                ->where('user_id', $id)
                ->select(
                    'mk_orders.*',
                    'mk_products.name as product_name',
                    'mk_products.slug as product_slug',
                    'mk_products.price',
                    'mk_products.delivery_charges'
                )
                ->orderBy('created_at', 'desc')
                ->get();
        ?>

        <span class="badge badge-info ml-2">Total: <?php echo e($orderStats->total_orders ?? 0); ?></span>
        <span class="badge badge-warning ml-2">Pending: <?php echo e($orderStats->pending ?? 0); ?></span>
        <span class="badge badge-success ml-2">Completed: <?php echo e($orderStats->completed ?? 0); ?></span>
        <span class="badge badge-primary ml-2">Total Amount: Rs. <?php echo e(number_format($orderStats->total_amount ?? 0)); ?></span>
      </h3>
    </div>

    <div class="card-body p-0">
      <?php if($orders->isEmpty()): ?>
        <div class="alert alert-info m-3 mb-0">
          No orders found for this user.
        </div>
      <?php else: ?>
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-sm mb-0">
            <thead class="table-dark">
              <tr>
                <th style="width: 80px;">Order ID</th>
                <th>Customer</th>
                <th>Phone</th>
                <th>Product ID</th>
                <th>Qty</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Date & Time</th>
              </tr>
            </thead>
            <tbody>
              <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td><strong>#<?php echo e($order->id); ?></strong></td>
                <td><?php echo e($order->name); ?></td>
                <td><?php echo e($order->phone); ?></td>
                <td>
                  <a href="<?php echo e(route('market.product.detail', $order->product_slug)); ?>" target="_blank">
                    <?php echo e($order->product_name); ?>

                  </a>
                </td>
                <td class="text-center"><?php echo e($order->quantity); ?></td>
                <td class="text-right fw-bold">
                  Rs. <?php echo e(number_format($order->total_price, 0)); ?>

                </td>
                <td>
                  <?php
                    $status = strtolower($order->status);
                  ?>
                  <?php if($status == 'completed' || $status == 'delivered'): ?>
                    <span class="badge badge-success">Completed</span>
                  <?php elseif($status == 'pending'): ?>
                    <span class="badge badge-warning">Pending</span>
                  <?php elseif($status == 'canceled' || $status == 'cancelled'): ?>
                    <span class="badge badge-danger">Canceled</span>
                  <?php else: ?>
                    <span class="badge badge-secondary"><?php echo e(ucfirst($order->status)); ?></span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php echo e(\Carbon\Carbon::parse($order->created_at)->format('d M Y, h:i a')); ?>

                </td>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>


                  <!-- spins tab -->
                  <div class="tab-pane" id="spins">
                    <div class="card card-outline card-secondary">
                      <div class="card-header">
                        <h3 class="card-title">
                          Lucky Spin History
                          <?php
                          $spinStats = DB::table('transactions')
                          ->where('user_id', $id)
                          ->where(function($query) {
                          $query->where('trx_type', 'spin_bet');
                          })
                          ->selectRaw("
                          COUNT(*) as total_spins,
                          COALESCE(SUM(amount), 0) as total_spins_amount
                          ")->first();

                          $spinWin = DB::table('transactions')
                          ->where('user_id', $id)
                          ->where(function($query) {
                          $query->where('trx_type', 'spin_win');
                          })
                          ->selectRaw("
                          COUNT(*) as total_wins,
                          COALESCE(SUM(amount), 0) as total_win_amount
                          ")->first();

                          ?>
                          <span class="badge badge-info ml-2">Total Spins: <?php echo e($spinStats->total_spins ?? 0); ?>, Amount: Rs <?php echo e(number_format($spinStats->total_spins_amount ?? 0)); ?></span>
                          <span class="badge badge-success ml-2">Total Won: <?php echo e(number_format($spinWin->total_wins ?? 0)); ?>, Rs <?php echo e(number_format($spinWin->total_win_amount ?? 0, 0)); ?></span>
                        </h3>
                      </div>
                      <div class="card-body">

                        <?php
                        $spins = DB::table('transactions')
                        ->where('user_id', $id)
                        ->where(function($query) {
                        $query->where('trx_type', 'spin_bet')
                        ->orWhere('trx_type', 'spin_win');
                        })
                        ->orderBy('created_at', 'desc')
                        ->get();
                        ?>

                        <?php if($spins->isEmpty()): ?>
                        <div class="alert alert-info m-3">
                          No lucky spin records found for this user.
                        </div>
                        <?php else: ?>
                        <table class="table table-bordered table-striped table-sm">
                          <thead>
                            <tr>
                              <th>ID</th>
                              <th>Type</th>
                              <th>Amount</th>
                              <th>Detail</th>
                              <th>Date</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $__currentLoopData = $spins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                              <td><?php echo e($spin->id); ?></td>
                              <td><?php echo $spin->trx_type === 'spin_bet' ? '<span class="badge badge-danger">Bet</span>' : '<span class="badge badge-success">Win</span>'; ?></td>
                              <td><?php echo e(number_format($spin->amount, 0)); ?></td>
                              <td><?php echo e($spin->detail); ?></td>
                              <td><?php echo e(\Carbon\Carbon::parse($spin->created_at)->format('d M y • h:i:s A')); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </tbody>
                        </table>

                        <?php if(count($spins) >= 100): ?>
                        <div class="alert alert-warning mt-3 small">
                          Showing only the 100 most recent spins. Contact support for full history if needed.
                        </div>
                        <?php endif; ?>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
                  <!-- /.card -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php echo $__env->make('admin.includes.version', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  </div>
  <!-- ./wrapper -->

  <?php echo $__env->make('admin.includes.footer_links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  <script>
    $(document).ready(function () {
      $('#l1').text(<?php echo e($l1Count ?? 0); ?>);
      $('#l2').text(<?php echo e($l2Count ?? 0); ?>);
    });
  </script>

  <script>

    $(document).on('change', '.toggle-sensitive, .toggle-tasks, .toggle-balance-sharing, .toggle-withdraw, .toggle-complaint, .toggle-withdraw-timer, .toggle-withdraw-without-package', function () {

        let id = $(this).data('id');
        let checked = $(this).prop('checked') ? 1 : 0;
        let $checkbox = $(this);

        let url = '';
        let data = { _token: '<?php echo e(csrf_token()); ?>' };

        if ($(this).hasClass('toggle-sensitive')) {
            url = `/users/${id}/toggle-sensitive`;
            data.is_sensitive = checked;
        }
        else if ($(this).hasClass('toggle-tasks')) {
            url = `/users/${id}/toggle-tasks-allowed`;
            data.is_tasks_allowed = checked;
        }
        else if ($(this).hasClass('toggle-balance-sharing')) {
            url = `/users/${id}/toggle-balance-sharing`;
            data.is_balance_sharing_allowed = checked;
        }
        else if ($(this).hasClass('toggle-withdraw')) {
            url = `/users/${id}/toggle-withdraw`;
            data.is_withdraw_allowed = checked;
        }
        else if ($(this).hasClass('toggle-complaint')) {
            url = `/users/${id}/toggle-complaint`;
            data.is_complaint_allowed = checked;
        }
        else if ($(this).hasClass('toggle-withdraw-timer')) {
            url = `/users/${id}/toggle-withdraw-timer`;
            data.withdraw_timer = checked;
        }
        else if ($(this).hasClass('toggle-withdraw-without-package')) {
            url = `/users/${id}/toggle-withdraw-without-package`;
            data.withdraw_without_package = checked;
        }
        $.post(url, data)
         .done(() => toastr.success('Updated successfully'))
         .fail(() => {
             toastr.error('Update failed');
             $checkbox.prop('checked', !checked); // revert on error
         });
    });

</script>
</body>

</html><?php /**PATH E:\xampp\htdocs\FeatureDesk\resources\views/admin/user_details.blade.php ENDPATH**/ ?>