<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  @include('user.includes.general_style')
  <title>{{ $displayName }} | ZipGo</title>
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

    <!-- Balance Bar (optional, but keeps consistency) -->
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

    <!-- Back button -->
    <div class="px-4 mt-3 mb-2">
      <a href="{{ url()->previous() }}" class="inline-flex items-center text-xs text-[#FF6B6B] hover:text-[#ff5252] transition">
        <i data-lucide="arrow-left" class="w-3 h-3 mr-1"></i> Back
      </a>
    </div>

    <!-- Expert Profile Card -->
    <div class="px-4 mb-20">
      <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        {{-- Header with selfie --}}
        <div class="bg-gradient-to-r from-[#FF6B6B]/20 to-[#FF6B6B]/5 p-5 text-center">
          @if($selfieImage)
          <img src="{{ $selfieImage }}" alt="{{ $displayName }}" class="w-24 h-24 rounded-full mx-auto object-cover border-4 border-white shadow">
          @else
          <div class="w-24 h-24 rounded-full bg-gray-200 mx-auto flex items-center justify-center text-3xl font-bold text-gray-500">
            {{ strtoupper(substr($displayName, 0, 1)) }}
          </div>
          @endif
          <h1 class="text-xl font-bold text-[#2C1810] mt-3">{{ $displayName }}</h1>
          <p class="text-[#FF6B6B] text-sm">{{ $service ? $service->name : 'Professional' }}</p>
        </div>

        {{-- Basic Info --}}
        <div class="p-5 space-y-4 border-b border-[#EAE0D5]">
          <div class="flex justify-between">
            <span class="text-[#6B5B50] flex items-center gap-1"><i data-lucide="star" class="w-4 h-4"></i> {{ $rating }} / 5</span>
          </div>
          <div class="flex justify-between">
            <span class="text-[#6B5B50] flex items-center gap-1"><i data-lucide="map-pin" class="w-4 h-4"></i> {{ $cityName }}</span>
          </div>
          <div class="flex justify-between">
            <span class="text-[#6B5B50] flex items-center gap-1"><i data-lucide="credit-card" class="w-4 h-4"></i> Rs. {{ $price }}</span>
          </div>
        </div>

        {{-- Service Rates / Menu --}}
        @if($rates->count())
        <div class="p-5 border-b border-[#EAE0D5]">
          <h3 class="font-semibold text-[#2C1810] mb-3 flex items-center gap-1">
            <i data-lucide="utensils-crossed" class="w-4 h-4"></i> Menu & Rates
          </h3>
          <div class="space-y-3">
            @foreach($rates as $rate)
            <div class="flex items-start gap-3 border-b border-gray-100 pb-3 last:border-0">
              @if($rate->image)
              <img src="{{ asset('uploads/expert-rates/' . $rate->image) }}" alt="{{ $rate->service_name }}" class="w-12 h-12 rounded-lg object-cover">
              @else
              <div class="w-12 h-12 rounded-lg bg-[#FF6B6B]/10 flex items-center justify-center">
                <i data-lucide="coffee" class="w-6 h-6 text-[#FF6B6B]"></i>
              </div>
              @endif
              <div class="flex-1">
                <div class="flex justify-between items-baseline">
                  <h4 class="font-medium text-[#2C1810]">{{ $rate->service_name }}</h4>
                  <span class="text-[#FF6B6B] font-bold">Rs. {{ number_format($rate->rate, 2) }}</span>
                </div>
                @if($rate->description)
                <p class="text-xs text-[#6B5B50] mt-1">{{ $rate->description }}</p>
                @endif
              </div>
            </div>
            @endforeach
          </div>
        </div>
        @else
        <div class="p-5 border-b border-[#EAE0D5] text-center text-[#6B5B50]">
          <i data-lucide="receipt" class="w-8 h-8 mx-auto mb-2 opacity-40"></i>
          <p class="text-sm">No rate information available.</p>
        </div>
        @endif

        {{-- Action Button --}}
        <div class="p-5">
          <a href="#" class="block w-full bg-[#FF6B6B] text-white text-center py-2.5 rounded-lg font-medium hover:bg-[#ff5252] transition">
            Book Now
          </a>
        </div>
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