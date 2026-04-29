<!DOCTYPE html>
<html lang="en">

<head>
  @include('user.includes.general_style')
  <title>Find Services – Home Services</title>
</head>

<body class="min-h-screen bg-[#0A0A0F]">

  <div class="mx-auto max-w-[420px] min-h-screen bg-[#0A0A0F] relative">

    @include('user.includes.top_greetings')

    <div class="px-4 mt-4 mb-4">
      <h1 class="text-xl font-bold text-white">Find a Professional</h1>
      <form action="{{ route('user.search.results') }}" method="GET" class="mt-3">
        <div class="relative">
          <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
          <input type="text" name="query" placeholder="e.g., plumber, AC repair..." class="w-full bg-gray-900/80 border border-gray-700 rounded-xl py-3 pl-10 pr-4 text-sm text-white focus:outline-none focus:border-emerald-500/50">
          <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 bg-emerald-600 px-3 py-1 rounded-lg text-xs">Search</button>
        </div>
      </form>
    </div>

    <div class="px-4 mb-5">
      <h3 class="text-sm font-semibold text-gray-200 mb-2">Popular Searches</h3>
      <div class="flex flex-wrap gap-2">
        @foreach($popularSearches as $term)
        <a href="{{ route('user.search.results') }}?query={{ urlencode($term) }}" class="bg-gray-800/60 border border-gray-700 rounded-full px-3 py-1 text-xs text-gray-300 hover:border-emerald-500/50 transition">{{ $term }}</a>
        @endforeach
      </div>
    </div>

    @include('user.includes.bottom_navigation')
  </div>

</body>

</html>