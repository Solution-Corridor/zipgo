  <!DOCTYPE html>
  <html lang="en">

  <head>
    @include('user.includes.general_style')
    <title>{{ $service->name }} - Sub Services</title>
    <style>
      /* Additional custom styles for square cards and overlay */
      .sub-card {
        position: relative;
        aspect-ratio: 1 / 1;
        background-size: cover;
        background-position: center;
        border-radius: 1rem;
        overflow: hidden;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s, box-shadow 0.2s;
      }

      .sub-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 20px rgba(0, 0, 0, 0.1);
      }

      .card-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.2), transparent);
        padding: 0.75rem 0.5rem 0.5rem;
        color: white;
      }

      .card-name {
        font-size: 0.75rem;
        font-weight: 600;
        margin-bottom: 0.2rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
      }

      .card-price {
        font-size: 0.7rem;
        font-weight: 700;
        color: #FFE66D;
      }

      .priority-badge-card {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        background: #FEF3C7;
        color: #B45309;
        font-size: 0.6rem;
        font-weight: bold;
        padding: 0.2rem 0.5rem;
        border-radius: 999px;
        z-index: 2;
      }

      .subservices-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.75rem;
        margin-top: 0.5rem;
      }

      @media (max-width: 420px) {
        .subservices-grid {
          gap: 0.6rem;
        }

        .card-name {
          font-size: 0.7rem;
        }

        .card-price {
          font-size: 0.65rem;
        }
      }
    </style>
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
        <p class="text-xs text-[#6B5B50]">{{ count($subServices) }} sub‑services available</p>
      </div>

      <div class="px-4 mb-20">
        @if($subServices->count())
        <div class="subservices-grid">
          @foreach($subServices as $sub)
          @php
          $bgImage = asset($sub->image);
          @endphp
          <div class="sub-card" style="background-image: url('{{ $bgImage }}');">
            <div class="card-overlay">
              <div class="card-name">{{ $sub->name }}</div>
              <div class="card-price">Rs. {{ number_format($sub->price, 0) }}</div>
            </div>
            <a href="{{ route('user.sub.service', ['slug' => $service->slug, 'subslug' => $sub->slug]) }}"
              class="absolute inset-0 z-10">
            </a>
          </div>
          @endforeach
        </div>
        @else
        <div class="text-center py-12">
          <i data-lucide="search-x" class="w-16 h-16 text-gray-300 mx-auto mb-3"></i>
          <p class="text-[#6B5B50]">No sub‑services available for {{ $service->name }} yet.</p>
        </div>
        @endif
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