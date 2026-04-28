@if (1 == 3)
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  @include('user.includes.general_style')
  <title>User Dashboard</title>
</head>

<body class="min-h-screen bg-[#0A0A0F]">

  <!-- Mobile-like container -->
  <div class="mx-auto max-w-[420px] min-h-screen bg-[#0A0A0F] shadow-2xl shadow-black/50 relative">

    <!-- Top Greeting -->
    @include('user.includes.top_greetings')

    <style>
      .balance-green {
        background: linear-gradient(90deg, #10b981, #22c55e);
        box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.4), 0 4px 10px -2px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease;
      }

      .balance-green:hover {
        transform: translateY(-2px);
      }

      @keyframes shine {
        0% {
          left: -100%;
        }

        100% {
          left: 150%;
        }
      }
    </style>

    <div class="px-4 mt-2 mb-3">
      @include('includes.success')
    </div>

    <!-- Premium Balance Section -->
    <div class="px-4 mt-2 mb-4">
      <div class="relative w-full rounded-2xl overflow-hidden bg-gradient-to-r from-emerald-500 to-green-600 border border-emerald-400/30 px-6 py-5 shadow-xl">
        <div class="absolute inset-0 bg-white/10 pointer-events-none"></div>
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-semibold text-white/90 tracking-wider uppercase">Earnings Balance</p>
            <div class="text-4xl font-bold text-white tracking-tighter mt-1">
              Rs. {{ number_format($user->balance ?? 0, 2) }}
            </div>
          </div>
          <div class="bg-white/20 backdrop-blur-md rounded-2xl p-3 shadow-inner border border-white/30">
            <i data-lucide="check" class="w-9 h-9 text-white stroke-[5]"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Action Buttons (2 per row) -->
    <div class="px-4 mt-1 mb-4">
      <div class="grid grid-cols-2 gap-3">
        <!-- Awards -->
        <a href="{{ route('awards') }}"
          class="flex items-center gap-3 bg-gradient-to-br from-gray-900 to-gray-800 border border-gray-700 rounded-lg px-4 py-1 shadow-md hover:shadow-lg hover:from-gray-800 hover:to-gray-700 active:scale-[0.97] transition-all">
          <div class="w-8 h-8 bg-amber-500/10 rounded-md flex items-center justify-center">
            <i data-lucide="award" class="w-4 h-4 text-amber-400"></i>
          </div>
          <span class="font-medium text-sm text-gray-100">Awards</span>
        </a>
        <!-- Info -->
        <a href="{{ route('info') }}"
          class="flex items-center gap-3 bg-gradient-to-br from-gray-900 to-gray-800 border border-gray-700 rounded-lg px-4 py-1 shadow-md hover:shadow-lg hover:from-gray-800 hover:to-gray-700 active:scale-[0.97] transition-all">
          <div class="w-8 h-8 bg-purple-500/10 rounded-md flex items-center justify-center">
            <i data-lucide="info" class="w-4 h-4 text-purple-400"></i>
          </div>
          <span class="font-medium text-sm text-gray-100">Info</span>
        </a>
        <!-- Share Balance -->
        <a href="{{ route('share.balance') }}"
          class="flex items-center gap-3 bg-gradient-to-br from-gray-900 to-gray-800 border border-gray-700 rounded-lg px-4 py-1 shadow-md hover:shadow-lg hover:from-gray-800 hover:to-gray-700 active:scale-[0.97] transition-all">
          <div class="w-8 h-8 bg-teal-500/10 rounded-md flex items-center justify-center">
            <i data-lucide="share-2" class="w-4 h-4 text-teal-400"></i>
          </div>
          <span class="font-medium text-sm text-gray-100">Share</span>
        </a>
        <!-- Crypto Hub -->
        <a href="{{ route('crypto') }}"
          class="flex items-center gap-3 bg-gradient-to-br from-gray-900 to-gray-800 border border-gray-700 rounded-lg px-4 py-1 shadow-md hover:shadow-lg hover:from-gray-800 hover:to-gray-700 active:scale-[0.97] transition-all">
          <div class="w-8 h-8 bg-orange-500/10 rounded-md flex items-center justify-center">
            <i data-lucide="bitcoin" class="w-4 h-4 text-orange-400"></i>
          </div>
          <span class="font-medium text-sm text-gray-100">Crypto Hub</span>
        </a>
        <!-- Refresh Button -->
        <button onclick="location.reload()"
          class="flex items-center gap-3 bg-gradient-to-br from-gray-900 to-gray-800 border border-gray-700 rounded-lg px-4 py-1 shadow-md hover:shadow-lg hover:from-gray-800 hover:to-gray-700 active:scale-[0.97] transition-all">
          <div class="w-8 h-8 bg-indigo-500/10 rounded-md flex items-center justify-center">
            <i data-lucide="refresh-cw" class="w-4 h-4 text-indigo-400"></i>
          </div>
          <span class="font-medium text-sm text-gray-100">Refresh</span>
        </button>
      </div>
    </div>

    <!-- Fixed Deposit Modals (unchanged) -->
    <dialog id="fixed-deposit-consent-modal" class="p-6 bg-gray-900 rounded-xl text-white max-w-md w-full">
      <h3 class="text-xl font-semibold mb-4">Fixed Deposit Application</h3>
      <p class="mb-6 text-gray-300">By proceeding, you consent to:</p>
      <ul class="list-disc pl-5 mb-6 text-gray-300 space-y-2.5">
        <li>Your funds will be locked for the entire duration of the selected Fixed Deposit term.</li>
        <li>Withdrawals and premature encashment will not be available until the package maturity date.</li>
        <li>All provisions are subject to the Fixed Deposit product's official Terms and Conditions.</li>
        <li>A daily reward equivalent to 2% of the deposited balance will be credited to your account.</li>
      </ul>
      <div class="flex justify-end gap-4">
        <button type="button" class="px-5 py-2.5 bg-gray-700 hover:bg-gray-600 rounded-lg transition" onclick="document.getElementById('fixed-deposit-consent-modal').close()">Cancel</button>
        <button type="button" id="confirm-fd-apply" class="px-5 py-2.5 bg-amber-600 hover:bg-amber-500 rounded-lg transition font-medium">I Agree – Apply</button>
      </div>
    </dialog>

    <dialog id="already-fixed-deposit-consent-modal" class="p-6 bg-gray-900 rounded-xl text-white max-w-md w-full shadow-2xl">
      <h3 class="text-xl font-semibold mb-5 text-gray-100">Already a Fixed Deposit Member</h3>
      <p class="text-gray-300 mb-6 leading-relaxed">This account is already registered as a fixed deposit member. Please contact support or use a different account if you wish to proceed with a new registration.</p>
      <div class="flex justify-end gap-4">
        <button type="button" class="px-6 py-2.5 bg-gray-700 hover:bg-gray-600 rounded-lg font-medium" onclick="document.getElementById('already-fixed-deposit-consent-modal').close()">Close</button>
      </div>
    </dialog>

    <!-- Invest / Withdraw Buttons -->
    <div class="flex gap-2 px-4 mb-5">
      <a href="{{ route('user.plans') }}" class="flex-1 py-1.5 rounded-full font-medium text-xs bg-gradient-to-r from-emerald-500 to-green-600 text-white shadow-md hover:brightness-110 active:scale-95 transition-all text-center">Membership</a>
      <a href="{{ route('user.upgrade_plan') }}" class="flex-1 py-1.5 rounded-full font-medium text-xs bg-gradient-to-r from-indigo-500 to-blue-600 text-white shadow-md hover:brightness-110 active:scale-95 transition-all text-center">Upgrade Plan</a>
    </div>

    <!-- Lucky Games Banner -->
    <div class="flex w-full gap-3 px-4 mb-4">
      <a href="#" class="relative flex-1 min-w-0 py-3 px-4 rounded-xl text-center font-bold text-sm leading-tight text-white shadow-xl overflow-hidden bg-gradient-to-r from-yellow-400 via-orange-500 to-amber-600 animate-pulse hover:animate-none transition-all duration-300 hover:scale-105 active:scale-95">
        <span class="absolute inset-0 overflow-hidden rounded-xl">
          <span class="absolute -left-full top-0 h-full w-1/2 bg-white/30 skew-x-12 animate-[shine_2.5s_infinite]"></span>
        </span>
        <span class="absolute inset-0 rounded-xl blur-md opacity-80 bg-gradient-to-r from-yellow-300 to-orange-500"></span>
        <span class="relative z-10 text-black font-bold tracking-wide">🎮 Lucky Games 🎮 قسمت آزمائیں</span>
      </a>
    </div>

    <!-- Grid Menu -->
    <div class="grid grid-cols-3 gap-3 px-4 mb-4">
      <a href="{{ route('user.my_plans') }}" class="card rounded-xl p-3 text-center hover:scale-105 active:scale-95 transition">
        <div class="mx-auto mb-1.5 w-10 h-10 rounded-lg bg-gradient-to-br from-indigo-600 to-purple-800 flex items-center justify-center"><i data-lucide="layers" class="w-5 h-5"></i></div>
        <p class="font-semibold text-xs">My Plans</p>
      </a>
      <a href="{{ route('user.my_team') }}" class="card rounded-xl p-3 text-center hover:scale-105 transition">
        <div class="mx-auto mb-1.5 w-10 h-10 rounded-lg bg-gradient-to-br from-purple-600 to-pink-600 flex items-center justify-center"><i data-lucide="users" class="w-5 h-5"></i></div>
        <p class="font-semibold text-xs">My Team</p>
      </a>
      <a href="{{ route('user.my_tasks') }}" class="card rounded-xl p-3 text-center hover:scale-105 transition relative">
        <div class="mx-auto mb-1.5 w-10 h-10 rounded-lg bg-emerald-600 flex items-center justify-center"><i data-lucide="list-checks" class="w-5 h-5 text-white"></i></div>
        <p class="font-semibold text-xs mt-1.5">My Tasks</p><span class="absolute -top-1 -right-1 bg-amber-600 text-[9px] font-bold px-1.5 py-0.5 rounded-full shadow"></span>
      </a>
      <a href="{{ route('user.my_orders') }}" class="card rounded-xl p-3 text-center hover:scale-105 transition">
        <div class="mx-auto mb-1.5 w-10 h-10 rounded-lg bg-gradient-to-br from-green-600 to-emerald-700 flex items-center justify-center"><i data-lucide="shopping-cart" class="w-5 h-5"></i></div>
        <p class="font-semibold text-xs">My Orders</p>
      </a>
      <a href="{{ route('user.withdraw_history') }}" class="card rounded-xl p-3 text-center hover:scale-105 transition">
        <div class="mx-auto mb-1.5 w-10 h-10 rounded-lg bg-gradient-to-br from-red-600 to-rose-700 flex items-center justify-center"><i data-lucide="upload" class="w-5 h-5"></i></div>
        <p class="font-semibold text-xs">Withdraw Log</p>
      </a>
      <a href="/FeatureDesk.apk" class="card rounded-xl p-3 text-center hover:scale-105 transition">
        <div class="mx-auto mb-1.5 w-10 h-10 rounded-lg bg-gradient-to-br from-orange-500 to-amber-600 flex items-center justify-center"><i data-lucide="smartphone" class="w-5 h-5"></i></div>
        <p class="font-semibold text-xs">App Download</p>
      </a>
      <a href="{{ route('user.my_complaints') }}" class="card rounded-xl p-3 text-center hover:scale-105 transition">
        <div class="mx-auto mb-1.5 w-10 h-10 rounded-lg bg-amber-600 flex items-center justify-center"><i data-lucide="alert-circle" class="w-5 h-5 text-white"></i></div>
        <p class="font-semibold text-xs">Complaint</p>
      </a>
      <a href="{{ route('user.all_transactions') }}" class="card rounded-xl p-3 text-center hover:scale-105 transition">
        <div class="mx-auto mb-1.5 w-10 h-10 rounded-lg bg-gradient-to-br from-blue-600 to-cyan-600 flex items-center justify-center"><i data-lucide="receipt" class="w-5 h-5"></i></div>
        <p class="font-semibold text-xs">Transactions</p>
      </a>
      <a href="https://whatsapp.com/channel/0029VbCEe3o0lwgyDdnKFe1H" rel="noopener noreferrer" class="card rounded-xl p-3 text-center hover:scale-105 transition">
        <div class="mx-auto mb-1.5 w-10 h-10 rounded-lg bg-green-600 flex items-center justify-center"><i class="fab fa-whatsapp w-5 h-5 text-white"></i></div>
        <p class="font-semibold text-xs">Helpline</p>
      </a>
    </div>

    <!-- Referral Link -->
    <div class="mx-4 mb-4 card rounded-xl p-4">
      <h3 class="text-base font-bold mb-1 text-center">Referral Link</h3>
      <div class="flex gap-2.5">
        <button id="copy-btn" class="flex-1 py-1 rounded-full gradient-primary font-semibold text-sm active:scale-95 transition">Copy</button>
        <button id="whatsapp-btn" class="flex-1 py-1 rounded-full font-semibold text-sm flex items-center justify-center gap-1.5 active:scale-95 transition bg-[#25D366] hover:bg-[#20b858] text-white"><i class="fab fa-whatsapp w-4 h-4"></i> WhatsApp</button>
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="px-4 grid grid-cols-2 gap-3 mb-2">
      <div class="card rounded-xl p-3.5 text-center">
        <p class="text-xs text-gray-400 mb-0.5">Total Deposit</p>
        <p class="text-xl font-bold text-emerald-400">0</p>
        <p class="text-xs text-gray-400 mb-0.5 mt-1">Tasks Reward</p>
        <p class="text-xl font-bold text-yellow-400">0</p>
      </div>
      <div class="card rounded-xl p-3.5 text-center">
        <p class="text-xs text-gray-400 mb-0.5">Total Withdraw</p>
        <p class="text-xl font-bold text-red-400">0</p>
        <p class="text-xs text-gray-400 mb-0.5 mt-1">Balance Shared</p>
        <p class="text-xl font-bold text-yellow-400">0</p>
      </div>
      <div class="card rounded-xl p-3.5 text-center">
        <p class="text-xs text-gray-400 mb-0.5">Refer Bonus</p>
        <p class="text-xl font-bold text-purple-300">0</p>
      </div>
      <div class="card rounded-xl p-3.5 text-center">
        <p class="text-xs text-gray-400 mb-0.5">Pending Withdraw</p>
        <p class="text-xl font-bold text-cyan-300">0</p>
      </div>
      <div class="card rounded-xl p-3.5 text-center">
        <p class="text-xs text-gray-400 mb-0.5">Team Size</p>
        <p class="text-xl font-bold">0</p>
      </div>
      <div class="card rounded-xl p-3.5 text-center">
        <p class="text-xs text-gray-400 mb-0.5">Team Invest</p>
        <p class="text-xl font-bold">0</p>
      </div>
    </div>

    <!-- Network Stats -->
    <div class="bg-gradient-to-r from-purple-900/60 to-blue-900/60 rounded-lg p-3 text-center mx-4 mb-20 card rounded-xl p-4">
      <p class="font-semibold text-base">0</p>
      <p class="text-xs text-gray-400 mt-0.5">Total Earnings</p>
    </div>

    <!-- Bottom Navigation -->
    @include('user.includes.bottom_navigation')

  </div> <!-- end mobile container -->

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const copyBtn = document.getElementById('copy-btn');
      if (copyBtn) {
        copyBtn.addEventListener('click', function() {
          const link = "{{ url('/register?ref=' . ($user->referral_code ?? '')) }}";
          navigator.clipboard.writeText(link).then(() => alert('Referral link copied!')).catch(() => prompt('Copy manually:', link));
        });
      }
      const waBtn = document.getElementById('whatsapp-btn');
      if (waBtn) {
        waBtn.addEventListener('click', function() {
          const link = "{{ url('/register?ref=' . ($user->referral_code ?? '')) }}";
          window.open(`https://wa.me/?text=${encodeURIComponent('Join me on this platform: ' + link)}`, '_blank');
        });
      }
    });
  </script>

