<!DOCTYPE html>
<html lang="en">
<head>
  @include('user.includes.general_style')
  <title>My Bookings – Home Services</title>
</head>
<body class="min-h-screen bg-[#FDFBF7]">

<div class="mx-auto max-w-[420px] min-h-screen bg-[#FDFBF7] relative">

  @include('user.includes.top_greetings')

  <div class="px-4 mt-4">
    <h1 class="text-xl font-bold text-[#2C1810]">My Bookings</h1>
  </div>

  @if(session('success'))
    <div class="mx-4 mt-2 p-2 bg-[#FFE66D]/20 border border-[#FFE66D]/50 rounded-lg text-[#2C1810] text-sm">{{ session('success') }}</div>
  @endif

  <!-- Upcoming -->
  <div class="px-4 mt-4">
    <h2 class="text-sm font-semibold text-[#2C1810] mb-2">Upcoming</h2>
    @forelse($upcoming as $book)
    <div class="bg-white border border-[#EAE0D5] rounded-xl p-3 mb-2 shadow-sm">
      <div class="flex justify-between items-start">
        <div>
          <p class="font-semibold text-[#2C1810]">{{ $book->professional }}</p>
          <p class="text-xs text-[#6B5B50]">{{ $book->service }}</p>
          <p class="text-xs text-[#6B5B50] mt-1"><i data-lucide="calendar" class="w-3 h-3 inline"></i> {{ $book->date }}</p>
        </div>
        <span class="text-xs px-2 py-1 rounded-full {{ $book->status == 'Confirmed' ? 'bg-green-100 text-green-700' : 'bg-[#FFE66D]/30 text-[#2C1810]' }}">{{ $book->status }}</span>
      </div>
      <div class="mt-2 flex gap-2">
        <a href="{{ route('bookings.show', $book->id) }}" class="text-xs text-[#FF6B6B] hover:text-[#ff5252]">View Details</a>
        <a href="#" class="text-xs text-red-500 hover:text-red-600" onclick="alert('Cancel demo'); return false;">Cancel</a>
      </div>
    </div>
    @empty
    <p class="text-[#6B5B50] text-sm">No upcoming bookings.</p>
    @endforelse
  </div>

  <!-- Past -->
  <div class="px-4 mt-4 mb-20">
    <h2 class="text-sm font-semibold text-[#2C1810] mb-2">Past</h2>
    @forelse($past as $book)
    <div class="bg-[#F5F0EA] border border-[#EAE0D5] rounded-xl p-3 mb-2 opacity-80">
      <p class="font-semibold text-[#2C1810]">{{ $book->professional }}</p>
      <p class="text-xs text-[#6B5B50]">{{ $book->service }} • {{ $book->date }}</p>
      <span class="text-xs text-[#6B5B50]">{{ $book->status }}</span>
    </div>
    @empty
    <p class="text-[#6B5B50] text-sm">No past bookings.</p>
    @endforelse
  </div>

  @include('user.includes.bottom_navigation')
</div>
<script> document.addEventListener('DOMContentLoaded', () => { if (typeof lucide !== 'undefined') lucide.createIcons(); }); </script>
</body>
</html>