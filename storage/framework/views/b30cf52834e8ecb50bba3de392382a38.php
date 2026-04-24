<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <?php echo $__env->make('user.includes.general_style', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <title>User Dashboard</title>
</head>

<body class="min-h-screen bg-[#0A0A0F]">
<?php
$dollarPrice = \App\Models\DollarPrice::latest()->first()?->price ?? 0;
?>
    <!-- Mobile-like container -->
    <div class="mx-auto max-w-[420px] min-h-screen bg-[#0A0A0F] shadow-2xl shadow-black/50 relative">

        <!-- Top Greeting + Add / Ref (updated: sharp top corners, rounded bottom) -->
        <?php echo $__env->make('user.includes.top_greetings', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>



        <style>
            /* Green Balance Card */
.balance-green {
    background: linear-gradient(90deg, #10b981, #22c55e);
    box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.4),
                0 4px 10px -2px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease;
}

.balance-green:hover {
    transform: translateY(-2px);
}
        </style>



        <div class="px-4 mt-2 mb-3">


            <?php echo $__env->make('includes.success', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
        <!-- Premium Balance Section - Matching Screenshot -->
<div class="px-4 mt-2 mb-4">
    <div class="relative w-full rounded-2xl overflow-hidden
                bg-gradient-to-r from-emerald-500 to-green-600
                border border-emerald-400/30
                px-6 py-5 shadow-xl">

        <!-- Subtle inner glow -->
        <div class="absolute inset-0 bg-white/10 pointer-events-none"></div>

        <div class="flex items-center justify-between">
            
            <!-- Left Side: Text + Amount -->
            <div>
                <p class="text-sm font-semibold text-white/90 tracking-wider uppercase">
                    Earnings Balance
                </p>
                <div id="balanceAmount" 
                     class="text-4xl font-bold text-white tracking-tighter mt-1">
                    $ <?php echo e(number_format(($dollarPrice && $dollarPrice != 0) ? $user->balance / $dollarPrice : 0, 2)); ?>

                </div>
                <div id="balanceAmount" 
                     class="text-1xl font-bold text-white tracking-tighter mt-1">
                    &nbsp;&nbsp;Rs <?php echo e(number_format($user->balance ?? 0, 2)); ?>

                </div>
            </div>

            <!-- Right Side: Bold Green Check -->
            <div class="bg-white/20 backdrop-blur-md rounded-2xl p-3 shadow-inner border border-white/30 flex items-center justify-center">
                <i data-lucide="check" 
                   class="w-9 h-9 text-white stroke-[5]"></i>
            </div>

        </div>
    </div>
</div>




<!-- Smart Thin Quick Action Buttons - 2 per row -->
<div class="px-4 mt-1 mb-4">
    <div class="grid grid-cols-2 gap-3">

        <!-- Awards -->
        <a href="<?php echo e(route('awards')); ?>" 
           class="flex items-center gap-3 bg-gradient-to-br from-gray-900 to-gray-800 border border-gray-700 rounded-lg px-4 py-1 shadow-md hover:shadow-lg hover:from-gray-800 hover:to-gray-700 active:scale-[0.97] transition-all">
            <div class="w-8 h-8 bg-amber-500/10 rounded-md flex items-center justify-center flex-shrink-0">
                <i data-lucide="award" class="w-4 h-4 text-amber-400"></i>
            </div>
            <span class="font-medium text-sm text-gray-100">Awards</span>
        </a>

        <!-- Info -->
        <a href="<?php echo e(route('info')); ?>" 
           class="flex items-center gap-3 bg-gradient-to-br from-gray-900 to-gray-800 border border-gray-700 rounded-lg px-4 py-1 shadow-md hover:shadow-lg hover:from-gray-800 hover:to-gray-700 active:scale-[0.97] transition-all">
            <div class="w-8 h-8 bg-purple-500/10 rounded-md flex items-center justify-center flex-shrink-0">
                <i data-lucide="info" class="w-4 h-4 text-purple-400"></i>
            </div>
            <span class="font-medium text-sm text-gray-100">Info</span>
        </a>

        <!-- Share Balance -->
        <?php if($user->is_balance_sharing_allowed): ?>
        <a href="<?php echo e(route('share.balance')); ?>" 
           class="flex items-center gap-3 bg-gradient-to-br from-gray-900 to-gray-800 border border-gray-700 rounded-lg px-4 py-1 shadow-md hover:shadow-lg hover:from-gray-800 hover:to-gray-700 active:scale-[0.97] transition-all">
            <div class="w-8 h-8 bg-teal-500/10 rounded-md flex items-center justify-center flex-shrink-0">
                <i data-lucide="share-2" class="w-4 h-4 text-teal-400"></i>
            </div>
            <span class="font-medium text-sm text-gray-100">Share</span>
        </a>
        <?php endif; ?>

        <!-- Crypto Hub -->
        <a href="<?php echo e(route('crypto')); ?>" 
           class="flex items-center gap-3 bg-gradient-to-br from-gray-900 to-gray-800 border border-gray-700 rounded-lg px-4 py-1 shadow-md hover:shadow-lg hover:from-gray-800 hover:to-gray-700 active:scale-[0.97] transition-all">
            <div class="w-8 h-8 bg-orange-500/10 rounded-md flex items-center justify-center flex-shrink-0">
                <i data-lucide="bitcoin" class="w-4 h-4 text-orange-400"></i>
            </div>
            <span class="font-medium text-sm text-gray-100">Crypto Hub</span>
        </a>

        <!-- Refresh -->
        <button onclick="location.reload()" 
    class="flex items-center gap-3 bg-gradient-to-br from-gray-900 to-gray-800 border border-gray-700 rounded-lg px-4 py-1 shadow-md hover:shadow-lg hover:from-gray-800 hover:to-gray-700 active:scale-[0.97] transition-all">
            <div class="w-8 h-8 bg-indigo-500/10 rounded-md flex items-center justify-center flex-shrink-0">
                <i data-lucide="refresh-cw" class="w-4 h-4 text-indigo-400"></i>
            </div>
            <span class="font-medium text-sm text-gray-100">Refresh</span>
        </button>

    </div>
</div>

        <!-- Place this somewhere in your layout, preferably at the end of <body> -->
        <dialog id="fixed-deposit-consent-modal" class="p-6 bg-gray-900 rounded-xl text-white max-w-md w-full">
            <h3 class="text-xl font-semibold mb-4">Fixed Deposit Application</h3>
            <p class="mb-6 text-gray-300">
                By proceeding, you consent to:
            </p>
            <ul class="list-disc pl-5 mb-6 text-gray-300 space-y-2.5">
                <li>Your funds will be locked for the entire duration of the selected Fixed Deposit term.</li>
                <li>Withdrawals and premature encashment will not be available until the package maturity date.</li>
                <li>All provisions are subject to the Fixed Deposit product's official Terms and Conditions.</li>
                <li>A daily reward equivalent to 2% of the deposited balance will be credited to your account.</li>
            </ul>

            <div class="flex justify-end gap-4">
                <button
                    type="button"
                    class="px-5 py-2.5 bg-gray-700 hover:bg-gray-600 rounded-lg transition"
                    onclick="document.getElementById('fixed-deposit-consent-modal').close()">
                    Cancel
                </button>
                <button
                    type="button"
                    id="confirm-fd-apply"
                    class="px-5 py-2.5 bg-amber-600 hover:bg-amber-500 rounded-lg transition font-medium">
                    I Agree – Apply
                </button>
            </div>
        </dialog>

        <dialog
            id="already-fixed-deposit-consent-modal"
            class="p-6 bg-gray-900 rounded-xl text-white max-w-md w-full shadow-2xl">
            <h3 class="text-xl font-semibold mb-5 text-gray-100">
                Already a Fixed Deposit Member
            </h3>

            <p class="text-gray-300 mb-6 leading-relaxed">
                This account is already registered as a fixed deposit member.
                Please contact support or use a different account if you wish to proceed with a new registration.
            </p>

            <div class="flex justify-end gap-4">
                <button
                    type="button"
                    class="px-6 py-2.5 bg-gray-700 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 focus:ring-offset-gray-900 rounded-lg font-medium transition-colors duration-200"
                    onclick="document.getElementById('already-fixed-deposit-consent-modal').close()">
                    Close
                </button>
            </div>
        </dialog>



        <!-- Invest / Withdraw Buttons -->
        <div class="flex gap-2 px-4 mb-5">

            <!-- INVEST (Growth - Emerald) -->
            <a href="/plan"
                class="flex-1 py-1.5 rounded-full font-medium text-xs
              bg-gradient-to-r from-emerald-500 to-green-600
              text-white shadow-md
              hover:brightness-110 active:scale-95
              transition-all duration-200
              focus:outline-none focus:ring-2 focus:ring-emerald-400
              block text-center">
                Membership
            </a>

            <!-- UPGRADE PLAN (Progress - Blue/Indigo) -->
            <a href="<?php echo e(route('upgrade_plan')); ?>"
                class="flex-1 py-1.5 rounded-full font-medium text-xs
              bg-gradient-to-r from-indigo-500 to-blue-600
              text-white shadow-md
              hover:brightness-110 active:scale-95
              transition-all duration-200
              focus:outline-none focus:ring-2 focus:ring-indigo-400
              block text-center">
                Upgrade Plan
            </a>

           <!-- WITHDRAW (Neutral - Violet Gradient) -->


<?php if($user->is_withdraw_allowed==1): ?>
<?php
    // If withdraw_timer == 0 → force cooldown OFF
    $isCooldownActive = ($user->withdraw_timer == 0) ? false : $isCooldownActive;

    // Only FD or cooldown can disable the button
    $isFdOrCooldown = $user->is_fd || $isCooldownActive;

    // Final disabled state
    $isDisabled = $isFdOrCooldown;
?>

<a href="<?php echo e($isDisabled ? '#' : '/withdraw'); ?>"
   id="withdrawBtn"
   class="flex-1 py-1.5 rounded-full font-medium text-xs text-center block
   transition-all duration-200
   focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-900
   <?php echo e($isDisabled
        ? 'bg-gray-700/50 text-gray-400 cursor-not-allowed opacity-65 shadow-none pointer-events-none'
        : 'bg-gradient-to-r from-violet-500 to-purple-600 text-white shadow-md hover:brightness-110 active:scale-95 focus:ring-violet-400 cursor-pointer'); ?>"
   aria-disabled="<?php echo e($isDisabled ? 'true' : 'false'); ?>"
   <?php echo e($isDisabled ? 'tabindex=-1' : ''); ?>

   title="<?php echo e($user->is_fd 
           ? 'Withdrawals are not available while you have an active Fixed Deposit'
           : ($isCooldownActive 
               ? 'Withdraw available after cooldown'
               : 'Withdraw funds'
             )); ?>">

    <?php if($isCooldownActive): ?>
        <span id="countdown"></span>
    <?php else: ?>
        Withdraw
    <?php endif; ?>
</a>

<?php if($isCooldownActive): ?>
<script>
    const nextActionTime = new Date("<?php echo e($nextWithdrawTime->toIso8601String()); ?>").getTime();
    
    // Withdraw countdown (already exists)
    const withdrawCountdownEl = document.getElementById('countdown');
    
    // Share countdown (new)
    const shareCountdownEl = document.getElementById('shareCountdown');

    const cooldownTimer = setInterval(function () {
        const now = new Date().getTime();
        const distance = nextActionTime - now;

        if (distance <= 0) {
            clearInterval(cooldownTimer);
            location.reload(); // both buttons become active again
            return;
        }

        const days    = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours   = Math.floor((distance / (1000 * 60 * 60)) % 24);
        const minutes = Math.floor((distance / (1000 * 60)) % 60);
        const seconds = Math.floor((distance / 1000) % 60);

        const timeStr = days + "d " + hours + "h " + minutes + "m " + seconds + "s";

        // Update both places if elements exist
        if (withdrawCountdownEl) withdrawCountdownEl.innerHTML = timeStr;
        if (shareCountdownEl)    shareCountdownEl.innerHTML    = timeStr;

    }, 1000);
</script>
<?php endif; ?>

<?php else: ?>
<a href="#"
   class="flex-1 py-1.5 rounded-full font-medium text-xs text-center block
   bg-gradient-to-r from-violet-500 to-purple-600 text-white
   shadow-md hover:brightness-110 active:scale-95
   focus:outline-none focus:ring-2 focus:ring-violet-400 focus:ring-offset-2 focus:ring-offset-gray-900
   transition-all duration-200 cursor-pointer"
   title="Withdraw funds">
    Withdraw
</a>
<?php endif; ?>
        </div>

<div class="flex w-full gap-3 px-4 mb-4">
    
    <!-- <a href="<?php echo e(route('games.lucky-spin')); ?>"
       class="flex-1 min-w-0 py-2.5 px-3 rounded-xl text-center font-bold text-sm leading-tight
              bg-gradient-to-r from-yellow-500 to-orange-600
              text-white shadow-lg
              hover:brightness-110 active:scale-95
              transition-all duration-300">
       Spin & Win
    </a> -->

<style>
@keyframes shine {
    0% { left: -100%; }
    100% { left: 150%; }
}
</style>

<a href="<?php echo e(route('games')); ?>"
   class="relative flex-1 min-w-0 py-3 px-4 rounded-xl text-center font-bold text-sm leading-tight
          text-white shadow-xl overflow-hidden
          bg-gradient-to-r from-yellow-400 via-orange-500 to-amber-600
          animate-pulse hover:animate-none
          transition-all duration-300 hover:scale-105 active:scale-95">

    <!-- Shine effect -->
    <span class="absolute inset-0 overflow-hidden rounded-xl">
        <span class="absolute -left-full top-0 h-full w-1/2 bg-white/30 skew-x-12
                     animate-[shine_2.5s_infinite]"></span>
    </span>

    <!-- Glow ring -->
    <span class="absolute inset-0 rounded-xl blur-md opacity-80
                 bg-gradient-to-r from-yellow-300 to-orange-500"></span>

    <!-- Text -->
    <span class="relative z-10 text-black font-bold tracking-wide">
        🎮 Lucky Games 🎮 قسمت آزمائیں
    </span>
</a>

</div>

        <!-- Grid Menu - compact version -->
        <div class="grid grid-cols-3 gap-3 px-4 mb-4">
            <a href="/my-plans" class="card rounded-xl p-3 text-center hover:scale-105 active:scale-95 transition relative block focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <div class="mx-auto mb-1.5 w-10 h-10 rounded-lg bg-gradient-to-br from-indigo-600 to-purple-800 flex items-center justify-center">
                    <i data-lucide="layers" class="w-5 h-5"></i>
                </div>
                <p class="font-semibold text-xs">My Plans</p>
            </a>

            <a href="/invite" class="card rounded-xl p-3 text-center hover:scale-105 active:scale-95 transition relative block focus:outline-none focus:ring-2 focus:ring-purple-500">
                <div class="mx-auto mb-1.5 w-10 h-10 rounded-lg bg-gradient-to-br from-purple-600 to-pink-600 flex items-center justify-center">
                    <i data-lucide="users" class="w-5 h-5"></i>
                </div>
                <p class="font-semibold text-xs">My Team</p>

            </a>

            <!-- Tasks / Missions -->
            <a href="<?php echo e(route('my_tasks')); ?>" class="card rounded-xl p-3 text-center hover:scale-105 active:scale-95 transition block focus:outline-none focus:ring-2 focus:ring-green-500">
                <div class="mx-auto mb-1.5 w-10 h-10 rounded-lg bg-emerald-600 flex items-center justify-center shadow-sm">
                    <i data-lucide="list-checks" class="w-5 h-5 text-white"></i>
                </div>
                <p class="font-semibold text-xs mt-1.5">My Tasks</p>
                <span class="absolute -top-1 -right-1 bg-amber-600 text-[9px] font-bold px-1.5 py-0.5 rounded-full shadow"><?php echo e($myTasksToday); ?></span>

                <!-- <span class="absolute -bottom-1 -right-1 bg-green-600 text-[9px] font-bold px-1.5 py-0.5 rounded-full shadow">Total <?php echo e($myTasksTotal); ?></span> -->
            </a>



            <a href="/my-orders" class="card rounded-xl p-3 text-center hover:scale-105 active:scale-95 transition block focus:outline-none focus:ring-2 focus:ring-green-500">
                <div class="mx-auto mb-1.5 w-10 h-10 rounded-lg bg-gradient-to-br from-green-600 to-emerald-700 flex items-center justify-center">
                    <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                </div>
                <p class="font-semibold text-xs">My Orders</p>
            </a>

            <a href="/withdraw-history" class="card rounded-xl p-3 text-center hover:scale-105 active:scale-95 transition block focus:outline-none focus:ring-2 focus:ring-red-500">
                <div class="mx-auto mb-1.5 w-10 h-10 rounded-lg bg-gradient-to-br from-red-600 to-rose-700 flex items-center justify-center">
                    <i data-lucide="upload" class="w-5 h-5"></i>
                </div>
                <p class="font-semibold text-xs">Withdraw Log</p>
            </a>

            <a href="/FeatureDesk.apk" class="card rounded-xl p-3 text-center hover:scale-105 active:scale-95 transition block focus:outline-none focus:ring-2 focus:ring-orange-500">
                <div class="mx-auto mb-1.5 w-10 h-10 rounded-lg bg-gradient-to-br from-orange-500 to-amber-600 flex items-center justify-center">
                    <i data-lucide="smartphone" class="w-5 h-5"></i>
                </div>
                <p class="font-semibold text-xs">App Download</p>
            </a>

            

            <?php if($user->is_complaint_allowed==1): ?>
            <a href="<?php echo e(route('my_complaints')); ?>" class="card rounded-xl p-3 text-center hover:scale-105 active:scale-95 transition block focus:outline-none focus:ring-2 focus:ring-green-500">
                <div class="mx-auto mb-1.5 w-10 h-10 rounded-lg bg-amber-600 flex items-center justify-center shadow-sm">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-white"></i>
                </div>
                <p class="font-semibold text-xs mt-1.5">Complaint</p>
            </a>
            <?php else: ?>
             <a href="#" class="card rounded-xl p-3 text-center hover:scale-105 active:scale-95 transition block focus:outline-none focus:ring-2 focus:ring-green-500">
                <div class="mx-auto mb-1.5 w-10 h-10 rounded-lg bg-amber-600 flex items-center justify-center shadow-sm">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-white"></i>
                </div>
                <p class="font-semibold text-xs mt-1.5">Complaint</p>
            </a>
            <?php endif; ?>


            <a href="/all-transactions" class="card rounded-xl p-3 text-center hover:scale-105 active:scale-95 transition block focus:outline-none focus:ring-2 focus:ring-blue-500">
                <div class="mx-auto mb-1.5 w-10 h-10 rounded-lg bg-gradient-to-br from-blue-600 to-cyan-600 flex items-center justify-center">
                    <i data-lucide="receipt" class="w-5 h-5"></i>
                </div>
                <p class="font-semibold text-xs">Transactions</p>
            </a>



            <a href="https://whatsapp.com/channel/0029VbCEe3o0lwgyDdnKFe1H" rel="noopener noreferrer"
                class="card rounded-xl p-3 text-center hover:scale-105 active:scale-95 transition block focus:outline-none focus:ring-2 focus:ring-green-500">
                <div class="mx-auto mb-1.5 w-10 h-10 rounded-lg bg-green-600 flex items-center justify-center shadow-sm">

                    <i class="fab fa-whatsapp"></i>

                </div>
                <p class="font-semibold text-xs mt-1.5 text-white-700">Helpline</p>
            </a>


        </div>

        <!-- Referral Link - compact version -->
        <div class="mx-4 mb-4 card rounded-xl p-4">
            <h3 class="text-base font-bold mb-1 text-center">Referral Link</h3>

            <div class="bg-gray-900/60 rounded-lg p-3 mb-1 text-center text-xs break-all" id="referral-link">
                <?php echo e(env('APP_URL')); ?>/register/26<?php echo e(auth()->user()->id ?? 'N/A'); ?>

            </div>

            <div class="flex gap-2.5">
                <!-- Copy Button -->
                <button
                    id="copy-btn"
                    class="flex-1 py-1 rounded-full gradient-primary font-semibold text-sm active:scale-95 transition">
                    Copy
                </button>

                <!-- Share on WhatsApp Button - now green -->
                <button
                    id="whatsapp-btn"
                    class="flex-1 py-1 rounded-full font-semibold text-sm flex items-center justify-center gap-1.5 active:scale-95 transition bg-[#25D366] hover:bg-[#20b858] text-white">
                    <i class="fab fa-whatsapp w-4 h-4"></i>
                    WhatsApp
                </button>

            </div>
        </div>




        <!-- Stats Cards - compact -->
        <div class="px-4 grid grid-cols-2 gap-3 mb-2">

            <div class="card rounded-xl p-3.5 text-center">
                <p class="text-xs text-gray-400 mb-0.5">Total Deposit</p>
                <p class="text-xl font-bold text-emerald-400">$ <?php echo e(number_format(($dollarPrice && $dollarPrice != 0) ? $total_deposit / $dollarPrice : 0, 2)); ?>

                </p>

                <p class="text-xs text-gray-400 mb-0.5 mt-1">Tasks Reward</p>
                <p class="text-xl font-bold text-yellow-400">$ <?php echo e(number_format(($dollarPrice && $dollarPrice != 0) ? $tasksReward / $dollarPrice : 0, 2)); ?></p>
            </div>
            <div class="card rounded-xl p-3.5 text-center">
                <p class="text-xs text-gray-400 mb-0.5">Total Withdraw</p>
                <p class="text-xl font-bold text-red-400">$ <?php echo e(number_format(($dollarPrice && $dollarPrice != 0) ? $total_withdraw / $dollarPrice : 0, 2)); ?></p>

                <p class="text-xs text-gray-400 mb-0.5 mt-1">Balance Shared</p>
                <p class="text-xl font-bold text-yellow-400">$ <?php echo e(number_format(($dollarPrice && $dollarPrice != 0) ? $balanceTransfer / $dollarPrice : 0, 2)); ?> 
                </p>
            </div>

            <div class="card rounded-xl p-3.5 text-center">
                <p class="text-xs text-gray-400 mb-0.5">Refer Bonus</p>
                <p class="text-xl font-bold text-purple-300">$ <?php echo e(number_format(($dollarPrice && $dollarPrice != 0) ? $refer_bonus / $dollarPrice : 0, 2)); ?></p>
            </div>
            <div class="card rounded-xl p-3.5 text-center">
                <p class="text-xs text-gray-400 mb-0.5">Pending Withdraw</p>
                <p class="text-xl font-bold text-cyan-300">$ <?php echo e(number_format(($dollarPrice && $dollarPrice != 0) ? $total_withdraw_pending / $dollarPrice : 0, 2)); ?></p>
            </div>

            <div class="card rounded-xl p-3.5 text-center">
                <p class="text-xs text-gray-400 mb-0.5">Team Size</p>
                <p class="text-xl font-bold"><?php echo e($team_size); ?></p>
            </div>
            <div class="card rounded-xl p-3.5 text-center">
                <p class="text-xs text-gray-400 mb-0.5">Team Invest</p>
                <p class="text-xl font-bold">$ <?php echo e(number_format(($dollarPrice && $dollarPrice != 0) ? $team_invest / $dollarPrice : 0, 2)); ?></p>
            </div>

        </div>

        <!-- Network Stats - compact -->
        
            <div class="bg-gradient-to-r from-purple-900/60 to-blue-900/60 rounded-lg p-3 text-center mx-4 mb-20 card rounded-xl p-4">
                <p class="font-semibold text-base">$ <?php echo e(number_format(($dollarPrice && $dollarPrice != 0) ? ($refer_bonus + $dailyProfit + $tasksReward) / $dollarPrice : 0, 2)); ?></p>
                <p class="text-xs text-gray-400 mt-0.5">Total Earnings</p>
            </div>



        <!-- Bottom Navigation -->
        <?php echo $__env->make('user.includes.bottom_navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    </div> <!-- end mobile container -->


    <?php if(auth()->guard()->check()): ?>
<?php
    $user = auth()->user();
    $phoneNumber = '447412803448';
    $defaultMessage = "Hello Feature Desk Support Team,%0A%0AUsername: {$user->username}%0APhone: {$user->phone}";
?>

<!-- Floating Buttons Container -->
<!-- <div class="fixed bottom-20 left-0 right-0 z-50 pointer-events-none"
     style="max-width: 420px; margin-left:auto; margin-right:auto;">
    <div class="flex justify-between px-4 pointer-events-auto gap-2"> -->

        


<!-- <a href="<?php echo e(route('crypto')); ?>" 
   class="inline-flex items-center gap-1.5
          px-3 py-1.5 
          rounded-l-none rounded-r-full
          bg-amber-900 border border-amber-500
          text-amber-200 hover:text-amber-100
          text-xs font-semibold uppercase tracking-wider
          shadow-lg shadow-amber-900/40
          hover:scale-105 transition-all duration-300">
    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.94-.49-7-3.85-7-7.93s3.06-7.44 7-7.93V17.93zm2-13.86c3.94.49 7 3.85 7 7.93s-3.06 7.44-7 7.93V4.07z"/>
        <path d="M13.5 9h-3v2h3c.55 0 1 .45 1 1s-.45 1-1 1h-3v2h3c1.1 0 2-.9 2-2s-.9-2-2-2z"/>
    </svg>
    Crypto Currency
</a> -->


<!-- <a href="https://www.whatsapp.com/channel/0029VbCEe3o0lwgyDdnKFe1H" rel="noopener noreferrer"
   target="_blank"
   class="flex items-center gap-2
          bg-green-500 hover:bg-green-600
          text-white font-medium
          px-3 py-2 
          rounded-l-full rounded-r-none
          shadow-xl transition-all duration-300
          animate-bounce-slow">

    <svg xmlns="http://www.w3.org/2000/svg"
         class="w-4 h-4"
         fill="currentColor"
         viewBox="0 0 24 24">
        <path d="M12.04 2C6.52 2 2.04 6.48 2.04 12c0 1.89.5 3.66 1.37 5.2L2 22l4.93-1.33A9.94 9.94 0 0012.04 22c5.52 0 10-4.48 10-10S17.56 2 12.04 2zm5.61 14.14c-.24.67-1.38 1.24-1.9 1.3-.5.06-1.14.09-1.85-.15-.43-.14-.98-.32-1.69-.63-2.98-1.29-4.92-4.32-5.07-4.52-.15-.2-1.21-1.61-1.21-3.08s.77-2.2 1.04-2.5c.27-.3.59-.37.79-.37h.57c.18 0 .43-.07.67.5.24.58.82 2 .89 2.14.07.14.12.3.02.49-.1.19-.15.3-.3.46-.15.16-.32.35-.45.47-.15.14-.31.3-.13.6.18.3.8 1.32 1.71 2.14 1.17 1.04 2.16 1.37 2.47 1.52.3.15.48.13.66-.08.18-.21.77-.9.97-1.21.2-.3.4-.25.67-.15.27.1 1.71.8 2 1 .29.2.48.3.55.47.07.16.07.95-.17 1.62z"/>
    </svg>

    <span class="text-xs">Helpline</span>
</a> -->

    <!-- </div>
</div> -->
<?php endif; ?>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const el = document.getElementById('balanceAmount');
    el.classList.add('balance-pulse');
});
</script>
<script>
            document.getElementById('fixed-deposit-btn')?.addEventListener('click', () => {
                document.getElementById('fixed-deposit-consent-modal').showModal();
            });

            document.getElementById('already-fixed-deposit-btn')?.addEventListener('click', () => {
                document.getElementById('already-fixed-deposit-consent-modal').showModal();
            });

            document.getElementById('confirm-fd-apply')?.addEventListener('click', () => {
                document.getElementById('fixed-deposit-consent-modal').close();
                // Proceed with application
                window.location.href = '/apply-fixed-deposit';
                // or: document.getElementById('fd-apply-form').submit();
            });
        </script>
<script>
            // Refresh button - reload page
            document.getElementById('refresh-btn')?.addEventListener('click', () => {
                window.location.reload();
            });

        </script>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const linkElement = document.getElementById('referral-link');
                const fullLink = linkElement.textContent.trim();

                // Copy button
                document.getElementById('copy-btn').addEventListener('click', () => {
                    navigator.clipboard.writeText(fullLink)
                        .then(() => {
                            const btn = document.getElementById('copy-btn');
                            const originalText = btn.textContent;
                            btn.textContent = 'Copied!';
                            btn.classList.add('bg-green-600');

                            setTimeout(() => {
                                btn.textContent = originalText;
                                btn.classList.remove('bg-green-600');
                            }, 2000);
                        })
                        .catch(err => {
                            console.error('Copy failed:', err);
                            alert('Could not copy — please select and copy manually');
                        });
                });

                // WhatsApp Share button
                document.getElementById('whatsapp-btn').addEventListener('click', () => {
                    const text = "Join me using my referral link! 🚀\n\n" + fullLink;
                    const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(text)}`;
                    window.open(whatsappUrl, '_blank');
                });
            });
        </script>





<!-- games popup -->
<!-- <dialog id="games-modal" class="modal bg-transparent">

    <div class="modal-box pointer-events-auto max-w-sm bg-gradient-to-b from-[#0f0f1a] to-[#0b0b12] 
                border border-purple-500/30 shadow-[0_0_40px_rgba(168,85,247,0.35)] 
                rounded-3xl p-7 text-center relative overflow-hidden animate-[fadeIn_0.4s_ease]">

        
        <button id="closeModalBtn"
        class="absolute right-4 top-4 text-gray-400 hover:text-white text-lg z-50">
    ✕
</button>

        
        <div class="absolute -top-20 -right-20 w-48 h-48 bg-purple-600/20 blur-3xl rounded-full"></div>
        <div class="absolute -bottom-20 -left-20 w-48 h-48 bg-indigo-600/20 blur-3xl rounded-full"></div>

        
        <div class="mx-auto w-20 h-20 bg-gradient-to-br from-purple-600 to-indigo-600 
                    rounded-2xl flex items-center justify-center text-5xl mb-6
                    shadow-[0_0_25px_rgba(168,85,247,0.9)] animate-pulse">
            🎰
        </div>

        
        <h2 class="text-3xl font-extrabold text-white mb-6">
            Ready to Play?
        </h2>

        
        <button onclick="goToGames()"
        class="w-full py-3 rounded-xl font-bold text-white 
               bg-gradient-to-r from-orange-500 to-amber-400
               hover:scale-105 active:scale-95 transition 
               shadow-[0_0_20px_rgba(249,115,22,0.7)]">
    Lucky Games
</button>

    </div>

</dialog>

<script>
    const modal = document.getElementById('games-modal');

    window.addEventListener('load', function () {
        modal.showModal();
    });

    document.getElementById('closeModalBtn').addEventListener('click', function () {
        modal.close();
    });

    function goToGames() {
        window.location.href = '/games';
    }
</script> -->




<!-- spin popup -->
<!-- <dialog id="max-spin-modal" class="modal bg-transparent">

    <div class="modal-box pointer-events-auto max-w-sm bg-gradient-to-b from-[#0f0f1a] to-[#0b0b12] 
                border border-purple-500/30 shadow-[0_0_40px_rgba(168,85,247,0.35)] 
                rounded-3xl p-7 text-center relative overflow-hidden">

<button 
    onclick="document.getElementById('max-spin-modal').close()" 
    class="absolute right-4 top-4 z-50 text-gray-400 hover:text-white text-lg bg-transparent border-none cursor-pointer outline-none focus:outline-none focus:ring-0">
    ✕
</button> -->

        <!-- glow background -->
        <!-- <div class="absolute -top-20 -right-20 w-48 h-48 bg-purple-600/20 blur-3xl rounded-full"></div>
        <div class="absolute -bottom-20 -left-20 w-48 h-48 bg-indigo-600/20 blur-3xl rounded-full"></div> -->

        <!-- icon -->
        <!-- <div class="mx-auto w-20 h-20 bg-gradient-to-br from-purple-600 to-indigo-600 
                    rounded-2xl flex items-center justify-center text-5xl mb-5
                    shadow-[0_0_20px_rgba(168,85,247,0.8)] animate-pulse">
            🎰
        </div> -->

        <!-- title -->
        <!-- <h2 class="text-3xl font-extrabold text-white tracking-tight">
            Max Spin Ready
        </h2>

        <p class="text-gray-400 mt-2 text-sm leading-relaxed">
            We selected the <span class="text-purple-400 font-semibold">highest amount</span>
            your balance allows so you get the <span class="text-emerald-400 font-semibold">maximum win potential</span>.
        </p> -->

        <!-- amount box -->
        <!-- <div class="mt-6 mb-7 bg-[#11111c] rounded-2xl p-5 border border-emerald-500/30 
                    shadow-[0_0_25px_rgba(16,185,129,0.25)]">

            <div class="text-xs text-amber-300 tracking-widest uppercase">
                Maximum Spin Amount
            </div>

            <div id="popup-max-amount"
                 class="text-5xl font-black text-emerald-400 mt-2 tracking-tight">
                Rs 10,000
            </div>

        </div> -->

        <!-- buttons -->
        <!-- <div class="flex gap-3">

            
            <button id="popup-play-spin"
                    class="flex-1 py-3 rounded-xl font-bold text-white 
                           bg-gradient-to-r from-emerald-500 to-green-400
                           hover:scale-105 active:scale-95 transition 
                           shadow-[0_0_18px_rgba(16,185,129,0.7)]">

                SPIN & WIN →
            </button>

        </div>

    </div> -->

    

<!-- </dialog> -->


<!-- <script>
document.addEventListener('DOMContentLoaded', () => {
    const modal       = document.getElementById('max-spin-modal');
    const amountEl    = document.getElementById('popup-max-amount');
    const playBtn     = document.getElementById('popup-play-spin');

    if (!modal || !amountEl || !playBtn) {
        console.warn('Max spin modal elements missing');
        return;
    }

    // Get real balance from Blade
    const balance = parseFloat('<?php echo e(auth()->user()->balance ?? 0); ?>') || 0;

    const amounts = [50, 100, 200, 500, 1000, 2000, 3000, 4000, 5000, 8000, 10000];
    const maxAmount = amounts.reduce((prev, curr) => curr <= balance ? curr : prev, 0);

    if (maxAmount < 50) return;

    amountEl.textContent = `Rs ${maxAmount.toLocaleString('en-IN')}`;

    // Open modal on load
    modal.showModal();   // ← this is the reliable way

    // Play button redirects
    playBtn.addEventListener('click', () => {
        modal.close();
        // Tiny delay gives close animation time
        setTimeout(() => {
            window.location.href = `/lucky-spin?auto=true&amount=${maxAmount}`;
        }, 200);
    });
});
</script> -->

</body>
</html><?php /**PATH E:\xampp\htdocs\FeatureDesk\resources\views/user/user_dashboard.blade.php ENDPATH**/ ?>