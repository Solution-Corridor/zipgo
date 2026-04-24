<!DOCTYPE html>
<html lang="en">

@section('title')
Edit Payment #{{ $payment->id }} - Admin Panel
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
                            <h1 class="m-0">Edit Payment #{{ $payment->id }}</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('running_packages') }}">Running Packages</a></li>
                                <li class="breadcrumb-item active">Edit</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">

                            @include('includes.success')

                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">All Payment Fields</h3>
                                </div>

                                <form action="{{ route('plan.update', $payment->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="card-body">

                                        {{-- Row: ID (read-only) --}}
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">ID</label>
                                            <div class="col-sm-9">
                                                <p class="form-control-plaintext">{{ $payment->id }}</p>
                                            </div>
                                        </div>

                                        {{-- Row: User (read-only, with link) --}}
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">User</label>
                                            <div class="col-sm-9">
                                                <p class="form-control-plaintext">
                                                    <a href="{{ route('userDetails', $payment->user_id) }}" target="_blank">
                                                        {{ $payment->user->username ?? 'N/A' }} (ID: {{ $payment->user_id }})
                                                    </a>
                                                </p>
                                            </div>
                                        </div>

                                        

                                        

                                        {{-- Row: Status (editable dropdown) --}}
                                        <div class="form-group row">
                                            <label for="status" class="col-sm-3 col-form-label">Status</label>
                                            <div class="col-sm-9">
                                                <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                                                    @foreach(['pending', 'approved', 'rejected', 'expired'] as $statusOption)
                                                        <option value="{{ $statusOption }}" {{ old('status', $payment->status) == $statusOption ? 'selected' : '' }}>
                                                            {{ ucfirst($statusOption) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('status')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Row: Admin Note (editable textarea) --}}
                                        <div class="form-group row">
                                            <label for="admin_note" class="col-sm-3 col-form-label">Admin Note</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control @error('admin_note') is-invalid @enderror" id="admin_note" name="admin_note" rows="3">{{ old('admin_note', $payment->admin_note) }}</textarea>
                                                @error('admin_note')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Row: Approved At (editable datetime) --}}
                                        <div class="form-group row">
                                            <label for="approved_at" class="col-sm-3 col-form-label">Approved At</label>
                                            <div class="col-sm-9">
                                                <input type="datetime-local" class="form-control @error('approved_at') is-invalid @enderror" id="approved_at" name="approved_at" value="{{ old('approved_at', $payment->approved_at ? \Carbon\Carbon::parse($payment->approved_at)->format('Y-m-d\TH:i') : '') }}">
                                                <small class="text-muted">Leave empty for NULL</small>
                                                @error('approved_at')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Row: Rejected At (editable datetime) --}}
                                        <div class="form-group row">
                                            <label for="rejected_at" class="col-sm-3 col-form-label">Rejected At</label>
                                            <div class="col-sm-9">
                                                <input type="datetime-local" class="form-control @error('rejected_at') is-invalid @enderror" id="rejected_at" name="rejected_at" value="{{ old('rejected_at', $payment->rejected_at ? \Carbon\Carbon::parse($payment->rejected_at)->format('Y-m-d\TH:i') : '') }}">
                                                <small class="text-muted">Leave empty for NULL</small>
                                                @error('rejected_at')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Row: Expires At (editable datetime) --}}
                                        <div class="form-group row">
                                            <label for="expires_at" class="col-sm-3 col-form-label">Expires At</label>
                                            <div class="col-sm-9">
                                                <input type="datetime-local" class="form-control @error('expires_at') is-invalid @enderror" id="expires_at" name="expires_at" value="{{ old('expires_at', $payment->expires_at ? \Carbon\Carbon::parse($payment->expires_at)->format('Y-m-d\TH:i') : '') }}">
                                                <small class="text-muted">Leave empty for NULL</small>
                                                @error('expires_at')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Row: Created At (read-only) --}}
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Created At</label>
                                            <div class="col-sm-9">
                                                <p class="form-control-plaintext">{{ $payment->created_at ? \Carbon\Carbon::parse($payment->created_at)->format('d M Y h:i A') : '—' }}</p>
                                            </div>
                                        </div>

                                        {{-- Row: Updated At (read-only) --}}
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Updated At</label>
                                            <div class="col-sm-9">
                                                <p class="form-control-plaintext">{{ $payment->updated_at ? \Carbon\Carbon::parse($payment->updated_at)->format('d M Y h:i A') : '—' }}</p>
                                            </div>
                                        </div>

                                    </div> {{-- /.card-body --}}

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Update Payment</button>
                                        <a href="{{ route('running_packages') }}" class="btn btn-default float-right">Cancel</a>
                                    </div>
                                </form>
                            </div> {{-- /.card --}}

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