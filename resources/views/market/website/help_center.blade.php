<!doctype html>
<html lang="en">

<head>
  <!-- Open Graph / Social Media -->
<meta property="og:title" content="Help Center - Feature Desk">
<meta property="og:description" content="Get help with your Feature Desk orders, shipping, returns, payments, and more. Find answers to frequently asked questions.">

    @include('market.website.includes.header_links')
    <title>Help Center - Feature Desk</title>
    <meta name="description" content="Get help with your Feature Desk orders, shipping, returns, payments, and more. Find answers to frequently asked questions.">
    <meta name="keywords" content="help center, customer support, faq, order help, shipping info, returns policy">
    <style>
        /* Help Center Specific Styles */
        :root {
            --primary: #BD8802;
            --primary-light: #ff4757;
            --dark: #1a1a2e;
            --light: #f8f9fa;
            --gray: #6c757d;
            --border: #e0e0e0;
        }
        
        .help-categories {
            padding: 60px 0;
            background: var(--light);
        }
        
        .category-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-top: 40px;
        }
        
        .category-card {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
            cursor: pointer;
        }
        
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .category-icon {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 20px;
            display: block;
        }
        
        .category-card h3 {
            font-size: 1.3rem;
            margin-bottom: 10px;
            color: var(--dark);
        }
        
        .category-card p {
            color: var(--gray);
            font-size: 0.95rem;
            margin-bottom: 15px;
        }
        
        .article-count {
            color: var(--primary);
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .faq-section {
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
        
        .accordion-item {
            border: 1px solid var(--border);
            border-radius: 8px;
            margin-bottom: 15px;
            overflow: hidden;
        }
        
        .accordion-header {
            padding: 20px;
            background: white;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 600;
        }
        
        .accordion-header.active {
            background: #fff5f5;
            color: var(--primary);
        }
        
        .accordion-icon {
            transition: transform 0.3s ease;
        }
        
        .accordion-header.active .accordion-icon {
            transform: rotate(180deg);
        }
        
        .accordion-content {
            padding: 0 20px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            border-top: 1px solid var(--border);
        }
        
        .accordion-content.active {
            padding: 20px;
            max-height: 500px;
        }
        
        .contact-section {
            padding: 60px 0;
            background: var(--light);
        }
        
        .contact-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-top: 40px;
        }
        
        .contact-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        
        .contact-icon {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 20px;
            display: block;
        }
        
        .contact-btn {
            display: inline-block;
            background: var(--primary);
            color: white;
            padding: 10px 25px;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 15px;
            transition: background 0.3s ease;
        }
        
        .contact-btn:hover {
            background: var(--primary-light);
            color: white;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            
            .help-categories, .faq-section, .contact-section {
                padding: 40px 0;
            }
            
            .category-grid, .contact-options {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 480px) {
            
            .section-title {
                font-size: 1.5rem;
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
                Help Center
              </li>
            </ol>
          </nav>

        </div>

      </div>

      {{-- Page Title / H1 --}}
      <div class="mt-3">
        <h1 class="h3 mb-0 fw-bold text-dark">
          How can we help you?
        </h1>
        <p class="text-muted mt-2 mb-0">Find answers to common questions about orders, shipping, payments, and more.</p>
      </div>
    </div>
  </section>
  {{-- ====================== END BREADCRUMBS + TITLE ====================== --}}


    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="container">
            <h2 class="section-title">Frequently Asked Questions</h2>
            
            <div class="accordion">
                <div class="accordion-item">
                    <div class="accordion-header">
                        <span>How do I track my order?</span>
                        <i class="fas fa-chevron-down accordion-icon"></i>
                    </div>
                    <div class="accordion-content">
                        <p>You can track your order by logging into your account and visiting "My Orders". You'll receive tracking information via email once your order ships.</p>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <div class="accordion-header">
                        <span>What is your return policy?</span>
                        <i class="fas fa-chevron-down accordion-icon"></i>
                    </div>
                    <div class="accordion-content">
                        <p>We offer a 30-day return policy for most items. Items must be in original condition with tags attached. Some items may have different return conditions.</p>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <div class="accordion-header">
                        <span>How long does shipping take?</span>
                        <i class="fas fa-chevron-down accordion-icon"></i>
                    </div>
                    <div class="accordion-content">
                        <p>Standard shipping takes 5-8 business days. Express shipping is available for 2-3 business days. Delivery times may vary during sale events.</p>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <div class="accordion-header">
                        <span>What payment methods do you accept?</span>
                        <i class="fas fa-chevron-down accordion-icon"></i>
                    </div>
                    <div class="accordion-content">
                        <p>We accept credit/debit cards (Visa, MasterCard), bank transfers, and cash on delivery in select areas.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            <h2 class="section-title">Still need help?</h2>
            <p>Get in touch with our support team for personalized assistance.</p>
            
            <div class="contact-options">
                <div class="contact-card">
                    <i class="fas fa-envelope contact-icon"></i>
                    <h3>Email Support</h3>
                    <p>Send us an email and we'll respond within 24 hours.</p>
                    <a href="mailto:info@featuredesk.site" class="contact-btn">Email Us</a>
                </div>
                
                <div class="contact-card">
                    <i class="fas fa-phone contact-icon"></i>
                    <h3>Phone Support</h3>
                    <p>Call us for immediate assistance with your queries.</p>
                    <a href="tel:+447412803448" class="contact-btn">Call Now</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('market.website.includes.footer')
    @include('market.website.includes.footer_links')

    <script>
        // Accordion functionality
        document.querySelectorAll('.accordion-header').forEach(header => {
            header.addEventListener('click', () => {
                const content = header.nextElementSibling;
                const isActive = header.classList.contains('active');
                
                // Close all accordions
                document.querySelectorAll('.accordion-header').forEach(h => {
                    h.classList.remove('active');
                    h.nextElementSibling.classList.remove('active');
                });
                
                // Open clicked accordion if it wasn't active
                if (!isActive) {
                    header.classList.add('active');
                    content.classList.add('active');
                }
            });
        });
        
        // Category card click
        document.querySelectorAll('.category-card').forEach(card => {
            card.addEventListener('click', function() {
                const category = this.querySelector('h3').textContent;
                // In a real implementation, this would open the category page
                alert(`Opening category: ${category}`);
            });
        });
        
        // Contact button handling
        document.querySelectorAll('.contact-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                if (this.href.includes('mailto:') || this.href.includes('tel:')) {
                    // Allow default behavior for mailto and tel links
                    return;
                }
                e.preventDefault();
                const contactMethod = this.parentElement.querySelector('h3').textContent;
                alert(`Connecting to ${contactMethod} support`);
            });
        });
        
        // Initialize first accordion as open
        document.querySelector('.accordion-header').click();
    </script>
</body>

</html>