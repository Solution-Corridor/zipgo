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
                            <h1 class="m-0">Edit Package: {{ $package->name }}</h1>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary card-outline">

                                <!-- Card Header -->
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-box"></i> Edit Package Details
                                    </h3>
                                </div>

                                <!-- Card Body -->
                                <div class="card-body">

                                    @include('includes.success')

                                    <form name="PackageForm" action="{{ route('packages.update', $package->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="row">

                                            <div class="col-md-3 mb-3">
                                                <label>Package Name <code>*</code></label>
                                                <input type="text" name="name" class="form-control"
                                                    value="{{ old('name', $package->name) }}" required>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label>Investment Amount ($) <code>*</code></label>
                                                <input type="number" name="investment_amount" step="0.01"
                                                    class="form-control" min="1" required
                                                    value="{{ old('investment_amount', $package->investment_amount) }}">
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label>Daily Profit Min ($) <code>*</code></label>
                                                <input type="number" name="daily_profit_min" step="0.01"
                                                    class="form-control" min="0" required
                                                    value="{{ old('daily_profit_min', $package->daily_profit_min) }}">
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label>Daily Profit Max ($) <code>*</code></label>
                                                <input type="number" name="daily_profit_max" step="0.01"
                                                    class="form-control" min="0" required
                                                    value="{{ old('daily_profit_max', $package->daily_profit_max) }}">
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label>Duration (Days) <code>*</code></label>
                                                <input type="number" name="duration_days"
                                                    class="form-control" min="1" required
                                                    value="{{ old('duration_days', $package->duration_days) }}">
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label>Referral Bonus Level 1 (%) <code>*</code></label>
                                                <input type="number" name="referral_bonus_level1" step="0.01"
                                                    class="form-control" min="0" max="100" required
                                                    value="{{ old('referral_bonus_level1', $package->referral_bonus_level1) }}">
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label>Referral Bonus Level 2 (%) <code>*</code></label>
                                                <input type="number" name="referral_bonus_level2" step="0.01"
                                                    class="form-control" min="0" max="100" required
                                                    value="{{ old('referral_bonus_level2', $package->referral_bonus_level2) }}">
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label>Daily Tasks <code>*</code></label>
                                                <input type="number"
                                                    name="daily_tasks"
                                                    class="form-control"
                                                    min="0"
                                                    required
                                                    value="{{ old('daily_tasks', $package->daily_tasks) }}">
                                                @error('daily_tasks')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label>Daily Task Price <code>*</code></label>
                                                <input type="number"
                                                    name="daily_task_price"
                                                    step="0.01"
                                                    class="form-control"
                                                    min="0"
                                                    required
                                                    value="{{ old('daily_task_price', $package->daily_task_price) }}">
                                                @error('daily_task_price')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label>Free Spins <code>*</code></label>
                                                <input type="number"
                                                    name="free_spins"
                                                    class="form-control"
                                                    min="0"
                                                    required
                                                    value="{{ old('free_spins', $package->free_spins) }}">
                                                @error('free_spins')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label>Free Spin Price <code>*</code></label>
                                                <input type="number"
                                                    name="free_spin_price"
                                                    step="0.01"
                                                    class="form-control"
                                                    min="0"
                                                    required
                                                    value="{{ old('free_spin_price', $package->free_spin_price) }}">
                                                @error('free_spin_price')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            
                                            <div class="col-md-3 mb-3">
                                                <label>Weekend Reward ($) <code>*</code></label>
                                                <input type="number"
                                                    name="weekend_reward"
                                                    step="0.01"
                                                    class="form-control"
                                                    min="0"
                                                    required
                                                    value="{{ old('weekend_reward', $package->weekend_reward) }}">
                                                @error('weekend_reward')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label>Plan Type</label>
                                                <select name="plan_type" class="form-control" required>
                                                    <option value="">--Select Type--</option>
                                                    <option value="silver" {{ old('plan_type', $package->plan_type) == 'silver' ? 'selected' : '' }}>Silver</option>
                                                    <option value="gold" {{ old('plan_type', $package->plan_type) == 'gold' ? 'selected' : '' }}>Gold</option>
                                                    <option value="diamond" {{ old('plan_type', $package->plan_type) == 'diamond' ? 'selected' : '' }}>Diamond</option>
                                                    <option value="invest" {{ old('plan_type', $package->plan_type) == 'invest' ? 'selected' : '' }}>Invest</option>
                                                </select>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label>Status</label>
                                                <select name="is_active" class="form-control">
                                                    <option value="1" {{ old('is_active', $package->is_active ? 1 : 0) == 1 ? 'selected' : '' }}>Active</option>
                                                    <option value="0" {{ old('is_active', $package->is_active ? 1 : 0) == 0 ? 'selected' : '' }}>Inactive</option>
                                                </select>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label>Daily Rewards</label>
                                                <select name="is_daily_rewards" class="form-control">
                                                    <option value="1" {{ old('is_daily_rewards', $package->is_daily_rewards ? 1 : 0) == 1 ? 'selected' : '' }}>Yes</option>
                                                    <option value="0" {{ old('is_daily_rewards', $package->is_daily_rewards ? 1 : 0) == 0 ? 'selected' : '' }}>No</option>
                                                </select> 
                                                @error('is_daily_rewards')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                        </div>

                                </div>

                                <!-- Card Footer -->
                                <div class="card-footer text-right">
                                    <a href="{{ route('packages.index') }}" class="btn btn-danger">
                                        <i class="fas fa-arrow-left"></i> Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update Package
                                    </button>
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