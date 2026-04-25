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

<!-- Sticky Top Greeting Header - Full Top Touch -->
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
    <a href="{{ route('user_profile') }}" class="inline-block">
      <div class="relative shrink-0">
        <div class="w-14 h-14 rounded-full overflow-hidden ring-1 ring-indigo-400/30 shadow-md">
          @if (auth()->user()->pic)
          <img src="/{{ auth()->user()->pic }}" class="w-full h-full object-cover" alt="">
          @else
          <div class="w-full h-full bg-gradient-to-br from-slate-700 via-indigo-800 to-slate-800 flex items-center justify-center text-2xl font-bold text-indigo-200">
            {{ strtoupper(substr($username, 0, 1)) }}
          </div>
          @endif
        </div>
        <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-emerald-500 rounded-full border-2 border-slate-950 z-10"></div>
      </div>
    </a>

    <div class="flex-1 min-w-0">
      <a href="{{ route('user_profile') }}" class="inline-block">
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
        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium rounded-full shadow-md transition-all duration-200">
        Log in / Sign up
      </button>
    </div>
    @endauth

    <!-- Notification Bell with Dropdown -->
    <div x-data="{ open: false }" class="relative inline-flex items-center">
      <button
        @click="open = !open"
        type="button"
        class="relative w-10 h-10 rounded-full bg-gradient-to-br from-slate-800 to-indigo-900/80 flex items-center justify-center shadow-md shadow-black/30 active:scale-95 transition-all duration-200 ring-1 ring-slate-700/50 hover:ring-indigo-500/40">
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
              <a href="/notifications" class="block text-center text-sm font-medium text-indigo-400 hover:text-indigo-300 transition">View all notifications →</a>
            </div>
          </div>
        </div>
      </template>
    </div>

    <!-- Plan / + Button -->
    <a href="/plan" class="relative w-10 h-10 rounded-full bg-gradient-to-br from-slate-800 to-indigo-900/80 flex items-center justify-center text-xl font-bold shadow-md shadow-black/30 active:scale-95 transition-all duration-200 ring-1 ring-slate-700/50 hover:ring-indigo-500/40">
      <span class="relative z-10 text-slate-200">+</span>
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

{{-- ========== LOGIN POPUP MODAL (guests, closable) ========== --}}
<div
  x-data="loginModal()"
  x-init="init()"
  @open-login-modal.window="open = true"
  x-show="open"
  x-cloak
  class="fixed inset-0 z-[10000] flex items-center justify-center px-4"
  style="display: none;">
  <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" @click="open = false"></div>
  <div class="relative w-full max-w-md bg-gradient-to-b from-slate-900 to-slate-950 rounded-2xl shadow-2xl border border-slate-700/50 overflow-hidden" @click.stop>
    <div class="flex items-center justify-between px-6 py-4 border-b border-slate-800">
      <h3 class="text-xl font-semibold text-slate-100">Welcome Back</h3>
      <button @click="open = false" class="text-slate-400 hover:text-slate-200 transition">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
    </div>
    <div class="p-6">
      <form @submit.prevent="submitLogin">
        <div class="mb-4">
          <label class="block text-sm font-medium text-slate-300 mb-1">Email or Username</label>
          <input type="text" x-model="credentials.email" required class="w-full px-4 py-2 bg-slate-800 border border-slate-700 rounded-lg text-slate-200 focus:ring-2 focus:ring-indigo-500">
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium text-slate-300 mb-1">Password</label>
          <input type="password" x-model="credentials.password" required class="w-full px-4 py-2 bg-slate-800 border border-slate-700 rounded-lg text-slate-200 focus:ring-2 focus:ring-indigo-500">
        </div>
        <div class="flex items-center justify-between mb-6">
          <label class="flex items-center">
            <input type="checkbox" x-model="credentials.remember" class="rounded bg-slate-800 border-slate-700 text-indigo-600">
            <span class="ml-2 text-sm text-slate-300">Remember me</span>
          </label>
          <a href="{{ route('password.request') }}" class="text-sm text-indigo-400 hover:text-indigo-300">Forgot password?</a>
        </div>
        <div x-show="errorMessage" x-text="errorMessage" class="mb-4 text-sm text-red-400 bg-red-900/30 p-2 rounded"></div>
        <button type="submit" :disabled="loading" class="w-full py-2 bg-indigo-600 hover:bg-indigo-500 text-white font-medium rounded-lg transition disabled:opacity-50">
          <span x-show="!loading">Log in</span>
          <span x-show="loading">Logging in...</span>
        </button>
      </form>
      <div class="mt-4 text-center text-sm text-slate-400">
        Don't have an account? <a href="{{ route('register') }}" class="text-indigo-400 hover:text-indigo-300">Sign up</a>
      </div>
    </div>
  </div>
</div>

<script>
  function loginModal() {
    return {
      open: false,
      loading: false,
      errorMessage: '',
      credentials: {
        email: '',
        password: '',
        remember: false
      },
      init() {
        @if($errors -> any())
        this.open = true;
        this.errorMessage = '{{ $errors->first() }}';
        @endif
      },
      async submitLogin() {
        this.loading = true;
        this.errorMessage = '';
        try {
          const response = await fetch('{{ route("login") }}', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              'Accept': 'application/json'
            },
            body: JSON.stringify(this.credentials)
          });
          const data = await response.json();
          if (response.ok) window.location.reload();
          else this.errorMessage = data.message || 'Invalid credentials.';
        } catch (error) {
          this.errorMessage = 'Network error.';
        } finally {
          this.loading = false;
        }
      }
    }
  }
