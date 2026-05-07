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
  <!-- Font Awesome 6 (free icons) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background: #f5f5f5;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      overflow: hidden;
      height: 100vh;
    }

    /* Fixed Navbar styles are now inside the include, but we keep the rest */
    .mobile-container {
      height: 100vh;
      max-width: 420px;
      margin: 0 auto;
      background: linear-gradient(145deg, #f8f7f4 0%, #e8e6e2 100%);
      overflow-y: hidden;
      padding-top: 60px;    /* space for fixed navbar */
      display: flex;
      flex-direction: column;
    }

    .service-card {
      transition: all 0.2s ease;
    }
    .service-card:active {
      transform: scale(0.97);
    }

    .main-flex {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .why-zipgo {
      background: rgba(255,255,255,0.5);
      backdrop-filter: blur(4px);
      border-radius: 1rem;
      padding: 12px 16px;
      margin-top: 12px;
      border: 1px solid rgba(0,0,0,0.05);
    }
    .feature-item {
      font-size: 12px;
      display: flex;
      align-items: center;
      gap: 8px;
      color: #2C1810;
    }
    .feature-item i {
      width: 18px;
      color: #FF6B6B;
    }
  </style>
</head>
<body>

<!-- Include the reusable navbar (no inline navbar code) -->
@include('website.includes.mobile_navbar')

<!-- Main container – no scroll -->
<div class="mobile-container">
  <main class="main-flex px-4 py-4">
    <!-- Top part: title + cards -->
    <div>
      <div class="text-center mb-4">
        <p class="text-xs font-bold text-[gray] uppercase tracking-wide">One app, endless solutions</p>
        <h2 class="text-lg font-bold text-[#2C1810] mt-2">What do you need today?</h2>
      </div>

      <div class="grid grid-cols-2 gap-3">
        <a href="/ride-booking" class="service-card block bg-white rounded-xl shadow-sm border border-[#EAE0D5] p-3 text-center hover:shadow-md transition">
          <div class="w-10 h-10 mx-auto bg-[#8B5CF6]/10 rounded-lg flex items-center justify-center mb-2">
            <i data-lucide="car" class="w-5 h-5 text-[#8B5CF6]"></i>
          </div>
          <h3 class="font-bold text-sm text-[#2C1810]">Easy Go</h3>
          <p class="text-[10px] text-[#6B5B50] mt-0.5 leading-tight">Cabs & autos</p>
        </a>

        <a href="/delivery" class="service-card block bg-white rounded-xl shadow-sm border border-[#EAE0D5] p-3 text-center hover:shadow-md transition">
          <div class="w-10 h-10 mx-auto bg-[#4ECDC4]/10 rounded-lg flex items-center justify-center mb-2">
            <i data-lucide="truck" class="w-5 h-5 text-[#4ECDC4]"></i>
          </div>
          <h3 class="font-bold text-sm text-[#2C1810]">Buy Fast</h3>
          <p class="text-[10px] text-[#6B5B50] mt-0.5 leading-tight">Fast & reliable</p>
        </a>

        <a href="/home-maintenance" class="service-card block bg-white rounded-xl shadow-sm border border-[#EAE0D5] p-3 text-center hover:shadow-md transition">
          <div class="w-10 h-10 mx-auto bg-[#D4A373]/10 rounded-lg flex items-center justify-center mb-2">
            <i data-lucide="home" class="w-5 h-5 text-[#D4A373]"></i>
          </div>
          <h3 class="font-bold text-sm text-[#2C1810]">Quick Service</h3>
          <p class="text-[10px] text-[#6B5B50] mt-0.5 leading-tight">Plumbing & more</p>
        </a>

        <a href="/home" class="service-card block bg-white rounded-xl shadow-sm border border-[#EAE0D5] p-3 text-center hover:shadow-md transition">
          <div class="w-10 h-10 mx-auto bg-[#FF6B6B]/10 rounded-lg flex items-center justify-center mb-2">
            <i data-lucide="globe" class="w-5 h-5 text-[#FF6B6B]"></i>
          </div>
          <h3 class="font-bold text-sm text-[#2C1810]">Browse ZipGo</h3>
          <p class="text-[10px] text-[#6B5B50] mt-0.5 leading-tight">Design & Dev</p>
        </a>
      </div>
    </div>

    <!-- Why ZipGo section – fills remaining space -->
    <div class="why-zipgo mt-2">
      <h4 class="text-sm font-bold text-[#2C1810] mb-2 flex items-center gap-1">
        <i data-lucide="star" class="w-4 h-4 text-[#FF6B6B]"></i> Why Choose ZipGo?
      </h4>
      <div class="space-y-2">
        <div class="feature-item">
          <i data-lucide="clock" class="w-4 h-4"></i>
          <span>Instant booking – ride in minutes</span>
        </div>
        <div class="feature-item">
          <i data-lucide="shield-check" class="w-4 h-4"></i>
          <span>100% verified drivers | 24/7 support</span>
        </div>
        <div class="feature-item">
          <i data-lucide="wallet" class="w-4 h-4"></i>
          <span>Best price guarantee & cashless payment</span>
        </div>
      </div>
      <div class="text-[10px] text-center text-[#6B5B50] mt-2 pt-1 border-t border-[#EAE0D5]">
        ⚡ Over 50,000+ happy rides completed
      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-white/40 backdrop-blur-sm border-t border-[#EAE0D5] px-4 py-2 text-center text-[10px] text-[#6B5B50]">
    <p>© ZipGo — All services, one tap away</p>
  </footer>
</div>

<script>
  lucide.createIcons();
  // Hamburger toggle script is already inside the include
</script>
</body>
</html>