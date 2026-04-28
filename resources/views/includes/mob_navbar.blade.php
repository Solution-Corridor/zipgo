<header class="sticky top-0 z-50 bg-[#0A0A0F]/80 backdrop-blur-lg border-b border-white/10">
  <div class="container mx-auto px-4">
    <div class="flex justify-between items-center h-20">
      <!-- Logo -->
      <a href="/" class="flex items-center gap-2">
        <img class="h-45" src="/assets/images/logo.png" alt="Investment Plan" style="height: 40px;">
      </a>

      <!-- Desktop Nav -->
      <nav class="hidden md:flex items-center gap-6">

        @guest
        <a href="/" class="text-white/80 hover:text-primary transition-colors">Home</a>
        <a href="/login" class="text-white/80 hover:text-primary transition-colors">Login</a>
        <a href="/register" class="bg-primary text-white font-semibold py-2 px-4 rounded-full hover:bg-primary/90 transition-all">Sign Up</a>
        @endguest



      </nav>

      <!-- Mobile Menu Button -->
      <div class="md:hidden">
        <button id="menu-btn" class="text-white focus:outline-none">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu">
            <line x1="4" x2="20" y1="12" y2="12" />
            <line x1="4" x2="20" y1="6" y2="6" />
            <line x1="4" x2="20" y1="18" y2="18" />
          </svg>
        </button>
      </div>
    </div>
  </div>
</header>

<!-- Mobile Menu -->
<div id="mobile-menu" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm hidden md:hidden">
  <div id="mobile-menu-content" class="fixed top-0 right-0 h-full w-72 bg-[#0A0A0F] border-l border-white/10 shadow-2xl p-6 transform translate-x-full transition-transform duration-300 ease-in-out">
    <div class="flex justify-between items-center mb-8">
      <h2 class="text-white text-xl font-bold">Menu</h2>
      <button id="close-menu-btn" class="text-white/50 hover:text-white text-3xl leading-none">&times;</button>
    </div>
    <nav class="flex flex-col space-y-2">

      @guest
      <a href="/" class="flex items-center gap-4 text-white/80 hover:text-primary transition-colors p-3 rounded-lg hover:bg-white/5">Home</a>
      <a href="/plan" class="flex items-center gap-4 text-white/80 hover:text-primary transition-colors p-3 rounded-lg hover:bg-white/5">Plans</a>
      <a href="/login" class="flex items-center gap-4 text-white/80 hover:text-primary transition-colors p-3 rounded-lg hover:bg-white/5">Login</a>
      <div class="pt-4">
        <a href="/register" class="block text-center bg-primary text-white font-semibold py-3 px-4 rounded-full hover:bg-primary/90 transition-all w-full">Sign Up</a>
      </div>
      @endguest

      @auth

      {{-- If Admin --}}
      @if(auth()->user()->type == 0)

      <a href="{{ route('admin.dashboard') }}"
        class="flex items-center gap-4 text-white/80 hover:text-primary transition-colors p-3 rounded-lg hover:bg-white/5">
        Admin Dashboard
      </a>

      <a href="{{ route('user_dashboard') }}"
        class="flex items-center gap-4 text-white/80 hover:text-primary transition-colors p-3 rounded-lg hover:bg-white/5">
        User Dashboard
      </a>

      <a href="{{ route('expert_dashboard') }}"
        class="flex items-center gap-4 text-white/80 hover:text-primary transition-colors p-3 rounded-lg hover:bg-white/5">
        Expert Dashboard
      </a>



      {{-- If Normal User --}}
      @elseif(auth()->user()->type == 2)
      <a href="{{ route('expert_dashboard') }}"
        class="flex items-center gap-4 text-white/80 hover:text-primary transition-colors p-3 rounded-lg hover:bg-white/5">
        Dashboard
      </a>
      @else

      <a href="{{ route('user_dashboard') }}"
        class="flex items-center gap-4 text-white/80 hover:text-primary transition-colors p-3 rounded-lg hover:bg-white/5">
        Dashboard
      </a>

      @endif




      <a href="{{ route('user_profile') }}" class="flex items-center gap-4 text-white/80 hover:text-primary transition-colors p-3 rounded-lg hover:bg-white/5">Settings</a>
      <div class="pt-4">
        <a href="{{ route('logout') }}" style="color: #f70212;"
          class="w-full text-left flex items-center gap-4 text-[#ef4444] hover:text-[#f87171] transition-colors p-3 rounded-lg hover:bg-white/5">
          Logout
        </a>
      </div>
      @endauth

    </nav>
  </div>
</div>