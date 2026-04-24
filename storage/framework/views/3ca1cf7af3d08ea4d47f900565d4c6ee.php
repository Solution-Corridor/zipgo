<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  <?php echo $__env->make('user.includes.general_style', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  <title>Page Not Found</title>
</head>

<body class="min-h-screen bg-[#0A0A0F]">

  <!-- Mobile-like container -->
  <div class="mx-auto max-w-[420px] min-h-screen bg-[#0A0A0F] shadow-2xl shadow-black/50 relative">

    <!-- Top Greeting + Add / Ref -->
    

    <!-- Main Content -->
    <div class="px-5 pt-6 pb-28 flex flex-col items-center justify-center min-h-[60vh] text-center">

      <!-- Icon / Illustration area -->
      <div class="w-24 h-24 rounded-full bg-gradient-to-br from-gray-800 to-gray-900 flex items-center justify-center mb-6 border border-gray-700/50 shadow-lg">
        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
        </svg>
      </div>

      <!-- Main Message -->
      <h2 class="text-2xl font-bold text-white mb-3">
        404 Page Not Found
      </h2>

      <p class="text-gray-400 text-base leading-relaxed mb-8 max-w-[300px]">
        Sorry, the page you are looking for does not exist.
      </p>

      <!-- Call to Action Button -->
      <a href="<?php echo e(route('welcome')); ?>" 
         class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-semibold rounded-2xl shadow-lg shadow-indigo-900/30 transition-all duration-300 transform hover:scale-105 active:scale-95">
        <span>Go Back</span>
        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
        </svg>
      </a>

      
    </div>

    <!-- Bottom Navigation -->
    

  </div> <!-- end mobile container -->

  <script>
    lucide.createIcons();
  </script>

</body>
</html><?php /**PATH E:\xampp\htdocs\FeatureDesk\resources\views/errors/404.blade.php ENDPATH**/ ?>