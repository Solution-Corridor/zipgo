@php
    $plans = \App\Models\Package::where('is_active', 1)->get();
@endphp

<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    @include('includes.header_links')
    <title>Membership Plans - Feature Desk</title>
</head>

<body class="body body5 bg-[#0A0A0F] text-white">
    <main class="mx-auto max-w-md p-4 min-h-screen">
        <!--=====progress END=======-->
        <div class="paginacontainer"></div>
        @include('includes.navbar')

        <div class="relative bg-[#0A0A0F] text-white overflow-hidden">
            <div class="relative z-10">
                <!-- Hero Section -->
                <section class="pb-12 text-center">
                    <div class="container mx-auto px-4">
                        <h1 class="text-2xl md:text-4xl font-bold text-white mb-6 leading-tight animate-fade-in-up animation-delay-200">
    Smart Membership Plans, <br>
    <span class="bg-clip-text text-transparent bg-gradient-primary">
        Daily Updates
    </span>
</h1>

<p class="max-w-2xl mx-auto text-lg text-white/60 mb-10 animate-fade-in-up animation-delay-400">
    Join Feature Desk — your secure platform for smart plan selection and transparent progress tracking. 
    Explore options that fit your goals and manage your account with ease.
</p>

                        <div class="flex flex-col justify-center gap-4 animate-fade-in-up animation-delay-600">
                            @auth

    {{-- If Admin --}}
    @if(auth()->user()->type == 0)

        <div class="flex flex-col sm:flex-row gap-4">

            {{-- User Dashboard --}}
            <a href="{{ route('user_dashboard') }}"
               class="w-full sm:w-auto bg-gradient-primary text-white font-semibold py-3 px-8 rounded-full flex items-center justify-center gap-2 shadow-[0_8px_30px_rgba(124,58,237,0.3)] hover:shadow-[0_8px_40px_rgba(124,58,237,0.4)] active:scale-[0.98] transition-all">
                <span>User Dashboard</span>
            </a>

            {{-- Admin Dashboard --}}
            <a href="{{ route('dashboard') }}"
               class="w-full sm:w-auto bg-gradient-to-r from-emerald-500 to-teal-500 text-white font-semibold py-3 px-8 rounded-full flex items-center justify-center gap-2 shadow-lg hover:shadow-xl active:scale-[0.98] transition-all">
                <span>Admin Dashboard</span>
            </a>

        </div>

    {{-- If Normal User --}}
    @else

        <a href="{{ route('user_dashboard') }}"
           class="w-full sm:w-auto bg-gradient-primary text-white font-semibold py-3 px-8 rounded-full flex items-center justify-center gap-2 shadow-[0_8px_30px_rgba(124,58,237,0.3)] hover:shadow-[0_8px_40px_rgba(124,58,237,0.4)] active:scale-[0.98] transition-all">
            <span>Go to Dashboard</span>
        </a>

    @endif

@else

    <a href="{{ route('login') }}"
       class="w-full sm:w-auto bg-gradient-primary text-white font-semibold py-3 px-8 rounded-full flex items-center justify-center gap-2 shadow-[0_8px_30px_rgba(124,58,237,0.3)] hover:shadow-[0_8px_40px_rgba(124,58,237,0.4)] active:scale-[0.98] transition-all">
        <span>Log In</span>
    </a>

