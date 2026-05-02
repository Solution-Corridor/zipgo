<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  @include('user.includes.general_style') <!-- replace with expert-specific CSS if needed -->
  <title>Expert Dashboard</title>
  <style>
    /* Hide scrollbar for sliders */
    .scrollbar-hide::-webkit-scrollbar {
      display: none;
    }

    .scrollbar-hide {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }
  </style>
</head>

<body class="min-h-screen bg-[#121826]">

  <div class="mx-auto max-w-[420px] min-h-screen bg-[#121826] shadow-2xl shadow-black/50 relative">

    <!-- Expert Top Greeting (inline) -->
    @php $expert = auth()->user(); @endphp
    @include('expert.includes.top_greetings')

        <!-- ✅ Balance Bar (added) -->
    <div class="px-4 mt-5">
      <div class="bg-gradient-to-r from-[#F4A261] to-[#E08E3E] rounded-2xl p-4 shadow-lg flex justify-between items-center">
        <div>
          <p class="text-white/80 text-xs uppercase tracking-wide">Your Balance</p>
          <p class="text-white text-2xl font-bold">Rs. {{ number_format(auth()->user()->balance ?? 0, 0) }}</p>
        </div>
        <a href="{{ route('expert.recharge') }}" 
           class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white font-semibold py-2 px-5 rounded-xl transition-all flex items-center gap-2">
          <i data-lucide="plus-circle" class="w-4 h-4"></i> Recharge
        </a>
      </div>
    </div>

    <div class="px-4 mt-3 space-y-5 pb-20">
      <!-- Earnings Summary Cards -->
      <div class="grid grid-cols-3 gap-2">
        <div class="bg-[#1A2636] rounded-xl p-3 text-center border border-[#2A3A5A] shadow-lg">
          <i data-lucide="calendar" class="w-5 h-5 text-[#F4A261] mx-auto mb-1"></i>
          <p class="text-xs text-gray-400">Today</p>
          <p class="text-lg font-bold text-white">Rs. {{ number_format($todayEarnings ?? 1250) }}</p>
        </div>
        <div class="bg-[#1A2636] rounded-xl p-3 text-center border border-[#2A3A5A] shadow-lg">
          <i data-lucide="trending-up" class="w-5 h-5 text-[#F4A261] mx-auto mb-1"></i>
          <p class="text-xs text-gray-400">This Week</p>
          <p class="text-lg font-bold text-white">Rs. {{ number_format($weeklyEarnings ?? 8750) }}</p>
        </div>
        <div class="bg-[#1A2636] rounded-xl p-3 text-center border border-[#2A3A5A] shadow-lg">
          <i data-lucide="wallet" class="w-5 h-5 text-[#F4A261] mx-auto mb-1"></i>
          <p class="text-xs text-gray-400">This Month</p>
          <p class="text-lg font-bold text-white">Rs. {{ number_format($monthlyEarnings ?? 34200) }}</p>
        </div>
      </div>

      <!-- Today's Jobs -->
      <div>
        <div class="flex justify-between items-center mb-2">
          <h3 class="text-sm font-semibold text-gray-200">Today's Jobs</h3>
          <a href="{{ route('expert.jobs') }}" class="text-xs text-[#F4A261] hover:text-[#e08e3e]">View all</a>
        </div>
        <div class="space-y-2">
          @forelse(($todaysJobs ?? []) as $job)
          <div class="bg-[#1A2636] rounded-xl p-3 border border-[#2A3A5A] shadow-md">
            <div class="flex justify-between items-start">
              <div>
                <p class="font-semibold text-white">{{ $job->customer }}</p>
                <p class="text-xs text-gray-400">{{ $job->service }} • {{ $job->time }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ $job->address }}</p>
              </div>
              <span class="text-xs px-2 py-1 rounded-full {{ $job->status == 'confirmed' ? 'bg-green-900/40 text-green-400' : 'bg-[#F4A261]/20 text-[#F4A261]' }}">
                {{ ucfirst($job->status) }}
              </span>
            </div>
            @if($job->status == 'pending')
            <div class="mt-2 flex gap-2">
              <button class="flex-1 text-xs bg-[#2A5C8C]/40 hover:bg-[#2A5C8C]/60 py-1 rounded-lg text-[#F4A261] transition">Accept</button>
              <button class="flex-1 text-xs bg-red-900/40 hover:bg-red-800/60 py-1 rounded-lg text-red-400 transition">Decline</button>
            </div>
            @endif
          </div>
          @empty
          <div class="bg-[#1A2636]/60 rounded-xl p-6 text-center border border-dashed border-[#2A3A5A]">
            <i data-lucide="briefcase" class="w-10 h-10 text-gray-600 mx-auto mb-2"></i>
            <p class="text-gray-400 text-sm">No jobs scheduled for today.</p>
          </div>
          @endforelse
        </div>
      </div>

      <!-- Upcoming Bookings -->
      <div>
        <h3 class="text-sm font-semibold text-gray-200 mb-2">Upcoming Bookings</h3>
        <div class="space-y-2">
          @forelse(($upcomingBookings ?? []) as $booking)
          <div class="bg-[#1A2636] rounded-xl p-3 border border-[#2A3A5A] flex justify-between items-center shadow-md">
            <div>
              <p class="font-semibold text-white">{{ $booking->customer }}</p>
              <p class="text-xs text-gray-400">{{ $booking->service }} • {{ $booking->date }} at {{ $booking->time }}</p>
            </div>
            <a href="{{ route('expert.jobs.show', $booking->id) }}" class="text-[#F4A261] text-xs hover:text-[#e08e3e]">View</a>
          </div>
          @empty
          <div class="bg-[#1A2636]/60 rounded-xl p-6 text-center border border-dashed border-[#2A3A5A]">
            <i data-lucide="calendar" class="w-10 h-10 text-gray-600 mx-auto mb-2"></i>
            <p class="text-gray-400 text-sm">No upcoming bookings.</p>
          </div>
          @endforelse
        </div>
      </div>

      <!-- Quick Action: Manage Service Rates -->
      <div class="mt-2">
        <a href="{{ route('expert.rates') }}"
          class="flex items-center justify-between bg-[#1A2636] rounded-xl p-4 border border-[#2A3A5A] shadow-md hover:border-[#F4A261]/50 transition-all group">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-[#F4A261]/20 flex items-center justify-center">
              <i data-lucide="credit-card" class="w-5 h-5 text-[#F4A261]"></i>
            </div>
            <div>
              <p class="font-semibold text-white">Manage Service Rates</p>
              <p class="text-xs text-gray-400">Set your prices & services</p>
            </div>
          </div>
          <i data-lucide="arrow-right" class="w-5 h-5 text-[#F4A261] group-hover:translate-x-1 transition-transform"></i>
        </a>
      </div>

      <!-- Performance Stats -->
      <div class="grid grid-cols-3 gap-2 pb-5">
        <div class="bg-[#1A2636] rounded-xl p-3 text-center border border-[#2A3A5A] shadow-md">
          <p class="text-xl font-bold text-[#F4A261]">{{ $completionRate ?? 98 }}%</p>
          <p class="text-[10px] text-gray-400">Completion Rate</p>
        </div>
        <div class="bg-[#1A2636] rounded-xl p-3 text-center border border-[#2A3A5A] shadow-md">
          <p class="text-xl font-bold text-[#F4A261]">{{ $totalJobs ?? 156 }}</p>
          <p class="text-[10px] text-gray-400">Total Jobs</p>
        </div>
        <div class="bg-[#1A2636] rounded-xl p-3 text-center border border-[#2A3A5A] shadow-md">
          <p class="text-xl font-bold text-[#F4A261]">{{ $rating ?? 4.9 }} ★</p>
          <p class="text-[10px] text-gray-400">Rating</p>
        </div>
      </div>
    </div>

    @include('expert.includes.bottom_navigation')

  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      if (typeof lucide !== 'undefined') lucide.createIcons();
    });
  </script>

</body>
</html>