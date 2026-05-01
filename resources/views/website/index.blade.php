<!doctype html>
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

</head>

<body>
  <!-- Navbar Start -->
  @include('includes.navbar')
  <!-- Navbar End -->



  <style>
    /* Modern Hero Section */
    .feature-desk-static-hero {
      position: relative;
      margin-top: 60px;
      height: 550px;
      overflow: hidden;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
      /* border: 2px solid blue; */
    }

    .hero-background {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
    }

    .hero-image {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 1.2s cubic-bezier(0.33, 1, 0.68, 1);
    }

    .feature-desk-static-hero:hover .hero-image {
      transform: scale(1.08);
    }

    .hero-overlay {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(135deg, rgba(0, 0, 0, 0.85) 0%, rgba(0, 0, 0, 0.7) 50%, transparent 100%);
      z-index: 1;
    }

    .gradient-overlay {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(45deg, rgba(238, 39, 55, 0.15) 0%, rgba(255, 152, 0, 0.15) 100%);
      z-index: 2;
      mix-blend-mode: overlay;
    }

    .hero-content {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 550px;
      display: flex;
      align-items: center;
      padding: 0 10%;
      z-index: 3;
      /* border: 2px solid green; */
    }

    .content-wrapper {
      max-width: 650px;
      animation: fadeUp 0.8s ease-out;
      /* border: 2px solid red; */
    }

    .badge-tag {
      display: inline-block;
      background: linear-gradient(135deg, #ff5722, #BD8802);
      color: white;
      padding: 10px 24px;
      border-radius: 50px;
      font-size: 14px;
      font-weight: 700;
      letter-spacing: 1px;
      text-transform: uppercase;
      margin-bottom: 30px;
      box-shadow: 0 8px 20px rgba(238, 39, 55, 0.3);
      animation: pulse 2s infinite;
    }

    .big-gradient {
      display: block;
      font-size: 86px;
      font-weight: 900;
      line-height: 1;
      background: linear-gradient(135deg, #ffd700, #ff9800, #ff5722);
      background-clip: text;
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      text-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      margin-bottom: 15px;
    }

    .headline-text {
      display: block;
      font-size: 52px;
      font-weight: 800;
      color: white;
      line-height: 1.2;
      text-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
    }

    .subtitle {
      font-size: 22px;
      color: rgba(255, 255, 255, 0.95);
      line-height: 1.5;
      max-width: 500px;
      font-weight: 400;
      text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }

    .hero-buttons {
      display: flex;
      gap: 20px;
      margin-bottom: 20px;
    }

    .btn-primary,
    .btn-secondary {
      display: inline-flex;
      align-items: center;
      gap: 12px;
      padding: 20px 40px;
      border-radius: 50px;
      font-size: 18px;
      font-weight: 700;
      text-decoration: none;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
      overflow: hidden;
    }

    .btn-primary {
      background: linear-gradient(135deg, #ff5722, #BD8802);
      color: white;
      box-shadow: 0 15px 35px rgba(238, 39, 55, 0.4);
    }

    .btn-primary:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 40px rgba(238, 39, 55, 0.6);
    }

    .btn-primary::after {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: left 0.7s;
    }

    .btn-primary:hover::after {
      left: 100%;
    }

    .btn-secondary {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      color: white;
      border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .btn-secondary:hover {
      background: rgba(255, 255, 255, 0.2);
      border-color: white;
      transform: translateY(-3px);
    }

    .trust-badges {
      display: flex;
      gap: 30px;
      flex-wrap: wrap;
    }

    .trust-item {
      color: rgba(255, 255, 255, 0.9);
      font-size: 16px;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .hero-badge {
      position: absolute;
      bottom: 40px;
      right: 40px;
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      color: #BD8802;
      padding: 15px 25px;
      border-radius: 50px;
      font-weight: 800;
      font-size: 16px;
      z-index: 4;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
      display: flex;
      align-items: center;
      gap: 10px;
      animation: float 3s ease-in-out infinite;
    }

    .fire-icon {
      animation: fire 1s infinite alternate;
    }

    /* Animations */
    @keyframes fadeUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes pulse {

      0%,
      100% {
        transform: scale(1);
      }

      50% {
        transform: scale(1.05);
      }
    }

    @keyframes float {

      0%,
      100% {
        transform: translateY(0);
      }

      50% {
        transform: translateY(-10px);
      }
    }

    @keyframes fire {
      from {
        transform: scale(1);
      }

      to {
        transform: scale(1.2);
      }
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
      .feature-desk-static-hero {
        height: 400px;
        margin-top: 50px;
      }

      .hero-content {
        padding: 0 5%;
        justify-content: center;
        text-align: center;
        height: 450px;
      }

      .content-wrapper {
        margin-top: -120px;
        display: flex;
        flex-direction: column;
        align-items: center;
      }

      .badge-tag {
        font-size: 12px;
        padding: 8px 20px;
        margin-top: 5px;
        margin-bottom: 0;
      }

      .big-gradient {
        font-size: 56px;
        margin-bottom: 0;
      }

      .headline-text {
        font-size: 36px;
      }

      .subtitle {
        font-size: 18px;
      }

      .hero-buttons {
        flex-direction: column;
        gap: 15px;
        width: 100%;
        max-width: 300px;
      }

      .btn-primary,
      .btn-secondary {
        width: 100%;
        justify-content: center;
        padding: 18px 30px;
      }

      .trust-badges {
        display: none;
      }

      .hero-badge {
        bottom: 20px;
        right: 20px;
        padding: 12px 20px;
        font-size: 14px;
      }
    }

    @media (max-width: 480px) {
      .feature-desk-static-hero {
        height: 300px;
      }

      .big-gradient {
        font-size: 48px;
      }

      .headline-text {
        font-size: 32px;
      }

      .subtitle {
        font-size: 16px;
      }

      .hero-badge {
        position: relative;
        bottom: auto;
        right: auto;
        margin: 30px auto 0;
        width: fit-content;
      }
    }

    /* Smooth transitions */
    * {
      transition: all 0.3s ease;
    }
  </style>



  <!-- Categories Section -->

  <style>
    /* Section */
    .category-section {
      margin: 0 auto;
      padding: 20px;
      margin-top: 50px;
      background: #0f2027;
      background: linear-gradient(0deg, #0f2027 0%, #2c5364 100%);
    }

    /* Header (Category + View All) */
    .category-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .category-header h2 {
      font-size: 24px;
      font-weight: 600;
      color: #fff;
    }

    @media (max-width: 480px) {
      .category-header h2 {
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
      transition: background 0.3s ease,
        transform 0.3s ease,
        box-shadow 0.3s ease;
      will-change: transform, box-shadow;
    }

    .view-all-btn:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 30px rgba(238, 39, 55, 0.5);
    }

    /* Carousel Container */
    .carousel-wrapper {
      position: relative;
      overflow: hidden;
      border-radius: 12px;
      min-height: 160px;
      display: flex;
      align-items: center;
    }

    .carousel-track {
      display: flex;
      gap: 24px;
      padding: 10px 0;
      scroll-behavior: smooth;
      overflow-x: auto;
      scrollbar-width: none;
      /* Firefox */
    }

    .carousel-track::-webkit-scrollbar {
      display: none;
    }

    /* Chrome/Safari */

    /* Category Item */
    .category-item {
      flex: 0 0 auto;
      width: 140px;
      text-align: center;
      cursor: pointer;
      transition: transform 0.2s;
    }

    .category-item:hover {
      transform: translateY(-4px);
    }

    .category-img {
      width: 120px;
      height: 120px;
      overflow: hidden;
      border-radius: 10px;
      margin: 0 auto 12px;
      border: 4px solid #fff;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .category-img img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .category-item p {
      font-size: 14px;
      color: #fff;
      font-weight: 500;
    }

    /* Carousel Buttons */
    .carousel-btn {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: rgba(0, 0, 0, 0.5);
      color: white;
      border: none;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      font-size: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      z-index: 10;
      transition: all 0.3s ease;
      backdrop-filter: blur(4px);
    }

    .carousel-btn:hover {
      background: rgba(0, 0, 0, 0.8);
      transform: translateY(-50%) scale(1.1);
    }

    .carousel-prev {
      left: 10px;
    }

    .carousel-next {
      right: 10px;
    }

    /* Hide scrollbar but keep functionality */
    .carousel-track {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }

    .carousel-track::-webkit-scrollbar {
      display: none;
    }

    /* Pause auto-scroll on hover */
    .carousel-wrapper:hover .carousel-track {
      scroll-behavior: auto;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .category-item {
        width: 110px;
      }

      .category-img {
        width: 90px;
        height: 90px;
      }

      .carousel-track {
        gap: 16px;
      }
    }

    @media (max-width: 768px) {
      .carousel-btn {
        width: 36px;
        height: 36px;
        font-size: 18px;
      }

      .carousel-prev {
        left: 5px;
      }

      .carousel-next {
        right: 5px;
      }
    }
  </style>

  <section class="category-section">
    <div class="category-header">
      <h2>Explore By Services</h2>
      <a href="/services"><button class="view-all-btn">View More</button></a>
    </div>

    <div class="carousel-wrapper">
      <!-- Left Arrow -->
      <button class="carousel-btn carousel-prev" aria-label="Previous">
        <i class="bx bx-chevron-left"></i>
      </button>



      <!-- Carousel Track -->
      <div class="carousel-track" id="carouselTrack">
        @foreach ($services as $service)
        <div class="category-item">
          <a href="/service/{{ $service->slug }}">
            <div class="category-img">
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

      <!-- Right Arrow -->
      <button class="carousel-btn carousel-next" aria-label="Next">
        <i class="bx bx-chevron-right"></i>
      </button>
    </div>
  </section>

  <!-- Optional: Auto-scroll every 4 seconds -->
  <script>
    // Wait for DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
      const track = document.getElementById('carouselTrack');
      const prevBtn = document.querySelector('.carousel-prev');
      const nextBtn = document.querySelector('.carousel-next');

      // Safety check: if elements don't exist, exit early
      if (!track) {
        console.warn('Carousel track not found!');
        return;
      }

      const itemWidth = 164; // 140px item + 24px gap
      let autoScrollInterval;
      let isHovered = false;

      function scrollToDirection(direction) {
        const scrollAmount = itemWidth * 3;
        if (direction === 'next') {
          track.scrollBy({
            left: scrollAmount,
            behavior: 'smooth'
          });
        } else {
          track.scrollBy({
            left: -scrollAmount,
            behavior: 'smooth'
          });
        }
      }

      // Only attach event listeners if buttons exist
      if (nextBtn) {
        nextBtn.addEventListener('click', () => {
          scrollToDirection('next');
          resetAutoScroll();
        });
      }

      if (prevBtn) {
        prevBtn.addEventListener('click', () => {
          scrollToDirection('prev');
          resetAutoScroll();
        });
      }

      function startAutoScroll() {
        autoScrollInterval = setInterval(() => {
          if (!isHovered) {
            if (track.scrollLeft + track.clientWidth >= track.scrollWidth - 50) {
              track.scrollTo({
                left: 0,
                behavior: 'smooth'
              });
            } else {
              scrollToDirection('next');
            }
          }
        }, 4000);
      }

      function resetAutoScroll() {
        clearInterval(autoScrollInterval);
        startAutoScroll();
      }

      // Hover pause
      const carouselWrapper = document.querySelector('.carousel-wrapper');
      if (carouselWrapper) {
        carouselWrapper.addEventListener('mouseenter', () => isHovered = true);
        carouselWrapper.addEventListener('mouseleave', () => isHovered = false);
      }

      // Start auto-scroll
      startAutoScroll();

      // Optional keyboard support
      document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') {
          scrollToDirection('prev');
          resetAutoScroll();
        }
        if (e.key === 'ArrowRight') {
          scrollToDirection('next');
          resetAutoScroll();
        }
      });
    });
  </script>


  @include('includes.city-card')


