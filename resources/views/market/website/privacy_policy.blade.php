<!doctype html>
<html lang="en">

<head>
  <!-- Open Graph / Social Media -->
  <meta property="og:title" content="Privacy Policy - Feature Desk">
  <meta property="og:description" content="Read Feature Desk's Privacy Policy to understand how we collect, use, and protect your personal information.">

  @include('market.website.includes.header_links')
  <title>Privacy Policy - Feature Desk</title>
  <meta name="description" content="Read Feature Desk's Privacy Policy to understand how we collect, use, and protect your personal information.">
  <meta name="keywords" content="privacy policy, data protection, personal information, cookies, GDPR, data security">
  <style>
    /* Privacy Policy Styles */
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

    .privacy-main {
      padding: 60px 0;
      background: white;
    }

    /* Table of Contents */
    .toc-section {
      background: #f8f9fa;
      border-radius: 10px;
      padding: 30px;
      margin-bottom: 40px;
      border-left: 4px solid var(--primary);
    }

    .toc-section h3 {
      font-size: 1.3rem;
      color: var(--dark);
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .toc-section h3 i {
      color: var(--primary);
    }

    .toc-links {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 10px;
    }

    .toc-link {
      color: var(--secondary);
      text-decoration: none;
      padding: 8px 0;
      display: flex;
      align-items: center;
      gap: 10px;
      transition: color 0.3s ease;
      font-size: 0.95rem;
    }

    .toc-link:hover {
      color: var(--primary);
    }

    .toc-link i {
      font-size: 0.8rem;
      color: var(--primary);
    }

    /* Policy Content */
    .policy-section {
      margin-bottom: 40px;
      scroll-margin-top: 30px;
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
    }

    .section-content p {
      margin-bottom: 15px;
    }

    /* Policy Points */
    .policy-points {
      margin: 20px 0;
      padding-left: 20px;
    }

    .policy-point {
      margin-bottom: 10px;
      padding-left: 10px;
      position: relative;
    }

    .policy-point:before {
      content: "•";
      color: var(--primary);
      font-size: 1.2rem;
      position: absolute;
      left: -10px;
      top: -2px;
    }

    /* Important Notes */
    .important-note {
      background: #fff8e1;
      border-left: 4px solid #ffc107;
      padding: 20px;
      margin: 25px 0;
      border-radius: 0 5px 5px 0;
    }

    .important-note h4 {
      color: #856404;
      margin-bottom: 10px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    /* Data Table */
    .data-table {
      width: 100%;
      margin: 25px 0;
      border-collapse: collapse;
    }

    .data-table th {
      background: #f8f9fa;
      padding: 15px;
      text-align: left;
      border-bottom: 2px solid var(--border);
      color: var(--dark);
      font-weight: 600;
    }

    .data-table td {
      padding: 15px;
      border-bottom: 1px solid var(--border);
      color: var(--gray);
      vertical-align: top;
    }

    .data-table tr:last-child td {
      border-bottom: none;
    }

    /* Cookie Table */
    .cookie-table {
      width: 100%;
      margin: 25px 0;
      border-collapse: collapse;
    }

    .cookie-table th {
      background: #f8f9fa;
      padding: 12px;
      text-align: left;
      border: 1px solid var(--border);
      color: var(--dark);
      font-weight: 600;
    }

    .cookie-table td {
      padding: 12px;
      border: 1px solid var(--border);
      color: var(--gray);
      font-size: 0.9rem;
    }

    /* Rights Section */
    .rights-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 20px;
      margin: 30px 0;
    }

    .right-card {
      background: #f8f9fa;
      border-radius: 8px;
      padding: 20px;
      border-left: 4px solid var(--primary);
    }

    .right-card h4 {
      color: var(--dark);
      margin-bottom: 10px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .right-card h4 i {
      color: var(--primary);
    }

    /* Contact Section */
    .contact-section {
      background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
      border-radius: 10px;
      padding: 40px;
      margin-top: 40px;
    }

    .contact-section h3 {
      color: var(--dark);
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .contact-section h3 i {
      color: var(--primary);
    }

    .contact-info {
      color: var(--secondary);
      line-height: 1.6;
      background-color: #BD8802;
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



    @media (max-width: 768px) {


      .privacy-main {
        padding: 40px 0;
      }

      .toc-links {
        grid-template-columns: 1fr;
      }

      .data-table,
      .cookie-table {
        display: block;
        overflow-x: auto;
      }

      .rights-grid {
        grid-template-columns: 1fr;
      }

      .contact-section {
        padding: 30px 20px;
      }
    }

    @media (max-width: 576px) {


      .section-title {
        font-size: 1.3rem;
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
                Privacy Policy
              </li>
            </ol>
          </nav>

        </div>

      </div>

      {{-- Page Title / H1 --}}
      <div class="mt-3">
        <h1 class="h3 mb-0 fw-bold text-dark">
          Privacy Policy
        </h1>
        <p class="text-muted mt-2 mb-0">Your privacy is important to us. This policy explains how we collect, use, and protect your personal information.</p>
      </div>
    </div>
  </section>
  {{-- ====================== END BREADCRUMBS + TITLE ====================== --}}


  <!-- Main Privacy Content -->
  <section class="privacy-main">
    <div class="container">
      <!-- Table of Contents -->
      <div class="toc-section">
        <h3><i class="fas fa-list"></i> Table of Contents</h3>
        <div class="toc-links">
          <a href="#information-collection" class="toc-link">
            <i class="fas fa-chevron-right"></i> Information We Collect
          </a>
          <a href="#data-usage" class="toc-link">
            <i class="fas fa-chevron-right"></i> How We Use Your Data
          </a>
          <a href="#data-protection" class="toc-link">
            <i class="fas fa-chevron-right"></i> Data Protection
          </a>
          <a href="#cookies" class="toc-link">
            <i class="fas fa-chevron-right"></i> Cookies Policy
          </a>
          <a href="#data-sharing" class="toc-link">
            <i class="fas fa-chevron-right"></i> Data Sharing
          </a>
          <a href="#your-rights" class="toc-link">
            <i class="fas fa-chevron-right"></i> Your Rights
          </a>
          <a href="#children-privacy" class="toc-link">
            <i class="fas fa-chevron-right"></i> Children's Privacy
          </a>
          <a href="#policy-changes" class="toc-link">
            <i class="fas fa-chevron-right"></i> Policy Changes
          </a>
        </div>
      </div>

      <!-- Introduction -->
      <div class="policy-section">
        <h2 class="section-title"><i class="fas fa-info-circle"></i> Introduction</h2>
        <div class="section-content">
          <p>Feature Desk ("we," "our," or "us") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website or use our services.</p>
          <p>Please read this privacy policy carefully. By using our services, you consent to the practices described in this policy.</p>
        </div>
      </div>

      <!-- Information We Collect -->
      <div class="policy-section" id="information-collection">
        <h2 class="section-title"><i class="fas fa-database"></i> Information We Collect</h2>
        <div class="section-content">
          <p>We collect various types of information to provide and improve our services to you:</p>

          <h4 style="margin: 20px 0 15px; color: var(--dark);">Personal Information:</h4>
          <ul class="policy-points">
            <li class="policy-point">Name and contact details (email, phone number, address)</li>
            <li class="policy-point">Account credentials</li>
            <li class="policy-point">Payment information</li>
            <li class="policy-point">Order history and preferences</li>
          </ul>

          <h4 style="margin: 20px 0 15px; color: var(--dark);">Automatically Collected Information:</h4>
          <ul class="policy-points">
            <li class="policy-point">Device information (IP address, browser type, operating system)</li>
            <li class="policy-point">Usage data (pages visited, time spent, click patterns)</li>
            <li class="policy-point">Location information (if enabled)</li>
          </ul>

          <div class="important-note">
            <h4><i class="fas fa-exclamation-circle"></i> Important</h4>
            <p>We do not store your payment card details. All payment transactions are processed through secure payment gateways.</p>
          </div>
        </div>
      </div>

      <!-- How We Use Your Data -->
      <div class="policy-section" id="data-usage">
        <h2 class="section-title"><i class="fas fa-cogs"></i> How We Use Your Information</h2>
        <div class="section-content">
          <p>We use the information we collect for various purposes:</p>

          <table class="data-table">
            <tr>
              <th>Purpose</th>
              <th>Description</th>
            </tr>
            <tr>
              <td>Service Delivery</td>
              <td>Process orders, deliver products, and provide customer support</td>
            </tr>
            <tr>
              <td>Account Management</td>
              <td>Create and manage your account, verify your identity</td>
            </tr>
            <tr>
              <td>Communication</td>
              <td>Send order updates, promotions, and service notifications</td>
            </tr>
            <tr>
              <td>Improvement</td>
              <td>Analyze usage patterns to enhance our services</td>
            </tr>
            <tr>
              <td>Security</td>
              <td>Protect against fraud and ensure platform security</td>
            </tr>
            <tr>
              <td>Legal Compliance</td>
              <td>Comply with applicable laws and regulations</td>
            </tr>
          </table>
        </div>
      </div>

      <!-- Data Protection -->
      <div class="policy-section" id="data-protection">
        <h2 class="section-title"><i class="fas fa-shield-alt"></i> Data Protection & Security</h2>
        <div class="section-content">
          <p>We implement appropriate security measures to protect your personal information:</p>

          <div class="rights-grid">
            <div class="right-card">
              <h4><i class="fas fa-lock"></i> Encryption</h4>
              <p>All data transmissions are encrypted using SSL/TLS technology.</p>
            </div>

            <div class="right-card">
              <h4><i class="fas fa-user-shield"></i> Access Control</h4>
              <p>Strict access controls limit employee access to personal data.</p>
            </div>

            <div class="right-card">
              <h4><i class="fas fa-firewall"></i> Firewalls</h4>
              <p>Advanced firewall systems protect our servers from unauthorized access.</p>
            </div>

            <div class="right-card">
              <h4><i class="fas fa-history"></i> Regular Audits</h4>
              <p>Regular security audits and vulnerability assessments.</p>
            </div>
          </div>

          <div class="important-note">
            <h4><i class="fas fa-exclamation-triangle"></i> Security Reminder</h4>
            <p>While we strive to protect your personal information, no method of transmission over the Internet or electronic storage is 100% secure. We cannot guarantee absolute security.</p>
          </div>
        </div>
      </div>

      <!-- Cookies Policy -->
      <div class="policy-section" id="cookies">
        <h2 class="section-title"><i class="fas fa-cookie-bite"></i> Cookies Policy</h2>
        <div class="section-content">
          <p>We use cookies and similar tracking technologies to enhance your browsing experience:</p>

          <table class="cookie-table">
            <tr>
              <th>Cookie Type</th>
              <th>Purpose</th>
              <th>Duration</th>
            </tr>
            <tr>
              <td>Essential Cookies</td>
              <td>Required for website functionality and security</td>
              <td>Session</td>
            </tr>
            <tr>
              <td>Analytics Cookies</td>
              <td>Collect information about website usage</td>
              <td>2 years</td>
            </tr>
            <tr>
              <td>Preference Cookies</td>
              <td>Remember your settings and preferences</td>
              <td>1 year</td>
            </tr>
            <tr>
              <td>Marketing Cookies</td>
              <td>Deliver relevant advertisements</td>
              <td>6 months</td>
            </tr>
          </table>

          <p style="margin-top: 20px;">You can control cookies through your browser settings. However, disabling cookies may affect your ability to use certain features of our website.</p>
        </div>
      </div>

      <!-- Data Sharing -->
      <div class="policy-section" id="data-sharing">
        <h2 class="section-title"><i class="fas fa-share-alt"></i> Data Sharing & Disclosure</h2>
        <div class="section-content">
          <p>We may share your information in the following circumstances:</p>

          <ul class="policy-points">
            <li class="policy-point"><strong>Service Providers:</strong> With third-party vendors who perform services on our behalf (payment processing, delivery, analytics)</li>
            <li class="policy-point"><strong>Legal Requirements:</strong> When required by law or to respond to legal process</li>
            <li class="policy-point"><strong>Business Transfers:</strong> In connection with any merger, sale, or acquisition</li>
            <li class="policy-point"><strong>With Your Consent:</strong> When you give us explicit permission to share</li>
          </ul>

          <p>We do not sell your personal information to third parties for marketing purposes.</p>
        </div>
      </div>

      <!-- Your Rights -->
      <div class="policy-section" id="your-rights">
        <h2 class="section-title"><i class="fas fa-user-check"></i> Your Rights</h2>
        <div class="section-content">
          <p>Depending on your location, you may have the following rights regarding your personal data:</p>

          <div class="rights-grid">
            <div class="right-card">
              <h4><i class="fas fa-eye"></i> Right to Access</h4>
              <p>Request access to your personal information we hold.</p>
            </div>

            <div class="right-card">
              <h4><i class="fas fa-edit"></i> Right to Rectify</h4>
              <p>Correct inaccurate or incomplete personal data.</p>
            </div>

            <div class="right-card">
              <h4><i class="fas fa-trash-alt"></i> Right to Delete</h4>
              <p>Request deletion of your personal information.</p>
            </div>

            <div class="right-card">
              <h4><i class="fas fa-ban"></i> Right to Object</h4>
              <p>Object to processing of your personal data.</p>
            </div>
          </div>

          <p>To exercise these rights, please contact us using the information provided below.</p>
        </div>
      </div>

      <!-- Children's Privacy -->
      <div class="policy-section" id="children-privacy">
        <h2 class="section-title"><i class="fas fa-child"></i> Children's Privacy</h2>
        <div class="section-content">
          <p>Our services are not directed to individuals under the age of 18. We do not knowingly collect personal information from children under 18.</p>
          <p>If you are a parent or guardian and believe your child has provided us with personal information, please contact us immediately. We will take steps to remove such information from our servers.</p>
        </div>
      </div>

      <!-- Policy Changes -->
      <div class="policy-section" id="policy-changes">
        <h2 class="section-title"><i class="fas fa-sync-alt"></i> Policy Changes</h2>
        <div class="section-content">
          <p>We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page and updating the "Last Updated" date.</p>
          <p>You are advised to review this Privacy Policy periodically for any changes. Changes to this Privacy Policy are effective when they are posted on this page.</p>
        </div>
      </div>

      <!-- Contact Information -->
      <div class="contact-section">
        <h3><i class="fas fa-envelope"></i> Contact Us</h3>
        <div class="contact-info">
          <p>If you have any questions about this Privacy Policy or our data practices, please contact us:</p>

          <div class="contact-details">
            <p><i class="fas fa-envelope"></i> <strong>Email:</strong> privacy@FeatureDesk</p>
            <p><i class="fas fa-phone"></i> <strong>Phone:</strong> +44 7412 803448</p>
            <p><i class="fas fa-map-marker-alt"></i> <strong>Address:</strong> Feature Desk Head Office, 123 Commercial Area, Main Boulevard, Lahore, Pakistan</p>
            <p><i class="fas fa-clock"></i> <strong>Hours:</strong> Monday to Friday, 9:00 AM - 6:00 PM</p>
          </div>

          <p style="margin-top: 20px; font-size: 0.9rem; color: var(--gray);">
            For data protection requests, please include "Privacy Request" in the subject line of your email.
          </p>
        </div>
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
    // Smooth scrolling for table of contents links
    document.querySelectorAll('.toc-link').forEach(link => {
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
          document.querySelectorAll('.policy-section').forEach(section => {
            section.style.backgroundColor = '';
          });

          targetElement.style.backgroundColor = '#f9f9f9';
          setTimeout(() => {
            targetElement.style.backgroundColor = '';
          }, 2000);
        }
      });
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

    // Highlight active section in TOC on scroll
    const sections = document.querySelectorAll('.policy-section');
    const navLinks = document.querySelectorAll('.toc-link');

    window.addEventListener('scroll', () => {
      let current = '';

      sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;

        if (pageYOffset >= (sectionTop - 100)) {
          current = section.getAttribute('id');
        }
      });

      navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === `#${current}`) {
          link.classList.add('active');
          link.innerHTML = `<i class="fas fa-chevron-right"></i> ${link.textContent}`;
        }
      });
    });

    // Table row hover effect
    document.querySelectorAll('.data-table tr, .cookie-table tr').forEach(row => {
      row.addEventListener('mouseenter', function() {
        this.style.backgroundColor = '#f8f9fa';
      });

      row.addEventListener('mouseleave', function() {
        this.style.backgroundColor = '';
      });
    });

    // Print policy button (optional)
    const printBtn = document.createElement('button');
    printBtn.innerHTML = '<i class="fas fa-print"></i> Print Policy';
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
      window.print();
    });

    document.body.appendChild(printBtn);
  </script>
</body>

</html>