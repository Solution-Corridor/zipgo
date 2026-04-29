<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-DCZ5K9SKZ9"></script>
<script>
  window.dataLayer = window.dataLayer || [];

  function gtag() {
    dataLayer.push(arguments);
  }
  gtag('js', new Date());
  gtag('config', 'G-DCZ5K9SKZ9');
</script>

@php
$username = auth()->user()?->username ?? 'Guest';
@endphp

<!-- Sticky Top Greeting Header - Full Top Touch (Customer Version) -->
<div class="sticky top-0 z-50 bg-slate-950">
  <div class="flex items-center gap-4 
                bg-gradient-to-r from-slate-950 via-slate-900 to-slate-950
                backdrop-blur-md 
                rounded-2xl
                px-5 py-4 
                shadow-xl shadow-black/50 
                w-full max-w-md mx-auto">

    @auth
    <!-- Authenticated: Avatar & Username -->
    <a href="{{ route('user.profile') }}" class="inline-block">
      <div class="relative shrink-0">
        <div class="w-14 h-14 rounded-full overflow-hidden ring-1 ring-emerald-400/30 shadow-md">
          @if (auth()->user()->pic)
          <img src="/{{ auth()->user()->pic }}" class="w-full h-full object-cover" alt="">
          @else
          <div class="w-full h-full bg-gradient-to-br from-slate-700 via-emerald-800 to-slate-800 flex items-center justify-center text-2xl font-bold text-emerald-200">
            {{ strtoupper(substr($username, 0, 1)) }}
          </div>
          @endif
        </div>
        <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-emerald-500 rounded-full border-2 border-slate-950 z-10"></div>
      </div>
    </a>

    <div class="flex-1 min-w-0">
      <a href="{{ route('user.profile') }}" class="inline-block">
        <h2 class="text-base font-semibold tracking-tight text-slate-100">
          {{ $username }}
        </h2>
      </a>
    </div>
    @else
    <!-- Guest: Show Login Button that triggers popup -->
    <div class="flex-1 min-w-0">
      <button
        x-data="{}"
        @click="$dispatch('open-login-modal')"
        class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-medium rounded-full shadow-md transition-all duration-200">
        Log in / Sign up
      </button>
    </div>
    @endauth

    <!-- Notification Bell with Dropdown (emerald style) -->
    <div x-data="{ open: false }" class="relative inline-flex items-center">
      <button
        @click="open = !open"
        type="button"
        class="relative w-10 h-10 rounded-full bg-gradient-to-br from-slate-800 to-emerald-900/80 flex items-center justify-center shadow-md shadow-black/30 active:scale-95 transition-all duration-200 ring-1 ring-slate-700/50 hover:ring-emerald-500/40">
        <i class="fas fa-bell text-slate-200 text-lg"></i>

        @auth
        @php $unreadCount = auth()->user()->unreadNotifications()->count(); @endphp
        @if($unreadCount > 0)
        <span class="absolute -top-1 -right-1 flex h-5 min-w-[1.25rem] items-center justify-center rounded-full bg-rose-600 text-[0.625rem] font-bold text-white ring-2 ring-slate-950 shadow-sm z-50">
          {{ $unreadCount > 9 ? '9+' : $unreadCount }}
        </span>
        @endif
        @endauth
      </button>

      <template x-teleport="body">
        <div
          x-show="open"
          x-cloak
          @keydown.escape.window="open = false"
          x-transition
          class="fixed inset-0 z-[9998]">
          <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="open = false"></div>
          <div
            x-ref="dropdown"
            class="absolute right-4 top-20 w-[320px] max-w-[92vw] bg-gradient-to-b from-slate-900 to-slate-950 border border-slate-800/70 rounded-2xl shadow-2xl shadow-black/70 overflow-hidden flex flex-col max-h-[70vh] z-[9999]">
            <div class="flex items-center justify-between px-5 py-3.5 border-b border-slate-800/70 bg-slate-950/60 backdrop-blur-sm">
              <h3 class="text-sm font-semibold text-slate-100 tracking-wide">Notifications</h3>
              <button @click="open = false" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-800/70 transition text-slate-400 hover:text-slate-200">✕</button>
            </div>
            <div class="overflow-y-auto divide-y divide-slate-800/60">
              @auth
              @forelse(auth()->user()->unreadNotifications as $notification)
              <a href="{{ route('notification.read', $notification->id) }}" class="block px-5 py-3.5 hover:bg-slate-800/40 transition group">
                <p class="text-sm text-slate-200 leading-snug group-hover:text-white">{{ $notification->data['message'] ?? 'New notification' }}</p>
                <p class="text-[11px] text-slate-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
              </a>
              @empty
              <div class="px-5 py-10 text-center text-slate-500 text-sm">🔔 No new notifications</div>
              @endforelse
              @endauth
            </div>
            <div class="px-5 py-3.5 border-t border-slate-800/70 bg-slate-950/60">
              <a href="/notifications" class="block text-center text-sm font-medium text-emerald-400 hover:text-emerald-300 transition">View all notifications →</a>
            </div>
          </div>
        </div>
      </template>
    </div>

    <!-- Support / Help Button (replaces old Plan/+) -->
    <a href="tel:+919876543210" class="relative w-10 h-10 rounded-full bg-gradient-to-br from-slate-800 to-emerald-900/80 flex items-center justify-center shadow-md shadow-black/30 active:scale-95 transition-all duration-200 ring-1 ring-slate-700/50 hover:ring-emerald-500/40">
      <i class="fas fa-headset text-slate-200 text-lg"></i>
    </a>
  </div>
</div>

<div class="px-4 mt-2 mb-2">
  <!-- Important notification by admin -->
  @php
  $importantNote = \App\Models\ImportantNote::first();
  @endphp

  @if($importantNote?->message)
  <div class="flex items-center gap-3 px-4 py-3 bg-amber-900/30 border border-amber-700/40 rounded-lg text-amber-200 text-sm mb-3">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <p>{!! nl2br(e($importantNote->message)) !!}</p>
  </div>
  @endif
</div>