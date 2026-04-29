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

<body class="min-h-screen bg-[#0A0A0F]">

  <div class="mx-auto max-w-[420px] min-h-screen bg-[#0A0A0F] shadow-2xl shadow-black/50 relative">

    @include('user.includes.top_greetings')

    <div class="px-4 mt-2 mb-4">
      <h1 class="text-xl font-bold text-white">Explore Services</h1>
      <p class="text-xs text-gray-400 mt-1">Find the right professional for your needs</p>
    </div>

    <div class="px-4 space-y-6">
      @foreach($exploreCategories as $cat)
      <div>
        <div class="flex items-center gap-2 mb-2">
          <i data-lucide="{{ $cat->icon }}" class="w-5 h-5 text-emerald-400"></i>
          <h2 class="text-base font-semibold text-white">{{ $cat->name }}</h2>
        </div>
        <div class="grid grid-cols-2 gap-2">
          @foreach($cat->services as $service)
          <a href="{{ route('user.search.results') }}?query={{ urlencode($service) }}"
            class="bg-gray-900/60 border border-gray-800 rounded-lg px-3 py-2 text-sm text-gray-300 hover:border-emerald-500/50 transition">
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