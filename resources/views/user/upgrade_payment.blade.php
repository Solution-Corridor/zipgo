<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  @include('user.includes.general_style')
  <title>Upgrade Payment</title>
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
      color: #9ca3af;
      background: rgba(100, 100, 255, 0.08);
      border: 1px solid rgba(100, 100, 255, 0.15);
      border-radius: 6px;
      cursor: pointer;
      transition: all 0.2s ease;
      vertical-align: middle;
    }

    .copy-btn:hover {
      color: #d1d5db;
      background: rgba(100, 100, 255, 0.15);
      border-color: rgba(100, 100, 255, 0.3);
    }

    .copy-btn.copied {
      color: #22c55e;
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

    /* New styles for remaining amount */
    .amount-box {
      background: rgba(34, 197, 94, 0.1);
      border: 1px solid rgba(34, 197, 94, 0.4);
      border-radius: 12px;
      padding: 16px;
      margin-bottom: 20px;
      text-align: center;
    }
    .amount-box.insufficient {
      background: rgba(239, 68, 68, 0.12);
      border-color: rgba(239, 68, 68, 0.5);
    }
    .amount-needed {
      font-size: 1.5rem;
      font-weight: 700;
      color: #fbbf24;
    }
    .sufficient-msg {
      font-size: 1.1rem;
      color: #22c55e;
      font-weight: 600;
    }
  </style>
</head>

<body class="min-h-screen bg-[#0A0A0F] text-white font-sans">

  <div class="mx-auto max-w-[420px] min-h-screen bg-[#0A0A0F] shadow-2xl shadow-black/60 relative">

    <!-- Top bar / header -->
    @include('user.includes.top_greetings')

    <main class="px-5 pt-6 pb-32">

      <h1 class="text-xl font-semibold text-center mb-3 bg-gradient-to-r from-cyan-400 to-blue-600 bg-clip-text text-transparent">
        Current Balance: {{ number_format(auth()->user()->balance ?? 0) }} Rs
      </h1>

      @include('includes.success')

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

      <!-- === NEW: Prominent Remaining Amount Box === -->
      <?php
        $planAmount   = $plan->investment_amount ?? 445;
        $userBalance  = auth()->user()->balance ?? 0;
        $remaining    = max(0, $planAmount - $userBalance);
        $isSufficient = $remaining <= 0;
      ?>

      <div class="amount-box {{ $isSufficient ? '' : 'insufficient' }}">
        @if($isSufficient)
          <p class="sufficient-msg">Your balance is sufficient!</p>
          <p class="text-gray-300 mt-2">No payment or screenshot needed.<br>Click below to upgrade your plan.</p>
        @else
          <p class="text-gray-300">You need to pay:</p>
          <p class="amount-needed">{{ number_format($remaining) }} Rs</p>
          <p class="text-sm text-gray-400 mt-1">
            (Plan: {{ number_format($planAmount) }} – Balance: {{ number_format($userBalance) }})
          </p>
        @endif
      </div>

      <!-- Payment Methods (only shown if payment is needed) -->
      @if(!$isSufficient)
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

        </div>
      </div>
      @endif

      <!-- Details / Confirmation area -->
      <div id="method-details" class="glass rounded-2xl p-6 mt-8 
     {{ $isSufficient ? '' : 'hidden' }}">

        @if($isSufficient)
          <!-- Sufficient balance → simple upgrade form -->
          <h3 class="text-xl font-bold mb-6 text-cyan-300 text-center">Upgrade Plan</h3>
          <form action="{{ route('user.upgrade.confirm') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="plan_id" value="{{ $plan->id }}">

            <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-bold py-4 px-6 rounded-xl transition shadow-lg">
              Upgrade Now
            </button>
          </form>
        @else
          <!-- Normal payment flow -->
          <h3 id="method-title" class="text-xl font-bold mb-6 text-cyan-300 text-center"></h3>

          <div class="space-y-3 mb-6 text-sm">
            <div>
              <span class="text-gray-400">Account Title:</span>
              <div id="account-title" class="font-semibold text-white"></div>
            </div>

            <div class="flex items-center">
              <div>
                <span class="text-gray-400">Account / Balance:</span>
                <div id="account-number" class="font-semibold text-white inline"></div>
              </div>
              <button type="button" class="copy-btn" data-clipboard-target="account-number" title="Copy account number">
                <i data-lucide="copy" class="w-4 h-4"></i>
              </button>
            </div>

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

          <div id="sample-wrapper" class="hidden mb-6">
            <p class="text-gray-400 mb-2 text-sm">Receipt Sample:</p>
            <img id="receipt-sample-img" 
                 class="rounded-lg border border-gray-700 max-h-60 object-contain mx-auto">
          </div>

          <form action="{{ route('user.upgrade.confirm') }}" 
                method="POST" 
                enctype="multipart/form-data"
                class="space-y-4">

            @csrf

            <input type="hidden" name="plan_id" value="{{ $plan->id }}">
            <input type="hidden" name="payment_method_id" id="selected_method_id">

            <div id="transaction-wrapper">
              <label class="text-sm text-gray-400">Transaction ID</label>
              <input type="text" name="transaction_id" id="transaction_id"
                     required
                     placeholder="Enter your transaction ID"
                     class="w-full mt-1 px-4 py-3 rounded-xl bg-black/40 border border-gray-700 focus:border-emerald-500 outline-none">
            </div>

            <div id="upload-wrapper">
              <label class="text-sm text-gray-400 block mb-2">
                Upload Payment Screenshot
              </label>

              <div id="upload-box"
                   class="relative border-2 border-dashed border-gray-600 rounded-2xl p-6 text-center cursor-pointer
                          bg-black/30 hover:border-emerald-500 hover:bg-emerald-500/5 transition-all duration-300">

                  <input type="file"
                         name="receipt_image"
                         id="receipt_image"
                         accept="image/*"
                         required
                         class="absolute inset-0 opacity-0 cursor-pointer">

                  <div id="upload-content" class="space-y-3">
                      <div class="flex justify-center">
                          <i data-lucide="upload-cloud" class="w-10 h-10 text-emerald-400"></i>
                      </div>

                      <p class="text-sm text-gray-300 font-medium">
                          Click to upload or drag & drop
                      </p>

                      <p class="text-xs text-gray-500">
                          PNG, JPG (Max 2MB)
                      </p>
                  </div>

                  <div id="image-preview" class="hidden relative">
                      <img id="preview-img"
                           class="mx-auto rounded-xl max-h-56 object-contain shadow-lg border border-gray-700">

                      <button type="button"
                              onclick="removeImage()"
                              class="absolute -top-3 -right-3 bg-red-600 hover:bg-red-500 text-white p-2 rounded-full shadow-lg transition">
                          <i data-lucide="x" class="w-4 h-4"></i>
                      </button>
                  </div>
              </div>
            </div>

            <button type="submit" id="submit-btn"
              class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-bold py-4 px-6 rounded-xl transition shadow-lg">
              Confirm Payment
            </button>

          </form>
        @endif

      </div>

    </main>

    <!-- Bottom Navigation -->
    @include('user.includes.bottom_navigation')

  </div>

  <script>
    lucide.createIcons();

    function selectExternalMethod(method, element) {
      document.querySelectorAll('.method-card').forEach(el => el.classList.remove('active'));
      element.classList.add('active');

      const panel = document.getElementById('method-details');
      panel.classList.remove('hidden');

      document.getElementById('method-title').textContent = method.account_type.toUpperCase();
      document.getElementById('account-title').textContent = method.account_title || '-';
      document.getElementById('account-number').textContent = method.account_number || '-';
      document.getElementById('method-instructions').textContent = method.details || 'No instructions provided.';
      document.getElementById('selected_method_id').value = method.id;

      if (method.iban) {
        document.getElementById('iban-wrapper').classList.remove('hidden');
        document.getElementById('iban-number').textContent = method.iban;
      } else {
        document.getElementById('iban-wrapper').classList.add('hidden');
      }

      if (method.receipt_sample) {
        document.getElementById('sample-wrapper').classList.remove('hidden');
        document.getElementById('receipt-sample-img').src = '/' + method.receipt_sample;
      } else {
        document.getElementById('sample-wrapper').classList.add('hidden');
      }

      document.getElementById('transaction-wrapper').classList.remove('hidden');
      document.getElementById('upload-wrapper').classList.remove('hidden');
      document.getElementById('transaction_id').setAttribute('required', 'required');
      document.getElementById('receipt_image').setAttribute('required', 'required');

      document.getElementById('submit-btn').textContent = "Confirm Payment";

      panel.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    // Image preview logic
    const input = document.getElementById('receipt_image');
    const preview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    const uploadContent = document.getElementById('upload-content');
    const uploadBox = document.getElementById('upload-box');

    if (input) {  // only if payment section exists
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
    }

    // Card click handler
    document.addEventListener('DOMContentLoaded', function () {
      document.querySelectorAll('.method-card').forEach(card => {
        card.addEventListener('click', function () {
          const method = JSON.parse(this.dataset.method);
          selectExternalMethod(method, this);
        });
      });
    });

    // Copy to clipboard
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
          btn.classList.add('copied');
          btn.querySelector('i').setAttribute('data-lucide', 'check');
          lucide.createIcons();

          setTimeout(() => {
            btn.classList.remove('copied');
            btn.querySelector('i').setAttribute('data-lucide', 'copy');
            lucide.createIcons();
          }, 2000);
        })
        .catch(err => console.error('Failed to copy:', err));
    });
  </script>

</body>
</html>