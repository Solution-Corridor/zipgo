<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  <!-- Select2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<!-- Select2 JS (must be loaded after jQuery) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
  <?php echo $__env->make('user.includes.general_style', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  <title>Withdraw Funds</title>
</head>

<body class="min-h-screen bg-[#0A0A0F]">

  <!-- Mobile-like container -->
  <div class="mx-auto max-w-[420px] min-h-screen bg-[#0A0A0F] shadow-2xl shadow-black/50 relative">

    <?php echo $__env->make('user.includes.top_greetings', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <style>
      .glass {
        background: rgba(30, 30, 50, 0.55);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(100, 100, 255, 0.12);
      }

      .method-card {
        transition: all 0.25s ease;
        aspect-ratio: 1 / 1.1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 12px;
        padding: 16px 12px;
        border-radius: 16px;
        cursor: pointer;
        user-select: none;
      }

      .method-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px -6px rgba(0, 0, 0, 0.5);
      }

      .method-card.active {
        border-color: #22c55e;
        background: rgba(34, 197, 94, 0.12);
        box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.25);
      }

      .method-logo-container {
        width: 64px;
        height: 64px;
        background: rgba(0, 0, 0, 0.4);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
      }

      .method-logo {
        max-width: 52px;
        max-height: 52px;
        object-fit: contain;
      }
    </style>
    <!-- Withdraw-specific Info / Restriction Banner -->
    <div class="mb-3 p-4 bg-amber-900/30 border border-amber-600/40 rounded-xl text-amber-300 text-sm">
      <strong>Important:</strong>
      <ul class="mt-1.5 space-y-1 text-left max-w-xs mx-auto">
        <li>• Rs 100 to 5% Transactional Service Charge applies</li>
        <li>• Processing may take up to <strong class="text-amber-50">24-48 hours</strong></li>
      </ul>
    </div>

    <!-- Main Withdraw Section -->
    <div class="px-4 py-1">
      <!-- Back + Balance -->
      <div class="flex items-center justify-between mb-3">
        <button class="flex items-center text-gray-300 hover:text-white transition">
          Select Method
        </button>
        <div class="bg-green-900/40 px-3 py-1.5 rounded-full text-green-300 text-sm font-medium">
          Balance: Rs <?php echo e(number_format($user->balance, 2)); ?>

        </div>
      </div>

      <!-- Payment Methods -->
      <div class="mb-3 pb-2">
        <?php echo $__env->make('includes.success', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <!-- STEP 1: Select Method -->
        <div id="step-methods">
          <div class="grid grid-cols-3 sm:grid-cols-4 gap-3.5">
            <div class="method-card glass" data-method="easypaisa" data-min="1000" data-max="50000">
              <div class="method-logo-container">
                <img src="/assets/images/easypaisa.png" alt="Easypaisa">
              </div>
              <div class="text-sm font-medium text-center">Easypaisa</div>
            </div>

            <div class="method-card glass" data-method="jazzcash" data-min="1000" data-max="50000">
              <div class="method-logo-container">
                <img src="/assets/images/jazzcash.png" alt="JazzCash">
              </div>
              <div class="text-sm font-medium text-center">JazzCash</div>
            </div>

            <div class="method-card glass" data-method="nayapay" data-min="1000" data-max="50000">
              <div class="method-logo-container">
                <img src="/assets/images/nayapay.png" alt="Nayapay">
              </div>
              <div class="text-sm font-medium text-center">Nayapay</div>
            </div>

            <div class="method-card glass" data-method="sadaypay" data-min="1000" data-max="50000">
              <div class="method-logo-container">
                <img src="/assets/images/sadapay.png" alt="Sadaypay">
              </div>
              <div class="text-sm font-medium text-center">Sadapay</div>
            </div>

            <div class="method-card glass" data-method="bank" data-min="1000" data-max="1000000">
              <div class="method-logo-container">
                <img src="/assets/images/meezan.png" alt="Bank">
              </div>
              <div class="text-sm font-medium text-center">Bank</div>
            </div>

            <div class="method-card glass" data-method="raast" data-min="1000" data-max="1000000">
              <div class="method-logo-container">
                <img src="/assets/images/raast.png" alt="Raas">
              </div>
              <div class="text-sm font-medium text-center">Raast</div>
            </div>

            <div class="method-card glass" data-method="binance" data-min="1000" data-max="1000000">
              <div class="method-logo-container">
                <img src="/assets/images/binance.png" alt="Raas">
              </div>
              <div class="text-sm font-medium text-center">Binance</div>
            </div>
          </div>
        </div>


        <!-- STEP 2: Enter Details -->
        <div id="step-details" class="hidden space-y-5">

          <button id="btn-back" class="flex items-center text-gray-400 hover:text-gray-200 text-sm mb-2">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-1.5"></i>
            Back to methods
          </button>

          <div class="glass rounded-xl p-5 space-y-5">

            <!-- Selected method -->
            <div class="flex items-center gap-3">
              <div class="method-logo-container w-12 h-12">
                <img id="selected-logo" src="" alt="" class="method-logo">
              </div>
              <div>
                <div class="font-semibold text-base" id="selected-name">---</div>
                <div class="text-xs text-gray-500">Selected Method</div>
              </div>
            </div>

            <form id="withdraw-form" method="POST" action="<?php echo e(route('withdraw.store')); ?>">
              <?php echo csrf_field(); ?>
              <input type="hidden" name="method" id="hidden_method" value="">

              <!-- Amount -->
              <!-- Amount Section - Quick Select Buttons -->

              <style>
                .amount-btn {
  background: #1f1f2b;
  border: 1px solid #374151;
  color: #e5e7eb;
  padding: 3px;
  border-radius: 5px;
  font-size: 15px;
  font-weight: 600;
  transition: all 0.2s ease;
  cursor: pointer;
  user-select: none;
}

.amount-btn:hover {
  background: #374151;
  border-color: #4b5563;
  transform: translateY(-1px);
}

.amount-btn.active {
  background: #22c55e;
  color: black;
  border-color: #22c55e;
  box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.3);
}
              </style>
