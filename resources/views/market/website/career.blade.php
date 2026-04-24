<!doctype html>
<html lang="en">

<head>
  <!-- Open Graph / Social Media -->
<meta property="og:title" content="Careers - Join Feature Desk Team | Feature Desk">
<meta property="og:description" content="Join Feature Desk's growing team. Explore career opportunities in e-commerce, technology, marketing, and customer service.">

  @include('market.website.includes.header_links')
  <title>Careers - Join Feature Desk Team</title>
  <meta name="description" content="Join Feature Desk's growing team. Explore career opportunities in e-commerce, technology, marketing, and customer service.">
  <meta name="keywords" content="careers, jobs, employment, join our team, career opportunities">
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
                Career
              </li>
            </ol>
          </nav>

        </div>

      </div>

      {{-- Page Title / H1 --}}
      <div class="mt-3">
        <h1 class="h3 mb-0 fw-bold text-dark">
          Join Our Growing Team
        </h1>
        <p class="text-muted mt-2 mb-0">Be part of Pakistan's fastest growing e-commerce platform. Shape the future of online shopping with us.</p>
      </div>
    </div>
  </section>
  {{-- ====================== END BREADCRUMBS + TITLE ====================== --}}



  <!-- About Working at Feature Desk -->
  <section class="careers-about">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 mb-4 mb-lg-0">
          <h2 class="section-title">Why Work With Us?</h2>
          <div class="about-content">
            <p>At Feature Desk, we're not just building an e-commerce platform - we're revolutionizing how Pakistan shops online. We believe in innovation, teamwork, and creating exceptional value for our customers.</p>
            <p>We offer a dynamic work environment where creativity is encouraged, growth is supported, and every team member plays a crucial role in our success story.</p>
            <p>Join us to work on cutting-edge technology, solve challenging problems, and make a real impact in the lives of millions of Pakistanis.</p>
          </div>
        </div>
        <div class="col-lg-6">
          <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80"
            alt="Feature Desk Team"
            style="width: 100%; border-radius: 15px; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
        </div>
      </div>
    </div>
  </section>

  <!-- Benefits Section -->
  <section class="benefits-section">
    <div class="container">
      <h2 class="section-title text-center">Perks & Benefits</h2>

      <div class="row mt-5">
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="benefit-card">
            <i class="fas fa-money-bill-wave benefit-icon"></i>
            <h3>Competitive Salary</h3>
            <p>Industry-competitive compensation packages with performance bonuses</p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
          <div class="benefit-card">
            <i class="fas fa-heartbeat benefit-icon"></i>
            <h3>Health Insurance</h3>
            <p>Comprehensive health coverage for you and your family</p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
          <div class="benefit-card">
            <i class="fas fa-graduation-cap benefit-icon"></i>
            <h3>Learning & Growth</h3>
            <p>Training programs, workshops, and career advancement opportunities</p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
          <div class="benefit-card">
            <i class="fas fa-utensils benefit-icon"></i>
            <h3>Meals & Snacks</h3>
            <p>Complimentary meals, snacks, and beverages at the office</p>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="benefit-card">
            <i class="fas fa-clock benefit-icon"></i>
            <h3>Flexible Hours</h3>
            <p>Flexible work schedule and remote work options</p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
          <div class="benefit-card">
            <i class="fas fa-plane benefit-icon"></i>
            <h3>Paid Time Off</h3>
            <p>Generous vacation days, sick leave, and public holidays</p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
          <div class="benefit-card">
            <i class="fas fa-dumbbell benefit-icon"></i>
            <h3>Wellness Program</h3>
            <p>Gym membership, yoga classes, and wellness activities</p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
          <div class="benefit-card">
            <i class="fas fa-baby benefit-icon"></i>
            <h3>Parental Leave</h3>
            <p>Paid maternity and paternity leave for new parents</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Open Positions -->
  <section class="positions-section">
    <div class="container">
      <h2 class="section-title text-center">Open Positions</h2>
      <p class="text-center text-muted mb-5" style="font-size: 1.1rem;">Join us in one of these exciting roles</p>

      <div class="row">
        <!-- Position 1 -->
        <div class="col-lg-6">
          <div class="position-card">
            <div class="position-header">
              <div class="position-title">
                <h3>Senior Software Engineer</h3>
                <div class="position-meta">
                  <span class="meta-item"><i class="fas fa-map-marker-alt"></i> Lahore</span>
                  <span class="meta-item"><i class="fas fa-briefcase"></i> Full-time</span>
                  <span class="meta-item"><i class="fas fa-clock"></i> 3+ years</span>
                </div>
              </div>
              <span class="position-type">Engineering</span>
            </div>

            <div class="position-description">
              <p>We're looking for a Senior Software Engineer to join our core platform team. You'll work on building scalable solutions for our growing e-commerce platform.</p>
            </div>

            <div class="position-requirements">
              <h4 style="font-size: 1rem; margin-bottom: 10px; color: var(--dark);">Key Requirements:</h4>
              <div class="requirements-list">
                <span class="requirement-tag">Node.js</span>
                <span class="requirement-tag">React</span>
                <span class="requirement-tag">MongoDB</span>
                <span class="requirement-tag">AWS</span>
                <span class="requirement-tag">Microservices</span>
              </div>
            </div>

            <button class="apply-btn" data-position="Senior Software Engineer">
              <i class="fas fa-paper-plane"></i> Apply Now
            </button>
          </div>
        </div>

        <!-- Position 2 -->
        <div class="col-lg-6">
          <div class="position-card">
            <div class="position-header">
              <div class="position-title">
                <h3>Digital Marketing Manager</h3>
                <div class="position-meta">
                  <span class="meta-item"><i class="fas fa-map-marker-alt"></i> Karachi</span>
                  <span class="meta-item"><i class="fas fa-briefcase"></i> Full-time</span>
                  <span class="meta-item"><i class="fas fa-clock"></i> 4+ years</span>
                </div>
              </div>
              <span class="position-type">Marketing</span>
            </div>

            <div class="position-description">
              <p>Lead our digital marketing efforts to drive customer acquisition and retention. Develop and execute comprehensive marketing strategies.</p>
            </div>

            <div class="position-requirements">
              <h4 style="font-size: 1rem; margin-bottom: 10px; color: var(--dark);">Key Requirements:</h4>
              <div class="requirements-list">
                <span class="requirement-tag">SEO/SEM</span>
                <span class="requirement-tag">Social Media</span>
                <span class="requirement-tag">Google Ads</span>
                <span class="requirement-tag">Analytics</span>
                <span class="requirement-tag">Content Strategy</span>
              </div>
            </div>

            <button class="apply-btn" data-position="Digital Marketing Manager">
              <i class="fas fa-paper-plane"></i> Apply Now
            </button>
          </div>
        </div>
      </div>

      <div class="row">
        <!-- Position 3 -->
        <div class="col-lg-6">
          <div class="position-card">
            <div class="position-header">
              <div class="position-title">
                <h3>Customer Support Lead</h3>
                <div class="position-meta">
                  <span class="meta-item"><i class="fas fa-map-marker-alt"></i> Islamabad</span>
                  <span class="meta-item"><i class="fas fa-briefcase"></i> Full-time</span>
                  <span class="meta-item"><i class="fas fa-clock"></i> 2+ years</span>
                </div>
              </div>
              <span class="position-type">Customer Service</span>
            </div>

            <div class="position-description">
              <p>Lead our customer support team to ensure exceptional service delivery. Manage team performance and implement support strategies.</p>
            </div>

            <div class="position-requirements">
              <h4 style="font-size: 1rem; margin-bottom: 10px; color: var(--dark);">Key Requirements:</h4>
              <div class="requirements-list">
                <span class="requirement-tag">Team Management</span>
                <span class="requirement-tag">CRM</span>
                <span class="requirement-tag">Customer Service</span>
                <span class="requirement-tag">Problem Solving</span>
              </div>
            </div>

            <button class="apply-btn" data-position="Customer Support Lead">
              <i class="fas fa-paper-plane"></i> Apply Now
            </button>
          </div>
        </div>

        <!-- Position 4 -->
        <div class="col-lg-6">
          <div class="position-card">
            <div class="position-header">
              <div class="position-title">
                <h3>Data Analyst</h3>
                <div class="position-meta">
                  <span class="meta-item"><i class="fas fa-map-marker-alt"></i> Remote</span>
                  <span class="meta-item"><i class="fas fa-briefcase"></i> Full-time</span>
                  <span class="meta-item"><i class="fas fa-clock"></i> 3+ years</span>
                </div>
              </div>
              <span class="position-type">Analytics</span>
            </div>

            <div class="position-description">
              <p>Analyze customer data to provide insights for business decisions. Work with cross-functional teams to drive data-informed strategies.</p>
            </div>

            <div class="position-requirements">
              <h4 style="font-size: 1rem; margin-bottom: 10px; color: var(--dark);">Key Requirements:</h4>
              <div class="requirements-list">
                <span class="requirement-tag">SQL</span>
                <span class="requirement-tag">Python</span>
                <span class="requirement-tag">Tableau</span>
                <span class="requirement-tag">Statistics</span>
              </div>
            </div>

            <button class="apply-btn" data-position="Data Analyst">
              <i class="fas fa-paper-plane"></i> Apply Now
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Company Culture -->
  <section class="culture-section">
    <div class="container">
      <h2 class="section-title text-center" style="color: white;">Our Culture & Values</h2>

      <div class="row mt-5">
        <div class="col-lg-6">
          <div class="culture-content">
            <p>At Feature Desk, we foster a culture of innovation, collaboration, and continuous learning. We believe in empowering our team members to do their best work and grow both personally and professionally.</p>
            <p>Our open-door policy encourages communication and idea-sharing at all levels. We celebrate diversity and believe that different perspectives make us stronger.</p>
            <p>We're not just colleagues - we're a family working together to achieve something extraordinary for Pakistan's e-commerce landscape.</p>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="culture-values">
            <div class="value-item">
              <h4><i class="fas fa-bullseye"></i> Customer First</h4>
              <p>Everything we do starts with our customers. We're obsessed with creating exceptional experiences.</p>
            </div>

            <div class="value-item">
              <h4><i class="fas fa-rocket"></i> Innovation Driven</h4>
              <p>We embrace change and constantly look for better ways to solve problems and serve our customers.</p>
            </div>

            <div class="value-item">
              <h4><i class="fas fa-hands-helping"></i> Team Collaboration</h4>
              <p>We believe in the power of teamwork. Together, we achieve more than any individual could alone.</p>
            </div>

            <div class="value-item">
              <h4><i class="fas fa-chart-line"></i> Growth Mindset</h4>
              <p>We're committed to personal and professional growth, both for our team and our customers.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Application Form -->
  <section class="application-section">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="application-form">
            <h2 class="form-title">Apply for a Position</h2>

            <form id="careerForm">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label" for="firstName">First Name *</label>
                    <input type="text" class="form-control" id="firstName" name="firstName" required>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label" for="lastName">Last Name *</label>
                    <input type="text" class="form-control" id="lastName" name="lastName" required>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label" for="email">Email Address *</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label" for="phone">Phone Number *</label>
                    <input type="tel" class="form-control" id="phone" name="phone" required>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="form-label" for="position">Position Applying For *</label>
                <select class="form-control" id="position" name="position" required>
                  <option value="">Select a position</option>
                  <option value="Senior Software Engineer">Senior Software Engineer</option>
                  <option value="Digital Marketing Manager">Digital Marketing Manager</option>
                  <option value="Customer Support Lead">Customer Support Lead</option>
                  <option value="Data Analyst">Data Analyst</option>
                  <option value="Other">Other</option>
                </select>
              </div>

              <div class="form-group">
                <label class="form-label" for="experience">Years of Experience *</label>
                <select class="form-control" id="experience" name="experience" required>
                  <option value="">Select experience</option>
                  <option value="0-1">0-1 years</option>
                  <option value="1-3">1-3 years</option>
                  <option value="3-5">3-5 years</option>
                  <option value="5+">5+ years</option>
                </select>
              </div>

              <div class="form-group">
                <label class="form-label">Resume/CV *</label>
                <div class="file-upload" id="fileUpload">
                  <i class="fas fa-cloud-upload-alt"></i>
                  <p>Click to upload your resume</p>
                  <p style="font-size: 0.9rem; color: var(--gray); margin-top: 5px;">PDF, DOC, DOCX up to 5MB</p>
                  <input type="file" id="resume" name="resume" accept=".pdf,.doc,.docx" style="display: none;">
                </div>
                <div id="fileName" style="margin-top: 10px; font-size: 0.9rem; color: var(--success);"></div>
              </div>

              <div class="form-group">
                <label class="form-label" for="coverLetter">Cover Letter (Optional)</label>
                <textarea class="form-control" id="coverLetter" name="coverLetter" rows="4" placeholder="Tell us why you're interested in joining Feature Desk..."></textarea>
              </div>

              <button type="submit" class="submit-application">
                <i class="fas fa-paper-plane"></i> Submit Application
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  @include('market.website.includes.footer')
  @include('market.website.includes.footer_links')

  <script>
    // Apply button functionality
    document.querySelectorAll('.apply-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        const position = this.getAttribute('data-position');
        document.getElementById('position').value = position;

        // Scroll to application form
        document.querySelector('.application-section').scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });

        // Highlight the position field
        const positionField = document.getElementById('position');
        positionField.focus();
        positionField.style.borderColor = 'var(--primary)';

        setTimeout(() => {
          positionField.style.borderColor = '';
        }, 2000);
      });
    });

    // File upload functionality
    const fileUpload = document.getElementById('fileUpload');
    const fileInput = document.getElementById('resume');
    const fileName = document.getElementById('fileName');

    fileUpload.addEventListener('click', () => {
      fileInput.click();
    });

    fileInput.addEventListener('change', function() {
      if (this.files.length > 0) {
        const file = this.files[0];
        fileName.textContent = `Selected: ${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)`;

        // Validate file size
        if (file.size > 5 * 1024 * 1024) { // 5MB limit
          fileName.innerHTML = `<span style="color: var(--primary);">File too large. Max size is 5MB.</span>`;
          this.value = '';
        }
      } else {
        fileName.textContent = '';
      }
    });

    // Drag and drop for file upload
    fileUpload.addEventListener('dragover', (e) => {
      e.preventDefault();
      fileUpload.style.borderColor = 'var(--primary)';
      fileUpload.style.background = 'rgba(238, 39, 55, 0.05)';
    });

    fileUpload.addEventListener('dragleave', () => {
      fileUpload.style.borderColor = '';
      fileUpload.style.background = '';
    });

    fileUpload.addEventListener('drop', (e) => {
      e.preventDefault();
      fileUpload.style.borderColor = '';
      fileUpload.style.background = '';

      if (e.dataTransfer.files.length) {
        fileInput.files = e.dataTransfer.files;
        fileInput.dispatchEvent(new Event('change'));
      }
    });

    // Form submission
    const careerForm = document.getElementById('careerForm');

    careerForm.addEventListener('submit', function(e) {
      e.preventDefault();

      // Basic validation
      const requiredFields = this.querySelectorAll('[required]');
      let isValid = true;

      requiredFields.forEach(field => {
        if (!field.value.trim()) {
          field.style.borderColor = 'var(--primary)';
          isValid = false;
        } else {
          field.style.borderColor = '';
        }
      });

      // File validation
      const resumeFile = document.getElementById('resume').files[0];
      if (!resumeFile) {
        fileName.innerHTML = `<span style="color: var(--primary);">Please upload your resume</span>`;
        isValid = false;
      }

      if (isValid) {
        // Show success message
        const submitBtn = this.querySelector('.submit-application');
        const originalText = submitBtn.innerHTML;

        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
        submitBtn.disabled = true;

        // Simulate API call
        setTimeout(() => {
          submitBtn.innerHTML = '<i class="fas fa-check"></i> Application Submitted!';
          submitBtn.style.background = 'var(--success)';

          // Reset form after 2 seconds
          setTimeout(() => {
            careerForm.reset();
            fileName.textContent = '';
            submitBtn.innerHTML = originalText;
            submitBtn.style.background = '';
            submitBtn.disabled = false;

            // Show success alert
            alert('Thank you for your application! We\'ll review your submission and contact you soon.');
          }, 2000);
        }, 1500);
      } else {
        alert('Please fill in all required fields and upload your resume.');
      }
    });

    // Reset field border color on input
    document.querySelectorAll('.form-control').forEach(field => {
      field.addEventListener('input', function() {
        this.style.borderColor = '';
      });
    });

    // Position select change
    document.getElementById('position').addEventListener('change', function() {
      if (this.value === 'Other') {
        const otherInput = document.createElement('input');
        otherInput.type = 'text';
        otherInput.className = 'form-control mt-2';
        otherInput.placeholder = 'Please specify position';
        otherInput.name = 'otherPosition';
        otherInput.required = true;

        const existingOther = document.querySelector('[name="otherPosition"]');
        if (!existingOther) {
          this.parentNode.appendChild(otherInput);
        }
      } else {
        const otherInput = document.querySelector('[name="otherPosition"]');
        if (otherInput) {
          otherInput.remove();
        }
      }
    });
  </script>
</body>

</html>