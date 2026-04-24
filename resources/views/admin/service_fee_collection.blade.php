<!DOCTYPE html>
<html lang="en">

@section('title')
Service Fee Collection
@endsection

@include('admin.includes.headlinks')

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
                            <h1 class="m-0">Service Fee Collection</h1>
                        </div>
                        <div class="col-sm-6">
                            <!-- Optional: you can add filters or search later here -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">

                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">Service Fee Collection History</h3>

                                    <div class="card-tools">
                                        <!-- You can add export button or filter here later -->
                                    </div>
                                </div>

                                <div class="card-body table-responsive p-0">
                                    <table class="table table-bordered table-striped table-hover example1" id="example1">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>User</th>
                                                <th>Type</th>
                                                <th>Amount</th>
                                                <th>Details</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($transactions as $transaction)
                                                <tr>
                                                    <td>{{ $transaction->id }}</td>

                                                    <td>
                                                        @if ($transaction->user)
                                                                    <a target="_blank" href="{{ route('userDetails', ['id' => $transaction->user->id]) }}">
                                                                    <small class="d-block text-muted">ID: {{ $transaction->user->id}}</small>
                                                                    {{ $transaction->user->username ?? 'N/A' }} <br>
                                                                    {{ $transaction->user->phone ?? 'N/A' }}
                                                                    @else
                                                            <span class="text-muted">— (System / Deleted)</span>
                                                        @endif</a>
                                                                </td>
                                                    
                                                    <td>
                                                        <span class="badge 
                                                            {{ $transaction->trx_type === 'referral_bonus' ? 'badge-info' : '' }}
                                                            {{ $transaction->trx_type === 'deposit' ? 'badge-success' : '' }}
                                                            {{ $transaction->trx_type === 'withdrawal' ? 'badge-danger' : '' }}
                                                            {{ !in_array($transaction->trx_type, ['referral_bonus','deposit','withdrawal']) ? 'badge-secondary' : '' }}">
                                                            {{ ucfirst(str_replace('_', ' ', $transaction->trx_type)) }}
                                                        </span>
                                                    </td>
                                                    <td class="{{ $transaction->amount >= 0 ? 'text-success' : 'text-danger' }}">
                                                        {{ $transaction->amount >= 0 ? '' : '' }}{{ number_format($transaction->amount, 2) }} Rs
                                                    </td>
                                                    <td>{{ $transaction->detail ?? '—' }}</td>
                                                    <td>{{ $transaction->created_at->format('d M Y • h:i A') }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted py-5">
                                                        No transactions found
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

        @include('admin.includes.version')
    </div>

    @include('admin.includes.footer_links')

</body>
</html>