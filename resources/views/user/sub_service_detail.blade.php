<!DOCTYPE html>
<html lang="en">

<head>
    @include('user.includes.general_style')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <!-- SweetAlert2 for pretty modal -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>{{ $subService->name }} | {{ $service->name }} - Map Booking</title>
    <style>
        /* Your existing styles unchanged */
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
        .price-row span {
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
                
                <div class="mode-buttons">
                    <button id="pickupModeBtn" class="mode-btn active">📍 Set Pickup</button>
                    <button id="dropModeBtn" class="mode-btn">🏁 Set Drop</button>
                </div>

                <div id="map"></div>
                <div class="location-info" id="locationFeedback">
                    Click on map to set pickup location first.
                </div>
            </div>
        </div>

        <!-- Price Breakdown -->
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
                    <span id="perKmRateDisplay">Rs. 35/km</span>
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
        const defaultCenter = [27.7172, 85.3240];
        const map = L.map('map').setView(defaultCenter, 13);
        
        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OSM</a> &copy; CartoDB',
            subdomains: 'abcd',
            maxZoom: 19
        }).addTo(map);
        
        let pickupMarker = null;
        let dropMarker = null;
        let currentMode = 'pickup';
        
        // DOM elements
        const pickupModeBtn = document.getElementById('pickupModeBtn');
        const dropModeBtn = document.getElementById('dropModeBtn');
        const locationFeedback = document.getElementById('locationFeedback');
        const distanceChargeSpan = document.getElementById('distanceCharge');
        const totalPriceSpan = document.getElementById('totalPrice');
        const distanceKmSpan = document.getElementById('distanceKm');
        
        // Price data
        const basePrice = {{ $subService->price }};
        const perKmRate = 35;
        const serviceFee = 30;
        
        // Helper distance
        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371;
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                      Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                      Math.sin(dLon/2) * Math.sin(dLon/2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            return R * c;
        }
        
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
                // Store current values for booking
                window.currentDistance = distance;
                window.currentDistanceCharge = distanceCharge;
                window.currentTotal = total;
            } else {
                distanceChargeSpan.innerText = 'Rs. 0';
                totalPriceSpan.innerText = 'Rs. ' + (basePrice + serviceFee).toLocaleString();
                distanceKmSpan.innerText = 'Distance: 0 km (set both locations)';
                window.currentDistance = 0;
                window.currentDistanceCharge = 0;
                window.currentTotal = basePrice + serviceFee;
            }
        }
        
        map.on('click', function(e) {
            const { lat, lng } = e.latlng;
            if (currentMode === 'pickup') {
                if (pickupMarker) map.removeLayer(pickupMarker);
                pickupMarker = L.marker([lat, lng], {
                    icon: L.divIcon({
                        className: 'custom-div-icon',
                        html: '<div style="background-color:#22c55e; width:12px; height:12px; border-radius:50%; border:2px solid white; box-shadow:0 0 0 2px #22c55e;"></div>',
                        iconSize: [12, 12],
                        popupAnchor: [0, -6]
                    })
                }).addTo(map);
                pickupMarker.bindPopup('Pickup').openPopup();
                locationFeedback.innerHTML = '✅ Pickup set. Now set drop location.';
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
                locationFeedback.innerHTML = '✅ Drop set. Ready to book!';
            }
            updatePrice();
        });
        
        pickupModeBtn.addEventListener('click', () => {
            currentMode = 'pickup';
            pickupModeBtn.classList.add('active');
            dropModeBtn.classList.remove('active');
            locationFeedback.innerHTML = '📍 Pickup mode – click on map to set pickup.';
        });
        
        dropModeBtn.addEventListener('click', () => {
            if (!pickupMarker) {
                locationFeedback.innerHTML = '⚠️ Please set pickup location first.';
                return;
            }
            currentMode = 'drop';
            dropModeBtn.classList.add('active');
            pickupModeBtn.classList.remove('active');
            locationFeedback.innerHTML = '🏁 Drop mode – click on map to set drop.';
        });
        
        // BOOKING with AJAX + SweetAlert2
        document.getElementById('bookNowBtn').addEventListener('click', async () => {
            if (!pickupMarker || !dropMarker) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Incomplete',
                    text: 'Please set both pickup and drop locations on the map!',
                    confirmButtonColor: '#FF6B6B'
                });
                return;
            }
            
            const pickupLatLng = pickupMarker.getLatLng();
            const dropLatLng = dropMarker.getLatLng();
            
            const bookingData = {
                service_id: {{ $service->id }},
                sub_service_id: {{ $subService->id }},
                pickup_lat: pickupLatLng.lat,
                pickup_lng: pickupLatLng.lng,
                drop_lat: dropLatLng.lat,
                drop_lng: dropLatLng.lng,
                distance_km: window.currentDistance.toFixed(2),
                base_price: basePrice,
                per_km_rate: perKmRate,
                distance_charge: window.currentDistanceCharge,
                service_fee: serviceFee,
                total_price: window.currentTotal,
                _token: '{{ csrf_token() }}'
            };
            
            try {
                const response = await fetch('{{ route("user.subservice.book") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(bookingData)
                });
                const result = await response.json();
                
                if (result.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '🎉 Booking Confirmed!',
                        html: `<strong>Booking ID:</strong> #${result.booking_id}<br>
                               <strong>Service:</strong> {{ $subService->name }}<br>
                               <strong>Total Paid:</strong> Rs. ${window.currentTotal.toLocaleString()}<br>
                               <strong>Status:</strong> Confirmed`,
                        confirmButtonText: 'Great!',
                        confirmButtonColor: '#22c55e',
                        background: '#fff',
                        backdrop: true
                    }).then(() => {
                        // Optional: redirect to booking history
                        // window.location.href = '/my-bookings';
                    });
                } else {
                    Swal.fire('Error', result.message || 'Booking failed. Try again.', 'error');
                }
            } catch (err) {
                Swal.fire('Error', 'Network error. Please check your connection.', 'error');
            }
        });
        
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') lucide.createIcons();
            updatePrice();
        });
    </script>
</body>

</html>