</body>

</html>
@endif



@if(1 == 2)
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  @include('user.includes.general_style')
  <title>User Dashboard – Services</title>
</head>

<body class="min-h-screen bg-[#0A0A0F]">

  <!-- Mobile-like container -->
  <div class="mx-auto max-w-[420px] min-h-screen bg-[#0A0A0F] shadow-2xl shadow-black/50 relative">

    <!-- Top Greeting -->
    @include('user.includes.top_greetings')

    <!-- Success/Error Messages -->
    <div class="px-4 mt-2 mb-3">
      @include('includes.success')
    </div>

    <!-- Wallet / Service Credit Section -->
    <div class="px-4 mt-2 mb-4">
      <div class="relative w-full rounded-2xl overflow-hidden bg-gradient-to-r from-emerald-500 to-green-600 border border-emerald-400/30 px-6 py-5 shadow-xl">
        <div class="absolute inset-0 bg-white/10 pointer-events-none"></div>
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-semibold text-white/90 tracking-wider uppercase">Service Wallet</p>
            <div class="text-4xl font-bold text-white tracking-tighter mt-1">
              Rs. {{ number_format($user->wallet_balance ?? 0, 2) }}
            </div>
            <p class="text-xs text-white/70 mt-1">Available for service payments</p>
          </div>
          <div class="bg-white/20 backdrop-blur-md rounded-2xl p-3 shadow-inner border border-white/30">
            <i data-lucide="wallet" class="w-9 h-9 text-white stroke-[1.5]"></i>
          </div>
        </div>
        <div class="flex gap-2 mt-4">
          <a href="" class="flex-1 text-center text-sm font-medium bg-white/20 hover:bg-white/30 py-1.5 rounded-lg transition">Add Funds</a>
          <a href="" class="flex-1 text-center text-sm font-medium bg-white/20 hover:bg-white/30 py-1.5 rounded-lg transition">History</a>
        </div>
      </div>
    </div>

    <!-- Quick Actions – Service Related -->
    <div class="px-4 mt-1 mb-4">
      <div class="grid grid-cols-2 gap-3">
        <a href="" class="flex items-center gap-3 bg-gradient-to-br from-gray-900 to-gray-800 border border-gray-700 rounded-lg px-4 py-1 shadow-md hover:shadow-lg hover:from-gray-800 hover:to-gray-700 active:scale-[0.97] transition-all">
          <div class="w-8 h-8 bg-emerald-500/10 rounded-md flex items-center justify-center">
            <i data-lucide="search" class="w-4 h-4 text-emerald-400"></i>
          </div>
          <span class="font-medium text-sm text-gray-100">Find Services</span>
        </a>
        <a href="" class="flex items-center gap-3 bg-gradient-to-br from-gray-900 to-gray-800 border border-gray-700 rounded-lg px-4 py-1 shadow-md hover:shadow-lg hover:from-gray-800 hover:to-gray-700 active:scale-[0.97] transition-all">
          <div class="w-8 h-8 bg-amber-500/10 rounded-md flex items-center justify-center">
            <i data-lucide="clock" class="w-4 h-4 text-amber-400"></i>
          </div>
          <span class="font-medium text-sm text-gray-100">Active Orders</span>
        </a>
        <a href="" class="flex items-center gap-3 bg-gradient-to-br from-gray-900 to-gray-800 border border-gray-700 rounded-lg px-4 py-1 shadow-md hover:shadow-lg hover:from-gray-800 hover:to-gray-700 active:scale-[0.97] transition-all">
          <div class="w-8 h-8 bg-rose-500/10 rounded-md flex items-center justify-center">
            <i data-lucide="heart" class="w-4 h-4 text-rose-400"></i>
          </div>
          <span class="font-medium text-sm text-gray-100">Favorites</span>
        </a>
        <a href="" class="flex items-center gap-3 bg-gradient-to-br from-gray-900 to-gray-800 border border-gray-700 rounded-lg px-4 py-1 shadow-md hover:shadow-lg hover:from-gray-800 hover:to-gray-700 active:scale-[0.97] transition-all">
          <div class="w-8 h-8 bg-purple-500/10 rounded-md flex items-center justify-center">
            <i data-lucide="star" class="w-4 h-4 text-purple-400"></i>
          </div>
          <span class="font-medium text-sm text-gray-100">My Reviews</span>
        </a>
      </div>
    </div>

    <!-- Service Categories Grid (using forelse) -->
    <div class="px-4 mb-5">
      <div class="flex justify-between items-center mb-2">
        <h3 class="text-sm font-semibold text-gray-200">Browse by Category</h3>
        <a href="" class="text-xs text-emerald-400">See all</a>
      </div>
      <div class="grid grid-cols-4 gap-3">
        @forelse($categories ?? [] as $category)
        <a href="" class="text-center">
          <div class="bg-gray-800/50 rounded-xl p-2.5 flex items-center justify-center mb-1 border border-gray-700 hover:border-emerald-500/50 transition">
            <i data-lucide="{{ $category->icon ?? 'briefcase' }}" class="w-6 h-6 text-emerald-400"></i>
          </div>
          <span class="text-[11px] text-gray-400">{{ $category->name }}</span>
        </a>
        @empty
        <!-- Demo categories if no data -->
        <a href="#" class="text-center">
          <div class="bg-gray-800/50 rounded-xl p-2.5"><i data-lucide="wrench" class="w-6 h-6 text-emerald-400"></i></div><span class="text-[11px] text-gray-400">Repair</span>
        </a>
        <a href="#" class="text-center">
          <div class="bg-gray-800/50 rounded-xl p-2.5"><i data-lucide="home" class="w-6 h-6 text-emerald-400"></i></div><span class="text-[11px] text-gray-400">Home</span>
        </a>
        <a href="#" class="text-center">
          <div class="bg-gray-800/50 rounded-xl p-2.5"><i data-lucide="laptop" class="w-6 h-6 text-emerald-400"></i></div><span class="text-[11px] text-gray-400">IT</span>
        </a>
        <a href="#" class="text-center">
          <div class="bg-gray-800/50 rounded-xl p-2.5"><i data-lucide="book-open" class="w-6 h-6 text-emerald-400"></i></div><span class="text-[11px] text-gray-400">Tuition</span>
        </a>
        @endforelse
      </div>
    </div>

    <!-- Active Service Requests / Orders -->
    <div class="px-4 mb-5">
      <div class="flex justify-between items-center mb-2">
        <h3 class="text-sm font-semibold text-gray-200">Active Orders</h3>
        <a href="" class="text-xs text-emerald-400">View all</a>
      </div>
      <div class="space-y-2">
        @forelse($activeOrders ?? [] as $order)
        <div class="bg-gray-900/60 border border-gray-800 rounded-xl p-3 flex justify-between items-center">
          <div>
            <p class="text-sm font-medium text-white">{{ $order->service_name }}</p>
            <p class="text-xs text-gray-400">Expert: {{ $order->expert_name }} • {{ $order->status }}</p>
          </div>
          <div class="text-right">
            <p class="text-sm font-semibold text-emerald-400">Rs. {{ number_format($order->price, 2) }}</p>
            <a href="" class="text-xs text-emerald-400">Track</a>
          </div>
        </div>
        @empty
        <div class="bg-gray-900/30 border border-dashed border-gray-700 rounded-xl p-4 text-center">
          <i data-lucide="package" class="w-8 h-8 text-gray-600 mx-auto mb-1"></i>
          <p class="text-sm text-gray-400">No active orders</p>
          <a href="" class="text-xs text-emerald-400 mt-1 inline-block">Browse services →</a>
        </div>
        @endforelse
      </div>
    </div>

    <!-- Recommended / Popular Services -->
    <div class="px-4 mb-5">
      <div class="flex justify-between items-center mb-2">
        <h3 class="text-sm font-semibold text-gray-200">Recommended for You</h3>
        <a href="" class="text-xs text-emerald-400">More</a>
      </div>
      <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
        @forelse($recommendedServices ?? [] as $service)
        <div class="min-w-[160px] bg-gray-900/60 border border-gray-800 rounded-xl p-3">
          <div class="flex items-center gap-2 mb-2">
            <div class="w-8 h-8 rounded-full bg-emerald-500/20 flex items-center justify-center">
              <i data-lucide="user" class="w-4 h-4 text-emerald-400"></i>
            </div>
            <div>
              <p class="text-xs font-semibold text-white">{{ $service->expert_name }}</p>
              <p class="text-[10px] text-gray-400">{{ $service->category }}</p>
            </div>
          </div>
          <p class="text-sm text-white font-medium truncate">{{ $service->name }}</p>
          <p class="text-xs text-gray-400 mt-1">Starting from</p>
          <p class="text-base font-bold text-emerald-400">Rs. {{ number_format($service->price, 2) }}</p>
          <a href="" class="mt-2 block text-center text-xs bg-emerald-600/20 hover:bg-emerald-600/30 py-1 rounded-lg transition">View</a>
        </div>
        @empty
        <div class="min-w-[160px] bg-gray-900/60 border border-gray-800 rounded-xl p-3 text-center">
          <i data-lucide="shopping-bag" class="w-6 h-6 text-gray-600 mx-auto mb-1"></i>
          <p class="text-xs text-gray-400">No recommendations yet</p>
        </div>
        @endforelse
      </div>
    </div>

    <!-- Quick Stats (service usage stats) -->
    <div class="px-4 grid grid-cols-2 gap-3 mb-5">
      <div class="bg-gray-900/40 rounded-xl p-3 text-center border border-gray-800">
        <p class="text-xs text-gray-400">Services Used</p>
        <p class="text-xl font-bold text-white">{{ $totalServicesUsed ?? 0 }}</p>
      </div>
      <div class="bg-gray-900/40 rounded-xl p-3 text-center border border-gray-800">
        <p class="text-xs text-gray-400">Total Spent</p>
        <p class="text-xl font-bold text-emerald-400">Rs. {{ number_format($totalSpent ?? 0, 2) }}</p>
      </div>
    </div>

    <!-- Support / Help Button -->
    <div class="mx-4 mb-16">
      <a href="" class="flex items-center justify-center gap-2 w-full py-2.5 bg-gradient-to-r from-gray-800 to-gray-900 rounded-xl text-sm font-medium text-gray-300 hover:text-white border border-gray-700 transition">
        <i data-lucide="headphones" class="w-4 h-4"></i> Need Help? Contact Support
      </a>
    </div>

    <!-- Bottom Navigation (User Version) -->
    @include('user.includes.bottom_navigation')

  </div> <!-- end mobile container -->

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      if (typeof lucide !== 'undefined') lucide.createIcons();
    });
  </script>

