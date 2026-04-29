<!DOCTYPE html>
<html lang="en">
<head>
  @include('user.includes.general_style')
  <title>My Bookings – Home Services</title>
</head>
<body class="min-h-screen bg-[#0A0A0F]">

<div class="mx-auto max-w-[420px] min-h-screen bg-[#0A0A0F] relative">

  @include('user.includes.top_greetings')

  <div class="px-4 mt-4">
    <h1 class="text-xl font-bold text-white">My Bookings</h1>
  </div>

  @if(session('success'))
    <div class="mx-4 mt-2 p-2 bg-emerald-600/20 border border-emerald-500 rounded-lg text-emerald-400 text-sm">{{ session('success') }}</div>
  @endif

  <!-- Upcoming -->
  <div class="px-4 mt-4">
    <h2 class="text-sm font-semibold text-gray-200 mb-2">Upcoming</h2>
    @forelse($upcoming as $book)
    <div class="bg-gray-900/60 border border-gray-800 rounded-xl p-3 mb-2">
      <div class="flex justify-between items-start">
        <div>
          <p class="font-semibold text-white">{{ $book->professional }}</p>
          <p class="text-xs text-gray-400">{{ $book->service }}</p>
          <p class="text-xs text-gray-400 mt-1"><i data-lucide="calendar" class="w-3 h-3 inline"></i> {{ $book->date }}</p>
        </div>
        <span class="text-xs px-2 py-1 rounded-full {{ $book->status == 'Confirmed' ? 'bg-green-600/20 text-green-400' : 'bg-yellow-600/20 text-yellow-400' }}">{{ $book->status }}</span>
      </div>
      <div class="mt-2 flex gap-2">
        <a href="{{ route('bookings.show', $book->id) }}" class="text-xs text-emerald-400">View Details</a>
        <a href="#" class="text-xs text-red-400" onclick="alert('Cancel demo'); return false;">Cancel</a>
      </div>
    </div>
    @empty
    <p class="text-gray-400 text-sm">No upcoming bookings.</p>
    @endforelse
  </div>

  <!-- Past -->
  <div class="px-4 mt-4 mb-20">
    <h2 class="text-sm font-semibold text-gray-200 mb-2">Past</h2>
    @forelse($past as $book)
    <div class="bg-gray-900/40 border border-gray-800 rounded-xl p-3 mb-2 opacity-80">
      <p class="font-semibold text-white">{{ $book->professional }}</p>
      <p class="text-xs text-gray-400">{{ $book->service }} • {{ $book->date }}</p>
      <span class="text-xs text-gray-500">{{ $book->status }}</span>
    </div>
    @empty
    <p class="text-gray-400 text-sm">No past bookings.</p>
    @endforelse
  </div>

  @include('user.includes.bottom_navigation')
</div>
<script> document.addEventListener('DOMContentLoaded', () => { if (typeof lucide !== 'undefined') lucide.createIcons(); }); </script>
</body>
</html>