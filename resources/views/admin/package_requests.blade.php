<!DOCTYPE html>
<html lang="en">
@section('title')
Package Plans - Your Investment Platform
@endsection

<!-- Start top links -->
@include('admin.includes.headlinks')

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        <!-- Navbar & Sidebar -->
        @include('admin.includes.navbar')
        @include('admin.includes.sidebar')

        <!-- Content Wrapper -->
        <div class="content-wrapper">

            <!-- Content Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Package Plans</h1>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            @include('admin.includes.success')
                            <div class="card card-primary card-outline card-outline-tabs">
                                <div class="card-header p-0 border-bottom-0">
                                    <ul class="nav nav-tabs" id="package-requests-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="pending-tab" data-toggle="pill" href="#pending" role="tab"
                                                aria-controls="pending" aria-selected="true">
                                                Pending <span class="badge badge-warning">{{ $pendingRequests->count() }}</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="approved-tab" data-toggle="pill" href="#approved" role="tab"
                                                aria-controls="approved" aria-selected="false">
                                                Approved <span class="badge badge-success">{{ $approvedRequests->count() }}</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="rejected-tab" data-toggle="pill" href="#rejected" role="tab"
                                                aria-controls="rejected" aria-selected="false">
                                                Rejected <span class="badge badge-danger">{{ $rejectedRequests->count() }}</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="card-body">
                                    <div class="tab-content" id="package-requests-tabsContent">

                                        <!-- PENDING TAB -->
                                        <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped" id="pendingTable">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>User</th>
                                                            <th>Package</th>
                                                            <th>Payment Method</th>
                                                            <th>Transaction ID</th>
                                                            <th>Amount</th>
                                                            <th>Receipt</th>
                                                            <th>Notes</th>
                                                            <th>Status</th>
                                                            <th>Created At</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                        $totalAmount = 0;
                                                        @endphp
                                                        @foreach ($pendingRequests as $payment)
                                                        <tr>
                                                            <td>{{ $payment->id }}</td>
                                                            <td>
                                                                <a target="_blank" href="{{ route('userDetails', ['id' => $payment->user_id]) }}">
                                                                    <small class="d-block text-muted">ID: {{ $payment->user_id }}</small>
                                                                    {{ $payment->username ?? 'N/A' }}<br>
                                                                    {{ $payment->phone ?? 'N/A' }}
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <a target="_blank" href="{{ route('packages.show', $payment->package_id) }}">
                                                                {{ $payment->plan_name }}
                                                                </a>
                                                            </td>
                                                            <td>
                                                                @if($payment->payment_method_id==100)
                                                                Internal Fund
                                                                @else
                                                                {{ $payment->payment_method_name }} - {{ $payment->payment_method_title }}
                                                                @endif
                                                            </td>
                                                            <td>{{ $payment->transaction_id }}</td>
                                                            <td>{{ number_format($payment->amount) }}
                                                                @php
                                                                $totalAmount += $payment->amount;
                                                                @endphp
                                                            </td>
                                                            <td>
                                                                @if($payment->receipt_path)
                                                                <a href="{{ asset($payment->receipt_path) }}" target="_blank">View</a>
                                                                @else
                                                                N/A
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($payment->is_upgrade)
                                                                <span class="badge badge-warning">Upgrade Request</span>

                                                                @if($payment->deducted_from_wallet > 0)
                                                                <br>
                                                                <small class="text-success">
                                                                    Wallet deducted: {{ number_format($payment->deducted_from_wallet, 2) }} Rs
                                                                </small>
                                                                @endif
                                                                @if($payment->notes)
                                                                <br>
                                                                <small class="text-info">
                                                                    Note: {{ $payment->notes }}
                                                                </small>
                                                                @endif

                                                                @else
                                                                <span class="badge badge-primary">Regular Payment</span>
                                                                @endif
                                                            </td>
                                                            <td><span class="badge badge-warning">{{ ucfirst($payment->status) }}</span></td>
                                                            <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('d M Y, h:i:s A') }}</td>
                                                            <td>
                                                                <a href="{{ route('approve_package', $payment->id) }}"
                                                                    class="btn btn-success btn-xs"
                                                                    onclick="return confirm('Approve this package?');">Approve</a>
                                                                <button type="button"
            class="btn btn-danger btn-xs reject-btn"
            data-id="{{ $payment->id }}"
            data-url="{{ route('reject_package', $payment->id) }}">
        Reject
    </button>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th colspan="5">Total Amount</th>
                                                            <th colspan="6">{{ number_format($totalAmount, 0) }} Rs</th>
                                                            
                                                        </tr>

                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- APPROVED TAB -->
                                        <div class="tab-pane fade" id="approved" role="tabpanel" aria-labelledby="approved-tab">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped" id="approvedTable">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>User</th>
                                                            <th>Package</th>
                                                            <th>Payment Method</th>
                                                            <th>Transaction ID</th>
                                                            <th>Amount</th>
                                                            <th>Receipt</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($approvedRequests as $payment)
                                                        <tr>
                                                            <td>{{ $payment->id }}</td>
                                                            <td>
                                                                <a target="_blank" href="{{ route('userDetails', ['id' => $payment->user_id]) }}">
                                                                    <small class="d-block text-muted">ID: {{ $payment->user_id }}</small>
                                                                    {{ $payment->username ?? 'N/A' }}<br>
                                                                    {{ $payment->phone ?? 'N/A' }}
                                                                </a>
                                                            </td>
                                                            <td>{{ $payment->plan_name }}</td>
                                                            <td>{{ $payment->payment_method_name }} - {{ $payment->payment_method_title }}</td>
                                                            <td>{{ $payment->transaction_id }}</td>
                                                            <td>{{ number_format($payment->amount) }}</td>
                                                            <td>
                                                                @if($payment->receipt_path)
                                                                <a href="{{ asset($payment->receipt_path) }}" target="_blank">View</a>
                                                                @else
                                                                N/A
                                                                @endif
                                                            </td>
                                                            <td><span class="badge badge-success">{{ ucfirst($payment->status) }}</span></td>
                                                            <td>
                                                                <a href="{{ route('approve_package', $payment->id) }}"
                                                                    class="btn btn-success btn-xs"
                                                                    onclick="return confirm('Approve this package?');">Approve</a>
                                                                <a href="{{ route('reject_package', $payment->id) }}"
                                                                    class="btn btn-danger btn-xs"
                                                                    onclick="return confirm('Reject this package?');">Reject</a>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- REJECTED TAB -->
                                        <div class="tab-pane fade" id="rejected" role="tabpanel" aria-labelledby="rejected-tab">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped" id="rejectedTable">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>User</th>
                                                            <th>Package</th>
                                                            <th>Payment Method</th>
                                                            <th>Transaction ID</th>
                                                            <th>Amount</th>
                                                            <th>Receipt</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($rejectedRequests as $payment)
                                                        <tr>
                                                            <td>{{ $payment->id }}</td>
                                                            <td>
                                                                <a target="_blank" href="{{ route('userDetails', ['id' => $payment->user_id]) }}">
                                                                    <small class="d-block text-muted">ID: {{ $payment->user_id }}</small>
                                                                    {{ $payment->username ?? 'N/A' }}<br>
                                                                    {{ $payment->phone ?? 'N/A' }}
                                                                </a>
                                                            </td>
                                                            <td>{{ $payment->plan_name }}</td>
                                                            <td>{{ $payment->payment_method_name }} - {{ $payment->payment_method_title }}</td>
                                                            <td>{{ $payment->transaction_id }}</td>
                                                            <td>{{ number_format($payment->amount) }}</td>
                                                            <td>
                                                                @if($payment->receipt_path)
                                                                <a href="{{ asset($payment->receipt_path) }}" target="_blank">View</a>
                                                                @else
                                                                N/A
                                                                @endif
                                                            </td>
                                                            <td><span class="badge badge-danger">{{ ucfirst($payment->status) }}</span></td>
                                                            <td>
                                                                <a href="{{ route('approve_package', $payment->id) }}"
                                                                    class="btn btn-success btn-xs"
                                                                    onclick="return confirm('Approve this package?');">Approve</a>
                                                                <a href="{{ route('reject_package', $payment->id) }}"
                                                                    class="btn btn-danger btn-xs"
                                                                    onclick="return confirm('Reject this package?');">Reject</a>
                                                            </td>
                                                        </tr>
                                                        @endforeach
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




            <!-- Rejection Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="" id="rejectForm">
                @csrf
                

                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Reject Package Request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="admin_note">Admin Note / Reason for Rejection</label>
                        <textarea class="form-control" id="admin_note" name="admin_note" rows="4" 
                                  placeholder="Enter reason (will be visible to user or for internal record)" required></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Confirm Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>



        </div>

        <!-- Footer -->
        @include('admin.includes.version')

    </div>

    <!-- Scripts -->
    @include('admin.includes.footer_links')

