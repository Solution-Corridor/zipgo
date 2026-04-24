<!DOCTYPE html>
<html lang="en">
@section('title') KYC Verifications @endsection

@include('admin.includes.headlinks')

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        @include('admin.includes.navbar')
        @include('admin.includes.sidebar')

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">KYC Verifications</h1>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">

                    @include('includes.success')

                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="kyc-tabs" role="tablist">

                                <li class="nav-item">
                                    <a class="nav-link active" id="pending-review-tab" data-toggle="pill" href="#pending-review" role="tab">
                                        <i class="fas fa-clock"></i> Pending Review
                                        <span class="badge badge-warning right">{{ $pendingReview->count() }}</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="approved-tab" data-toggle="pill" href="#approved" role="tab">
                                        <i class="fas fa-check-circle"></i> Approved
                                        <span class="badge badge-success right">{{ $approved->count() }}</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="rejected-tab" data-toggle="pill" href="#rejected" role="tab">
                                        <i class="fas fa-times-circle"></i> Rejected
                                        <span class="badge badge-danger right">{{ $rejected->count() }}</span>
                                    </a>
                                </li>

                            </ul>
                        </div>

                        <div class="card-body p-3">
                            <div class="tab-content" id="kyc-tabContent">

                                <!-- Pending Review Tab (pending + submitted) -->
                                <div class="tab-pane fade show active" id="pending-review">
                                    @if($pendingReview->isEmpty())
                                    <div class="alert alert-info text-center py-4">
                                        No KYC verifications waiting for review at the moment.
                                    </div>
                                    @else
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-sm">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>User</th>
                                                    <th>Full Name</th>
                                                    <th>Phone / Whatsapp</th>
                                                    <th>Submitted</th>
                                                    <th>Status</th>
                                                    <th>Message</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($pendingReview as $kyc)
                                                <tr>
                                                    <td>{{ $kyc->id }}</td>
                                                    <td>
                                                        <a target="_blank" href="{{ route('userDetails', $kyc->user?->id ?? '') }}">
                                                            {{ $kyc->user?->username ?? '—' }}
                                                            <small class="d-block text-muted">{{ $kyc->user?->phone ?? '—' }}</small>
                                                        </a>
                                                    </td>
                                                    <td>{{ $kyc->full_name ?? '—' }}
                                                        <small class="d-block text-muted">{{ $kyc->gender ?? '—' }}</small>
                                                        <small class="d-block text-muted">{{ $kyc->city ?? '—' }}</small>
                                                    </td>
                                                    <td>
                                                        {{$kyc->phone ?? '—'}}<br>
                                                        {{$kyc->whatsapp ?? '—'}}
                                                    </td>
                                                    <td>{{ $kyc->submitted_at?->format('d M Y • h:i A') ?? '—' }}</td>
                                                    <td>
                                                        <span class="badge {{ $kyc->status === 'submitted' ? 'badge-info' : 'badge-warning' }}">
                                                            {{ ucfirst($kyc->status) }}
                                                        </span>
                                                    </td>
                                                    
                                                    <td>
    @if($kyc->user && $kyc->user->whatsapp)
        <!-- APPROVE -->
        <a 
            href="https://wa.me/{{ preg_replace('/^0/', '92', $kyc->user->whatsapp) }}?text={{ urlencode('Dear *'.$kyc->full_name.'*, your KYC has been approved.') }}"
            target="_blank"
            class="btn btn-success btn-xs mr-1">
            <i class="fab fa-whatsapp"></i> Approve
        </a>

        <!-- REJECT -->
        <a 
            href="https://wa.me/{{ preg_replace('/^0/', '92', $kyc->user->whatsapp) }}?text={{ urlencode('Dear *'.$kyc->full_name.'*, your KYC has been rejected. Documents not verified.') }}"
            target="_blank"
            class="btn btn-danger btn-xs">
            <i class="fab fa-whatsapp"></i> Reject
        </a>
    @else
        <span class="text-muted">No WhatsApp</span>
        {{-- or just leave empty --}}
    @endif
