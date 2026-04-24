<!doctype html>
<html lang="en">

<head>
  <!-- Open Graph / Social Media -->
  <meta property="og:title" content="Track Your Order - Feature Desk">
  <meta property="og:description" content="Track your Feature Desk order status, shipment details, and delivery information in real-time.">

  @include('market.website.includes.header_links')
  <title>Track Your Order - Feature Desk</title>
  <meta name="description" content="Track your Feature Desk order status, shipment details, and delivery information in real-time.">
  <meta name="keywords" content="track order, order tracking, shipment tracking, delivery status, order status">
  <style>
    /* Track Order Page Specific Styles */
    :root {
      --primary: #BD8802;
      --primary-light: #ff4757;
      --dark: #1a1a2e;
      --light: #f8f9fa;
      --gray: #6c757d;
      --border: #e0e0e0;
      --success: #28a745;
      --warning: #ffc107;
      --info: #17a2b8;
    }

    .tracking-main {
      padding: 60px 0;
      min-height: 60vh;
    }

    .section-title {
      font-size: 1.8rem;
      color: var(--dark);
      margin-bottom: 20px;
      position: relative;
      padding-bottom: 10px;
    }

    /* Search Section */
    .to-search-container {
      background: white;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      margin-bottom: 40px;
    }

    .search-header {
      text-align: center;
    }

    .to-search-form {
      max-width: 600px;
      margin: 0 auto;
    }

    .search-group {
      display: flex;
      gap: 10px;
      margin-bottom: 20px;
    }

    @media (max-width: 576px) {
      .search-group {
        flex-direction: column;
      }
    }

    .search-input {
      flex: 1;
      padding: 12px 15px;
      border: 2px solid var(--border);
      border-radius: 5px;
      font-size: 1rem;
      transition: all 0.3s ease;
    }

    .search-input:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(238, 39, 55, 0.1);
    }

    .search-btn {
      background: var(--primary);
      color: white;
      padding: 12px 30px;
      border: none;
      border-radius: 5px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.3s ease;
      display: flex;
      align-items: center;
      gap: 8px;
      white-space: nowrap;
    }

    .search-btn:hover {
      background: var(--primary-light);
    }

    .search-hint {
      text-align: center;
      color: var(--gray);
      font-size: 0.9rem;
      margin-top: 15px;
    }

    /* Results Section */
    .results-section {
      display: none;
    }

    .results-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
      flex-wrap: wrap;
      gap: 15px;
    }

    .order-found {
      color: var(--success);
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .reset-search {
      background: transparent;
      color: var(--primary);
      border: 1px solid var(--primary);
      padding: 8px 20px;
      border-radius: 5px;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .reset-search:hover {
      background: var(--primary);
      color: white;
    }

    /* Order Table */
    .orders-table {
      background: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .table-responsive {
      overflow-x: auto;
    }

    .table {
      width: 100%;
      border-collapse: collapse;
    }

    .table th {
      background: #f8f9fa;
      padding: 15px;
      text-align: left;
      font-weight: 600;
      color: var(--dark);
      border-bottom: 2px solid var(--border);
    }

    .table td {
      padding: 15px;
      border-bottom: 1px solid var(--border);
      vertical-align: middle;
    }

    .table tbody tr:hover {
      background: rgba(238, 39, 55, 0.02);
    }

    /* Status Badges */
    .status-badge {
      padding: 5px 12px;
      border-radius: 20px;
      font-size: 0.85rem;
      font-weight: 600;
      display: inline-block;
    }

    .status-pending {
      background: rgba(255, 193, 7, 0.1);
      color: #856404;
    }

    .status-processing {
      background: rgba(23, 162, 184, 0.1);
      color: #0c5460;
    }

    .status-shipped {
      background: rgba(0, 123, 255, 0.1);
      color: #004085;
    }

    .status-delivered {
      background: rgba(40, 167, 69, 0.1);
      color: #155724;
    }

    .status-cancelled {
      background: rgba(220, 53, 69, 0.1);
      color: #721c24;
    }

    /* No Results */
    .no-results {
      text-align: center;
      padding: 60px 20px;
      background: white;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .no-results-icon {
      font-size: 4rem;
      color: var(--gray);
      margin-bottom: 20px;
      opacity: 0.5;
    }

    /* Order Details */
    .order-details-btn {
      background: transparent;
      color: var(--primary);
      border: 1px solid var(--primary);
      padding: 5px 15px;
      border-radius: 5px;
      cursor: pointer;
      transition: all 0.3s ease;
      font-size: 0.9rem;
    }

    .order-details-btn:hover {
      background: var(--primary);
      color: white;
    }

    /* Alert Messages */
    .alert {
      padding: 15px;
      border-radius: 5px;
      margin-bottom: 20px;
      display: none;
    }

    .alert-error {
      background: rgba(220, 53, 69, 0.1);
      border: 1px solid #f5c6cb;
      color: #721c24;
    }

    .alert-success {
      background: rgba(40, 167, 69, 0.1);
      border: 1px solid #c3e6cb;
      color: #155724;
    }

    /* Help Section */
    .help-section {
      background: var(--light);
      padding: 40px;
      border-radius: 10px;
      margin-top: 40px;
    }

    .help-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      margin-top: 20px;
    }

    .help-item {
      display: flex;
      align-items: flex-start;
      gap: 15px;
    }

    .help-icon {
      color: var(--primary);
      font-size: 1.5rem;
      flex-shrink: 0;
    }

    .help-content h4 {
      font-size: 1rem;
      margin-bottom: 5px;
      color: var(--dark);
    }

    .help-content p {
      color: var(--gray);
      font-size: 0.9rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .tracking-main {
        padding: 40px 0;
      }

      .to-search-container {
        padding: 25px;
      }

      .table th,
      .table td {
        padding: 10px;
        font-size: 0.9rem;
      }

      .help-section {
        padding: 25px;
      }
    }

    @media (max-width: 480px) {
      .section-title {
        font-size: 1.5rem;
      }

      .to-search-container {
        padding: 20px;
      }
    }
  </style>
</head>

<body>
  <!-- Navbar Start -->
  @include('market.website.includes.navbar')
  <!-- Navbar End -->

  <!-- Main Tracking Section -->
  <section class="tracking-main mt-5">
    <div class="container">
      <!-- Search Section -->
      <div class="to-search-container">
        <div class="search-header">
          <h1 class="section-title" style="text-align: center;">Track Your Order</h1>
        </div>

        <!-- Alert Messages -->
        <div class="alert alert-error" id="errorAlert">
          <i class="fas fa-exclamation-circle me-2"></i>
          <span id="errorMessage"></span>
        </div>

        <div class="alert alert-success" id="successAlert">
          <i class="fas fa-check-circle me-2"></i>
          <span id="successMessage"></span>
        </div>

        <!-- Search Form -->
        <form id="trackingForm" class="to-search-form">
          @csrf
          <div class="search-group">
            <input type="text" 
                   class="search-input" 
                   id="searchQuery" 
                   name="search_query" 
                   placeholder="Enter Order ID or Phone Number (e.g., 12345 or 03001234567)" 
                   required>
            <button type="submit" class="search-btn" id="trackBtn">
              <i class="fas fa-search"></i> Track Order
            </button>
          </div>
          <!-- <p class="search-hint">
            <i class="fas fa-info-circle me-1"></i>
            Need help finding your Order ID? Check your confirmation email or order invoice.
          </p> -->
        </form>
      </div>

      <!-- Results Section -->
      <div class="results-section" id="resultsSection">
        <div class="results-header">
          <div class="order-found" id="resultsCount">
            <i class="fas fa-clipboard-check"></i>
            <span id="ordersCount">0</span> Orders Found
          </div>
          <button type="button" class="reset-search" id="resetSearch">
            <i class="fas fa-redo me-1"></i> New Search
          </button>
        </div>

        <!-- Orders Table -->
        <div class="orders-table" id="ordersTableContainer">
          <div class="table-responsive">
            <table class="table" id="ordersTable">
              <thead>
                <tr>
                  <th>Order ID</th>
                  <th>Date</th>
                  <th>Product</th>
                  <th>Total Amount</th>
                  <th>Status</th>
                  <!-- <th>Action</th> -->
                </tr>
              </thead>
              <tbody id="ordersTableBody">
                <!-- Orders will be populated here -->
              </tbody>
            </table>
          </div>
        </div>

        <!-- No Results Message -->
        <div class="no-results" id="noResults" style="display: none;">
          <div class="no-results-icon">
            <i class="fas fa-box-open"></i>
          </div>
          <h3>No Orders Found</h3>
          <p class="text-muted">We couldn't find any orders matching your search criteria.</p>
          <p class="text-muted mt-2">Please check your Order ID or Phone Number and try again.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  @include('market.website.includes.footer')
  @include('market.website.includes.footer_links')

<script>
    document.addEventListener('DOMContentLoaded', function() {
      const trackingForm = document.getElementById('trackingForm');
      const searchQuery = document.getElementById('searchQuery');
      const resultsSection = document.getElementById('resultsSection');
      const ordersTableBody = document.getElementById('ordersTableBody');
      const noResults = document.getElementById('noResults');
      const ordersTableContainer = document.getElementById('ordersTableContainer');
      const errorAlert = document.getElementById('errorAlert');
      const successAlert = document.getElementById('successAlert');
      const errorMessage = document.getElementById('errorMessage');
      const successMessage = document.getElementById('successMessage');
      const ordersCount = document.getElementById('ordersCount');
      const resetSearch = document.getElementById('resetSearch');
      const trackBtn = document.getElementById('trackBtn');

      // Form submission
      trackingForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const query = searchQuery.value.trim();
        
        if (!query) {
          showError('Please enter an Order ID or Phone Number to search.');
          return;
        }

        // Show loading state
        const originalBtnText = trackBtn.innerHTML;
        trackBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Searching...';
        trackBtn.disabled = true;

        try {
          // Send AJAX request - FIXED: Use FormData instead of JSON
          const formData = new FormData();
          formData.append('search_query', query);
          formData.append('_token', '{{ csrf_token() }}');

          const response = await fetch('{{ route("track.order.search") }}', {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              'Accept': 'application/json',
            },
            body: formData
          });

          const data = await response.json();

          if (response.ok) {
            if (data.success) {
              showSuccess(data.message || 'Order found!');
              displayResults(data.orders || []);
            } else {
              showError(data.message || 'No orders found.');
              displayResults([]);
            }
          } else {
            // Handle HTTP errors
            if (data.errors) {
              showError(data.errors.search_query ? data.errors.search_query[0] : 'Validation error.');
            } else if (data.message) {
              showError(data.message);
            } else {
              showError('An error occurred. Please try again.');
            }
          }
        } catch (error) {
          console.error('Error:', error);
          showError('Network error. Please check your connection and try again.');
        } finally {
          // Reset button state
          trackBtn.innerHTML = originalBtnText;
          trackBtn.disabled = false;
        }
      });

      // Reset search
      resetSearch.addEventListener('click', function() {
        searchQuery.value = '';
        resultsSection.style.display = 'none';
        hideAlerts();
        searchQuery.focus();
      });

      // Display search results
      function displayResults(orders) {
        if (!orders || orders.length === 0) {
          noResults.style.display = 'block';
          ordersTableContainer.style.display = 'none';
          ordersCount.textContent = '0';
        } else {
          noResults.style.display = 'none';
          ordersTableContainer.style.display = 'block';
          ordersCount.textContent = orders.length;
          
          // Clear previous results
          ordersTableBody.innerHTML = '';
          
          // Add new results
          orders.forEach(order => {
            const row = document.createElement('tr');
            
            // Format date
            const orderDate = order.created_at ? new Date(order.created_at) : new Date();
            const formattedDate = orderDate.toLocaleDateString('en-US', {
              year: 'numeric',
              month: 'short',
              day: 'numeric'
            });
            
            // Format amount
            const totalAmount = order.total_price ;
            const formattedAmount = new Intl.NumberFormat('en-PK', {
              style: 'currency',
              currency: 'PKR',
              minimumFractionDigits: 0,
              maximumFractionDigits: 2
            }).format(totalAmount);
            
            // Status badge
            const statusClass = getStatusClass(order.status);
            const statusText = getStatusText(order.status);
            
            row.innerHTML = `
              <td><strong>${order.id}</strong></td>
              <td>${formattedDate}</td>
              <td>${order.product_name}</td>
              <td>${formattedAmount}</td>
              <td>
                <span class="status-badge ${statusClass}">${statusText}</span>
              </td>
              {{--<td>
                <button class="order-details-btn" onclick="viewOrderDetails('${order.id}')">
                  <i class="fas fa-eye me-1"></i> View Details
                </button>
              </td>--}}
            `;
            
            ordersTableBody.appendChild(row);
          });
        }
        
        // Show results section
        resultsSection.style.display = 'block';
        
        // Scroll to results
        resultsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }

      // View order details function
      window.viewOrderDetails = function(orderId) {
        // Redirect to order details page
        window.location.href = `/order/${orderId}`;
        
        // OR if you want to show a modal instead:
        // fetch(`/order/${orderId}/details`)
        //   .then(response => response.json())
        //   .then(data => {
        //     // Show modal with order details
        //     console.log('Order details:', data);
        //   })
        //   .catch(error => {
        //     console.error('Error:', error);
        //     alert('Unable to load order details.');
        //   });
      };

      // Hide results
      function hideResults() {
        resultsSection.style.display = 'none';
      }

      // Show error message
      function showError(message) {
        errorMessage.textContent = message;
        errorAlert.style.display = 'block';
        successAlert.style.display = 'none';
        
        // Auto-hide after 5 seconds
        setTimeout(() => {
          errorAlert.style.display = 'none';
        }, 5000);
        
        // Scroll to error
        errorAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });
      }

      // Show success message
      function showSuccess(message) {
        successMessage.textContent = message;
        successAlert.style.display = 'block';
        errorAlert.style.display = 'none';
        
        // Auto-hide after 3 seconds
        setTimeout(() => {
          successAlert.style.display = 'none';
        }, 3000);
      }

      // Hide all alerts
      function hideAlerts() {
        errorAlert.style.display = 'none';
        successAlert.style.display = 'none';
      }

      // Get status class
      function getStatusClass(status) {
        const statusMap = {
          'pending': 'status-pending',
          'processing': 'status-processing',
          'confirmed': 'status-processing',
          'shipped': 'status-shipped',
          'delivered': 'status-delivered',
          'completed': 'status-delivered',
          'cancelled': 'status-cancelled',
          'refunded': 'status-cancelled'
        };
        return statusMap[status?.toLowerCase()] || 'status-pending';
      }

      // Get status text
      function getStatusText(status) {
        const textMap = {
          'pending': 'Pending',
          'processing': 'Processing',
          'confirmed': 'Confirmed',
          'shipped': 'Shipped',
          'delivered': 'Delivered',
          'completed': 'Completed',
          'cancelled': 'Cancelled',
          'refunded': 'Refunded'
        };
        return textMap[status?.toLowerCase()] || 'Pending';
      }
    });
  </script>
</body>

</html>