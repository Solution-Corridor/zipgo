<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes, viewport-fit=cover">
  <title>ZipGo – Delivery Services</title>
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>
  <!-- Font Awesome 6 -->
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
      overflow: auto;
      height: 100%;
    }
    .mobile-container {
      max-width: 420px;
      margin: 0 auto;
      background: linear-gradient(145deg, #f8f7f4 0%, #e8e6e2 100%);
      min-height: 100vh;
      padding-top: 60px;    /* space for fixed navbar */
      display: flex;
      flex-direction: column;
    }
    .service-item {
      transition: all 0.2s ease;
    }
    .service-item:active {
      transform: scale(0.98);
    }
    .back-btn {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: rgba(255,255,255,0.7);
      border-radius: 30px;
      padding: 6px 12px;
      font-size: 13px;
      font-weight: 500;
      color: #2C1810;
      margin-bottom: 12px;
    }
    .card-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 8px;
    }
    .book-btn-small {
      background-color: #FF6B6B;
      color: white;
      font-size: 11px;
      font-weight: 600;
      padding: 4px 10px;
      border-radius: 20px;
      transition: 0.2s;
      text-decoration: none;
    }
    .book-btn-small:hover {
      background-color: #ff5252;
    }
  </style>
</head>
<body>

@include('website.includes.mobile_navbar')

<div class="mobile-container">
  <main class="flex-1 px-4 py-4">
    <a href="{{ url('/') }}" class="back-btn inline-flex items-center gap-1 mb-3">
      <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Home
    </a>

    <div class="text-center mb-5">
      <h1 class="text-xl font-bold text-[#2C1810]">Buy Fast – Delivery Services</h1>
      <p class="text-xs text-[#6B5B50] mt-1">Fast, reliable, and trackable deliveries</p>
    </div>

    <div class="grid grid-cols-2 gap-4">
      @forelse($deliveryServices as $service)
      <div class="service-item bg-white rounded-xl shadow-sm border border-[#EAE0D5] overflow-hidden hover:shadow-md transition">
        @if($service->pic)
        <img src="{{ asset($service->pic) }}" alt="{{ $service->name }}" class="w-full h-28 object-cover">
        @else
        <div class="w-full h-28 bg-gradient-to-br from-[#4ECDC4]/20 to-[#4ECDC4]/5 flex items-center justify-center">
          <i data-lucide="truck" class="w-8 h-8 text-[#4ECDC4]"></i>
        </div>
        @endif
        <div class="p-3">
          <div class="card-header">
            <h3 class="font-bold text-sm text-[#2C1810]">{{ $service->name }}</h3>
            <a href="" class="book-btn-small">Book</a>
          </div>
          <p class="text-[11px] text-[#6B5B50] mt-1 line-clamp-2">{{ Str::limit($service->detail ?? 'No description', 45) }}</p>
        </div>
      </div>
      @empty
      <div class="col-span-2 text-center py-10">
        <i data-lucide="alert-circle" class="w-12 h-12 text-gray-400 mx-auto mb-2"></i>
        <p class="text-[#6B5B50]">No delivery services available at the moment.</p>
      </div>
      @endforelse
    </div>

    <!-- Trust & features for delivery -->
    <div class="mt-6 text-center text-[10px] text-[#6B5B50] bg-white/30 rounded-full py-2 px-3 w-fit mx-auto">
      <i data-lucide="shield-check" class="w-3 h-3 inline mr-1"></i> Real‑time tracking | Insurance up to Rs 5,000 | 24/7 support
    </div>
  </main>

  <footer class="bg-white/40 backdrop-blur-sm border-t border-[#EAE0D5] px-4 py-2 text-center text-[10px] text-[#6B5B50]">
    <p>© ZipGo — Delivery made easy</p>
  </footer>
</div>

<script>
  lucide.createIcons();
</script>
</body>
</html>