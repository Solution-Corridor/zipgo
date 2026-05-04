<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Open Graph / Social Media -->
  <meta property="og:title" content="ZipGo - Book Local Services in Pakistan">
  <meta property="og:description" content="ZipGo is Pakistan's trusted marketplace to book trusted professionals for all home, repair, cleaning, beauty &amp; other local services. Fast, reliable &amp; affordable.">

  @include('includes.header_links')

  <title>ZipGo - Book Trusted Local Services in Pakistan</title>

  <meta name="description" content="ZipGo is Pakistan's leading marketplace to instantly book verified professionals for Plumbing, Electrical, Cleaning, AC Repair, Beauty, Painting, and 100+ other home &amp; local services.">

  <meta name="keywords" content="ZipGo, book services pakistan, home services, plumbing service, electrician near me, cleaning service, ac repair, beauty services, hire professional, local services pakistan">

  <!-- Structured Data - Organization -->
  <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "ZipGo",
      "url": "{{ url('/') }}",
      "logo": "{{ asset('assets/images/zipgo-logo.png') }}",
      "description": "ZipGo is a leading online marketplace in Pakistan that connects customers with verified service providers for home, repair, cleaning, beauty and other local services.",
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+971543041994",
        "contactType": "Customer Service",
        "areaServed": "PK",
        "availableLanguage": ["English", "Urdu"]
      },
      "sameAs": [
        "https://www.facebook.com/zipgo",
        "https://www.instagram.com/zipgo.pk",
        "https://www.tiktok.com/@zipgo"
      ]
    }
  </script>

  <!-- Structured Data - WebSite -->
  <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebSite",
      "url": "{{ url('/') }}",
      "name": "ZipGo",
      "alternateName": "ZipGo Pakistan",
      "potentialAction": {
        "@type": "SearchAction",
        "target": {
          "@type": "EntryPoint",
          "urlTemplate": "{{ url('/search?q={search_term_string}') }}"
        },
        "query-input": "required name=search_term_string"
      }
    }
  </script>

  <!-- Additional Styles for new horizontal service cards -->
  <style>
    /* ===== FULL CSS FOR THE PAGE WITH HEIGHT FIX AND DESKTOP CENTERING ===== */

    /* ===== BASE & UTILITY STYLES ===== */
    .services-section {
      margin: 0 auto;
      padding: 20px;
      margin-top: 50px;
      background: #0f2027;
      background: linear-gradient(0deg, #0f2027 0%, #2c5364 100%);
      min-height: auto;
      height: auto;
    }

    /* Header (Category + View All) */
    .services-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
      flex-wrap: wrap;
      gap: 12px;
    }

    .services-header h2 {
      font-size: 24px;
      font-weight: 600;
      color: #fff;
    }

    @media (max-width: 480px) {
      .services-header h2 {
        font-size: 17px;
      }

      .view-all-btn {
        padding: 4px 12px !important;
        font-size: 10px !important;
      }
    }

    .view-all-btn {
      background: #eef2f6;
      color: #0f2027;
      border: none;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      padding: 8px 20px;
      border-radius: 8px;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .view-all-btn:hover {
      background: #ffffff;
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    /* Horizontal scrolling services */
    .services-flex {
      display: flex;
      flex-direction: row;
      gap: 20px;
      justify-content: flex-start;
      overflow-x: auto;
      overflow-y: hidden;
      scroll-behavior: smooth;
      -webkit-overflow-scrolling: touch;
      scrollbar-width: thin;
      padding-bottom: 2px;
      margin-bottom: 0;
      height: auto;
      scroll-snap-type: x mandatory;
    }

    .services-flex::-webkit-scrollbar {
      height: 5px;
    }

    .services-flex::-webkit-scrollbar-track {
      background: rgba(255, 255, 255, 0.2);
      border-radius: 10px;
    }

    .services-flex::-webkit-scrollbar-thumb {
      background: #ff5722;
      border-radius: 10px;
    }

    /* Category Item */
    .services-item {
      flex: 0 0 auto;
      width: 140px;
      text-align: center;
      cursor: pointer;
      transition: transform 0.2s;
      margin-bottom: 0;
      scroll-snap-align: start;
    }

    .services-item:hover {
      transform: translateY(-4px);
    }

    .services-img {
      width: 120px;
      height: 120px;
      overflow: hidden;
      border-radius: 10px;
      margin: 0 auto 12px;
      border: 4px solid #fff;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .services-img img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .services-item p {
      font-size: 14px;
      color: #fff;
      font-weight: 500;
      margin-bottom: 0;
      line-height: 1.3;
    }

    /* Tablet */
    @media (max-width: 768px) {
      .services-item {
        width: 110px;
      }

      .services-img {
        width: 90px;
        height: 90px;
      }

      .services-flex {
        gap: 16px;
        padding-left: 4px;
        padding-right: 4px;
        padding-bottom: 2px;
      }
    }

    /* Mobile */
    @media (max-width: 480px) {
      .services-item {
        width: 95px;
      }

      .services-img {
        width: 75px;
        height: 75px;
      }

      .services-item p {
        font-size: 12px;
      }

      .services-flex {
        gap: 12px;
        padding-bottom: 2px;
      }

      .services-section {
        padding: 16px;
      }
    }

    /* Desktop Centering */
    @media (min-width: 992px) {
      .services-flex {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 160px));
        justify-content: center;
        gap: 24px;
        overflow-x: visible;
        padding-bottom: 0;
        scroll-snap-type: none;
      }

      .services-item {
        width: auto;
        flex: none;
      }

      .services-img {
        width: 100%;
        max-width: 140px;
        height: auto;
        aspect-ratio: 1 / 1;
        margin-left: auto;
        margin-right: auto;
      }

      .services-section {
        padding: 30px 40px;
      }
    }

    @media (min-width: 1400px) {
      .services-flex {
        grid-template-columns: repeat(auto-fit, minmax(160px, 180px));
        gap: 30px;
      }
    }

    /* New Horizontal Service Cards */
    .all-services-section {
      background: #f8fafc;
    }

    .section-heading {
      font-size: 28px;
      font-weight: 700;
      color: #0f2027;
      position: relative;
      display: inline-block;
      margin-bottom: 0.5rem;
      letter-spacing: -0.3px;
    }

    .section-heading:after {
      content: '';
      display: block;
      width: 60px;
      height: 4px;
      background: linear-gradient(90deg, #ff5722, #bd8802);
      border-radius: 4px;
      margin-top: 8px;
    }

    .service-horizontal-card {
      display: flex;
      align-items: center;
      gap: 14px;
      background: #ffffff;
      border-radius: 10px;
      padding: 12px 16px;
      transition: all 0.3s cubic-bezier(0.2, 0, 0, 1);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
      border: 1px solid #eef2f6;
      height: 100%;
      cursor: pointer;
    }

    .service-horizontal-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 30px -10px rgba(0, 0, 0, 0.12);
      border-color: #ffd1c0;
    }

    .service-img-left {
      width: 64px;
      height: 64px;
      flex-shrink: 0;
      border-radius: 8px;
      overflow: hidden;
      background: #f1f5f9;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .service-img-left img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.2s ease;
    }

    .service-horizontal-card:hover .service-img-left img {
      transform: scale(1.02);
    }

    .service-info-right .service-name {
      font-size: 1rem;
      font-weight: 600;
      color: #1e293b;
      margin: 0 0 4px 0;
      line-height: 1.3;
    }

    .service-horizontal-card:hover .service-name {
      color: #ff5722;
    }

    .service-card-link {
      text-decoration: none;
      display: block;
      height: 100%;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      .service-img-left {
        width: 54px;
        height: 54px;
      }

      .service-info-right .service-name {
        font-size: 0.9rem;
      }

      .service-horizontal-card {
        padding: 10px 12px;
        gap: 10px;
      }
    }

    @media (max-width: 576px) {
      .service-img-left {
        width: 48px;
        height: 48px;
      }

      .service-info-right .service-name {
        font-size: 0.85rem;
      }
    }

    /* Other utilities */
    .experts-grid {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
    }

    .section-title {
      font-size: 28px;
      font-weight: 700;
      margin-bottom: 20px;
      text-align: center;
    }

    /* ===== CAROUSEL BUTTONS (MOBILE ONLY) ===== */
    .carousel-btn {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      width: 36px;
      height: 36px;
      background: rgba(0, 0, 0, 0.6);
      backdrop-filter: blur(4px);
      border: none;
      border-radius: 50%;
      color: white;
      font-size: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      z-index: 10;
      transition: all 0.2s;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .carousel-btn:hover {
      background: #ff5722;
      transform: translateY(-50%) scale(1.05);
    }

    .carousel-btn.disabled {
      opacity: 0.4;
      cursor: not-allowed;
      pointer-events: none;
    }

    .carousel-prev {
      left: 4px;
    }

    .carousel-next {
      right: 4px;
    }

    @media (max-width: 768px) {
      .carousel-btn {
        width: 32px;
        height: 32px;
        font-size: 18px;
      }
    }

    @media (max-width: 480px) {
      .carousel-btn {
        width: 28px;
        height: 28px;
        font-size: 14px;
      }
    }

    /* Desktop hide buttons */
    @media (min-width: 992px) {
      .carousel-btn {
        display: none;
      }
    }

    .services-carousel-wrapper {
      position: relative;
    }
  </style>
</head>

<body>
  <!-- Navbar Start -->
  @include('includes.navbar')
  <!-- Navbar End -->

  <!-- FIRST SERVICES SECTION with carousel wrapper -->
  <section class="services-section">
    <div class="services-header">
      <h1 class="text-light fs-3">Explore The Services</h1>
      <a href="/services">
        <button class="view-all-btn">View More</button>
      </a>
    </div>

    <!-- Added wrapper for carousel buttons positioning -->
    <div class="services-carousel-wrapper">
      <div class="services-flex" id="servicesFlex">
        @foreach ($priority_services as $service)
        <div class="services-item">
          <a href="/service/{{ $service->slug }}">
            <div class="services-img">
              <img src="{{ $service->pic }}"
                onerror="this.onerror=null; this.src='/assets/images/favicon.png';"
                alt="{{ $service->name }}"
                title="{{ $service->name }}">
            </div>
            <p>{{ $service->name }}</p>
          </a>
        </div>
        @endforeach
      </div>
      <!-- Carousel buttons (will be shown only on mobile via CSS) -->
      <button class="carousel-btn carousel-prev" id="carouselPrev" aria-label="Previous"><i class="fas fa-chevron-left"></i></button>
      <button class="carousel-btn carousel-next" id="carouselNext" aria-label="Next"><i class="fas fa-chevron-right"></i></button>
    </div>
  </section>

  <!-- ALL SERVICES HORIZONTAL CARDS SECTION -->
  <section class="all-services-section py-5">
    <div class="container">
      <div class="row mb-3">
        <div class="col-12">
          <h2 class="section-heading">All Professional Services</h2>
          <p class="text-muted">Discover trusted experts for every need — from home repairs to beauty & wellness</p>
        </div>
      </div>

      <div class="row g-2">
        @forelse($services ?? [] as $service)
        <div class="col-12 col-sm-6 col-md-3">
          <a href="/service/{{ $service->slug }}" class="service-card-link">
            <div class="service-horizontal-card">
              <div class="service-img-left">
                <img src="{{ $service->pic }}"
                  alt="{{ $service->name }}"
                  onerror="this.onerror=null; this.src='/assets/images/favicon.png';">
              </div>
              <div class="service-info-right">
                <h5 class="service-name">{{ $service->name }}</h5>
              </div>
            </div>
          </a>
        </div>
        @endforeach
      </div>

      <div class="row mt-5">
        <div class="col-12 text-center">
          <a href="/services"
            class="view-all-btn"
            style="background: linear-gradient(135deg, #2c5364, #0f2027); box-shadow: 0 8px 20px rgba(0,0,0,0.1);">
            Explore Complete Service List →
          </a>
        </div>
      </div>
    </div>
  </section>

  @include('includes.city-card')

  <!-- Experts Section -->
  <section class="container-fluid">
    <div class="products-grid-sm">
      <section class="expert-section">
        <h2 class="section-title">Meet Our Experts</h2>
        <div class="experts-grid">
          @foreach ($experts as $expert)
          <div class="col-md-3 col-sm-6 col-12">
            @include('includes.experts_card')
          </div>
          @endforeach
        </div>
      </section>
    </div>
  </section>

  <!-- Footer -->
  @include('includes.footer')
  @include('includes.footer_links')

  <!-- Font Awesome for icons (if not already in header_links) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Image fallback
      const serviceImages = document.querySelectorAll('.service-img-left img');
      serviceImages.forEach(img => {
        img.addEventListener('error', function() {
          if (!this.dataset.fallbackSet) {
            this.src = '/assets/images/favicon.png';
            this.dataset.fallbackSet = 'true';
          }
        });
      });

      // Accessibility for scrollable area (original)
      const servicesFlex = document.getElementById('servicesFlex');
      if (servicesFlex && window.innerWidth <= 768) {
        servicesFlex.setAttribute('aria-label', 'Horizontal scrollable services');
      }

      // ========== CAROUSEL WITH AUTO-SLIDE ==========
      const flexContainer = document.getElementById('servicesFlex');
      const prevBtn = document.getElementById('carouselPrev');
      const nextBtn = document.getElementById('carouselNext');

      if (!flexContainer || !prevBtn || !nextBtn) return;

      let autoSlideInterval = null;
      let autoSlideActive = false;
      let pauseTimeout = null;
      const AUTO_SLIDE_DELAY = 3000; // 3 seconds
      const RESUME_DELAY = 5000; // Resume after 5 seconds of inactivity

      // Function to update button disabled state
      function updateButtonsState() {
        if (window.innerWidth >= 992) return;
        const maxScrollLeft = flexContainer.scrollWidth - flexContainer.clientWidth;
        const currentScroll = flexContainer.scrollLeft;
        prevBtn.classList.toggle('disabled', currentScroll <= 5);
        nextBtn.classList.toggle('disabled', maxScrollLeft - currentScroll <= 5);
      }

      // Scroll to next item (with loop)
      function scrollToNext() {
        if (window.innerWidth >= 992) return; // only on mobile
        const items = flexContainer.querySelectorAll('.services-item');
        if (items.length === 0) return;

        const firstItem = items[0];
        const itemWidth = firstItem.offsetWidth;
        const gap = parseFloat(getComputedStyle(flexContainer).gap) || 20;
        const scrollAmount = itemWidth + gap;
        const maxScroll = flexContainer.scrollWidth - flexContainer.clientWidth;
        let newScrollLeft = flexContainer.scrollLeft + scrollAmount;

        // If at the end or beyond, loop back to start
        if (newScrollLeft >= maxScroll - 5) {
          newScrollLeft = 0;
        }

        flexContainer.scrollTo({
          left: newScrollLeft,
          behavior: 'smooth'
        });
        setTimeout(updateButtonsState, 200);
      }

      // Scroll to previous item (with loop)
      function scrollToPrev() {
        if (window.innerWidth >= 992) return;
        const items = flexContainer.querySelectorAll('.services-item');
        if (items.length === 0) return;

        const firstItem = items[0];
        const itemWidth = firstItem.offsetWidth;
        const gap = parseFloat(getComputedStyle(flexContainer).gap) || 20;
        const scrollAmount = itemWidth + gap;
        let newScrollLeft = flexContainer.scrollLeft - scrollAmount;
        const maxScroll = flexContainer.scrollWidth - flexContainer.clientWidth;

        // If at the beginning, loop to end
        if (newScrollLeft <= 5) {
          newScrollLeft = maxScroll;
        }

        flexContainer.scrollTo({
          left: newScrollLeft,
          behavior: 'smooth'
        });
        setTimeout(updateButtonsState, 200);
      }

      // Start auto-slide (only if on mobile)
      function startAutoSlide() {
        if (autoSlideInterval) clearInterval(autoSlideInterval);
        if (window.innerWidth >= 992) return;
        autoSlideActive = true;
        autoSlideInterval = setInterval(() => {
          if (autoSlideActive && window.innerWidth < 992) {
            scrollToNext();
          }
        }, AUTO_SLIDE_DELAY);
      }

      // Stop auto-slide and schedule restart after RESUME_DELAY
      function pauseAutoSlide() {
        if (!autoSlideActive) return;
        if (autoSlideInterval) {
          clearInterval(autoSlideInterval);
          autoSlideInterval = null;
        }
        autoSlideActive = false;

        // Clear any existing resume timeout
        if (pauseTimeout) clearTimeout(pauseTimeout);
        // Resume after inactivity
        pauseTimeout = setTimeout(() => {
          if (window.innerWidth < 992) {
            startAutoSlide();
          }
        }, RESUME_DELAY);
      }

      // Reset pause timer (call on user interaction)
      function resetAutoSlidePause() {
        if (window.innerWidth >= 992) return;
        if (!autoSlideActive) {
          // If already paused, restart the resume timer
          if (pauseTimeout) clearTimeout(pauseTimeout);
          pauseTimeout = setTimeout(() => {
            if (window.innerWidth < 992) {
              startAutoSlide();
            }
          }, RESUME_DELAY);
        } else {
          // If active, pause now
          pauseAutoSlide();
        }
      }

      // Event listeners for user interaction
      prevBtn.addEventListener('click', () => {
        if (!prevBtn.classList.contains('disabled')) {
          scrollToPrev();
          resetAutoSlidePause();
        }
      });

      nextBtn.addEventListener('click', () => {
        if (!nextBtn.classList.contains('disabled')) {
          scrollToNext();
          resetAutoSlidePause();
        }
      });

      // Pause on touch/mouse interaction with the carousel area
      const carouselWrapper = document.querySelector('.services-carousel-wrapper');
      if (carouselWrapper) {
        ['touchstart', 'mousedown'].forEach(eventType => {
          carouselWrapper.addEventListener(eventType, () => {
            resetAutoSlidePause();
          });
        });
        // Also pause on scroll start
        flexContainer.addEventListener('scroll', () => {
          resetAutoSlidePause();
        });
      }

      // Update button states on scroll
      flexContainer.addEventListener('scroll', updateButtonsState);

      // Handle resize: restart or stop auto-slide based on viewport
      window.addEventListener('resize', function() {
        updateButtonsState();
        if (window.innerWidth >= 992) {
          // Desktop: stop auto-slide
          if (autoSlideInterval) {
            clearInterval(autoSlideInterval);
            autoSlideInterval = null;
          }
          autoSlideActive = false;
          if (pauseTimeout) clearTimeout(pauseTimeout);
        } else {
          // Mobile: restart if not active
          if (!autoSlideActive && !autoSlideInterval) {
            startAutoSlide();
          }
        }
      });

      // Initial setup
      updateButtonsState();
      // Start auto-slide only on mobile
      if (window.innerWidth < 992) {
        startAutoSlide();
      }

      // Also update on load (images may shift layout)
      window.addEventListener('load', function() {
        updateButtonsState();
        if (window.innerWidth < 992 && !autoSlideActive && !autoSlideInterval) {
          startAutoSlide();
        }
      });
    });
  </script>
</body>

</html>