@endauth


                            <a href="/register"
                               class="w-full sm:w-auto bg-white/10 text-white font-medium py-3 px-8 rounded-full hover:bg-white/20 active:scale-[0.98] transition-all">
                                Register
                            </a>
                        </div>
                    </div>
                </section>

                <!-- Pricing / Plans Section -->
                <section>
                    <div class="container mx-auto px-4">
                        <div class="text-center max-w-3xl mx-auto">
                            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                                Membership <span class="text-primary">Plans</span>
                            </h2>
                            <div class="w-24 h-1 bg-gradient-to-r from-primary to-accent mx-auto mb-6"></div>
                            <p class="text-white/60 text-lg">
                                We have wide range of plans choose which suits your goals.
                            </p>
                        </div>

                        <div>
                    @foreach ($plans as $plan)
    <div class="pt-6 flex justify-center">
        <div class="w-full rounded-2xl px-4 py-8 pb-4 cursor-pointer transition-all duration-200 hover:scale-[1.02] active:scale-[0.98] shadow-xl shadow-yellow-900/20 border border-yellow-700/50 bg-gradient-to-br from-gray-900 to-black">

            <!-- Header -->
            <div class="flex items-center gap-3 mb-4">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center shadow-lg bg-gradient-to-br from-yellow-600 to-amber-800">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package text-white">
                        <path d="M11 21.73a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73z"></path>
                        <path d="M12 22V12"></path>
                        <path d="m3.3 7 7.703 4.734a2 2 0 0 0 1.994 0L20.7 7"></path>
                        <path d="m7.5 4.27 9 5.15"></path>
                    </svg>
                </div>

                <div>
                    <h2 class="text-base font-bold text-white">
                        {{ $plan->name }}
                    </h2>
                    <p class="text-xs text-amber-300/70">
                        Duration {{ $plan->duration_days }} Days
                    </p>
                </div>
            </div>

            <!-- Price Section -->
            <div class="flex items-end justify-between mb-4 p-4 rounded-2xl bg-gradient-to-br from-yellow-900/30 to-amber-900/20 border border-yellow-700/30">
                <div>
                    <p class="text-1xl font-bold text-white">
                        Rs {{ number_format($plan->investment_amount) }}
                    </p>
                    <p class="text-xs text-amber-300/50">
                        Membership Price
                    </p>
                </div>

                <div class="text-right">
                    <p class="text-sm font-bold text-amber-400">
                        Rs {{ number_format($plan->daily_profit_min) }}–{{ number_format($plan->daily_profit_max) }}
                    </p>
                    <p class="text-xs text-amber-300/50">
                        Daily Profit
                    </p>
                </div>

                <div class="text-right">
                    <p class="text-sm font-bold text-amber-400">
                        Rs {{ number_format($plan->weekend_reward) }}-{{ number_format($plan->weekend_reward * 0.15 + $plan->weekend_reward) }}
                    </p>
                    <p class="text-xs text-amber-300/50">
                        Weekly Profit
                    </p>
                </div>

            </div>

            <!-- Features -->
            <div class="space-y-2.5 mb-6 text-sm">
                <div class="flex items-center gap-2.5 text-white font-medium">
                    <div class="w-5 h-5 rounded-full bg-amber-400/20 flex items-center justify-center text-amber-400">✔</div>
                    Daily Earnings Auto
                </div>

                <div class="flex items-center gap-2.5 text-white font-medium">
                    <div class="w-5 h-5 rounded-full bg-amber-400/20 flex items-center justify-center text-amber-400">✔</div>
                    Total Profit:
                    {{ number_format($plan->daily_profit_min * $plan->duration_days) }}
                    -
                    {{ number_format($plan->daily_profit_max * $plan->duration_days) }}
                    Rs
                </div>
                @if($plan->daily_tasks > 0)
                <div class="flex items-center gap-2.5 text-white font-medium">
                    <div class="w-5 h-5 rounded-full bg-amber-400/20 flex items-center justify-center text-amber-400">✔</div>
                    Daily Tasks: {{ number_format($plan->daily_tasks) }} x {{ number_format($plan->daily_task_price) }} Rs
                </div>
                @endif
                @if($plan->free_spins > 0)
                <div class="flex items-center gap-2.5 text-white font-medium">
                    <div class="w-5 h-5 rounded-full bg-amber-400/20 flex items-center justify-center text-amber-400">✔</div>
                    Free Spin: {{ number_format($plan->free_spins) }} x {{ number_format($plan->free_spin_price) }} Rs
                </div>
                @endif

                 @if($plan->weekend_reward > 0)
                <div class="flex items-center gap-2.5 text-white font-medium">
                    <div class="w-5 h-5 rounded-full bg-amber-400/20 flex items-center justify-center text-amber-400">✔</div>
                    Weekly Reward: {{ number_format($plan->weekend_reward) }}-{{ number_format($plan->weekend_reward * 0.15 + $plan->weekend_reward) }} Rs
                </div>
                @endif

                <!-- Plan Wise Refer Bonus -->
                <div class="mt-4 text-center">
                    <p class="text-white font-semibold text-[16px]">Referral Reward</p>
                    <p class="text-[14px] font-extrabold text-amber-400 drop-shadow">
                        <span class="text-[14px] text-amber-400 font-bold drop-shadow-md">
                            Level 1: {{ number_format($plan->referral_bonus_level1) }}%,
                        </span>
                        <span class="text-[14px] text-amber-400 font-bold drop-shadow-md">
                            Level 2: {{ number_format($plan->referral_bonus_level2) }}%
                        </span>
                    </p>
                </div>
            </div>

            <!-- Button -->
            @auth
            <a href="/payment/{{ $plan->id }}"
               class="investNow w-full py-1.5 mt-6 mb-0 rounded-xl font-semibold text-white flex items-center justify-center gap-2 bg-gradient-to-r from-yellow-600 to-amber-700 shadow-lg shadow-yellow-900/50 hover:shadow-xl hover:shadow-yellow-800/70 transition-all">
                JOIN NOW
            </a>
            @else
            <a href="/register"
               class="investNow w-full py-1.5 mt-6 mb-0 rounded-xl font-semibold text-white flex items-center justify-center gap-2 bg-gradient-to-r from-yellow-600 to-amber-700 shadow-lg shadow-yellow-900/50 hover:shadow-xl hover:shadow-yellow-800/70 transition-all">
                JOIN NOW
            </a>
            @endauth

        </div>
    </div>
@endforeach
                </div>
                    </div>
                </section>

                <!-- About Us Section -->
                <section class="py-10">
                    <div class="container mx-auto px-4">
                        <div class="text-center max-w-3xl mx-auto">
                            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
    About <span class="text-primary">Feature Desk</span> MEMBERSHIP
</h2>
<div class="w-24 h-1 bg-gradient-primary mx-auto mb-6"></div>
<p class="text-white/60 text-lg">
    Feature Desk is a secure online membership platform offering transparent plan options and easy account management. 
    Explore our membership features, track your progress daily, and handle everything with full confidence and security.
</p>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        @include('includes.footer_links')
    </main>
</body>

</html>