</body>

</html>
@endif



<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  @include('user.includes.general_style')
  <title>Home Services – Find Plumber, Electrician & More</title>
  <style>
    /* Hide scrollbar for category slider but keep functionality */
    .scrollbar-hide::-webkit-scrollbar {
      display: none;
    }
    .scrollbar-hide {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }
  </style>
</head>
<body class="min-h-screen bg-[#0A0A0F]">

  <!-- Mobile-like container -->
  <div class="mx-auto max-w-[420px] min-h-screen bg-[#0A0A0F] shadow-2xl shadow-black/50 relative">

    <!-- Top Greeting -->
    @include('user.includes.top_greetings')

    <!-- Search Bar – Prominent (now uses #) -->
    <div class="px-4 mt-3 mb-4">
      <form action="#" method="GET" class="relative" onsubmit="alert('Search feature coming soon'); return false;">
        <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
        <input type="text" name="query" placeholder="Search for plumber, electrician, AC repair..." 
               class="w-full bg-gray-900/80 border border-gray-700 rounded-xl py-3 pl-10 pr-4 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-emerald-500/50 transition">
        <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 bg-emerald-600 px-3 py-1 rounded-lg text-xs font-medium">Go</button>
      </form>
    </div>

    <!-- Quick Categories (Horizontal Scroll) -->
    <div class="px-4 mb-5">
      <h3 class="text-sm font-semibold text-gray-200 mb-2">Browse by Service</h3>
      <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
        @php
          $categories = [
            ['name' => 'Plumber', 'icon' => 'droplet', 'color' => 'blue'],
            ['name' => 'Electrician', 'icon' => 'zap', 'color' => 'yellow'],
            ['name' => 'Carpenter', 'icon' => 'hammer', 'color' => 'amber'],
            ['name' => 'AC Repair', 'icon' => 'snowflake', 'color' => 'cyan'],
            ['name' => 'Painter', 'icon' => 'palette', 'color' => 'purple'],
            ['name' => 'Cleaner', 'icon' => 'spray-can', 'color' => 'green'],
            ['name' => 'Electrician', 'icon' => 'plug', 'color' => 'orange'],
            ['name' => 'Plumber', 'icon' => 'wrench', 'color' => 'teal'],
          ];
        @endphp
        @foreach($categories as $cat)
          <a href="#" class="flex flex-col items-center min-w-[70px]" onclick="alert('Category: {{ $cat['name'] }}'); return false;">
            <div class="w-14 h-14 rounded-2xl bg-gray-800/80 border border-gray-700 flex items-center justify-center mb-1 hover:border-emerald-500/50 transition group">
              <i data-lucide="{{ $cat['icon'] }}" class="w-6 h-6 text-{{ $cat['color'] }}-400"></i>
            </div>
            <span class="text-[11px] text-gray-400">{{ $cat['name'] }}</span>
          </a>
        @endforeach
      </div>
    </div>

    <!-- Nearby Professionals / Top Rated -->
    <div class="px-4 mb-5">
      <div class="flex justify-between items-center mb-2">
        <h3 class="text-sm font-semibold text-gray-200">Nearby Professionals</h3>
        <a href="#" class="text-xs text-emerald-400" onclick="alert('All nearby professionals'); return false;">View all</a>
      </div>
      <div class="space-y-3">
        <!-- Demo experts with # links -->
        <div class="bg-gray-900/60 border border-gray-800 rounded-xl p-3 flex items-center gap-3">
          <div class="w-12 h-12 rounded-full bg-blue-600/30 flex items-center justify-center text-blue-400 font-bold">R</div>
          <div class="flex-1">
            <div class="flex items-center gap-2">
              <p class="font-semibold text-white text-sm">Ramesh K.</p>
              <span class="text-[10px] bg-emerald-600/20 text-emerald-400 px-1.5 py-0.5 rounded-full">Plumber</span>
            </div>
            <div class="flex items-center gap-3 mt-0.5">
              <span class="text-xs text-gray-400"><i data-lucide="star" class="w-3 h-3 inline text-yellow-500"></i> 4.9</span>
              <span class="text-xs text-gray-400"><i data-lucide="map-pin" class="w-3 h-3 inline"></i> 1.2 km</span>
            </div>
            <p class="text-xs text-gray-500 mt-1">Starting from Rs. 299</p>
          </div>
          <a href="#" class="bg-emerald-600/20 hover:bg-emerald-600/30 px-3 py-1.5 rounded-lg text-xs font-medium text-emerald-400 transition" onclick="alert('Book Ramesh'); return false;">Book</a>
        </div>
        <div class="bg-gray-900/60 border border-gray-800 rounded-xl p-3 flex items-center gap-3">
          <div class="w-12 h-12 rounded-full bg-yellow-600/30 flex items-center justify-center text-yellow-400 font-bold">S</div>
          <div class="flex-1">
            <div class="flex items-center gap-2">
              <p class="font-semibold text-white text-sm">Sunil E.</p>
              <span class="text-[10px] bg-emerald-600/20 text-emerald-400 px-1.5 py-0.5 rounded-full">Electrician</span>
            </div>
            <div class="flex items-center gap-3 mt-0.5">
              <span class="text-xs text-gray-400"><i data-lucide="star" class="w-3 h-3 inline text-yellow-500"></i> 4.8</span>
              <span class="text-xs text-gray-400"><i data-lucide="map-pin" class="w-3 h-3 inline"></i> 3.0 km</span>
            </div>
            <p class="text-xs text-gray-500 mt-1">Starting from Rs. 399</p>
          </div>
          <a href="#" class="bg-emerald-600/20 px-3 py-1.5 rounded-lg text-xs font-medium text-emerald-400" onclick="alert('Book Sunil'); return false;">Book</a>
        </div>
        <div class="bg-gray-900/60 border border-gray-800 rounded-xl p-3 flex items-center gap-3">
          <div class="w-12 h-12 rounded-full bg-amber-600/30 flex items-center justify-center text-amber-400 font-bold">M</div>
          <div class="flex-1">
            <div class="flex items-center gap-2">
              <p class="font-semibold text-white text-sm">Mohan C.</p>
              <span class="text-[10px] bg-emerald-600/20 text-emerald-400 px-1.5 py-0.5 rounded-full">Carpenter</span>
            </div>
            <div class="flex items-center gap-3 mt-0.5">
              <span class="text-xs text-gray-400"><i data-lucide="star" class="w-3 h-3 inline text-yellow-500"></i> 4.7</span>
              <span class="text-xs text-gray-400"><i data-lucide="map-pin" class="w-3 h-3 inline"></i> 2.5 km</span>
            </div>
            <p class="text-xs text-gray-500 mt-1">Starting from Rs. 499</p>
          </div>
          <a href="#" class="bg-emerald-600/20 px-3 py-1.5 rounded-lg text-xs font-medium text-emerald-400" onclick="alert('Book Mohan'); return false;">Book</a>
        </div>
      </div>
    </div>

    <!-- Service Packages / Offers -->
    <div class="px-4 mb-5">
      <div class="flex justify-between items-center mb-2">
        <h3 class="text-sm font-semibold text-gray-200">Popular Service Packages</h3>
        <a href="#" class="text-xs text-emerald-400" onclick="alert('All packages'); return false;">View all</a>
      </div>
      <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
        <div class="min-w-[200px] bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl p-3 border border-gray-700">
          <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-bold bg-emerald-600/30 text-emerald-400 px-2 py-0.5 rounded-full">20% OFF</span>
            <i data-lucide="gift" class="w-4 h-4 text-emerald-400"></i>
          </div>
          <p class="font-semibold text-white text-sm">Plumbing Maintenance</p>
          <p class="text-xs text-gray-400 mt-1">Includes inspection + 2 repairs</p>
          <div class="mt-2 flex items-center justify-between">
            <span class="text-base font-bold text-emerald-400">Rs. 999</span>
            <a href="#" class="text-xs bg-emerald-600 px-2.5 py-1 rounded-lg" onclick="alert('Book Plumbing Maintenance'); return false;">Book</a>
          </div>
        </div>
        <div class="min-w-[200px] bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl p-3 border border-gray-700">
          <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-bold bg-emerald-600/30 text-emerald-400 px-2 py-0.5 rounded-full">15% OFF</span>
            <i data-lucide="gift" class="w-4 h-4 text-emerald-400"></i>
          </div>
          <p class="font-semibold text-white text-sm">Full Home Electrification</p>
          <p class="text-xs text-gray-400 mt-1">Wiring + 10 points + safety check</p>
          <div class="mt-2 flex items-center justify-between">
            <span class="text-base font-bold text-emerald-400">Rs. 2499</span>
            <a href="#" class="text-xs bg-emerald-600 px-2.5 py-1 rounded-lg" onclick="alert('Book Home Electrification'); return false;">Book</a>
          </div>
        </div>
        <div class="min-w-[200px] bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl p-3 border border-gray-700">
          <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-bold bg-emerald-600/30 text-emerald-400 px-2 py-0.5 rounded-full">10% OFF</span>
            <i data-lucide="gift" class="w-4 h-4 text-emerald-400"></i>
          </div>
          <p class="font-semibold text-white text-sm">AC Service & Repair</p>
          <p class="text-xs text-gray-400 mt-1">Gas refill + cleaning + check</p>
          <div class="mt-2 flex items-center justify-between">
            <span class="text-base font-bold text-emerald-400">Rs. 1499</span>
            <a href="#" class="text-xs bg-emerald-600 px-2.5 py-1 rounded-lg" onclick="alert('Book AC Service'); return false;">Book</a>
          </div>
        </div>
      </div>
    </div>

    <!-- How It Works Section -->
    <div class="px-4 mb-5">
      <h3 class="text-sm font-semibold text-gray-200 mb-2">How It Works</h3>
      <div class="grid grid-cols-3 gap-2 text-center">
        <div class="bg-gray-900/40 rounded-xl p-2 border border-gray-800">
          <i data-lucide="search" class="w-5 h-5 text-emerald-400 mx-auto mb-1"></i>
          <p class="text-[10px] text-gray-400">1. Search</p>
        </div>
        <div class="bg-gray-900/40 rounded-xl p-2 border border-gray-800">
          <i data-lucide="calendar" class="w-5 h-5 text-emerald-400 mx-auto mb-1"></i>
          <p class="text-[10px] text-gray-400">2. Book</p>
        </div>
        <div class="bg-gray-900/40 rounded-xl p-2 border border-gray-800">
          <i data-lucide="check-circle" class="w-5 h-5 text-emerald-400 mx-auto mb-1"></i>
          <p class="text-[10px] text-gray-400">3. Relax</p>
        </div>
      </div>
    </div>

    <!-- Support / Quick Help -->
    <div class="mx-4 mb-20">
      <div class="bg-gradient-to-r from-gray-800/50 to-gray-900/50 rounded-xl p-3 flex items-center justify-between border border-gray-700">
        <div class="flex items-center gap-2">
          <i data-lucide="phone-call" class="w-5 h-5 text-emerald-400"></i>
          <span class="text-sm text-gray-200">24/7 Support</span>
        </div>
        <a href="tel:+919876543210" class="text-xs bg-emerald-600/20 px-3 py-1 rounded-full text-emerald-400">Call Now</a>
      </div>
    </div>

    <!-- Bottom Navigation (User Version) - Ensure this file exists -->
    @include('user.includes.bottom_navigation')

  </div> <!-- end mobile container -->

  <!-- Only ONE lucide initialization, no MutationObserver -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      if (typeof lucide !== 'undefined') {
        lucide.createIcons();
      }
    });
  </script>
</body>
</html>