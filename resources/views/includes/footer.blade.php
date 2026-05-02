<!-- WhatsApp Float Button -->
<a href="https://wa.me/971543041994" class="whatsapp-float">
  <i class='bx bxl-whatsapp'></i>
</a>

<style type="text/css">
  .whatsapp-float {
    position: fixed;
    bottom: 50px;
    right: 46px;
    background-color: #25D366;
    color: white;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
    font-size: 28px;
    z-index: 1000;
    transition: background-color 0.3s ease;
    text-decoration: none;
  }

  .whatsapp-float:hover {
    background-color: #128C7E;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  @media (max-width: 768px) {
    .whatsapp-float {
      width: 50px;
      height: 50px;
      font-size: 30px;
      right: 10px;
      bottom: 20px;
    }
  }
</style>

<!-- Temu-Inspired Footer with Bootstrap Grid -->
<footer class="temu-footer">
  <div class="container">
    <!-- Top Section: Navigation Links -->
    <div class="row footer-top g-4">
      <!-- <div class="col-md-3 col-sm-6 customer-service">
                <div class="footer-section">
                    <h3>Customer Service</h3>
                    <ul class="footer-links">
                        <li><a href="/help-center">Help Center</a></li>
                        <li><a href="/shipping-info">Shipping Info</a></li>
                        <li><a href="/track-order">Track Order</a></li>
                        <li><a href="/returns-refunds">Returns & Refunds</a></li>
                        <li><a href="/faqs">FAQ</a></li>
                    </ul>
                </div>
            </div> -->

      <!-- <div class="col-md-3 col-sm-6">
                <div class="footer-section">
                    <h3>About Us</h3>
                    <ul class="footer-links">
                        <li><a href="/about">About Us</a></li>
                        <li><a href="/contact-us">Contact Us</a></li>
                        <li><a href="/careers">Careers</a></li>
                        <li><a href="/blogs">Blogs</a></li>
                    </ul>
                </div>
            </div> -->

      <!-- <div class="col-md-3 col-sm-6">
                <div class="footer-section">
                    <h3>Shop With Us</h3>
                    <ul class="footer-links">
                        <li><a href="/new-products">New Arrivals</a></li>
                        <li><a href="/quick-selling">Quick Selling</a></li>
                        <li><a href="/high-rated">High Rated</a></li>
                        <li><a href="/categories">All Categories</a></li>
                    </ul>
                </div>
            </div> -->

      <div class="col-12">
        <div class="footer-section">
          <h3>Stay Connected</h3>
          <ul class="footer-links">
            <li>
              <a target="_blank" rel="nofollow noopener noreferrer" href="https://www.facebook.com/FeaturedeskOfficial" aria-label="Facebook">
                <i class='bx bxl-facebook'></i>
              </a>
            </li>
            <li>
              <a target="_blank" rel="nofollow noopener noreferrer" href="https://www.instagram.com/featuredeskofficial/" aria-label="Instagram">
                <i class='bx bxl-instagram'></i>
              </a>
            </li>
            <li>
              <a target="_blank" rel="nofollow noopener noreferrer" href="https://www.youtube.com/@featuredeskofficial" aria-label="YouTube">
                <i class='bx bxl-youtube'></i>
              </a>
            </li>
            <li>
              <a target="_blank" rel="nofollow noopener noreferrer" href="https://www.pinterest.com/FeaturedeskOfficial/" aria-label="Pinterest">
                <i class='bx bxl-pinterest'></i>
              </a>
            </li>
            <li>
              <a target="_blank" rel="nofollow noopener noreferrer" href="https://www.tiktok.com/@featuredeskofficial" aria-label="TikTok">
                <i class='bx bxl-tiktok'></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>



    <!-- Bottom Section: Payment Methods & Copyright -->
    <div class="footer-bottom">
      <div class="row align-items-center g-3">
        <div class="col-md-4">
          <div class="payment-methods">
            <span class="me-2">We Accept:</span>
            <div class="payment-icons d-inline-flex gap-2">
              <img src="/assets/images/payment/easypaisa.avif" alt="Easypaisa" title="Easypaisa" style="width: 32px; height: auto;">
              <img src="/assets/images/payment/jazzcash.avif" alt="Jazzcash" title="Jazzcash" style="width: 32px; height: auto;">
              <img src="/assets/images/payment/visa.avif" alt="VisaCard" title="VisaCard" style="width: 32px; height: auto;">
              <img src="/assets/images/payment/master.avif" alt="Mastercard" title="Mastercard" style="width: 32px; height: auto;">
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="legal-links d-flex justify-content-center gap-3 flex-wrap">
            <a href="/privacy-policy">Privacy Policy</a>
            <a href="/terms-of-service">Terms of Service</a>
            <a href="/cookie-policy">Cookie Policy</a>
            <a href="/sitemap">Sitemap</a>
          </div>
        </div>

        <div class="col-md-4">
          <div class="copyright text-md-end">
            <p class="mb-1">
              © <script>
                document.write(new Date().getFullYear())
              </script>
              ZipGo.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>

