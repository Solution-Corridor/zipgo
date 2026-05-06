<!DOCTYPE html>
<html lang="en">

<head>
    @include('user.includes.general_style')
    <!-- Leaflet CSS + JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <title>{{ $subService->name }} | {{ $service->name }} - Map Booking</title>
    <style>
        /* Your existing styles + map adjustments */
        .location-card {
            background: white;
            border-radius: 1rem;
            padding: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border: 1px solid #f0ece8;
        }
        .price-breakdown {
            background: white;
            border-radius: 1rem;
            padding: 1rem;
            margin-top: 1rem;
        }
        .price-row {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px dashed #f0ece8;
        }

        .price-row span{
color: black !important;
        }
        .price-row.total {
            border-top: 2px solid #FFE66D;
            border-bottom: none;
            margin-top: 0.5rem;
            padding-top: 0.75rem;
            font-weight: 800;
            font-size: 1.1rem;
            color: #2C1810;
        }
        .book-btn {
            background: #FF6B6B;
            color: white;
            padding: 1rem;
            border-radius: 2rem;
            font-weight: 700;
            text-align: center;
            transition: all 0.2s;
            display: block;
            width: 100%;
            border: none;
            cursor: pointer;
        }
        .book-btn:hover {
            background: #ff5252;
            transform: translateY(-2px);
        }
        #map {
            height: 280px;
            width: 100%;
            border-radius: 1rem;
            margin-top: 0.5rem;
            z-index: 1;
        }
        .mode-buttons {
            display: flex;
            gap: 0.75rem;
            margin: 0.75rem 0;
        }
        .mode-btn {
            flex: 1;
            background: #f0ece8;
            border: none;
            padding: 0.5rem;
            border-radius: 2rem;
            font-size: 0.75rem;
            font-weight: 600;
            transition: all 0.2s;
        }
        .mode-btn.active {
            background: #FF6B6B;
            color: white;
        }
        .location-info {
            font-size: 0.7rem;
            color: #6B5B50;
            margin-top: 0.5rem;
            text-align: center;
        }
        @media (max-width: 420px) {
            #map { height: 250px; }
        }
    </style>
</head>

