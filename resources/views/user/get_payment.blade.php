<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  @include('user.includes.general_style')
  <title>Payment</title>
  <!-- lucide icons -->
  <script src="https://unpkg.com/lucide@latest"></script>
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
      box-shadow: 0 12px 30px -6px rgba(0,0,0,0.5);
    }
    .method-card.active {
      border-color: #22c55e;
      background: rgba(34, 197, 94, 0.12);
      box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.25);
    }
    .method-logo-container {
      width: 64px;
      height: 64px;
      background: rgba(0,0,0,0.4);
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
    .method-name {
      font-size: 0.95rem;
      font-weight: 600;
      text-align: center;
      line-height: 1.3;
    }

    @media (max-width: 420px) {
      .methods-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
      }
    }

    .copy-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 28px;
  height: 28px;
  margin-left: 8px;
  color: #9ca3af;           /* gray-400 */
  background: rgba(100, 100, 255, 0.08);
  border: 1px solid rgba(100, 100, 255, 0.15);
  border-radius: 6px;
  cursor: pointer;
  transition: all 0.2s ease;
  vertical-align: middle;
}

.copy-btn:hover {
  color: #d1d5db;           /* gray-300 */
  background: rgba(100, 100, 255, 0.15);
  border-color: rgba(100, 100, 255, 0.3);
}

.copy-btn.copied {
  color: #22c55e;           /* emerald-500 */
  background: rgba(34, 197, 94, 0.12);
  border-color: rgba(34, 197, 94, 0.4);
}

.copy-btn.copied::after {
  content: "Copied!";
  position: absolute;
  top: -32px;
  left: 50%;
  transform: translateX(-50%);
  background: #111827;
  color: #22c55e;
  font-size: 11px;
  padding: 4px 8px;
  border-radius: 4px;
  white-space: nowrap;
  pointer-events: none;
  animation: fadeOut 2s forwards;
}

@keyframes fadeOut {
  0%   { opacity: 1; transform: translateX(-50%) translateY(0); }
  80%  { opacity: 1; transform: translateX(-50%) translateY(-4px); }
  100% { opacity: 0; transform: translateX(-50%) translateY(-8px); }
}

  </style>
</head>