<div>
  <label class="block text-sm font-medium mb-1.5">Amount (PKR)</label>
  
  <!-- Quick Amount Buttons -->
  <div class="grid grid-cols-4 gap-2 mb-3" id="amount-buttons">
    <button type="button" class="amount-btn" data-amount="1000">1,000</button>
    <button type="button" class="amount-btn" data-amount="1500">1,500</button>
    <button type="button" class="amount-btn" data-amount="5000">5,000</button>
    <button type="button" class="amount-btn" data-amount="15000">15,000</button>
    <button type="button" class="amount-btn" data-amount="30000">30,000</button>
    <button type="button" class="amount-btn" data-amount="50000">50,000</button>
    <button type="button" class="amount-btn" data-amount="100000">1,00,000</button>
    <!-- You can add more if needed -->
  </div>

  <!-- Read-only Input -->
  <div class="relative">
    <input
      name="amount"
      id="amount"
      type="text"
      readonly
      required
      class="w-full bg-gray-900 border border-gray-700 rounded-lg py-3 px-4 focus:outline-none focus:border-green-600"
      placeholder="Select amount from above">
    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 text-sm font-medium">PKR</span>
  </div>

  <p class="text-xs text-gray-600 mt-1.5">
    Min: <span id="show-min">1000</span> – Max: <span id="show-max">50,000</span>
  </p>
