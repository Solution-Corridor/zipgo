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

<body class="min-h-screen bg-[#0A0A0F]">

  <!-- Mobile-like container -->
  <div class="mx-auto max-w-[420px] min-h-screen bg-[#0A0A0F] shadow-2xl shadow-black/50 relative">

    <!-- Top Greeting -->
    @include('user.includes.top_greetings')

    <!-- Search Bar -->
    <div class="px-4 mt-3 mb-4">
      <form action="{{ route('user.search.results') }}" method="GET" class="relative">
        <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
        <input type="text" name="query" placeholder="Search for plumber, electrician, AC repair..."
          class="w-full bg-gray-900/80 border border-gray-700 rounded-xl py-3 pl-10 pr-4 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-emerald-500/50 transition">
        <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 bg-emerald-600 px-3 py-1 rounded-lg text-xs font-medium">Go</button>
      </form>
    </div>

    <!-- Quick Categories (Horizontal Scroll) -->
    <div class="px-4 mb-5">
      <h3 class="text-sm font-semibold text-gray-200 mb-2">Browse by Service</h3>
      <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
        @foreach($categories as $cat)
        <a href="{{ route('user.search.results') }}?category={{ urlencode($cat->name) }}" class="flex flex-col items-center min-w-[70px]">
          <div class="w-14 h-14 rounded-2xl bg-gray-800/80 border border-gray-700 flex items-center justify-center mb-1 hover:border-emerald-500/50 transition group">
            <i data-lucide="{{ $cat->icon }}" class="w-6 h-6 text-{{ $cat->color }}-400"></i>
          </div>
          <span class="text-[11px] text-gray-400">{{ $cat->name }}</span>
        </a>
        @endforeach
      </div>
    </div>

    <!-- Nearby Professionals / Top Rated -->
    <div class="px-4 mb-5">
      <div class="flex justify-between items-center mb-2">
        <h3 class="text-sm font-semibold text-gray-200">Nearby Professionals</h3>
        <a href="{{ route('user.search') }}" class="text-xs text-emerald-400">View all</a>
      </div>
      <div class="space-y-3">
        @foreach($nearbyProfessionals as $pro)
        <div class="bg-gray-900/60 border border-gray-800 rounded-xl p-3 flex items-center gap-3">
          <div class="w-12 h-12 rounded-full bg-{{ $pro->avatar_color }}-600/30 flex items-center justify-center text-{{ $pro->avatar_color }}-400 font-bold">
            {{ $pro->avatar }}
          </div>
          <div class="flex-1">
            <div class="flex items-center gap-2">
              <p class="font-semibold text-white text-sm">{{ $pro->name }}</p>
              <span class="text-[10px] bg-emerald-600/20 text-emerald-400 px-1.5 py-0.5 rounded-full">{{ $pro->profession }}</span>
            </div>
            <div class="flex items-center gap-3 mt-0.5">
              <span class="text-xs text-gray-400"><i data-lucide="star" class="w-3 h-3 inline text-yellow-500"></i> {{ $pro->rating }}</span>
              <span class="text-xs text-gray-400"><i data-lucide="map-pin" class="w-3 h-3 inline"></i> {{ $pro->distance }}</span>
            </div>
            <p class="text-xs text-gray-500 mt-1">Starting from Rs. {{ $pro->price }}</p>
          </div>
          <a href="#" class="bg-emerald-600/20 hover:bg-emerald-600/30 px-3 py-1.5 rounded-lg text-xs font-medium text-emerald-400 transition" onclick="alert('Book {{ $pro->name }}'); return false;">Book</a>
        </div>
        @endforeach
      </div>
    </div>

    <!-- Service Packages / Offers -->
    <div class="px-4 mb-5">
      <div class="flex justify-between items-center mb-2">
        <h3 class="text-sm font-semibold text-gray-200">Popular Service Packages</h3>
        <a href="#" class="text-xs text-emerald-400" onclick="alert('All packages'); return false;">View all</a>
      </div>
      <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
        @foreach($packages as $pkg)
        <div class="min-w-[200px] bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl p-3 border border-gray-700">
          <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-bold bg-emerald-600/30 text-emerald-400 px-2 py-0.5 rounded-full">{{ $pkg->discount }}</span>
            <i data-lucide="{{ $pkg->icon }}" class="w-4 h-4 text-emerald-400"></i>
          </div>
          <p class="font-semibold text-white text-sm">{{ $pkg->title }}</p>
          <p class="text-xs text-gray-400 mt-1">{{ $pkg->description }}</p>
          <div class="mt-2 flex items-center justify-between">
            <span class="text-base font-bold text-emerald-400">Rs. {{ $pkg->price }}</span>
            <a href="#" class="text-xs bg-emerald-600 px-2.5 py-1 rounded-lg" onclick="alert('Book {{ $pkg->title }}'); return false;">Book</a>
          </div>
        </div>
        @endforeach
      </div>
    </div>

    <!-- How It Works Section -->
    <div class="px-4 mb-5">
      <h3 class="text-sm font-semibold text-gray-200 mb-2">How It Works</h3>
      <div class="grid grid-cols-3 gap-2 text-center">
        <div class="bg-gray-900/40 rounded-xl p-2 border border-gray-800">
          <i data-lucide="search" class="w-5 h-5 text-emerald-400 mx-auto mb-1"></i>
          <p class="text-[10px] text-gray-400">1. Search</p>
        </div>
        <div class="bg-gray-900/40 rounded-xl p-2 border border-gray-800">
          <i data-lucide="calendar" class="w-5 h-5 text-emerald-400 mx-auto mb-1"></i>
          <p class="text-[10px] text-gray-400">2. Book</p>
        </div>
        <div class="bg-gray-900/40 rounded-xl p-2 border border-gray-800">
          <i data-lucide="check-circle" class="w-5 h-5 text-emerald-400 mx-auto mb-1"></i>
          <p class="text-[10px] text-gray-400">3. Relax</p>
        </div>
      </div>
    </div>

    <!-- Support / Quick Help -->
    <div class="mx-4 mb-20">
      <div class="bg-gradient-to-r from-gray-800/50 to-gray-900/50 rounded-xl p-3 flex items-center justify-between border border-gray-700">
        <div class="flex items-center gap-2">
          <i data-lucide="phone-call" class="w-5 h-5 text-emerald-400"></i>
          <span class="text-sm text-gray-200">24/7 Support</span>
        </div>
        <a href="tel:+919876543210" class="text-xs bg-emerald-600/20 px-3 py-1 rounded-full text-emerald-400">Call Now</a>
      </div>
    </div>

    @include('user.includes.bottom_navigation')


  </div> <!-- end mobile container -->


</body>

</html>