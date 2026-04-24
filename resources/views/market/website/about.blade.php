<!doctype html>
<html lang="en">

<head>
  <!-- Open Graph / Social Media -->
<meta property="og:title" content="Careers - Join Feature Desk Team | Feature Desk">
<meta property="og:description" content="Join Feature Desk's growing team. Explore career opportunities in e-commerce, technology, marketing, and customer service.">

  @include('market.website.includes.header_links')
<title>About Us - Feature Desk</title>
<meta name="description" content="Learn about Feature Desk, a fast-growing e-commerce platform dedicated to providing seamless online shopping experiences worldwide.">
<meta name="keywords" content="about feature desk, ecommerce platform, online shopping, marketplace">
  <style>
    /* Careers Specific Styles */
    :root {
      --primary: #BD8802;
      --primary-light: #ff4757;
      --secondary: #2d3748;
      --accent: #ff9800;
      --light: #f8f9fa;
      --dark: #1a1a2e;
      --gray: #6c757d;
      --success: #28a745;
      --border: #e0e0e0;
    }

    .careers-header {
      background: linear-gradient(135deg, var(--primary), #ff416c);
      color: white;
      padding: 100px 0 60px;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .careers-header:before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none"><path d="M1200 120L0 16.48 0 0 1200 0 1200 120z" fill="white"/></svg>');
      background-size: 100% 100px;
      background-position: bottom;
      background-repeat: no-repeat;
    }

    .careers-header h1 {
      font-size: 3.5rem;
      font-weight: 800;
      margin-bottom: 20px;
      position: relative;
      z-index: 2;
    }

    .careers-header p {
      font-size: 1.3rem;
      opacity: 0.9;
      max-width: 700px;
      margin: 0 auto 30px;
      position: relative;
      z-index: 2;
    }

    .hero-stats {
      display: flex;
      justify-content: center;
      gap: 40px;
      flex-wrap: wrap;
      margin-top: 40px;
      position: relative;
      z-index: 2;
    }

    .stat-item {
      text-align: center;
    }

    .stat-number {
      font-size: 2.5rem;
      font-weight: 700;
      color: white;
      display: block;
      margin-bottom: 5px;
    }

    .stat-label {
      color: #ff416c;
      font-size: 1.1rem;
      opacity: 0.8;
    }

    .careers-about {
      padding: 100px 0;
      background: white;
    }

    .section-title {
      font-size: 2.5rem;
      color: var(--dark);
      margin-bottom: 30px;
      position: relative;
      padding-bottom: 15px;
    }

    .section-title:after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 80px;
      height: 4px;
      background: var(--primary);
      border-radius: 2px;
    }

    .text-center .section-title:after {
      left: 50%;
      transform: translateX(-50%);
    }

    .about-content {
      font-size: 1.1rem;
      line-height: 1.8;
      color: var(--secondary);
    }

    /* Benefits Section */
    .benefits-section {
      padding: 80px 0;
      background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .benefit-card {
      background: white;
      border-radius: 15px;
      padding: 40px 30px;
      height: 100%;
      text-align: center;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      border: 2px solid transparent;
    }

    .benefit-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
      border-color: var(--primary);
    }

    .benefit-icon {
      font-size: 3rem;
      color: var(--primary);
      margin-bottom: 25px;
      display: inline-block;
      transition: transform 0.3s ease;
    }

    .benefit-card:hover .benefit-icon {
      transform: scale(1.1);
    }

    .benefit-card h3 {
      font-size: 1.3rem;
      color: var(--dark);
      margin-bottom: 15px;
      font-weight: 600;
    }

    .benefit-card p {
      color: var(--gray);
      font-size: 0.95rem;
      margin-bottom: 0;
    }

    /* Open Positions */
    .positions-section {
      padding: 80px 0;
      background: white;
    }

    .position-card {
      background: white;
      border-radius: 12px;
      padding: 30px;
      margin-bottom: 25px;
      border: 1px solid var(--border);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease;
    }

    .position-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
      border-color: var(--primary);
    }

    .position-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 20px;
      flex-wrap: wrap;
      gap: 15px;
    }

    .position-title h3 {
      font-size: 1.4rem;
      color: var(--dark);
      margin-bottom: 8px;
      font-weight: 600;
    }

    .position-meta {
      display: flex;
      gap: 15px;
      flex-wrap: wrap;
    }

    .meta-item {
      display: flex;
      align-items: center;
      gap: 8px;
      color: var(--gray);
      font-size: 0.9rem;
    }

    .meta-item i {
      color: var(--primary);
    }

    .position-type {
      background: rgba(238, 39, 55, 0.1);
      color: var(--primary);
      padding: 5px 15px;
      border-radius: 20px;
      font-size: 0.85rem;
      font-weight: 600;
    }

    .position-description {
      color: var(--secondary);
      line-height: 1.6;
      margin-bottom: 20px;
    }

    .position-requirements {
      margin-bottom: 25px;
    }

    .requirements-list {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-top: 10px;
    }

    .requirement-tag {
      background: #f8f9fa;
      color: var(--secondary);
      padding: 6px 15px;
      border-radius: 20px;
      font-size: 0.85rem;
      border: 1px solid var(--border);
    }

    .apply-btn {
      background: var(--primary);
      color: white;
      padding: 12px 30px;
      border-radius: 8px;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      font-weight: 600;
      transition: all 0.3s ease;
      border: none;
      cursor: pointer;
    }

    .apply-btn:hover {
      background: var(--primary-light);
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(238, 39, 55, 0.3);
    }

    /* Culture Section */
    .culture-section {
      padding: 80px 0;
      background: linear-gradient(135deg, var(--dark), #2d3748);
      color: white;
    }

    .culture-content {
      font-size: 1.1rem;
      line-height: 1.8;
      opacity: 0.9;
    }

    .culture-content p {
      color: white;
    }

    .culture-values {
      margin-top: 40px;
    }

    .value-item {
      margin-bottom: 25px;
    }

    .value-item p {
      color: white;
    }

    .value-item h4 {
      font-size: 1.2rem;
      margin-bottom: 10px;
      color: white;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .value-item h4 i {
      color: var(--primary);
    }

    /* Application Form */
    .application-section {
      padding: 80px 0;
      background: var(--light);
    }

    .application-form {
      background: white;
      border-radius: 15px;
      padding: 50px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }

    .form-title {
      font-size: 2rem;
      color: var(--dark);
      margin-bottom: 30px;
      text-align: center;
    }

    .form-group {
      margin-bottom: 25px;
    }

    .form-label {
      display: block;
      margin-bottom: 8px;
      color: var(--dark);
      font-weight: 600;
    }

    .form-control {
      width: 100%;
      padding: 14px 20px;
      border: 1px solid var(--border);
      border-radius: 8px;
      font-size: 1rem;
      transition: all 0.3s ease;
    }

    .form-control:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(238, 39, 55, 0.1);
    }

    .file-upload {
      border: 2px dashed var(--border);
      padding: 30px;
      text-align: center;
      border-radius: 8px;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .file-upload:hover {
      border-color: var(--primary);
      background: rgba(238, 39, 55, 0.05);
    }

    .file-upload i {
      font-size: 2.5rem;
      color: var(--primary);
      margin-bottom: 15px;
      display: block;
    }

    .submit-application {
      background: var(--primary);
      color: white;
      padding: 16px 40px;
      border-radius: 8px;
      font-size: 1.1rem;
      font-weight: 600;
      width: 100%;
      border: none;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 20px;
    }

    .submit-application:hover {
      background: var(--primary-light);
      transform: translateY(-3px);
      box-shadow: 0 10px 25px rgba(238, 39, 55, 0.3);
    }

    /* Responsive */
    @media (max-width: 992px) {
      .careers-header h1 {
        font-size: 2.8rem;
      }

      .section-title {
        font-size: 2.2rem;
      }

      .application-form {
        padding: 40px 30px;
      }
    }

    @media (max-width: 768px) {
      .careers-header {
        padding: 80px 0 50px;
      }

      .careers-header h1 {
        font-size: 2.3rem;
      }

      .careers-header p {
        font-size: 1.1rem;
      }

      .hero-stats {
        gap: 30px;
      }

      .stat-number {
        font-size: 2rem;
      }

      .careers-about,
      .benefits-section,
      .positions-section,
      .culture-section,
      .application-section {
        padding: 60px 0;
      }

      .position-header {
        flex-direction: column;
        align-items: flex-start;
      }

      .position-type {
        align-self: flex-start;
      }
    }

    @media (max-width: 576px) {
      .careers-header h1 {
        font-size: 2rem;
      }

      .section-title {
        font-size: 1.8rem;
      }

      .hero-stats {
        flex-direction: column;
        gap: 20px;
      }

      .benefit-card,
      .position-card {
        padding: 25px 20px;
      }

      .form-title {
        font-size: 1.6rem;
      }
    }
  </style>
</head>

<body>
  <!-- Navbar Start -->
  @include('market.website.includes.navbar')
  <!-- Navbar End -->
  {{-- ====================== BREADCRUMBS + PAGE TITLE ====================== --}}
  <section class="bg-light border-bottom" style="margin-top:70px; padding: 15px 0;">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-12 col-md-8">

          {{-- Breadcrumb --}}
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 bg-transparent p-0">
              <li class="breadcrumb-item">
                <a href="{{ url('/') }}" class="text-decoration-none text-muted">
                  <i class="fas fa-home me-1"></i> Home
                </a>
              </li>
              <li class="breadcrumb-item active text-success" aria-current="page">
                About Us
              </li>
            </ol>
          </nav>

        </div>

      </div>

      {{-- Page Title / H1 --}}
      <div class="mt-3">
        <h1 class="h3 mb-0 fw-bold text-dark">
          About Feature Desk - Revolutionizing E-commerce World Wide
        </h1>
        <p class="text-muted mt-2 mb-0">Be part of world's fastest growing e-commerce platform. Shape the future of online shopping with us.</p>
      </div>
    </div>
  </section>
  {{-- ====================== END BREADCRUMBS + TITLE ====================== --}}



  <!-- About Feature Desk -->
<section class="careers-about">
  <div class="container">
    <div class="row align-items-center">
      
      <!-- LEFT CONTENT -->
      <div class="col-lg-6 mb-4 mb-lg-0">
        <h2 class="section-title">Who We Are</h2>
        
        <div class="about-content">
          <p>
            <strong>Feature Desk</strong> is a fast-growing e-commerce platform dedicated to transforming the way people shop online. 
            We bring together quality products, trusted sellers, and seamless technology to create a smooth and reliable shopping experience.
          </p>

          <p>
            Our mission is simple — to make online shopping <strong>faster, safer, and more accessible</strong> for everyone. 
            Whether you're a customer looking for great products or a seller aiming to grow your business, Feature Desk provides the tools and platform to succeed.
          </p>

          <p>
            We continuously innovate by leveraging modern technologies, data-driven strategies, and customer-focused design 
            to stay ahead in the evolving e-commerce landscape.
          </p>
        </div>
      </div>

      <!-- RIGHT SIDE (STATS / HIGHLIGHTS) -->
      <div class="col-lg-6">
        <div class="row g-4">
          
          <div class="col-6">
            <div class="benefit-card text-center">
              <div class="stat-number">10K+</div>
              <div class="stat-label">Active Users</div>
            </div>
          </div>

          <div class="col-6">
            <div class="benefit-card text-center">
              <div class="stat-number">5K+</div>
              <div class="stat-label">Products</div>
            </div>
          </div>

          <div class="col-6">
            <div class="benefit-card text-center">
              <div class="stat-number">500+</div>
              <div class="stat-label">Trusted Sellers</div>
            </div>
          </div>

          <div class="col-6">
            <div class="benefit-card text-center">
              <div class="stat-number">24/7</div>
              <div class="stat-label">Support</div>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</section>


<section class="benefits-section">
  <div class="container text-center">
    
    <h2 class="section-title">Our Mission & Vision</h2>

    <div class="row g-4 mt-4">

      <div class="col-md-6">
        <div class="benefit-card">
          <div class="benefit-icon">
            <i class="fas fa-bullseye"></i>
          </div>
          <h3>Our Mission</h3>
          <p>
            To empower businesses and customers by providing a reliable, scalable, and user-friendly e-commerce platform.
          </p>
        </div>
      </div>

      <div class="col-md-6">
        <div class="benefit-card">
          <div class="benefit-icon">
            <i class="fas fa-eye"></i>
          </div>
          <h3>Our Vision</h3>
          <p>
            To become a leading global marketplace where innovation meets convenience, and every transaction builds trust.
          </p>
        </div>
      </div>

    </div>
  </div>
</section>

<section class="positions-section">
  <div class="container text-center">
    
    <h2 class="section-title">Why Choose Feature Desk?</h2>

    <div class="row g-4 mt-4">

      <div class="col-md-4">
        <div class="benefit-card">
          <div class="benefit-icon">
            <i class="fas fa-shield-alt"></i>
          </div>
          <h3>Secure Platform</h3>
          <p>We prioritize security to ensure safe transactions for buyers and sellers.</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="benefit-card">
          <div class="benefit-icon">
            <i class="fas fa-rocket"></i>
          </div>
          <h3>Fast Performance</h3>
          <p>Optimized systems for smooth browsing and quick checkout experience.</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="benefit-card">
          <div class="benefit-icon">
            <i class="fas fa-users"></i>
          </div>
          <h3>Customer First</h3>
          <p>We focus on delivering the best experience for our users and partners.</p>
        </div>
      </div>

    </div>

  </div>
</section>

  
  

  
  <!-- Footer -->
  @include('market.website.includes.footer')
  @include('market.website.includes.footer_links')

  
</body>

</html>