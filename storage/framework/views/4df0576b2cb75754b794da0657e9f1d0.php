<!DOCTYPE html>
<html lang="en">
<?php $__env->startSection('title'); ?>
Orders
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
              <h1 class="m-0">Orders</h1>
            </div><!-- /.col -->
            <div class="col-sm-6"></div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card card-primary card-outline card-outline-tabs">
                <!-- Tabs Header -->
                <div class="card-header p-0 border-bottom-0">
                  <ul class="nav nav-tabs" id="orderStatusTabs" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" data-status="all" id="tab-all" data-toggle="tab" href="#all-orders" role="tab">
                        All <span class="badge badge-primary"><?php echo e($orders->count()); ?></span>
                      </a>
                    </li>
                    <?php
                      $uniqueStatuses = $orders->pluck('status')->unique()->filter()->values();
                    ?>
                    <?php $__currentLoopData = $uniqueStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <li class="nav-item">
                        <a class="nav-link" data-status="<?php echo e($status); ?>" id="tab-<?php echo e(Str::slug($status)); ?>" data-toggle="tab" href="#tab-<?php echo e(Str::slug($status)); ?>" role="tab">
                          <?php echo e($status); ?> <span class="badge badge-secondary"><?php echo e($orders->where('status', $status)->count()); ?></span>
                        </a>
                      </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </ul>
                </div>

                <div class="card-body">
                  <!-- Tab panes (empty, used by DataTables) -->
                  <div class="tab-content">
                    <div class="tab-pane fade show active" id="all-orders" role="tabpanel"></div>
                    <?php $__currentLoopData = $uniqueStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <div class="tab-pane fade" id="tab-<?php echo e(Str::slug($status)); ?>" role="tabpanel"></div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </div>

                  <?php echo $__env->make('admin.includes.success', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                  <!-- Orders Table -->
                  <div class="card card-primary">
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Sr#</th>
                          <th>User</th>
                          <th>Customer</th>
                          <th>Product</th>
                          <th>Quantity</th>
                          <th>Total Price</th>
                          <th>Address</th>
                          <th>Order At</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <tr>
                            <td><?php echo e($data->id); ?></td>
                            <td>
                              <a target="_blank" href="<?php echo e(route('userDetails', $data->user_id??'')); ?>"><?php echo e($data->username??''); ?></a>
                            </td>
                            <td>
                              <?php echo e($data->name); ?> <br>
                              <?php echo e($data->phone); ?>

                            </td>
                            <td>
                              <a target="_blank" href="<?php echo e(route('market.product.detail', $data->product_slug)); ?>"><?php echo e($data->product_name); ?></a>
                            </td>
                            <td><?php echo e($data->quantity); ?></td>
                            <td><?php echo e($data->total_price); ?></td>
                            <td><?php echo e($data->address); ?></td>
                            <td><?php echo e(\Carbon\Carbon::parse($data->created_at)->format('d M Y, h:i a')); ?></td>
                            <td>
                              <form action="<?php echo e(route('orders.updateStatus', $data->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <select name="status" class="form-select" onchange="this.form.submit()">
                                  <option value="Pending" <?php echo e($data->status == 'Pending' ? 'selected' : ''); ?>>Pending</option>
                                  <option value="Processing" <?php echo e($data->status == 'Processing' ? 'selected' : ''); ?>>Processing</option>
                                  <option value="Shipped" <?php echo e($data->status == 'Shipped' ? 'selected' : ''); ?>>Shipped</option>
                                  <option value="Delivered" <?php echo e($data->status == 'Delivered' ? 'selected' : ''); ?>>Delivered</option>
                                  <option value="Canceled" <?php echo e($data->status == 'Canceled' ? 'selected' : ''); ?>>Canceled</option>
                                  <option value="Refunded" <?php echo e($data->status == 'Refunded' ? 'selected' : ''); ?>>Refunded</option>
                                  <option value="Returned" <?php echo e($data->status == 'Returned' ? 'selected' : ''); ?>>Returned</option>
                                  <option value="Returned Address Not Found" <?php echo e($data->status == 'Returned Address Not Found' ? 'selected' : ''); ?>>Returned Address Not Found</option>
                                </select>
                              </form>
                            </td>
                          </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
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

  <!-- Custom Script for Tab Filtering (DataTables) -->
  <script>
    $(function() {
      // Ensure DataTable is initialized (if not already, your footer_links likely does it)
      var table = $('#example1').DataTable();

      // Filter function: search exactly in the Status column (index 8)
      function filterOrdersByStatus(status) {
        var columnIndex = 8; // 9th column (0-based)
        if (status === 'all') {
          table.column(columnIndex).search('').draw();
        } else {
          // Escape regex special characters
          var escapedStatus = status.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
          table.column(columnIndex).search('^' + escapedStatus + '$', true, false).draw();
        }
      }

      // Handle tab clicks
      $('#orderStatusTabs a').on('shown.bs.tab', function(e) {
        var status = $(this).data('status');
        filterOrdersByStatus(status);
        // Remember last active tab (optional)
        localStorage.setItem('activeOrderTab', status);
      });

      // Restore last active tab after page reload
      var lastActiveTab = localStorage.getItem('activeOrderTab');
      if (lastActiveTab && lastActiveTab !== 'all') {
        var targetTab = $('#orderStatusTabs a[data-status="' + lastActiveTab + '"]');
        if (targetTab.length) {
          targetTab.tab('show');
          filterOrdersByStatus(lastActiveTab);
        }
      } else {
        // Default: show all orders
        filterOrdersByStatus('all');
      }
    });
  </script>
</body>
</html><?php /**PATH E:\xampp\htdocs\FeatureDesk\resources\views/market/admin/orders.blade.php ENDPATH**/ ?>