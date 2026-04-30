<!DOCTYPE html>
<html lang="en">
<head>
  @include('user.includes.general_style')
  <title>Search Results for "{{ $query }}"</title>
</head>
<body class="min-h-screen bg-[#FDFBF7]">

<div class="mx-auto max-w-[420px] min-h-screen bg-[#FDFBF7] relative">

  @include('user.includes.top_greetings')

  <div class="px-4 mt-4 mb-2">
    <a href="{{ route('user.search') }}" class="text-[#FF6B6B] text-sm flex items-center gap-1 hover:text-[#ff5252]">
      <i data-lucide="arrow-left" class="w-4 h-4"></i> Back
    </a>
    <h1 class="text-lg font-bold text-[#2C1810] mt-2">Results for "{{ $query }}"</h1>
    <p class="text-xs text-[#6B5B50]">{{ count($results) }} professionals found</p>
  </div>

  <div class="px-4 space-y-3 mb-20">
    @forelse($results as $pro)
    <div class="bg-white border border-[#EAE0D5] rounded-xl p-3 flex items-center gap-3 shadow-sm hover:shadow-md transition">
      <div class="w-12 h-12 rounded-full bg-[#FF6B6B]/10 flex items-center justify-center text-[#FF6B6B] font-bold">
        {{ substr($pro->name, 0, 1) }}
      </div>
      <div class="flex-1">
        <p class="font-semibold text-[#2C1810] text-sm">{{ $pro->name }}</p>
        <p class="text-xs text-[#6B5B50]">{{ $pro->expertise }}</p>
        <div class="flex items-center gap-3 mt-1">
          <span class="text-xs text-[#6B5B50]"><i data-lucide="star" class="w-3 h-3 inline text-[#FFE66D] fill-[#FFE66D]"></i> {{ $pro->rating }}</span>
          <span class="text-xs text-[#6B5B50]"><i data-lucide="map-pin" class="w-3 h-3 inline"></i> {{ $pro->distance }}</span>
        </div>
        <p class="text-xs text-[#FF6B6B] mt-1">Rs. {{ $pro->price }} onwards</p>
      </div>
      <a href="#" class="bg-[#FF6B6B]/10 hover:bg-[#FF6B6B]/20 px-3 py-1.5 rounded-lg text-xs font-medium text-[#FF6B6B] transition" onclick="alert('Book {{ $pro->name }}'); return false;">Book</a>
    </div>
    @empty
    <div class="text-center py-10">
      <i data-lucide="search-x" class="w-12 h-12 text-[#6B5B50] mx-auto mb-2"></i>
      <p class="text-[#6B5B50]">No professionals found. Try a different search.</p>
    </div>
    @endforelse
  </div>

  @include('user.includes.bottom_navigation')
</div>
<script>
  document.addEventListener('DOMContentLoaded', () => { if (typeof lucide !== 'undefined') lucide.createIcons(); });
</script>
</body>
</html>