<!DOCTYPE html>
<html lang="en">

@section('title')
Expert Verification
@endsection

@include('admin.includes.headlinks')

@php
$currentTab = request()->query('tab', 'pending');
$experts = $currentTab === 'pending' ? $pendingExperts : $verifiedExperts;
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
              <h1 class="m-0">Expert Verification</h1>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card card-primary card-outline">
                <div class="card-header p-0 border-bottom-0">
                  <ul class="nav nav-tabs" id="verificationTabs" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link {{ $currentTab == 'pending' ? 'active' : '' }}" id="pending-tab" data-toggle="pill" href="#pending" role="tab" aria-controls="pending" aria-selected="true">
                        <i class="fa fa-clock"></i>&nbsp;&nbsp;Pending Verification
                        <span class="badge badge-warning ml-1">{{ $pendingExperts->count() }}</span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link {{ $currentTab == 'verified' ? 'active' : '' }}" id="verified-tab" data-toggle="pill" href="#verified" role="tab" aria-controls="verified" aria-selected="false">
                        <i class="fa fa-check-circle"></i>&nbsp;&nbsp;Verified
                        <span class="badge badge-success ml-1">{{ $verifiedExperts->count() }}</span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link {{ $currentTab == 'rejected' ? 'active' : '' }}" id="rejected-tab" data-toggle="pill" href="#rejected" role="tab" aria-controls="rejected" aria-selected="false">
                        <i class="fa fa-times-circle"></i>&nbsp;&nbsp;Rejected
                        <span class="badge badge-danger ml-1">{{ $rejectedExperts->count() }}</span>
                      </a>
                    </li>
                  </ul>
                </div>

                <div class="card-body">
                  @include('includes.success')

                  <div class="tab-content">
                    {{-- PENDING TAB --}}
                    <div class="tab-pane fade {{ $currentTab == 'pending' ? 'show active' : '' }}" id="pending" role="tabpanel">
                      <table class="table table-bordered table-hover table-striped">
                        <thead class="thead-dark">
                          <tr>
                            <th>ID</th>
                            <th>Expert (User)</th>
                            <th>Service</th>
                            <th>NIC Details</th>
                            <th>Documents</th>
                            <th>Payment Status</th>
                            <th>Submitted On</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @forelse ($pendingExperts as $expert)
                          <tr>
                            <td>{{ $expert->id }}</td>
                            <td>
                              <strong>{{ $expert->username ?? 'N/A' }}</strong><br>
                              <small class="text-muted">{{ $expert->email }}</small>
                              <small>{{ $expert->phone ?? 'No phone' }}</small>
                            </td>
                            <td>{{ $expert->service_name ?? 'Not assigned' }}</td>
                            <td>
                              <strong>Full Name:</strong> {{ $expert->full_name ?? '—' }}<br>
                              <strong>NIC #:</strong> {{ $expert->nic_number ?? '—' }}<br>
                              <strong>Expiry:</strong> {{ $expert->nic_expiry ? \Carbon\Carbon::parse($expert->nic_expiry)->format('d M Y') : '—' }}
                            </td>
                            <td>
                              @if($expert->nic_front_image)
                              <a href="{{ asset($expert->nic_front_image) }}" target="_blank" class="btn btn-xs btn-info">NIC Front</a>
                              @endif
                              @if($expert->nic_back_image)
                              <a href="{{ asset($expert->nic_back_image) }}" target="_blank" class="btn btn-xs btn-info">NIC Back</a>
                              @endif
                              @if($expert->selfie_image)
                              <a href="{{ asset($expert->selfie_image) }}" target="_blank" class="btn btn-xs btn-primary">Selfie</a>
                              @endif
                            </td>
                            <td>
                              <span class="badge {{ $expert->payment_status == 'Paid' ? 'badge-success' : '' }} {{ $expert->payment_status == 'Pending' ? 'badge-warning' : '' }} {{ $expert->payment_status == 'Failed' ? 'badge-danger' : '' }} {{ $expert->payment_status == 'Refunded' ? 'badge-secondary' : '' }}">
                                {{ $expert->payment_status ?? 'Pending' }}
                              </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($expert->created_at)->format('d M Y h:i A') }}</td>
                            <td>
                              <div class="d-flex gap-2">
                                <form action="{{ route('admin.experts.verify', $expert->id) }}" method="POST"
                                  onsubmit="return confirm('Verify this expert? Their profile will become active.')">
                                  @csrf
                                  <button type="submit" class="btn btn-success btn-sm mr-1">
                                    <i class="fa fa-check"></i>
                                  </button>
                                </form>

                                <form action="{{ route('admin.experts.reject', $expert->id) }}" method="POST"
                                  onsubmit="return confirm('Reject this expert? Their profile will be marked as rejected.')">
                                  @csrf
                                  <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fa fa-times"></i>
                                  </button>
                                </form>
                              </div>
                            </td>
                          </tr>
                          @empty
                          <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                              No pending expert verifications.
                            </td>
                          </tr>
                          @endforelse
                        </tbody>
                      </table>
                    </div>

                    {{-- VERIFIED TAB --}}
                    <div class="tab-pane fade {{ $currentTab == 'verified' ? 'show active' : '' }}" id="verified" role="tabpanel">
                      <table class="table table-bordered table-hover table-striped">
                        <thead class="thead-dark">
                          <tr>
                            <th>ID</th>
                            <th>Expert (User)</th>
                            <th>Service</th>
                            <th>NIC Details</th>
                            <th>Documents</th>
                            <th>Payment Status</th>
                            <th>Verified On</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          @forelse ($verifiedExperts as $expert)
                          <tr>
                            <td>{{ $expert->id }}</td>
                            <td>
                              <strong>{{ $expert->username ?? 'N/A' }}</strong><br>
                              <small class="text-muted">{{ $expert->email }}</small>
                            </td>
                            <td>{{ $expert->service_name ?? 'Not assigned' }}</td>
                            <td>
                              <strong>Full Name:</strong> {{ $expert->full_name ?? '—' }}<br>
                              <strong>NIC #:</strong> {{ $expert->nic_number ?? '—' }}<br>
                              <strong>Expiry:</strong> {{ $expert->nic_expiry ? \Carbon\Carbon::parse($expert->nic_expiry)->format('d M Y') : '—' }}
                            </td>
                            <td>
                              @if($expert->nic_front_image)
                              <a href="{{ asset($expert->nic_front_image) }}" target="_blank" class="btn btn-xs btn-info">NIC Front</a>
                              @endif
                              @if($expert->nic_back_image)
                              <a href="{{ asset($expert->nic_back_image) }}" target="_blank" class="btn btn-xs btn-info">NIC Back</a>
                              @endif
                              @if($expert->selfie_image)
                              <a href="{{ asset($expert->selfie_image) }}" target="_blank" class="btn btn-xs btn-primary">Selfie</a>
                              @endif
                            </td>
                            <td>
                              <span class="badge {{ $expert->payment_status == 'Paid' ? 'badge-success' : '' }} {{ $expert->payment_status == 'Pending' ? 'badge-warning' : '' }} {{ $expert->payment_status == 'Failed' ? 'badge-danger' : '' }}">
                                {{ $expert->payment_status ?? 'Pending' }}
                              </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($expert->updated_at)->format('d M Y h:i A') }}</td>
                            <td>
                              <div class="d-flex gap-2">
                                <form action="{{ route('admin.experts.verify', $expert->id) }}" method="POST"
                                  onsubmit="return confirm('Verify this expert? Their profile will become active.')">
                                  @csrf
                                  <button type="submit" class="btn btn-success btn-sm mr-1">
                                    <i class="fa fa-check"></i>
                                  </button>
                                </form>

                                <form action="{{ route('admin.experts.reject', $expert->id) }}" method="POST"
                                  onsubmit="return confirm('Reject this expert? Their profile will be marked as rejected.')">
                                  @csrf
                                  <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fa fa-times"></i>
                                  </button>
                                </form>
                              </div>
                            </td>
                          </tr>
                          @empty
                          <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                              No verified experts yet.
                            </td>
                          </tr>
                          @endforelse
                        </tbody>
                      </table>
                    </div>

                    {{-- REJECTED TAB --}}
                    <div class="tab-pane fade {{ $currentTab == 'rejected' ? 'show active' : '' }}" id="rejected" role="tabpanel">
                      <table class="table table-bordered table-hover table-striped">
                        <thead class="thead-dark">
                          <tr>
                            <th>ID</th>
                            <th>Expert (User)</th>
                            <th>Service</th>
                            <th>NIC Details</th>
                            <th>Documents</th>
                            <th>Payment Status</th>
                            <th>Rejected On</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          @forelse ($rejectedExperts as $expert)
                          <tr>
                            <td>{{ $expert->id }}</td>
                            <td>
                              <strong>{{ $expert->username ?? 'N/A' }}</strong><br>
                              <small class="text-muted">{{ $expert->email }}</small>
                            </td>
                            <td>{{ $expert->service_name ?? 'Not assigned' }}</td>
                            <td>
                              <strong>Full Name:</strong> {{ $expert->full_name ?? '—' }}<br>
                              <strong>NIC #:</strong> {{ $expert->nic_number ?? '—' }}<br>
                              <strong>Expiry:</strong> {{ $expert->nic_expiry ? \Carbon\Carbon::parse($expert->nic_expiry)->format('d M Y') : '—' }}
                            </td>
                            <td>
                              @if($expert->nic_front_image)
                              <a href="{{ asset($expert->nic_front_image) }}" target="_blank" class="btn btn-xs btn-info">NIC Front</a>
                              @endif
                              @if($expert->nic_back_image)
                              <a href="{{ asset($expert->nic_back_image) }}" target="_blank" class="btn btn-xs btn-info">NIC Back</a>
                              @endif
                              @if($expert->selfie_image)
                              <a href="{{ asset($expert->selfie_image) }}" target="_blank" class="btn btn-xs btn-primary">Selfie</a>
                              @endif
                            </td>
                            <td>
                              <span class="badge {{ $expert->payment_status == 'Paid' ? 'badge-success' : '' }} {{ $expert->payment_status == 'Pending' ? 'badge-warning' : '' }} {{ $expert->payment_status == 'Failed' ? 'badge-danger' : '' }} {{ $expert->payment_status == 'Refunded' ? 'badge-secondary' : '' }}">
                                {{ $expert->payment_status ?? 'Pending' }}
                              </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($expert->updated_at)->format('d M Y h:i A') }}</td>
                            <td>
                              <div class="d-flex gap-2">
                                <form action="{{ route('admin.experts.verify', $expert->id) }}" method="POST"
                                  onsubmit="return confirm('Verify this expert? Their profile will become active.')">
                                  @csrf
                                  <button type="submit" class="btn btn-success btn-sm mr-1">
                                    <i class="fa fa-check"></i>
                                  </button>
                                </form>

                                <form action="{{ route('admin.experts.reject', $expert->id) }}" method="POST"
                                  onsubmit="return confirm('Reject this expert? Their profile will be marked as rejected.')">
                                  @csrf
                                  <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fa fa-times"></i>
                                  </button>
                                </form>
                              </div>
                            </td>
                          </tr>
                          @empty
                          <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                              No rejected experts.
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
          </div>
      </section>
    </div>

    @include('admin.includes.version')
  </div>

  @include('admin.includes.footer_links')
</body>

</html>