<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    @include('expert.includes.general_style')
    <title>Complete Payment | ProHub</title>
    <style>
        * {
            -webkit-tap-highlight-color: transparent;
        }
        body {
            background: #0A0A0F;
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, sans-serif;
        }
        .gradient-primary {
            background: linear-gradient(105deg, #8b5cf6 0%, #6366f1 100%);
        }
        .glow {
            box-shadow: 0 8px 20px -6px rgba(0, 0, 0, 0.6), 0 0 0 1px rgba(139, 92, 246, 0.1);
        }
        .card-hover {
            transition: transform 0.1s ease, border-color 0.2s;
        }
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>
<body class="min-h-screen bg-[#0A0A0F] antialiased">
    <div class="mx-auto max-w-[420px] min-h-screen bg-[#0A0A0F] shadow-2xl shadow-black/50 relative">
        @include('expert.includes.top_greetings')

        <div class="px-4 pt-4 pb-28">
            @include('includes.success')

            <div class="mt-2 mb-6">
                <div class="flex items-center gap-2 mb-3 px-1">
                    <i data-lucide="credit-card" class="w-5 h-5 text-indigo-400"></i>
                    <h3 class="text-indigo-200 font-semibold text-sm tracking-wide">PAYMENT VERIFICATION</h3>
                    <div class="flex-1 h-px bg-gradient-to-r from-indigo-500/40 to-transparent"></div>
                </div>

                <div class="rounded-xl overflow-hidden glow bg-gray-900/70 border border-gray-700/50 p-5">
                    <div class="text-center mb-6">
                        <h2 class="text-xl font-bold text-slate-100">Expert Registration Fee</h2>
                        <p class="text-slate-400 text-sm mt-1">Complete payment to activate your expert profile</p>
                    </div>

                    <div class="mb-6 text-center bg-slate-800/40 rounded-xl p-4 border border-white/5">
                        <p class="text-slate-400 text-sm">Amount to pay</p>
                        <p class="text-3xl font-bold text-indigo-400">
                            Rs. {{ number_format(session('amount', 0), 0) }}
                        </p>
                    </div>

                    
                    <form action="{{ route('expert.payment.process') }}" method="POST" id="paymentForm">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs text-slate-400 mb-1">Card Number *</label>
                                <input type="text" name="card_number" id="card_number" maxlength="19"
                                    class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2.5 text-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                    placeholder="1234 5678 9012 3456" required>
                            </div>
                            <div class="grid grid-cols-3 gap-3">
                                <div>
                                    <label class="block text-xs text-slate-400 mb-1">MM *</label>
                                    <input type="text" name="expiry_month" id="expiry_month" maxlength="2"
                                        class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2.5 text-slate-200 focus:ring-2 focus:ring-indigo-500"
                                        placeholder="01" required>
                                </div>
                                <div>
                                    <label class="block text-xs text-slate-400 mb-1">YY *</label>
                                    <input type="text" name="expiry_year" id="expiry_year" maxlength="2"
                                        class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2.5 text-slate-200 focus:ring-2 focus:ring-indigo-500"
                                        placeholder="25" required>
                                </div>
                                <div>
                                    <label class="block text-xs text-slate-400 mb-1">CVC *</label>
                                    <input type="text" name="cvc" id="cvc" maxlength="3"
                                        class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2.5 text-slate-200 focus:ring-2 focus:ring-indigo-500"
                                        placeholder="123" required>
                                </div>
                            </div>
                        </div>

                        <div id="errorMessage" class="hidden mt-4 p-3 bg-rose-900/40 border border-rose-700/50 rounded-lg text-rose-200 text-sm"></div>

                        <button type="submit" id="payButton"
                            class="mt-6 w-full py-3.5 rounded-xl font-semibold text-white bg-indigo-700 hover:bg-indigo-600 shadow-lg active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                            <i data-lucide="lock" class="w-4 h-4"></i> Pay Rs. {{ number_format(session('amount', 0), 0) }}
                        </button>
                    </form>

                    <div class="mt-4 text-center">
                        <a href="{{ route('expert_profile') }}" class="text-sm text-slate-400 hover:text-slate-300 transition inline-flex items-center gap-1">
                            <i data-lucide="arrow-left" class="w-3 h-3"></i> Back to edit profile
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @include('expert.includes.bottom_navigation')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Format card number with spaces every 4 digits
            const cardInput = document.getElementById('card_number');
            if (cardInput) {
                cardInput.addEventListener('input', function(e) {
                    let value = this.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
                    let formatted = '';
                    for (let i = 0; i < value.length; i++) {
                        if (i > 0 && i % 4 === 0) formatted += ' ';
                        formatted += value[i];
                    }
                    this.value = formatted;
                });
            }

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
                if (errorDiv) {
                    errorDiv.innerText = msg;
                    errorDiv.classList.remove('hidden');
                    setTimeout(() => {
                        errorDiv.classList.add('hidden');
                    }, 4000);
                } else {
                    alert(msg);
                }
            }

            // Form submission validation (client side)
            const paymentForm = document.getElementById('paymentForm');
            if (paymentForm) {
                paymentForm.addEventListener('submit', function(e) {
                    const errorDiv = document.getElementById('errorMessage');
                    if (errorDiv) errorDiv.classList.add('hidden');

                    let cardNumberRaw = document.getElementById('card_number').value;
                    let month = document.getElementById('expiry_month').value;
                    let year = document.getElementById('expiry_year').value;
                    let cvc = document.getElementById('cvc').value;

                    // Validate card number (Luhn)
                    if (!luhnCheck(cardNumberRaw)) {
                        showError('Invalid card number.');
                        e.preventDefault();
                        return;
                    }
                    // Validate month
                    if (!/^\d{2}$/.test(month) || parseInt(month) < 1 || parseInt(month) > 12) {
                        showError('Invalid expiry month (01-12).');
                        e.preventDefault();
                        return;
                    }
                    // Validate year (two digits)
                    if (!/^\d{2}$/.test(year)) {
                        showError('Invalid expiry year (two digits).');
                        e.preventDefault();
                        return;
                    }
                    // Validate CVC
                    if (!/^\d{3}$/.test(cvc)) {
                        showError('CVC must be 3 digits.');
                        e.preventDefault();
                        return;
                    }

                    // Check expiry date (not in past)
                    const currentYear = new Date().getFullYear() % 100;
                    const currentMonth = new Date().getMonth() + 1;
                    let expYear = parseInt(year);
                    let expMonth = parseInt(month);
                    if (expYear < currentYear || (expYear === currentYear && expMonth < currentMonth)) {
                        showError('Card has expired.');
                        e.preventDefault();
                        return;
                    }

                    // Allow server-side processing
                });
            }

            // Init Lucide icons
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>
</body>
</html>