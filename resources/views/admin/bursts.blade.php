<!DOCTYPE html>
<html lang="en">

@section('title')
Bursts Record
@endsection

@include('admin.includes.headlinks')

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        @include('admin.includes.navbar')
        @include('admin.includes.sidebar')

        <!-- Content Wrapper -->
        <div class="content-wrapper">

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <!-- Tabs -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary card-outline">
                                <div class="card-header p-2">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="pill" href="#today" role="tab">Today</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="pill" href="#alltime" role="tab">All Time Details</a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="card-body">
                                    <div class="tab-content">
                                        <!-- Today Tab -->
                                        <div class="tab-pane fade show active" id="today">
                                            
                                            <!-- Summary Boxes for Today -->
                                            <div class="row mb-4">
                                                <div class="col-lg-4 col-6">
                                                    <div class="small-box bg-info">
                                                        <div class="inner">
                                                            <h3>{{ $todaySummary['total']['count'] }}</h3>
                                                            <p>Total Bursts</p>
                                                        </div>
                                                        <div class="icon">
                                                            <i class="fas fa-spinner"></i>
                                                        </div>
                                                        <div class="small-box-footer bg-info-dark">
                                                            <strong>Amount: {{ number_format($todaySummary['total']['amount'], 2) }} Rs</strong>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-lg-4 col-6">
                                                    <div class="small-box bg-success">
                                                        <div class="inner">
                                                            <h3>{{ $todaySummary['wins']['count'] }}</h3>
                                                            <p>Wins</p>
                                                        </div>
                                                        <div class="icon">
                                                            <i class="fas fa-trophy"></i>
                                                        </div>
                                                        <div class="small-box-footer bg-success-dark">
                                                            <strong>Win Amount: {{ number_format($todaySummary['wins']['amount'], 2) }} Rs</strong>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-lg-4 col-6">
                                                    <div class="small-box bg-danger">
                                                        <div class="inner">
                                                            <h3>{{ $todaySummary['bets']['count'] }}</h3>
                                                            <p>Bets (Losses)</p>
                                                        </div>
                                                        <div class="icon">
                                                            <i class="fas fa-times-circle"></i>
                                                        </div>
                                                        <div class="small-box-footer bg-danger-dark">
                                                            <strong>Bet Amount: {{ number_format($todaySummary['bets']['amount'], 2) }} Rs</strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Net Profit/Loss Box -->
                                            @php
                                                $todayNet = $todaySummary['wins']['amount'] - $todaySummary['bets']['amount'];
                                                $todayNetClass = $todayNet >= 0 ? 'success' : 'danger';
                                                $todayNetIcon = $todayNet >= 0 ? 'arrow-up' : 'arrow-down';
                                            @endphp
                                            
                                            <div class="row mb-4">
                                                <div class="col-12">
                                                    <div class="info-box bg-{{ $todayNetClass }}">
                                                        <span class="info-box-icon"><i class="fas fa-{{ $todayNetIcon }}"></i></span>
                                                        <div class="info-box-content">
                                                            <span class="info-box-text">Net Result (Today)</span>
                                                            <span class="info-box-number">{{ number_format(abs($todayNet), 2) }} Rs {{ $todayNet >= 0 ? 'Profit' : 'Loss' }}</span>
                                                            <div class="progress">
                                                                <div class="progress-bar" style="width: 100%"></div>
                                                            </div>
                                                            <span class="progress-description">
                                                                {{ $todaySummary['wins']['count'] }} Wins vs {{ $todaySummary['bets']['count'] }} Bets
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Today's Transactions Table -->
                                            <table class="table table-hover table-bordered text-nowrap todayTable" id="todayTable">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>User</th>
                                                        <th>Type</th>
                                                        <th>Amount</th>
                                                        <th>Details</th>
                                                        <th>Date / Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($todayTrx as $trx)
                                                        <tr>
                                                            <td>{{ $trx->id }}</td>
                                                            <td>
                                                                @if($trx->user)
                                                                    <a target="_blank" href="{{ route('userDetails', $trx->user->id) }}">
                                                                        <small class="d-block text-muted">ID: {{ $trx->user->id }}</small>
                                                                        <strong>{{ $trx->user->username ?? '—' }}</strong><br>
                                                                        {{ $trx->user->phone ?? 'N/A' }}
                                                                    </a>
                                                                @else
                                                                    <span class="text-muted">— (System / Deleted)</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <span class="badge {{ $trx->trx_type === 'burst_win' ? 'badge-success' : 'badge-danger' }}">
                                                                    {{ $trx->trx_type === 'burst_win' ? 'WIN' : 'BET' }}
                                                                </span>
                                                            </td>
                                                            <td class="{{ $trx->trx_type === 'burst_win' ? 'text-success fw-bold' : 'text-danger' }}">
                                                                {{ number_format($trx->amount, 2) }} Rs
                                                            </td>
                                                            <td>{{ $trx->detail ?? '—' }}</td>
                                                            <td>{{ $trx->created_at?->format('d M Y • h:i.s A') ?? '—' }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="6" class="text-center text-muted py-5">
                                                                <i class="fas fa-info-circle me-2"></i>No spin transactions recorded for today yet
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                                <tfoot>
                                                    <tr class="bg-light">
                                                        <th colspan="3" class="text-right">Totals:</th>
                                                        <th>
                                                            <span class="text-success">Win: {{ number_format($todaySummary['wins']['amount'], 2) }}</span> / 
                                                            <span class="text-danger">Bet: {{ number_format($todaySummary['bets']['amount'], 2) }}</span>
                                                        </th>
                                                        <th colspan="2"></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>

                                        <!-- All Time Tab -->
                                        <div class="tab-pane fade" id="alltime">
                                            
                                            <!-- Summary Boxes for All Time -->
                                            <div class="row mb-4">
                                                <div class="col-lg-4 col-6">
                                                    <div class="small-box bg-info">
                                                        <div class="inner">
                                                            <h3>{{ $allSummary['total']['count'] }}</h3>
                                                            <p>Total Bursts (All Time)</p>
                                                        </div>
                                                        <div class="icon">
                                                            <i class="fas fa-spinner"></i>
                                                        </div>
                                                        <div class="small-box-footer bg-info-dark">
                                                            <strong>Amount: {{ number_format($allSummary['total']['amount'], 2) }} Rs</strong>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-lg-4 col-6">
                                                    <div class="small-box bg-success">
                                                        <div class="inner">
                                                            <h3>{{ $allSummary['wins']['count'] }}</h3>
                                                            <p>Total Wins</p>
                                                        </div>
                                                        <div class="icon">
                                                            <i class="fas fa-trophy"></i>
                                                        </div>
                                                        <div class="small-box-footer bg-success-dark">
                                                            <strong>Win Amount: {{ number_format($allSummary['wins']['amount'], 2) }} Rs</strong>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-lg-4 col-6">
                                                    <div class="small-box bg-danger">
                                                        <div class="inner">
                                                            <h3>{{ $allSummary['bets']['count'] }}</h3>
                                                            <p>Total Bets (Losses)</p>
                                                        </div>
                                                        <div class="icon">
                                                            <i class="fas fa-times-circle"></i>
                                                        </div>
                                                        <div class="small-box-footer bg-danger-dark">
                                                            <strong>Bet Amount: {{ number_format($allSummary['bets']['amount'], 2) }} Rs</strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Net Profit/Loss Box - All Time -->
                                            @php
                                                $allNet = $allSummary['wins']['amount'] - $allSummary['bets']['amount'];
                                                $allNetClass = $allNet >= 0 ? 'success' : 'danger';
                                                $allNetIcon = $allNet >= 0 ? 'arrow-up' : 'arrow-down';
                                            @endphp
                                            
                                            <div class="row mb-4">
                                                <div class="col-6">
                                                    <div class="info-box bg-{{ $allNetClass }}">
                                                        <span class="info-box-icon"><i class="fas fa-{{ $allNetIcon }}"></i></span>
                                                        <div class="info-box-content">
                                                            <span class="info-box-text">Net Result (All Time)</span>
                                                            <span class="info-box-number">{{ number_format(abs($allNet), 2) }} Rs {{ $allNet >= 0 ? 'Profit' : 'Loss' }}</span>
                                                            <div class="progress">
                                                                <div class="progress-bar" style="width: 100%"></div>
                                                            </div>
                                                            <span class="progress-description">
                                                                {{ $allSummary['wins']['count'] }} Wins vs {{ $allSummary['bets']['count'] }} Bets
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            

                                            <!-- Win Rate Box -->
                                            @php
                                                $winRate = $allSummary['total']['count'] > 0 
                                                    ? round(($allSummary['wins']['count'] / $allSummary['total']['count']) * 100, 2) 
                                                    : 0;
                                            @endphp
                                            
                                            
                                                <div class="col-6">
                                                    <div class="info-box bg-warning">
                                                        <span class="info-box-icon"><i class="fas fa-percent"></i></span>
                                                        <div class="info-box-content">
                                                            <span class="info-box-text">Win Rate (All Time)</span>
                                                            <span class="info-box-number">{{ $winRate }}%</span>
                                                            <div class="progress">
                                                                <div class="progress-bar" style="width: {{ $winRate }}%"></div>
                                                            </div>
                                                            <span class="progress-description">
                                                                {{ $allSummary['wins']['count'] }} wins out of {{ $allSummary['total']['count'] }} total bursts
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- All Time Transactions Table -->
                                            <table class="table table-hover table-bordered text-nowrap alltimeTable" id="alltimeTable" style="width:100%">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>User</th>
                                                        <th>Type</th>
                                                        <th>Amount</th>
                                                        <th>Details</th>
                                                        <th>Date / Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($allTrx as $trx)
                                                        <tr>
                                                            <td>{{ $trx->id }}</td>
                                                            <td>
                                                                @if($trx->user)
                                                                    <a target="_blank" href="{{ route('userDetails', $trx->user->id) }}">
                                                                        <small class="d-block text-muted">ID: {{ $trx->user->id }}</small>
                                                                        <strong>{{ $trx->user->username ?? '—' }}</strong><br>
                                                                        {{ $trx->user->phone ?? 'N/A' }}
                                                                    </a>
                                                                @else
                                                                    <span class="text-muted">— (System / Deleted)</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <span class="badge {{ $trx->trx_type === 'burst_win' ? 'badge-success' : 'badge-danger' }}">
                                                                    {{ $trx->trx_type === 'burst_win' ? 'WIN' : 'BET' }}
                                                                </span>
                                                            </td>
                                                            <td class="{{ $trx->trx_type === 'burst_win' ? 'text-success fw-bold' : 'text-danger' }}">
                                                                {{ number_format($trx->amount, 2) }} Rs
                                                            </td>
                                                            <td>{{ $trx->detail ?? '—' }}</td>
                                                            <td>{{ $trx->created_at?->format('d M Y • h:i.s A') ?? '—' }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="6" class="text-center text-muted py-5">
                                                                <i class="fas fa-info-circle me-2"></i>No spin transactions recorded yet
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                                <tfoot>
                                                    <tr class="bg-light">
                                                        <th colspan="3" class="text-right">Totals:</th>
                                                        <th>
                                                            <span class="text-success">Win: {{ number_format($allSummary['wins']['amount'], 2) }}</span> / 
                                                            <span class="text-danger">Bet: {{ number_format($allSummary['bets']['amount'], 2) }}</span>
                                                        </th>
                                                        <th colspan="2"></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
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

    <!-- DataTables Initialization -->

<script>
$(function () {
    // Today Table
    $("#todayTable").DataTable({
        "responsive": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "order": [[0, "desc"]],
        "info": true,
        "autoWidth": false,
        "pageLength": 25,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "buttons": ["copy", "excel", "pdf", "print", "csv", "colvis"]
    }).buttons().container().appendTo('#todayTable_wrapper .col-md-6:eq(0)');

    // All Time Table
    $("#alltimeTable").DataTable({
        "responsive": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "order": [[0, "desc"]],
        "info": true,
        "autoWidth": false,
        "pageLength": 25,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "buttons": ["copy", "excel", "pdf", "print", "csv", "colvis"]
    }).buttons().container().appendTo('#alltimeTable_wrapper .col-md-6:eq(0)');

    // Keep your tab fix (very good to have)
    $('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
        var target = $(e.target).attr("href");
        if (target === '#today') {
            $('#todayTable').DataTable().columns.adjust().responsive.recalc();
        } else if (target === '#alltime') {
            $('#alltimeTable').DataTable().columns.adjust().responsive.recalc();
        }
    });

    // Optional: force redraw on page load for the active (today) tab
    setTimeout(function() {
        $('#todayTable').DataTable().columns.adjust().draw();
    }, 300);
});
</script>

</body>
</html>