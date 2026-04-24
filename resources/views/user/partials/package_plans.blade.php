@php
if($plan->plan_type == 'silver'){
$border = 'border-gray-400/40';
$shadow = 'shadow-gray-500/20';
$iconBg = 'from-gray-400 to-gray-600';
$priceBg = 'from-gray-700/30 to-gray-900/20 border-gray-500/30';
$text = 'text-gray-300';
$accent = 'text-gray-300';
$button = 'from-gray-500 to-gray-700 shadow-gray-700/40';
}
elseif($plan->plan_type == 'gold'){
$border = 'border-yellow-700/50';
$shadow = 'shadow-yellow-900/20';
$iconBg = 'from-yellow-600 to-amber-800';
$priceBg = 'from-yellow-900/30 to-amber-900/20 border-yellow-700/30';
$text = 'text-amber-300/70';
$accent = 'text-amber-400';
$button = 'from-yellow-600 to-amber-700 shadow-yellow-900/50';
}
elseif($plan->plan_type == 'diamond'){
$border = 'border-cyan-500/40';
$shadow = 'shadow-cyan-500/20';
$iconBg = 'from-cyan-400 to-blue-600';
$priceBg = 'from-cyan-900/30 to-blue-900/20 border-cyan-600/30';
$text = 'text-cyan-300/70';
$accent = 'text-cyan-400';
$button = 'from-cyan-500 to-blue-700 shadow-cyan-900/50';
}
elseif($plan->plan_type == 'invest'){
$border = 'border-green-500/40';
$shadow = 'shadow-green-500/20';
$iconBg = 'from-green-400 to-green-600';
$priceBg = 'from-green-900/30 to-green-900/20 border-green-600/30';
$text = 'text-green-300/70';
$accent = 'text-green-400';
$button = 'from-green-500 to-green-700 shadow-green-900/50';
}
else{
$border = 'border-gray-400/40';
$shadow = 'shadow-gray-500/20';
$iconBg = 'from-gray-400 to-gray-600';
$priceBg = 'from-gray-700/30 to-gray-900/20 border-gray-500/30';
$text = 'text-gray-300';
$accent = 'text-gray-300';
$button = 'from-gray-500 to-gray-700 shadow-gray-700/40';
}
@endphp


<div class="pt-6 flex justify-center">
    <div class="w-full rounded-2xl px-4 py-8 pb-4 cursor-pointer transition-all duration-200 hover:scale-[1.02] active:scale-[0.98] shadow-xl {{ $shadow }} border {{ $border }} bg-gradient-to-br from-gray-900 to-black">

        <!-- Header -->
        <div class="flex items-center gap-3 mb-4">

            <div class="w-14 h-14 rounded-2xl flex items-center justify-center shadow-lg bg-gradient-to-br {{ $iconBg }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M11 21.73a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73z"></path>
                    <path d="M12 22V12"></path>
                </svg>
            </div>

            <div>
                <h2 class="text-base font-bold text-white">
                    {{ $plan->name }}
                </h2>

                <p class="text-xs {{ $text }}">
                    Duration {{ $plan->duration_days }} Days
                </p>
            </div>

        </div>


        <!-- Price Section -->

        <div class="flex items-end justify-between mb-4 p-4 rounded-2xl bg-gradient-to-br {{ $priceBg }} border">

            <div>
                <p class="text-xl font-bold text-white">
                    Rs {{ number_format($plan->investment_amount) }}
                </p>
                <p class="text-xs {{ $text }}">
                    Membership Price
                </p>
            </div>

            <div class="text-right">
                <p class="text-sm font-bold {{ $accent }}">
                    Rs {{ number_format($plan->daily_profit_min) }} – {{ number_format($plan->daily_profit_max) }}
                </p>
                <p class="text-xs {{ $text }}">
                    Daily Income
                </p>
            </div>

            @if($plan->weekend_reward > 0)
            <div class="text-right">
                <p class="text-sm font-bold {{ $accent }}">
                    Rs {{ number_format($plan->weekend_reward) }} - {{ number_format($plan->weekend_reward * 0.15 + $plan->weekend_reward) }}
                </p>
                <p class="text-xs {{ $text }}">
                    Weekly Income
                </p>
            </div>
            @endif

        </div>


        <!-- Features -->

        <div class="space-y-2.5 mb-6 text-sm">

            <div class="flex items-center gap-2.5 text-white font-medium">
                <div class="w-5 h-5 rounded-full bg-white/10 flex items-center justify-center {{ $accent }}">✔</div>
                Daily Earning
            </div>


            <div class="flex items-center gap-2.5 text-white font-medium">
                <div class="w-5 h-5 rounded-full bg-white/10 flex items-center justify-center {{ $accent }}">✔</div>

                Total Income:

                {{ number_format($plan->daily_profit_min * $plan->duration_days) }}
                -
                {{ number_format($plan->daily_profit_max * $plan->duration_days) }}

                Rs

            </div>


            @if($plan->daily_tasks > 0)
            <div class="flex items-center gap-2.5 text-white font-medium">
                <div class="w-5 h-5 rounded-full bg-white/10 flex items-center justify-center {{ $accent }}">✔</div>

                Daily Tasks: {{ number_format($plan->daily_tasks) }} x {{ number_format($plan->daily_task_price) }} Rs

            </div>
            @endif


            @if($plan->free_spins > 0)
            <div class="flex items-center gap-2.5 text-white font-medium">
                <div class="w-5 h-5 rounded-full bg-white/10 flex items-center justify-center {{ $accent }}">✔</div>

                Free Spin: {{ number_format($plan->free_spins) }} x {{ number_format($plan->free_spin_price) }} Rs

            </div>
            @endif


            @if($plan->weekend_reward > 0)
            <div class="flex items-center gap-2.5 text-white font-medium">
                <div class="w-5 h-5 rounded-full bg-white/10 flex items-center justify-center {{ $accent }}">✔</div>

                Weekly Reward:
                {{ number_format($plan->weekend_reward) }}
                -
                {{ number_format($plan->weekend_reward * 0.15 + $plan->weekend_reward) }}

                Rs

            </div>
            @endif


            <!-- Referral -->

            <div class="mt-4 text-center">

                <p class="text-white font-semibold text-[16px]">
                    Referral Reward
                </p>

                <p class="text-[14px] font-extrabold {{ $accent }}">

                    Level 1: {{ number_format($plan->referral_bonus_level1) }}%

                    |

                    Level 2: {{ number_format($plan->referral_bonus_level2) }}%

                </p>

            </div>

        </div>


        <!-- Button -->

        @auth

        <a href="/payment/{{ $plan->id }}"
            class="investNow w-full py-1.5 mt-6 mb-0 rounded-xl font-semibold text-white flex items-center justify-center gap-2 bg-gradient-to-r {{ $button }} shadow-lg hover:shadow-xl transition-all">

            JOIN NOW

        </a>

        @else

        <a href="/register"
            class="investNow w-full py-1.5 mt-6 mb-0 rounded-xl font-semibold text-white flex items-center justify-center gap-2 bg-gradient-to-r {{ $button }} shadow-lg hover:shadow-xl transition-all">

            JOIN NOW

        </a>

        @endauth

    </div>
</div>