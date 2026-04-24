<!doctype html>
<html lang="en">

<head>
  <!-- Open Graph / Social Media -->
  <meta property="og:title" content="Cookie Policy - Feature Desk">
  <meta property="og:description" content="Learn about Feature Desk's Cookie Policy, how we use cookies, and how you can manage your cookie preferences.">

  @include('market.website.includes.header_links')
  <title>Cookie Policy - Feature Desk</title>
  <meta name="description" content="Learn about Feature Desk's Cookie Policy, how we use cookies, and how you can manage your cookie preferences.">
  <meta name="keywords" content="cookie policy, cookies, website cookies, cookie settings, privacy cookies">
  <style>
    /* Cookie Policy Styles */
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
      --info: #17a2b8;
      --border: #e0e0e0;
    }

    @keyframes float {

      0%,
      100% {
        transform: translateY(0);
      }

      50% {
        transform: translateY(-10px);
      }
    }

    .cookie-main {
      padding: 60px 0;
      background: white;
    }

    /* Quick Summary */
    .summary-section {
      background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
      border-radius: 15px;
      padding: 30px;
      margin-bottom: 40px;
      border-left: 5px solid var(--primary);
    }

    .summary-content {
      display: flex;
      align-items: center;
      gap: 30px;
      flex-wrap: wrap;
    }

    .summary-text {
      flex: 1;
      min-width: 300px;
    }

    .summary-text h3 {
      font-size: 1.8rem;
      color: var(--dark);
      margin-bottom: 15px;
    }

    .summary-text p {
      color: var(--gray);
      line-height: 1.6;
    }

    .summary-box {
      background: white;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
      min-width: 250px;
    }

    .summary-item {
      display: flex;
      align-items: center;
      gap: 15px;
      margin-bottom: 15px;
      padding-bottom: 15px;
      border-bottom: 1px solid var(--border);
    }

    .summary-item:last-child {
      margin-bottom: 0;
      padding-bottom: 0;
      border-bottom: none;
    }

    .summary-item i {
      font-size: 1.5rem;
      color: var(--primary);
    }

    /* Cookie Types */
    .types-section {
      margin-bottom: 50px;
    }

    .section-title {
      font-size: 2rem;
      color: var(--dark);
      margin-bottom: 30px;
      text-align: center;
      position: relative;
      padding-bottom: 15px;
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

    .cookie-types-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 25px;
      margin-top: 30px;
    }

    .type-card {
      background: white;
      border-radius: 12px;
      padding: 30px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
      border: 2px solid transparent;
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }

    .type-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
      border-color: var(--primary);
    }

    .type-card:before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 5px;
      height: 100%;
      background: var(--primary);
    }

    .type-header {
      display: flex;
      align-items: center;
      gap: 15px;
      margin-bottom: 20px;
    }

    .type-icon {
      font-size: 2rem;
      color: var(--primary);
      background: rgba(238, 39, 55, 0.1);
      width: 60px;
      height: 60px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .type-header h3 {
      font-size: 1.3rem;
      color: var(--dark);
      margin: 0;
    }

    .type-content {
      color: var(--gray);
      line-height: 1.6;
      margin-bottom: 20px;
    }

    .type-examples {
      background: #f8f9fa;
      padding: 15px;
      border-radius: 8px;
      margin-top: 15px;
    }

    .type-examples h4 {
      font-size: 0.9rem;
      color: var(--dark);
      margin-bottom: 8px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .type-examples p {
      font-size: 0.85rem;
      color: var(--gray);
      margin: 0;
    }

    /* Cookie Table */
    .table-section {
      margin-bottom: 50px;
    }

    .cookie-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 30px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
      border-radius: 10px;
      overflow: hidden;
    }

    .cookie-table th {
      background: var(--primary);
      color: white;
      padding: 20px 15px;
      text-align: left;
      font-weight: 600;
      border: none;
    }

    .cookie-table td {
      padding: 18px 15px;
      border-bottom: 1px solid var(--border);
      color: var(--gray);
      vertical-align: top;
    }

    .cookie-table tr:last-child td {
      border-bottom: none;
    }

    .cookie-table tr:nth-child(even) {
      background: #f8f9fa;
    }

    .cookie-name {
      color: var(--dark);
      font-weight: 600;
      font-family: 'Courier New', monospace;
    }

    .cookie-purpose {
      color: var(--secondary);
    }

    .cookie-duration {
      color: var(--primary);
      font-weight: 600;
    }

    /* Cookie Control */
    .control-section {
      background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
      border-radius: 15px;
      padding: 40px;
      margin-bottom: 50px;
    }

    .control-options {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 25px;
      margin-top: 30px;
    }

    .control-card {
      background: white;
      border-radius: 10px;
      padding: 25px;
      text-align: center;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease;
    }

    .control-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .control-icon {
      font-size: 2.5rem;
      color: var(--primary);
      margin-bottom: 20px;
      display: block;
    }

    .control-card h4 {
      font-size: 1.2rem;
      color: var(--dark);
      margin-bottom: 10px;
    }

    .control-card p {
      color: var(--gray);
      font-size: 0.95rem;
      margin-bottom: 20px;
    }

    /* Settings Panel */
    .settings-panel {
      background: white;
      border-radius: 15px;
      padding: 40px;
      margin: 50px 0;
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
      border: 2px solid var(--border);
    }

    .settings-panel h3 {
      color: var(--dark);
      margin-bottom: 30px;
      text-align: center;
      font-size: 1.8rem;
    }

    .cookie-setting {
      margin-bottom: 25px;
      padding-bottom: 25px;
      border-bottom: 1px solid var(--border);
    }

    .cookie-setting:last-child {
      margin-bottom: 0;
      padding-bottom: 0;
      border-bottom: none;
    }

    .setting-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 15px;
      cursor: pointer;
    }

    .setting-header h4 {
      font-size: 1.1rem;
      color: var(--dark);
      margin: 0;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .setting-header h4 i {
      color: var(--primary);
    }

    /* Toggle Switch */
    .toggle-switch {
      position: relative;
      display: inline-block;
      width: 60px;
      height: 30px;
    }

    .toggle-switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }

    .toggle-slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      transition: .4s;
      border-radius: 34px;
    }

    .toggle-slider:before {
      position: absolute;
      content: "";
      height: 22px;
      width: 22px;
      left: 4px;
      bottom: 4px;
      background-color: white;
      transition: .4s;
      border-radius: 50%;
    }

    input:checked+.toggle-slider {
      background-color: var(--primary);
    }

    input:checked+.toggle-slider:before {
      transform: translateX(30px);
    }

    .setting-description {
      color: var(--gray);
      line-height: 1.6;
      font-size: 0.95rem;
    }

    /* Action Buttons */
    .action-buttons {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin-top: 40px;
      flex-wrap: wrap;
    }

    .cookie-btn {
      padding: 15px 35px;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      border: none;
      display: flex;
      align-items: center;
      gap: 10px;
      min-width: 200px;
      justify-content: center;
    }

    .btn-accept {
      background: var(--primary);
      color: white;
    }

    .btn-accept:hover {
      background: var(--primary-light);
      transform: translateY(-3px);
      box-shadow: 0 10px 25px rgba(238, 39, 55, 0.3);
    }

    .btn-reject {
      background: white;
      color: var(--dark);
      border: 2px solid var(--border);
    }

    .btn-reject:hover {
      background: #f8f9fa;
      transform: translateY(-3px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .btn-settings {
      background: var(--secondary);
      color: white;
    }

    .btn-settings:hover {
      background: #1a202c;
      transform: translateY(-3px);
      box-shadow: 0 10px 25px rgba(26, 32, 44, 0.3);
    }

    /* FAQ Section */
    .faq-section {
      margin: 50px 0;
    }

    .faq-item {
      background: white;
      border-radius: 10px;
      padding: 25px;
      margin-bottom: 15px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      border-left: 4px solid var(--primary);
    }

    .faq-question {
      color: var(--dark);
      font-size: 1.1rem;
      font-weight: 600;
      margin-bottom: 15px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .faq-question i {
      color: var(--primary);
    }

    .faq-answer {
      color: var(--gray);
      line-height: 1.6;
    }

    /* Contact Section */
    .contact-section {
      background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
      color: white;
      padding: 60px 0;
      border-radius: 15px;
      margin-top: 50px;
    }

    .contact-section h3 {
      color: white;
      margin-bottom: 20px;
      text-align: center;
      font-size: 2rem;
    }

    .contact-content {
      text-align: center;
      max-width: 600px;
      margin: 0 auto;
    }

    .contact-content p {
      opacity: 0.9;
      margin-bottom: 30px;
      font-size: 1.1rem;
    }

    .contact-btn {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      background: var(--primary);
      color: white;
      padding: 15px 30px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      transition: all 0.3s ease;
      margin-top: 15px;
    }

    .contact-btn:hover {
      background: var(--primary-light);
      transform: translateY(-3px);
      color: white;
    }

    /* Responsive */
    @media (max-width: 992px) {


      .summary-content {
        flex-direction: column;
        text-align: center;
      }

      .summary-text {
        text-align: center;
      }

      .cookie-types-grid {
        grid-template-columns: 1fr;
      }
    }

    @media (max-width: 768px) {

      .cookie-main {
        padding: 40px 0;
      }

      .section-title {
        font-size: 1.8rem;
      }

      .settings-panel,
      .control-section {
        padding: 30px 20px;
      }

      .cookie-table {
        display: block;
        overflow-x: auto;
      }

      .action-buttons {
        flex-direction: column;
        align-items: center;
      }

      .cookie-btn {
        width: 100%;
        max-width: 300px;
      }
    }

    @media (max-width: 576px) {

      .section-title {
        font-size: 1.6rem;
      }

      .type-card {
        padding: 25px 20px;
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
                Cookie Policy
              </li>
            </ol>
          </nav>

        </div>

      </div>

      {{-- Page Title / H1 --}}
      <div class="mt-3">
        <h1 class="h3 mb-0 fw-bold text-dark">
          Cookie Policy
        </h1>
        <p class="text-muted mt-2 mb-0">Learn how Feature Desk uses cookies and similar technologies to enhance your browsing experience.</p>
      </div>
    </div>
  </section>
  {{-- ====================== END BREADCRUMBS + TITLE ====================== --}}


  <!-- Main Cookie Content -->
  <section class="cookie-main">
    <div class="container">
      <!-- Quick Summary -->
      <div class="summary-section">
        <div class="summary-content">
          <div class="summary-text">
            <h3>Cookie Policy Overview</h3>
            <p>This Cookie Policy explains what cookies are, how Feature Desk uses them, the types of cookies we use, and how you can manage your cookie preferences.</p>
            <p>By using our website, you consent to the use of cookies in accordance with this policy.</p>
          </div>
          <div class="summary-box">
            <div class="summary-item">
              <i class="fas fa-info-circle"></i>
              <div>
                <strong>What are cookies?</strong>
                <div style="font-size: 0.9rem; color: var(--gray);">Small text files stored on your device</div>
              </div>
            </div>
            <div class="summary-item">
              <i class="fas fa-shield-alt"></i>
              <div>
                <strong>Why we use them?</strong>
                <div style="font-size: 0.9rem; color: var(--gray);">To improve your browsing experience</div>
              </div>
            </div>
            <div class="summary-item">
              <i class="fas fa-user-cog"></i>
              <div>
                <strong>Your control</strong>
                <div style="font-size: 0.9rem; color: var(--gray);">You can manage cookie settings</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- What Are Cookies -->
      <div class="types-section">
        <h2 class="section-title">What Are Cookies?</h2>
        <div class="section-content" style="max-width: 800px; margin: 0 auto 30px; text-align: center; color: var(--gray);">
          <p>Cookies are small text files that are placed on your computer or mobile device when you visit our website. They help us provide you with a better experience by remembering your preferences and understanding how you use our site.</p>
        </div>
      </div>

      <!-- Types of Cookies -->
      <div class="types-section">
        <h2 class="section-title">Types of Cookies We Use</h2>
        <div class="cookie-types-grid">
          <div class="type-card">
            <div class="type-header">
              <div class="type-icon">
                <i class="fas fa-lock"></i>
              </div>
              <h3>Essential Cookies</h3>
            </div>
            <div class="type-content">
              <p>These cookies are necessary for the website to function properly. They enable basic functions like page navigation and access to secure areas.</p>
            </div>
            <div class="type-examples">
              <h4><i class="fas fa-check-circle"></i> Examples:</h4>
              <p>Session cookies, security cookies, authentication cookies</p>
            </div>
          </div>

          <div class="type-card">
            <div class="type-header">
              <div class="type-icon">
                <i class="fas fa-chart-line"></i>
              </div>
              <h3>Analytics Cookies</h3>
            </div>
            <div class="type-content">
              <p>These cookies help us understand how visitors interact with our website by collecting and reporting information anonymously.</p>
            </div>
            <div class="type-examples">
              <h4><i class="fas fa-check-circle"></i> Examples:</h4>
              <p>Google Analytics, visitor tracking, page performance</p>
            </div>
          </div>

          <div class="type-card">
            <div class="type-header">
              <div class="type-icon">
                <i class="fas fa-user-cog"></i>
              </div>
              <h3>Preference Cookies</h3>
            </div>
            <div class="type-content">
              <p>These cookies remember your preferences and settings to enhance your browsing experience on future visits.</p>
            </div>
            <div class="type-examples">
              <h4><i class="fas fa-check-circle"></i> Examples:</h4>
              <p>Language settings, theme preferences, layout choices</p>
            </div>
          </div>

          <div class="type-card">
            <div class="type-header">
              <div class="type-icon">
                <i class="fas fa-ad"></i>
              </div>
              <h3>Marketing Cookies</h3>
            </div>
            <div class="type-content">
              <p>These cookies track your browsing habits to show you relevant advertisements and measure the effectiveness of advertising campaigns.</p>
            </div>
            <div class="type-examples">
              <h4><i class="fas fa-check-circle"></i> Examples:</h4>
              <p>Retargeting cookies, ad performance tracking</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Cookie Table -->
      <div class="table-section">
        <h2 class="section-title">Our Cookies</h2>
        <div class="section-content" style="text-align: center; margin-bottom: 20px;">
          <p>Below is a list of some cookies we use on our website:</p>
        </div>

        <table class="cookie-table">
          <thead>
            <tr>
              <th>Cookie Name</th>
              <th>Purpose</th>
              <th>Duration</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="cookie-name">session_id</td>
              <td class="cookie-purpose">Maintains user session state</td>
              <td class="cookie-duration">Session</td>
            </tr>
            <tr>
              <td class="cookie-name">user_auth</td>
              <td class="cookie-purpose">Remembers login status</td>
              <td class="cookie-duration">30 days</td>
            </tr>
            <tr>
              <td class="cookie-name">cart_items</td>
              <td class="cookie-purpose">Stores shopping cart items</td>
              <td class="cookie-duration">7 days</td>
            </tr>
            <tr>
              <td class="cookie-name">_ga</td>
              <td class="cookie-purpose">Google Analytics tracking</td>
              <td class="cookie-duration">2 years</td>
            </tr>
            <tr>
              <td class="cookie-name">_gid</td>
              <td class="cookie-purpose">Google Analytics session</td>
              <td class="cookie-duration">24 hours</td>
            </tr>
            <tr>
              <td class="cookie-name">language</td>
              <td class="cookie-purpose">Stores language preference</td>
              <td class="cookie-duration">1 year</td>
            </tr>
            <tr>
              <td class="cookie-name">theme_pref</td>
              <td class="cookie-purpose">Stores theme preference</td>
              <td class="cookie-duration">1 year</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Cookie Control -->
      <div class="control-section">
        <h2 class="section-title">How to Control Cookies</h2>
        <div class="control-options">
          <div class="control-card">
            <i class="fas fa-cog control-icon"></i>
            <h4>Browser Settings</h4>
            <p>Most web browsers allow you to control cookies through their settings preferences.</p>
          </div>

          <div class="control-card">
            <i class="fas fa-trash-alt control-icon"></i>
            <h4>Delete Cookies</h4>
            <p>You can delete cookies already stored on your computer through your browser settings.</p>
          </div>

          <div class="control-card">
            <i class="fas fa-ban control-icon"></i>
            <h4>Block Cookies</h4>
            <p>You can set your browser to block all cookies, but this may affect website functionality.</p>
          </div>
        </div>
      </div>

      <!-- Cookie Settings -->
      <div class="settings-panel">
        <h3>Manage Your Cookie Preferences</h3>

        <div class="cookie-setting">
          <div class="setting-header">
            <h4><i class="fas fa-lock"></i> Essential Cookies</h4>
            <label class="toggle-switch">
              <input type="checkbox" checked disabled>
              <span class="toggle-slider"></span>
            </label>
          </div>
          <div class="setting-description">
            <p>These cookies are required for the website to function and cannot be disabled. They are usually only set in response to actions made by you.</p>
          </div>
        </div>

        <div class="cookie-setting">
          <div class="setting-header">
            <h4><i class="fas fa-chart-line"></i> Analytics Cookies</h4>
            <label class="toggle-switch">
              <input type="checkbox" id="analyticsToggle" checked>
              <span class="toggle-slider"></span>
            </label>
          </div>
          <div class="setting-description">
            <p>Allow us to count visits and traffic sources so we can measure and improve the performance of our site.</p>
          </div>
        </div>

        <div class="cookie-setting">
          <div class="setting-header">
            <h4><i class="fas fa-user-cog"></i> Preference Cookies</h4>
            <label class="toggle-switch">
              <input type="checkbox" id="preferenceToggle" checked>
              <span class="toggle-slider"></span>
            </label>
          </div>
          <div class="setting-description">
            <p>Enable the website to provide enhanced functionality and personalization based on your preferences.</p>
          </div>
        </div>

        <div class="cookie-setting">
          <div class="setting-header">
            <h4><i class="fas fa-ad"></i> Marketing Cookies</h4>
            <label class="toggle-switch">
              <input type="checkbox" id="marketingToggle">
              <span class="toggle-slider"></span>
            </label>
          </div>
          <div class="setting-description">
            <p>Used to track visitors across websites to display relevant advertisements.</p>
          </div>
        </div>

        <div class="action-buttons">
          <button class="cookie-btn btn-accept" id="acceptAll">
            <i class="fas fa-check"></i> Accept All Cookies
          </button>
          <button class="cookie-btn btn-settings" id="saveSettings">
            <i class="fas fa-save"></i> Save Preferences
          </button>
          <button class="cookie-btn btn-reject" id="rejectAll">
            <i class="fas fa-times"></i> Reject Non-Essential
          </button>
        </div>
      </div>

    </div>
  </section>

  <!-- Footer -->
  @include('market.website.includes.footer')
  @include('market.website.includes.footer_links')

  <script>
    // Cookie Settings Management
    const analyticsToggle = document.getElementById('analyticsToggle');
    const preferenceToggle = document.getElementById('preferenceToggle');
    const marketingToggle = document.getElementById('marketingToggle');

    // Load saved preferences
    document.addEventListener('DOMContentLoaded', () => {
      const savedSettings = JSON.parse(localStorage.getItem('cookiePreferences')) || {
        analytics: true,
        preference: true,
        marketing: false
      };

      analyticsToggle.checked = savedSettings.analytics;
      preferenceToggle.checked = savedSettings.preference;
      marketingToggle.checked = savedSettings.marketing;
    });

    // Save Settings
    document.getElementById('saveSettings').addEventListener('click', () => {
      const preferences = {
        analytics: analyticsToggle.checked,
        preference: preferenceToggle.checked,
        marketing: marketingToggle.checked
      };

      localStorage.setItem('cookiePreferences', JSON.stringify(preferences));
      showNotification('Cookie preferences saved successfully!', 'success');
    });

    // Accept All Cookies
    document.getElementById('acceptAll').addEventListener('click', () => {
      analyticsToggle.checked = true;
      preferenceToggle.checked = true;
      marketingToggle.checked = true;

      const preferences = {
        analytics: true,
        preference: true,
        marketing: true
      };

      localStorage.setItem('cookiePreferences', JSON.stringify(preferences));
      showNotification('All cookies accepted!', 'success');
    });

    // Reject Non-Essential
    document.getElementById('rejectAll').addEventListener('click', () => {
      analyticsToggle.checked = false;
      preferenceToggle.checked = false;
      marketingToggle.checked = false;

      const preferences = {
        analytics: false,
        preference: false,
        marketing: false
      };

      localStorage.setItem('cookiePreferences', JSON.stringify(preferences));
      showNotification('Non-essential cookies rejected.', 'info');
    });

    // Show Notification
    function showNotification(message, type) {
      // Remove existing notification
      const existingNotification = document.querySelector('.cookie-notification');
      if (existingNotification) {
        existingNotification.remove();
      }

      // Create notification
      const notification = document.createElement('div');
      notification.className = 'cookie-notification';
      notification.innerHTML = `
                <div style="
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background: ${type === 'success' ? '#28a745' : '#17a2b8'};
                    color: white;
                    padding: 15px 25px;
                    border-radius: 8px;
                    box-shadow: 0 5px 20px rgba(0,0,0,0.2);
                    z-index: 1000;
                    display: flex;
                    align-items: center;
                    gap: 10px;
                    animation: slideIn 0.3s ease;
                    max-width: 400px;
                ">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'info-circle'}"></i>
                    <span>${message}</span>
                    <button onclick="this.parentElement.remove()" style="
                        background: none;
                        border: none;
                        color: white;
                        cursor: pointer;
                        margin-left: 15px;
                        font-size: 1.2rem;
                    ">
                        &times;
                    </button>
                </div>
            `;

      document.body.appendChild(notification);

      // Auto remove after 5 seconds
      setTimeout(() => {
        if (notification.parentElement) {
          notification.remove();
        }
      }, 5000);
    }

    // Add keyframes for animation
    const style = document.createElement('style');
    style.textContent = `
            @keyframes slideIn {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            
            @keyframes fadeOut {
                from { opacity: 1; }
                to { opacity: 0; }
            }
            
            .cookie-table tr:hover {
                background: rgba(238, 39, 55, 0.05) !important;
                transform: scale(1.001);
                transition: all 0.2s ease;
            }
        `;
    document.head.appendChild(style);

    // Table row hover effect
    document.querySelectorAll('.cookie-table tr').forEach(row => {
      row.addEventListener('mouseenter', function() {
        this.style.transform = 'scale(1.001)';
        this.style.transition = 'transform 0.2s ease';
      });

      row.addEventListener('mouseleave', function() {
        this.style.transform = '';
      });
    });

    // Toggle switch animations
    document.querySelectorAll('.toggle-switch input').forEach(switchInput => {
      switchInput.addEventListener('change', function() {
        const slider = this.nextElementSibling;
        slider.style.transform = 'scale(1.1)';
        setTimeout(() => {
          slider.style.transform = '';
        }, 200);
      });
    });

    // Print Cookie Policy
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