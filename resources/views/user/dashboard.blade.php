<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  @include('user.includes.general_style')
  <title>Home Services – Find Plumber, Electrician & More</title>
  <style>
    /* Hide scrollbar for category slider but keep functionality */
    .scrollbar-hide::-webkit-scrollbar {
      display: none;
    }

    .scrollbar-hide {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }
  </style>
</head>

<body class="min-h-screen bg-[#e6e5e3]">

  <!-- Mobile-like container -->
  <div class="mx-auto max-w-[420px] min-h-screen bg-[#e6e5e3] shadow-2xl shadow-black/10 relative">

    <!-- Top Greeting -->
    @include('user.includes.top_greetings')

    <!-- Search Bar -->
    <div class="px-4 mt-3 mb-4">
      <form action="{{ route('user.search.results') }}" method="GET" class="relative">
        <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#6B5B50]"></i>
        <input type="text" name="query" placeholder="Search for plumber, electrician, AC repair..."
          class="w-full bg-white border border-[#EAE0D5] rounded-xl py-3 pl-10 pr-4 text-sm text-[#2C1810] placeholder-[#6B5B50] focus:outline-none focus:border-[#FF6B6B]/70 transition">
        <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 bg-[#FF6B6B] hover:bg-[#ff5252] px-3 py-1 rounded-lg text-xs font-medium text-white">Go</button>
      </form>
    </div>

    <!-- Quick Categories (Horizontal Scroll) -->
    <div class="px-4 mb-5">
      <h3 class="text-sm font-semibold text-[#2C1810] mb-2">Browse by Service</h3>
      <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
        @foreach($categories as $cat)
        <a href="{{ route('user.search.results') }}?category={{ urlencode($cat->name) }}" class="flex flex-col items-center min-w-[70px]">
          <div class="w-14 h-14 rounded-2xl bg-white/80 border border-[#EAE0D5] flex items-center justify-center mb-1 hover:border-[#FF6B6B]/50 transition group shadow-sm">
            <i data-lucide="{{ $cat->icon }}" class="w-6 h-6 text-[#4ECDC4]"></i>
          </div>
          <span class="text-[11px] text-[#6B5B50]">{{ $cat->name }}</span>
        </a>
        @endforeach
      </div>
    </div>

    <!-- Nearby Professionals / Top Rated -->
    <div class="px-4 mb-5">
      <div class="flex justify-between items-center mb-2">
        <h3 class="text-sm font-semibold text-[#2C1810]">Nearby Professionals</h3>
        <a href="{{ route('user.search') }}" class="text-xs text-[#FF6B6B] hover:text-[#ff5252]">View all</a>
      </div>
      <div class="space-y-3">
        @foreach($nearbyProfessionals as $pro)
        <div class="bg-white border border-[#EAE0D5] rounded-xl p-3 flex items-center gap-3 shadow-sm hover:shadow-md transition">
          <div class="w-12 h-12 rounded-full bg-{{ $pro->avatar_color }}-100 flex items-center justify-center text-{{ $pro->avatar_color }}-600 font-bold">
            {{ $pro->avatar }}
          </div>
          <div class="flex-1">
            <div class="flex items-center gap-2">
              <p class="font-semibold text-[#2C1810] text-sm">{{ $pro->name }}</p>
              <span class="text-[10px] bg-[#FF6B6B]/10 text-[#FF6B6B] px-1.5 py-0.5 rounded-full">{{ $pro->profession }}</span>
            </div>
            <div class="flex items-center gap-3 mt-0.5">
              <span class="text-xs text-[#6B5B50]"><i data-lucide="star" class="w-3 h-3 inline text-[#FFE66D] fill-[#FFE66D]"></i> {{ $pro->rating }}</span>
              <span class="text-xs text-[#6B5B50]"><i data-lucide="map-pin" class="w-3 h-3 inline"></i> {{ $pro->distance }}</span>
            </div>
            <p class="text-xs text-[#6B5B50] mt-1">Starting from Rs. {{ $pro->price }}</p>
          </div>
          <a href="#" class="bg-[#FF6B6B]/10 hover:bg-[#FF6B6B]/20 px-3 py-1.5 rounded-lg text-xs font-medium text-[#FF6B6B] transition">Book</a>
        </div>
        @endforeach
      </div>
    </div>

    <!-- Service Packages / Offers -->
    <div class="px-4 mb-5">
      <div class="flex justify-between items-center mb-2">
        <h3 class="text-sm font-semibold text-[#2C1810]">Popular Service Packages</h3>
        <a href="#" class="text-xs text-[#FF6B6B] hover:text-[#ff5252]" onclick="alert('All packages'); return false;">View all</a>
      </div>
      <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
        @foreach($packages as $pkg)
        <div class="min-w-[200px] bg-gradient-to-br from-white to-[#FFF9F5] rounded-xl p-3 border border-[#EAE0D5] shadow-sm">
          <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-bold bg-[#FFE66D]/30 text-[#2C1810] px-2 py-0.5 rounded-full">{{ $pkg->discount }}</span>
            <i data-lucide="{{ $pkg->icon }}" class="w-4 h-4 text-[#FF6B6B]"></i>
          </div>
          <p class="font-semibold text-[#2C1810] text-sm">{{ $pkg->title }}</p>
          <p class="text-xs text-[#6B5B50] mt-1">{{ $pkg->description }}</p>
          <div class="mt-2 flex items-center justify-between">
            <span class="text-base font-bold text-[#FF6B6B]">Rs. {{ $pkg->price }}</span>
            <a href="#" class="text-xs bg-[#FF6B6B] hover:bg-[#ff5252] px-2.5 py-1 rounded-lg text-white">Book</a>
          </div>
        </div>
        @endforeach
      </div>
    </div>

    <!-- How It Works Section -->
    <div class="px-4 mb-5">
      <h3 class="text-sm font-semibold text-[#2C1810] mb-2">How It Works</h3>
      <div class="grid grid-cols-3 gap-2 text-center">
        <div class="bg-white rounded-xl p-2 border border-[#EAE0D5] shadow-sm">
          <i data-lucide="search" class="w-5 h-5 text-[#4ECDC4] mx-auto mb-1"></i>
          <p class="text-[10px] text-[#6B5B50]">1. Search</p>
        </div>
        <div class="bg-white rounded-xl p-2 border border-[#EAE0D5] shadow-sm">
          <i data-lucide="calendar" class="w-5 h-5 text-[#4ECDC4] mx-auto mb-1"></i>
          <p class="text-[10px] text-[#6B5B50]">2. Book</p>
        </div>
        <div class="bg-white rounded-xl p-2 border border-[#EAE0D5] shadow-sm">
          <i data-lucide="check-circle" class="w-5 h-5 text-[#4ECDC4] mx-auto mb-1"></i>
          <p class="text-[10px] text-[#6B5B50]">3. Relax</p>
        </div>
      </div>
    </div>

    <!-- Support / Quick Help -->
    <div class="mx-4 mb-20">
      <div class="bg-gradient-to-r from-white to-[#FFF9F5] rounded-xl p-3 flex items-center justify-between border border-[#EAE0D5] shadow-sm">
        <div class="flex items-center gap-2">
          <i data-lucide="phone-call" class="w-5 h-5 text-[#4ECDC4]"></i>
          <span class="text-sm text-[#2C1810]">24/7 Support</span>
        </div>
        <a href="tel:+919876543210" class="text-xs bg-[#FF6B6B]/10 hover:bg-[#FF6B6B]/20 px-3 py-1 rounded-full text-[#FF6B6B]">Call Now</a>
      </div>
    </div>

    @include('user.includes.bottom_navigation')

  </div> <!-- end mobile container -->

</body>
</html>