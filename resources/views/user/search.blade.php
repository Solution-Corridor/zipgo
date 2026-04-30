<!DOCTYPE html>
<html lang="en">

<head>
  @include('user.includes.general_style')
  <title>Find Services – Home Services</title>
</head>

<body class="min-h-screen bg-[#e6e5e3]">

  <div class="mx-auto max-w-[420px] min-h-screen bg-[#e6e5e3] relative">

    @include('user.includes.top_greetings')

    <div class="px-4 mt-4 mb-4">
      <h1 class="text-xl font-bold text-[#2C1810]">Find a Professional</h1>
      <form action="{{ route('user.search.results') }}" method="GET" class="mt-3">
        <div class="relative">
          <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#6B5B50]"></i>
          <input type="text" name="query" placeholder="e.g., plumber, AC repair..." class="w-full bg-white border border-[#EAE0D5] rounded-xl py-3 pl-10 pr-4 text-sm text-[#2C1810] placeholder:text-[#6B5B50] focus:outline-none focus:border-[#FF6B6B]/70">
          <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 bg-[#FF6B6B] hover:bg-[#ff5252] px-3 py-1 rounded-lg text-xs text-white">Search</button>
        </div>
      </form>
    </div>

    <div class="px-4 mb-5">
      <h3 class="text-sm font-semibold text-[#2C1810] mb-2">Popular Searches</h3>
      <div class="flex flex-wrap gap-2">
        @foreach($popularSearches as $term)
        <a href="{{ route('user.search.results') }}?query={{ urlencode($term) }}" class="bg-white border border-[#EAE0D5] rounded-full px-3 py-1 text-xs text-[#2C1810] hover:border-[#FF6B6B]/50 transition shadow-sm">{{ $term }}</a>
        @endforeach
      </div>
    </div>

    @include('user.includes.bottom_navigation')
  </div>

</body>

</html>