<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <?php echo $__env->make('user.includes.general_style', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <title>User Dashboard</title>
</head>

<body class="min-h-screen bg-[#0A0A0F]">

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
                    Rs. <?php echo e(number_format($user->balance ?? 0, 2)); ?>

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
        
        <a href="<?php echo e(route('share.balance')); ?>" 
           class="flex items-center gap-3 bg-gradient-to-br from-gray-900 to-gray-800 border border-gray-700 rounded-lg px-4 py-1 shadow-md hover:shadow-lg hover:from-gray-800 hover:to-gray-700 active:scale-[0.97] transition-all">
            <div class="w-8 h-8 bg-teal-500/10 rounded-md flex items-center justify-center flex-shrink-0">
                <i data-lucide="share-2" class="w-4 h-4 text-teal-400"></i>
            </div>
            <span class="font-medium text-sm text-gray-100">Share</span>
        </a>
        

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
            <a href=""
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








        </div>

<div class="flex w-full gap-3 px-4 mb-4">
    


<style>
@keyframes shine {
    0% { left: -100%; }
    100% { left: 150%; }
}
</style>

<a href=""
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
            <a href="" class="card rounded-xl p-3 text-center hover:scale-105 active:scale-95 transition block focus:outline-none focus:ring-2 focus:ring-green-500">
                <div class="mx-auto mb-1.5 w-10 h-10 rounded-lg bg-emerald-600 flex items-center justify-center shadow-sm">
                    <i data-lucide="list-checks" class="w-5 h-5 text-white"></i>
                </div>
                <p class="font-semibold text-xs mt-1.5">My Tasks</p>
                <span class="absolute -top-1 -right-1 bg-amber-600 text-[9px] font-bold px-1.5 py-0.5 rounded-full shadow"></span>

                
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

            

            
            <a href="<?php echo e(route('my_complaints')); ?>" class="card rounded-xl p-3 text-center hover:scale-105 active:scale-95 transition block focus:outline-none focus:ring-2 focus:ring-green-500">
                <div class="mx-auto mb-1.5 w-10 h-10 rounded-lg bg-amber-600 flex items-center justify-center shadow-sm">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-white"></i>
                </div>
                <p class="font-semibold text-xs mt-1.5">Complaint</p>
            </a>
            


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
                <p class="text-xl font-bold text-emerald-400">0
                </p>

                <p class="text-xs text-gray-400 mb-0.5 mt-1">Tasks Reward</p>
                <p class="text-xl font-bold text-yellow-400">0</p>
            </div>
            <div class="card rounded-xl p-3.5 text-center">
                <p class="text-xs text-gray-400 mb-0.5">Total Withdraw</p>
                <p class="text-xl font-bold text-red-400">0</p>

                <p class="text-xs text-gray-400 mb-0.5 mt-1">Balance Shared</p>
                <p class="text-xl font-bold text-yellow-400">0 
                </p>
            </div>

            <div class="card rounded-xl p-3.5 text-center">
                <p class="text-xs text-gray-400 mb-0.5">Refer Bonus</p>
                <p class="text-xl font-bold text-purple-300">0</p>
            </div>
            <div class="card rounded-xl p-3.5 text-center">
                <p class="text-xs text-gray-400 mb-0.5">Pending Withdraw</p>
                <p class="text-xl font-bold text-cyan-300">0</p>
            </div>

            <div class="card rounded-xl p-3.5 text-center">
                <p class="text-xs text-gray-400 mb-0.5">Team Size</p>
                <p class="text-xl font-bold">0</p>
            </div>
            <div class="card rounded-xl p-3.5 text-center">
                <p class="text-xs text-gray-400 mb-0.5">Team Invest</p>
                <p class="text-xl font-bold">0</p>
            </div>

        </div>

        <!-- Network Stats - compact -->
        
            <div class="bg-gradient-to-r from-purple-900/60 to-blue-900/60 rounded-lg p-3 text-center mx-4 mb-20 card rounded-xl p-4">
                <p class="font-semibold text-base">0</p>
                <p class="text-xs text-gray-400 mt-0.5">Total Earnings</p>
            </div>



        <!-- Bottom Navigation -->
        <?php echo $__env->make('user.includes.bottom_navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    </div> <!-- end mobile container -->



</body>
</html><?php /**PATH E:\xampp\htdocs\zipGo\resources\views/user/dashboard.blade.php ENDPATH**/ ?>