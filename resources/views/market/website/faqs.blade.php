<!doctype html>
<html lang="en">

<head>
    <!-- Open Graph / Social Media -->
    <meta property="og:title" content="FAQs - Feature Desk">
    <meta property="og:description" content="Frequently Asked Questions about Feature Desk. Find answers about orders, shipping, payments, returns, and account management.">

    @include('market.website.includes.header_links')
    <title>FAQs - Feature Desk</title>
    <meta name="description" content="Frequently Asked Questions about Feature Desk. Find answers about orders, shipping, payments, returns, and account management.">
    <meta name="keywords" content="faqs, frequently asked questions, help, support, customer service">
    <style>
        /* FAQs Specific Styles */
        :root {
            --primary: #BD8802;
            --primary-light: #ff4757;
            --dark: #1a1a2e;
            --light: #f8f9fa;
            --gray: #6c757d;
            --border: #e0e0e0;
        }

        .faq-main {
            padding: 80px 0;
            background: var(--light);
        }

        .section-title {
            font-size: 2.2rem;
            color: var(--dark);
            margin-bottom: 40px;
            text-align: center;
            position: relative;
            padding-bottom: 20px;
        }

        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: var(--primary);
            border-radius: 2px;
        }

        /* FAQ Categories */
        .category-card {
            background: white;
            border-radius: 15px;
            padding: 40px 30px;
            text-align: center;
            height: 100%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .category-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
            border-color: var(--primary);
        }

        .category-card.active {
            border-color: var(--primary);
            background: #fff5f5;
        }

        .category-card.active:after {
            content: '✓';
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--primary);
            color: white;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
        }

        .category-icon {
            font-size: 3.5rem;
            color: var(--primary);
            margin-bottom: 25px;
            display: inline-block;
            transition: transform 0.3s ease;
        }

        .category-card:hover .category-icon {
            transform: scale(1.1);
        }

        .category-card h3 {
            font-size: 1.4rem;
            color: var(--dark);
            margin-bottom: 15px;
            font-weight: 600;
        }

        .category-card p {
            color: var(--gray);
            font-size: 0.95rem;
            margin-bottom: 20px;
        }

        .faq-count {
            display: inline-block;
            background: rgba(238, 39, 55, 0.1);
            color: var(--primary);
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        /* FAQ Accordion */
        .faq-accordion {
            margin-top: 60px;
        }

        .accordion-item {
            background: white;
            border-radius: 12px;
            margin-bottom: 20px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border);
            transition: all 0.3s ease;
            display: block !important;
            /* Ensure all items are visible by default */
        }

        .accordion-item.hidden {
            display: none !important;
        }

        .accordion-item[data-category] {
            /* For filtering functionality */
        }

        .accordion-item:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .accordion-header {
            padding: 25px 30px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 600;
            font-size: 1.1rem;
            color: var(--dark);
            transition: all 0.3s ease;
            background: white;
        }

        .accordion-header:hover {
            background: #f9f9f9;
        }

        .accordion-header.active {
            background: #fff5f5;
            color: var(--primary);
        }

        .accordion-icon {
            font-size: 1.2rem;
            transition: transform 0.3s ease;
            color: var(--primary);
        }

        .accordion-header.active .accordion-icon {
            transform: rotate(180deg);
        }

        .accordion-content {
            padding: 0 30px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease, padding 0.3s ease;
            color: var(--gray);
            line-height: 1.7;
        }

        .accordion-content.active {
            padding: 0 30px 30px;
            max-height: 1000px;
        }

        /* FAQ Category Tag */
        .faq-category-tag {
            display: inline-block;
            background: rgba(238, 39, 55, 0.1);
            color: var(--primary);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-right: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Filter Controls */
        .faq-filter-controls {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 10px 25px;
            background: white;
            border: 2px solid var(--border);
            border-radius: 50px;
            font-weight: 600;
            color: var(--dark);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-btn:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .filter-btn.active {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
        }

        /* No Results Message */
        .no-results {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            display: none;
        }

        .no-results.show {
            display: block;
        }

        .no-results i {
            font-size: 4rem;
            color: var(--gray);
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .no-results h4 {
            color: var(--dark);
            margin-bottom: 10px;
        }

        .no-results p {
            color: var(--gray);
            max-width: 400px;
            margin: 0 auto;
        }

        /* Search Box */
        .faq-search-box {
            max-width: 600px;
            margin: 0 auto 40px;
            position: relative;
        }

        .faq-search-box input {
            width: 100%;
            padding: 15px 20px;
            padding-left: 50px;
            border: 2px solid var(--border);
            border-radius: 50px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .faq-search-box input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(238, 39, 55, 0.1);
        }

        .faq-search-box i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
            font-size: 1.2rem;
        }

        /* Contact Section */
        .contact-section {
            padding: 80px 0;
            background: white;
        }

        .contact-box {
            background: linear-gradient(135deg, var(--primary), #ff416c);
            border-radius: 20px;
            padding: 60px;
            color: white;
            text-align: center;
        }

        .contact-box h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: white;
        }

        .contact-box p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 30px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .contact-links {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
        }

        .contact-btn {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            color: white;
            padding: 15px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .contact-btn:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-3px);
            color: white;
        }

        /* FAQ Categories Grid */
        .category-grid {
            margin-bottom: 40px;
        }

        /* Responsive */
        @media (max-width: 992px) {

            .section-title {
                font-size: 2rem;
            }

            .contact-box {
                padding: 40px 30px;
            }
        }

        @media (max-width: 768px) {

            .faq-main {
                padding: 60px 0;
            }

            .section-title {
                font-size: 1.8rem;
                margin-bottom: 30px;
            }

            .category-card {
                padding: 30px 20px;
            }

            .category-icon {
                font-size: 3rem;
            }

            .contact-links {
                flex-direction: column;
                align-items: center;
                gap: 15px;
            }

            .contact-btn {
                width: 100%;
                max-width: 300px;
                justify-content: center;
            }

            .faq-filter-controls {
                gap: 8px;
            }

            .filter-btn {
                padding: 8px 20px;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 576px) {
            .section-title {
                font-size: 1.6rem;
            }

            .accordion-header {
                padding: 20px;
                font-size: 1rem;
            }

            .accordion-content {
                padding: 0 20px;
            }

            .accordion-content.active {
                padding: 0 20px 20px;
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
                                FAQ's
                            </li>
                        </ol>
                    </nav>

                </div>

            </div>

            {{-- Page Title / H1 --}}
            <div class="mt-3">
                <h1 class="h3 mb-0 fw-bold text-dark">
                    Frequently Asked Questions
                </h1>
                <p class="text-muted mt-2 mb-0">Find quick answers to common questions about shopping on Feature Desk.</p>
            </div>
        </div>
    </section>
    {{-- ====================== END BREADCRUMBS + TITLE ====================== --}}

    <!-- FAQ Main Content -->
    <section class="faq-main">
        <div class="container">
            <!-- FAQ Categories -->
            <h2 class="section-title">Browse by Category</h2>

            <div class="row category-grid">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="category-card" data-category="all">
                        <i class="fas fa-list-alt category-icon"></i>
                        <h3>All FAQs</h3>
                        <p>Browse all frequently asked questions</p>
                        <div class="faq-count">36 FAQs</div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="category-card" data-category="orders">
                        <i class="fas fa-shopping-cart category-icon"></i>
                        <h3>Orders</h3>
                        <p>Order tracking, cancellations, and modifications</p>
                        <div class="faq-count">12 FAQs</div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="category-card" data-category="shipping">
                        <i class="fas fa-shipping-fast category-icon"></i>
                        <h3>Shipping</h3>
                        <p>Delivery times, tracking, and shipping fees</p>
                        <div class="faq-count">8 FAQs</div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="category-card" data-category="payments">
                        <i class="fas fa-credit-card category-icon"></i>
                        <h3>Payments</h3>
                        <p>Payment methods, refunds, and billing</p>
                        <div class="faq-count">10 FAQs</div>
                    </div>
                </div>
            </div>

            <!-- FAQ Search -->
            <div class="faq-search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="faqSearch" placeholder="Search for questions or keywords...">
            </div>

            <!-- FAQ Filter Buttons -->
            <div class="faq-filter-controls">
                <button class="filter-btn active" data-filter="all">All</button>
                <button class="filter-btn" data-filter="orders">Orders</button>
                <button class="filter-btn" data-filter="shipping">Shipping</button>
                <button class="filter-btn" data-filter="payments">Payments</button>
                <button class="filter-btn" data-filter="returns">Returns</button>
                <button class="filter-btn" data-filter="account">Account</button>
            </div>

            <!-- FAQ Accordion -->
            <div class="faq-accordion">
                <h2 class="section-title">Most Popular Questions</h2>

                <!-- No Results Message -->
                <div class="no-results" id="noResults">
                    <i class="fas fa-search"></i>
                    <h4>No FAQs Found</h4>
                    <p>We couldn't find any FAQs matching your search. Try different keywords or browse all categories.</p>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="accordion-item" data-category="orders">
                            <div class="accordion-header">
                                <span><span class="faq-category-tag">Orders</span>How do I track my order?</span>
                                <i class="fas fa-chevron-down accordion-icon"></i>
                            </div>
                            <div class="accordion-content">
                                <p>You can track your order by logging into your Feature Desk account and going to "My Orders" section. You'll also receive tracking information via email once your order ships.</p>
                            </div>
                        </div>

                        <div class="accordion-item" data-category="payments">
                            <div class="accordion-header">
                                <span><span class="faq-category-tag">Payments</span>What payment methods do you accept?</span>
                                <i class="fas fa-chevron-down accordion-icon"></i>
                            </div>
                            <div class="accordion-content">
                                <p>We accept Cash on Delivery, credit/debit cards (Visa, MasterCard), bank transfers, and mobile wallets (Easypaisa, JazzCash).</p>
                            </div>
                        </div>

                        <div class="accordion-item" data-category="shipping">
                            <div class="accordion-header">
                                <span><span class="faq-category-tag">Shipping</span>How long does shipping take?</span>
                                <i class="fas fa-chevron-down accordion-icon"></i>
                            </div>
                            <div class="accordion-content">
                                <p>Standard shipping takes 5-8 business days. Express shipping (2-3 days) is available in select areas. Delivery times may vary during sale events.</p>
                            </div>
                        </div>

                        <div class="accordion-item" data-category="orders">
                            <div class="accordion-header">
                                <span><span class="faq-category-tag">Orders</span>Can I change my delivery address?</span>
                                <i class="fas fa-chevron-down accordion-icon"></i>
                            </div>
                            <div class="accordion-content">
                                <p>Yes, you can change your delivery address before your order ships. Go to "My Orders" and select "Change Address". Once shipped, address changes are not possible.</p>
                            </div>
                        </div>

                        <div class="accordion-item" data-category="account">
                            <div class="accordion-header">
                                <span><span class="faq-category-tag">Account</span>How do I reset my password?</span>
                                <i class="fas fa-chevron-down accordion-icon"></i>
                            </div>
                            <div class="accordion-content">
                                <p>Click "Forgot Password" on the login page. Enter your email address and follow the instructions sent to your email to reset your password.</p>
                            </div>
                        </div>

                        <div class="accordion-item" data-category="orders">
                            <div class="accordion-header">
                                <span><span class="faq-category-tag">Orders</span>Can I modify my order?</span>
                                <i class="fas fa-chevron-down accordion-icon"></i>
                            </div>
                            <div class="accordion-content">
                                <p>Orders can be modified within 1 hour of placement. Go to "My Orders" and click "Modify Order". After this period, contact customer support.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="accordion-item" data-category="returns">
                            <div class="accordion-header">
                                <span><span class="faq-category-tag">Returns</span>What is your return policy?</span>
                                <i class="fas fa-chevron-down accordion-icon"></i>
                            </div>
                            <div class="accordion-content">
                                <p>Most items can be returned within 30 days of delivery. Items must be unused, in original packaging with tags attached. Some items have different return conditions.</p>
                            </div>
                        </div>

                        <div class="accordion-item" data-category="payments">
                            <div class="accordion-header">
                                <span><span class="faq-category-tag">Payments</span>How do I apply a coupon code?</span>
                                <i class="fas fa-chevron-down accordion-icon"></i>
                            </div>
                            <div class="accordion-content">
                                <p>During checkout, you'll see a "Apply Coupon" field. Enter your coupon code and click "Apply". The discount will be automatically deducted from your total.</p>
                            </div>
                        </div>

                        <div class="accordion-item" data-category="payments">
                            <div class="accordion-header">
                                <span><span class="faq-category-tag">Payments</span>Is Cash on Delivery available?</span>
                                <i class="fas fa-chevron-down accordion-icon"></i>
                            </div>
                            <div class="accordion-content">
                                <p>Yes, Cash on Delivery is available in most areas of Pakistan. There may be additional charges for COD orders in some remote locations.</p>
                            </div>
                        </div>

                        <div class="accordion-item" data-category="account">
                            <div class="accordion-header">
                                <span><span class="faq-category-tag">Account</span>How do I contact customer support?</span>
                                <i class="fas fa-chevron-down accordion-icon"></i>
                            </div>
                            <div class="accordion-content">
                                <p>You can contact us via email at support@FeatureDesk or call us at +44 7412 803448. We're available Monday to Saturday, 9:00 AM to 7:00 PM.</p>
                            </div>
                        </div>

                        <div class="accordion-item" data-category="returns">
                            <div class="accordion-header">
                                <span><span class="faq-category-tag">Returns</span>How do I start a return?</span>
                                <i class="fas fa-chevron-down accordion-icon"></i>
                            </div>
                            <div class="accordion-content">
                                <p>Go to "My Orders", select the item you want to return, and click "Return Item". Follow the instructions and we'll arrange pickup from your address.</p>
                            </div>
                        </div>

                        <div class="accordion-item" data-category="shipping">
                            <div class="accordion-header">
                                <span><span class="faq-category-tag">Shipping</span>Do you ship internationally?</span>
                                <i class="fas fa-chevron-down accordion-icon"></i>
                            </div>
                            <div class="accordion-content">
                                <p>Currently, we only ship within Pakistan. We're working to expand our shipping services to other countries in the future.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            <div class="contact-box">
                <h2>Still have questions?</h2>
                <p>Can't find what you're looking for? Our support team is here to help you.</p>

                <div class="contact-links">
                    <a href="mailto:info@featuredesk.site" class="contact-btn">
                        <i class="fas fa-envelope"></i> Email Support
                    </a>
                    <a href="tel:+447412803448" class="contact-btn">
                        <i class="fas fa-phone"></i> Call Now
                    </a>
                    <a href="/contact-us" class="contact-btn">
                        <i class="fas fa-headset"></i> Live Chat
                    </a>
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
                const item = header.parentElement;
                const content = header.nextElementSibling;

                // Toggle current item
                header.classList.toggle('active');
                content.classList.toggle('active');
            });
        });

        // Filter functionality
        let activeFilter = 'all';
        let searchTerm = '';

        // Category cards click
        document.querySelectorAll('.category-card').forEach(card => {
            card.addEventListener('click', function() {
                const category = this.getAttribute('data-category');

                // Update active state on category cards
                document.querySelectorAll('.category-card').forEach(c => {
                    c.classList.remove('active');
                });
                this.classList.add('active');

                // Update filter buttons
                document.querySelectorAll('.filter-btn').forEach(btn => {
                    btn.classList.remove('active');
                    if (btn.getAttribute('data-filter') === category) {
                        btn.classList.add('active');
                    }
                });

                // Apply filter
                filterFAQs(category, searchTerm);
            });
        });

        // Filter buttons click
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const filter = this.getAttribute('data-filter');

                // Update active state on filter buttons
                document.querySelectorAll('.filter-btn').forEach(b => {
                    b.classList.remove('active');
                });
                this.classList.add('active');

                // Update active state on category cards
                document.querySelectorAll('.category-card').forEach(card => {
                    card.classList.remove('active');
                    if (card.getAttribute('data-category') === filter) {
                        card.classList.add('active');
                    }
                });

                activeFilter = filter;
                filterFAQs(filter, searchTerm);
            });
        });

        // Search functionality
        const searchInput = document.getElementById('faqSearch');
        searchInput.addEventListener('input', function() {
            searchTerm = this.value.toLowerCase().trim();
            filterFAQs(activeFilter, searchTerm);
        });

        function filterFAQs(filter, search) {
            const allItems = document.querySelectorAll('.accordion-item');
            let visibleItems = 0;

            allItems.forEach(item => {
                const category = item.getAttribute('data-category');
                const question = item.querySelector('.accordion-header span').textContent.toLowerCase();
                const answer = item.querySelector('.accordion-content p').textContent.toLowerCase();

                // Check if item matches filter
                const matchesFilter = filter === 'all' || category === filter;

                // Check if item matches search
                const matchesSearch = !search ||
                    question.includes(search) ||
                    answer.includes(search) ||
                    category.includes(search);

                // Show/hide item based on both conditions
                if (matchesFilter && matchesSearch) {
                    item.classList.remove('hidden');
                    visibleItems++;
                } else {
                    item.classList.add('hidden');
                }

                // Close all accordions when filtering
                item.querySelector('.accordion-header').classList.remove('active');
                item.querySelector('.accordion-content').classList.remove('active');
            });

            // Show/hide no results message
            const noResults = document.getElementById('noResults');
            if (visibleItems === 0) {
                noResults.classList.add('show');
            } else {
                noResults.classList.remove('show');
            }
        }

        // Contact buttons
        document.querySelectorAll('.contact-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                if (this.href.includes('mailto:') || this.href.includes('tel:')) {
                    return; // Allow default behavior for email and phone
                }
                e.preventDefault();
                const action = this.querySelector('i').className;
                if (action.includes('headset')) {
                    // In production, this would connect to your chat service
                    window.location.href = '/contact-us';
                }
            });
        });

        // Initialize with first FAQ open
        document.querySelector('.accordion-header').click();
    </script>
</body>

</html>