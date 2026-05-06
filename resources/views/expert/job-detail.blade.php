<!DOCTYPE html>
<html lang="en">

<head>
  @include('expert.includes.general_style')
  <!-- Leaflet CSS + JS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <title>Job #{{ $booking->id }} | Expert Dashboard</title>
  <style>
    #job-map {
      height: 220px;
      width: 100%;
      border-radius: 0.75rem;
      margin: 0.5rem 0;
    }
  </style>
</head>

<body class="min-h-screen bg-[#121826]">

  <div class="mx-auto max-w-[420px] min-h-screen bg-[#121826] shadow-2xl shadow-black/50 relative">

    @include('expert.includes.top_greetings')

    <div class="px-4 pt-4 pb-20">
      <a href="{{ route('expert.jobs') }}" class="text-[#F4A261] text-sm flex items-center gap-1 mb-4 hover:text-[#E08E3E]">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Jobs
      </a>

      <div class="bg-[#1A2636] rounded-xl border border-[#2A3A5A] shadow-xl overflow-hidden">
        <div class="p-5 space-y-4">

          <!-- Header -->
          <div class="flex justify-between items-start">
            <h1 class="text-xl font-bold text-white">Job #{{ $booking->id }}</h1>
            <span class="text-xs px-3 py-1 rounded-full 
                        @if($booking->status == 'completed') bg-green-900/40 text-green-400
                        @elseif($booking->status == 'confirmed') bg-[#2A5C8C]/40 text-[#8AB3D3]
                        @elseif($booking->status == 'pending') bg-[#F4A261]/20 text-[#F4A261]
                        @else bg-red-900/40 text-red-400 @endif">
              {{ ucfirst($booking->status) }}
            </span>
          </div>

          <!-- Map with pickup/drop -->
          <div class="border-t border-[#2A3A5A] pt-3">
            <p class="text-xs text-gray-400 mb-1">Route Map</p>
            <div id="job-map"></div>
          </div>

          <!-- Customer info -->
          <div class="border-t border-[#2A3A5A] pt-3">
            <div class="flex justify-between">
              <span class="text-xs text-gray-400">Customer</span>
              <span class="text-sm text-white font-medium">{{ $booking->user->name ?? 'N/A' }}</span>
            </div>
            <div class="flex justify-between mt-2">
              <span class="text-xs text-gray-400">Phone</span>
              <a href="tel:{{ $booking->user->phone ?? '' }}" class="text-sm text-[#F4A261]">{{ $booking->user->phone ?? 'Not provided' }}</a>
            </div>
          </div>

          <!-- Service & distance -->
          <div class="border-t border-[#2A3A5A] pt-3">
            <div class="flex justify-between">
              <span class="text-xs text-gray-400">Service</span>
              <span class="text-sm text-white">{{ $booking->subService->name ?? $booking->service->name }}</span>
            </div>
            <div class="flex justify-between mt-2">
              <span class="text-xs text-gray-400">Distance</span>
              <span class="text-sm text-white">{{ $booking->distance_km }} km</span>
            </div>
            <div class="flex justify-between mt-2">
              <span class="text-xs text-gray-400">Booking Date</span>
              <span class="text-sm text-white">{{ $booking->created_at->format('M d, Y g:i A') }}</span>
            </div>
          </div>

          <!-- Fare breakdown (earnings) -->
          <div class="border-t border-[#2A3A5A] pt-3">
            <p class="text-xs text-gray-400 mb-1">Your Earnings</p>
            <div class="flex justify-between">
              <span class="text-xs text-gray-400">Base Fare</span>
              <span class="text-sm text-white">Rs. {{ number_format($booking->base_price) }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-xs text-gray-400">Distance Charge</span>
              <span class="text-sm text-white">Rs. {{ number_format($booking->distance_charge) }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-xs text-gray-400">Service Fee</span>
              <span class="text-sm text-white">Rs. {{ number_format($booking->service_fee) }}</span>
            </div>
            <div class="flex justify-between font-bold mt-1">
              <span class="text-sm text-[#F4A261]">Total</span>
              <span class="text-lg text-[#F4A261]">Rs. {{ number_format($booking->total_price) }}</span>
            </div>
          </div>

          <!-- Action buttons -->
          @if($booking->status == 'pending')
          <div class="flex gap-3 pt-2">
            <form method="POST" action="{{ route('expert.jobs.accept', $booking->id) }}" class="flex-1">
              @csrf
              <button class="w-full py-2 bg-[#2A5C8C]/40 hover:bg-[#2A5C8C]/60 text-[#F4A261] rounded-lg text-sm font-medium transition">Accept Job</button>
            </form>
            <form method="POST" action="{{ route('expert.jobs.decline', $booking->id) }}" class="flex-1">
              @csrf
              <button class="w-full py-2 bg-red-900/40 hover:bg-red-800/60 text-red-400 rounded-lg text-sm font-medium transition">Decline</button>
            </form>
          </div>
          @elseif($booking->status == 'confirmed')
          <form method="POST" action="{{ route('expert.jobs.complete', $booking->id) }}">
            @csrf
            <button class="w-full py-2 bg-[#F4A261]/20 hover:bg-[#F4A261]/30 text-[#F4A261] rounded-lg text-sm font-medium transition">Mark as Completed</button>
          </form>
          @endif

          <!-- Call customer -->
          <div class="pt-2">
            <a href="tel:{{ $booking->user->phone ?? '' }}" class="block w-full text-center py-2 bg-[#2A5C8C]/40 hover:bg-[#2A5C8C]/60 text-[#F4A261] rounded-lg text-sm font-medium transition">
              <i data-lucide="phone" class="w-4 h-4 inline mr-1"></i> Call Customer
            </a>
          </div>
        </div>
      </div>
    </div>

    @include('expert.includes.bottom_navigation')
  </div>

  <script>
    // Map with pickup and drop
    const pickupLat = {{ $booking->pickup_lat }};
    const pickupLng = {{ $booking->pickup_lng }};
    const dropLat = {{ $booking->drop_lat }};
    const dropLng = {{ $booking->drop_lng }};

    const map = L.map('job-map').setView([(pickupLat + dropLat)/2, (pickupLng + dropLng)/2], 12);
    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
      attribution: '&copy; OSM & CartoDB',
      subdomains: 'abcd',
      maxZoom: 19
    }).addTo(map);

    L.marker([pickupLat, pickupLng], {
      icon: L.divIcon({ html: '<div style="background:#22c55e; width:12px; height:12px; border-radius:50%; border:2px solid white;"></div>', iconSize: [12,12] })
    }).addTo(map).bindPopup('Pickup');

    L.marker([dropLat, dropLng], {
      icon: L.divIcon({ html: '<div style="background:#ef4444; width:12px; height:12px; border-radius:50%; border:2px solid white;"></div>', iconSize: [12,12] })
    }).addTo(map).bindPopup('Drop');

    L.polyline([[pickupLat, pickupLng], [dropLat, dropLng]], { color: '#F4A261', weight: 3 }).addTo(map);
    map.fitBounds([[pickupLat, pickupLng], [dropLat, dropLng]], { padding: [30,30] });

    document.addEventListener('DOMContentLoaded', () => {
      if (typeof lucide !== 'undefined') lucide.createIcons();
    });
  </script>
</body>
</html>