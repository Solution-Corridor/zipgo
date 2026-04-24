<!DOCTYPE html>
<html lang="en">
@section('title')
Payment Methods
@endsection

<!-- SEO Metadata -->

<!-- Start top links -->
@include('admin.includes.headlinks')
<!-- Bootstrap Toggle CSS -->

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        <!-- Start navbar -->
        @include('admin.includes.navbar')
        
        <!-- end navbar -->

        <!-- Start Sidebar -->
        @include('admin.includes.sidebar')
        <!-- end Sidebar -->

        <div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Payment Methods</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill"
                                       href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home"
                                       aria-selected="true">
                                        <i class="fa fa-list"></i> List Payment Methods
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill"
                                       href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile"
                                       aria-selected="false">
                                        <i class="fa fa-plus"></i> Add New Payment Method
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-four-tabContent">

                                <!-- LIST TAB -->
                                <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel"
                                     aria-labelledby="custom-tabs-four-home-tab">

                                    @include('includes.success') <!-- your success message partial -->

                                    <div class="card card-primary">
                                        <table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Type</th>
            <th>Account Title</th>
            <th>Account Number</th>
            <th>IBAN</th>
            <th>Details</th>
            <th>Receipt Sample</th>
            <th>Status</th> <!-- Single status column -->
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($methods as $method)
        <tr>
            <td>{{ $method->id }}</td>
            <td>
                @if ($method->account_type == 'easypaisa')
                  <img src="/assets/images/easypaisa.png" alt="Easypaisa" width="50" height="50" style="border-radius: 50%;">
                @endif
                @if ($method->account_type == 'jazzcash')
                  <img src="/assets/images/jazzcash.png" alt="JazzCash" width="50" height="50" style="border-radius: 50%;">
                @endif
                @if ($method->account_type == 'nayapay')
                  <img src="/assets/images/nayapay.png" alt="NayaPay" width="50" height="50" style="border-radius: 50%;">
                @endif
                @if ($method->account_type == 'sadapay')
                  <img src="/assets/images/sadapay.png" alt="SadaPay" width="50" height="50" style="border-radius: 50%;">
                @endif
                @if ($method->account_type == 'bank')
                  <img src="/assets/images/meezan.png" alt="Bank" width="50" height="50" style="border-radius: 50%;">
                @endif
                @if ($method->account_type == 'raast')
                  <img src="/assets/images/raast.png" alt="Raast" width="50" height="50" style="border-radius: 50%;">
                @endif
                @if ($method->account_type == 'binance')
                  <img src="/assets/images/binance.png" alt="Binance" width="50" height="50" style="border-radius: 50%;">
                @endif

                </td>
            <td>{{ $method->account_title }}</td>
            <td>{{ $method->account_number ?? '—' }}</td>
            <td>{{ $method->iban ?? '—' }}</td>
            <td>{{ Str::limit($method->details ?? '—', 60) }}</td>
            <td>
                @if($method->receipt_sample)
                    <a href="/{{ $method->receipt_sample }}" target="_blank">View Receipt</a>
                @else
                    —
                @endif
            </td>
            <td>
                <!-- Custom switch with danger/success colors -->
                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                    <input type="checkbox" 
                           class="custom-control-input toggle-class" 
                           id="statusSwitch{{ $method->id }}" 
                           data-id="{{ $method->id }}" 
                           {{ $method->is_active ? 'checked' : '' }}>
                    <label class="custom-control-label" for="statusSwitch{{ $method->id }}"></label>
                </div>
            </td>
            <td>
                <a href="{{ route('payment-methods.edit', $method->id) }}" class="btn btn-info btn-xs">
                    <i class="fa fa-edit"></i>
                </a>
                <form action="{{ route('payment-methods.destroy', $method->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Delete this payment method?');">
                        <i class="fa fa-trash"></i>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
                                    </div>
                                </div>

                                <!-- ADD FORM TAB -->
                                <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel"
                                     aria-labelledby="custom-tabs-four-profile-tab">

                                    <div class="card card-primary">
                                        <form name="PaymentMethodForm" action="{{ route('payment-methods.store') }}"
                                              method="POST" enctype="multipart/form-data">
                                            @csrf

                                            <div class="container-fluid">
                                                <div class="row mt-3">

                                                    <div class="col-md-4">
                                                        <label>Account Type <code>*</code></label>
                                                        <select name="account_type" class="form-control" required>
                                                            <option value="">Select Type</option>
                                                            <option value="easypaisa" {{ old('account_type') == 'easypaisa' ? 'selected' : '' }}>Easypaisa</option>
                                                            <option value="jazzcash"  {{ old('account_type') == 'jazzcash'  ? 'selected' : '' }}>JazzCash</option>
                                                            <option value="nayapay"   {{ old('account_type') == 'nayapay'   ? 'selected' : '' }}>NayaPay</option>
                                                            <option value="sadapay"   {{ old('account_type') == 'sadapay'   ? 'selected' : '' }}>SadaPay</option>
                                                            <option value="bank"      {{ old('account_type') == 'bank'      ? 'selected' : '' }}>Bank</option>
                                                            <option value="raast"      {{ old('account_type') == 'raast'      ? 'selected' : '' }}>Raast</option>
                                                        </select>
                                                        @error('account_type')
                                                        <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label>Account Title <code>*</code></label>
                                                        <input type="text" name="account_title" class="form-control"
                                                               value="{{ old('account_title') }}"
                                                               placeholder="Salman Bashir" required>
                                                        @error('account_title')
                                                        <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label>Account Number</label>
                                                        <input type="text" name="account_number" class="form-control"
                                                        placeholder="03454444778"
                                                               value="{{ old('account_number') }}">
                                                        @error('account_number')
                                                        <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label>IBAN (for Bank only)</label>
                                                        <input type="text" name="iban" class="form-control"
                                                        placeholder="PK36TMFB0000000011985591"
                                                               value="{{ old('iban') }}">
                                                        @error('iban')
                                                        <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>

                                                    

                                                    <div class="col-md-4">
                                                        <label>Receipt Sample (Image) <small>(optional)</small></label>
                                                        <input type="file" name="receipt_sample" class="form-control-file" accept="image/*">
                                                        @error('receipt_sample')
                                                        <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label>Status</label>
                                                        <select name="is_active" class="form-control">
                                                            <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Active</option>
                                                            <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Inactive</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label>Additional Details / Instructions</label>
                                                        <textarea name="details" class="form-control" rows="3" placeholder="Guidelines">{{ old('details') }}</textarea>
                                                        @error('details')
                                                        <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="card-footer text-center mt-4">
                                                <a href="{{ route('dashboard') }}" class="btn btn-danger">Cancel</a>
                                                <button type="submit" class="btn btn-primary">Create Payment Method</button>
                                            </div>
                                        </form>
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>      
<script>

    
$(document).ready(function() {
    $('.toggle-class').change(function() {
        var is_active = $(this).prop('checked') ? 1 : 0;
        var id = $(this).data('id');
        var $checkbox = $(this);

        $.ajax({
            type: "POST",
            url: '{{ route("payment-methods.toggle-status", ":id") }}'.replace(':id', id),
            data: {
                _token: '{{ csrf_token() }}',
                is_active: is_active
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message || 'Status updated');
                } else {
                    toastr.error(response.message || 'Failed to update status');
                    // revert the checkbox state
                    $checkbox.prop('checked', !$checkbox.prop('checked'));
                    // if Bootstrap Toggle is used, refresh its UI
                    if ($.fn.bootstrapToggle) {
                        $checkbox.bootstrapToggle('toggle');
                    }
                }
            },
            error: function() {
                toastr.error('Something went wrong');
                $checkbox.prop('checked', !$checkbox.prop('checked'));
                if ($.fn.bootstrapToggle) {
                    $checkbox.bootstrapToggle('toggle');
                }
            }
        });
    });
});
</script>

        </div>
        <!-- /.content-wrapper -->

        <!-- Footer -->
        @include('admin.includes.version')
        <!-- ./wrapper -->

        <!-- Footer links -->
        @include('admin.includes.footer_links')

</body>

</html>