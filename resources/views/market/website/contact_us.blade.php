<!doctype html>
<html lang="en">

<head>
    <!-- Open Graph / Social Media -->
    <meta property="og:title" content="Contact Us - Feature Desk">
    <meta property="og:description" content="Contact Feature Desk customer support for orders, shipping, returns, and any other inquiries. We're here to help you!">

  @include('market.website.includes.header_links')
  <title>Contact Us - Feature Desk</title>
  <meta name="description" content="Contact Feature Desk customer support for orders, shipping, returns, and any other inquiries. We're here to help you!">
  <meta name="keywords" content="contact Feature Desk, customer support, help center, contact us pakistan">
  <style>
    /* Contact Page Specific Styles */
    :root {
      --primary: #BD8802;
      --primary-light: #ff4757;
      --dark: #1a1a2e;
      --light: #f8f9fa;
      --gray: #6c757d;
      --border: #e0e0e0;
      --success: #28a745;
    }

    .contact-main {
      padding: 60px 0;
    }

    .section-title {
      font-size: 1.8rem;
      color: var(--dark);
      margin-bottom: 30px;
      position: relative;
      padding-bottom: 10px;
    }

    .section-title:after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 60px;
      height: 3px;
      background: var(--primary);
    }

    .contact-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 40px;
      margin-top: 40px;
    }

    /* Contact Info Cards */
    .contact-info {
      display: flex;
      flex-direction: column;
      gap: 25px;
      background-color: #BD8802;
    }

    .info-card {
      background: white;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      display: flex;
      align-items: flex-start;
      gap: 20px;
      transition: transform 0.3s ease;
    }

    .info-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .info-icon {
      background: rgba(238, 39, 55, 0.1);
      color: var(--primary);
      width: 50px;
      height: 50px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.2rem;
      flex-shrink: 0;
    }

    .info-content h3 {
      font-size: 1.2rem;
      margin-bottom: 8px;
      color: var(--dark);
    }

    .info-content p {
      color: var(--gray);
      margin-bottom: 5px;
      font-size: 0.95rem;
    }

    .info-link {
      color: var(--primary);
      text-decoration: none;
      font-weight: 600;
      font-size: 0.95rem;
      display: inline-block;
      margin-top: 5px;
    }

    .info-link:hover {
      color: var(--primary-light);
    }

    /* Contact Form */
    .contact-form-container {
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-label {
      display: block;
      margin-bottom: 8px;
      color: var(--dark);
      font-weight: 600;
    }

    .form-control {
      width: 100%;
      padding: 12px 15px;
      border: 1px solid var(--border);
      border-radius: 5px;
      font-size: 1rem;
      transition: border-color 0.3s ease;
    }

    .form-control:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 2px rgba(238, 39, 55, 0.1);
    }

    textarea.form-control {
      min-height: 120px;
      resize: vertical;
    }

    .submit-btn {
      background: var(--primary);
      color: white;
      padding: 12px 30px;
      border: none;
      border-radius: 5px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.3s ease;
      display: inline-flex;
      align-items: center;
      gap: 10px;
    }

    .submit-btn:hover {
      background: var(--primary-light);
    }

    /* FAQ Section */
    .faq-section {
      padding: 60px 0;
      background: var(--light);
    }

    .faq-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 25px;
      margin-top: 40px;
    }

    .faq-item {
      background: white;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .faq-item h3 {
      font-size: 1.1rem;
      color: var(--dark);
      margin-bottom: 10px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .faq-icon {
      color: var(--primary);
      font-size: 1.2rem;
    }

    .faq-item p {
      color: var(--gray);
      font-size: 0.95rem;
      line-height: 1.6;
    }

    /* Map Section */
    .map-section {
      padding: 60px 0;
    }

    .map-container {
      height: 400px;
      background: #f5f5f5;
      border-radius: 10px;
      overflow: hidden;
      margin-top: 30px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--gray);
      position: relative;
    }

    .map-placeholder {
      text-align: center;
      padding: 40px;
    }

    .map-icon {
      font-size: 3rem;
      color: var(--primary);
      margin-bottom: 20px;
    }

    /* Success Message */
    .success-message {
      background: rgba(40, 167, 69, 0.1);
      border: 1px solid var(--success);
      color: var(--success);
      padding: 15px;
      border-radius: 5px;
      margin-bottom: 20px;
      display: none;
    }

    /* Responsive */
    @media (max-width: 768px) {

      .contact-main,
      .faq-section,
      .map-section {
        padding: 40px 0;
      }

      .contact-grid,
      .faq-grid {
        grid-template-columns: 1fr;
        gap: 30px;
      }

      .info-card {
        padding: 20px;
      }

      .map-container {
        height: 300px;
      }
    }

    @media (max-width: 480px) {

      .section-title {
        font-size: 1.5rem;
      }

      .contact-form-container {
        padding: 20px;
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
                Coutact Us
            </ol>
          </nav>

        </div>

      </div>

      {{-- Page Title / H1 --}}
      <div class="mt-3">
        <h1 class="h3 mb-0 fw-bold text-dark">
          Get in Touch
        </h1>
        <p class="text-muted mt-2 mb-0">Have questions or need assistance? We're here to help. Reach out to us through any of the channels below.</p>
      </div>
    </div>
  </section>
  {{-- ====================== END BREADCRUMBS + TITLE ====================== --}}



  <!-- Main Contact Section -->
  <section class="contact-main">
    <div class="container">
      <div class="contact-grid">
        <!-- Contact Information -->
        <div class="contact-info">
          <div class="info-card">
            <div class="info-icon">
              <i class="fas fa-phone"></i>
            </div>
            <div class="info-content">
              <h3>Call Us</h3>
              <p>Monday to Friday: 9AM - 6PM</p>
              <p>Saturday: 10AM - 4PM</p>
              <a href="tel:+447412803448" class="info-link">+44 7412 803448</a>
            </div>
          </div>

          <div class="info-card">
            <div class="info-icon">
              <i class="fas fa-envelope"></i>
            </div>
            <div class="info-content">
              <h3>Email Us</h3>
              <p>For general inquiries and support</p>
              <a href="mailto:info@featuredesk.site" class="info-link">info@featuredesk.site</a>
            </div>
          </div>

          <div class="info-card">
            <div class="info-icon">
              <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="info-content">
              <h3>Website</h3>
              <p>www.featuredesk.site</p>              
            </div>
          </div>

          <div class="info-card">
            <div class="info-icon">
              <i class="fas fa-clock"></i>
            </div>
            <div class="info-content">
              <h3>Business Hours</h3>
              <p><strong>Customer Support:</strong></p>
              <p>Mon-Sat: 9:00 AM - 7:00 PM</p>
              <p>Sunday: 10:00 AM - 5:00 PM</p>
            </div>
          </div>
        </div>

        <!-- Contact Form -->
        <div class="contact-form-container">
          <h2 class="section-title">Send us a Message</h2>
          <p>Fill out the form below and we'll get back to you as soon as possible.</p>

          <div class="success-message" id="successMessage">
            <i class="fas fa-check-circle"></i> Thank you! Your message has been sent successfully.
          </div>

          <form id="contactForm">
            <div class="form-group">
              <label class="form-label" for="name">Full Name *</label>
              <input type="text" class="form-control" id="name" name="name" required placeholder="Enter your full name">
            </div>

            <div class="form-group">
              <label class="form-label" for="email">Email Address *</label>
              <input type="email" class="form-control" id="email" name="email" required placeholder="Enter your email address">
            </div>

            <div class="form-group">
              <label class="form-label" for="phone">Phone Number</label>
              <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your phone number">
            </div>

            <div class="form-group">
              <label class="form-label" for="subject">Subject *</label>
              <select class="form-control" id="subject" name="subject" required>
                <option value="">Select a subject</option>
                <option value="order">Order Issues</option>
                <option value="shipping">Shipping & Delivery</option>
                <option value="returns">Returns & Refunds</option>
                <option value="account">Account Help</option>
                <option value="payment">Payment Issues</option>
                <option value="other">Other</option>
              </select>
            </div>

            <div class="form-group">
              <label class="form-label" for="message">Message *</label>
              <textarea class="form-control" id="message" name="message" required placeholder="Please describe your issue or inquiry..."></textarea>
            </div>

            <button type="submit" class="submit-btn">
              <i class="fas fa-paper-plane"></i> Send Message
            </button>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ Section -->
  <section class="faq-section">
    <div class="container">
      <h2 class="section-title text-center">Common Questions</h2>
      <p class="text-center" style="max-width: 600px; margin: 0 auto 40px; color: var(--gray);">
        Quick answers to questions we get asked often.
      </p>

      <div class="faq-grid">
        <div class="faq-item">
          <h3><i class="fas fa-question-circle faq-icon"></i> How quickly will you respond?</h3>
          <p>We typically respond to emails within 24 hours. For urgent matters, please call our support line.</p>
        </div>

        <div class="faq-item">
          <h3><i class="fas fa-shipping-fast faq-icon"></i> Where is my order?</h3>
          <p>Track your order through your account or use the tracking link in your confirmation email.</p>
        </div>

        <div class="faq-item">
          <h3><i class="fas fa-exchange-alt faq-icon"></i> How do I return an item?</h3>
          <p>Visit the Returns section in your account to initiate a return. Most items can be returned within 30 days.</p>
        </div>

        <div class="faq-item">
          <h3><i class="fas fa-credit-card faq-icon"></i> Is my payment secure?</h3>
          <p>Yes, all payments are processed through secure, encrypted channels to protect your information.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  @include('market.website.includes.footer')
  @include('market.website.includes.footer_links')

  <script>
    // Contact Form Handling
    const contactForm = document.getElementById('contactForm');
    const successMessage = document.getElementById('successMessage');

    contactForm.addEventListener('submit', function(e) {
      e.preventDefault();

      // Get form data
      const formData = {
        name: document.getElementById('name').value,
        email: document.getElementById('email').value,
        phone: document.getElementById('phone').value,
        subject: document.getElementById('subject').value,
        message: document.getElementById('message').value
      };

      // Validate form
      if (!formData.name || !formData.email || !formData.subject || !formData.message) {
        alert('Please fill in all required fields.');
        return;
      }

      // In a real application, you would send this data to your server
      // For now, we'll just show a success message
      console.log('Form submitted:', formData);

      // Show success message
      successMessage.style.display = 'block';

      // Reset form
      contactForm.reset();

      // Scroll to success message
      successMessage.scrollIntoView({
        behavior: 'smooth',
        block: 'nearest'
      });

      // Hide success message after 5 seconds
      setTimeout(() => {
        successMessage.style.display = 'none';
      }, 5000);
    });

    // Phone link click tracking
    document.querySelectorAll('a[href^="tel:"]').forEach(link => {
      link.addEventListener('click', function() {
        console.log('Phone number clicked:', this.href);
        // You could add analytics tracking here
      });
    });

    // Email link click tracking
    document.querySelectorAll('a[href^="mailto:"]').forEach(link => {
      link.addEventListener('click', function() {
        console.log('Email link clicked:', this.href);
        // You could add analytics tracking here
      });
    });

    // Get Directions link
    const directionsLink = document.querySelector('a[href*="maps.google.com"]');
    if (directionsLink) {
      directionsLink.addEventListener('click', function(e) {
        console.log('Get directions clicked');
        // In a real app, you might want to track this event
      });
    }

    // Form validation on blur
    const requiredFields = contactForm.querySelectorAll('[required]');
    requiredFields.forEach(field => {
      field.addEventListener('blur', function() {
        if (!this.value.trim()) {
          this.style.borderColor = 'var(--primary)';
        } else {
          this.style.borderColor = '';
        }
      });
    });
  </script>
</body>

</html>