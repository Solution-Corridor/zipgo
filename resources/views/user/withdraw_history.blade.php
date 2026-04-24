<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  @include('user.includes.general_style')
  <title>Withdraw History</title>
</head>

<body class="min-h-screen bg-[#0A0A0F]">

  <!-- Mobile-like container -->
  <div class="mx-auto max-w-[420px] min-h-screen bg-[#0A0A0F] shadow-2xl shadow-black/50 relative">

    <!-- Top Greeting -->
    @include('user.includes.top_greetings')

    <style>
      .glass {
        background: rgba(30, 30, 50, 0.55);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(100, 100, 255, 0.12);
      }

      .status-pending {
        background: rgba(234, 179, 8, 0.15);
        color: #fbbf24;
      }

      .status-approved {
        background: rgba(34, 197, 94, 0.15);
        color: #22c55e;
      }

      .status-rejected {
        background: rgba(239, 68, 68, 0.15);
        color: #ef4444;
      }

      .status-returned {
        background: rgba(239, 68, 68, 0.15);
        color: #fbbf24;
      }

      .status-cancelled,
      .status-failed {
        background: rgba(107, 114, 128, 0.15);
        color: #9ca3af;
      }

      .history-card {
        border-radius: 16px;
        padding: 16px;
        margin-bottom: 12px;
      }

      .amount {
        font-size: 1.25rem;
        font-weight: 700;
      }
    </style>

    <!-- Main Content -->
    <div class="px-4 py-5">

      <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-white">Withdraw History</h1>        
      </div>

      @if ($withdrawals->isEmpty())
      <div class="glass rounded-2xl p-8 text-center">
        <div class="text-gray-400 mb-3">
          <i data-lucide="history" class="w-12 h-12 mx-auto opacity-50"></i>
        </div>
        <p class="text-gray-300 mb-2">No withdrawal requests yet</p>
        <p class="text-sm text-gray-500">Your withdrawal history will appear here</p>
      </div>
      @else
      <div class="space-y-3">
        @foreach ($withdrawals as $wd)
        <div class="glass history-card">
          <div class="flex justify-between items-start mb-3">
            <div>
              <div class="text-sm text-gray-400">
                {{ $wd->created_at->format('d M Y • h:i A') }}
              </div>
              <div class="font-medium mt-0.5">
                {{ ucfirst(str_replace('_', ' ', $wd->method)) }}

                @if ($wd->status === 'pending')
            <form action="{{ route('withdraw.cancel', $wd->id) }}" method="POST" class="inline"
                  onsubmit="return confirm('Cancel this pending withdrawal?');">
                @csrf
                <button type="submit" class="px-2.5 py-1 bg-red-600/70 hover:bg-red-700 text-white text-xs rounded-md transition ml-4">
                    Cancel
                </button>
            </form>
        @endif

              </div>
              
            </div>
            <div class="text-right">
              <div class="amount text-white">
                Rs {{ number_format($wd->amount, 0) }}
              </div>
              <span class="inline-block px-3 py-1 mt-1.5 text-xs font-medium rounded-full uppercase status-{{ $wd->status }}">
                {{ ucfirst($wd->status) }}
              </span>
              @if ($wd->status === 'approved')
              <div class="text-xs text-gray-400 mt-1">
                {{ $wd->approved_at->format('d M Y • h:i A') }}
              </div>
              @endif

              @if ($wd->status === 'rejected')
              <div class="text-xs text-gray-400 mt-1">
                {{ $wd->rejected_at->format('d M Y • h:i A') }}
              </div>
              @endif

              @if ($wd->status === 'cancelled')
              <div class="text-xs text-gray-400 mt-1">
                {{ $wd->cancelled_at->format('d M Y • h:i A') }}
              </div>
              @endif

              @if ($wd->status === 'returned')
              <div class="text-xs text-gray-400 mt-1">
                {{ $wd->updated_at->format('d M Y • h:i A') }}
              </div>
              @endif

              
            </div>
          </div>

          <div class="grid grid-cols-2 gap-2 text-sm border-t border-gray-800/50 pt-3 mt-2">
            <div class="text-gray-400">To Account:</div>
            <div class="text-right text-gray-200 font-medium">
              {{ $wd->account_title }}<br>
              <span class="text-xs text-gray-500">{{ $wd->account_number }}</span>
            </div>
          </div>

          @if ($wd->remarks)
          <div class="mt-3 p-4 rounded-lg border border-orange-500/40 bg-orange-500/10 text-orange-400 text-sm">
            <span class="font-semibold text-orange-300">⚠ Remarks:</span>
            <div class="mt-1">
              {{ $wd->remarks }}
            </div>
          </div>
          @endif
        </div>
        @endforeach
      </div>

      <!-- Simple pagination (optional) -->
      @if ($withdrawals->hasPages())
      <div class="mt-6 flex justify-center">
        {{ $withdrawals->links('pagination::tailwind') }}
      </div>
      @endif
      @endif

      <!-- Bottom padding for nav -->
      <div class="h-20"></div>
    </div>

    <!-- Bottom Navigation -->
    @include('user.includes.bottom_navigation')

  </div>

  <script>
    lucide.createIcons();
  </script>

</body>

</html>