</div>

              <!-- Bank Selection (visible only for "bank" method) -->
              <div id="bank-selection" class="hidden">
                <label class="block text-sm font-medium mb-1.5">Select Bank</label>
                <select name="bank_name" id="bankSelect" class="select2">
  <!-- Commercial Banks -->
    <option value="">Search Bank</option>
    <option value="Allied Bank Limited (ABL)">Allied Bank Limited (ABL)</option>
    <option value="Askari Bank">Askari Bank</option>
    <option value="Bank AL Habib">Bank AL Habib</option>
    <option value="Bank Alfalah">Bank Alfalah</option>
    <option value="Bank of China">Bank of China</option>
    <option value="Bank of Khyber">Bank of Khyber</option>
    <option value="Bank of Punjab">Bank of Punjab</option>
    <option value="Citibank N.A.">Citibank N.A.</option>
    <option value="Deutsche Bank AG">Deutsche Bank AG</option>
    <option value="Dubai Islamic Bank">Dubai Islamic Bank</option>
    <option value="Faysal Bank">Faysal Bank</option>
    <option value="First Women Bank">First Women Bank</option>
    <option value="Habib Bank Limited (HBL)">Habib Bank Limited (HBL)</option>
    <option value="Habib Metropolitan Bank">Habib Metropolitan Bank</option>
    <option value="Industrial and Commercial Bank of China (ICBC)">Industrial and Commercial Bank of China (ICBC)</option>
    <option value="JS Bank">JS Bank</option>
    <option value="MCB Bank Limited">MCB Bank Limited</option>
    <option value="MCB Islamic Bank">MCB Islamic Bank</option>
    <option value="Meezan Bank">Meezan Bank</option>
    <option value="National Bank of Pakistan (NBP)">National Bank of Pakistan (NBP)</option>
    <option value="Samba Bank">Samba Bank</option>
    <option value="Saudi Pak Bank">Saudi Pak Bank</option>
    <option value="Silkbank">Silkbank</option>
    <option value="Sindh Bank">Sindh Bank</option>
    <option value="Soneri Bank">Soneri Bank</option>
    <option value="Standard Chartered Bank">Standard Chartered Bank</option>
    <option value="Summit Bank">Summit Bank</option>
    <option value="United Bank Limited (UBL)">United Bank Limited (UBL)</option>
    <option value="Zarai Taraqiati Bank (ZTBL)">Zarai Taraqiati Bank (ZTBL)</option>
  

  <!-- Microfinance Banks -->
 
    <option value="Advans Pakistan Microfinance Bank">Advans Pakistan Microfinance Bank</option>
    <option value="Apna Microfinance Bank">Apna Microfinance Bank</option>
    <option value="FINCA Microfinance Bank">FINCA Microfinance Bank</option>
    <option value="HBL Microfinance Bank">HBL Microfinance Bank</option>
    <option value="Khushhali Microfinance Bank">Khushhali Microfinance Bank</option>
    <option value="LOLC Microfinance Bank (formerly Pak Oman)">LOLC Microfinance Bank (formerly Pak Oman)</option>
    <option value="Mobilink Microfinance Bank (JazzCash)">Mobilink Microfinance Bank (JazzCash)</option>
    <option value="NRSP Microfinance Bank">NRSP Microfinance Bank</option>
    <option value="Sindh Microfinance Bank">Sindh Microfinance Bank</option>
    <option value="Telenor Microfinance Bank (Easypaisa)">Telenor Microfinance Bank (Easypaisa)</option>
    <option value="U Microfinance Bank (UPaisa)">U Microfinance Bank (UPaisa)</option>
  

  <!-- Digital Banks -->
  
    <option value="Easypaisa Bank Limited">Easypaisa Bank Limited</option>
    <option value="Hugo Bank Limited">Hugo Bank Limited</option>
    <option value="KT Bank Pakistan Limited">KT Bank Pakistan Limited</option>
    <option value="Mashreq Bank Pakistan Limited">Mashreq Bank Pakistan Limited</option>
    <option value="Raqami Islamic Digital Bank Limited">Raqami Islamic Digital Bank Limited</option>
  

  <!-- Electronic Money Institutions (EMIs) / Wallets -->
  
    <option value="Akhtar Fuiou Technologies">Akhtar Fuiou Technologies</option>
    <option value="E-Processing Systems">E-Processing Systems</option>
    <option value="Finja">Finja</option>
    <option value="NayaPay">NayaPay</option>
    <option value="SadaPay">SadaPay</option>
    <option value="Wemsol">Wemsol</option>
  
