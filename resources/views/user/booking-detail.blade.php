<!DOCTYPE html>
<html lang="en">

<head>
  @include('user.includes.general_style')
  <!-- Leaflet CSS + JS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <title>Booking #{{ $booking->id }}</title>
  <style>
    .info-row { margin-bottom: 0.75rem; }
    .info-label { font-size: 0.7rem; color: #6B5B50; }
    .info-value { font-size: 0.9rem; font-weight: 500; color: #2C1810; word-break: break-word; }
    #detail-map {
      height: 240px;
      width: 100%;
      border-radius: 0.75rem;
      margin-top: 0.5rem;
      margin-bottom: 0.75rem;
      z-index: 1;
    }
  </style>
</head>

<body class="min-h-screen bg-[#e6e5e3]">

  <div class="mx-auto max-w-[420px] min-h-screen bg-[#e6e5e3] relative">

    @include('user.includes.top_greetings')

    <div class="px-4 mt-4">
      <a href="{{ route('user.bookings') }}" class="text-[#FF6B6B] text-sm flex items-center gap-1 hover:text-[#ff5252]">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Back
      </a>
      <h1 class="text-xl font-bold text-[#2C1810] mt-2">Booking #{{ $booking->id }}</h1>
    </div>

    <div class="mx-4 mt-4 bg-white border border-[#EAE0D5] rounded-xl p-4 shadow-sm space-y-3">

      <!-- Map Section -->
      <div>
        <div class="info-label">Pickup → Drop Route</div>
        <div id="detail-map"></div>
        <p class="text-xs text-gray-400 text-center mt-1">📍 Green: Pickup | 🔴 Red: Drop</p>
      </div>

      <div class="info-row">
        <div class="info-label">Service</div>
        <div class="info-value">{{ $booking->service->name }} → {{ $booking->subService->name }}</div>
      </div>

      <div class="info-row">
        <div class="info-label">Booking Date</div>
        <div class="info-value">{{ $booking->created_at->format('l, F j, Y \a\t g:i A') }}</div>
      </div>

      <div class="info-row">
        <div class="info-label">Distance</div>
        <div class="info-value">{{ $booking->distance_km }} km</div>
      </div>

      <div class="info-row">
        <div class="info-label">Fare Breakdown</div>
        <div class="info-value text-sm">
          Base: Rs. {{ number_format($booking->base_price, 0) }}<br>
          Distance ({{ $booking->per_km_rate }}/km): Rs. {{ number_format($booking->distance_charge, 0) }}<br>
          Service Fee: Rs. {{ number_format($booking->service_fee, 0) }}<br>
          <strong class="text-[#FF6B6B]">Total: Rs. {{ number_format($booking->total_price, 0) }}</strong>
        </div>
      </div>

      <div class="info-row">
        <div class="info-label">Status</div>
        <span class="inline-block px-2 py-1 rounded-full text-xs 
          @if($booking->status == 'confirmed') bg-green-100 text-green-700
          @elseif($booking->status == 'pending') bg-yellow-100 text-yellow-700
          @elseif($booking->status == 'cancelled') bg-red-100 text-red-700
          @else bg-gray-100 text-gray-700 @endif">
          {{ ucfirst($booking->status) }}
        </span>
      </div>
    </div>

    <div class="mx-4 mt-4 mb-20 flex gap-3">
      <a href="#" class="flex-1 text-center bg-[#FF6B6B] hover:bg-[#ff5252] py-2 rounded-lg text-white text-sm transition" onclick="alert('Contact support: support@example.com'); return false;">Contact Support</a>
      @if($booking->status == 'pending')
      <a href="#" class="flex-1 text-center bg-red-100 hover:bg-red-200 py-2 rounded-lg text-red-600 text-sm transition" onclick="event.preventDefault(); cancelBooking({{ $booking->id }});">Cancel Booking</a>
      @endif
    </div>

    @include('user.includes.bottom_navigation')
  </div>

  <script>
    // Coordinates from the booking (use double values)
    const pickupLat = {{ $booking->pickup_lat }};
    const pickupLng = {{ $booking->pickup_lng }};
    const dropLat = {{ $booking->drop_lat }};
    const dropLng = {{ $booking->drop_lng }};
    
    // Calculate center point between pickup and drop
    const centerLat = (pickupLat + dropLat) / 2;
    const centerLng = (pickupLng + dropLng) / 2;
    
    // Initialize map
    const map = L.map('detail-map').setView([centerLat, centerLng], 12);
    
    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OSM</a> &copy; CartoDB',
      subdomains: 'abcd',
      maxZoom: 19
    }).addTo(map);
    
    // Pickup marker (green)
    L.marker([pickupLat, pickupLng], {
      icon: L.divIcon({
        className: 'custom-div-icon',
        html: '<div style="background-color:#22c55e; width:14px; height:14px; border-radius:50%; border:2px solid white; box-shadow:0 0 0 2px #22c55e;"></div>',
        iconSize: [14, 14],
        popupAnchor: [0, -7]
      })
    }).addTo(map).bindPopup('Pickup').openPopup();
    
    // Drop marker (red)
    L.marker([dropLat, dropLng], {
      icon: L.divIcon({
        className: 'custom-div-icon',
        html: '<div style="background-color:#ef4444; width:14px; height:14px; border-radius:50%; border:2px solid white; box-shadow:0 0 0 2px #ef4444;"></div>',
        iconSize: [14, 14],
        popupAnchor: [0, -7]
      })
    }).addTo(map).bindPopup('Drop');
    
    // Draw a line between pickup and drop
    const polyline = L.polyline([[pickupLat, pickupLng], [dropLat, dropLng]], {
      color: '#FF6B6B',
      weight: 3,
      opacity: 0.7,
      dashArray: '5, 10'
    }).addTo(map);
    
    // Optional: fit bounds to show both markers nicely
    map.fitBounds([[pickupLat, pickupLng], [dropLat, dropLng]], { padding: [30, 30] });
    
    // Cancel booking function (unchanged)
    function cancelBooking(bookingId) {
      if (confirm('Cancel this booking? This action cannot be undone.')) {
        fetch(`/bookings/${bookingId}/cancel`, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
          }
        }).then(res => res.json()).then(data => {
          if (data.success) window.location.href = '{{ route("user.bookings") }}';
          else alert('Cancellation failed');
        });
      }
    }

    document.addEventListener('DOMContentLoaded', () => {
      if (typeof lucide !== 'undefined') lucide.createIcons();
    });
  </script>
</body>

</html>