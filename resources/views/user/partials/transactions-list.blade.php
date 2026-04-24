@foreach ($transactions as $transaction)
    @php
        $isDeduction = $transaction->amount < 0 ||
                       in_array($transaction->trx_type, ['balance_transfer_sent', 'plan_upgrade_deduction', 'service_fee', 'withdraw', 'plan_upgrade_partial_deduction', 'spin_bet', 'burst_bet', 'profit_balls_bet', 'place_order']);

        $badgeClass  = $isDeduction
            ? 'bg-red-500/20 text-red-400 border border-red-500/30'
            : 'bg-green-500/20 text-green-400 border border-green-500/30';

        $amountClass = $isDeduction ? 'text-red-400' : 'text-green-400';
        $sign = $isDeduction ? '-' : '+';
    @endphp

    <div class="bg-gray-900/70 backdrop-blur-sm rounded-xl p-4 border border-gray-800/50 transaction-item">
        <div class="flex justify-between items-start mb-2">
            <div>
                <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium {{ $badgeClass }}">
                    {{ ucfirst(str_replace('_', ' ', $transaction->trx_type)) }}
                </span>
            </div>
            <div class="text-right">
                <p class="text-lg font-semibold {{ $amountClass }}">
                    {{ $sign }} Rs {{ number_format(abs($transaction->amount), 0) }}
                </p>
                <p class="text-xs text-gray-500 mt-1">
                    {{ $transaction->created_at->format('d M Y • h:i A') }}
                </p>
            </div>
        </div>

        <p class="text-sm text-gray-300 mt-1 line-clamp-2">
            {{ $transaction->detail ?? 'No description' }}
        </p>
    </div>
@endforeach