<body class="min-h-screen bg-[#0A0A0F] text-white font-sans">

  <div class="mx-auto max-w-[420px] min-h-screen bg-[#0A0A0F] shadow-2xl shadow-black/60 relative">

    <!-- Top bar / header -->
    @include('user.includes.top_greetings')

    <main class="px-5 pt-1 pb-32">

      <h1 class="text-xl font-semibold text-center mb-3 bg-gradient-to-r from-cyan-400 to-blue-600 bg-clip-text text-transparent">
        Payment
      </h1>

      @include('includes.success')
      <!-- NEW: Display error messages -->
      

      <!-- Compact Plan Card -->
      <div class="glass rounded-xl px-4 py-3 mb-4 shadow-md flex items-center justify-between">
        <div>
          <span class="text-cyan-300 font-semibold">Plan:</span>
          <span class="font-bold ml-1">{{ $plan->name ?? 'Eagle-01' }}</span>
        </div>

        <div>
          <span class="text-gray-400 text-sm">Amount:</span>
          <span class="text-emerald-400 font-bold ml-1">
            {{ number_format($plan->investment_amount ?? 445) }} Rs
          </span>
        </div>
      </div>

      <!-- Payment Methods -->
      <div class="mb-8">
        <h2 class="text-lg font-semibold mb-5 text-center text-gray-300">
          Select Payment Method
        </h2>

        <div class="methods-grid 
              grid grid-cols-2          
              xs:grid-cols-3           
              sm:grid-cols-3           
              md:grid-cols-4           
              gap-3 sm:gap-4 lg:gap-5">

          @forelse ($activeMethods as $method)
            <div 
              class="method-card glass"
              data-is-internal="false"
              data-method='@json($method)'
            >
              <div class="method-logo-container">
                @if ($method->account_type == 'easypaisa')
                  <img src="/assets/images/easypaisa.png" alt="Easypaisa" class="method-logo">
                @endif
                @if ($method->account_type == 'jazzcash')
                  <img src="/assets/images/jazzcash.png" alt="JazzCash" class="method-logo">
                @endif
                @if ($method->account_type == 'nayapay')
                  <img src="/assets/images/nayapay.png" alt="NayaPay" class="method-logo">
                @endif
                @if ($method->account_type == 'sadapay')
                  <img src="/assets/images/sadapay.png" alt="SadaPay" class="method-logo">
                @endif
                @if ($method->account_type == 'bank')
                  <img src="/assets/images/meezan.png" alt="Bank" class="method-logo">
                @endif
                @if ($method->account_type == 'raast')
                  <img src="/assets/images/raast.png" alt="Raast" class="method-logo">
                @endif
                @if ($method->account_type == 'binance')
                  <img src="/assets/images/binance.png" alt="Binance" class="method-logo">
                @endif
              </div>
              <div class="method-name">
                {{ ucfirst($method->account_type) }}
              </div>
            </div>
          @empty
            <div class="col-span-4 text-center py-10 text-gray-500">
              No active payment methods available at the moment.
            </div>
          @endforelse

          <!-- STATIC INTERNAL FUNDS CARD -->
          <!-- <div 
            class="method-card glass"
            data-is-internal="true"
          >
            <div class="method-logo-container">
              <i data-lucide="wallet" class="w-10 h-10 text-emerald-400"></i>
              <img src="/assets/images/internal_transfer.png"> 
            </div>
            <div class="method-name">
              Internal Funds
            </div>
          </div> -->

        </div>
      </div>

      <!-- Details panel (shown when method selected) -->
      <div id="method-details" class="hidden glass rounded-2xl p-6 mt-8">

        <h3 id="method-title" class="text-xl font-bold mb-6 text-cyan-300 text-center"></h3>

        <!-- Account Information -->
        <div class="space-y-3 mb-6 text-sm">

          <div style="visibility: hidden; display:none;">
  <span class="text-gray-400">Account Title:</span>
  <div id="account-title" class="font-semibold text-white"></div>
</div>

          <!-- Account / Balance -->
<div class="flex items-center">
  <div>
    <span class="text-gray-400">Account #:</span>
    <div id="account-number" class="font-semibold text-white inline"></div>
  </div>
  <button type="button" class="copy-btn" data-clipboard-target="account-number" title="Copy account number">
    <i data-lucide="copy" class="w-4 h-4"></i>
  </button>
</div>

<!-- IBAN (remains hidden by default) -->
<div id="iban-wrapper" class="hidden flex items-center">
  <div>
    <span class="text-gray-400">IBAN:</span>
    <div id="iban-number" class="font-semibold text-white inline"></div>
  </div>
  <button type="button" class="copy-btn" data-clipboard-target="iban-number" title="Copy IBAN">
    <i data-lucide="copy" class="w-4 h-4"></i>
  </button>
</div>

          <div>
            <span class="text-gray-400">Instructions:</span>
            <div id="method-instructions" class="text-gray-300 whitespace-pre-line"></div>
          </div>

        </div>

        <!-- Receipt Sample -->
        <div id="sample-wrapper" class="hidden mb-6">
          <p class="text-gray-400 mb-2 text-sm">Receipt Sample:</p>
          <img id="receipt-sample-img" 
               class="rounded-lg border border-gray-700 max-h-60 object-contain mx-auto">
        </div>

        <!-- Confirmation Form -->
        <form action="{{ route('user.payment.confirm') }}" 
              method="POST" 
              enctype="multipart/form-data"
              class="space-y-4">

          @csrf

          <input type="hidden" name="plan_id" value="{{ $plan->id }}">
          <input type="hidden" name="payment_method_id" id="selected_method_id">
          <input type="hidden" name="is_internal" id="is_internal" value="0">

          <!-- Transaction ID -->