</select>
                <p class="text-xs text-gray-600 mt-1.5">Select your bank from the list</p>
              </div>

              <!-- Account Number -->
              <div>
                <label class="block text-sm font-medium mb-1.5">Account / Mobile / IBAN</label>
                <input
                  name="account_number"
                  id="account-number"
                  type="text"
                  class="w-full bg-gray-900 border border-gray-700 rounded-lg py-3 px-4 text-base focus:outline-none focus:border-green-600"
                  placeholder="03xxxxxxxxx or PKxx...">
              </div>

              <!-- Account Title -->
              <div>
                <label class="block text-sm font-medium mb-1.5">Account Title / Name</label>
                <input
                  name="account_title"
                  id="account-title"
                  type="text"
                  pattern="^[A-Za-z\s]+$"
                  title="Only alphabets and spaces are allowed"
                  class="w-full bg-gray-900 border border-gray-700 rounded-lg py-3 px-4 text-base focus:outline-none focus:border-green-600"
                  placeholder="Full name as per account"
                  required
                  oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')">
              </div>

              <!-- Submit -->
              <div class="pt-4">
                <button
                  type="submit"
                  class="w-full bg-green-600 hover:bg-green-500 text-white font-semibold py-3.5 rounded-xl transition text-base flex items-center justify-center">
                  Submit Withdrawal Request
                </button>
                <p class="text-xs text-center text-gray-600 mt-3 leading-tight">
                  Double-check details — withdrawals are irreversible
                </p>
              </div>
            </form>

          </div>
        </div>
      </div>

      <!-- Withdrawal Instructions -->
<div class="mt-0 mb-12 glass rounded-xl p-4 border border-red-500/30">

  <div class="flex items-center gap-2 mb-3">
    <span class="text-red-400 text-lg">⚠</span>
    <h3 class="text-sm font-semibold text-red-300">Withdrawal Instructions</h3>
  </div>

  <ul class="text-sm text-gray-300 space-y-2 leading-relaxed">
    <li>
      • Please make sure all withdrawal details
      (<span class="text-gray-200">account number, bank name, wallet address</span>)
      are entered <strong class="text-white">correctly</strong> before submitting your request.
    </li>

    <li>
      • If a withdrawal fails or funds are sent to the wrong account due to
      <strong class="text-red-300">incorrect information</strong> provided by you,
      the loss will be your responsibility.
    </li>

    <li>
      • The company <strong class="text-red-300">will not be responsible</strong>
      for mistakes in account or payment details entered by the user.
    </li>

<li>
  • If a withdrawal request is <strong class="text-red-300">cancelled by the user</strong>,
  the deducted <span class="text-amber-300">service fee Rs 100 to 5%</span> will not be refunded.
  The remaining amount will be returned to the user's balance.
</li>

    <li>
      • Always double-check your information to ensure a
      <span class="text-green-300">smooth and successful withdrawal</span>.
    </li>
  </ul>