<body class="min-h-screen bg-[#e6e5e3]">

    <div class="mx-auto max-w-[420px] min-h-screen bg-[#e6e5e3] relative pb-24">
        
        @include('user.includes.top_greetings')

        <!-- Header -->
        <div class="px-4 mt-4 mb-3">
            <div class="flex items-center justify-between">
                <a href="{{ url()->previous() }}" class="text-[#FF6B6B] text-sm flex items-center gap-1">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i> Back
                </a>
                <span class="text-xs text-[#6B5B50]">Map Booking</span>
            </div>

            <div class="mt-4 flex gap-3 items-start">
                @if($subService->image)
                <div class="w-16 h-16 rounded-xl overflow-hidden flex-shrink-0 bg-white shadow-sm">
                    <img src="{{ asset($subService->image) }}" alt="{{ $subService->name }}" class="w-full h-full object-cover">
                </div>
                @endif
                <div class="flex-1">
                    <h1 class="text-xl font-bold text-[#2C1810]">{{ $subService->name }}</h1>
                    <p class="text-xs text-[#6B5B50] mt-1">{{ $service->name }} • On-demand</p>
                    <div class="flex items-center gap-2 mt-2">
                        <span class="text-lg font-bold text-[#FF6B6B]">Rs. {{ number_format($subService->price, 0) }}</span>
                        <span class="text-xs text-[#6B5B50]">base fare</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Map + Location Picker -->
        <div class="px-4 mb-4">
            <div class="bg-white rounded-2xl p-4 shadow-sm">
                <div class="flex items-center gap-2 mb-2">
                    <i data-lucide="map" class="w-5 h-5 text-[#FF6B6B]"></i>
                    <span class="text-sm font-semibold text-[#2C1810]">Pickup & Drop on Map</span>
                </div>
                
                <!-- Mode toggle (Pickup / Drop) -->
                <div class="mode-buttons">
                    <button id="pickupModeBtn" class="mode-btn active">📍 Set Pickup</button>
                    <button id="dropModeBtn" class="mode-btn">🏁 Set Drop</button>
                </div>

                <!-- Map container -->
                <div id="map"></div>
                
                <!-- Live location feedback -->
                <div class="location-info" id="locationFeedback">
                    Click on map to set pickup location first.
                </div>
            </div>
        </div>

        <!-- Price Breakdown (dynamic) -->
        <div class="px-4">
            <div class="price-breakdown">
                <h3 class="text-sm font-bold text-[#2C1810] mb-2 flex items-center gap-2">
                    <i data-lucide="credit-card" class="w-4 h-4"></i> Fare Details
                </h3>
                <div class="price-row">
                    <span>Base Fare</span>
                    <span id="baseFareDisplay">Rs. {{ number_format($subService->price, 0) }}</span>
                </div>
                <div class="price-row">
                    <span>Distance (per km)</span>
                    <span>Rs. {{ number_format($subService->price, 0) }}/km</span>
                </div>
                <div class="price-row">
                    <span>Distance Charge</span>
                    <span id="distanceCharge">Rs. 0</span>
                </div>
                <div class="price-row">
                    <span>Service Fee</span>
                    <span>Rs. 30</span>
                </div>
                <div class="price-row total">
                    <span>Total Amount</span>
                    <span id="totalPrice">Rs. 0</span>
                </div>
                <div class="text-xs text-gray-400 text-center mt-2" id="distanceKm">Distance: 0 km</div>
            </div>

            <button id="bookNowBtn" class="book-btn mt-4 flex items-center justify-center gap-2">
                <i data-lucide="shield-check" class="w-5 h-5"></i> Confirm Booking
            </button>
        </div>

        @include('user.includes.bottom_navigation')
    </div>

    <script>
        // --- Map Configuration ---
        // Default center (example: your city center, e.g., Kathmandu or any lat/lng)
        const defaultCenter = [27.7172, 85.3240];  // Change to your city's coordinates
        
        // Initialize map
        const map = L.map('map').setView(defaultCenter, 13);
        
        // Load OpenStreetMap tiles
        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OSM</a> &copy; CartoDB',
            subdomains: 'abcd',
            maxZoom: 19
        }).addTo(map);
        
        // Markers
        let pickupMarker = null;
        let dropMarker = null;
        let currentMode = 'pickup'; // 'pickup' or 'drop'
        
        // UI elements
        const pickupModeBtn = document.getElementById('pickupModeBtn');
        const dropModeBtn = document.getElementById('dropModeBtn');
        const locationFeedback = document.getElementById('locationFeedback');
        const distanceChargeSpan = document.getElementById('distanceCharge');
        const totalPriceSpan = document.getElementById('totalPrice');
        const distanceKmSpan = document.getElementById('distanceKm');
        
        // Price constants
        const basePrice = {{ $subService->price }};
        const perKmRate = 35;
        const serviceFee = 30;
        
        // Helper: calculate distance (Haversine formula) in km
        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371; // km
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                      Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                      Math.sin(dLon/2) * Math.sin(dLon/2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            return R * c;
        }
        
        // Update price based on current markers
        function updatePrice() {
            if (pickupMarker && dropMarker) {
                const p = pickupMarker.getLatLng();
                const d = dropMarker.getLatLng();
                const distance = calculateDistance(p.lat, p.lng, d.lat, d.lng);
                const distanceCharge = Math.round(distance * perKmRate);
                const total = basePrice + distanceCharge + serviceFee;
                
                distanceChargeSpan.innerText = 'Rs. ' + distanceCharge.toLocaleString();
                totalPriceSpan.innerText = 'Rs. ' + total.toLocaleString();
                distanceKmSpan.innerText = `Distance: ${distance.toFixed(2)} km`;
            } else {
                distanceChargeSpan.innerText = 'Rs. 0';
                totalPriceSpan.innerText = 'Rs. ' + (basePrice + serviceFee).toLocaleString();
                distanceKmSpan.innerText = 'Distance: 0 km (set both locations)';
            }
        }
        
        // Handle map click
        map.on('click', function(e) {
            const { lat, lng } = e.latlng;
            
            if (currentMode === 'pickup') {
                // Remove existing pickup marker
                if (pickupMarker) map.removeLayer(pickupMarker);
                // Add new pickup marker (green)
                pickupMarker = L.marker([lat, lng], {
                    icon: L.divIcon({
                        className: 'custom-div-icon',
                        html: '<div style="background-color:#22c55e; width:12px; height:12px; border-radius:50%; border:2px solid white; box-shadow:0 0 0 2px #22c55e;"></div>',
                        iconSize: [12, 12],
                        popupAnchor: [0, -6]
                    })
                }).addTo(map);
                pickupMarker.bindPopup('Pickup').openPopup();
                locationFeedback.innerHTML = '✅ Pickup set. Now click "Set Drop" or tap on map again to set drop location.';
                // Optionally auto-switch mode to drop for convenience
                // But we'll let user switch manually to avoid confusion. 
                // Uncomment next line if you want auto-switch:
                // document.getElementById('dropModeBtn').click();
            } 
            else if (currentMode === 'drop') {
                if (dropMarker) map.removeLayer(dropMarker);
                dropMarker = L.marker([lat, lng], {
                    icon: L.divIcon({
                        className: 'custom-div-icon',
                        html: '<div style="background-color:#ef4444; width:12px; height:12px; border-radius:50%; border:2px solid white; box-shadow:0 0 0 2px #ef4444;"></div>',
                        iconSize: [12, 12],
                        popupAnchor: [0, -6]
                    })
                }).addTo(map);
                dropMarker.bindPopup('Drop').openPopup();
                locationFeedback.innerHTML = '✅ Drop set. Both locations ready.';
            }
            
            updatePrice();
        });
        
        // Mode switching UI
        pickupModeBtn.addEventListener('click', () => {
            currentMode = 'pickup';
            pickupModeBtn.classList.add('active');
            dropModeBtn.classList.remove('active');
            locationFeedback.innerHTML = '📍 Pickup mode active – click on map to set pickup location.';
        });
        
        dropModeBtn.addEventListener('click', () => {
            if (!pickupMarker) {
                locationFeedback.innerHTML = '⚠️ Please set pickup location first.';
                return;
            }
            currentMode = 'drop';
            dropModeBtn.classList.add('active');
            pickupModeBtn.classList.remove('active');
            locationFeedback.innerHTML = '🏁 Drop mode active – click on map to set drop location.';
        });
        
        // Optional: Add a reset button? Not required but you can add a small "Reset" link.
        // For better UX, we add a hidden reset feature: double-click map clears all? Not needed now.
        
        // Dummy booking button
        document.getElementById('bookNowBtn').addEventListener('click', () => {
            if (!pickupMarker || !dropMarker) {
                alert('Please set both pickup and drop locations on the map before booking.');
                return;
            }
            const pickupLatLng = pickupMarker.getLatLng();
            const dropLatLng = dropMarker.getLatLng();
            const totalText = totalPriceSpan.innerText;
            alert(`✨ DEMO BOOKING ✨\n\nService: {{ $subService->name }}\nPickup: ${pickupLatLng.lat.toFixed(4)}, ${pickupLatLng.lng.toFixed(4)}\nDrop: ${dropLatLng.lat.toFixed(4)}, ${dropLatLng.lng.toFixed(4)}\nTotal: ${totalText}\n\nThis is a dummy demonstration. No actual booking is created.`);
        });
        
        // Lucide icons & initial distance message
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') lucide.createIcons();
            updatePrice(); // base price only
        });
    </script>
</body>

</html>