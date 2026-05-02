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

    .service-card {
      transition: all 0.25s ease;
    }

    .service-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 12px -3px rgb(0 0 0 / 0.08);
      border-color: #FF6B6B;
    }

    /* Search Bar Styles */
    .search-input {
      width: 100%;
      padding: 12px 16px 12px 40px;
      border: 1px solid #EAE0D5;
      border-radius: 9999px;
      font-size: 15px;
      background-color: white;
      transition: all 0.2s;
    }

    .search-input:focus {
      outline: none;
      border-color: #FF6B6B;
      box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.1);
    }
  </style>
</head>

<body class="min-h-screen bg-[#e6e5e3]">

  <div class="mx-auto max-w-[420px] min-h-screen bg-[#e6e5e3] shadow-2xl shadow-black/5 relative">

    @include('user.includes.top_greetings')

    <div class="px-4 mt-2 mb-4">
      <h1 class="text-xl font-bold text-[#2C1810]">Explore Services</h1>
      <p class="text-xs text-[#6B5B50] mt-1">Find the right professional for your needs</p>
    </div>

    <!-- Search Bar -->
    <div class="px-4 mb-5 relative">
      <div class="relative">
        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#6B5B50] text-lg">🔍</span>
        <input 
          type="text" 
          id="serviceSearch"
          placeholder="Search services..." 
          class="search-input text-black placeholder:text-gray-400 focus:text-black">
      </div>
    </div>

    <div class="px-4 space-y-1" id="servicesContainer"> <!-- Reduced spacing between cards -->

      @foreach($services as $service)
      <a href="{{ route('user.search.results', ['id' => $service->id]) }}"
        class="service-card bg-white border border-[#EAE0D5] rounded-xl flex items-center px-3 py-2 gap-3 hover:border-[#FF6B6B]/70 transition"
        data-search="{{ strtolower($service->name . ' ' . ($service->description ?? '')) }}">

        <!-- Left Image -->
        <div class="w-10 h-10 flex-shrink-0 rounded-lg overflow-hidden border border-[#EAE0D5]">
          @if(!empty($service->pic))
          <img src="{{ asset($service->pic) }}"
            alt="{{ $service->name }}"
            class="w-full h-full object-cover">
          @else
          <div class="w-full h-full bg-gradient-to-br from-[#FF6B6B]/10 to-[#FF8E8E]/10 flex items-center justify-center text-sm">
            🛠️
          </div>
          @endif
        </div>

        <!-- Service Name -->
        <div class="flex-1 min-w-0">
          <h3 class="font-medium text-[#2C1810] text-sm leading-tight truncate">
            {{ $service->name }}
          </h3>

          @if(!empty($service->description))
          <p class="text-[11px] text-[#6B5B50] leading-tight truncate">
            {{ $service->description }}
          </p>
          @endif
        </div>

        <!-- Arrow -->
        <div class="text-[#FF6B6B] text-base leading-none">
          →
        </div>

      </a>
      @endforeach

    </div>

    <div class="mb-10">&nbsp;</div>

    @include('user.includes.bottom_navigation')

  </div>

  <!-- JavaScript for Live Search -->
  <script>
    document.getElementById('serviceSearch').addEventListener('input', function() {
      const searchTerm = this.value.toLowerCase().trim();
      const cards = document.querySelectorAll('.service-card');

      cards.forEach(card => {
        const searchableText = card.getAttribute('data-search');
        if (searchableText.includes(searchTerm)) {
          card.style.display = 'flex';
        } else {
          card.style.display = 'none';
        }
      });
    });
  </script>

</body>
</html>