</div>

      <div class="h-8"></div>

      
    </div>

    <?php echo $__env->make('user.includes.bottom_navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<!-- Move jQuery and Lucide BEFORE Select2 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/lucide@latest"></script>
<!-- Now load Select2 JS (after jQuery) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<style>
  /* === Select2 Dark Theme Overrides === */

/* Dropdown container */
.select2-dropdown {
    background-color: #1f1f2b;        /* dark background for the dropdown */
    border: 1px solid #2d2d3a;        /* subtle border */
    border-radius: 8px;               /* smooth corners */
    box-shadow: 0 8px 20px rgba(0,0,0,0.6); /* floating effect */
}

/* Search field inside dropdown */
.select2-search--dropdown {
    padding: 8px;
    background-color: #1f1f2b;        /* same as dropdown */
}
.select2-search--dropdown .select2-search__field {
    background-color: #0f0f1a;         /* darker field */
    border: 1px solid #3a3a4a;
    color: #e0e0e0;                    /* light text */
    border-radius: 6px;
    padding: 8px 10px;
}
.select2-search--dropdown .select2-search__field:focus {
    border-color: #22c55e;              /* green accent on focus */
    outline: none;
}

/* Each result item */
.select2-results__option {
    background-color: #1f1f2b;
    color: #ddd;
    padding: 8px 12px;
    font-size: 14px;
}
.select2-results__option--highlighted {
    background-color: #2a2a3a !important;  /* hover color */
    color: white !important;
}
.select2-results__option[aria-selected="true"] {
    background-color: #22c55e !important;   /* selected item */
    color: black !important;
}

/* Fix the "clear" button and other small elements */
.select2-container--default .select2-selection--single {
    background-color: #0f0f1a;           /* matches your input background */
    border: 1px solid #3a3a4a;
    border-radius: 8px;
    height: 46px;                        /* adjust to match your inputs */
    line-height: 46px;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #e0e0e0;
    line-height: 46px;
    padding-left: 15px;
}
.select2-container--default .select2-selection--single .select2-selection__placeholder {
    color: #aaa;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 44px;
    right: 10px;
}
.select2-container--default .select2-selection--single .select2-selection__arrow b {
    border-color: #aaa transparent transparent transparent;
}
.select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
    border-color: transparent transparent #aaa transparent;
}

/* When dropdown is open, style the selected item in the closed box */
.select2-container--default.select2-container--open .select2-selection--single {
    border-color: #22c55e;
}

/* If you use "allowClear", style the "x" */
.select2-container--default .select2-selection--single .select2-selection__clear {
    color: #aaa;
    right: 25px;
}

.select2-container--default .select2-dropdown {
  background: rgba(30, 30, 50, 0.55) !important;
  backdrop-filter: blur(10px);
  border: 1px solid rgba(100, 100, 255, 0.18);
  border-radius: 12px;
}
/* Force original select to be hidden after Select2 initialises */
#bankSelect.select2-hidden-accessible {
    position: absolute !important;
    left: -10000px !important;
    top: auto !important;
    width: 1px !important;
    height: 1px !important;
    overflow: hidden !important;
    clip: rect(0, 0, 0, 0) !important;
    white-space: nowrap !important;
}
</style>

