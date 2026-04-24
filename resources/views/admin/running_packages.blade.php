<!DOCTYPE html>
<html lang="en">

@section('title')
Running Packages - Admin Panel
@endsection

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
                            <h1 class="m-0">Running Packages</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Running Packages</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">

                            <div class="card">
                                @include('includes.success')

                                {{-- Tabs navigation --}}
                                <div class="card-header">
                                    <ul class="nav nav-tabs card-header-tabs" id="package-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="running-tab" data-toggle="tab" href="#running" role="tab" aria-controls="running" aria-selected="true">
                                                Running Packages
                                                <span class="badge badge-success ml-1">{{ count($runningPackages) }}</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="expired-tab" data-toggle="tab" href="#expired" role="tab" aria-controls="expired" aria-selected="false">
                                                Expired Packages
                                                <span class="badge badge-danger ml-1">{{ count($expiredPackages) }}</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                {{-- Tab panes --}}
                                <div class="card-body">
                                    <div class="tab-content" id="package-tabContent">

                                        {{-- Running packages tab --}}
                                        <div class="tab-pane fade show active" id="running" role="tabpanel" aria-labelledby="running-tab">
                                            <div class="table-responsive">
                                                <table class="example1 table table-bordered table-hover table-striped" id="example1">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>User</th>
                                                            <th>Package</th>
                                                            <th>Investment</th>
                                                            <th>Daily Profit Range</th>
                                                            <th>Duration</th>
                                                            <th>Approved</th>
                                                            <th>Expires</th>
                                                            <th>Days Left</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($runningPackages as $package)
                                                        <tr>
                                                            <td>{{ $package->id }}</td>

                                                            <td>
                                                                @if ($package->user)
                                                                <a target="_blank" href="{{ route('userDetails', ['id' => $package->user->id]) }}">
                                                                    <small class="d-block text-muted">ID: {{ $package->user->id}}</small>
                                                                    {{ $package->user->username ?? 'N/A' }} <br>
                                                                    {{ $package->user->phone ?? 'N/A' }}
                                                                </a>
                                                                @else
                                                                <span class="text-muted">— (Deleted User)</span>
                                                                @endif
                                                            </td>

                                                            <td>
                                                                <strong>{{ $package->package->name ?? '—' }}</strong>
                                                                <small class="d-block text-muted">ID: {{ $package->plan_id }}</small>
                                                            </td>

                                                            <td class="text-bold">
                                                                {{ number_format($package->amount, 0) }}
                                                            </td>

                                                            <td>
                                                                {{ number_format($package->package->daily_profit_min ?? 0, 0) }} —
                                                                {{ number_format($package->package->daily_profit_max ?? 0, 0) }}
                                                            </td>

                                                            <td>
                                                                {{ $package->package->duration_days ?? '—' }} days
                                                            </td>

                                                            <td>
                                                                {{ $package->approved_at 
                                                                    ? \Carbon\Carbon::parse($package->approved_at)->format('d M Y . h:i A') 
                                                                    : '—' }}
                                                            </td>

                                                            <td class="{{ \Carbon\Carbon::parse($package->expires_at)->isPast() ? 'text-danger' : '' }}">
                                                                {{ $package->expires_at 
                                                                    ? \Carbon\Carbon::parse($package->expires_at)->format('d M Y . h:i A') 
                                                                    : '—' }}
                                                            </td>

                                                            <td class="font-weight-bold">
                                                                @php
                                                                    $daysLeft = now()->diffInDays($package->expires_at, false);
                                                                    $wholeDays = floor($daysLeft);
                                                                @endphp

                                                                @if ($wholeDays > 0)
                                                                    <span class="badge badge-success">{{ $wholeDays }}</span>
                                                                @elseif ($wholeDays === 0)
                                                                    <span class="badge badge-warning">Expires today</span>
                                                                @else
                                                                    <span class="badge badge-danger">{{ abs($wholeDays) }}</span>
                                                                @endif
                                                            </td>

                                                            <td class="d-flex align-items-center gap-1">

    {{-- Edit Button --}}
    <a href="{{ route('plan.edit', $package->id) }}" 
       class="btn btn-xs btn-primary m-auto" 
       title="Edit">
        <i class="fa fa-edit"></i>
    </a>

    {{-- Expire Button --}}
    @if(!\Carbon\Carbon::parse($package->expires_at)->isPast())
        <form action="{{ route('plan.expire', $package->id) }}" 
              method="POST" 
              style="display:inline-block; margin:0;">
            @csrf
            @method('PUT')
            <button type="submit" 
                    class="btn btn-xs btn-danger" 
                    title="Expire"
                    onclick="return confirm('Are you sure?')">
                <i class="fa fa-times"></i>
            </button>
        </form>
    @else
        <span class="badge badge-secondary">
            <i class="fa fa-check"></i>
        </span>
    @endif