<style>
  /* Main Footer Styles */
  .temu-footer {
    background: linear-gradient(135deg, #1f2937, #111827);
    color: #e5e7eb;
    /* softer white for better readability */
    padding: 30px 0 20px;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    border-top: 1px solid rgba(255, 255, 255, 0.08);
  }

  /* Top Section */
  .footer-top {
    margin-bottom: 20px;
    padding-bottom: 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  }

  .footer-section h3 {
    color: #fff;
    font-size: 1.1rem;
    margin-bottom: 15px;
    font-weight: 600;
    position: relative;
    padding-bottom: 8px;
  }

  .footer-section h3::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    width: 30px;
    height: 2px;
    background: #BD8802;
  }

  .footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-wrap: wrap;
    /* Allows wrapping on small screens */
    gap: 20px;
    text-align: center;
    /* Space between items */
  }

  .footer-links li {
    display: inline-block;
    /* Makes each li inline */
  }

  .footer-links a {
    text-decoration: none;
    color: inherit;
    display: flex;
    align-items: center;
    gap: 8px;
    /* Space between icon and text */
    transition: color 0.3s;
  }

  .footer-links a:hover {
    color: #007bff;
    /* Change to your desired hover color */
  }

  .footer-links i {
    font-size: 2.0rem;
  }

  /* Middle Section - Improved Alignment */
  .footer-middle {
    margin-bottom: 20px;
    padding-bottom: 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  }

  .app-download h4,
  .newsletter h4 {
    color: #fff;
    margin-bottom: 8px;
    font-size: 1rem;
    font-weight: 600;
  }

  .app-buttons {
    display: flex;
    gap: 10px;
  }

  .app-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    background: rgba(255, 255, 255, 0.1);
    padding: 8px 12px;
    border-radius: 6px;
    text-decoration: none;
    color: #fff;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.2);
    min-width: 160px;
  }

  .app-btn:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-2px);
  }

  .app-btn i {
    font-size: 1.5rem;
  }

  .app-btn span {
    font-size: 0.75rem;
    line-height: 1.2;
  }

  .newsletter p {
    color: #b0b0b0;
    margin-bottom: 12px;
    font-size: 0.85rem;
  }

  .newsletter-form input {
    padding: 10px 12px;
    border: none;
    border-radius: 6px;
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
    width: 100%;
    border: 1px solid rgba(255, 255, 255, 0.2);
    font-size: 0.9rem;
  }

  .newsletter-form input::placeholder {
    color: #b0b0b0;
  }

  .newsletter-form button {
    padding: 10px 20px;
    background: #BD8802;
    color: #fff;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
    font-size: 0.9rem;
    white-space: nowrap;
  }

  .newsletter-form button:hover {
    background: #ff5252;
    transform: translateY(-2px);
  }

  /* Bottom Section */
  .footer-bottom {
    padding-top: 15px;
  }

  .payment-methods {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
  }

  .payment-icons {
    display: flex;
    gap: 10px;
    font-size: 1.5rem;
  }

  .payment-icons i {
    opacity: 0.8;
    transition: opacity 0.3s ease;
  }

  .payment-icons i:hover {
    opacity: 1;
  }

  .legal-links a {
    color: #b0b0b0;
    text-decoration: none;
    font-size: 0.8rem;
    transition: color 0.3s ease;
  }

  .legal-links a:hover {
    color: #fff;
  }

  .copyright {
    color: #b0b0b0;
    font-size: 0.8rem;
    line-height: 1.4;
  }

  .copyright a {
    color: #BD8802;
    text-decoration: none;
  }

  .copyright a:hover {
    text-decoration: underline;
  }

  .address {
    font-size: 0.8rem;
    color: #b0b0b0;
  }

  .address i {
    margin-right: 3px;
  }

  /* Responsive Design */
  /* Responsive Design - Mobile View (2 columns layout) */
  @media (max-width: 768px) {
    .temu-footer {
      padding: 20px 15px 15px;
    }

    .footer-top {
      margin-bottom: 15px;
      padding-bottom: 15px;
    }

    /* Show 2 columns on mobile for top section */
    .footer-top .col-sm-6 {
      flex: 0 0 50%;
      max-width: 50%;
    }

    .footer-section h3 {
      font-size: 1rem;
      margin-bottom: 12px;
      padding-bottom: 6px;
      text-align: left;
    }

    .footer-section h3::after {
      left: 0;
      transform: none;
    }

    .footer-links {
      text-align: center;
    }

    .footer-links li {
      margin-bottom: 6px;
    }

    .footer-links a {
      font-size: 0.8rem;
      justify-content: flex-start;
    }

    /* Middle section - stack vertically on mobile */
    .footer-middle {
      margin-bottom: 15px;
      padding-bottom: 15px;
    }

    .footer-middle .col-md-6 {
      margin-bottom: 20px;
    }

    .app-download,
    .newsletter {
      text-align: left;
    }

    .app-buttons {
      flex-direction: row;
      flex-wrap: wrap;
      width: 100%;
    }

    .app-btn {
      width: calc(50% - 5px);
      min-width: auto;
      padding: 8px 10px;
    }

    .app-btn i {
      font-size: 1.3rem;
    }

    .app-btn span {
      font-size: 0.7rem;
    }

    .newsletter-form {
      flex-direction: row;
      gap: 0;
    }

    .newsletter-form input {
      padding: 10px;
      font-size: 0.85rem;
      flex: 1;
    }

    .newsletter-form button {
      padding: 10px 15px;
      font-size: 0.85rem;
      margin-left: 8px;
      white-space: nowrap;
    }

    /* Bottom section - Legal links in single row on mobile */
    .footer-bottom .row>div {
      margin-bottom: 15px;
      text-align: center;
    }

    .footer-bottom .row>div:last-child {
      margin-bottom: 0;
    }

    .payment-methods {
      justify-content: center;
      text-align: center;
      flex-direction: row;
    }

    /* Legal links in single row */
    .legal-links {
      justify-content: center !important;
      flex-direction: row !important;
      gap: 15px !important;
      flex-wrap: nowrap !important;
      overflow-x: auto;
      padding: 5px 0;
      white-space: nowrap;
    }

    .legal-links a {
      font-size: 0.75rem;
      padding: 2px 0;
    }

    .copyright {
      text-align: center !important;
    }

    .address {
      font-size: 0.75rem;
    }
  }

  /* Small mobile devices (phones) */
  @media (max-width: 576px) {

    /* Keep 2 columns but adjust spacing */
    .footer-top .col-sm-6 {
      flex: 0 0 50%;
      max-width: 50%;
      padding: 0 8px;
    }

    .footer-section h3 {
      font-size: 0.95rem;
    }

    .footer-links a {
      font-size: 0.75rem;
    }

    .app-buttons {
      flex-direction: column;
    }

    .app-btn {
      width: 100%;
      margin-bottom: 8px;
    }

    .app-btn:last-child {
      margin-bottom: 0;
    }

    .newsletter-form {
      flex-direction: column;
      gap: 10px;
    }

    .newsletter-form input {
      width: 100%;
      margin-right: 0;
    }

    .newsletter-form button {
      width: 100%;
      margin-left: 0;
    }

    /* Adjust legal links for smaller screens */
    .legal-links {
      gap: 12px !important;
      justify-content: space-around !important;
    }

    .legal-links a {
      font-size: 0.7rem;
    }

    .payment-icons {
      font-size: 1.3rem;
      gap: 8px;
    }
  }

  /* Extra small devices (very small phones) */
  @media (max-width: 375px) {
    .footer-top .col-sm-6 {
      flex: 0 0 50%;
      max-width: 50%;
      padding: 0 5px;
    }

    .footer-section h3 {
      font-size: 0.9rem;
    }

    .footer-links a {
      font-size: 0.7rem;
    }

    .app-btn {
      padding: 6px 8px;
    }

    .app-btn i {
      font-size: 1.2rem;
    }

    .app-btn span {
      font-size: 0.65rem;
    }

    /* Adjust legal links for very small screens */
    .legal-links {
      gap: 8px !important;
    }

    .legal-links a {
      font-size: 0.65rem;
    }
  }

  /* Special media query for horizontal scrolling on very narrow screens */
  @media (max-width: 320px) {
    .legal-links {
      gap: 6px !important;
      padding: 5px;
    }

    .legal-links a {
      font-size: 0.6rem;
      padding: 0 2px;
    }
  }
</style>