<script>
  document.addEventListener('DOMContentLoaded', function() {

    // --- Lucide Icons ---
    if (typeof lucide !== 'undefined') {
      lucide.createIcons();
    } else {
      console.warn('Lucide not loaded – icons may not appear.');
    }

    // --- Select2 Initialisation ---
    try {
      if (typeof $ !== 'undefined' && $('#bankSelect').length) {
        $('#bankSelect').select2({
          placeholder: 'Search for a bank...',
          allowClear: true,
          width: '100%'
        });
        console.log('Select2 initialised successfully.');
      } else {
        console.warn('jQuery or #bankSelect missing – Select2 not initialised.');
      }
    } catch (e) {
      console.error('Select2 initialisation failed:', e);
    }

    // --- DOM Elements ---
    const methodCards     = document.querySelectorAll('.method-card');
    const stepMethods     = document.getElementById('step-methods');
    const stepDetails     = document.getElementById('step-details');
    const btnBack         = document.getElementById('btn-back');
    const bankSelection   = document.getElementById('bank-selection');
    const bankSelect      = document.getElementById('bankSelect');

    const selectedNameEl  = document.getElementById('selected-name');
    const selectedLogoEl  = document.getElementById('selected-logo');
    const showMinEl       = document.getElementById('show-min');
    const showMaxEl       = document.getElementById('show-max');
    const hiddenMethodEl  = document.getElementById('hidden_method');
    const amountInput     = document.getElementById('amount');
    const amountButtons   = document.querySelectorAll('.amount-btn');

    if (!stepMethods || !stepDetails) {
      console.error('Required elements missing – cannot attach events.');
      return;
    }

    // ======================
    //  UPDATE AMOUNT LIMITS
    // ======================
    function updateAmountLimits(min, max) {
      if (showMinEl) showMinEl.textContent = min.toLocaleString();
      if (showMaxEl) showMaxEl.textContent = max.toLocaleString();

      if (amountInput) {
        amountInput.dataset.min = min;
        amountInput.dataset.max = max;
        amountInput.value = '';                    // clear previous amount
      }

      // Remove active state from all buttons
      amountButtons.forEach(btn => btn.classList.remove('active'));
    }

    // ======================
    //  AMOUNT BUTTONS LOGIC
    // ======================
    amountButtons.forEach(button => {
      button.addEventListener('click', () => {
        const value = parseInt(button.dataset.amount);
        const min   = parseInt(amountInput.dataset.min) || 1000;
        const max   = parseInt(amountInput.dataset.max) || 50000;

        if (value >= min && value <= max) {
          amountInput.value = value;

          // Highlight only the clicked button
          amountButtons.forEach(btn => btn.classList.remove('active'));
          button.classList.add('active');
        } else {
          alert(`Amount must be between ${min.toLocaleString()} and ${max.toLocaleString()} PKR for this method.`);
        }
      });
    });

    // ======================
    //  PAYMENT METHOD CARDS
    // ======================
    methodCards.forEach(card => {
      card.addEventListener('click', () => {
        // Remove active from all cards
        methodCards.forEach(c => c.classList.remove('active'));
        card.classList.add('active');

        const methodName = card.querySelector('div.text-sm')?.textContent.trim() || '';
        const methodLogo = card.querySelector('img')?.src || '';
        const methodValue = card.dataset.method;
        const min = Number(card.dataset.min) || 1000;
        const max = Number(card.dataset.max) || 50000;

        // Update UI
        if (selectedNameEl) selectedNameEl.textContent = methodName;
        if (selectedLogoEl) selectedLogoEl.src = methodLogo;
        if (hiddenMethodEl) hiddenMethodEl.value = methodValue;

        // Update amount limits + reset input
        updateAmountLimits(min, max);

        // Show/hide bank selection
        if (methodValue === 'bank') {
          bankSelection?.classList.remove('hidden');
          if (bankSelect) bankSelect.required = true;
        } else {
          bankSelection?.classList.add('hidden');
          if (bankSelect) {
            bankSelect.required = false;
            bankSelect.value = '';
            if (typeof $ !== 'undefined') {
              $(bankSelect).val(null).trigger('change');
            }
          }
        }

        // Switch steps
        stepMethods.classList.add('hidden');
        stepDetails.classList.remove('hidden');
      });
    });

    // ======================
    //  BACK BUTTON
    // ======================
    if (btnBack) {
      btnBack.addEventListener('click', () => {
        stepDetails.classList.add('hidden');
        stepMethods.classList.remove('hidden');
        methodCards.forEach(c => c.classList.remove('active'));

        const form = document.getElementById('withdraw-form');
        if (form) form.reset();

        bankSelection?.classList.add('hidden');
        if (bankSelect) {
          bankSelect.required = false;
          bankSelect.value = '';
          if (typeof $ !== 'undefined') {
            $(bankSelect).val(null).trigger('change');
          }
        }

        // Clear amount buttons
        if (amountInput) amountInput.value = '';
        amountButtons.forEach(btn => btn.classList.remove('active'));
      });
    }

  }); // End of DOMContentLoaded

  // ======================
  //  Select2 Extra Config (outside DOMContentLoaded)
  // ======================
  $(document).ready(function() {
    $('#bankSelect').select2({
      placeholder: 'Search for a bank...',
      allowClear: true,
      width: '100%'
    });

    $(document).on('select2:open', '#bankSelect', function () {
      setTimeout(function() {
        document.querySelector('.select2-container--open .select2-search__field').focus();
      }, 0);
    });
  });

</script>

</body>

</html><?php /**PATH E:\xampp\htdocs\FeatureDesk\resources\views/user/withdraw.blade.php ENDPATH**/ ?>