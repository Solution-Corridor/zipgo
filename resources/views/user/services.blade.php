<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  @include('user.includes.general_style')
  <title>All Professionals | ZipGo</title>
  <style>
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

  <div class="mx-auto max-w-[420px] min-h-screen bg-[#e6e5e3] shadow-2xl shadow-black/10 relative">

    <!-- Top Greeting -->
    @include('user.includes.top_greetings')

    <!-- Balance Bar (same as dashboard) -->
    <div class="mx-auto max-w-[420px] px-4 mt-2">
      <div class="bg-gradient-to-r from-emerald-600 to-teal-600 rounded-2xl p-4 shadow-lg flex justify-between items-center">
        <div>
          <p class="text-white/80 text-xs uppercase tracking-wide">Your Balance</p>
          <p class="text-white text-2xl font-bold">Rs. {{ number_format(auth()->user()->balance ?? 0, 2) }}</p>
        </div>
        <a href="{{ route('user.recharge') }}"
          class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white font-semibold py-2 px-5 rounded-xl transition-all flex items-center gap-2">
          <i data-lucide="plus-circle" class="w-4 h-4"></i> Recharge
        </a>
      </div>
    </div>

    <!-- Header -->
    <div class="px-4 mt-3 mb-2 flex justify-between items-center">
      <h2 class="text-md font-bold text-[#2C1810]">All Professionals</h2>
      <a href="{{ route('user.dashboard') }}" class="text-xs text-[#FF6B6B] hover:text-[#ff5252]">← Back</a>
    </div>

    <!-- Professionals List -->
    <div class="px-4 mb-20">
      <div class="space-y-3">
        @forelse($experts as $pro)
        <a href="{{ route('user.expert_detail', $pro->id) }}" class="block">
          <div class="bg-white border border-[#EAE0D5] rounded-xl p-3 flex items-center gap-3 shadow-sm hover:shadow-md transition">
            @if($pro->selfie_image)
              <img src="{{ $pro->selfie_image }}" alt="{{ $pro->name }}" class="w-12 h-12 rounded-full object-cover">
            @else
              <div class="w-12 h-12 rounded-full bg-{{ $pro->avatar_color }}-100 flex items-center justify-center text-{{ $pro->avatar_color }}-600 font-bold">
                {{ $pro->avatar }}
              </div>
            @endif

            <div class="flex-1">
              <p class="font-semibold text-[#2C1810] text-sm">{{ $pro->name }}</p>
              <div class="flex items-center gap-3 mt-0.5">
                <span class="text-xs text-[#6B5B50]"><i data-lucide="star" class="w-3 h-3 inline text-[#FFE66D] fill-[#FFE66D]"></i> {{ $pro->rating }}</span>
                <span class="text-xs text-[#6B5B50]"><i data-lucide="map-pin" class="w-3 h-3 inline"></i> {{ $pro->distance }}</span>
              </div>
              <p class="text-xs text-[#6B5B50] mt-1">Starting from Rs. {{ $pro->price }}</p>
            </div>

            <div class="text-xs font-medium text-[#FF6B6B] bg-[#FF6B6B]/10 px-2 py-1 rounded-lg" style="word-break: break-word; white-space: normal; max-width: 110px; text-align: center;">
              {{ $pro->profession }}
            </div>
          </div>
        </a>
        @empty
        <div class="text-center py-10 text-gray-500">No professionals found.</div>
        @endforelse
      </div>

      <!-- Pagination -->
      <div class="mt-6">
        {{ $experts->links() }}
      </div>
    </div>

    @include('user.includes.bottom_navigation')
  </div>

  <script src="https://unpkg.com/lucide@latest"></script>
  <script>
    lucide.createIcons();
  </script>
</body>
</html>