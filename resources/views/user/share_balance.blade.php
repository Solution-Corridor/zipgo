<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  @include('user.includes.general_style')
  <title>Share Balance – compact but airy</title>
  <style>
    /* ===== balanced compactness ===== */
    * {
      line-height: 1.3 !important;         /* slightly looser than before */
    }
    /* reduce but don't eliminate gaps from included sections */
    .top-greetings, .bottom-nav, [class*="greeting"], [class*="bottom"] {
      margin-top: 0 !important;
      margin-bottom: 0 !important;
      padding-top: 0.3rem !important;
      padding-bottom: 0.3rem !important;
    }
    /* main container – minimal outer padding */
    .max-w-\[420px\] {
      padding-top: 0.3rem !important;
      padding-bottom: 0.3rem !important;
    }
    /* inner content blocks – moderate spacing */
    .px-5, .px-4 {
      padding-left: 1rem !important;
      padding-right: 1rem !important;
    }
    .pt-5, .pb-6, .p-5 {
      padding-top: 0.75rem !important;
      padding-bottom: 0.75rem !important;
    }
    .mb-5, .mb-6 {
      margin-bottom: 0.75rem !important;
    }
    .mb-4, .mb-3 {
      margin-bottom: 0.6rem !important;
    }
    .mt-5 {
      margin-top: 0.75rem !important;
    }
    .space-y-4 > :not([hidden]) ~ :not([hidden]) {
      margin-top: 0.6rem !important;
    }
    /* form inputs – comfortable height */
    input, button {
      padding-top: 0.6rem !important;
      padding-bottom: 0.6rem !important;
    }
    .py-3, .py-3\.5, .py-4 {
      padding-top: 0.6rem !important;
      padding-bottom: 0.6rem !important;
    }
    .p-3, .p-3\.5, .p-4 {
      padding: 0.6rem !important;
    }
    /* balance card – slightly larger numbers */
    .text-3xl {
      font-size: 1.8rem !important;
    }
    h1.text-2xl {
      font-size: 1.5rem !important;
      margin-bottom: 0.1rem !important;
    }
    /* labels and small text – readable but compact */
    .text-sm, label, .text-xs, .text-gray-400 {
      font-size: 0.75rem !important;
    }
    /* extra small hint (min/max) */
    .text-2xs {
      font-size: 0.65rem !important;
    }
    /* amber note – medium compact */
    .bg-amber-900\/30 {
      padding: 0.5rem 0.75rem !important;
      margin-bottom: 0.75rem !important;
      font-size: 0.75rem !important;
    }
    /* bottom navigation – minimal height */
    [class*="bottom_navigation"], .bottom-nav, footer {
      padding: 0.3rem 0 !important;
      margin: 0 !important;
    }
  </style>
</head>
<body class="min-h-screen bg-[#0A0A0F] text-white font-sans">

<!-- main container – now with balanced padding -->
<div class="mx-auto max-w-[420px] min-h-screen bg-[#0A0A0F] shadow-2xl shadow-black/50 relative overflow-hidden">

  @include('user.includes.top_greetings')

  <!-- main content area – spacing slightly increased -->
  <div class="px-4" style="padding-top: 0.6rem; padding-bottom: 0.6rem;">

    

    <!-- important note – comfortable height -->
    <div class="mb-3 p-2.5 bg-amber-900/30 border border-amber-600/40 rounded-xl text-amber-300 text-center text-xs leading-normal">
      <strong>Important:</strong> Rs 100 to 5% Transactional Service Charge applies.
    </div>

    <!-- title section – a bit more breathing -->
    <h1 class="text-xl font-bold text-center mb-0.5">Share Balance</h1>
    <p class="text-center text-gray-400 text-xs mb-2">Instant transfer to another user</p>

    @include('includes.success')

    <!-- balance card – comfortable padding, clear number -->
    <div class="bg-gradient-to-r from-purple-900/35 to-indigo-900/35 border border-purple-500/25 rounded-xl p-3 mb-3 text-center">
      <p class="text-gray-400 text-xs uppercase tracking-wide">Available Balance</p>
      <p class="text-3xl font-bold mt-0.5">Rs {{ number_format(auth()->user()->balance, 0) }}</p>
    </div>

    <!-- form with moderate vertical gaps -->
    <form id="shareBalanceForm" action="{{ route('transfer.balance') }}" method="POST" class="space-y-4">
  @csrf

  <div>
    <label class="block text-xs font-medium text-gray-300 mb-1">Receiver Username / Phone</label>
    <input 
      type="text" 
      name="receiver_username" 
      required 
      placeholder="Username or Phone" 
      class="w-full px-4 py-4 bg-gray-900/65 border border-gray-700 rounded-xl focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/30 transition placeholder-gray-500 text-base font-semibold"
      autocomplete="off"
    >
    @error('receiver_username')
      <p class="text-red-400 text-2xs mt-1">{{ $message }}</p>
    @enderror
  </div>

  <div>
    <label class="block text-xs font-medium text-gray-300 mb-1">
      Amount 
      <span class="text-gray-500 text-2xs">(Min 1100 – Max {{ number_format(auth()->user()->balance, 0) }})</span>
    </label>
    <input 
      type="number" 
      name="amount" 
      id="amountInput"
      min="1100" 
      max="{{ auth()->user()->balance }}"
      required 
      placeholder="1100+" 
      class="w-full px-4 py-4 bg-gray-900/65 border border-gray-700 rounded-xl focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/30 transition text-base font-semibold"
    >
    @error('amount')
      <p class="text-red-400 text-2xs mt-1">{{ $message }}</p>
    @enderror
    <p id="amountError" class="text-red-400 text-2xs mt-1 hidden">
      Cannot exceed balance (Rs {{ number_format(auth()->user()->balance, 0) }})
    </p>
  </div>

  <button 
    type="submit"
    id="submitBtn"
    class="w-full py-4 mt-2 rounded-xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 shadow-lg active:scale-95 transition disabled:opacity-50 disabled:cursor-not-allowed"
    disabled
  >
    <span id="btnText">Confirm Transfer</span>
    <span id="loadingText" class="hidden">
      <i data-lucide="loader-2" class="w-3.5 h-3.5 inline animate-spin mr-1"></i>
      Processing...
    </span>
  </button>
</form>

  </div> <!-- end inner content -->

  @include('user.includes.bottom_navigation')

</div> <!-- end container -->

<!-- script unchanged -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  const amountInput = document.getElementById('amountInput');
  const amountError = document.getElementById('amountError');
  const submitBtn   = document.getElementById('submitBtn');
  const max         = {{ auth()->user()->balance }};

  amountInput.addEventListener('input', () => {
    const val = parseFloat(amountInput.value) || 0;

    if (val > max) {
      amountError.classList.remove('hidden');
      submitBtn.disabled = true;
    } else {
      amountError.classList.add('hidden');
      submitBtn.disabled = val < 1100;
    }
  });

  document.getElementById('shareBalanceForm').addEventListener('submit', () => {
    document.getElementById('btnText').classList.add('hidden');
    document.getElementById('loadingText').classList.remove('hidden');
    submitBtn.disabled = true;
  });

  lucide.createIcons();
});
</script>

</body>
</html>