</td>
                                                    <td>
                                                        <div class="d-flex">

                                                            <!-- Approve -->
                                                            <form action="{{ route('admin.kyc.approve', $kyc->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Approve this KYC verification?')"
                                                                class="mr-1">
                                                                @csrf
                                                                <button type="submit" class="btn btn-success btn-xs">
                                                                    <i class="fas fa-check"></i> Approve
                                                                </button>
                                                            </form>

                                                            <!-- Reject -->
                                                            <button type="button" class="btn btn-danger btn-xs reject-btn"
                                                                data-kyc-id="{{ $kyc->id }}"
                                                                data-action="{{ route('admin.kyc.reject', $kyc->id) }}">
                                                                <i class="fas fa-times"></i> Reject
                                                            </button>

                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif
                                </div>

                                <!-- Approved Tab -->
                                <div class="tab-pane fade" id="approved">
                                    @if($approved->isEmpty())
                                    <div class="alert alert-info text-center py-4">
                                        No approved KYC verifications yet.
                                    </div>
                                    @else
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-sm">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>User</th>
                                                    <th>Full Name</th>
                                                    <th>Phone / Whatsapp</th>
                                                    <th>Approved At</th>
                                                    <th>Admin Note</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($approved as $kyc)
                                                <tr>
                                                    <td>{{ $kyc->id }}</td>
                                                    <td>
                                                        <a target="_blank" href="{{ route('userDetails', $kyc->user?->id ?? '') }}">
                                                            {{ $kyc->user?->username ?? '—' }}
                                                            <small class="d-block text-muted">{{ $kyc->user?->phone ?? '—' }}</small>
                                                        </a>
                                                    </td>
                                                    <td>{{ $kyc->full_name ?? '—' }}</td>
                                                    <td>
                                                        {{$kyc->phone ?? '—'}}<br>
                                                        {{$kyc->whatsapp ?? '—'}}
                                                    </td>
                                                    <td>{{ $kyc->reviewed_at?->format('d M Y • h:i A') ?? '—' }}</td>
                                                    
                                                    <td>{{ $kyc->admin_note ?? '' }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif
                                </div>

                                <!-- Rejected Tab -->
                                <div class="tab-pane fade" id="rejected">
                                    @if($rejected->isEmpty())
                                    <div class="alert alert-info text-center py-4">
                                        No rejected KYC verifications yet.
                                    </div>
                                    @else
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-sm">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>User</th>
                                                    <th>Full Name</th>
                                                    <th>Phone / Whatsapp</th>
                                                    <th>Rejected At</th>
                                                    <th>Admin Note</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($rejected as $kyc)
                                                <tr>
                                                    <td>{{ $kyc->id }}</td>
                                                    <td>
                                                        <a target="_blank" href="{{ route('userDetails', $kyc->user?->id ?? '') }}">
                                                            {{ $kyc->user?->username ?? '—' }}
                                                            <small class="d-block text-muted">{{ $kyc->user?->phone ?? '—' }}</small>
                                                        </a>
                                                    </td>
                                                    <td>{{ $kyc->full_name ?? '—' }}</td>
                                                    <td>
                                                        {{$kyc->phone ?? '—'}}<br>
                                                        {{$kyc->whatsapp ?? '—'}}
                                                    </td>
                                                    <td>{{ $kyc->reviewed_at?->format('d M Y • h:i A') ?? '—' }}</td>
                                                    
                                                    <td>{{ $kyc->admin_note ?? '<span class="text-muted">—</span>' }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </section>
            
        </div>

        <!-- Reject Reason Modal -->
        <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="rejectModalLabel">Reject KYC Verification</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form id="rejectForm" method="POST" action="">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="id" id="reject_kyc_id">
                            <div class="form-group">
                                <label for="admin_note">Admin Note / Reason for Rejection <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="admin_note" name="admin_note" rows="4" 
                                          placeholder="Enter reason for rejection (will be visible to the user)" required></textarea>
                                <small class="form-text text-muted">Be clear and professional — this note is usually shown to the user.</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-times"></i> Confirm Reject
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @include('admin.includes.version')
    </div>

    @include('admin.includes.footer_links')

    <!-- Custom Script (placed after footer_links to ensure jQuery is loaded) -->
    <script>
    $(document).ready(function() {
        $('.reject-btn').on('click', function() {
            var kycId   = $(this).data('kyc-id');
            var action  = $(this).data('action');

            $('#reject_kyc_id').val(kycId);
            $('#rejectForm').attr('action', action);
            $('#admin_note').val(''); // clear previous note

            $('#rejectModal').modal('show');
        });
    });
    </script>
</body>
</html>