<div id="transaction-wrapper">
  <label class="text-sm text-gray-400">Transaction ID</label>
  <input type="number"
         name="transaction_id"
         id="transaction_id"
         required
         placeholder="Enter your transaction ID"
         inputmode="numeric"
         pattern="[0-9]*"
         class="w-full mt-1 px-4 py-3 rounded-xl bg-black/40 border border-gray-700 focus:border-emerald-500 outline-none">
</div>

<!-- Screenshot Upload -->
<div id="upload-wrapper" class="mb-3">
  <label class="text-xs text-gray-400 block mb-1">Payment Screenshot</label>
  
  <div id="upload-box" class="relative border border-dashed border-gray-600 rounded-lg px-4 py-3 text-center cursor-pointer bg-black/20 hover:border-emerald-500/70">
    <input type="file" name="receipt_image" id="receipt_image" accept="image/*" required class="absolute inset-0 opacity-0 z-10">

    <div id="upload-content" class="space-y-1.5 text-sm">
      <i data-lucide="upload-cloud" class="w-7 h-7 mx-auto text-emerald-400"></i>
      <div>
        <span class="text-gray-300">Click / drop</span>
        <span class="text-gray-500 text-xs block">max 2MB</span>
      </div>
    </div>

    <div id="image-preview" class="hidden">
      <div class="relative inline-block">
        <img id="preview-img" class="max-h-28 rounded object-contain border border-gray-700">
        <button type="button" onclick="removeImage()" class="absolute -top-2 -right-2 bg-red-600 text-white rounded-full p-1">
          <i data-lucide="x" class="w-3 h-3"></i>
        </button>
      </div>
    </div>
  </div>
