<!DOCTYPE html>
<html lang="en">

@section('title')
Complaints - Admin Panel
@endsection

@include('admin.includes.headlinks')

@php
$currentTab = request()->query('tab', 'pending'); // default to pending
$complaints = $currentTab === 'pending' ? $pending : $others;
@endphp

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        @include('admin.includes.navbar')
        @include('admin.includes.sidebar')

        <div class="content-wrapper">

            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Complaints</h1>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">

                            <div class="card card-danger card-outline">
                                <div class="card-header p-0 border-bottom-0">
                                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="pending-tab" data-toggle="pill" href="#pending" role="tab" aria-controls="pending" aria-selected="true"><i class="fa fa-check-circle"></i>&nbsp;&nbsp;Pending</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" id="others-tab" data-toggle="pill" href="#others" role="tab" aria-controls="others" aria-selected="false"><i class="fa fa-ban"></i>&nbsp;&nbsp;Others</a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="card-body">

                                    @include('includes.success')

                                    <div class="tab-content" id="custom-tabs-four-tabContent">
                                        <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">

                                        <a href="{{ route('finish.complaints') }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to mark all pending complaints as no valid? This action cannot be undone.')">
                                                    <i class="fas fa-undo"></i> No Valid Complaints
                                                </a>
                                                <br><br>

                                            <table class="table table-bordered table-hover table-striped mb-0">
                                                <thead class="thead-dark">
                                                     <tr>
                                                        <th>#</th>
                                                        <th>User</th>
                                                        <th>Subject & Detail</th>
                                                        <th>Status</th>
                                                        <th>Admin Reply</th>
                                                        <th>Date</th>
                                                        <th>Actions</th>
                                                     </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($complaints as $complaint)
                                                    <tr>
                                                        <td>{{ $complaint->id }}</td>

                                                        <td>
                                                            @if ($complaint->user)
                                                            <a target="_blank" href="{{ route('userDetails', ['id' => $complaint->user->id]) }}">
                                                                <small class="d-block text-muted">ID: {{ $complaint->user->id}}</small>
                                                                {{ $complaint->user->username ?? 'N/A' }} <br>
                                                                {{ $complaint->user->phone ?? 'N/A' }}
                                                            </a>
                                                            @else
                                                            <span class="text-muted">— (Deleted User)</span>
                                                            @endif
                                                        </td>

                                                        <td>
                                                            <strong>{{ $complaint->subject }}</strong>
                                                            <div class="text-muted small mt-1">
                                                                {{ $complaint->detail }}
                                                            </div>
                                                            @if($complaint->screenshot)
                                                            <a href="{{ asset($complaint->screenshot) }}" target="_blank">
                                                                View Attachment
                                                            </a>
                                                            @endif
                                                        </td>

                                                        <td>
                                                            <span class="badge
                                                    {{ $complaint->status === 'pending'     ? 'badge-warning'  : '' }}
                                                    {{ $complaint->status === 'in_progress' ? 'badge-info'     : '' }}
                                                    {{ $complaint->status === 'resolved'    ? 'badge-success'  : '' }}
                                                    {{ $complaint->status === 'rejected'    ? 'badge-danger'   : '' }}
                                                    {{ $complaint->status === 'not_valid'   ? 'badge-secondary': '' }}">
                                                                {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                                                            </span>
                                                        </td>

                                                        <td class="text-muted small">
                                                            {{ $complaint->admin_reply ?? '--' }}
                                                            @if($complaint->attachments)
                                                            <a href="{{ asset($complaint->attachments) }}" target="_blank" rel="noopener noreferrer">View Attachment</a>
                                                            @endif
                                                        </td>


                                                        <td>{{ $complaint->created_at->format('d M Y h:i A') }}</td>

                                                        <td>
                                                            <button type="button"
                                                                class="btn btn-sm btn-primary reply-btn"
                                                                data-toggle="modal"
                                                                data-target="#replyModal"
                                                                data-id="{{ $complaint->id }}"
                                                                data-status="{{ $complaint->status }}"
                                                                data-reply="{{ addslashes($complaint->admin_reply ?? '') }}">
                                                                Reply / Update
                                                            </button>

                                                            <!-- Delete Button -->
                                                            <form action="{{ route('admin.complaints.destroy', $complaint->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this complaint? This action cannot be undone.')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="8" class="text-center text-muted py-5">
                                                            No complaints found in this category
                                                        </td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>


                                        <div class="tab-pane fade" id="others" role="tabpanel" aria-labelledby="others-tab">
                                            <table class="table table-bordered table-hover table-striped mb-0">
                                                <thead class="thead-dark">
                                                     <tr>
                                                        <th>#</th>
                                                        <th>User</th>
                                                        <th>Subject & Detail</th>
                                                        <th>Status</th>
                                                        <th>Admin Reply</th>
                                                        <th>Date</th>
                                                        <th>Actions</th>
                                                     </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($others as $complaint)
                                                    <tr>
                                                        <td>{{ $complaint->id }}</td>

                                                        <td>
                                                            @if ($complaint->user)
                                                            <a target="_blank" href="{{ route('userDetails', ['id' => $complaint->user->id]) }}">
                                                                <small class="d-block text-muted">ID: {{ $complaint->user->id}}</small>
                                                                {{ $complaint->user->username ?? 'N/A' }} <br>
                                                                {{ $complaint->user->phone ?? 'N/A' }}
                                                            </a>
                                                            @else
                                                            <span class="text-muted">— (Deleted User)</span>
                                                            @endif
                                                        </td>

                                                        <td>
                                                            <strong>{{ $complaint->subject }}</strong>
                                                            <div class="text-muted small mt-1">
                                                                {{ $complaint->detail }}
                                                            </div>
                                                            @if($complaint->screenshot)
                                                            <a href="{{ asset($complaint->screenshot) }}" target="_blank" rel="noopener noreferrer">View Attachment</a>
                                                            @endif
                                                        </td>

                                                        <td>
                                                            <span class="badge
                                                    {{ $complaint->status === 'pending'     ? 'badge-warning'  : '' }}
                                                    {{ $complaint->status === 'in_progress' ? 'badge-info'     : '' }}
                                                    {{ $complaint->status === 'resolved'    ? 'badge-success'  : '' }}
                                                    {{ $complaint->status === 'rejected'    ? 'badge-danger'   : '' }}
                                                    {{ $complaint->status === 'not_valid'   ? 'badge-secondary': '' }}">
                                                                {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                                                            </span>
                                                        </td>

                                                        <td>
                                                            <div class="text-muted small mt-1">
                                                                {{ $complaint->admin_reply ?? '--' }}
                                                            </div>
                                                            @if($complaint->attachments)
                                                            <a href="{{ asset($complaint->attachments) }}" target="_blank" rel="noopener noreferrer">View Attachment</a>
                                                            @endif
                                                        </td>



                                                        <td>{{ $complaint->created_at->format('d M Y h:i A') }}</td>

                                                        <td>
                                                            <button type="button"
                                                                class="btn btn-sm btn-primary reply-btn"
                                                                data-toggle="modal"
                                                                data-target="#replyModal"
                                                                data-id="{{ $complaint->id }}"
                                                                data-status="{{ $complaint->status }}"
                                                                data-reply="{{ addslashes($complaint->admin_reply ?? '') }}">
                                                                Reply / Update
                                                            </button>

                                                            <!-- Delete Button -->
                                                            <form action="{{ route('admin.complaints.destroy', $complaint->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this complaint? This action cannot be undone.')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="8" class="text-center text-muted py-5">
                                                            No complaints found in this category
                                                        </td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>


                                    </div>

                                </div>
                            </div>
                        </div>
            </section>
        </div>


        <!-- Reply Modal -->
        <div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="replyModalLabel">
                            Reply to Complaint #<span id="modalComplaintId"></span>
                        </h5>
                        <button type="button" class="btn-close close" data-dismiss="modal" aria-label="Close">X</button>
                    </div>

                    <form action="{{ route('admin.complaints.update') }}" method="POST" enctype="multipart/form-data" id="replyForm">
                        @csrf

                        <div class="modal-body">
                            <input type="hidden" name="id" id="modalIdField">

                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="modalStatus" class="form-control" required>
                                    <option value="pending">Pending</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="resolved">Resolved</option>
                                    <option value="rejected">Rejected</option>
                                    <option value="not_valid">Not Valid</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="admin_reply" class="form-label">Admin Reply / Resolution Note</label>
                                <textarea name="admin_reply" id="modalReply" class="form-control" rows="4"
                                    placeholder="Enter your reply or resolution details..."></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="attachments" class="form-label">Attach Screenshot / Files (optional)</label>
                                <input type="file" name="attachment" id="attachments" class="form-control" multiple accept="image/*,.pdf">
                                <small class="text-muted">You can select multiple files (images, pdfs)</small>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Complaint</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const replyButtons = document.querySelectorAll('.reply-btn');

    replyButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            // Get data attributes from the clicked button
            const complaintId   = this.getAttribute('data-id');
            const currentStatus = this.getAttribute('data-status');
            const currentReply  = this.getAttribute('data-reply');

            // Fill modal fields
            document.getElementById('modalComplaintId').textContent = complaintId;
            document.getElementById('modalIdField').value = complaintId;
            document.getElementById('modalStatus').value = currentStatus;
            document.getElementById('modalReply').value  = currentReply || '';
        });
    });

});
</script>

        @include('admin.includes.version')
    </div>

    @include('admin.includes.footer_links')

</body>

</html>