{{-- resources/views/includes/expert-cards.blade.php --}}
<style>
  .expert-section {
    padding: 2rem 1rem;
    max-width: 1400px;
    margin: 0 auto;
  }

  .section-title {
    text-align: center;
    font-size: 1.8rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 2rem;
  }

  .experts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 1.5rem;
  }

  .expert-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid #eef2f6;
    transition: 0.3s;
  }

  .expert-card:hover {
    transform: translateY(-5px);
  }

  .expert-img-wrapper {
    position: relative;
    width: 100%;
    aspect-ratio: 1 / 1;
    overflow: hidden;
  }

  .expert-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .service-badge {
    position: absolute;
    bottom: 10px;
    left: 10px;
    background: rgba(0,0,0,0.7);
    color: #fff;
    font-size: 0.7rem;
    padding: 3px 8px;
    border-radius: 20px;
  }

  .expert-info {
    padding: 1rem;
  }

  .expert-name {
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 4px;
  }

  .meta-row {
    display: flex;
    justify-content: space-between;
    font-size: 0.8rem;
    margin: 4px 0;
  }

  .rating {
    color: #f59e0b;
  }

  .experience {
    background: #f1f5f9;
    padding: 2px 6px;
    border-radius: 20px;
    font-size: 0.7rem;
  }

  .location {
    font-size: 0.75rem;
    margin-bottom: 8px;
    color: #475569;
  }

  .button-group {
    display: flex;
    gap: 6px;
  }

  .btn {
    flex: 1;
    text-align: center;
    padding: 6px 0;
    border-radius: 30px;
    font-size: 0.75rem;
    text-decoration: none;
    color: #fff;
  }

  .btn-call { background: #10b981; }
  .btn-whatsapp { background: #25D366; }
  .btn-profile { background: #1e293b; }

  /* MOBILE FIX */
  @media (max-width: 768px) {
    .experts-grid {
      grid-template-columns: repeat(2, 1fr);
      gap: 0.7rem;
    }

    .expert-card {
      border-radius: 12px;
    }

    .expert-img-wrapper {
      aspect-ratio: 1 / 0.75; /* shorter image */
    }

    .expert-info {
      padding: 0.6rem;
    }

    .expert-name {
      font-size: 0.9rem;
      line-height: 1.2;
    }

    .meta-row {
      flex-direction: row;
      font-size: 0.7rem;
      margin: 2px 0;
    }

    .location {
      font-size: 0.65rem;
      margin-bottom: 5px;
    }

    .expert-info > * {
      margin-bottom: 3px;
    }

    .btn {
      padding: 4px 0;
      font-size: 0.65rem;
    }
  }

  @media (max-width: 480px) {
    .expert-section {
      padding: 1rem;
    }

    .expert-name {
      font-size: 0.8rem;
    }

    .btn span {
      display: none;
    }

    .btn i {
      font-size: 0.9rem;
    }

    .rating span {
      display: none;
    }
  }
</style>

  <!-- Products Carousel Section -->
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


</body>

</html>