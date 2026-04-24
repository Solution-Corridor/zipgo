<!DOCTYPE html>
<html lang="en">
@section('title')
Users
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
                            <h1 class="m-0"> Users</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6"></div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">

                            <div class="card card-primary card-outline card-outline-tabs">

                                @include('admin.includes.success')

                                <div class="card-body">

                                    <table id="example1" class="table table-bordered table-striped example1">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>UserName</th>
                                                <th>WhatsApp</th>
                                                <th>Ref</th>
                                                <th>Invested</th>
                                                <th>Withdraws</th>
                                                <th>Balance</th>
                                                <th>Plans</th>
                                                <th>Status</th>
                                                <th>Since</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($users as $u)
                                            <tr>
                                                <td>{{ $u->id }}</td>
                                                <td><a target="_blank" href="{{ route('userDetails', ['id' => $u->id]) }}">{{ $u->username }}
                                                        <small class="d-block text-muted">{{ $u->phone }}</small>
                                                    </a>
                                                </td>
                                                <td>
                                                    @if ($u->whatsapp)
                                                    <a href="https://wa.me/{{ $u->whatsapp }}" target="_blank" class="btn btn-success btn-sm">
                                                        <i class="fab fa-whatsapp"></i> {{ $u->whatsapp }}
                                                    </a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($u->referrer)
                                                    <a target="_blank" href="{{ route('userDetails', $u->referrer->id) }}">
                                                        {{ $u->referrer->username ?? '—' }}
                                                        <small class="d-block text-muted">{{ $u->referrer->phone ?? '—' }}</small>
                                                    </a>
                                                    @else
                                                    <span class="text-muted">—</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    @php
                                                    $total_invested = $u->payments()->where('status', 'approved')->sum('amount');
                                                    @endphp
                                                    {{ number_format($total_invested) }}
                                                </td>

                                                <td>
                                                    @php
                                                    $total_withdraw = $u->withdraws()->where('status', 'approved')->sum('amount');
                                                    @endphp
                                                    {{ number_format($total_withdraw) }}
                                                </td>
                                                <td>{{ number_format($u->balance ?? 0) }}</td>



                                                <td>
                                                    @if($u->active_plans_count > 0)
                                                    <span class="badge bg-success">{{ $u->active_plans_count }}</span>
                                                    @else
                                                    <span class="badge bg-secondary">0</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    @switch($u->status)
                                                        @case(0)
                                                            <span class="badge bg-warning">Pending</span>
                                                            @break
                                                        @case(1)
                                                            <span class="badge bg-success">Active</span>
                                                            @break
                                                        @case(2)
                                                            <span class="badge bg-danger">Suspended</span>
                                                            @break
                                                    @endswitch
                                                </td>

                                                <td>{{ \Carbon\Carbon::parse($u->created_at)->format('d M y • h:i:s A') }}</td>

                                                <td>
                                                    <div class="d-flex align-items-center" style="gap:6px;">

                                                        <form action="{{ route('deleteUser', ['id' => $u->id]) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-xs" title="Delete"
                                                                onclick="return confirm('Are you sure to delete this user?')">
                                                                <i class="fa fa-trash-alt"></i>
                                                            </button>
                                                        </form>

                                                        <a href="{{ route('editUser', ['id' => $u->id]) }}" class="btn btn-primary btn-xs" title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>

                                                        @if($u->status == 0)
                                                        <a href="{{ route('activateUser', ['id' => $u->id]) }}" class="btn btn-success btn-xs" title="Activate">
                                                            <i class="fas fa-check-circle"></i>
                                                        </a>
                                                        @endif

                                                        @if($u->status == 1)
                                                        <a href="{{ route('suspendUser', ['id' => $u->id]) }}" class="btn btn-warning btn-xs" title="Suspend">
                                                            <i class="fas fa-pause"></i>
                                                        </a>
                                                        @endif

                                                        @if($u->status == 2)
                                                        <a href="{{ route('activateUser', ['id' => $u->id]) }}" class="btn btn-success btn-xs" title="Activate">
                                                            <i class="fas fa-check-circle"></i>
                                                        </a>
                                                        @endif

                                                        <form action="{{ route('admin.force-logout', $u->id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn btn-dark btn-xs"
                                                                title="Force Logout (end all sessions)"
                                                                onclick="return confirm('Force logout this user from all devices? They will be logged out immediately.')">
                                                                <i class="fas fa-sign-out-alt"></i>
                                                            </button>
                                                        </form>

                                                    </div>
                                                </td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
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

</body>

</html>