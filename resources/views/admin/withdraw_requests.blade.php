<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Withdraw Requests - Admin Panel</title>

    @include('admin.includes.headlinks')

    <style>
        /* Print styles unchanged */
        @media print {
            body * {
                visibility: hidden;
            }

            #printable-pending,
            #printable-pending * {
                visibility: visible;
            }

            #printable-pending {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                padding: 1cm;
                background: white;
            }

            .no-print,
            .no-print * {
                display: none !important;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                font-size: 12pt;
            }

            th,
            td {
                border: 1px solid #000;
                padding: 8px;
                text-align: left;
            }

            th {
                background-color: #f2f2f2 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            tfoot th {
                background-color: #e0e0e0 !important;
            }

            .nav-tabs,
            .tab-pane:not(#pending),
            .content-header,
            .main-header,
            .main-sidebar,
            .footer,
            .card-header {
                display: none !important;
            }
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        @include('admin.includes.navbar')
        @include('admin.includes.sidebar')

        <!-- Content Wrapper -->
        <div class="content-wrapper">

            <!-- Content Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Withdraw Requests</h1>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">

                            <div class="card card-primary card-outline card-outline-tabs">
                                <div class="card-header p-0 border-bottom-0">
                                    <ul class="nav nav-tabs" id="withdraw-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="pending-tab" data-toggle="pill" href="#pending" role="tab"
                                                aria-controls="pending" aria-selected="true">
                                                Pending <span class="badge badge-warning">{{ $pending->count() }}</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="approved-tab" data-toggle="pill" href="#approved" role="tab"
                                                aria-controls="approved" aria-selected="false">
                                                Approved <span class="badge badge-success">{{ $approved->count() }}</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="rejected-tab" data-toggle="pill" href="#rejected" role="tab"
                                                aria-controls="rejected" aria-selected="false">
                                                Rejected <span class="badge badge-danger">{{ $rejected->count() }}</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="cancelled-tab" data-toggle="pill" href="#cancelled" role="tab"
                                                aria-controls="cancelled" aria-selected="false">
                                                Cancelled <span class="badge badge-secondary">{{ $cancelled->count() }}</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="card-body">
                                    @include('admin.includes.success')
                                    <div class="tab-content" id="withdraw-tabs-content">

                                        <!-- PENDING TAB -->
                                        <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                                            <div class="mb-3 text-end no-print">
                                                <button type="button" class="btn btn-info btn-sm" onclick="printPendingTable()">
                                                    <i class="fas fa-print"></i> Print Pending Requests
                                                </button>

                                                <a href="{{ route('return.withdraw', ['status' => 'pending']) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to return all pending withdrawals? This action cannot be undone.')">
                                                    <i class="fas fa-undo"></i> Return All Withdrawals
                                                </a>
                                            </div>

                                            <div id="printable-pending">
                                                <h4 class="text-center mb-4">Pending Withdraw Requests: {{ $pending->count() }}, Amount: Rs {{ number_format($pending->sum('amount')) }}</h4>
                                                <p class="text-center mb-4">Printed on: <span id="print-date"></span></p>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped table-hover example1" id="example1">
                                                        <thead>
                                                             <tr>
                                                                <th>#</th>
                                                                <th>User</th>
                                                                <th>KYC Status</th>
                                                                <th>Method</th>
                                                                <th>Amount</th>
                                                                <th>Account Number</th>
                                                                <th>Account Title</th>
                                                                <th>Requested At</th>
                                                                <th class="no-print">Status</th>
                                                                <th>Message</th>
                                                                <th class="no-print">Actions</th>
                                                             </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($pending as $request)
                                                             <tr>
                                                                <td>{{ $request->id }}</td>
                                                                <td class="align-middle">
                                                                    @if($request->user)
                                                                    <div class="mb-2">
                                                                        <a target="_blank" href="{{ route('userDetails', ['id' => $request->user->id]) }}" class="fw-semibold text-decoration-none">
                                                                            {{ $request->user->username ?? 'N/A' }}
                                                                        </a>
                                                                        <div class="small text-muted">
                                                                            ID: {{ $request->user->id }} |
                                                                            {{ $request->user->phone ?? 'N/A' }}
                                                                        </div>
                                                                    </div>
                                                                    @else
                                                                    <div class="text-danger small">User Deleted</div>
                                                                    @endif

                                                                    <div class="border-top pt-1 mt-1">
                                                                        @if($request->last_approved_at)
                                                                        <small class="text-muted d-block">Last Withdraw</small>
                                                                        <span class="badge bg-light text-dark">
                                                                            {{ \Carbon\Carbon::parse($request->last_approved_at)->diffForHumans() }}
                                                                        </span>
                                                                        <div class="small text-muted">
                                                                            {{ \Carbon\Carbon::parse($request->last_approved_at)->format('d M Y, h:i A') }}
                                                                        </div>
                                                                        @else
                                                                        <span class="small text-muted">No previous withdraw</span>
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    @php
        $kyc = $request->user->kyc_status;
    @endphp

    @if($kyc == 'approved')
        <span class="badge badge-success px-3 py-2">
            Approved
        </span>
    @elseif($kyc == 'rejected')
        <span class="badge badge-danger px-3 py-2">
            Rejected
        </span>
    @elseif($kyc == 'submitted')
        <span class="badge badge-warning px-3 py-2">
            Under Review
        </span>
    @else
        <span class="badge badge-secondary px-3 py-2">
            Not Submitted
        </span>
    @endif
                                                                </td>
                                                                <td>
    {{ ucfirst($request->method ?? '') }}
    {{ $request->bank_name ?? '' }}
    
</td>
                                                                <td>{{ number_format($request->amount, 0) }}</td>
                                                                <td>{{ $request->account_number }}</td>
                                                                <td>{{ $request->account_title }}</td>
                                                                <td>{{ $request->created_at->format('d M Y') }}<br><small>{{ $request->created_at->format('h:i A') }}</small></td>
                                                                <td class="no-print"><span class="badge badge-warning">Pending</span></td>

                                                                <td>
@if($request->user->whatsapp)
    <!-- APPROVE -->
    <a 
        href="https://wa.me/{{ preg_replace('/^0/', '92', $request->user->whatsapp) }}?text={{ urlencode('Dear *'.$request->user->username.'*, your withdrawal of *Rs '.$request->amount.'* has been approved.') }}"
        target="_blank"
        class="btn btn-success btn-xs mr-1">
        <i class="fab fa-whatsapp"></i> Approve
    </a>

    <!-- REJECT -->
    <a 
        href="https://wa.me/{{ preg_replace('/^0/', '92', $request->user->whatsapp) }}?text={{ urlencode('Dear *'.$request->user->username.'*, your withdrawal of *Rs '.$request->amount.'* has been rejected.') }}"
        target="_blank"
        class="btn btn-danger btn-xs">
        <i class="fab fa-whatsapp"></i> Reject
    </a>
@else
        <span class="text-muted">No WhatsApp</span>
        {{-- or just leave empty --}}
    @endif
</td>

                                                                <td class="no-print">
                                                                    <a href="{{ route('approve_withdraw', $request->id) }}"
                                                                        class="btn btn-success btn-xs"
                                                                        onclick="return confirm('Approve this withdrawal?')">Approve</a>
                                                                    <button type="button"
                                                                        class="btn btn-danger btn-xs reject-btn"
                                                                        data-id="{{ $request->id }}"
                                                                        data-url="{{ route('reject_withdraw', $request->id) }}">
                                                                        Reject
                                                                    </button>
                                                                    <a href="{{ route('approve_process', $request->id) }}"
                                                                        class="btn btn-warning btn-xs"
                                                                        onclick="return confirm('Approve this withdrawal?')">Approve + Process</a>
                                                                    <a href="{{ route('edit_withdraw', $request->id) }}" class="btn btn-primary btn-xs">Edit</a>

                                                                    <!-- Delete Button -->
                                                                    <form action="{{ route('admin.withdraw.destroy', $request->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this withdrawal request? This action cannot be undone.')">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-danger btn-xs">Delete</button>
                                                                    </form>
                                                                </td>
                                                             </tr>
                                                            @empty
                                                             <tr>
                                                                <td colspan="9" class="text-center text-muted py-4">No pending requests</td>
                                                             </tr>
                                                            @endforelse
                                                        </tbody>
                                                        <tfoot>
                                                             <tr>
                                                                <th colspan="4" style="text-align:right">Total Amount:</th>
                                                                <th>{{ number_format($pending->sum('amount'), 0) }}</th>
                                                                <th colspan="6"></th>
                                                             </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- APPROVED TAB -->
                                        <div class="tab-pane fade" id="approved" role="tabpanel" aria-labelledby="approved-tab">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped table-hover" id="approvedWithdrawTable">
                                                    <thead>
                                                         <tr>
                                                            <th>#</th>
                                                            <th>User</th>
                                                            <th>Method</th>
                                                            <th>Amount</th>
                                                            <th>Account Number</th>
                                                            <th>Account Title</th>
                                                            <th>Status</th>
                                                            <th>Actions</th> <!-- NEW COLUMN -->
                                                         </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($approved as $request)
                                                         <tr>
                                                            <td>{{ $request->id }}</td>
                                                            <td>
                                                                @if($request->user)
                                                                <a target="_blank" href="{{ route('userDetails', ['id' => $request->user->id]) }}">
                                                                    <small class="d-block text-muted">ID: {{ $request->user->id }}</small>
                                                                    {{ $request->user->username ?? 'N/A' }}<br>
                                                                    {{ $request->user->phone ?? 'N/A' }}
                                                                </a>
                                                                @else
                                                                <span class="text-danger">User Deleted</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ ucfirst($request->method) }}
                                                                @if($request->method == 'bank' && $request->bank_name)
                                                                <br><small class="text-muted">{{ $request->bank_name }}</small>
                                                                @endif
                                                            </td>
                                                            <td>Rs {{ number_format($request->amount, 0) }}</td>
                                                            <td>{{ $request->account_number }}</td>
                                                            <td>{{ $request->account_title }}</td>
                                                            <td><span class="badge badge-success">Approved</span></td>
                                                            <td>
                                                                <form action="{{ route('admin.withdraw.destroy', $request->id) }}" method="POST" onsubmit="return confirm('Delete this approved request?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-xs">Delete</button>
                                                                </form>
                                                            </td>
                                                         </tr>
                                                        @empty
                                                         <tr>
                                                            <td colspan="8" class="text-center text-muted py-4">No approved requests</td>
                                                         </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- REJECTED TAB -->
                                        <div class="tab-pane fade" id="rejected" role="tabpanel" aria-labelledby="rejected-tab">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped table-hover" id="rejectedWithdrawTable">
                                                    <thead>
                                                         <tr>
                                                            <th>#</th>
                                                            <th>User</th>
                                                            <th>Method</th>
                                                            <th>Amount</th>
                                                            <th>Account Number</th>
                                                            <th>Account Title</th>
                                                            <th>Remarks</th>
                                                            <th>Refund</th>
                                                            <th>Status</th>
                                                            <th>Actions</th> <!-- NEW COLUMN -->
                                                         </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($rejected as $request)
                                                         <tr>
                                                            <td>{{ $request->id }}</td>
                                                            <td>
                                                                <a target="_blank" href="{{ route('userDetails', ['id' => $request->user->id]) }}">
                                                                    <small class="d-block text-muted">ID: {{ $request->user->id }}</small>
                                                                    {{ $request->user->username ?? 'N/A' }}<br>
                                                                    {{ $request->user->phone ?? 'N/A' }}
                                                                </a>
                                                            </td>
                                                            <td>{{ ucfirst($request->method) }}
                                                                @if($request->method == 'bank' && $request->bank_name)
                                                                <br><small class="text-muted">{{ $request->bank_name }}</small>
                                                                @endif
                                                            </td>
                                                            <td>Rs {{ number_format($request->amount, 0) }}</td>
                                                            <td>{{ $request->account_number }}</td>
                                                            <td>{{ $request->account_title }}</td>
                                                            <td>{{ $request->remarks ?? '—' }}</td>
                                                            <td><span class="badge badge-{{ $request->is_refund ? 'success' : 'secondary' }}">{{ $request->is_refund ? 'Yes' : 'No' }}</span></td>
                                                            <td><span class="badge badge-danger">Rejected</span></td>
                                                            <td>
                                                                <form action="{{ route('admin.withdraw.destroy', $request->id) }}" method="POST" onsubmit="return confirm('Delete this rejected request?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-xs">Delete</button>
                                                                </form>
                                                            </td>
                                                         </tr>
                                                        @empty
                                                         <tr>
                                                            <td colspan="10" class="text-center text-muted py-4">No rejected requests</td>
                                                         </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- CANCELLED TAB -->
                                        <div class="tab-pane fade" id="cancelled" role="tabpanel" aria-labelledby="cancelled-tab">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped table-hover" id="cancelledWithdrawTable">
                                                    <thead>
                                                         <tr>
                                                            <th>#</th>
                                                            <th>User</th>
                                                            <th>Method</th>
                                                            <th>Amount</th>
                                                            <th>Account Number</th>
                                                            <th>Account Title</th>
                                                            <th>Remarks</th>
                                                            <th>Status</th>
                                                            <th>Actions</th> <!-- NEW COLUMN -->
                                                         </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($cancelled as $request)
                                                         <tr>
                                                            <td>{{ $request->id }}</td>
                                                            <td>
                                                                @if($request->user?->id)
                                                                <a target="_blank" href="{{ route('userDetails', ['id' => $request->user->id]) }}">
                                                                    <small class="d-block text-muted">ID: {{ $request->user->id }}</small>
                                                                    {{ $request->user->username ?? 'N/A' }}<br>
                                                                    {{ $request->user->phone ?? 'N/A' }}
                                                                </a>
                                                                @else
                                                                <span class="text-muted">User not found</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                {{ ucfirst($request->method) }}
                                                                @if($request->method == 'bank' && $request->bank_name)
                                                                <br><small class="text-muted">{{ $request->bank_name }}</small>
                                                                @endif
                                                            </td>
                                                            <td>Rs {{ number_format($request->amount, 0) }}</td>
                                                            <td>{{ $request->account_number }}</td>
                                                            <td>{{ $request->account_title }}</td>
                                                            <td>{{ $request->remarks ?? '—' }}</td>
                                                            <td><span class="badge badge-warning">Cancelled</span></td>
                                                            <td>
                                                                <form action="{{ route('admin.withdraw.destroy', $request->id) }}" method="POST" onsubmit="return confirm('Delete this cancelled request?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-xs">Delete</button>
                                                                </form>
                                                            </td>
                                                         </tr>
                                                        @empty
                                                         <tr>
                                                            <td colspan="9" class="text-center text-muted py-4">No cancelled requests</td>
                                                         </tr>
                                                        @endforelse
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

        @include('admin.includes.version')
    </div>

    <!-- Rejection Remarks Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="" id="rejectForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="rejectModalLabel">Reject Withdrawal Request</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="checkbox" class="form-checkbox" id="payment" name="payment" value="1">
                            <label for="payment">Refund Payment</label>
                        </div>
                        <div class="form-group">
                            <label for="remarks">Remarks (reason for rejection)</label>
                            <textarea class="form-control" id="remarks" name="remarks" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Reject Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('admin.includes.footer_links')

    <script>
        $(document).ready(function() {
            $('#withdraw-tabs a').on('click', function (e) {
                e.preventDefault();
                $(this).tab('show');
            });

            $('.reject-btn').on('click', function() {
                var url = $(this).data('url');
                $('#rejectForm').attr('action', url);
                $('#rejectModal').modal('show');
            });
        });

        function printPendingTable() {
            document.getElementById('print-date').textContent = new Date().toLocaleString();
            window.print();
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#pendingWithdrawTable').DataTable({
                paging: false,
                info: false,
                searching: false,
                ordering: true,
                order: [],
                columnDefs: [
                    { orderable: false, targets: [0,1,2,4,5,6,7,8] },
                    {
                        targets: 3,
                        type: 'num-fmt',
                        render: $.fn.dataTable.render.number(',', '.', 0, '')
                    }
                ]
            });
        });
    </script>
</body>

</html>