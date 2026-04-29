<!DOCTYPE html>
<html lang="en">
<head>
  @include('user.includes.general_style')
  <title>Booking #{{ $booking->id }}</title>
</head>
<body class="min-h-screen bg-[#0A0A0F]">

<div class="mx-auto max-w-[420px] min-h-screen bg-[#0A0A0F] relative">

  @include('user.includes.top_greetings')

  <div class="px-4 mt-4">
    <a href="{{ route('user.bookings') }}" class="text-emerald-400 text-sm flex items-center gap-1">
      <i data-lucide="arrow-left" class="w-4 h-4"></i> Back
    </a>
    <h1 class="text-xl font-bold text-white mt-2">Booking Details</h1>
  </div>

  <div class="mx-4 mt-4 bg-gray-900/60 border border-gray-800 rounded-xl p-4 space-y-3">
    <div><p class="text-xs text-gray-400">Service</p><p class="text-white font-medium">{{ $booking->service }}</p></div>
    <div><p class="text-xs text-gray-400">Professional</p><p class="text-white font-medium">{{ $booking->professional }}</p></div>
    <div><p class="text-xs text-gray-400">Date & Time</p><p class="text-white font-medium">{{ $booking->date }}</p></div>
    <div><p class="text-xs text-gray-400">Address</p><p class="text-white font-medium">{{ $booking->address }}</p></div>
    <div><p class="text-xs text-gray-400">Price</p><p class="text-emerald-400 font-bold text-lg">Rs. {{ $booking->price }}</p></div>
    <div><p class="text-xs text-gray-400">Status</p><span class="inline-block px-2 py-1 rounded-full text-xs bg-green-600/20 text-green-400">{{ $booking->status }}</span></div>
    <div><p class="text-xs text-gray-400">Description</p><p class="text-sm text-gray-300">{{ $booking->description }}</p></div>
  </div>

  <div class="mx-4 mt-4 mb-20 flex gap-3">
    <a href="#" class="flex-1 text-center bg-emerald-600 hover:bg-emerald-700 py-2 rounded-lg text-white text-sm" onclick="alert('Contact professional demo'); return false;">Contact</a>
    <a href="#" class="flex-1 text-center bg-red-600/20 hover:bg-red-600/30 py-2 rounded-lg text-red-400 text-sm" onclick="alert('Cancel booking demo'); return false;">Cancel Booking</a>
  </div>

  @include('user.includes.bottom_navigation')
</div>
<script> document.addEventListener('DOMContentLoaded', () => { if (typeof lucide !== 'undefined') lucide.createIcons(); }); </script>
</body>
</html>