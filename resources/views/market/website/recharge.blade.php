<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  @include('user.includes.general_style')
  <title>Recharge Wallet</title>
</head>

<body class="min-h-screen text-gray-200 flex items-start justify-center" style="background: #0B0B12;">

  <div class="w-full max-w-[420px] min-h-screen relative bg-[#0B0B12] mb-16">

    @include('user.includes.top_greetings')

    <div class="px-4 py-6">

      <!-- Page Header -->
      <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-white">Recharge</h1>
        <p class="text-gray-400 mt-1">Add money to your wallet instantly</p>
      </div>

      <!-- Current Balance Card -->
      <div class="bg-[#151520] rounded-3xl p-6 mb-8 text-center border border-gray-800">
        <p class="text-sm text-gray-400 uppercase tracking-widest">Available Balance</p>
        <p class="text-4xl font-bold text-emerald-400 mt-2">
          Rs {{ number_format($balance ?? 0) }}
        </p>
      </div>

      <!-- Recharge Amount -->
      <div class="mb-8">
        <label class="block text-sm text-gray-400 mb-3">Enter Recharge Amount</label>

        <div class="grid grid-cols-3 gap-3 mb-4">
          <button onclick="setAmount(500)"
            class="amount-btn bg-[#1F1F2E] hover:bg-[#2A2A3A] py-3 rounded-2xl text-lg font-semibold transition">
            500
          </button>
          <button onclick="setAmount(1000)"
            class="amount-btn bg-[#1F1F2E] hover:bg-[#2A2A3A] py-3 rounded-2xl text-lg font-semibold transition">
            1,000
          </button>
          <button onclick="setAmount(2000)"
            class="amount-btn bg-[#1F1F2E] hover:bg-[#2A2A3A] py-3 rounded-2xl text-lg font-semibold transition">
            2,000
          </button>
        </div>

        <div class="relative">
          <span class="absolute left-5 top-1/2 -translate-y-1/2 text-2xl font-bold text-gray-400">Rs</span>
          <input type="number" id="amount"
            class="w-full bg-[#151520] border border-gray-700 focus:border-emerald-500 rounded-3xl py-5 pl-14 pr-6 text-3xl font-bold text-white outline-none"
            placeholder="0" min="100" required>
        </div>
      </div>

      <!-- Payment Methods -->
      <!-- Payment Methods -->
      <div class="mb-8">
        <p class="text-sm text-gray-400 mb-4">Choose Payment Method</p>

        <div class="flex items-center gap-5 flex-wrap">
          <img src="/assets/images/payment/easypaisa.avif"
            alt="Easypaisa"
            title="Easypaisa"
            class="payment-method w-12 h-auto cursor-pointer hover:scale-110 active:scale-95 transition-transform duration-200">

          <img src="/assets/images/payment/jazzcash.avif"
            alt="Jazzcash"
            title="Jazzcash"
            class="payment-method w-12 h-auto cursor-pointer hover:scale-110 active:scale-95 transition-transform duration-200">

          <img src="/assets/images/payment/visa.avif"
            alt="Visa Card"
            title="Visa Card"
            class="payment-method w-12 h-auto cursor-pointer hover:scale-110 active:scale-95 transition-transform duration-200">

          <img src="/assets/images/payment/master.avif"
            alt="Mastercard"
            title="Mastercard"
            class="payment-method w-12 h-auto cursor-pointer hover:scale-110 active:scale-95 transition-transform duration-200">
        </div>
      </div>

      <!-- Recharge Button -->
      <button onclick="processRecharge()"
        class="w-full bg-emerald-500 hover:bg-emerald-600 transition py-5 rounded-3xl text-xl font-bold text-white shadow-lg shadow-emerald-500/30">
        Recharge Now
      </button>

      <p class="text-center text-xs text-gray-500 mt-6">
        Secure & Instant • Powered by EasyPaisa, JazzCash & Cards
      </p>

    </div>

    @include('user.includes.bottom_navigation')

  </div>

  <script>
    function setAmount(val) {
      document.getElementById('amount').value = val;
    }

    function processRecharge() {
      const amount = document.getElementById('amount').value;
      if (!amount || amount < 100) {
        alert("Please enter a valid amount (minimum Rs 100)");
        return;
      }
      // Add your form submission logic here
      alert("Recharge of Rs " + amount + " initiated successfully!");
      // window.location.href = "/recharge/confirm?amount=" + amount;
    }

    // Optional: Highlight selected payment method
    document.querySelectorAll('.payment-method').forEach(img => {
      img.addEventListener('click', () => {
        document.querySelectorAll('.payment-method').forEach(i => i.style.opacity = '0.5');
        img.style.opacity = '1';
      });
    });
  </script>

</body>

</html>