</div>

          <button type="submit" id="submit-btn"
            class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-bold py-4 px-6 rounded-xl transition shadow-lg">
            Confirm Payment
          </button>

        </form>

      </div>

    </main>

    <!-- Bottom Navigation -->
    @include('user.includes.bottom_navigation')

  </div>

  <script>
    lucide.createIcons();

    function selectExternalMethod(method, element) {
      // Reset & highlight
      document.querySelectorAll('.method-card').forEach(el => el.classList.remove('active'));
      element.classList.add('active');

      const panel = document.getElementById('method-details');
      panel.classList.remove('hidden');

      // Fill data
      document.getElementById('method-title').textContent = method.account_type.toUpperCase();
      document.getElementById('account-title').textContent = method.account_title || '-';
      document.getElementById('account-number').textContent = method.account_number || '-';
      document.getElementById('method-instructions').textContent = method.details || 'No instructions provided.';
      document.getElementById('selected_method_id').value = method.id;
      document.getElementById('is_internal').value = "0";

      // IBAN
      if (method.iban) {
        document.getElementById('iban-wrapper').classList.remove('hidden');
        document.getElementById('iban-number').textContent = method.iban;
      } else {
        document.getElementById('iban-wrapper').classList.add('hidden');
      }

      // Receipt sample
      if (method.receipt_sample) {
        document.getElementById('sample-wrapper').classList.remove('hidden');
        document.getElementById('receipt-sample-img').src = '/' + method.receipt_sample;
      } else {
        document.getElementById('sample-wrapper').classList.add('hidden');
      }

      // Show required fields for external methods
      document.getElementById('transaction-wrapper').classList.remove('hidden');
      document.getElementById('upload-wrapper').classList.remove('hidden');

      // NEW: Add required attributes back
      document.getElementById('transaction_id').setAttribute('required', 'required');
      document.getElementById('receipt_image').setAttribute('required', 'required');

      document.getElementById('submit-btn').textContent = "Confirm Payment";

      panel.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function selectInternalFunds(element) {
      // Reset & highlight
      document.querySelectorAll('.method-card').forEach(el => el.classList.remove('active'));
      element.classList.add('active');

      const panel = document.getElementById('method-details');
      panel.classList.remove('hidden');

      // Fill internal funds info
      document.getElementById('method-title').textContent = "INTERNAL FUNDS";
      document.getElementById('account-title').textContent = "Your Wallet";
      document.getElementById('account-number').textContent = "{{ number_format(auth()->user()->balance ?? 0) }} Rs";
      document.getElementById('method-instructions').innerHTML = 
        `You are about to pay <strong>{{ number_format($plan->investment_amount ?? 445) }} Rs</strong> using your internal wallet balance.<br><br>` +
        `Please make sure your balance is sufficient. No screenshot or transaction ID is required.`;

      // Hide unnecessary fields
      document.getElementById('iban-wrapper').classList.add('hidden');
      document.getElementById('sample-wrapper').classList.add('hidden');
      document.getElementById('transaction-wrapper').classList.add('hidden');
      document.getElementById('upload-wrapper').classList.add('hidden');

      // NEW: Remove required attributes (they are hidden, but for safety)
      document.getElementById('transaction_id').removeAttribute('required');
      document.getElementById('receipt_image').removeAttribute('required');

      // Mark as internal
      document.getElementById('selected_method_id').value = "internal";
      document.getElementById('is_internal').value = "1";

      // Change button
      document.getElementById('submit-btn').textContent = "Pay with Wallet Balance";

      panel.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    // ── Image upload preview logic ──
    const input = document.getElementById('receipt_image');
    const preview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    const uploadContent = document.getElementById('upload-content');
    const uploadBox = document.getElementById('upload-box');

    input.addEventListener('change', function () {
      if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
          previewImg.src = e.target.result;
          preview.classList.remove('hidden');
          uploadContent.classList.add('hidden');
        }
        reader.readAsDataURL(this.files[0]);
      }
    });

    function removeImage() {
      input.value = "";
      preview.classList.add('hidden');
      uploadContent.classList.remove('hidden');
    }

    uploadBox.addEventListener('dragover', (e) => {
      e.preventDefault();
      uploadBox.classList.add('border-emerald-500', 'bg-emerald-500/10');
    });

    uploadBox.addEventListener('dragleave', () => {
      uploadBox.classList.remove('border-emerald-500', 'bg-emerald-500/10');
    });

    uploadBox.addEventListener('drop', (e) => {
      e.preventDefault();
      uploadBox.classList.remove('border-emerald-500', 'bg-emerald-500/10');
      if (e.dataTransfer.files && e.dataTransfer.files[0]) {
        input.files = e.dataTransfer.files;
        input.dispatchEvent(new Event('change'));
      }
    });

    // NEW: Global click handler for all method cards
    document.addEventListener('DOMContentLoaded', function () {
      document.querySelectorAll('.method-card').forEach(card => {
        card.addEventListener('click', function () {
          if (this.dataset.isInternal === 'true') {
            selectInternalFunds(this);
          } else {
            // external method
            const method = JSON.parse(this.dataset.method);
            selectExternalMethod(method, this);
          }
        });
      });
    });


    // Copy to clipboard functionality
document.addEventListener('click', function(e) {
  if (!e.target.closest('.copy-btn')) return;

  const btn = e.target.closest('.copy-btn');
  const targetId = btn.dataset.clipboardTarget;
  const textElement = document.getElementById(targetId);

  if (!textElement) return;

  const text = textElement.textContent.trim();

  if (!text || text === '-') return;

  navigator.clipboard.writeText(text)
    .then(() => {
      // Visual feedback
      btn.classList.add('copied');
      btn.querySelector('i').setAttribute('data-lucide', 'check');
      lucide.createIcons(); // re-render icon to check

      // Reset after 2 seconds
      setTimeout(() => {
        btn.classList.remove('copied');
        btn.querySelector('i').setAttribute('data-lucide', 'copy');
        lucide.createIcons();
      }, 2000);
    })
    .catch(err => {
      console.error('Failed to copy:', err);
      // Optional: fallback alert
      // alert('Failed to copy – please select and copy manually');
    });
});

  </script>

</body>
</html>