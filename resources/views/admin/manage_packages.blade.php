<!DOCTYPE html>
<html lang="en">
@section('title')
Package Plans - Your Investment Platform
@endsection

<!-- SEO Metadata -->

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
                            <h1 class="m-0">Package Plans</h1>
                        </div>
                        <div class="col-sm-6"></div>
                    </div>
                </div>
            </div>
            <!-- /.content-header -->

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary card-outline card-outline-tabs">
                                <div class="card-header p-0 border-bottom-0">
                                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill"
                                                href="#custom-tabs-four-home" role="tab"
                                                aria-controls="custom-tabs-four-home" aria-selected="true">
                                                <i class="fa fa-list"></i> List Packages
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill"
                                                href="#custom-tabs-four-profile" role="tab"
                                                aria-controls="custom-tabs-four-profile" aria-selected="false">
                                                <i class="fa fa-plus"></i> Add New Package
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-four-tabContent">

                                        <!-- LIST TAB -->
                                        <div class="tab-pane fade show active" id="custom-tabs-four-home"
                                            role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">

                                            @include('includes.success')

                                            <div class="row">

                                                @forelse ($packages as $pkg)
                                                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                                    <div class="card card-outline h-100 shadow-sm">

                                                        <div class="card-header 
    @if($pkg->plan_type=='silver') bg-secondary
    @elseif($pkg->plan_type=='gold') bg-warning
    @elseif($pkg->plan_type=='diamond') bg-info
    @elseif($pkg->plan_type=='invest') bg-success
    @else bg-primary
    @endif text-white">

                                                            <h5 class="m-0 font-weight-bold">
                                                                {{ $pkg->name }} -
                                                                {{ number_format($pkg->investment_amount, 0) }} Rs
                                                                <small class="float-right">
                                                                    @if($pkg->is_active)
                                                                    <span class="badge badge-success">Active</span>
                                                                    @else
                                                                    <span class="badge badge-secondary">Inactive</span>
                                                                    @endif
                                                                </small>
                                                            </h5>
                                                        </div>

                                                        <div class="card-body">

                                                            <div class="package-info-list small">

                                                                <div class="d-flex justify-content-between mb-2">
                                                                    <strong>ID:</strong>
                                                                    <span>{{ $pkg->id }}</span>
                                                                </div>

                                                                <div class="d-flex justify-content-between mb-2">
                                                                    <strong>Investment:</strong>
                                                                    <span>Rs {{ number_format($pkg->investment_amount, 0) }}</span>
                                                                </div>

                                                                <div class="d-flex justify-content-between mb-2">
                                                                    <strong>Daily Profit:</strong>
                                                                    <span>Rs {{ number_format($pkg->daily_profit_min, 0) }} —
                                                                        Rs {{ number_format($pkg->daily_profit_max, 0) }}</span>
                                                                </div>

                                                                <div class="d-flex justify-content-between mb-2">
                                                                    <strong>Total Profit:</strong>
                                                                    <span>Rs {{ number_format($pkg->daily_profit_min * $pkg->duration_days, 0) }} —
                                                                        Rs {{ number_format($pkg->daily_profit_max * $pkg->duration_days, 0) }}</span>
                                                                </div>

                                                                <div class="d-flex justify-content-between mb-2">
                                                                    <strong>Net Profit:</strong>
                                                                    <span>Rs {{ number_format((($pkg->daily_profit_min * $pkg->duration_days) - $pkg->investment_amount), 0) }}</span>
                                                                </div>

                                                                <div class="d-flex justify-content-between mb-2">
                                                                    <strong>Profit %:</strong>
                                                                    <span>{{ number_format((($pkg->daily_profit_min * $pkg->duration_days) - $pkg->investment_amount) / $pkg->investment_amount * 100, 2) }}%</span>
                                                                </div>

                                                                <div class="d-flex justify-content-between mb-2">
                                                                    <strong>Duration:</strong>
                                                                    <span>{{ $pkg->duration_days }} days</span>
                                                                </div>

                                                                <div class="d-flex justify-content-between mb-2">
                                                                    <strong>Referral Bonus L1:</strong>
                                                                    <span>{{ $pkg->referral_bonus_level1 }}%</span>
                                                                </div>

                                                                <div class="d-flex justify-content-between mb-2">
                                                                    <strong>Referral Bonus L2:</strong>
                                                                    <span>{{ $pkg->referral_bonus_level2 }}%</span>
                                                                </div>

                                                                <div class="d-flex justify-content-between mb-2">
                                                                    <strong>Daily Tasks:</strong>
                                                                    <span>{{ $pkg->daily_tasks }} × Rs {{ number_format($pkg->daily_task_price, 2) }}</span>
                                                                </div>

                                                                <div class="d-flex justify-content-between mb-2">
                                                                    <strong>Free Spins:</strong>
                                                                    <span>{{ $pkg->free_spins }} × Rs {{ number_format($pkg->free_spin_price, 2) }}</span>
                                                                </div>

                                                                <div class="d-flex justify-content-between mb-2 font-weight-bold border-top pt-2 mt-2">
                                                                    <strong>Weekend Reward:</strong>
                                                                    <span>Rs {{ number_format($pkg->weekend_reward, 0) }}</span>
                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="card-footer text-center">
                                                            <!-- view pkg details -->
                                                             <a target="_blank" href="{{ route('packages.show', $pkg->id) }}"
                                                                class="btn btn-primary btn-sm mr-2">
                                                                <i class="fa fa-eye"></i> View
                                                            </a>

                                                            <a href="{{ route('packages.edit', $pkg->id) }}"
                                                                class="btn btn-info btn-sm mr-2">
                                                                <i class="fa fa-edit"></i> Edit
                                                            </a>

                                                            <form action="{{ route('packages.destroy', $pkg->id) }}" method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm"
                                                                    onclick="return confirm('Are you sure you want to delete this package?');">
                                                                    <i class="fa fa-trash"></i> Delete
                                                                </button>
                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>
                                                @empty
                                                <div class="col-12">
                                                    <div class="alert alert-info text-center">
                                                        No packages found. Please add a new package.
                                                    </div>
                                                </div>
                                                @endforelse

                                            </div>



                                        </div>



                                        <!-- ADD FORM TAB -->
                                        <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel"
                                            aria-labelledby="custom-tabs-four-profile-tab">

                                            <div class="card card-primary">
                                                <form name="PackageForm" action="{{ route('packages.store') }}" method="POST">
                                                    @csrf

                                                    <div class="container-fluid">

                                                        <!-- Main Package Fields -->
                                                        <div class="row mt-3">
                                                            <div class="col-md-3">
                                                                <label>Package Name <code>*</code></label>
                                                                <input type="text" name="name" class="form-control"
                                                                    placeholder="e.g. Starter Plan, VIP 30 Days"
                                                                    value="{{ old('name') }}" required>
                                                                @error('name')
                                                                <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label>Investment Amount (PKR) <code>*</code></label>
                                                                <input type="number" name="investment_amount" step="0.01"
                                                                    class="form-control" min="1" required
                                                                    placeholder="100" value="{{ old('investment_amount') }}">
                                                                @error('investment_amount')
                                                                <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>


                                                            <div class="col-md-3">
                                                                <label>Daily Profit Min (PKR) <code>*</code></label>
                                                                <input type="number" name="daily_profit_min" step="0.01"
                                                                    class="form-control" min="0" placeholder="1300" required
                                                                    value="{{ old('daily_profit_min') }}">
                                                                @error('daily_profit_min')
                                                                <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label>Daily Profit Max (PKR) <code>*</code></label>
                                                                <input type="number" name="daily_profit_max" step="0.01"
                                                                    class="form-control" min="0" placeholder="1500" required
                                                                    value="{{ old('daily_profit_max') }}">
                                                                @error('daily_profit_max')
                                                                <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label>Duration (Days) <code>*</code></label>
                                                                <input type="number" name="duration_days" class="form-control"
                                                                    placeholder="85"
                                                                    min="1" required value="{{ old('duration_days') }}">
                                                                @error('duration_days')
                                                                <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label>Referral Bonus Level 1 (%) <code>*</code></label>
                                                                <input type="number" name="referral_bonus_level1" step="0.01"
                                                                    class="form-control" min="0" max="100" required
                                                                    placeholder="5"
                                                                    value="{{ old('referral_bonus_level1') }}">
                                                                @error('referral_bonus_level1')
                                                                <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label>Referral Bonus Level 2 (%) <code>*</code></label>
                                                                <input type="number" name="referral_bonus_level2" step="0.01"
                                                                    class="form-control" min="0" max="100" required
                                                                    placeholder="3"
                                                                    value="{{ old('referral_bonus_level2') }}">
                                                                @error('referral_bonus_level2')
                                                                <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label>Daily Tasks <code>*</code></label>
                                                                <input type="number"
                                                                    name="daily_tasks"
                                                                    class="form-control"
                                                                    min="0"
                                                                    required
                                                                    placeholder="10"
                                                                    value="{{ old('daily_tasks') }}">
                                                                @error('daily_tasks')
                                                                <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label>Daily Task Price <code>*</code></label>
                                                                <input type="number"
                                                                    name="daily_task_price"
                                                                    step="0.01"
                                                                    class="form-control"
                                                                    min="0"
                                                                    required
                                                                    placeholder="5.00"
                                                                    value="{{ old('daily_task_price') }}">
                                                                @error('daily_task_price')
                                                                <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label>Free Spins <code>*</code></label>
                                                                <input type="number"
                                                                    name="free_spins"
                                                                    class="form-control"
                                                                    min="0"
                                                                    required
                                                                    placeholder="3"
                                                                    value="{{ old('free_spins') }}">
                                                                @error('free_spins')
                                                                <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label>Free Spin Price <code>*</code></label>
                                                                <input type="number"
                                                                    name="free_spin_price"
                                                                    step="0.01"
                                                                    class="form-control"
                                                                    min="0"
                                                                    required
                                                                    placeholder="2.50"
                                                                    value="{{ old('free_spin_price') }}">
                                                                @error('free_spin_price')
                                                                <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label>Weekend Reward <code>*</code></label>
                                                                <input type="number"
                                                                    name="weekend_reward"
                                                                    step="0.01"
                                                                    class="form-control"
                                                                    min="0"
                                                                    required
                                                                    placeholder="250"
                                                                    value="{{ old('weekend_reward') }}">
                                                                @error('weekend_reward')
                                                                <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label>Plan Type</label>
                                                                <select name="plan_type" class="form-control" required>
                                                                    <option value="">--Select Type--</option>
                                                                    <option value="silver" {{ old('plan_type') == 'silver' ? 'selected' : '' }}>Silver</option>
                                                                    <option value="gold" {{ old('plan_type') == 'gold' ? 'selected' : '' }}>Gold</option>
                                                                    <option value="diamond" {{ old('plan_type') == 'diamond' ? 'selected' : '' }}>Diamond</option>
                                                                    <option value="invest" {{ old('plan_type') == 'invest' ? 'selected' : '' }}>Invest</option>
                                                                </select>
                                                            </div>


                                                            <div class="col-md-3">
                                                                <label>Status</label>
                                                                <select name="is_active" class="form-control">
                                                                    <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Active</option>
                                                                    <option value="0" {{ old('is_active', 1) == 0 ? 'selected' : '' }}>Inactive</option>
                                                                </select>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <label>Is Daily Rewards</label>
                                                                <select name="is_daily_rewards" class="form-control">
                                                                    <option value="1" {{ old('is_daily_rewards', 1) == 1 ? 'selected' : '' }}>Yes</option>
                                                                    <option value="0" {{ old('is_daily_rewards') == 0 ? 'selected' : '' }}>No</option>
                                                                </select>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <!-- Submit -->
                                                    <div class="card-footer text-center mt-4">
                                                        <a href="/admin/dashboard" class="btn btn-danger">Cancel</a>
                                                        <button type="submit" class="btn btn-primary">
                                                            Create Package
                                                        </button>
                                                    </div>

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
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->

    <!-- Footer -->
    @include('admin.includes.version')
    <!-- ./wrapper -->

    <!-- Footer links -->
    @include('admin.includes.footer_links')

</body>

</html>