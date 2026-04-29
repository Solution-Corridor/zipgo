<nav class="fixed bottom-0 left-0 right-0 z-50 pointer-events-none" style="max-width: 420px; margin-left: auto; margin-right: auto;">
    <div class="bg-[#0A0A0F]/95 backdrop-blur-xl rounded-t-3xl py-2 px-2 flex justify-between items-center border-t border-white/10 shadow-2xl shadow-black/50 pointer-events-auto">

        @php
            $currentRoute = request()->route()->getName();
        @endphp

        <!-- Home (flat) -->
        <a href="{{ route('user.dashboard') }}"
           class="nav-item flex flex-col items-center justify-center flex-1 py-2 rounded-xl transition-all duration-300 group @if($currentRoute == 'user.dashboard') active @endif">
            <i data-lucide="home" class="w-5 h-5 transition-all duration-300 group-hover:scale-110"></i>
            <span class="text-[10px] mt-1 font-medium transition-all duration-300 group-hover:text-emerald-400">Home</span>
        </a>

        <!-- Explore (flat) -->
        <a href="{{ route('user.explore') }}"
           class="nav-item flex flex-col items-center justify-center flex-1 py-2 rounded-xl transition-all duration-300 group @if($currentRoute == 'user.explore') active @endif">
            <i data-lucide="compass" class="w-5 h-5 transition-all duration-300 group-hover:scale-110"></i>
            <span class="text-[10px] mt-1 font-medium transition-all duration-300 group-hover:text-emerald-400">Explore</span>
        </a>

        <!-- FIND – Prominent Center Button (separate styling) -->
        <a href="{{ route('user.search') }}"
           class="find-btn flex flex-col items-center justify-center -mt-6 flex-1 relative @if($currentRoute == 'user.search') active-find @endif">
            <div class="w-14 h-14 rounded-2xl 
                        bg-gradient-to-br from-emerald-500 to-teal-600 
                        flex items-center justify-center 
                        shadow-xl shadow-emerald-500/40 
                        hover:shadow-emerald-400/60 
                        border-4 border-[#0A0A0F] 
                        transition-all duration-300 
                        group-hover:scale-105 group-active:scale-95
                        @if($currentRoute == 'user.search') ring-2 ring-amber-400/50 ring-offset-2 ring-offset-[#0A0A0F] scale-105 @endif">
                <i data-lucide="search" class="w-7 h-7 text-white"></i>
            </div>
            <span class="text-[10px] mt-1 font-semibold transition-all duration-300 
                         @if($currentRoute == 'user.search') text-amber-400 
                         @else text-emerald-400 group-hover:text-emerald-300 @endif">Find</span>
        </a>

        <!-- Bookings (flat) -->
        <a href="{{ route('user.bookings') }}"
           class="nav-item flex flex-col items-center justify-center flex-1 py-2 rounded-xl transition-all duration-300 group @if($currentRoute == 'user.bookings') active @endif">
            <i data-lucide="calendar-check" class="w-5 h-5 transition-all duration-300 group-hover:scale-110"></i>
            <span class="text-[10px] mt-1 font-medium transition-all duration-300 group-hover:text-emerald-400">Bookings</span>
        </a>

        <!-- Profile (flat) -->
        <a href="{{ route('user.profile') }}"
           class="nav-item flex flex-col items-center justify-center flex-1 py-2 rounded-xl transition-all duration-300 group @if($currentRoute == 'user.profile') active @endif">
            <i data-lucide="user" class="w-5 h-5 transition-all duration-300 group-hover:scale-110"></i>
            <span class="text-[10px] mt-1 font-medium transition-all duration-300 group-hover:text-emerald-400">Profile</span>
        </a>

    </div>
</nav>

<style>
    /* ===== FLAT NAVIGATION ITEMS (Home, Explore, Bookings, Profile) ===== */
    .nav-item {
        position: relative;
        color: #9ca3af; /* gray-400 */
        transition: all 0.2s ease;
    }

    .nav-item i {
        transition: all 0.2s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    }

    /* Active flat item */
    .nav-item.active i {
        color: #10b981;
        stroke: #10b981;
        filter: drop-shadow(0 0 6px rgba(16, 185, 129, 0.5));
        transform: scale(1.1);
    }

    .nav-item.active span {
        color: #10b981;
        font-weight: 600;
    }

    /* Active indicator line for flat items */
    .nav-item.active::after {
        content: '';
        position: absolute;
        bottom: -6px;
        left: 50%;
        transform: translateX(-50%);
        width: 24px;
        height: 3px;
        background: linear-gradient(90deg, #10b981, #34d399);
        border-radius: 4px;
        box-shadow: 0 0 8px #10b98180;
        animation: slideUp 0.2s ease-out;
    }

    /* Hover effect for flat items */
    .nav-item:not(.active):hover i {
        color: #34d399;
        transform: translateY(-2px) scale(1.1);
    }

    .nav-item:not(.active):hover span {
        color: #e5e7eb;
    }

    /* ===== PROMINENT FIND BUTTON ===== */
    .find-btn {
        transition: all 0.2s ease;
    }

    /* Pulsing shadow animation for the Find button */
    .find-btn .w-14 {
        transition: all 0.2s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        animation: softGlow 2s infinite;
    }

    .find-btn:hover .w-14 {
        transform: scale(1.05);
        box-shadow: 0 0 20px rgba(16, 185, 129, 0.6);
    }

    .find-btn:active .w-14 {
        transform: scale(0.96);
    }

    /* Active state for Find button */
    .find-btn.active-find .w-14 {
        background: linear-gradient(135deg, #059669, #0d9488);
        box-shadow: 0 0 25px rgba(245, 158, 11, 0.5);
        ring: 2px solid #fbbf24;
    }

    .find-btn.active-find span {
        color: #fbbf24;
        text-shadow: 0 0 4px #f59e0b;
    }

    /* Keyframes for soft glow (always active) */
    @keyframes softGlow {
        0% {
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4);
        }
        70% {
            box-shadow: 0 0 0 8px rgba(16, 185, 129, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
        }
    }

    /* Same slide-up animation for flat active line */
    @keyframes slideUp {
        0% {
            width: 0;
            opacity: 0;
        }
        100% {
            width: 24px;
            opacity: 1;
        }
    }

    /* Glass morphism enhancement */
    nav .bg-\[#0A0A0F\]\/95 {
        background: rgba(10, 10, 15, 0.96);
        backdrop-filter: blur(20px);
    }

    /* Safe area for notches */
    @supports (padding-bottom: env(safe-area-inset-bottom)) {
        nav .bg-\[#0A0A0F\]\/95 {
            padding-bottom: env(safe-area-inset-bottom);
        }
    }

    /* Tap effect for all clickable items */
    .nav-item:active, .find-btn:active {
        transform: scale(0.98);
        transition: transform 0.05s;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') lucide.createIcons();
    });
</script>