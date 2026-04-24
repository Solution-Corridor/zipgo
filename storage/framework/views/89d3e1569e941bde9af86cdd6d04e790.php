<?php
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
?>


<div class="pt-6 flex justify-center">
    <div class="w-full rounded-2xl px-4 py-8 pb-4 cursor-pointer transition-all duration-200 hover:scale-[1.02] active:scale-[0.98] shadow-xl <?php echo e($shadow); ?> border <?php echo e($border); ?> bg-gradient-to-br from-gray-900 to-black">

        <!-- Header -->
        <div class="flex items-center gap-3 mb-4">

            <div class="w-14 h-14 rounded-2xl flex items-center justify-center shadow-lg bg-gradient-to-br <?php echo e($iconBg); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M11 21.73a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73z"></path>
                    <path d="M12 22V12"></path>
                </svg>
            </div>

            <div>
                <h2 class="text-base font-bold text-white">
                    <?php echo e($plan->name); ?>

                </h2>

                <p class="text-xs <?php echo e($text); ?>">
                    Duration <?php echo e($plan->duration_days); ?> Days
                </p>
            </div>

        </div>


        <!-- Price Section -->

        <div class="flex items-end justify-between mb-4 p-4 rounded-2xl bg-gradient-to-br <?php echo e($priceBg); ?> border">

            <div>
                <p class="text-xl font-bold text-white">
                    Rs <?php echo e(number_format($plan->investment_amount)); ?>

                </p>
                <p class="text-xs <?php echo e($text); ?>">
                    Membership Price
                </p>
            </div>

            <div class="text-right">
                <p class="text-sm font-bold <?php echo e($accent); ?>">
                    Rs <?php echo e(number_format($plan->daily_profit_min)); ?> – <?php echo e(number_format($plan->daily_profit_max)); ?>

                </p>
                <p class="text-xs <?php echo e($text); ?>">
                    Daily Income
                </p>
            </div>

            <?php if($plan->weekend_reward > 0): ?>
            <div class="text-right">
                <p class="text-sm font-bold <?php echo e($accent); ?>">
                    Rs <?php echo e(number_format($plan->weekend_reward)); ?> - <?php echo e(number_format($plan->weekend_reward * 0.15 + $plan->weekend_reward)); ?>

                </p>
                <p class="text-xs <?php echo e($text); ?>">
                    Weekly Income
                </p>
            </div>
            <?php endif; ?>

        </div>


        <!-- Features -->

        <div class="space-y-2.5 mb-6 text-sm">

            <div class="flex items-center gap-2.5 text-white font-medium">
                <div class="w-5 h-5 rounded-full bg-white/10 flex items-center justify-center <?php echo e($accent); ?>">✔</div>
                Daily Earning
            </div>


            <div class="flex items-center gap-2.5 text-white font-medium">
                <div class="w-5 h-5 rounded-full bg-white/10 flex items-center justify-center <?php echo e($accent); ?>">✔</div>

                Total Income:

                <?php echo e(number_format($plan->daily_profit_min * $plan->duration_days)); ?>

                -
                <?php echo e(number_format($plan->daily_profit_max * $plan->duration_days)); ?>


                Rs

            </div>


            <?php if($plan->daily_tasks > 0): ?>
            <div class="flex items-center gap-2.5 text-white font-medium">
                <div class="w-5 h-5 rounded-full bg-white/10 flex items-center justify-center <?php echo e($accent); ?>">✔</div>

                Daily Tasks: <?php echo e(number_format($plan->daily_tasks)); ?> x <?php echo e(number_format($plan->daily_task_price)); ?> Rs

            </div>
            <?php endif; ?>


            <?php if($plan->free_spins > 0): ?>
            <div class="flex items-center gap-2.5 text-white font-medium">
                <div class="w-5 h-5 rounded-full bg-white/10 flex items-center justify-center <?php echo e($accent); ?>">✔</div>

                Free Spin: <?php echo e(number_format($plan->free_spins)); ?> x <?php echo e(number_format($plan->free_spin_price)); ?> Rs

            </div>
            <?php endif; ?>


            <?php if($plan->weekend_reward > 0): ?>
            <div class="flex items-center gap-2.5 text-white font-medium">
                <div class="w-5 h-5 rounded-full bg-white/10 flex items-center justify-center <?php echo e($accent); ?>">✔</div>

                Weekly Reward:
                <?php echo e(number_format($plan->weekend_reward)); ?>

                -
                <?php echo e(number_format($plan->weekend_reward * 0.15 + $plan->weekend_reward)); ?>


                Rs

            </div>
            <?php endif; ?>


            <!-- Referral -->

            <div class="mt-4 text-center">

                <p class="text-white font-semibold text-[16px]">
                    Referral Reward
                </p>

                <p class="text-[14px] font-extrabold <?php echo e($accent); ?>">

                    Level 1: <?php echo e(number_format($plan->referral_bonus_level1)); ?>%

                    |

                    Level 2: <?php echo e(number_format($plan->referral_bonus_level2)); ?>%

                </p>

            </div>

        </div>


        <!-- Button -->

        <?php if(auth()->guard()->check()): ?>

        <a href="/payment/<?php echo e($plan->id); ?>"
            class="investNow w-full py-1.5 mt-6 mb-0 rounded-xl font-semibold text-white flex items-center justify-center gap-2 bg-gradient-to-r <?php echo e($button); ?> shadow-lg hover:shadow-xl transition-all">

            JOIN NOW

        </a>

        <?php else: ?>

        <a href="/register"
            class="investNow w-full py-1.5 mt-6 mb-0 rounded-xl font-semibold text-white flex items-center justify-center gap-2 bg-gradient-to-r <?php echo e($button); ?> shadow-lg hover:shadow-xl transition-all">

            JOIN NOW

        </a>

        <?php endif; ?>

    </div>
</div><?php /**PATH E:\xampp\htdocs\FeatureDesk\resources\views/user/partials/package_plans.blade.php ENDPATH**/ ?>