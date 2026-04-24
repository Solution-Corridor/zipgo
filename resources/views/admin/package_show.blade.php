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
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fa fa-package"></i> Package Details
                    </h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('packages.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Back to Packages
                    </a>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">

<div style="max-width: 680px; background: #fff; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); overflow: hidden;">

    <!-- Card Header -->
    <div style="
        background: 
            @if($package->plan_type == 'silver') #6c757d
            @elseif($package->plan_type == 'gold') #ffc107
            @elseif($package->plan_type == 'diamond') #17a2b8
            @elseif($package->plan_type == 'invest') #28a745
            @else #007bff
            @endif;
        color: white;
        padding: 24px 20px;
    ">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
            <h2 style="margin: 0; font-weight: 700; font-size: 1.65rem;">
                {{ $package->name }}
            </h2>
            
            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="
                    padding: 6px 16px;
                    border-radius: 50px;
                    font-size: 0.95rem;
                    font-weight: 600;
                    background: rgba(255,255,255,0.25);
                ">
                    @if($package->is_active)
                        <i class="fa fa-check"></i> Active
                    @else
                        <i class="fa fa-times"></i> Inactive
                    @endif
                </span>
                <span style="font-size: 1rem; opacity: 0.95;">
                    {{ ucfirst($package->plan_type ?? 'Standard') }} Plan
                </span>
            </div>
        </div>
    </div>

    <!-- Card Body -->
    <div style="padding: 28px 20px; background: #fff;">

        <!-- Investment Highlight -->
        <div style="background: #f8f9fa; border-radius: 12px; padding: 18px; margin-bottom: 28px; text-align: center;">
            <div style="color: #666; font-size: 0.95rem;">Investment Amount</div>
            <div style="font-size: 1.85rem; font-weight: 700; color: #28a745; margin: 6px 0;">
                Rs {{ number_format($package->investment_amount, 0) }}
            </div>
        </div>

        <div style="display: flex; flex-direction: column; gap: 22px;">

            <!-- Basic Information -->
            <div>
                <h5 style="color: #444; font-weight: 600; margin-bottom: 16px; padding-bottom: 8px; border-bottom: 2px solid #f1f1f1;">
                    Basic Information
                </h5>
                
                <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f1f1f1;">
                    <strong style="color: #555;">Package ID</strong>
                    <span style="font-weight: 600;">#{{ $package->id }}</span>
                </div>

                <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f1f1f1;">
                    <strong style="color: #555;">Daily Profit</strong>
                    <span>Rs {{ number_format($package->daily_profit_min, 0) }} — Rs {{ number_format($package->daily_profit_max, 0) }}</span>
                </div>

                <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f1f1f1;">
                    <strong style="color: #555;">Duration</strong>
                    <span style="font-weight: 600;">{{ $package->duration_days }} Days</span>
                </div>

                <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f1f1f1;">
                    <strong style="color: #555;">Total Profit (Min — Max)</strong>
                    <span style="font-weight: 600;">
                        Rs {{ number_format($package->daily_profit_min * $package->duration_days, 0) }} — 
                        Rs {{ number_format($package->daily_profit_max * $package->duration_days, 0) }}
                    </span>
                </div>
            </div>

            <!-- Returns & Benefits -->
            <div>
                <h5 style="color: #444; font-weight: 600; margin-bottom: 16px; padding-bottom: 8px; border-bottom: 2px solid #f1f1f1;">
                    Returns &amp; Benefits
                </h5>

                <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f1f1f1;">
                    <strong style="color: #555;">Net Profit (Min)</strong>
                    <span style="color: #17a2b8; font-weight: 700;">
                        Rs {{ number_format(($package->daily_profit_min * $package->duration_days) - $package->investment_amount, 0) }}
                    </span>
                </div>

                <div style="display: flex; justify-content: space-between; padding: 14px 0; border-bottom: 1px solid #f1f1f1; align-items: center;">
                    <strong style="color: #555;">Profit Percentage (Min)</strong>
                    <span style="background: #28a745; color: white; padding: 8px 18px; border-radius: 30px; font-weight: 700; font-size: 1.1rem;">
                        {{ number_format((($package->daily_profit_min * $package->duration_days) - $package->investment_amount) / $package->investment_amount * 100, 2) }}%
                    </span>
                </div>

                <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f1f1f1;">
                    <strong style="color: #555;">Referral Bonus L1</strong>
                    <span style="font-weight: 600;">{{ $package->referral_bonus_level1 }}%</span>
                </div>

                <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f1f1f1;">
                    <strong style="color: #555;">Referral Bonus L2</strong>
                    <span style="font-weight: 600;">{{ $package->referral_bonus_level2 }}%</span>
                </div>

                <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f1f1f1;">
                    <strong style="color: #555;">Daily Tasks</strong>
                    <span>{{ $package->daily_tasks }} × Rs {{ number_format($package->daily_task_price, 2) }}</span>
                </div>

                <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f1f1f1;">
                    <strong style="color: #555;">Free Spins</strong>
                    <span>{{ $package->free_spins }} × Rs {{ number_format($package->free_spin_price, 2) }}</span>
                </div>

                <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f1f1f1;">
                    <strong style="color: #555;">Weekend Reward</strong>
                    <span style="color: #ffc107; font-weight: 700;">
                        Rs {{ number_format($package->weekend_reward, 0) }}
                    </span>
                </div>

                <div style="display: flex; justify-content: space-between; padding: 10px 0;">
                    <strong style="color: #555;">Daily Rewards Enabled</strong>
                    <span>
                        @if($package->is_daily_rewards)
                            <span style="background: #28a745; color: white; padding: 6px 16px; border-radius: 30px;">Yes</span>
                        @else
                            <span style="background: #6c757d; color: white; padding: 6px 16px; border-radius: 30px;">No</span>
                        @endif
                    </span>
                </div>
            </div>

        </div>
    </div>

    <!-- Card Footer -->
    <div style="background: #f8f9fa; padding: 22px 20px; border-top: 1px solid #eee; text-align: center;">
        <a href="{{ route('packages.edit', $package->id) }}" 
           style="background: #17a2b8; color: white; padding: 12px 28px; border-radius: 8px; text-decoration: none; font-weight: 500; display: inline-block; margin: 0 6px 10px 6px;">
            <i class="fa fa-edit"></i> Edit Package
        </a>
        
        <a href="{{ route('packages.index') }}" 
           style="background: #6c757d; color: white; padding: 12px 28px; border-radius: 8px; text-decoration: none; font-weight: 500; display: inline-block; margin: 0 6px 10px 6px;">
            <i class="fa fa-list"></i> Back to List
        </a>
    </div>
</div>
                </div>
            </div>
        </div>
    </section>
</div>

    <!-- Footer -->
    @include('admin.includes.version')
    <!-- ./wrapper -->

    <!-- Footer links -->
    @include('admin.includes.footer_links')

</body>

</html>