<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes, viewport-fit=cover">
  <title>ZipGo - Ride Booking with Map</title>
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>
  <!-- Leaflet CSS + JS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <!-- Leaflet Routing Machine -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
  <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
  <style>
    /* Hide main content initially */
    .main-content {
      opacity: 0;
      transition: opacity 0.5s ease;
    }

    .main-content.visible {
      opacity: 1;
    }

    /* Splash screen */
    .splash {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(to right bottom, #0AB5F8, #59A356);
      z-index: 1000;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: opacity 1s ease;
    }

    .splash.hide {
      opacity: 0;
      pointer-events: none;
    }

    .splash-logo {
      width: 120px;
      height: auto;
      transition: all 0.8s cubic-bezier(0.2, 0.9, 0.4, 1.1);
      object-fit: contain;
    }

    /* final header logo area */
    .header-logo-area {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .header-logo-img {
      height: 28px;
      width: auto;
    }

    /* map & other styles */
    #map {
      height: 280px;
      width: 100%;
      border-radius: 1rem;
      z-index: 1;
    }

    .vehicle-card.active {
      border-color: #FF6B6B;
      background-color: #FFF5F5;
    }

    .scrollbar-hide::-webkit-scrollbar {
      display: none;
    }

    /* Dropdown menu styling */
    .menu-dropdown {
      position: absolute;
      top: 60px;
      right: 12px;
      background: white;
      border-radius: 1rem;
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
      width: 180px;
      z-index: 50;
      border: 1px solid #EAE0D5;
      overflow: hidden;
      transition: all 0.2s ease;
    }

    .menu-item {
      padding: 12px 16px;
      display: flex;
      align-items: center;
      gap: 12px;
      font-size: 14px;
      color: #2C1810;
      border-bottom: 1px solid #f0ebe6;
      cursor: pointer;
    }

    .menu-item:last-child {
      border-bottom: none;
    }

    .menu-item:hover {
      background-color: #FFF5F5;
    }

    .menu-item i {
      width: 18px;
      height: 18px;
    }

    /* Dark style for Earn as a Driver */
    .menu-item.dark-item {
      background-color: #1f2937;
      color: white;
      border-bottom: 1px solid #374151;
    }

    .menu-item.dark-item:hover {
      background-color: #111827;
    }

    .menu-item.dark-item i {
      color: #4ECDC4;
    }
  </style>
</head>

<body class="bg-[#e6e5e3] antialiased">

  <!-- Splash Screen -->
  <div id="splash" class="splash">
    <img src="/assets/images/logo.png" alt="ZipGo Logo" id="splashLogo" class="splash-logo">
  </div>

  <!-- Main Content (hidden initially) -->
  <div id="mainContent" class="main-content max-w-[420px] mx-auto bg-[#e6e5e3] min-h-screen shadow-2xl relative flex flex-col">

    <!-- Header with Logo, Back button, and Burger Menu -->
    <header class="px-4 pt-4 pb-2 bg-white/80 backdrop-blur-sm border-b border-[#EAE0D5] sticky top-0 z-20 flex items-center justify-between">
      <a href="/" class="p-1 -ml-1 rounded-full hover:bg-white/50">
        <i data-lucide="arrow-left" class="w-5 h-5 text-[#2C1810]"></i>
      </a>
      <div id="headerLogoArea" class="header-logo-area">
        <img src="/assets/images/logo.png" alt="zipgo-logo" title="ZipGo Logo" id="headerLogo" class="header-logo-img">
        <!-- <span class="font-bold text-xl text-[#2C1810]">ZipGo Ride</span> -->
      </div>
      <!-- Burger Menu Button -->
      <div class="relative">
        <button id="menuBtn" class="p-1 rounded-full hover:bg-white/50">
          <i data-lucide="menu" class="w-6 h-6 text-[#2C1810]"></i>
        </button>
        <!-- Dropdown Menu -->
        <div id="dropdownMenu" class="menu-dropdown hidden">
          <div class="menu-item" onclick="alert('Help & Support: Call 1800-ZIPGO')">
            <i data-lucide="help-circle" class="text-[#FF6B6B]"></i>
            <span>Help & Support</span>
          </div>
          <div class="menu-item" onclick="alert('Payment Methods: Cash, Card, ZipGo Wallet')">
            <i data-lucide="credit-card" class="text-[#4ECDC4]"></i>
            <span>Payment Methods</span>
          </div>
          <div class="menu-item" onclick="alert('Your ride history will appear here')">
            <i data-lucide="clock" class="text-[#8B5CF6]"></i>
            <span>Ride History</span>
          </div>
          <div class="menu-item" onclick="alert('Invite friends & earn rewards')">
            <i data-lucide="gift" class="text-[#FFA500]"></i>
            <span>Refer & Earn</span>
          </div>
          <!-- Earn as a Driver - Dark background -->
          <div class="menu-item dark-item" onclick="alert('Register as a driver with ZipGo! Earn flexibly.')">
            <i data-lucide="user-plus" class="text-[#4ECDC4]"></i>
            <span>Earn as a Driver</span>
          </div>
          <div class="menu-item" onclick="alert('Terms & Privacy Policy')">
            <i data-lucide="shield" class="text-[#6B5B50]"></i>
            <span>Legal</span>
          </div>
        </div>
      </div>
    </header>

    <!-- Map Section -->
    <div class="px-4 pt-3">
      <div id="map"></div>
    </div>

    <!-- Location Inputs -->
    <div class="px-4 mt-3 space-y-2">
      <div class="bg-white rounded-xl p-3 border border-[#EAE0D5] shadow-sm">
        <label class="text-xs font-semibold text-[#6B5B50] flex items-center gap-1">
          <span class="w-2 h-2 bg-green-500 rounded-full"></span> PICKUP LOCATION
        </label>
        <input type="text" id="pickupInput" placeholder="Current location" value="Hafizabad Punjab" class="w-full text-sm text-[#2C1810] focus:outline-none mt-1 bg-transparent">
      </div>
      <div class="bg-white rounded-xl p-3 border border-[#EAE0D5] shadow-sm">
        <label class="text-xs font-semibold text-[#6B5B50] flex items-center gap-1">
          <span class="w-2 h-2 bg-red-500 rounded-full"></span> DROP LOCATION
        </label>
        <input type="text" id="dropInput" placeholder="Where to go?" value="Jhelum" class="w-full text-sm text-[#2C1810] focus:outline-none mt-1 bg-transparent">
      </div>
      <button id="swapBtn" class="text-xs text-[#FF6B6B] flex items-center gap-1 ml-1 mt-0">
        <i data-lucide="arrow-up-down" class="w-3 h-3"></i> Swap locations
      </button>
    </div>

    <!-- Choose a ride -->
    <div class="px-4 mt-4">
      <h3 class="text-sm font-bold text-[#2C1810] mb-2">Choose a ride</h3>
      <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
        <div class="vehicle-card min-w-[100px] bg-white border border-[#EAE0D5] rounded-xl p-3 text-center cursor-pointer transition-all" data-vehicle="bike" data-base="29" data-perkm="6">
          <i data-lucide="bike" class="w-6 h-6 mx-auto text-[#4ECDC4]"></i>
          <p class="font-semibold text-sm mt-1 text-[#2C1810]">Bike</p>
          <p class="text-[10px] text-[#6B5B50]">Rs 29 base</p>
        </div>
        <div class="vehicle-card min-w-[100px] bg-white border border-[#EAE0D5] rounded-xl p-3 text-center cursor-pointer transition-all" data-vehicle="auto" data-base="45" data-perkm="9">
          <i data-lucide="navigation" class="w-6 h-6 mx-auto text-[#FFA500]"></i>
          <p class="font-semibold text-sm mt-1 text-[#2C1810]">Auto</p>
          <p class="text-[10px] text-[#6B5B50]">Rs 45 base</p>
        </div>
        <div class="vehicle-card active min-w-[100px] bg-white border-2 border-[#FF6B6B] rounded-xl p-3 text-center cursor-pointer transition-all" data-vehicle="mini" data-base="85" data-perkm="12">
          <i data-lucide="car" class="w-6 h-6 mx-auto text-[#8B5CF6]"></i>
          <p class="font-semibold text-sm mt-1 text-[#2C1810]">Mini</p>
          <p class="text-[10px] text-[#6B5B50]">Rs 85 base</p>
        </div>
        <div class="vehicle-card min-w-[100px] bg-white border border-[#EAE0D5] rounded-xl p-3 text-center cursor-pointer transition-all" data-vehicle="sedan" data-base="120" data-perkm="16">
          <i data-lucide="car-front" class="w-6 h-6 mx-auto text-[#2C1810]"></i>
          <p class="font-semibold text-sm mt-1 text-[#2C1810]">Sedan</p>
          <p class="text-[10px] text-[#6B5B50]">Rs 120 base</p>
        </div>
        <div class="vehicle-card min-w-[100px] bg-white border border-[#EAE0D5] rounded-xl p-3 text-center cursor-pointer transition-all" data-vehicle="suv" data-base="170" data-perkm="20">
          <i data-lucide="truck" class="w-6 h-6 mx-auto text-[#D4A373]"></i>
          <p class="font-semibold text-sm mt-1 text-[#2C1810]">SUV</p>
          <p class="text-[10px] text-[#6B5B50]">Rs 170 base</p>
        </div>
      </div>
    </div>

    <!-- Fare Estimate Card -->
    <div class="mx-4 mt-4 bg-gradient-to-r from-white to-[#FFF9F5] rounded-xl border border-[#EAE0D5] p-4 shadow-sm">
      <div class="flex justify-between items-center">
        <span class="text-[#2C1810] text-sm font-semibold">Estimated fare</span>
        <span class="text-xs bg-[#FFE66D]/30 px-2 py-0.5 rounded-full">incl. taxes</span>
      </div>
      <div class="mt-2">
        <span id="fareAmount" class="text-2xl font-bold text-[#FF6B6B]">Rs 133</span>
        <span id="distanceHint" class="text-xs text-[#6B5B50] ml-1"></span>
      </div>
      <div class="mt-3 flex text-xs text-[#6B5B50] justify-between border-t border-[#EAE0D5] pt-2">
        <span>⚡ Base fare</span>
        <span id="baseFareSpan">Rs 85</span>
        <span>➕ Distance</span>
        <span id="distFareSpan">Rs 48</span>
      </div>
    </div>

    <!-- Book Button -->
    <div class="px-4 mt-4 mb-6">
      <button id="bookBtn" class="w-full bg-[#FF6B6B] hover:bg-[#ff5252] py-3 rounded-xl text-white font-bold text-base shadow-lg active:scale-95 transition-all">
        Book Now
      </button>
    </div>

    <!-- footer -->
    <div class="text-center text-[10px] text-[#8B7A6E] pb-4">
      <i data-lucide="shield-check" class="w-3 h-3 inline mr-1"></i> 24/7 support & insured rides
    </div>
  </div>

  <script>
    // --------------------------------------------------------------
    // SPLASH SCREEN: stay 2 seconds, then move logo without stretching
    // --------------------------------------------------------------
    const splash = document.getElementById('splash');
    const splashLogo = document.getElementById('splashLogo');
    const headerLogoArea = document.getElementById('headerLogoArea');
    const mainContent = document.getElementById('mainContent');

    // Wait 2 seconds, then start animation
    setTimeout(() => {
      // Get positions
      const splashRect = splashLogo.getBoundingClientRect();
      const headerRect = headerLogoArea.getBoundingClientRect();

      // Compute uniform scale based on width (preserve aspect ratio)
      const targetWidth = headerRect.width;
      const currentWidth = splashRect.width;
      const scale = targetWidth / currentWidth;

      // Calculate translation to move center of splash logo to center of header logo area
      const deltaX = (headerRect.left + headerRect.width / 2) - (splashRect.left + splashRect.width / 2);
      const deltaY = (headerRect.top + headerRect.height / 2) - (splashRect.top + splashRect.height / 2);

      // Apply transform (translate then scale uniformly)
      splashLogo.style.transform = `translate(${deltaX}px, ${deltaY}px) scale(${scale})`;
      splashLogo.style.transition = 'transform 0.7s cubic-bezier(0.2, 0.9, 0.4, 1.1), opacity 1s';
      splashLogo.style.opacity = '0';

      // After animation, hide splash and show main content
      setTimeout(() => {
        splash.classList.add('hide');
        mainContent.classList.add('visible');
        setTimeout(() => {
          splash.style.display = 'none';
        }, 600);
      }, 800);
    }, 1500); // 2 seconds delay

    // --------------------------------------------------------------
    // Initialize Lucide Icons & Map functionality
    // --------------------------------------------------------------
    setTimeout(() => {
      lucide.createIcons();
    }, 100);

    // --- Burger Menu Toggle ---
    const menuBtn = document.getElementById('menuBtn');
    const dropdown = document.getElementById('dropdownMenu');
    if (menuBtn && dropdown) {
      menuBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        dropdown.classList.toggle('hidden');
      });
      document.addEventListener('click', (event) => {
        if (!menuBtn.contains(event.target) && !dropdown.contains(event.target)) {
          dropdown.classList.add('hidden');
        }
      });
    }

    // --- Leaflet Map Setup ---
    let map, currentRoute = null,
      pickupLatLng = null,
      dropLatLng = null;

    function initMap() {
      map = L.map('map').setView([28.6139, 77.2090], 13);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
      }).addTo(map);
      refreshRouteFromInputs();
    }

    function geocodeAddress(address, callback) {
      fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}&limit=1`)
        .then(res => res.json())
        .then(data => {
          if (data && data.length) {
            callback({
              lat: parseFloat(data[0].lat),
              lng: parseFloat(data[0].lon)
            });
          } else {
            alert(`Location not found: ${address}`);
            callback(null);
          }
        })
        .catch(err => {
          console.error(err);
          // alert("Geocoding error");
          callback(null);
        });
    }

    function updateFareAndDistance() {
      if (!pickupLatLng || !dropLatLng) return;
      const R = 6371;
      const dLat = (dropLatLng.lat - pickupLatLng.lat) * Math.PI / 180;
      const dLon = (dropLatLng.lng - pickupLatLng.lng) * Math.PI / 180;
      const a = Math.sin(dLat / 2) ** 2 + Math.cos(pickupLatLng.lat * Math.PI / 180) * Math.cos(dropLatLng.lat * Math.PI / 180) * Math.sin(dLon / 2) ** 2;
      const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
      const distanceKm = R * c;
      const activeCard = document.querySelector('.vehicle-card.active');
      const base = parseInt(activeCard.dataset.base);
      const perKm = parseInt(activeCard.dataset.perkm);
      const distanceCost = Math.round(perKm * distanceKm);
      const total = base + distanceCost;
      document.getElementById('fareAmount').innerText = `Rs ${total}`;
      document.getElementById('baseFareSpan').innerHTML = `Rs ${base}`;
      document.getElementById('distFareSpan').innerHTML = `Rs ${distanceCost}`;
      document.getElementById('distanceHint').innerHTML = `for ${distanceKm.toFixed(1)} km`;
      return distanceKm;
    }

    function drawRoute() {
      if (currentRoute) map.removeControl(currentRoute);
      if (pickupLatLng && dropLatLng) {
        currentRoute = L.Routing.control({
          waypoints: [L.latLng(pickupLatLng.lat, pickupLatLng.lng), L.latLng(dropLatLng.lat, dropLatLng.lng)],
          routeWhileDragging: true,
          showAlternatives: false,
          lineOptions: {
            styles: [{
              color: '#FF6B6B',
              weight: 4
            }]
          },
          addWaypoints: false,
          fitSelectedRoutes: false
        }).addTo(map);
        const bounds = L.latLngBounds([pickupLatLng, dropLatLng]);
        map.fitBounds(bounds, {
          padding: [40, 40]
        });
        updateFareAndDistance();
      }
    }

    function refreshRouteFromInputs() {
      const pickupAddr = document.getElementById('pickupInput').value;
      const dropAddr = document.getElementById('dropInput').value;
      if (!pickupAddr || !dropAddr) return;
      geocodeAddress(pickupAddr, (pCoord) => {
        if (pCoord) {
          pickupLatLng = pCoord;
          geocodeAddress(dropAddr, (dCoord) => {
            if (dCoord) {
              dropLatLng = dCoord;
              drawRoute();
            }
          });
        }
      });
    }

    // Event listeners
    document.addEventListener('DOMContentLoaded', () => {
      const pickupInput = document.getElementById('pickupInput');
      const dropInput = document.getElementById('dropInput');
      const swapBtn = document.getElementById('swapBtn');
      const bookBtn = document.getElementById('bookBtn');
      const vehicleCards = document.querySelectorAll('.vehicle-card');

      if (pickupInput) pickupInput.addEventListener('change', refreshRouteFromInputs);
      if (dropInput) dropInput.addEventListener('change', refreshRouteFromInputs);
      if (swapBtn) {
        swapBtn.addEventListener('click', () => {
          const pickupVal = pickupInput.value;
          const dropVal = dropInput.value;
          pickupInput.value = dropVal;
          dropInput.value = pickupVal;
          const temp = pickupLatLng;
          pickupLatLng = dropLatLng;
          dropLatLng = temp;
          if (pickupLatLng && dropLatLng) drawRoute();
          else refreshRouteFromInputs();
        });
      }

      vehicleCards.forEach(card => {
        card.addEventListener('click', function() {
          vehicleCards.forEach(c => {
            c.classList.remove('active', 'border-2', 'border-[#FF6B6B]');
            c.classList.add('border', 'border-[#EAE0D5]');
          });
          this.classList.add('active', 'border-2', 'border-[#FF6B6B]');
          this.classList.remove('border', 'border-[#EAE0D5]');
          updateFareAndDistance();
        });
      });

      if (bookBtn) {
        bookBtn.addEventListener('click', () => {
          if (!pickupLatLng || !dropLatLng) {
            alert("Please select both pickup and drop locations.");
            return;
          }
          const activeVehicle = document.querySelector('.vehicle-card.active p.font-semibold').innerText;
          const fare = document.getElementById('fareAmount').innerText;
          alert(`✅ ${activeVehicle} booked!\nFrom: ${pickupInput.value}\nTo: ${dropInput.value}\nFare: ${fare}\n\nDriver is on the way.`);
        });
      }

      // Initialize map after DOM
      initMap();
    });
  </script>
</body>

</html>