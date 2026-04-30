<!DOCTYPE html>
<html lang="en">
<head>
    @include('expert.includes.general_style')
    <title>My Earnings | Expert Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="min-h-screen bg-[#121826]">

<div class="mx-auto max-w-[420px] min-h-screen bg-[#121826] shadow-2xl shadow-black/50 relative">

    @include('expert.includes.top_greetings')

    <div class="px-4 pt-4 pb-20">
        <h1 class="text-xl font-bold text-white mb-4">My Earnings</h1>

        <!-- Summary Cards -->
        <div class="grid grid-cols-2 gap-3 mb-5">
            <div class="bg-[#1A2636] rounded-xl p-3 border border-[#2A3A5A]">
                <p class="text-xs text-gray-400">Total Earnings</p>
                <p class="text-2xl font-bold text-[#F4A261]">Rs. {{ number_format($totalEarnings) }}</p>
            </div>
            <div class="bg-[#1A2636] rounded-xl p-3 border border-[#2A3A5A]">
                <p class="text-xs text-gray-400">Pending Payout</p>
                <p class="text-2xl font-bold text-[#F4A261]">Rs. {{ number_format($pendingPayout) }}</p>
            </div>
            <div class="bg-[#1A2636] rounded-xl p-3 border border-[#2A3A5A]">
                <p class="text-xs text-gray-400">This Month</p>
                <p class="text-lg font-bold text-white">Rs. {{ number_format($thisMonthEarnings) }}</p>
            </div>
            <div class="bg-[#1A2636] rounded-xl p-3 border border-[#2A3A5A]">
                <p class="text-xs text-gray-400">Last Month</p>
                <p class="text-lg font-bold text-white">Rs. {{ number_format($lastMonthEarnings) }}</p>
            </div>
        </div>

        <!-- Weekly Chart (simple bar representation) -->
        <div class="bg-[#1A2636] rounded-xl p-3 border border-[#2A3A5A] mb-5">
            <h3 class="text-sm font-semibold text-gray-200 mb-2">Last 7 Days</h3>
            <div class="flex items-end gap-1 h-32">
                @foreach($weeklyData as $day)
                <div class="flex-1 flex flex-col items-center">
                    <div class="w-full bg-[#F4A261]/30 rounded-t" style="height: {{ ($day / max($weeklyData)) * 100 }}px"></div>
                    <span class="text-[10px] text-gray-400 mt-1">Rs. {{ $day }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Withdrawals & Transactions -->
        <div class="space-y-4">
            <div>
                <h3 class="text-sm font-semibold text-gray-200 mb-2">Recent Withdrawals</h3>
                @forelse($withdrawals as $wd)
                <div class="bg-[#1A2636] rounded-xl p-3 border border-[#2A3A5A] mb-2 flex justify-between items-center">
                    <div>
                        <p class="text-sm text-white">{{ $wd->date }}</p>
                        <p class="text-xs text-gray-400">Rs. {{ number_format($wd->amount) }}</p>
                    </div>
                    <span class="text-xs px-2 py-1 rounded-full {{ $wd->status == 'completed' ? 'bg-green-900/40 text-green-400' : 'bg-[#F4A261]/20 text-[#F4A261]' }}">
                        {{ ucfirst($wd->status) }}
                    </span>
                </div>
                @empty
                <p class="text-gray-400 text-sm">No withdrawals yet.</p>
                @endforelse
            </div>

            <div>
                <h3 class="text-sm font-semibold text-gray-200 mb-2">Transaction History</h3>
                @forelse($transactions as $txn)
                <div class="bg-[#1A2636] rounded-xl p-3 border border-[#2A3A5A] mb-2 flex justify-between">
                    <div>
                        <p class="text-sm text-white">{{ $txn->description }}</p>
                        <p class="text-xs text-gray-400">{{ $txn->date }}</p>
                    </div>
                    <p class="text-sm font-semibold {{ $txn->type == 'credit' ? 'text-green-400' : 'text-red-400' }}">
                        {{ $txn->type == 'credit' ? '+' : '-' }} Rs. {{ number_format($txn->amount) }}
                    </p>
                </div>
                @empty
                <p class="text-gray-400 text-sm">No transactions.</p>
                @endforelse
            </div>
        </div>
    </div>

    @include('expert.includes.bottom_navigation')
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof lucide !== 'undefined') lucide.createIcons();
    });
</script>
</body>
</html>