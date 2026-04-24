<!DOCTYPE html>
<html lang="en">
@section('title')
Edit Package - Your Investment Platform
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
                    <h1 class="m-0">Edit Payment Method</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('payment-methods.index') }}">Payment Methods</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Update Payment Method</h3>
                        </div>

                        @include('admin.includes.success')

                        <form action="{{ route('payment-methods.update', $paymentMethod->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="card-body">
                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Account Type <code>*</code></label>
                                            <select name="account_type" class="form-control" required>
                                                <option value="">Select Type</option>
                                                <option value="easypaisa" {{ old('account_type', $paymentMethod->account_type) == 'easypaisa' ? 'selected' : '' }}>Easypaisa</option>
                                                <option value="jazzcash"  {{ old('account_type', $paymentMethod->account_type) == 'jazzcash'  ? 'selected' : '' }}>JazzCash</option>
                                                <option value="nayapay"   {{ old('account_type', $paymentMethod->account_type) == 'nayapay'   ? 'selected' : '' }}>NayaPay</option>
                                                <option value="sadapay"   {{ old('account_type', $paymentMethod->account_type) == 'sadapay'   ? 'selected' : '' }}>SadaPay</option>
                                                <option value="bank"      {{ old('account_type', $paymentMethod->account_type) == 'bank'      ? 'selected' : '' }}>Bank</option>
                                                <option value="raast"      {{ old('account_type', $paymentMethod->account_type) == 'raast'      ? 'selected' : '' }}>Raast</option>
                                            </select>
                                            @error('account_type') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Account Title <code>*</code></label>
                                            <input type="text" name="account_title" class="form-control"
                                                   value="{{ old('account_title', $paymentMethod->account_title) }}" required>
                                            @error('account_title') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Account Number</label>
                                            <input type="text" name="account_number" class="form-control"
                                                   value="{{ old('account_number', $paymentMethod->account_number) }}">
                                            @error('account_number') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>IBAN (for Bank only)</label>
                                            <input type="text" name="iban" class="form-control"
                                                   value="{{ old('iban', $paymentMethod->iban) }}">
                                            @error('iban') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                    </div>

                                    

                                    <div class="col-md-1">
                                        <div class="form-group">
                                             @if($paymentMethod->receipt_sample && file_exists(public_path($paymentMethod->receipt_sample)))
                                                <img src="{{ asset($paymentMethod->receipt_sample) }}" alt="Current Receipt" style="max-width: 40px; margin: 10px 0; border:1px solid #ddd;">
                                                <br>
                                            @else
                                                <p class="text-muted">No receipt image uploaded yet.</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">

                                            <label>Replace Receipt Sample (optional)</label>
                                            <div class="custom-file">
                                                <input type="file" name="receipt_sample" class="custom-file-input" accept="image/*">
                                                <label class="custom-file-label" for="receipt_sample">Choose file...</label>
                                            </div>
                                            @error('receipt_sample') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select name="is_active" class="form-control">
                                                <option value="1" {{ old('is_active', $paymentMethod->is_active) ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ old('is_active', $paymentMethod->is_active) ? '' : 'selected' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Additional Details / Instructions</label>
                                            <textarea name="details" class="form-control" rows="3">{{ old('details', $paymentMethod->details) }}</textarea>
                                            @error('details') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="card-footer text-center">
                                <a href="{{ route('payment-methods.index') }}" class="btn btn-danger">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update Payment Method</button>
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