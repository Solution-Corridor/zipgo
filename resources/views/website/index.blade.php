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

/* Section base - fixed height issue */
.services-section {
  margin: 0 auto;
  padding: 20px;
  margin-top: 50px;
  background: #0f2027;
  background: linear-gradient(0deg, #0f2027 0%, #2c5364 100%);
  min-height: auto;        /* FIX: removed fixed min-height to avoid excess space */
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
  background: linear-gradient(135deg, #ff5722, #BD8802);
  color: #fff;
  box-shadow: 0 15px 25px rgba(238, 39, 55, 0.3);
  border: none;
  padding: 8px 20px;
  border-radius: 8px;
  font-size: 14px;
  cursor: pointer;
  transition: background 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
  will-change: transform, box-shadow;
}

.view-all-btn:hover {
  transform: translateY(-5px);
  box-shadow: 0 20px 30px rgba(238, 39, 55, 0.5);
}

/* Horizontal scrolling services-flex - mobile first (left aligned, scrollable) */
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
  padding-bottom: 2px;     /* FIX: reduced bottom padding to minimize empty space */
  margin-bottom: 0;
  height: auto;            /* FIX: remove fixed height */
}

/* Custom scrollbar styling */
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

/* Tablet adjustments */
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

/* Mobile adjustments */
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

/* ===== DESKTOP CENTERING (min-width: 992px) ===== */
@media (min-width: 992px) {
  .services-flex {
    /* Switch to grid layout for perfect centering and wrapping */
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 160px));
    justify-content: center;
    gap: 24px;
    overflow-x: visible;   /* No horizontal scroll on desktop */
    padding-bottom: 0;
  }

  /* Remove fixed width from items – grid controls sizing */
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

  /* Optional: larger container padding for better look */
  .services-section {
    padding: 30px 40px;
  }
}

/* Large desktop (optional: increase max card width) */
@media (min-width: 1400px) {
  .services-flex {
    grid-template-columns: repeat(auto-fit, minmax(160px, 180px));
    gap: 30px;
  }
}

/* ===== NEW STYLES FOR HORIZONTAL SERVICE CARDS (image left + name) ===== */
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

/* Horizontal card styling */
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
  background: #ffffff;
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

.service-info-right {
  flex: 1;
}

.service-info-right .service-name {
  font-size: 1rem;
  font-weight: 600;
  color: #1e293b;
  margin: 0 0 4px 0;
  line-height: 1.3;
  transition: color 0.2s;
}

.service-horizontal-card:hover .service-name {
  color: #ff5722;
}

/* subtle service meta (optional) */
.service-category-badge {
  font-size: 0.7rem;
  color: #5b6e8c;
  background: #f1f5f9;
  display: inline-block;
  padding: 2px 8px;
  border-radius: 20px;
}

/* link reset */
.service-card-link {
  text-decoration: none;
  display: block;
  height: 100%;
}

/* grid spacing */
.all-services-section .row.g-4 {
  --bs-gutter-y: 1.5rem;
}

/* Responsive adjustments for service cards */
@media (max-width: 768px) {
  .service-img-left {
    width: 54px;
    height: 54px;
    border-radius: 14px;
  }
  .service-info-right .service-name {
    font-size: 0.9rem;
  }
  .service-horizontal-card {
    padding: 10px 12px;
    gap: 10px;
  }
  .service-img-left {
    border-radius: 5px;
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

/* Additional utility classes (experts section, footer, etc.) */
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

/* Ensure any leftover spacing issues are fixed */
.services-section:after,
.services-flex:after {
  display: none;
}
  </style>

</head>

<body>
  <!-- Navbar Start -->
  @include('includes.navbar')
  <!-- Navbar End -->

  <!-- FIRST SERVICES SECTION (priority services, horizontal scroll style) - FIXED for mobile -->
  <section class="services-section">
    <div class="services-header">
      <h1 class="text-light fs-3">Explore The Services</h1>
      <a href="/services"><button class="view-all-btn">View More</button></a>
    </div>

    <!-- services-flex now scrolls horizontally on mobile, and displays properly on desktop -->
    <div class="services-flex">
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
  </section>

  <!-- ========== NEW SERVICES LOOP: image left + service name, col-md-3 grid ========== -->
  <!-- This section appears right after the services-section as requested -->
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
                {{-- only service name as requested, but optional subtle hint can be added --}}
                {{-- <span class="service-category-badge">professional</span> --}}
              </div>
            </div>
          </a>
        </div>
        @endforeach
      </div>

      <div class="row mt-5">
        <div class="col-12 text-center">
          <a href="/services" class="view-all-btn" style="background: linear-gradient(135deg, #2c5364, #0f2027); box-shadow: 0 8px 20px rgba(0,0,0,0.1); display: inline-block; text-decoration: none;">Explore Complete Service List →</a>
        </div>
      </div>
    </div>
  </section>
  <!-- ========== END NEW SERVICES LOOP SECTION ========== -->

  @include('includes.city-card')

  <!-- Experts Section -->
  <section class="container-fluid">
    <div class="products-grid-sm">
      <section class="expert-section">
        <h2 class="section-title">Meet Our Experts</h2>
        <div class="experts-grid">
          @foreach ($experts as $expert)
          @include('includes.experts_card')
          @endforeach
        </div>
      </section>
    </div>
  </section>

  <!-- Footer -->
  @include('includes.footer')
  @include('includes.footer_links')

  {{-- Additional inline fallback script to handle any image broken links (optional) --}}
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // ensure all service images fallback gracefully
      const serviceImages = document.querySelectorAll('.service-img-left img');
      serviceImages.forEach(img => {
        img.addEventListener('error', function() {
          if (!this.dataset.fallbackSet) {
            this.src = '/assets/images/favicon.png';
            this.dataset.fallbackSet = 'true';
          }
        });
      });

      // Optional: Add smooth scroll hint to services-flex for better UX (if needed)
      const servicesFlex = document.querySelector('.services-flex');
      if (servicesFlex && window.innerWidth <= 768) {
        // add a subtle indicator that it's scrollable (better UX)
        servicesFlex.setAttribute('aria-label', 'Horizontal scrollable services');
      }
    });
  </script>
</body>

</html>