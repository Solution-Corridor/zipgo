<!DOCTYPE html>
<html lang="en">
<head>
  @include('user.includes.general_style')
  <title>Booking #{{ $booking->id }}</title>
</head>
<body class="min-h-screen bg-[#FDFBF7]">

<div class="mx-auto max-w-[420px] min-h-screen bg-[#FDFBF7] relative">

  @include('user.includes.top_greetings')

  <div class="px-4 mt-4">
    <a href="{{ route('user.bookings') }}" class="text-[#FF6B6B] text-sm flex items-center gap-1 hover:text-[#ff5252]">
      <i data-lucide="arrow-left" class="w-4 h-4"></i> Back
    </a>
    <h1 class="text-xl font-bold text-[#2C1810] mt-2">Booking Details</h1>
  </div>

  <div class="mx-4 mt-4 bg-white border border-[#EAE0D5] rounded-xl p-4 space-y-3 shadow-sm">
    <div><p class="text-xs text-[#6B5B50]">Service</p><p class="text-[#2C1810] font-medium">{{ $booking->service }}</p></div>
    <div><p class="text-xs text-[#6B5B50]">Professional</p><p class="text-[#2C1810] font-medium">{{ $booking->professional }}</p></div>
    <div><p class="text-xs text-[#6B5B50]">Date & Time</p><p class="text-[#2C1810] font-medium">{{ $booking->date }}</p></div>
    <div><p class="text-xs text-[#6B5B50]">Address</p><p class="text-[#2C1810] font-medium">{{ $booking->address }}</p></div>
    <div><p class="text-xs text-[#6B5B50]">Price</p><p class="text-[#FF6B6B] font-bold text-lg">Rs. {{ $booking->price }}</p></div>
    <div><p class="text-xs text-[#6B5B50]">Status</p><span class="inline-block px-2 py-1 rounded-full text-xs bg-green-100 text-green-700">{{ $booking->status }}</span></div>
    <div><p class="text-xs text-[#6B5B50]">Description</p><p class="text-sm text-[#2C1810]">{{ $booking->description }}</p></div>
  </div>

  <div class="mx-4 mt-4 mb-20 flex gap-3">
    <a href="#" class="flex-1 text-center bg-[#FF6B6B] hover:bg-[#ff5252] py-2 rounded-lg text-white text-sm transition" onclick="alert('Contact professional demo'); return false;">Contact</a>
    <a href="#" class="flex-1 text-center bg-red-100 hover:bg-red-200 py-2 rounded-lg text-red-600 text-sm transition" onclick="alert('Cancel booking demo'); return false;">Cancel Booking</a>
  </div>

  @include('user.includes.bottom_navigation')
</div>
<script> document.addEventListener('DOMContentLoaded', () => { if (typeof lucide !== 'undefined') lucide.createIcons(); }); </script>
</body>
</html>