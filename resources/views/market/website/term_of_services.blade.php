<!doctype html>
<html lang="en">

<head>
  <!-- Open Graph / Social Media -->
<meta property="og:title" content="Terms of Service - Feature Desk">
<meta property="og:description" content="Feature Desk Terms of Service. Read our terms governing your use of our website and services.">

  @include('market.website.includes.header_links')
  <title>Terms of Service - Feature Desk</title>
  <meta name="description" content="Feature Desk Terms of Service. Read our terms governing your use of our website and services.">
  <meta name="keywords" content="terms of service, terms and conditions, user agreement, legal terms, service terms">
  <style>
    /* Terms of Service Styles */
    :root {
      --primary: #BD8802;
      --primary-light: #ff4757;
      --secondary: #2d3748;
      --accent: #ff9800;
      --light: #f8f9fa;
      --dark: #1a1a2e;
      --gray: #6c757d;
      --success: #28a745;
      --warning: #ffc107;
      --danger: #dc3545;
      --border: #e0e0e0;
    }

    .terms-main {
      padding: 60px 0;
      background: white;
    }

    /* Quick Navigation */
    .terms-nav {
      background: #f8f9fa;
      border-radius: 10px;
      padding: 25px;
      margin-bottom: 40px;
      border: 1px solid var(--border);
      position: sticky;
      top: 20px;
      z-index: 10;
    }

    .terms-nav h3 {
      font-size: 1.2rem;
      color: var(--dark);
      margin-bottom: 15px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .terms-nav h3 i {
      color: var(--primary);
    }

    .nav-links {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 10px;
    }

    .nav-link {
      color: #16213e  !important;
      text-decoration: none;
      padding: 8px 15px;
      border-radius: 5px;
      font-size: 0.9rem;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .nav-link:hover {
      background: white;
      color: var(--primary);
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }

    .nav-link i {
      font-size: 0.8rem;
      color: var(--primary);
    }

    /* Terms Content */
    .terms-section {
      margin-bottom: 40px;
      padding: 30px;
      background: white;
      border-radius: 10px;
      border: 1px solid var(--border);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.02);
      scroll-margin-top: 30px;
    }

    .terms-section:last-child {
      margin-bottom: 0;
    }

    .section-title {
      font-size: 1.5rem;
      color: var(--primary);
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 2px solid rgba(238, 39, 55, 0.1);
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .section-title i {
      font-size: 1.2rem;
    }

    .section-content {
      color: var(--secondary);
      line-height: 1.8;
      font-size: 1rem;
    }

    .section-content p {
      margin-bottom: 15px;
    }

    /* Terms Lists */
    .terms-list {
      margin: 20px 0;
      padding-left: 25px;
    }

    .terms-item {
      margin-bottom: 12px;
      padding-left: 10px;
      position: relative;
      line-height: 1.6;
    }

    .terms-item:before {
      content: "•";
      color: var(--primary);
      font-size: 1.2rem;
      position: absolute;
      left: -15px;
      top: -2px;
    }

    /* Numbered List */
    .numbered-list {
      counter-reset: term-counter;
      margin: 25px 0;
    }

    .numbered-item {
      margin-bottom: 15px;
      padding-left: 35px;
      position: relative;
      line-height: 1.6;
    }

    .numbered-item:before {
      counter-increment: term-counter;
      content: counter(term-counter) ".";
      position: absolute;
      left: 0;
      top: 0;
      color: var(--primary);
      font-weight: bold;
      font-size: 1rem;
    }

    /* Important Boxes */
    .warning-box {
      background: #fff8e1;
      border-left: 4px solid var(--warning);
      padding: 20px;
      margin: 25px 0;
      border-radius: 0 5px 5px 0;
    }

    .warning-box h4 {
      color: #856404;
      margin-bottom: 10px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .danger-box {
      background: #f8d7da;
      border-left: 4px solid var(--danger);
      padding: 20px;
      margin: 25px 0;
      border-radius: 0 5px 5px 0;
    }

    .danger-box h4 {
      color: #721c24;
      margin-bottom: 10px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .info-box {
      background: #e8f4fd;
      border-left: 4px solid #007bff;
      padding: 20px;
      margin: 25px 0;
      border-radius: 0 5px 5px 0;
    }

    .info-box h4 {
      color: #0056b3;
      margin-bottom: 10px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    /* Definition Terms */
    .definition-term {
      background: #f8f9fa;
      padding: 15px;
      border-radius: 8px;
      margin: 20px 0;
      border-left: 3px solid var(--primary);
    }

    .definition-term dt {
      font-weight: 600;
      color: var(--dark);
      margin-bottom: 8px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .definition-term dd {
      color: var(--gray);
      margin-left: 0;
      padding-left: 25px;
    }

    /* Accept Button */
    .accept-section {
      background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
      border-radius: 10px;
      padding: 40px;
      margin-top: 40px;
      text-align: center;
      border: 2px solid var(--border);
    }

    .accept-section h3 {
      color: var(--dark);
      margin-bottom: 20px;
    }

    .accept-btn {
      background: var(--primary);
      color: white;
      padding: 15px 40px;
      border-radius: 8px;
      font-size: 1.1rem;
      font-weight: 600;
      border: none;
      cursor: pointer;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      margin-top: 15px;
    }

    .accept-btn:hover {
      background: var(--primary-light);
      transform: translateY(-3px);
      box-shadow: 0 10px 25px rgba(238, 39, 55, 0.3);
    }

    /* Contact Section */
    .contact-section {
      margin-top: 50px;
      padding: 40px;
      background: white;
      border-radius: 10px;
      border: 1px solid var(--border);
      text-align: center;
    }

    .contact-section h3 {
      color: var(--dark);
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    .contact-section h3 i {
      color: var(--primary);
    }

    .contact-info {
      color: var(--secondary);
      line-height: 1.6;
      max-width: 600px;
      margin: 0 auto;
    }

    .contact-details {
      margin-top: 20px;
      padding-top: 20px;
      border-top: 1px solid var(--border);
    }

    .contact-details p {
      margin-bottom: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    .contact-details i {
      color: var(--primary);
      width: 20px;
    }

    /* Back to Top */
    .back-to-top {
      position: fixed;
      bottom: 30px;
      right: 30px;
      background: var(--primary);
      color: white;
      width: 50px;
      height: 50px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.2rem;
      box-shadow: 0 4px 15px rgba(238, 39, 55, 0.4);
      cursor: pointer;
      transition: all 0.3s ease;
      z-index: 100;
      opacity: 0;
      visibility: hidden;
    }

    .back-to-top.show {
      opacity: 1;
      visibility: visible;
    }

    .back-to-top:hover {
      background: var(--primary-light);
      transform: translateY(-3px);
    }

    /* Scroll Progress */
    .scroll-progress {
      position: fixed;
      top: 0;
      left: 0;
      width: 0%;
      height: 3px;
      background: var(--primary);
      z-index: 100;
      transition: width 0.2s ease;
    }

    /* Responsive */
    @media (max-width: 992px) {
     
      .nav-links {
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
      }
    }

    @media (max-width: 768px) {
    

      .terms-main {
        padding: 40px 0;
      }

      .terms-nav {
        position: static;
      }

      .nav-links {
        grid-template-columns: 1fr;
      }

      .terms-section {
        padding: 25px 20px;
      }

      .accept-section,
      .contact-section {
        padding: 30px 20px;
      }

      .section-title {
        font-size: 1.3rem;
      }
    }

    @media (max-width: 576px) {
     

      .section-title {
        font-size: 1.2rem;
      }

      .accept-btn {
        width: 100%;
        justify-content: center;
      }
    }
  </style>
</head>

<body>
  <!-- Navbar Start -->
  @include('market.website.includes.navbar')
  <!-- Navbar End -->

  <!-- Scroll Progress -->
  <div class="scroll-progress" id="scrollProgress"></div>
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
                Terms of Service
              </li>
            </ol>
          </nav>

        </div>

      </div>

      {{-- Page Title / H1 --}}
      <div class="mt-3">
        <h1 class="h3 mb-0 fw-bold text-dark">
          Terms of Service  
        </h1>
        <p class="text-muted mt-2 mb-0">Please read these terms carefully before using Feature Desk's services. By using our platform, you agree to these terms.</p>
      </div>
    </div>
  </section>
  {{-- ====================== END BREADCRUMBS + TITLE ====================== --}}


  <!-- Main Terms Content -->
  <section class="terms-main">
    <div class="container">
      <!-- Quick Navigation -->
      <div class="terms-nav">
        <h3><i class="fas fa-compass"></i> Quick Navigation</h3>
        <div class="nav-links">
          <a href="#acceptance" class="nav-link">
            <i class="fas fa-check-circle"></i> Acceptance of Terms
          </a>
          <a href="#account" class="nav-link">
            <i class="fas fa-user-circle"></i> Account Registration
          </a>
          <a href="#orders" class="nav-link">
            <i class="fas fa-shopping-cart"></i> Orders & Payments
          </a>
          <a href="#content" class="nav-link">
            <i class="fas fa-file-alt"></i> User Content
          </a>
          <a href="#prohibited" class="nav-link">
            <i class="fas fa-ban"></i> Prohibited Activities
          </a>
          <a href="#intellectual" class="nav-link">
            <i class="fas fa-copyright"></i> Intellectual Property
          </a>
          <a href="#liability" class="nav-link">
            <i class="fas fa-balance-scale"></i> Liability
          </a>
          <a href="#termination" class="nav-link">
            <i class="fas fa-power-off"></i> Termination
          </a>
          <a href="#governing" class="nav-link">
            <i class="fas fa-gavel"></i> Governing Law
          </a>
          <a href="#changes" class="nav-link">
            <i class="fas fa-sync-alt"></i> Changes to Terms
          </a>
        </div>
      </div>

      <!-- Acceptance of Terms -->
      <div class="terms-section" id="acceptance">
        <h2 class="section-title"><i class="fas fa-check-circle"></i> 1. Acceptance of Terms</h2>
        <div class="section-content">
          <p>By accessing and using Feature Desk ("Website", "Platform", "Service"), you accept and agree to be bound by the terms and provisions of this agreement.</p>

          <div class="warning-box">
            <h4><i class="fas fa-exclamation-triangle"></i> Important Notice</h4>
            <p>If you do not agree to all of these terms, you must not access or use the Feature Desk platform. Your continued use of the platform constitutes your acceptance of these terms.</p>
          </div>

          <p>These Terms of Service apply to all users of the platform, including without limitation users who are browsers, vendors, customers, merchants, and/or contributors of content.</p>
        </div>
      </div>

      <!-- Account Registration -->
      <div class="terms-section" id="account">
        <h2 class="section-title"><i class="fas fa-user-circle"></i> 2. Account Registration</h2>
        <div class="section-content">
          <p>To access certain features of our platform, you may be required to create an account.</p>

          <div class="definition-term">
            <dt><i class="fas fa-key"></i> Account Responsibilities:</dt>
            <dd>You are responsible for maintaining the confidentiality of your account and password and for restricting access to your computer or device.</dd>
            <dd>You agree to accept responsibility for all activities that occur under your account or password.</dd>
          </div>

          <ul class="terms-list">
            <li class="terms-item">You must be at least 18 years old to create an account</li>
            <li class="terms-item">You must provide accurate and complete information during registration</li>
            <li class="terms-item">You must notify us immediately of any unauthorized use of your account</li>
            <li class="terms-item">We reserve the right to refuse service, terminate accounts, or cancel orders at our discretion</li>
          </ul>
        </div>
      </div>

      <!-- Orders and Payments -->
      <div class="terms-section" id="orders">
        <h2 class="section-title"><i class="fas fa-shopping-cart"></i> 3. Orders and Payments</h2>
        <div class="section-content">
          <p>All orders placed through our platform are subject to acceptance and availability.</p>

          <div class="numbered-list">
            <div class="numbered-item">
              <strong>Order Acceptance:</strong> We reserve the right to refuse or cancel any order for any reason, including limitations on quantities available for purchase.
            </div>
            <div class="numbered-item">
              <strong>Pricing:</strong> All prices are shown in Pakistani Rupees (PKR) and are subject to change without notice.
            </div>
            <div class="numbered-item">
              <strong>Payment Methods:</strong> We accept various payment methods including cash on delivery, credit/debit cards, and mobile wallets.
            </div>
            <div class="numbered-item">
              <strong>Taxes:</strong> You are responsible for any applicable taxes associated with your purchases.
            </div>
          </div>

          <div class="info-box">
            <h4><i class="fas fa-info-circle"></i> Order Processing</h4>
            <p>Orders are typically processed within 24-48 hours. You will receive an email confirmation once your order has been processed and shipped.</p>
          </div>
        </div>
      </div>

      <!-- User Content -->
      <div class="terms-section" id="content">
        <h2 class="section-title"><i class="fas fa-file-alt"></i> 4. User Content</h2>
        <div class="section-content">
          <p>Our platform may allow you to post, link, store, share and otherwise make available certain information, text, graphics, videos, or other material ("Content").</p>

          <div class="definition-term">
            <dt><i class="fas fa-shield-alt"></i> Your Rights:</dt>
            <dd>You retain any and all of your rights to any Content you submit, post or display on or through the platform.</dd>
          </div>

          <div class="danger-box">
            <h4><i class="fas fa-exclamation-circle"></i> Content Responsibility</h4>
            <p>You are solely responsible for the Content you post on the platform. You agree that Content you post will not violate any right of any third party.</p>
          </div>

          <ul class="terms-list">
            <li class="terms-item">Content must not be illegal, offensive, or violate any laws</li>
            <li class="terms-item">Content must not infringe upon any copyright, trademark, or other proprietary rights</li>
            <li class="terms-item">Content must not contain false or misleading information</li>
            <li class="terms-item">We reserve the right to remove any Content that violates these terms</li>
          </ul>
        </div>
      </div>

      <!-- Prohibited Activities -->
      <div class="terms-section" id="prohibited">
        <h2 class="section-title"><i class="fas fa-ban"></i> 5. Prohibited Activities</h2>
        <div class="section-content">
          <p>You are prohibited from using the platform for any unlawful purpose or to engage in any activities that may harm our platform or other users.</p>

          <div class="numbered-list">
            <div class="numbered-item">
              <strong>Illegal Activities:</strong> Using the platform for any illegal or unauthorized purpose
            </div>
            <div class="numbered-item">
              <strong>Security Violations:</strong> Attempting to interfere with, compromise, or disrupt the platform's security
            </div>
            <div class="numbered-item">
              <strong>Spam and Fraud:</strong> Sending unsolicited communications or engaging in fraudulent activities
            </div>
            <div class="numbered-item">
              <strong>Data Mining:</strong> Using automated systems to extract data from our platform
            </div>
            <div class="numbered-item">
              <strong>Impersonation:</strong> Impersonating another person or entity
            </div>
          </div>

          <div class="warning-box">
            <h4><i class="fas fa-gavel"></i> Consequences</h4>
            <p>Violation of these prohibited activities may result in immediate termination of your account, legal action, and reporting to appropriate authorities.</p>
          </div>
        </div>
      </div>

      <!-- Intellectual Property -->
      <div class="terms-section" id="intellectual">
        <h2 class="section-title"><i class="fas fa-copyright"></i> 6. Intellectual Property</h2>
        <div class="section-content">
          <p>The platform and its original content, features, and functionality are and will remain the exclusive property of Feature Desk and its licensors.</p>

          <div class="definition-term">
            <dt><i class="fas fa-trademark"></i> Our Intellectual Property Includes:</dt>
            <dd>Website design, logos, graphics, text, software, and all other content</dd>
            <dd>Trademarks, service marks, and trade names</dd>
            <dd>Proprietary technology and systems</dd>
          </div>

          <p>These Terms of Service do not grant you any right, title, or interest in the platform or any content on the platform. You may not use our intellectual property without our prior written consent.</p>

          <div class="info-box">
            <h4><i class="fas fa-lightbulb"></i> Feedback</h4>
            <p>Any feedback, comments, or suggestions you may provide regarding the platform is entirely voluntary. We are free to use such feedback without any obligation to you.</p>
          </div>
        </div>
      </div>

      <!-- Limitation of Liability -->
      <div class="terms-section" id="liability">
        <h2 class="section-title"><i class="fas fa-balance-scale"></i> 7. Limitation of Liability</h2>
        <div class="section-content">
          <p>To the maximum extent permitted by applicable law, Feature Desk shall not be liable for any indirect, incidental, special, consequential, or punitive damages.</p>

          <div class="numbered-list">
            <div class="numbered-item">
              <strong>Service Availability:</strong> We do not guarantee uninterrupted, timely, secure, or error-free operation of the platform.
            </div>
            <div class="numbered-item">
              <strong>Third-Party Services:</strong> We are not responsible for third-party products, services, or websites linked through our platform.
            </div>
            <div class="numbered-item">
              <strong>Maximum Liability:</strong> Our total liability to you for any claim arising out of or relating to these terms shall not exceed the amount you paid to us in the last 12 months.
            </div>
          </div>

          <div class="danger-box">
            <h4><i class="fas fa-exclamation-triangle"></i> Disclaimer</h4>
            <p>The platform is provided on an "as is" and "as available" basis without warranties of any kind, either express or implied.</p>
          </div>
        </div>
      </div>

      <!-- Termination -->
      <div class="terms-section" id="termination">
        <h2 class="section-title"><i class="fas fa-power-off"></i> 8. Termination</h2>
        <div class="section-content">
          <p>We may terminate or suspend your account and bar access to the platform immediately, without prior notice or liability, under our sole discretion.</p>

          <ul class="terms-list">
            <li class="terms-item">Breach of these Terms of Service</li>
            <li class="terms-item">Request by law enforcement or other government agencies</li>
            <li class="terms-item">Extended periods of inactivity</li>
            <li class="terms-item">Unexpected technical issues or problems</li>
          </ul>

          <p>Upon termination, your right to use the platform will immediately cease. If you wish to terminate your account, you may simply discontinue using the platform.</p>
        </div>
      </div>

      <!-- Governing Law -->
      <div class="terms-section" id="governing">
        <h2 class="section-title"><i class="fas fa-gavel"></i> 9. Governing Law</h2>
        <div class="section-content">
          <p>These Terms shall be governed and construed in accordance with the laws of Pakistan, without regard to its conflict of law provisions.</p>

          <div class="definition-term">
            <dt><i class="fas fa-map-marker-alt"></i> Jurisdiction:</dt>
            <dd>Any disputes arising from these Terms or your use of the platform shall be subject to the exclusive jurisdiction of the courts located in Lahore, Pakistan.</dd>
          </div>

          <p>Our failure to enforce any right or provision of these Terms will not be considered a waiver of those rights.</p>
        </div>
      </div>

      <!-- Changes to Terms -->
      <div class="terms-section" id="changes">
        <h2 class="section-title"><i class="fas fa-sync-alt"></i> 10. Changes to Terms</h2>
        <div class="section-content">
          <p>We reserve the right, at our sole discretion, to modify or replace these Terms at any time.</p>

          <div class="info-box">
            <h4><i class="fas fa-bell"></i> Notification of Changes</h4>
            <p>If a revision is material, we will provide at least 30 days' notice prior to any new terms taking effect. What constitutes a material change will be determined at our sole discretion.</p>
          </div>

          <p>By continuing to access or use our platform after those revisions become effective, you agree to be bound by the revised terms. If you do not agree to the new terms, you must stop using the platform.</p>
        </div>
      </div>

      <!-- Accept Terms Button -->
      <div class="accept-section">
        <h3>Agreement to Terms</h3>
        <p>By using Feature Desk's platform and services, you acknowledge that you have read, understood, and agree to be bound by these Terms of Service.</p>
        <button class="accept-btn" id="acceptTerms">
          <i class="fas fa-handshake"></i> I Accept the Terms of Service
        </button>
        <p style="margin-top: 15px; font-size: 0.9rem; color: var(--gray);">
          This button is for acknowledgment purposes only. Your use of the platform constitutes acceptance.
        </p>
      </div>


    </div>
  </section>

  <!-- Back to Top Button -->
  <div class="back-to-top" id="backToTop">
    <i class="fas fa-chevron-up"></i>
  </div>

  <!-- Footer -->
  @include('market.website.includes.footer')
  @include('market.website.includes.footer_links')

  <script>
    // Scroll progress indicator
    const scrollProgress = document.getElementById('scrollProgress');

    window.addEventListener('scroll', () => {
      const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
      const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
      const scrolled = (winScroll / height) * 100;
      scrollProgress.style.width = scrolled + "%";
    });

    // Back to top button
    const backToTopBtn = document.getElementById('backToTop');

    window.addEventListener('scroll', () => {
      if (window.pageYOffset > 300) {
        backToTopBtn.classList.add('show');
      } else {
        backToTopBtn.classList.remove('show');
      }
    });

    backToTopBtn.addEventListener('click', () => {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });

    // Smooth scrolling for navigation links
    document.querySelectorAll('.nav-link').forEach(link => {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        const targetId = this.getAttribute('href');
        const targetElement = document.querySelector(targetId);

        if (targetElement) {
          targetElement.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });

          // Highlight the active section
          document.querySelectorAll('.terms-section').forEach(section => {
            section.style.boxShadow = '0 5px 15px rgba(0,0,0,0.02)';
          });

          targetElement.style.boxShadow = '0 10px 30px rgba(238, 39, 55, 0.1)';
          setTimeout(() => {
            targetElement.style.boxShadow = '';
          }, 2000);
        }
      });
    });

    // Accept terms button
    const acceptBtn = document.getElementById('acceptTerms');
    acceptBtn.addEventListener('click', function() {
      const originalText = this.innerHTML;
      const originalBg = this.style.background;

      this.innerHTML = '<i class="fas fa-check"></i> Terms Accepted';
      this.style.background = 'var(--success)';
      this.disabled = true;

      // Show confirmation message
      const confirmation = document.createElement('div');
      confirmation.innerHTML = `
                <div style="
                    background: #d4edda;
                    color: #155724;
                    padding: 15px;
                    border-radius: 8px;
                    margin-top: 15px;
                    border: 1px solid #c3e6cb;
                    text-align: center;
                    animation: fadeIn 0.3s ease;
                ">
                    <i class="fas fa-check-circle"></i> 
                    <strong>Thank you!</strong> You have acknowledged acceptance of our Terms of Service.
                </div>
            `;

      const acceptSection = document.querySelector('.accept-section');
      acceptSection.appendChild(confirmation);

      // Remove confirmation after 5 seconds
      setTimeout(() => {
        this.innerHTML = originalText;
        this.style.background = originalBg;
        this.disabled = false;
        confirmation.remove();
      }, 5000);

      // Scroll to confirmation
      confirmation.scrollIntoView({
        behavior: 'smooth',
        block: 'nearest'
      });
    });

    // Highlight active section in navigation
    const sections = document.querySelectorAll('.terms-section');
    const navLinks = document.querySelectorAll('.nav-link');

    window.addEventListener('scroll', () => {
      let current = '';

      sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;

        if (pageYOffset >= (sectionTop - 150)) {
          current = section.getAttribute('id');
        }
      });

      navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === `#${current}`) {
          link.classList.add('active');
          link.style.background = 'var(--primary)';
          link.style.color = 'white';
        } else {
          link.style.background = '';
          link.style.color = '';
        }
      });
    });

    // Add print functionality
    const printBtn = document.createElement('button');
    printBtn.innerHTML = '<i class="fas fa-print"></i> Print Terms';
    printBtn.style.cssText = `
            position: fixed;
            bottom: 30px;
            left: 30px;
            background: var(--primary);
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            z-index: 100;
            transition: all 0.3s ease;
        `;

    printBtn.addEventListener('mouseenter', () => {
      printBtn.style.transform = 'translateY(-3px)';
      printBtn.style.boxShadow = '0 6px 20px rgba(0,0,0,0.3)';
    });

    printBtn.addEventListener('mouseleave', () => {
      printBtn.style.transform = '';
      printBtn.style.boxShadow = '';
    });

    printBtn.addEventListener('click', () => {
      // Hide navigation and buttons during print
      document.querySelector('.terms-nav').style.display = 'none';
      printBtn.style.display = 'none';
      backToTopBtn.style.display = 'none';
      scrollProgress.style.display = 'none';

      window.print();

      // Restore after print
      setTimeout(() => {
        document.querySelector('.terms-nav').style.display = 'block';
        printBtn.style.display = 'block';
        backToTopBtn.style.display = 'block';
        scrollProgress.style.display = 'block';
      }, 100);
    });

    document.body.appendChild(printBtn);

    // Add keyframes for animations
    const style = document.createElement('style');
    style.textContent = `
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(-10px); }
                to { opacity: 1; transform: translateY(0); }
            }
        `;
    document.head.appendChild(style);
  </script>
</body>

</html>