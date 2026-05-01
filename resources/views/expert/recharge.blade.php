<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    @include('expert.includes.general_style')
    <title>Recharge Balance | ProHub Expert</title>
    <style>
        .recharge-input {
            background-color: #121826;
            border-color: #2A3A5A;
            color: #ffffff;
        }
        .recharge-input:focus {
            border-color: #F4A261;
            outline: none;
            ring: 2px solid #F4A261;
        }
        .recharge-input::placeholder {
            color: #9CA3AF;
        }
    </style>
</head>
<body class="min-h-screen bg-[#121826] antialiased">
    <div class="mx-auto max-w-[420px] min-h-screen bg-[#121826] shadow-2xl shadow-black/50 relative">
        @include('expert.includes.top_greetings')

        <div class="px-4 pt-4 pb-28">
            <div class="bg-[#1A2636] rounded-xl border border-[#2A3A5A] shadow-lg p-6">
                <h2 class="text-xl font-bold text-white mb-2">Recharge Balance</h2>
                <p class="text-sm text-gray-400 mb-6">Select a payment method and enter amount.</p>

                <form method="POST" action="{{ route('user.recharge.process') }}" id="rechargeForm">
                    @csrf

                    <div class="mb-5">
                        <label class="block text-xs font-medium text-gray-300 mb-1">Amount (Rs.) *</label>
                        <input type="number" name="amount" id="amount" step="10" min="50" max="50000" required
                               class="w-full recharge-input border rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:ring-2 focus:ring-[#F4A261] focus:border-transparent">
                        @error('amount') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-5">
                        <label class="block text-xs font-medium text-gray-300 mb-1">Payment Method *</label>
                        <select name="method" id="paymentMethod" class="w-full recharge-input border rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-[#F4A261]" required>
                            <option value="">-- Select --</option>
                            <option value="easypaisa">Easypaisa</option>
                            <option value="jazzcash">JazzCash</option>
                            <option value="bank_card">Bank Card (Credit/Debit)</option>
                        </select>
                    </div>

                    <div id="dynamicFields" class="space-y-4 mb-5"></div>

                    <button type="submit" class="w-full py-3 rounded-xl font-semibold text-white bg-gradient-to-r from-[#F4A261] to-[#E08E3E] hover:from-[#E08E3E] hover:to-[#D97706] shadow-md transition active:scale-[0.98]">
                        Proceed to Pay
                    </button>
                </form>
            </div>
        </div>

        @include('expert.includes.bottom_navigation')
    </div>

    <script>
        function formatCardNumber(input) {
            let value = input.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
            let formatted = '';
            for (let i = 0; i < value.length; i++) {
                if (i > 0 && i % 4 === 0) formatted += ' ';
                formatted += value[i];
            }
            input.value = formatted;
        }

        const templates = {
            easypaisa: `
                <div>
                    <label class="block text-xs font-medium text-gray-300 mb-1">Easypaisa Mobile Number *</label>
                    <input type="tel" name="mobile_number" pattern="[0-9]{10}" maxlength="10" placeholder="03XXXXXXXXX" 
                           class="w-full recharge-input border rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:ring-2 focus:ring-[#F4A261]">
                    <p class="text-xs text-gray-500 mt-1">Enter the mobile number linked to Easypaisa.</p>
                </div>
            `,
            jazzcash: `
                <div>
                    <label class="block text-xs font-medium text-gray-300 mb-1">JazzCash Mobile Number *</label>
                    <input type="tel" name="mobile_number" pattern="[0-9]{10}" maxlength="10" placeholder="03XXXXXXXXX" 
                           class="w-full recharge-input border rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:ring-2 focus:ring-[#F4A261]">
                    <p class="text-xs text-gray-500 mt-1">Enter the mobile number registered with JazzCash.</p>
                </div>
            `,
            bank_card: `
                <div>
                    <label class="block text-xs font-medium text-gray-300 mb-1">Card Number *</label>
                    <input type="text" name="card_number" id="card_number" maxlength="19" placeholder="1234 5678 9012 3456" 
                           class="w-full recharge-input border rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:ring-2 focus:ring-[#F4A261]">
                </div>
                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-300 mb-1">MM *</label>
                        <input type="text" name="expiry_month" maxlength="2" placeholder="01" 
                               class="w-full recharge-input border rounded-lg px-4 py-3 text-center text-white placeholder-gray-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-300 mb-1">YY *</label>
                        <input type="text" name="expiry_year" maxlength="2" placeholder="25" 
                               class="w-full recharge-input border rounded-lg px-4 py-3 text-center text-white placeholder-gray-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-300 mb-1">CVV *</label>
                        <input type="text" name="cvv" maxlength="3" placeholder="123" 
                               class="w-full recharge-input border rounded-lg px-4 py-3 text-center text-white placeholder-gray-500">
                    </div>
                </div>
            `
        };

        function initLucide() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            } else {
                setTimeout(initLucide, 100);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const methodSelect = document.getElementById('paymentMethod');
            const dynamicContainer = document.getElementById('dynamicFields');

            function updateFields() {
                const selected = methodSelect.value;
                dynamicContainer.innerHTML = '';
                if (selected && templates[selected]) {
                    dynamicContainer.innerHTML = templates[selected];
                    if (selected === 'bank_card') {
                        const cardInput = document.getElementById('card_number');
                        if (cardInput) {
                            cardInput.addEventListener('input', function() { formatCardNumber(this); });
                        }
                    }
                }
            }

            methodSelect.addEventListener('change', updateFields);
            updateFields();

            // Initialize Lucide icons for the bottom navigation
            initLucide();
        });
    </script>
</body>
</html>