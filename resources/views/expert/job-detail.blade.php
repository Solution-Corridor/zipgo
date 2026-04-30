<!DOCTYPE html>
<html lang="en">

<head>
  @include('expert.includes.general_style')
  <title>Job #{{ $job->id }} | Expert Dashboard</title>
</head>

<body class="min-h-screen bg-[#121826]">

  <div class="mx-auto max-w-[420px] min-h-screen bg-[#121826] shadow-2xl shadow-black/50 relative">

    @include('expert.includes.top_greetings')

    <div class="px-4 pt-4 pb-20">
      <!-- Back link -->
      <a href="{{ route('expert.jobs') }}" class="text-[#F4A261] text-sm flex items-center gap-1 mb-4 hover:text-[#E08E3E]">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Jobs
      </a>

      <!-- Job details card -->
      <div class="bg-[#1A2636] rounded-xl border border-[#2A3A5A] shadow-xl overflow-hidden">
        <div class="p-5 space-y-4">
          <!-- Header with status badge -->
          <div class="flex justify-between items-start">
            <h1 class="text-xl font-bold text-white">Job #{{ $job->id }}</h1>
            <span class="text-xs px-3 py-1 rounded-full 
                        @if($job->status == 'completed') bg-green-900/40 text-green-400
                        @elseif($job->status == 'confirmed') bg-[#2A5C8C]/40 text-[#8AB3D3]
                        @elseif($job->status == 'pending') bg-[#F4A261]/20 text-[#F4A261]
                        @else bg-red-900/40 text-red-400 @endif">
              {{ ucfirst($job->status) }}
            </span>
          </div>

          <!-- Customer info -->
          <div class="border-t border-[#2A3A5A] pt-3">
            <div class="flex justify-between">
              <span class="text-xs text-gray-400">Customer</span>
              <span class="text-sm text-white font-medium">{{ $job->customer }}</span>
            </div>
            <div class="flex justify-between mt-2">
              <span class="text-xs text-gray-400">Phone</span>
              <a href="tel:{{ $job->customer_phone }}" class="text-sm text-[#F4A261]">{{ $job->customer_phone }}</a>
            </div>
          </div>

          <!-- Service & schedule -->
          <div class="border-t border-[#2A3A5A] pt-3">
            <div class="flex justify-between">
              <span class="text-xs text-gray-400">Service</span>
              <span class="text-sm text-white">{{ $job->service }}</span>
            </div>
            <div class="flex justify-between mt-2">
              <span class="text-xs text-gray-400">Date & Time</span>
              <span class="text-sm text-white">{{ $job->date }} at {{ $job->time }}</span>
            </div>
            <div class="flex justify-between mt-2">
              <span class="text-xs text-gray-400">Address</span>
              <span class="text-sm text-white text-right">{{ $job->address }}</span>
            </div>
          </div>

          <!-- Description -->
          <div class="border-t border-[#2A3A5A] pt-3">
            <p class="text-xs text-gray-400 mb-1">Description</p>
            <p class="text-sm text-gray-300">{{ $job->description }}</p>
          </div>

          <!-- Earnings -->
          @if($job->earnings)
          <div class="border-t border-[#2A3A5A] pt-3">
            <div class="flex justify-between">
              <span class="text-xs text-gray-400">Earnings</span>
              <span class="text-lg font-bold text-[#F4A261]">Rs. {{ number_format($job->earnings) }}</span>
            </div>
          </div>
          @endif

          <!-- Action buttons (only if job is pending or confirmed) -->
          @if(in_array($job->status, ['pending', 'confirmed']))
          <div class="flex gap-3 pt-2">
            @if($job->status == 'pending')
            <form method="POST" action="{{ route('expert.jobs.accept', $job->id) }}" class="flex-1">
              @csrf
              <button class="w-full py-2 bg-[#2A5C8C]/40 hover:bg-[#2A5C8C]/60 text-[#F4A261] rounded-lg text-sm font-medium transition">Accept Job</button>
            </form>
            <form method="POST" action="{{ route('expert.jobs.decline', $job->id) }}" class="flex-1">
              @csrf
              <button class="w-full py-2 bg-red-900/40 hover:bg-red-800/60 text-red-400 rounded-lg text-sm font-medium transition">Decline</button>
            </form>
            @elseif($job->status == 'confirmed')
            <form method="POST" action="{{ route('expert.jobs.complete', $job->id) }}" class="w-full">
              @csrf
              <button class="w-full py-2 bg-[#F4A261]/20 hover:bg-[#F4A261]/30 text-[#F4A261] rounded-lg text-sm font-medium transition">Mark as Completed</button>
            </form>
            @endif
          </div>
          @endif

          <!-- Contact customer button -->
          <div class="pt-2">
            <a href="tel:{{ $job->customer_phone }}" class="block w-full text-center py-2 bg-[#2A5C8C]/40 hover:bg-[#2A5C8C]/60 text-[#F4A261] rounded-lg text-sm font-medium transition">
              <i data-lucide="phone" class="w-4 h-4 inline mr-1"></i> Call Customer
            </a>
          </div>
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