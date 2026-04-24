<!doctype html>
<html lang="en">

<head>
  <!-- Open Graph / Social Media -->
<meta property="og:title" content="Returns & Refunds - Feature Desk">
<meta property="og:description" content="Learn about Feature Desk's return and refund policy. How to return items, get refunds, and conditions for returns.">

  @include('market.website.includes.header_links')
  <title>Returns & Refunds - Feature Desk</title>
  <meta name="description" content="Learn about Feature Desk's return and refund policy. How to return items, get refunds, and conditions for returns.">
  <meta name="keywords" content="return policy, refund policy, how to return, return items, money back">
  <style>
    /* Returns & Refunds Styles */
    :root {
      --primary: #BD8802;
      --primary-light: #ff4757;
      --dark: #1a1a2e;
      --light: #f8f9fa;
      --gray: #6c757d;
      --border: #e0e0e0;
      --success: #28a745;
      --warning: #ffc107;
    }



    .returns-main {
      padding: 60px 0;
      background: var(--light);
    }

    .policy-section {
      margin-bottom: 40px;
      padding: 30px;
      background: white;
      border-radius: 10px;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    }

    .policy-title {
      font-size: 1.5rem;
      color: var(--primary);
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 2px solid rgba(238, 39, 55, 0.1);
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .policy-title i {
      font-size: 1.2rem;
    }

    .policy-content {
      color: var(--dark);
      line-height: 1.6;
    }

    .policy-content p {
      margin-bottom: 15px;
    }

    /* Policy Points */
    .policy-points {
      margin: 20px 0;
    }

    .policy-point {
      margin-bottom: 15px;
      padding-left: 25px;
      position: relative;
    }

    .policy-point:before {
      content: "•";
      color: var(--primary);
      font-size: 1.5rem;
      position: absolute;
      left: 0;
      top: -2px;
    }

    /* Important Notes */
    .important-box {
      background: #fff8e1;
      border-left: 4px solid var(--warning);
      padding: 20px;
      margin: 25px 0;
      border-radius: 0 5px 5px 0;
    }

    .important-box h4 {
      color: #856404;
      margin-bottom: 10px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    /* Return Steps */
    .return-steps {
      margin: 30px 0;
      counter-reset: step-counter;
    }

    .step {
      margin-bottom: 25px;
      padding-left: 50px;
      position: relative;
    }

    .step:before {
      counter-increment: step-counter;
      content: counter(step-counter);
      position: absolute;
      left: 0;
      top: 0;
      width: 35px;
      height: 35px;
      background: var(--primary);
      color: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
    }

    .step h4 {
      margin-bottom: 8px;
      color: var(--dark);
    }

    /* Timeline */
    .timeline {
      margin: 30px 0;
      padding: 20px;
      background: #f8f9fa;
      border-radius: 8px;
      border-left: 4px solid var(--success);
    }

    .timeline h4 {
      color: var(--success);
      margin-bottom: 15px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .timeline-point {
      margin-bottom: 10px;
      padding-left: 20px;
      position: relative;
    }

    .timeline-point:before {
      content: "→";
      position: absolute;
      left: 0;
      color: var(--gray);
    }

    /* Contact Box */
    .contact-box {
      background: #e8f4fd;
      border-left: 4px solid #007bff;
      padding: 25px;
      margin: 30px 0;
      border-radius: 0 8px 8px 0;
    }

    .contact-box h4 {
      color: #0056b3;
      margin-bottom: 15px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .contact-links {
      margin-top: 15px;
    }

    .contact-link {
      color: var(--primary);
      font-weight: 600;
      text-decoration: none;
      margin-right: 20px;
    }

    .contact-link:hover {
      color: var(--primary-light);
      text-decoration: underline;
    }

    /* Non-Returnable Items */
    .non-returnable {
      background: #f8d7da;
      border-left: 4px solid #dc3545;
      padding: 20px;
      margin: 25px 0;
      border-radius: 0 5px 5px 0;
    }

    .non-returnable h4 {
      color: #721c24;
      margin-bottom: 10px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    /* Simple Table */
    .simple-table {
      width: 100%;
      margin: 20px 0;
      border-collapse: collapse;
    }

    .simple-table th {
      background: #f8f9fa;
      padding: 12px;
      text-align: left;
      border-bottom: 2px solid var(--border);
      color: var(--dark);
    }

    .simple-table td {
      padding: 12px;
      border-bottom: 1px solid var(--border);
      color: var(--gray);
    }

    .simple-table tr:last-child td {
      border-bottom: none;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .returns-main {
        padding: 40px 0;
      }

      .policy-section {
        padding: 20px;
        margin-bottom: 30px;
      }

      .policy-title {
        font-size: 1.3rem;
      }

      .step {
        padding-left: 45px;
      }

      .simple-table {
        display: block;
        overflow-x: auto;
      }
    }

    @media (max-width: 480px) {
      .policy-title {
        font-size: 1.2rem;
      }

      .contact-link {
        display: block;
        margin-bottom: 10px;
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
                Returns & Refunds
              </li>
            </ol>
          </nav>

        </div>

      </div>

      {{-- Page Title / H1 --}}
      <div class="mt-3">
        <h1 class="h3 mb-0 fw-bold text-dark">
          Returns & Refunds Policy
        </h1>
        <p class="text-muted mt-2 mb-0">Our policy for returns and refunds. Simple, fair, and customer-friendly.</p>
      </div>
    </div>
  </section>
  {{-- ====================== END BREADCRUMBS + TITLE ====================== --}}


  <!-- Main Returns Content -->
  <section class="returns-main">
    <div class="container">
      <!-- Return Policy Overview -->
      <div class="policy-section">
        <h2 class="policy-title"><i class="fas fa-exchange-alt"></i> Return Policy Overview</h2>
        <div class="policy-content">
          <p>We want you to be completely satisfied with your purchase. If you're not happy with your order, you can return it within our policy period.</p>

          <div class="policy-points">
            <div class="policy-point">30-day return window from delivery date</div>
            <div class="policy-point">Items must be in original condition</div>
            <div class="policy-point">Original packaging and tags must be intact</div>
            <div class="policy-point">Proof of purchase required</div>
          </div>

          <div class="important-box">
            <h4><i class="fas fa-exclamation-circle"></i> Important</h4>
            <p>Some items may have different return conditions. Please check product details before purchase.</p>
          </div>
        </div>
      </div>

      <!-- How to Return -->
      <div class="policy-section">
        <h2 class="policy-title"><i class="fas fa-undo-alt"></i> How to Return an Item</h2>
        <div class="policy-content">
          <p>Follow these simple steps to return an item:</p>

          <div class="return-steps">
            <div class="step">
              <h4>Initiate Return</h4>
              <p>Go to "My Orders" in your account and select the item you want to return.</p>
            </div>

            <div class="step">
              <h4>Select Reason</h4>
              <p>Choose the reason for return from the available options.</p>
            </div>

            <div class="step">
              <h4>Print Label</h4>
              <p>Print the return label provided and attach it to your package.</p>
            </div>

            <div class="step">
              <h4>Pack & Ship</h4>
              <p>Pack the item securely with all original accessories and ship it to our return center.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Refund Process -->
      <div class="policy-section">
        <h2 class="policy-title"><i class="fas fa-money-bill-wave"></i> Refund Process</h2>
        <div class="policy-content">
          <p>Once we receive your returned item, here's what happens:</p>

          <div class="timeline">
            <h4><i class="fas fa-clock"></i> Refund Timeline</h4>
            <div class="timeline-point">Item received at return center</div>
            <div class="timeline-point">Quality check (2-3 business days)</div>
            <div class="timeline-point">Refund approval</div>
            <div class="timeline-point">Refund processed (5-10 business days)</div>
            <div class="timeline-point">Amount credited to your account</div>
          </div>

          <p><strong>Refund Method:</strong> Refunds are issued to the original payment method used for purchase.</p>
          <p><strong>Processing Time:</strong> Refunds typically take 5-10 business days to appear in your account after approval.</p>
        </div>
      </div>

      <!-- Non-Returnable Items -->
      <div class="policy-section">
        <h2 class="policy-title"><i class="fas fa-ban"></i> Non-Returnable Items</h2>
        <div class="policy-content">
          <p>For health and safety reasons, some items cannot be returned:</p>

          <div class="non-returnable">
            <h4><i class="fas fa-exclamation-triangle"></i> Items that cannot be returned:</h4>
            <div class="policy-points">
              <div class="policy-point">Personal care items (unless sealed)</div>
              <div class="policy-point">Underwear and innerwear</div>
              <div class="policy-point">Customized or personalized products</div>
              <div class="policy-point">Gift cards and vouchers</div>
              <div class="policy-point">Perishable goods</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Return Charges -->
      <div class="policy-section">
        <h2 class="policy-title"><i class="fas fa-truck"></i> Return Shipping Charges</h2>
        <div class="policy-content">
          <table class="simple-table">
            <tr>
              <th>Return Reason</th>
              <th>Shipping Charges</th>
            </tr>
            <tr>
              <td>Wrong item received</td>
              <td>Free return</td>
            </tr>
            <tr>
              <td>Damaged or defective item</td>
              <td>Free return</td>
            </tr>
            <tr>
              <td>Changed your mind</td>
              <td>Customer pays return shipping</td>
            </tr>
            <tr>
              <td>Size or color change</td>
              <td>Customer pays return shipping</td>
            </tr>
          </table>
        </div>
      </div>

      <!-- Contact for Returns -->
      <div class="policy-section">
        <h2 class="policy-title"><i class="fas fa-headset"></i> Need Help with Returns?</h2>
        <div class="policy-content">
          <p>If you need assistance with your return or have questions about our policy, contact our support team:</p>

          <div class="contact-box">
            <h4><i class="fas fa-comments"></i> Contact Options</h4>
            <p>Our team is available to help you with return-related queries.</p>

            <div class="contact-links">
              <!-- <a href="mailto:returns@FeatureDesk" class="contact-link">
                <i class="fas fa-envelope"></i> returns@FeatureDesk
              </a> -->
              <a href="tel:+447412803448" class="contact-link">
                <i class="fas fa-phone"></i> +44 7412 803448
              </a>
            </div>

            <p style="margin-top: 15px; font-size: 0.9rem; color: var(--gray);">
              <i class="fas fa-clock"></i> Support Hours: Mon-Sat, 9:00 AM - 7:00 PM
            </p>
          </div>

          <p><strong>Note:</strong> Please have your order number ready when contacting support for faster assistance.</p>
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
        console.log('Returns contact link clicked:', this.href);
      });
    });

    // Add smooth scrolling for any anchor links
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

    // Simple table row hover effect
    document.querySelectorAll('.simple-table tr').forEach(row => {
      row.addEventListener('mouseenter', function() {
        this.style.backgroundColor = '#f8f9fa';
      });

      row.addEventListener('mouseleave', function() {
        this.style.backgroundColor = '';
      });
    });
  </script>
</body>

</html>