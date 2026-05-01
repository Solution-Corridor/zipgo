<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>All Cities - ZipGo</title>
  <meta name="description" content="Browse all cities where ZipGo provides services">
  @include('includes.header_links')
  <style>
    .cities-page {
      max-width: 1280px;
      margin: 0 auto;
      padding: 2rem 1.5rem;
    }

    .page-header {
      text-align: center;
      margin-bottom: 2rem;
    }

    .page-header h1 {
      font-size: 2rem;
      font-weight: 700;
      color: #1f2937;
    }

    .page-header p {
      color: #6b7280;
    }

    .cities-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 1.8rem;
    }

    .city-card {
      background: #ffffff;
      border-radius: 16px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      overflow: hidden;
      transition: transform 0.2s, box-shadow 0.2s;
      border: 1px solid #eef2f6;
      text-decoration: none;
      color: inherit;
      display: block;
      opacity: 0;
      transform: translateY(20px);
      animation: fadeInUp 0.4s ease forwards;
    }

    @keyframes fadeInUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .city-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
    }

    .city-img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      background-color: #f3f4f6;
    }

    .city-content {
      padding: 1.2rem;
    }

    .city-name {
      font-size: 1.25rem;
      font-weight: 600;
      color: #111827;
      margin-bottom: 0.5rem;
    }

    .city-detail {
      font-size: 0.9rem;
      color: #4b5563;
      line-height: 1.5;
      margin-bottom: 1rem;
      display: -webkit-box;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    .btn-view {
      display: inline-block;
      background: #1B2534;
      color: white;
      padding: 0.5rem 1rem;
      border-radius: 40px;
      text-decoration: none;
      font-weight: 500;
      font-size: 0.85rem;
      transition: background 0.2s;
    }

    .btn-view:hover {
      background: #151f2d;
    }

    .see-more-container {
      text-align: center;
      margin-top: 2.5rem;
    }

    .btn-see-more {
      background: transparent;
      border: 2px solid #1B2534;
      color: #1B2534;
      padding: 0.7rem 2rem;
      border-radius: 40px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s;
    }

    .btn-see-more:hover {
      background: #1B2534;
      color: white;
    }

    .loader {
      display: none;
      justify-content: center;
      margin: 20px 0;
    }

    .spinner {
      width: 40px;
      height: 40px;
      border: 4px solid #f3f3f3;
      border-top: 4px solid #1B2534;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }

    .empty-state {
      text-align: center;
      padding: 3rem;
      background: white;
      border-radius: 16px;
      color: #6c757d;
    }
  </style>
</head>

<body>
  @include('includes.navbar')

  <div class="cities-page mt-5">
    <div class="page-header">
      <h1>Our Service Cities</h1>
      <p>Find expert services in your city</p>
    </div>

    <div class="cities-grid" id="citiesGrid">
      <!-- Cities will be loaded here dynamically -->
    </div>

    <div class="loader" id="loader">
      <div class="spinner"></div>
    </div>

    <div class="see-more-container" id="seeMoreContainer">
      <button class="btn-see-more" id="seeMoreBtn">See More</button>
    </div>
  </div>

  @include('includes.footer')
  @include('includes.footer_links')

  <script>
    let currentOffset = 0;
    let isLoading = false;
    let hasMore = true;

    const citiesGrid = document.getElementById('citiesGrid');
    const seeMoreBtn = document.getElementById('seeMoreBtn');
    const seeMoreContainer = document.getElementById('seeMoreContainer');
    const loader = document.getElementById('loader');

    async function loadCities(offset) {
      if (isLoading || !hasMore) return;
      isLoading = true;
      loader.style.display = 'flex';

      try {
        // *** FIXED URL: use your route name or direct path ***
        const response = await fetch(`/areas/load-more?offset=${offset}`);

        if (!response.ok) {
          throw new Error(`HTTP ${response.status}`);
        }

        const data = await response.json();
        console.log('Loaded cities:', data); // Debug

        if (data.cities && data.cities.length > 0) {
          appendCities(data.cities);
          currentOffset = data.nextOffset;
          hasMore = data.hasMore;

          if (!hasMore) {
            seeMoreBtn.textContent = 'All Cities Loaded';
            seeMoreBtn.disabled = true;
            seeMoreBtn.style.opacity = '0.6';
            seeMoreBtn.style.cursor = 'default';
          }
        } else {
          // No cities at all
          if (offset === 0) {
            citiesGrid.innerHTML = '<div class="empty-state">No cities available yet.</div>';
          }
          seeMoreContainer.style.display = 'none';
          hasMore = false;
        }
      } catch (error) {
        console.error('Error loading cities:', error);
        citiesGrid.innerHTML = `<div class="empty-state">Error loading cities: ${error.message}</div>`;
      } finally {
        isLoading = false;
        loader.style.display = 'none';
      }
    }
    window.cityImageBaseUrl = "{{ asset('uploads/cities') }}/";

    function appendCities(cities) {
    cities.forEach(city => {
        const cityCard = document.createElement('a');
        cityCard.href = `/city/${city.slug}`;
        cityCard.className = 'city-card';

        let imgHtml = '';
        if (city.pic) {
            // If pic already contains 'uploads/cities/' then use asset directly
            let imgUrl;
            if (city.pic.startsWith('uploads/')) {
                imgUrl = "{{ asset('') }}" + city.pic;  // e.g., /uploads/cities/...
            } else {
                imgUrl = "{{ asset('uploads/cities/') }}" + city.pic;
            }
            imgHtml = `<img src="${imgUrl}" class="city-img" alt="${city.name}" 
                         onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22%3E%3Crect width=%22100%22 height=%22100%22 fill=%22%23e5e7eb%22/%3E%3Ctext x=%2250%22 y=%2255%22 text-anchor=%22middle%22 fill=%22%239ca3af%22%3E🏙%3C/text%3E%3C/svg%3E'">`;
        } else {
            imgHtml = `<div class="city-img" style="background:#e5e7eb;display:flex;align-items:center;justify-content:center;">
                           <span style="font-size:3rem;">🏙️</span>
                       </div>`;
        }

        cityCard.innerHTML = `
            ${imgHtml}
            <div class="city-content">
                <div class="city-name">${escapeHtml(city.name)}</div>
                <div class="city-detail">${escapeHtml(city.short_detail || 'Explore services in this city')}</div>
                <span class="btn-view">Explore →</span>
            </div>
        `;
        citiesGrid.appendChild(cityCard);
    });
}

    function escapeHtml(str) {
      if (!str) return '';
      return str.replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
      });
    }

    // Load first 6 cities on page load
    loadCities(0);

    // See More button click
    seeMoreBtn.addEventListener('click', () => {
      if (hasMore && !isLoading) {
        loadCities(currentOffset);
      }
    });
  </script>
</body>

</html>