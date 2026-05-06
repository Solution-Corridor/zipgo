<!DOCTYPE html>
<html lang="en">

<head>
  @include('user.includes.general_style')
  <title>My Bookings – Home Services</title>
</head>

<body class="min-h-screen bg-[#e6e5e3]">

  <div class="mx-auto max-w-[420px] min-h-screen bg-[#e6e5e3] relative">

    @include('user.includes.top_greetings')

    <div class="px-4 mt-4">
      <h1 class="text-xl font-bold text-[#2C1810]">My Bookings</h1>
    </div>

    @if(session('success'))
    <div class="mx-4 mt-2 p-2 bg-[#FFE66D]/20 border border-[#FFE66D]/50 rounded-lg text-[#2C1810] text-sm">{{ session('success') }}</div>
    @endif

    <!-- Upcoming Bookings -->
    <div class="px-4 mt-4">
      <h2 class="text-sm font-semibold text-[#2C1810] mb-2">Upcoming / Active</h2>
      @forelse($upcoming as $book)
      <div class="bg-white border border-[#EAE0D5] rounded-xl p-3 mb-2 shadow-sm">
        <div class="flex justify-between items-start">
          <div>
            <p class="font-semibold text-[#2C1810]">{{ $book->subService->name ?? $book->service->name }}</p>
            <p class="text-xs text-[#6B5B50]">{{ $book->service->name }}</p>
            <p class="text-xs text-[#6B5B50] mt-1">
              <i data-lucide="calendar" class="w-3 h-3 inline"></i> {{ $book->created_at->format('M d, Y') }}
            </p>
            <p class="text-xs text-[#6B5B50]">Total: Rs. {{ number_format($book->total_price, 0) }}</p>
          </div>
          <span class="text-xs px-2 py-1 rounded-full 
            {{ $book->status == 'confirmed' ? 'bg-green-100 text-green-700' : ($book->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-700') }}">
            {{ ucfirst($book->status) }}
          </span>
        </div>
        <div class="mt-2 flex gap-2">
          <a href="{{ route('bookings.show', $book->id) }}" class="text-xs text-[#FF6B6B] hover:text-[#ff5252]">View Details</a>
          @if($book->status == 'pending')
          <a href="#" class="text-xs text-red-500 hover:text-red-600" onclick="event.preventDefault(); cancelBooking({{ $book->id }});">Cancel</a>
          @endif
        </div>
      </div>
      @empty
      <p class="text-[#6B5B50] text-sm">No upcoming bookings.</p>
      @endforelse
    </div>

    <!-- Past Bookings -->
    <div class="px-4 mt-4 mb-20">
      <h2 class="text-sm font-semibold text-[#2C1810] mb-2">Past / Completed</h2>
      @forelse($past as $book)
      <div class="bg-[#F5F0EA] border border-[#EAE0D5] rounded-xl p-3 mb-2 opacity-80">
        <p class="font-semibold text-[#2C1810]">{{ $book->subService->name ?? $book->service->name }}</p>
        <p class="text-xs text-[#6B5B50]">{{ $book->service->name }} • {{ $book->created_at->format('M d, Y') }}</p>
        <span class="text-xs text-[#6B5B50]">{{ ucfirst($book->status) }}</span>
      </div>
      @empty
      <p class="text-[#6B5B50] text-sm">No past bookings.</p>
      @endforelse
    </div>

    @include('user.includes.bottom_navigation')
  </div>

  <script>
    function cancelBooking(bookingId) {
      if (confirm('Are you sure you want to cancel this booking?')) {
        fetch(`/bookings/${bookingId}/cancel`, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
          }
        }).then(res => res.json()).then(data => {
          if (data.success) location.reload();
          else alert('Cancellation failed');
        });
      }
    }

    document.addEventListener('DOMContentLoaded', () => {
      if (typeof lucide !== 'undefined') lucide.createIcons();
    });
  </script>
</body>

</html>