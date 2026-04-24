<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  <?php echo $__env->make('user.includes.general_style', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  <title>My Plans</title>
</head>

<body class="min-h-screen bg-[#0A0A0F]">

  <div class="mx-auto max-w-[420px] min-h-screen bg-[#0A0A0F] shadow-2xl shadow-black/50 relative">

    <!-- Top Greeting -->
    <?php echo $__env->make('user.includes.top_greetings', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- ... header and includes remain the same ... -->

    <div class="px-4 pt-4 pb-24">
      <!-- Warning / Info banner -->
      <div class="flex items-center gap-3 px-4 py-3 bg-amber-900/30 border border-amber-700/40 rounded-lg text-amber-200 text-sm mb-3">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <p>
          New plan activations are processed within <span class="font-semibold">24 hours</span>.
        </p>
      </div>
      <!-- Header -->

      

      <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold">My Plans</h1>
        <span class="text-xs px-3 py-1.5 bg-purple-900/40 text-purple-300 rounded-full border border-purple-700/40">
          <?php echo e($activeCount); ?> Active
        </span>
      </div>

      <?php echo $__env->make('includes.success', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

      <!-- 1. Active Plans -->
      <?php if($active->isNotEmpty()): ?>
      <div class="mb-8">
        <h2 class="text-sm uppercase tracking-wider text-gray-400/90 mb-3 px-1">Active Plans</h2>
        <div class="space-y-4">
          <?php $__currentLoopData = $active; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="card rounded-xl overflow-hidden glow bg-gradient-to-b from-gray-900/80 to-gray-950/80 border border-purple-800/30">
            <div class="p-4">
              <div class="flex justify-between items-start mb-3">
                <div>
                  <h3 class="font-semibold text-lg"><?php echo e($plan->package_name); ?></h3>
                  <p class="text-xs text-purple-400 mt-0.5">
                    Invested: Rs. <?php echo e(number_format($plan->amount, 2)); ?>

                  </p>
                </div>


                <span class="text-xs px-2.5 py-1 bg-gray-600/60 text-gray-300 rounded-full"><?php echo e($plan->duration_days); ?> days</span>

                <span class="text-xs px-2.5 py-1 bg-green-900/50 text-green-300 rounded-full border border-green-700/40">
                  Active
                </span>
              </div>
              <div class="grid grid-cols-2 gap-3 text-xs mb-4">

                <div>
                  <p class="text-gray-400">Daily Tasks</p>
                  <p class="font-medium text-green-400"><?php echo e($plan->daily_tasks); ?> x <?php echo e($plan->daily_task_price); ?> Rs</p>
                </div>
                <?php if($plan->free_spins > 0): ?>
                <div>
                  <p class="text-gray-400">Free Spins</p>
                  <p class="font-medium"><?php echo e($plan->free_spins); ?> x <?php echo e($plan->free_spin_price); ?> Rs</p>
                </div>
                <?php endif; ?>

                <div>
                  <p class="text-gray-400">Daily Profit</p>
                  <p class="font-medium text-green-400"><?php echo e($plan->daily_profit_display); ?> Rs</p>
                </div>

                <?php if($plan->weekend_reward > 0): ?>
                <div>
                  <p class="text-gray-400">Weekend Reward</p>
                  <p class="font-medium text-green-400"><?php echo e($plan->weekend_reward); ?> - <?php echo e(number_format($plan->weekend_reward * 0.15 + $plan->weekend_reward)); ?> Rs</p>
                </div>
                <?php endif; ?>

                <div>
                  <p class="text-gray-400">Started on</p>
                  <p class="font-medium"><?php echo e(\Carbon\Carbon::parse($plan->approved_at)->format('d M Y • h:i A')); ?></p>
                </div>

                <div>
                  <p class="text-gray-400">Expires</p>
                  <p class="font-medium text-amber-400">
                    <?php echo e($plan->expires_at->format('d M Y • h:i A')); ?>

                  </p>
                </div>


                <div>
                  <p class="text-gray-400">Ends in</p>
                  <p class="font-medium text-amber-400">
                    <?php echo e($plan->days_remaining); ?> day<?php echo e($plan->days_remaining == 1 ? '' : 's'); ?>

                  </p>
                </div>

                <div class="mt-2">
                  <form action="<?php echo e(route('plan.cancel', $plan->payment_id)); ?>" method="POST"
                    onsubmit="return confirm('Are you sure you want to cancel this plan?')">
                    <?php echo csrf_field(); ?>
                    <button class="px-1 py-0.5 text-xs bg-red-600 hover:bg-red-700 text-white rounded-sm">
                      Cancel Plan
                    </button>
                  </form>
                </div>

                <div>
                  <p class="text-gray-400"></p>
                  <p class="font-medium text-green-400"></p>
                </div>


              </div>
              <!-- show progress bar $plan->duration_days, $plan->days_remaining -->
              <?php
              $totalDuration = $plan->duration_days;
              $elapsed = $totalDuration - $plan->days_remaining;
              $progressPercentage = ($elapsed / $totalDuration) * 100;
              ?>
              <div class="h-2 bg-gray-700 rounded-full overflow-hidden">
                <div class="h-full bg-green-400" style="width: <?php echo e($progressPercentage); ?>%"></div>
              </div>
            </div>
          </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>
      <?php endif; ?>

      <!-- 2. Pending -->
      <?php if($pending->isNotEmpty()): ?>
      <div class="mb-8">
        <h2 class="text-sm uppercase tracking-wider text-gray-400/90 mb-3 px-1">Pending Approvals</h2>
        <div class="space-y-4">
          <?php $__currentLoopData = $pending; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="card rounded-xl overflow-hidden bg-gray-900/70 border border-amber-800/40">
            <div class="p-4">
              <div class="flex justify-between items-center mb-3">
                <h3 class="font-semibold text-lg"><?php echo e($plan->package_name); ?></h3>
                <span class="text-xs px-2.5 py-1 bg-gray-600/60 text-gray-300 rounded-full"><?php echo e($plan->duration_days); ?> days</span>
                <span class="text-xs px-2.5 py-1 bg-amber-900/60 text-amber-300 rounded-full">Pending</span>
              </div>
              <div class="text-sm space-y-1 mb-4">
                <div class="flex justify-between">
                  <span class="text-gray-400">Amount:</span>
                  <span>Rs. <?php echo e(number_format($plan->amount, 0)); ?></span>
                </div>
                <div class="flex justify-between">
                  <span class="text-gray-400">Submitted:</span>
                  <span><?php echo e(\Carbon\Carbon::parse($plan->created_at)->diffForHumans()); ?></span>
                </div>
              </div>
              <p class="text-xs text-amber-400 text-center">Awaiting admin review</p>
            </div>
          </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>
      <?php endif; ?>

      <!-- 3. Expired Plans (approved but time ended) -->
      <?php if($expired->isNotEmpty()): ?>
      <div class="mb-8">
        <h2 class="text-sm uppercase tracking-wider text-gray-400/90 mb-3 px-1">Expired Plans</h2>
        <div class="space-y-4">
          <?php $__currentLoopData = $expired; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="card rounded-xl overflow-hidden bg-gray-900/60 border border-gray-700/50 opacity-80">
            <div class="p-4">
              <div class="flex justify-between items-center mb-3">
                <h3 class="font-semibold text-lg"><?php echo e($plan->package_name); ?></h3>
                <span class="text-xs px-2.5 py-1 bg-gray-600/60 text-gray-300 rounded-full"><?php echo e($plan->duration_days); ?> days</span>
                <span class="text-xs px-2.5 py-1 bg-gray-600/60 text-gray-300 rounded-full">Expired</span>
              </div>
              <div class="text-sm space-y-1 mb-3">
                <div class="flex justify-between">
                  <span class="text-gray-400">Invested:</span>
                  <span>Rs. <?php echo e(number_format($plan->amount, 0)); ?></span>
                </div>
                <div class="flex justify-between">
                  <span class="text-gray-400">Started on:</span>
                  <span><?php echo e(\Carbon\Carbon::parse($plan->approved_at)->format('d M Y • h:i A')); ?></span>
                </div>
                <div class="flex justify-between">
                  <span class="text-gray-400">Expired on:</span>
                  <span><?php echo e(\Carbon\Carbon::parse($plan->expires_at)->format('d M Y • h:i A')); ?></span>
                </div>
              </div>
              <p class="text-xs text-gray-500 text-center">Plan has ended. You can invest in a new package.</p>
            </div>
          </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>
      <?php endif; ?>



      <!-- 4. Rejected -->
      <?php if($rejected->isNotEmpty()): ?>
      <div class="mb-8">
        <h2 class="text-sm uppercase tracking-wider text-gray-400/90 mb-3 px-1">Rejected Requests</h2>
        <div class="space-y-4">
          <?php $__currentLoopData = $rejected; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="card rounded-xl overflow-hidden bg-gray-900/60 border border-red-800/40 opacity-85">
            <div class="p-4">
              <div class="flex justify-between items-center mb-3">
                <h3 class="font-semibold text-lg"><?php echo e($plan->package_name); ?></h3>
                <span class="text-xs px-2.5 py-1 bg-red-900/60 text-red-300 rounded-full">Rejected</span>
              </div>
              <p class="text-sm mb-2">Amount: <strong>Rs. <?php echo e(number_format($plan->amount, 0)); ?></strong></p>
              <?php if($plan->admin_note): ?>
              <p class="text-xs text-red-300 mb-3">Note: <?php echo e($plan->admin_note); ?></p>
              <?php endif; ?>
              <p class="text-xs text-gray-500">
                <?php echo e(\Carbon\Carbon::parse($plan->updated_at)->diffForHumans()); ?>

              </p>
            </div>
          </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>
      <?php endif; ?>

      <!-- 5. Cancelled -->
      <?php if($cancelled->isNotEmpty()): ?>
      <div class="mb-8">
        <h2 class="text-sm uppercase tracking-wider text-gray-400/90 mb-3 px-1">Cancelled Requests</h2>
        <div class="space-y-4">
          <?php $__currentLoopData = $cancelled; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="card rounded-xl overflow-hidden bg-gray-900/60 border border-red-800/40 opacity-85">
            <div class="p-4">
              <div class="flex justify-between items-center mb-3">
                <h3 class="font-semibold text-lg"><?php echo e($plan->package_name); ?></h3>
                <span class="text-xs px-2.5 py-1 bg-red-900/60 text-red-300 rounded-full">Cancelled</span>
              </div>
              <p class="text-sm mb-2">Amount: <strong>Rs. <?php echo e(number_format($plan->amount, 0)); ?></strong></p>
              <?php if($plan->admin_note): ?>
              <p class="text-xs text-red-300 mb-3">Note: <?php echo e($plan->admin_note); ?></p>
              <?php endif; ?>
              <p class="text-xs text-gray-500">
                <?php echo e(\Carbon\Carbon::parse($plan->updated_at)->diffForHumans()); ?>

              </p>
            </div>
          </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>
      <?php endif; ?>

      <!-- Empty state if nothing at all -->
      <?php if($active->isEmpty() && $pending->isEmpty() && $rejected->isEmpty() && $expired->isEmpty()): ?>
      <div class="text-center py-12 text-gray-500">
        <p class="text-lg">No plans yet</p>
        <p class="mt-2">Browse available packages and start investing!</p>
      </div>
      <?php endif; ?>

      <!-- Available Packages section remains as before or make dynamic -->

    </div>

    <!-- bottom nav etc. -->

    <!-- Bottom Nav -->
    <?php echo $__env->make('user.includes.bottom_navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  </div>

  <script>
    lucide.createIcons();
  </script>
</body>

</html><?php /**PATH E:\xampp\htdocs\FeatureDesk\resources\views/user/my_plans.blade.php ENDPATH**/ ?>