<!-- DataTables Initialization -->
    <script>
        $(document).ready(function() {

        $(document).on('click', '.reject-btn', function() {
        var id   = $(this).data('id');
        var url  = $(this).data('url');

        // Set form action dynamically
        $('#rejectForm').attr('action', url);

        // Optional: show request ID in title
        $('#rejectModalLabel').text('Reject Package Request #' + id);

        $('#rejectModal').modal('show');
    });

            // Pending table (has extra Action column)
            $('#pendingTable').DataTable({
                responsive: true,
                columnDefs: [
                    { responsivePriority: 1, targets: 1 }, // User
                    { responsivePriority: 2, targets: 9 }, // Action
                    { responsivePriority: 3, targets: 0 }, // #
                    { responsivePriority: 4, targets: 5 }  // Amount
                ],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100]
            });

            // Approved table
            $('#approvedTable').DataTable({
                responsive: true,
                columnDefs: [
                    { responsivePriority: 1, targets: 1 }, // User
                    { responsivePriority: 2, targets: 0 }, // #
                    { responsivePriority: 3, targets: 5 }  // Amount
                ],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100]
            });

            // Rejected table (same as approved)
            $('#rejectedTable').DataTable({
                responsive: true,
                columnDefs: [
                    { responsivePriority: 1, targets: 1 }, // User
                    { responsivePriority: 2, targets: 0 }, // #
                    { responsivePriority: 3, targets: 5 }  // Amount
                ],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100]
            });

            // Fix layout when switching tabs (very common issue)
            $('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
                $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust().responsive.recalc();
            });

        });
    </script>

    <!-- Optional mobile-friendly tweaks -->
    <style>
        @media (max-width: 576px) {
            .table th, .table td {
                font-size: 0.85rem;
                padding: 0.5rem;
            }
            .btn-xs {
                padding: 0.25rem 0.4rem;
                font-size: 0.75rem;
            }
            .badge {
                font-size: 0.7rem;
            }
        }
    </style>

</body>

</html>