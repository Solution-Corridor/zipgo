<!DOCTYPE html>
<html lang="en">

<head>
  @include('market.website.includes.header_links')
  <title>Buy Now - {{ $product->name }}</title>
  <meta name="description" content="Complete your purchase" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="background-color: #ffffff;">

  @include('market.website.includes.navbar')

  <div class="contact-form-area" style="margin-top: 30px;">
    <div class="container">
      <div class="row pt-45">
        <div class="col-lg-12 d-flex justify-content-center">

          <div class="contact-form" style="background: #f9f9f9; padding: 30px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.3);">
            @include('market.website.includes.success')
            <h1 class="text-center mb-4 fs-5" style="color: #BD8802;">{{ $product->name }}</h1>

            <form method="post" action="{{ route('market.ordernow') }}" id="contactForm" enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="product_id" value="{{ $product->product_id }}">

              <div class="row">

                <!-- Customer Info -->
                <div class="col-lg-6">
                  <div class="form-group">
                    <input type="text" name="name" class="form-control" required placeholder="Full Name *">
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <input type="tel" name="phone" class="form-control" required placeholder="Phone Number *">
                  </div>
                </div>

                <div class="col-12">
                  <div class="form-group">
                    <textarea name="address" class="form-control" rows="4" required placeholder="Delivery Address *"></textarea>
                  </div>
                </div>

                <!-- Order Summary & Button -->
                <div class="col-12">
                  <hr>
                  <div class="row align-items-center p-2 g-0">
                    <!-- Product Price -->
                    <div class="col-12 col-md-3 text-center py-2 order-price">
                      <div class="small text-muted">Product Price</div>
                      <div class="fw-bold">Rs. {{ number_format($product->price) }} × {{ request('qty', 1) }}</div>
                    </div>
                    
                    <!-- Delivery Charges -->
                    <div class="col-12 col-md-3 text-center py-2 order-delivery">
                      <div class="small text-primary">Delivery Charges</div>
                      <div class="fw-bold text-primary">Rs. {{ number_format($product->delivery_charges ?? 0) }}</div>
                    </div>
                    
                    <!-- Total Amount -->
                    <div class="col-12 col-md-3 text-center py-2 order-total">
                      <div class="small text-danger" style="margin-top: -10px;">Total Amount</div>
                      <div class="fw-bold text-danger" style="margin-top: 0px;">Rs. <span id="total_price_display">0</span></div>
                      <input type="hidden" id="quantity" name="quantity" value="{{ request('qty', 1) }}">
                      <input type="hidden" id="total_price_hidden" name="total_price" value="0">
                    </div>
                    
                    <!-- Order Button -->
                    <div class="col-12 col-md-3 text-center py-2 order-button">
                      <button id="orderBtn" class="btn-order" type="button">
                        <span class="btn-text">Place Order</span>
                        <i class="bx bx-check icon-check"></i>
                        <img src="/assets/images/internal_transfer.png" class="van" />
                      </button>
                      <p class="small text-muted mt-2">Your Balance: Rs. {{ number_format(auth()->user()->balance ?? 0) }}</p>
                    </div>
                  </div>
                </div>

              </div>
            </form>

          </div>

        </div>
      </div>
    </div>
  </div>

  <!-- Button + Animation CSS -->
  <style>
    .btn-order {
      position: relative;
      overflow: hidden;
      border: none;
      padding: 12px 30px;
      background: #BD8802;
      color: #fff;
      font-size: 18px;
      border-radius: 10px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      transition: transform 0.5s ease, box-shadow 0.5s ease;
      min-width: 160px;
      margin: 0 auto;
    }

    .btn-order:hover {
      background: #BD8802;
      box-shadow: 0 10px 15px rgba(0, 0, 0, 0.3);
      color: #fff;
      transform: translateY(-2px);
    }

    .btn-order:disabled {
      opacity: 0.8;
      cursor: not-allowed;
    }

    .btn-text {
      font-size: 16px;
      text-align: center;
      flex: 1;
    }

    .icon-check {
      display: none;
      font-size: 22px;
    }

    .van {
      position: absolute;
      width: 35px;
      bottom: 5px;
      left: -50px;
      opacity: 0.5;
      transition: transform 1s ease-out, opacity 0.3s;
    }

    .van.move {
      opacity: 1;
      transform: translateX(200px);
    }

    /* Highlight invalid fields */
    .is-invalid {
      border: 2px solid red !important;
    }

    /* Desktop view - all 4 in one row */
    @media screen and (min-width: 769px) {
      .row.align-items-center.p-2.g-0 {
        display: flex;
        flex-wrap: nowrap;
      }
      
      .order-price,
      .order-delivery,
      .order-total,
      .order-button {
        width: 25%;
        float: left;
      }
    }

    /* Mobile-specific styles */
    @media screen and (max-width: 768px) {
      .btn-order {
        padding: 12px 25px;
        font-size: 16px;
        min-width: 140px;
        width: 100%;
        max-width: 250px;
        display: flex;
        justify-content: center;
      }
      
      .btn-text {
        font-size: 16px;
        text-align: center;
      }
      
      /* Reset Bootstrap grid for mobile */
      .row.align-items-center.p-2.g-0 {
        display: block;
      }
      
      /* First row: Product Price + Delivery Charges side by side */
      .order-price,
      .order-delivery {
        display: inline-block;
        width: 50%;
        text-align: center;
        padding: 15px 5px !important;
        border-bottom: 1px solid #e0e0e0;
        margin-bottom: 0;
        float: left;
      }
      
      /* Second row: Total Amount - Added margin-top for spacing */
      .order-total {
        width: 100%;
        text-align: center;
        padding: 15px 5px !important;
        clear: both;
        margin: 10px 0 0 0; /* Added top margin for spacing */
      }
      
      /* Third row: Order Button */
      .order-button {
        width: 100%;
        text-align: center;
        padding: 20px 5px !important;
        clear: both;
      }
      
      /* Remove Bootstrap padding/margin reset */
      .col-12.col-md-3.text-center.py-2 {
        padding: 0 !important;
        margin: 0 !important;
      }
      
      /* Adjust font sizes for mobile */
      .small {
        font-size: 13px;
        margin-bottom: 5px;
      }
      
      .fw-bold {
        font-size: 14px;
      }
      
      .contact-form {
        padding: 20px !important;
      }
      
      /* Center all text in mobile */
      .order-price .small,
      .order-price .fw-bold,
      .order-delivery .small,
      .order-delivery .fw-bold,
      .order-total .small,
      .order-total .fw-bold {
        text-align: center;
      }
    }
    
    /* Small mobile devices */
    @media screen and (max-width: 480px) {
      .small {
        font-size: 12px;
      }
      
      .fw-bold {
        font-size: 13px;
      }
      
      .btn-order {
        min-width: 120px;
        padding: 10px 20px;
      }
      
      .order-price,
      .order-delivery {
        padding: 12px 3px !important;
      }
      
      .order-total {
        padding: 12px 3px !important;
        margin: 8px 0 0 0; /* Reduced top margin for small screens */
      }
      
      .order-button {
        padding: 15px 3px !important;
      }
    }
    
    /* Clear floats */
    .row.align-items-center.p-2.g-0::after {
      content: "";
      display: table;
      clear: both;
    }
  </style>

  <!-- Button Logic: Validation + Animation + Submit -->
  <script>
    document.getElementById("orderBtn").addEventListener("click", function(e) {
      e.preventDefault();

      const form = document.getElementById("contactForm");

      if (!form.checkValidity()) {
        form.reportValidity();

        const firstInvalid = form.querySelector(":invalid");
        if (firstInvalid) {
          firstInvalid.scrollIntoView({
            behavior: "smooth",
            block: "center"
          });
          firstInvalid.classList.add("is-invalid");
        }

        return;
      }

      const btn = this;
      const text = btn.querySelector(".btn-text");
      const van = btn.querySelector(".van");
      const check = btn.querySelector(".icon-check");

      btn.disabled = true;
      text.textContent = "Processing...";

      van.classList.add("move");

      setTimeout(() => {
        text.textContent = "Order Placed";
        check.style.display = "inline-block";
        van.style.display = "none";
        form.submit();
      }, 1200);
    });
  </script>

  <!-- Auto price update -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const totalDisplay = document.getElementById('total_price_display');
    const totalHidden = document.getElementById('total_price_hidden');
    
    const pricePerItem = {{ $product->price }};
    const deliveryCharges = {{ $product->delivery_charges ?? 0 }};
    const quantity = {{ request('qty', 1) }};
    
    const total = (quantity * pricePerItem) + deliveryCharges;
    
    totalDisplay.textContent = total.toLocaleString('en-US');
    totalHidden.value = total;
});
</script>
<!-- Enhanced Balance Check -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const orderBtn = document.getElementById('orderBtn');
    const balance = {{ auth()->user()->balance ?? 0 }};
    const totalHidden = document.getElementById('total_price_hidden');
    
    function updateButtonState() {
        const total = parseFloat(totalHidden.value) || 0;
        const insufficient = balance < total;
        
        orderBtn.disabled = insufficient;
        
        if (insufficient) {
            orderBtn.style.backgroundColor = '#6c757d';
            orderBtn.style.cursor = 'not-allowed';
            orderBtn.querySelector('.btn-text').textContent = 'Insufficient Balance';
            
            // Optional: Add warning message below button
            let warning = document.getElementById('balance-warning');
            if (!warning) {
                warning = document.createElement('p');
                warning.id = 'balance-warning';
                warning.className = 'text-danger text-center mt-2 mb-0 small';
                warning.innerHTML = `⚠️ Your balance (Rs. ${balance.toLocaleString()}) is less than total amount`;
                orderBtn.parentElement.appendChild(warning);
            }
        } else {
            orderBtn.style.backgroundColor = '';
            orderBtn.style.cursor = 'pointer';
            orderBtn.querySelector('.btn-text').textContent = 'Place Order';
            
            const warning = document.getElementById('balance-warning');
            if (warning) warning.remove();
        }
    }

    // Initial check
    setTimeout(updateButtonState, 50);
});
</script>

  @include('market.website.includes.footer')
  @include('market.website.includes.footer_links')

</body>

</html>