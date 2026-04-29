<!DOCTYPE html>
<html lang="en">
<head>
  @include('user.includes.general_style')
  <title>Search Results for "{{ $query }}"</title>
</head>
<body class="min-h-screen bg-[#0A0A0F]">

<div class="mx-auto max-w-[420px] min-h-screen bg-[#0A0A0F] relative">

  @include('user.includes.top_greetings')

  <div class="px-4 mt-4 mb-2">
    <a href="{{ route('user.search') }}" class="text-emerald-400 text-sm flex items-center gap-1">
      <i data-lucide="arrow-left" class="w-4 h-4"></i> Back
    </a>
    <h1 class="text-lg font-bold text-white mt-2">Results for "{{ $query }}"</h1>
    <p class="text-xs text-gray-400">{{ count($results) }} professionals found</p>
  </div>

  <div class="px-4 space-y-3 mb-20">
    @forelse($results as $pro)
    <div class="bg-gray-900/60 border border-gray-800 rounded-xl p-3 flex items-center gap-3">
      <div class="w-12 h-12 rounded-full bg-emerald-600/30 flex items-center justify-center text-emerald-400 font-bold">
        {{ substr($pro->name, 0, 1) }}
      </div>
      <div class="flex-1">
        <p class="font-semibold text-white text-sm">{{ $pro->name }}</p>
        <p class="text-xs text-gray-400">{{ $pro->expertise }}</p>
        <div class="flex items-center gap-3 mt-1">
          <span class="text-xs text-gray-400"><i data-lucide="star" class="w-3 h-3 inline text-yellow-500"></i> {{ $pro->rating }}</span>
          <span class="text-xs text-gray-400"><i data-lucide="map-pin" class="w-3 h-3 inline"></i> {{ $pro->distance }}</span>
        </div>
        <p class="text-xs text-emerald-400 mt-1">Rs. {{ $pro->price }} onwards</p>
      </div>
      <a href="#" class="bg-emerald-600/20 hover:bg-emerald-600/30 px-3 py-1.5 rounded-lg text-xs font-medium text-emerald-400" onclick="alert('Book {{ $pro->name }}'); return false;">Book</a>
    </div>
    @empty
    <div class="text-center py-10">
      <i data-lucide="search-x" class="w-12 h-12 text-gray-600 mx-auto mb-2"></i>
      <p class="text-gray-400">No professionals found. Try a different search.</p>
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