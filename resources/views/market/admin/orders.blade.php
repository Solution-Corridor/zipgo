<!DOCTYPE html>
<html lang="en">
@section('title')
Orders
@endsection
<!-- Start top links -->
@include('admin.includes.headlinks')

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">
    <!-- Start navbar -->
    @include('admin.includes.navbar')
    <!-- end navbar -->

    <!-- Start Sidebar -->
    @include('admin.includes.sidebar')
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
                        All <span class="badge badge-primary">{{ $orders->count() }}</span>
                      </a>
                    </li>
                    @php
                      $uniqueStatuses = $orders->pluck('status')->unique()->filter()->values();
                    @endphp
                    @foreach($uniqueStatuses as $status)
                      <li class="nav-item">
                        <a class="nav-link" data-status="{{ $status }}" id="tab-{{ Str::slug($status) }}" data-toggle="tab" href="#tab-{{ Str::slug($status) }}" role="tab">
                          {{ $status }} <span class="badge badge-secondary">{{ $orders->where('status', $status)->count() }}</span>
                        </a>
                      </li>
                    @endforeach
                  </ul>
                </div>

                <div class="card-body">
                  <!-- Tab panes (empty, used by DataTables) -->
                  <div class="tab-content">
                    <div class="tab-pane fade show active" id="all-orders" role="tabpanel"></div>
                    @foreach($uniqueStatuses as $status)
                      <div class="tab-pane fade" id="tab-{{ Str::slug($status) }}" role="tabpanel"></div>
                    @endforeach
                  </div>

                  @include('admin.includes.success')

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
                        @foreach ($orders as $data)
                          <tr>
                            <td>{{ $data->id }}</td>
                            <td>
                              <a target="_blank" href="{{ route('userDetails', $data->user_id??'') }}">{{ $data->username??'' }}</a>
                            </td>
                            <td>
                              {{ $data->name }} <br>
                              {{ $data->phone }}
                            </td>
                            <td>
                              <a target="_blank" href="{{ route('market.product.detail', $data->product_slug) }}">{{ $data->product_name }}</a>
                            </td>
                            <td>{{ $data->quantity }}</td>
                            <td>{{ $data->total_price }}</td>
                            <td>{{ $data->address }}</td>
                            <td>{{ \Carbon\Carbon::parse($data->created_at)->format('d M Y, h:i a') }}</td>
                            <td>
                              <form action="{{ route('orders.updateStatus', $data->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-select" onchange="this.form.submit()">
                                  <option value="Pending" {{ $data->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                  <option value="Processing" {{ $data->status == 'Processing' ? 'selected' : '' }}>Processing</option>
                                  <option value="Shipped" {{ $data->status == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                                  <option value="Delivered" {{ $data->status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                                  <option value="Canceled" {{ $data->status == 'Canceled' ? 'selected' : '' }}>Canceled</option>
                                  <option value="Refunded" {{ $data->status == 'Refunded' ? 'selected' : '' }}>Refunded</option>
                                  <option value="Returned" {{ $data->status == 'Returned' ? 'selected' : '' }}>Returned</option>
                                  <option value="Returned Address Not Found" {{ $data->status == 'Returned Address Not Found' ? 'selected' : '' }}>Returned Address Not Found</option>
                                </select>
                              </form>
                            </td>
                          </tr>
                        @endforeach
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
    @include('admin.includes.version')
    <!------ end Footer -->
  </div>
  <!-- ./wrapper -->

  <!------ Start Footer links-->
  @include('admin.includes.footer_links')
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
</html>