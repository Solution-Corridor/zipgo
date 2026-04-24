<!DOCTYPE html>
<html lang="en">
@section('title')
    Edit Withdrawal - Admin
@endsection

<!-- Start top links -->
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
                            <h1 class="m-0">Edit Withdrawal #{{ $withdrawal->id }}</h1>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                @include('includes.success') <!-- assuming this shows session success -->

                                <div class="card-header">
                                    <h3 class="card-title">Edit Withdrawal Request</h3>
                                </div>

                                <form action="{{ route('update_withdraw', $withdrawal->id) }}" method="POST">
                                    @csrf
                                   
                                    <div class="card-body">
                                        <div class="row">

                                            <!-- User (read-only) -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>User</label>
                                                    <input type="text" class="form-control" value="{{ $withdrawal->user->username ?? '—' }} (ID: {{ $withdrawal->user_id }})" readonly>
                                                </div>
                                            </div>

                                            <!-- Method -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Withdrawal Method <code>*</code></label>
                                                    <input type="text" name="method" class="form-control" value="{{ old('method', $withdrawal->method) }}" required>
                                                    @error('method') <small class="text-danger">{{ $message }}</small> @enderror
                                                </div>
                                            </div>

                                            <!-- Bank Name -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Bank Name</label>
                                                    <input type="text" name="bank_name" class="form-control" value="{{ old('bank_name', $withdrawal->bank_name) }}">
                                                    @error('bank_name') <small class="text-danger">{{ $message }}</small> @enderror
                                                </div>
                                            </div>

                                            <!-- Amount -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Amount <code>*</code></label>
                                                    <input type="number" name="amount" step="0.01" min="0" class="form-control" value="{{ old('amount', $withdrawal->amount) }}" required>
                                                    @error('amount') <small class="text-danger">{{ $message }}</small> @enderror
                                                </div>
                                            </div>

                                            <!-- Account Number -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Account Number <code>*</code></label>
                                                    <input type="text" name="account_number" class="form-control" value="{{ old('account_number', $withdrawal->account_number) }}" required>
                                                    @error('account_number') <small class="text-danger">{{ $message }}</small> @enderror
                                                </div>
                                            </div>

                                            <!-- Account Title -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Account Title / Name <code>*</code></label>
                                                    <input type="text" name="account_title" class="form-control" value="{{ old('account_title', $withdrawal->account_title) }}" required>
                                                    @error('account_title') <small class="text-danger">{{ $message }}</small> @enderror
                                                </div>
                                            </div>

                                            <!-- Status -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Status <code>*</code></label>
                                                    <select name="status" class="form-control" required>
                                                        <option value="pending"    {{ old('status', $withdrawal->status) == 'pending'    ? 'selected' : '' }}>Pending</option>
                                                        <option value="approved"   {{ old('status', $withdrawal->status) == 'approved'   ? 'selected' : '' }}>Approved</option>
                                                        <option value="rejected"   {{ old('status', $withdrawal->status) == 'rejected'   ? 'selected' : '' }}>Rejected</option>
                                                        <option value="cancelled"  {{ old('status', $withdrawal->status) == 'cancelled'  ? 'selected' : '' }}>Cancelled</option>
                                                        <option value="processing" {{ old('status', $withdrawal->status) == 'processing' ? 'selected' : '' }}>Processing</option>
                                                    </select>
                                                    @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                                                </div>
                                            </div>

                                            <!-- is_refund -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Is Refund?</label>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="is_refund" class="custom-control-input" id="is_refund" value="1" {{ old('is_refund', $withdrawal->is_refund) ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="is_refund">Mark as refund processed</label>
                                                    </div>
                                                    @error('is_refund') <small class="text-danger">{{ $message }}</small> @enderror
                                                </div>
                                            </div>

                                            <!-- Transaction ID -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Transaction ID</label>
                                                    <input type="text" name="transaction_id" class="form-control" value="{{ old('transaction_id', $withdrawal->transaction_id) }}">
                                                    @error('transaction_id') <small class="text-danger">{{ $message }}</small> @enderror
                                                </div>
                                            </div>

                                            <!-- Remarks -->
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Remarks / Admin Note</label>
                                                    <textarea name="remarks" class="form-control" rows="4">{{ old('remarks', $withdrawal->remarks ?? '') }}</textarea>
                                                    @error('remarks') <small class="text-danger">{{ $message }}</small> @enderror
                                                </div>
                                            </div>

                                            <!-- ──────────────────────────────────────── -->
                                            <!--           Timestamps – read only          -->
                                            <!-- ──────────────────────────────────────── -->
                                            <div class="col-12 mt-4">
                                                <hr>
                                                <h5 class="text-muted">System Timestamps (read-only)</h5>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Created At</label>
                                                    <input type="text" class="form-control" value="{{ $withdrawal->created_at ? $withdrawal->created_at->format('Y-m-d H:i:s') : '—' }}" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Processed At</label>
                                                    <input type="text" class="form-control" value="{{ $withdrawal->processed_at ? $withdrawal->processed_at->format('Y-m-d H:i:s') : '—' }}" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Approved At</label>
                                                    <input type="text" class="form-control" value="{{ $withdrawal->approved_at ? $withdrawal->approved_at->format('Y-m-d H:i:s') : '—' }}" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Rejected At</label>
                                                    <input type="text" class="form-control" value="{{ $withdrawal->rejected_at ? $withdrawal->rejected_at->format('Y-m-d H:i:s') : '—' }}" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Cancelled At</label>
                                                    <input type="text" class="form-control" value="{{ $withdrawal->cancelled_at ? $withdrawal->cancelled_at->format('Y-m-d H:i:s') : '—' }}" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Last Updated At</label>
                                                    <input type="text" class="form-control" value="{{ $withdrawal->updated_at ? $withdrawal->updated_at->format('Y-m-d H:i:s') : '—' }}" readonly>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="card-footer">
                                        <a href="{{ route('withdraw_requests') }}" class="btn btn-secondary">Cancel</a>
                                        <button type="submit" class="btn btn-primary float-right">Update Withdrawal</button>
                                    </div>
                                </form>
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