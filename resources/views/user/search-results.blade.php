<!DOCTYPE html>
<html lang="en">
<head>
  @include('user.includes.general_style')
  <title>Service Providers - {{ $service->name }}</title>
</head>
<body class="min-h-screen bg-[#e6e5e3]">

  <div class="mx-auto max-w-[420px] min-h-screen bg-[#e6e5e3] relative">

    @include('user.includes.top_greetings')

    <div class="px-4 mt-4 mb-3">
      <a href="{{ route('user.explore') }}" 
         class="text-[#FF6B6B] text-sm flex items-center gap-1 hover:text-[#ff5252]">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Services
      </a>
      
      <h1 class="text-xl font-bold text-[#2C1810] mt-3">{{ $service->name }}</h1>
      <p class="text-xs text-[#6B5B50]">{{ count($experts) }} professionals available</p>
    </div>

    <div class="px-4 space-y-3 mb-20">
      @forelse($experts as $pro)
        <div class="bg-white border border-[#EAE0D5] rounded-xl p-4 flex items-center gap-3 shadow-sm hover:shadow-md transition">
          
          <div class="w-12 h-12 rounded-full bg-[#FF6B6B]/10 flex items-center justify-center text-[#FF6B6B] font-bold text-xl overflow-hidden">
            <img src="{{ $pro->	selfie_image }}" alt="{{ $pro->full_name }}" class="w-full h-full object-cover">
          </div>

          <div class="flex-1 min-w-0">
            <p class="font-semibold text-[#2C1810]">{{ $pro->full_name }}</p>
            <p class="text-xs text-[#6B5B50]">{{ $pro->expertise ?? $service->name }} Expert</p>
            
            <div class="flex items-center gap-3 mt-1">
              <span class="text-xs text-[#6B5B50]">
                <i data-lucide="star" class="w-3 h-3 inline text-[#FFE66D] fill-[#FFE66D]"></i> 
                {{ $pro->rating ?? '4.8' }}
              </span>
              <span class="text-xs text-[#6B5B50]">
                <i data-lucide="map-pin" class="w-3 h-3 inline"></i> 
                {{ $pro->distance ?? '2.4 km' }}
              </span>
            </div>

            <p class="text-xs text-[#FF6B6B] mt-1 font-medium">
              Rs. {{ number_format($pro->price ?? $service->price, 0) }} onwards
            </p>
          </div>

          <a href="#" 
             class="bg-[#FF6B6B] hover:bg-[#ff5252] text-white px-5 py-2 rounded-xl text-sm font-medium transition">
            Profile
          </a>
        </div>
      @empty
        <div class="text-center py-12">
          <i data-lucide="search-x" class="w-16 h-16 text-gray-300 mx-auto mb-3"></i>
          <p class="text-[#6B5B50]">No professionals found for this service yet.</p>
        </div>
      @endforelse
    </div>

    @include('user.includes.bottom_navigation')
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      if (typeof lucide !== 'undefined') lucide.createIcons();
    });
  </script>
</body>
</html>