</script>

@if(auth()->user() && auth()->user()->type == 2 && !DB::table('expert_details')->where('user_id', auth()->id())->exists())
@php
    // Get services with id, name, price
    $services = DB::table('services')
        ->whereNotNull('name')
        ->where('name', '!=', '')
        ->where('is_active', 1)
        ->select('id', 'name', 'price')
        ->get()
        ->map(fn($item) => [
            'id'    => $item->id,
            'name'  => trim($item->name),
            'price' => (float) $item->price
        ])
        ->filter(fn($item) => !empty($item['name']))
        ->unique(fn($item) => strtolower($item['name']))
        ->values()
        ->toArray();
@endphp

<div x-data="{ open: true }" x-init="open = true" x-show="open" x-cloak
     class="fixed inset-0 z-[10001] flex items-center justify-center px-4" style="display: none;">
    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>
    <div class="relative w-full max-w-[calc(100%-2rem)] sm:max-w-md bg-gradient-to-b from-slate-900 to-slate-950 rounded-2xl shadow-2xl border border-slate-700/50 overflow-hidden max-h-[90vh] overflow-y-auto" @click.stop>
        <div class="sticky top-0 px-6 py-4 border-b border-slate-800 bg-slate-900/90 backdrop-blur-sm z-10">
            <h3 class="text-xl font-semibold text-slate-100 text-center">Expert Dashboard</h3>
        </div>

        <form action="{{ route('expert.store.pending') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf
            <input type="hidden" name="user_id" value="{{ auth()->id() }}">

            <!-- SDDL Services with price display -->
            <div class="bg-slate-800/50 rounded-xl p-4" x-data="{
                open: false,
                search: '',
                selectedId: null,
                selectedName: '',
                selectedPrice: 0,
                allServices: {{ json_encode($services) }},
                get filteredServices() {
                    if (!this.search.trim()) return this.allServices;
                    const term = this.search.toLowerCase();
                    return this.allServices.filter(s => s.name.toLowerCase().includes(term));
                },
                selectService(service) {
                    this.selectedId = service.id;
                    this.selectedName = service.name;
                    this.selectedPrice = service.price;
                    this.search = service.name;
                    this.open = false;
                },
                clearSelection() {
                    this.selectedId = null;
                    this.selectedName = '';
                    this.selectedPrice = 0;
                    this.search = '';
                    this.open = true;
                }
            }">
                <h4 class="text-md font-semibold text-indigo-300 mb-3">SDDL (Services)</h4>
                <div class="relative">
                    <input type="text"
                           x-model="search"
                           @focus="open = true"
                           @click.away="open = false"
                           @keydown.escape="open = false"
                           placeholder="Select a service..."
                           class="w-full px-4 py-2 pr-8 bg-slate-800 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    >
                    <button @click="clearSelection" x-show="selectedId" type="button" class="absolute right-2 top-1/2 -translate-y-1/2 text-slate-400 hover:text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                    <div x-show="open && filteredServices.length > 0" x-cloak x-transition
                         class="absolute z-20 left-0 right-0 mt-1 bg-slate-800 border border-slate-700 rounded-lg shadow-xl max-h-60 overflow-y-auto">
                        <template x-for="service in filteredServices" :key="service.id">
                            <div @click="selectService(service)"
                                 class="px-4 py-2 text-slate-200 hover:bg-indigo-600/50 cursor-pointer transition"
                                 x-text="service.name"></div>
                        </template>
                    </div>
                    <div x-show="open && filteredServices.length === 0 && search !== ''" x-cloak
                         class="absolute z-20 left-0 right-0 mt-1 bg-slate-800 border border-slate-700 rounded-lg shadow-xl p-3 text-center text-slate-400 text-sm">
                        No matching service
                    </div>
                </div>
                <!-- Display price -->
                <div class="mt-3 text-right" x-show="selectedId" x-cloak>
                    <span class="text-sm text-slate-400">Service price:</span>
                    <span class="text-xl font-bold text-indigo-300" x-text="'$' + selectedPrice.toFixed(2)"></span>
                </div>
                <input type="hidden" name="service_id" :value="selectedId">
            </div>

            <!-- NIC Details (unchanged) -->
            <div class="bg-slate-800/50 rounded-xl p-4">
                <h4 class="text-md font-semibold text-indigo-300 mb-3">NIC Details</h4>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm text-slate-400">NIC Number</label>
                        <input type="text" name="nic_number" class="w-full px-4 py-2 bg-slate-800 border border-slate-700 rounded-lg text-slate-200" placeholder="NIC number">
                    </div>
                    <div>
                        <label class="block text-sm text-slate-400">Expiry Date</label>
                        <input type="date" name="nic_expiry" class="w-full px-4 py-2 bg-slate-800 border border-slate-700 rounded-lg text-slate-200">
                    </div>
                    <div>
                        <label class="block text-sm text-slate-400">NIC Front Image</label>
                        <input type="file" name="nic_front" class="w-full text-slate-400">
                    </div>
                    <div>
                        <label class="block text-sm text-slate-400">NIC Back Image</label>
                        <input type="file" name="nic_back" class="w-full text-slate-400">
                    </div>
                    <div>
                        <label class="block text-sm text-slate-400">Selfie with NIC</label>
                        <input type="file" name="selfie" class="w-full text-slate-400">
                    </div>
                </div>
            </div>

            <!-- Payment button (no dropdown) -->
            <div class="flex justify-end mt-4">
                <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg transition w-full">
                    Proceed to Payment
                </button>
            </div>
        </form>
    </div>
</div>
@endif