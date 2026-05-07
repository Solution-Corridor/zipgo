<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes, viewport-fit=cover">
  <title>ZipGo – Your Service Hub</title>
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    /* Ensure no unexpected scroll on body */
    body {
      overflow: hidden;
      height: 100vh;
      margin: 0;
      padding: 0;
    }

    /* Mobile container exactly fits screen, no scroll */
    .mobile-container {
      height: 100vh;
      max-width: 420px;
      margin: 0 auto;
      display: flex;
      flex-direction: column;
      overflow-y: auto;
      /* allow scroll only if content exceeds, but we design to not exceed */
      background: linear-gradient(145deg, #f8f7f4 0%, #e8e6e2 100%);
    }

    /* Make cards compact but still elegant */
    .service-card {
      transition: all 0.2s ease;
    }

    .service-card:active {
      transform: scale(0.97);
    }

    /* Hide scrollbar for cleaner look (optional) */
    .mobile-container::-webkit-scrollbar {
      width: 0;
      background: transparent;
    }

    /* Ensure footer stays at bottom if content small, but we'll flex column */
  </style>
</head>

<body class="overflow-hidden">

  <div class="mobile-container">
    <!-- HEADER with ZipGo Logo -->
    <header class="px-4 pt-4 pb-2 bg-white/60 backdrop-blur-sm border-b border-[#EAE0D5] sticky top-0 z-10 flex items-center justify-between">
      <div class="flex items-center gap-2">
        <!-- Your logo image -->
        <img src="/assets/images/logo.png" alt="zipgo-logo" title="ZipGo Logo" class="h-8 w-auto">
        <!-- <span class="font-bold text-xl tracking-tight text-[#2C1810]">ZipGo</span> -->
      </div>
      <!-- <div class="text-xs bg-[#FFE66D]/40 px-2 py-1 rounded-full text-[#6B5B50]">24/7</div> -->
    </header>

    <!-- Main content: minimal padding so cards fit without scroll -->
    <main class="flex-1 px-4 py-4">
      <!-- Subtitle -->
      <div class="text-center mb-4">
        <p class="text-xs font-bold text-[gray] uppercase tracking-wide">One app, endless solutions</p>
        <h2 class="text-lg font-bold text-[#2C1810] mt-2">What do you need today?</h2>
      </div>

      <div class="grid grid-cols-2 gap-3">
        <!-- Card 1: Ride Booking -->
        <a href="/ride-booking" class="service-card block bg-white rounded-xl shadow-sm border border-[#EAE0D5] p-3 text-center hover:shadow-md transition">
          <div class="w-10 h-10 mx-auto bg-[#8B5CF6]/10 rounded-lg flex items-center justify-center mb-2">
            <i data-lucide="car" class="w-5 h-5 text-[#8B5CF6]"></i>
          </div>
          <h3 class="font-bold text-sm text-[#2C1810]">Easy Go</h3>
          <p class="text-[10px] text-[#6B5B50] mt-0.5 leading-tight">Cabs & autos</p>
        </a>

        <!-- Card 2: Delivery Services -->
        <a href="/delivery" class="service-card block bg-white rounded-xl shadow-sm border border-[#EAE0D5] p-3 text-center hover:shadow-md transition">
          <div class="w-10 h-10 mx-auto bg-[#4ECDC4]/10 rounded-lg flex items-center justify-center mb-2">
            <i data-lucide="truck" class="w-5 h-5 text-[#4ECDC4]"></i>
          </div>
          <h3 class="font-bold text-sm text-[#2C1810]">Buy Fast</h3>
          <p class="text-[10px] text-[#6B5B50] mt-0.5 leading-tight">Fast & reliable</p>
        </a>

        <!-- Card 3: Home Maintenance -->
        <a href="/home-maintenance" class="service-card block bg-white rounded-xl shadow-sm border border-[#EAE0D5] p-3 text-center hover:shadow-md transition">
          <div class="w-10 h-10 mx-auto bg-[#D4A373]/10 rounded-lg flex items-center justify-center mb-2">
            <i data-lucide="home" class="w-5 h-5 text-[#D4A373]"></i>
          </div>
          <h3 class="font-bold text-sm text-[#2C1810]">Quick Service</h3>
          <p class="text-[10px] text-[#6B5B50] mt-0.5 leading-tight">Plumbing & more</p>
        </a>

        <!-- Card 4: Website -->
        <a href="/home" class="service-card block bg-white rounded-xl shadow-sm border border-[#EAE0D5] p-3 text-center hover:shadow-md transition">
          <div class="w-10 h-10 mx-auto bg-[#FF6B6B]/10 rounded-lg flex items-center justify-center mb-2">
            <i data-lucide="globe" class="w-5 h-5 text-[#FF6B6B]"></i>
          </div>
          <h3 class="font-bold text-sm text-[#2C1810]">Browse ZipGo</h3>
          <p class="text-[10px] text-[#6B5B50] mt-0.5 leading-tight">Design & Dev</p>
        </a>
      </div>

      <!-- Optional small note (doesn't add height) -->
      <div class="text-center mt-4">
        <span class="inline-flex items-center gap-1 text-[10px] text-[#6B5B50] bg-white/40 px-3 py-1 rounded-full">
          <i data-lucide="check-circle" class="w-3 h-3 text-green-600"></i> Trusted by 10k+ users
        </span>
      </div>
    </main>

    <!-- Simple footer (minimal height) -->
    <footer class="bg-white/40 backdrop-blur-sm border-t border-[#EAE0D5] px-4 py-2 text-center text-[10px] text-[#6B5B50]">
      <p>© ZipGo — All services, one tap away</p>
    </footer>
  </div>

  <script>
    lucide.createIcons();
  </script>
</body>

</html>