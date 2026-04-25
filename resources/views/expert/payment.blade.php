<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
  <title>Payment - Expert Registration</title>
  <!-- Tailwind CSS v3 -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            slate: {
              950: '#020617',
              900: '#0f172a',
              800: '#1e293b',
              700: '#334155',
              600: '#475569',
              500: '#64748b',
              400: '#94a3b8',
              300: '#cbd5e1',
              200: '#e2e8f0',
              100: '#f1f5f9',
            }
          }
        }
      }
    }
  </script>
  <style>
    input:focus {
      outline: none;
      ring: 2px solid #6366f1;
    }
  </style>
</head>



<body class="min-h-screen bg-slate-950 flex items-center justify-center px-4 py-8">
  <div class="w-full max-w-md bg-gradient-to-b from-slate-900 to-slate-950 rounded-2xl shadow-2xl border border-slate-700/50 p-6">
    <div class="text-center mb-6">
      <h2 class="text-2xl font-bold text-slate-100">Payment Details</h2>
      <p class="text-slate-400 text-sm mt-1">Complete your expert registration</p>
    </div>

    <div class="mb-6 text-center bg-slate-800/50 rounded-xl p-4">
      <p class="text-slate-400 text-sm">Amount to pay</p>
      <p class="text-3xl font-bold text-indigo-400">${{ number_format(session('amount'), 2) }}</p>
    </div>

    @if(session('error'))
    <div class="mb-4 p-3 bg-rose-900/30 border border-rose-700/40 rounded-lg text-rose-200 text-sm">
      {{ session('error') }}
    </div>
    @endif

    <form action="{{ route('expert.payment.process') }}" method="POST">
      @csrf
      <div class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-slate-300 mb-1">Card Number</label>
          <input type="text" name="card_number" maxlength="16" pattern="\d*"
            class="w-full px-4 py-2 bg-slate-800 border border-slate-700 rounded-lg text-slate-200 focus:ring-2 focus:ring-indigo-500"
            placeholder="1234 5678 9012 3456" required>
        </div>
        <div class="grid grid-cols-3 gap-3">
          <div>
            <label class="block text-sm font-medium text-slate-300 mb-1">MM</label>
            <input type="text" name="expiry_month" maxlength="2" pattern="\d*"
              class="w-full px-4 py-2 bg-slate-800 border border-slate-700 rounded-lg text-slate-200 focus:ring-2 focus:ring-indigo-500"
              placeholder="01" required>
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-300 mb-1">YY</label>
            <input type="text" name="expiry_year" maxlength="2" pattern="\d*"
              class="w-full px-4 py-2 bg-slate-800 border border-slate-700 rounded-lg text-slate-200 focus:ring-2 focus:ring-indigo-500"
              placeholder="25" required>
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-300 mb-1">CVC</label>
            <input type="text" name="cvc" maxlength="3" pattern="\d*"
              class="w-full px-4 py-2 bg-slate-800 border border-slate-700 rounded-lg text-slate-200 focus:ring-2 focus:ring-indigo-500"
              placeholder="123" required>
          </div>
        </div>
      </div>
      <button type="submit" class="mt-6 w-full py-2 bg-indigo-600 hover:bg-indigo-500 text-white font-medium rounded-lg transition">
        Pay ${{ number_format(session('amount'), 2) }}
      </button>
    </form>

    <div class="mt-4 text-center">
      <a href="{{ route('user_profile') }}" class="text-sm text-slate-400 hover:text-slate-300 transition">
        ← Cancel and return to profile
      </a>
    </div>
  </div>

  <script>
    // Get amount from URL parameter or use default (for demo)
    const urlParams = new URLSearchParams(window.location.search);
    let amount = parseFloat(urlParams.get('amount'));
    if (isNaN(amount) || amount <= 0) amount = 49.99; // fallback amount
    document.getElementById('amountDisplay').innerText = '$' + amount.toFixed(2);
    // Update button text
    const payBtn = document.getElementById('payButton');
    payBtn.innerText = 'Pay $' + amount.toFixed(2);

    // Format card number with spaces every 4 digits
    const cardInput = document.getElementById('card_number');
    cardInput.addEventListener('input', function(e) {
      let value = this.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
      let formatted = '';
      for (let i = 0; i < value.length; i++) {
        if (i > 0 && i % 4 === 0) formatted += ' ';
        formatted += value[i];
      }
      this.value = formatted;
    });

    // Luhn algorithm
    function luhnCheck(cardNumber) {
      let stripped = cardNumber.replace(/\s/g, '');
      if (!/^\d+$/.test(stripped)) return false;
      let sum = 0;
      let alternate = false;
      for (let i = stripped.length - 1; i >= 0; i--) {
        let n = parseInt(stripped.charAt(i), 10);
        if (alternate) {
          n *= 2;
          if (n > 9) n = (n % 10) + 1;
        }
        sum += n;
        alternate = !alternate;
      }
      return (sum % 10 === 0);
    }

    function showError(msg) {
      const errorDiv = document.getElementById('errorMessage');
      errorDiv.innerText = msg;
      errorDiv.classList.remove('hidden');
      setTimeout(() => {
        errorDiv.classList.add('hidden');
      }, 4000);
    }

    // Form submission handler
    document.getElementById('paymentForm').addEventListener('submit', function(e) {
      e.preventDefault();

      // Clear previous error
      document.getElementById('errorMessage').classList.add('hidden');

      // Get values
      let cardNumberRaw = document.getElementById('card_number').value;
      let month = document.getElementById('expiry_month').value;
      let year = document.getElementById('expiry_year').value;
      let cvc = document.getElementById('cvc').value;

      // Validate card number (Luhn)
      if (!luhnCheck(cardNumberRaw)) {
        showError('Invalid card number.');
        return;
      }
      // Validate month
      if (!/^\d{2}$/.test(month) || parseInt(month) < 1 || parseInt(month) > 12) {
        showError('Invalid expiry month (01-12).');
        return;
      }
      // Validate year (two digits)
      if (!/^\d{2}$/.test(year)) {
        showError('Invalid expiry year (two digits).');
        return;
      }
      // Validate CVC
      if (!/^\d{3}$/.test(cvc)) {
        showError('CVC must be 3 digits.');
        return;
      }

      // Check expiry date (not in past)
      const currentYear = new Date().getFullYear() % 100;
      const currentMonth = new Date().getMonth() + 1;
      let expYear = parseInt(year);
      let expMonth = parseInt(month);
      if (expYear < currentYear || (expYear === currentYear && expMonth < currentMonth)) {
        showError('Card has expired.');
        return;
      }

      alert('Payment successful! Redirecting to dashboard...');
      window.location.href = '/user-dashboard';
    });
  </script>
</body>

</html>