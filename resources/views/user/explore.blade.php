<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  @include('user.includes.general_style')
  <title>Explore Services – Home Services</title>
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

<body class="min-h-screen bg-[#FDFBF7]">

  <div class="mx-auto max-w-[420px] min-h-screen bg-[#FDFBF7] shadow-2xl shadow-black/5 relative">

    @include('user.includes.top_greetings')

    <div class="px-4 mt-2 mb-4">
      <h1 class="text-xl font-bold text-[#2C1810]">Explore Services</h1>
      <p class="text-xs text-[#6B5B50] mt-1">Find the right professional for your needs</p>
    </div>

    <div class="px-4 space-y-6">
      @foreach($exploreCategories as $cat)
      <div>
        <div class="flex items-center gap-2 mb-2">
          <i data-lucide="{{ $cat->icon }}" class="w-5 h-5 text-[#4ECDC4]"></i>
          <h2 class="text-base font-semibold text-[#2C1810]">{{ $cat->name }}</h2>
        </div>
        <div class="grid grid-cols-2 gap-2">
          @foreach($cat->services as $service)
          <a href="{{ route('user.search.results') }}?query={{ urlencode($service) }}"
            class="bg-white border border-[#EAE0D5] rounded-lg px-3 py-2 text-sm text-[#2C1810] hover:border-[#FF6B6B]/50 transition shadow-sm">
            {{ $service }}
          </a>
          @endforeach
        </div>
      </div>
      @endforeach
    </div>

    @include('user.includes.bottom_navigation')

  </div>

</body>
</html>