</td>
                                                        </tr>
                                                        @empty
                                                        <tr>
                                                            <td colspan="10" class="text-center text-muted py-5">
                                                                No running/active packages at the moment
                                                            </td>
                                                        </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        {{-- Expired packages tab --}}
                                        <div class="tab-pane fade" id="expired" role="tabpanel" aria-labelledby="expired-tab">
                                            <div class="table-responsive">
                                                <table class="example1 table table-bordered table-hover table-striped">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>User</th>
                                                            <th>Package</th>
                                                            <th>Investment</th>
                                                            <th>Daily Profit Range</th>
                                                            <th>Duration</th>
                                                            <th>Approved</th>
                                                            <th>Expires</th>
                                                            <th>Days Left</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($expiredPackages as $package)
                                                        <tr>
                                                            <td>{{ $package->id }}</td>

                                                            <td>
                                                                @if ($package->user)
                                                                <a target="_blank" href="{{ route('userDetails', ['id' => $package->user->id]) }}">
                                                                    <small class="d-block text-muted">ID: {{ $package->user->id}}</small>
                                                                    {{ $package->user->username ?? 'N/A' }} <br>
                                                                    {{ $package->user->phone ?? 'N/A' }}
                                                                </a>
                                                                @else
                                                                <span class="text-muted">— (Deleted User)</span>
                                                                @endif
                                                            </td>

                                                            <td>
                                                                <strong>{{ $package->package->name ?? '—' }}</strong>
                                                                <small class="d-block text-muted">ID: {{ $package->plan_id }}</small>
                                                            </td>

                                                            <td class="text-bold">
                                                                {{ number_format($package->amount, 0) }}
                                                            </td>

                                                            <td>
                                                                {{ number_format($package->package->daily_profit_min ?? 0, 0) }} —
                                                                {{ number_format($package->package->daily_profit_max ?? 0, 0) }}
                                                            </td>

                                                            <td>
                                                                {{ $package->package->duration_days ?? '—' }} days
                                                            </td>

                                                            <td>
                                                                {{ $package->approved_at 
                                                                    ? \Carbon\Carbon::parse($package->approved_at)->format('d M Y . h:i A') 
                                                                    : '—' }}
                                                            </td>

                                                            <td class="{{ \Carbon\Carbon::parse($package->expires_at)->isPast() ? 'text-danger' : '' }}">
                                                                {{ $package->expires_at 
                                                                    ? \Carbon\Carbon::parse($package->expires_at)->format('d M Y . h:i A') 
                                                                    : '—' }}
                                                            </td>

                                                            <td class="font-weight-bold">
                                                                @php
                                                                    $daysLeft = now()->diffInDays($package->expires_at, false);
                                                                    $wholeDays = floor($daysLeft);
                                                                @endphp

                                                                @if ($wholeDays > 0)
                                                                    <span class="badge badge-success">{{ $wholeDays }}</span>
                                                                @elseif ($wholeDays === 0)
                                                                    <span class="badge badge-warning">Expires today</span>
                                                                @else
                                                                    <span class="badge badge-danger">{{ abs($wholeDays) }}</span>
                                                                @endif
                                                            </td>

                                                            <td>
                                                                {{-- Edit Button --}}
                                                                <a href="{{ route('plan.edit', $package->id) }}" 
       class="btn btn-xs btn-primary m-auto" 
       title="Edit">
        <i class="fa fa-edit"></i>
    </a>
                                                               
                                                            </td>
                                                        </tr>
                                                        @empty
                                                        <tr>
                                                            <td colspan="10" class="text-center text-muted py-5">
                                                                No expired packages at the moment
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
                    </div>
                </div>
            </section>
        </div>

        @include('admin.includes.version')
    </div>

    @include('admin.includes.footer_links')

</body>

</html>