<!doctype html>
<html lang="en">

<head>
  <!-- Open Graph / Social Media -->
<meta property="og:title" content="Shipping Info - Feature Desk">
<meta property="og:description" content="Learn about shopping on Feature Desk - ordering, shipping, payments, returns, and customer service.">

  @include('market.website.includes.header_links')
  <title>Shipping Info - Feature Desk</title>
  <meta name="description" content="Learn about shopping on Feature Desk - ordering, shipping, payments, returns, and customer service.">
  <meta name="keywords" content="shopping guide, how to shop, ordering process, shipping information, payment methods">
  <style>
    /* Shipping Info Styles */
    :root {
      --primary: #BD8802;
      --primary-light: #ff4757;
      --dark: #1a1a2e;
      --light: #f8f9fa;
      --gray: #6c757d;
      --border: #e0e0e0;
    }

    .shopping-info {
      padding: 60px 0;
      background: var(--light);
    }

    .info-section {
      margin-bottom: 50px;
      padding: 30px;
      background: white;
      border-radius: 10px;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    }

    .info-section:last-child {
      margin-bottom: 0;
    }

    .info-title {
      font-size: 1.5rem;
      color: var(--primary);
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 2px solid rgba(238, 39, 55, 0.1);
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .info-title i {
      font-size: 1.2rem;
    }

    .info-content {
      color: var(--dark);
      line-height: 1.6;
    }

    .info-content p {
      margin-bottom: 15px;
    }

    .info-list {
      margin: 20px 0;
      padding-left: 20px;
    }

    .info-list li {
      margin-bottom: 10px;
      padding-left: 5px;
    }

    .info-list li:last-child {
      margin-bottom: 0;
    }

    .important-note {
      background: #fff8e1;
      border-left: 4px solid #ffc107;
      padding: 15px;
      margin: 20px 0;
      border-radius: 0 5px 5px 0;
    }

    .contact-link {
      color: var(--primary);
      font-weight: 600;
      text-decoration: none;
    }

    .contact-link:hover {
      color: var(--primary-light);
      text-decoration: underline;
    }

    /* Simple Grid for Important Info */
    .quick-info {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      margin: 40px 0;
    }

    .info-point {
      background: white;
      padding: 20px;
      border-radius: 8px;
      border-left: 4px solid var(--primary);
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .info-point h3 {
      font-size: 1.1rem;
      color: var(--dark);
      margin-bottom: 10px;
    }

    .info-point p {
      color: var(--gray);
      font-size: 0.95rem;
    }

    /* Responsive */
    @media (max-width: 768px) {

      .shopping-info {
        padding: 40px 0;
      }

      .info-section {
        padding: 20px;
        margin-bottom: 30px;
      }

      .info-title {
        font-size: 1.3rem;
      }

      .quick-info {
        grid-template-columns: 1fr;
      }
    }

    @media (max-width: 480px) {

      .info-title {
        font-size: 1.2rem;
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
                Shipping Info
            </ol>
          </nav>

        </div>

      </div>

      {{-- Page Title / H1 --}}
      <div class="mt-3">
        <h1 class="h3 mb-0 fw-bold text-dark">
          Shipping Information
        </h1>
        <p class="text-muted mt-2 mb-0">Everything you need to know about shopping on Feature Desk.</p>
      </div>
    </div>
  </section>
  {{-- ====================== END BREADCRUMBS + TITLE ====================== --}}


  <!-- Main Shipping Info -->
  <section class="shopping-info">
    <div class="container">
      <!-- How to Order -->
      <div class="info-section">
        <h2 class="info-title"><i class="fas fa-shopping-cart"></i> How to Order</h2>
        <div class="info-content">
          <p>Ordering on Feature Desk is simple and straightforward:</p>
          <ol class="info-list">
            <li><strong>Browse Products:</strong> Search or navigate through categories to find what you want</li>
            <li><strong>Add to Cart:</strong> Click "Add to Cart" for items you wish to purchase</li>
            <li><strong>Review Cart:</strong> Go to your cart to review items, quantities, and total</li>
            <li><strong>Checkout:</strong> Proceed to checkout and enter your shipping details</li>
            <li><strong>Payment:</strong> Choose your payment method and complete the transaction</li>
            <li><strong>Confirmation:</strong> You'll receive an order confirmation via email</li>
          </ol>
          <p>You can track your order status from your account dashboard.</p>
        </div>
      </div>

      <!-- Shipping Information -->
      <div class="info-section">
        <h2 class="info-title"><i class="fas fa-shipping-fast"></i> Shipping Information</h2>
        <div class="info-content">
          <p><strong>Delivery Areas:</strong> We deliver to all major cities across Pakistan.</p>
          <p><strong>Shipping Time:</strong> Most orders are delivered within 5-8 business days.</p>
          <p><strong>Express Delivery:</strong> Available for select locations with 2-3 day delivery.</p>
          <p><strong>Shipping Charges:</strong> Calculated based on location and order weight. Free shipping available on orders over Rs. 1,999.</p>
          <div class="important-note">
            <strong>Note:</strong> Delivery times may be extended during sale events, holidays, or due to weather conditions.
          </div>
        </div>
      </div>

      <!-- Payment Methods -->
      <div class="info-section">
        <h2 class="info-title"><i class="fas fa-credit-card"></i> Payment Methods</h2>
        <div class="info-content">
          <p>We accept the following payment methods:</p>
          <ul class="info-list">
            <li><strong>Cash on Delivery:</strong> Pay when you receive your order (available in select areas)</li>
            <li><strong>Credit/Debit Cards:</strong> Visa, MasterCard</li>
            <li><strong>Bank Transfer:</strong> Direct bank deposit</li>
            <li><strong>Mobile Wallets:</strong> Easypaisa, JazzCash</li>
          </ul>
          <p>All payments are processed through secure channels to protect your information.</p>
        </div>
      </div>

      <!-- Returns & Refunds -->
      <div class="info-section">
        <h2 class="info-title"><i class="fas fa-exchange-alt"></i> Returns & Refunds</h2>
        <div class="info-content">
          <p><strong>Return Policy:</strong> Most items can be returned within 30 days of delivery.</p>
          <p><strong>Conditions:</strong> Items must be unused, in original packaging, with tags attached.</p>
          <p><strong>Refund Process:</strong> Refunds are processed within 5-10 business days after we receive the returned item.</p>
          <p><strong>Return Shipping:</strong> Return shipping fees may apply depending on the reason for return.</p>
        </div>
      </div>

      <!-- Quick Important Info -->
      <div class="quick-info">
        <div class="info-point">
          <h3>Customer Support</h3>
          <p>Need help? Contact our support team at <a href="tel:+447412803448" class="contact-link">+44 741 2803448</a> or <a href="mailto:info@featuredesk.site" class="contact-link">info@featuredesk.site</a></p>
        </div>

        <div class="info-point">
          <h3>Account Creation</h3>
          <p>Create an account to track orders, save favorites, and get personalized offers.</p>
        </div>

        <div class="info-point">
          <h3>Coupons & Discounts</h3>
          <p>Apply coupon codes at checkout. Check our promotions page for current offers.</p>
        </div>
      </div>

      <!-- Contact Info -->
      <div class="info-section">
        <h2 class="info-title"><i class="fas fa-headset"></i> Need More Help?</h2>
        <div class="info-content">
          <p>If you have any questions or need assistance with your shopping experience, please contact us:</p>
          <p><strong>Email:</strong> <a href="mailto:info@featuredesk.site" class="contact-link">info@featuredesk.site</a></p>
          <p><strong>Phone:</strong> <a href="tel:+447412803448" class="contact-link">+44 741 2803448</a></p>
          <p><strong>Hours:</strong> Monday to Saturday, 9:00 AM to 7:00 PM</p>
          <p>We're here to help you have the best shopping experience!</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  @include('market.website.includes.footer')
  @include('market.website.includes.footer_links')

  <script>
    // Simple script for contact links
    document.querySelectorAll('.contact-link').forEach(link => {
      link.addEventListener('click', function(e) {
        // You could add analytics tracking here
        console.log('Contact link clicked:', this.href);
      });
    });

    // Smooth scroll for any anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const targetId = this.getAttribute('href');
        if (targetId !== '#') {
          const targetElement = document.querySelector(targetId);
          if (targetElement) {
            targetElement.scrollIntoView({
              behavior: 'smooth',
              block: 'start'
            });
          }
        }
      });
    });
  </script>
</body>

</html>